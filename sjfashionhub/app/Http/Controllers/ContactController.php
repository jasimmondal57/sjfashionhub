<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Models\RecaptchaSetting;
use App\Mail\ContactSubmissionNotification;
use App\Mail\ContactConfirmationMail;
use App\Services\MailConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;

class ContactController extends Controller
{
    /**
     * Store a new contact form submission
     */
    public function store(Request $request)
    {
        $ip = $request->ip();

        // Log the request for debugging
        Log::info('Contact form submission', [
            'email' => $request->email,
            'subject' => $request->subject,
            'ip' => $ip,
        ]);

        // Check if IP is blocked
        if ($this->isIpBlocked($ip)) {
            Log::warning('Contact form submission from blocked IP', ['ip' => $ip]);
            return back()->with('error', 'Your IP address has been blocked due to spam. Please contact support.');
        }

        // Verify reCAPTCHA if enabled
        if (RecaptchaSetting::isEnabled()) {
            if (!$this->verifyRecaptcha($request)) {
                Log::warning('reCAPTCHA verification failed', ['email' => $request->email, 'ip' => $ip]);
                return back()->with('error', 'reCAPTCHA verification failed. Please try again.');
            }
        }

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            Log::warning('Contact form validation failed', $validator->errors()->toArray());

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please check your input and try again.',
                    'errors' => $validator->errors()
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        // Check for spam patterns
        if ($this->isSpam($request)) {
            Log::warning('Spam detected in contact form', [
                'email' => $request->email,
                'subject' => $request->subject,
                'ip' => $request->ip(),
            ]);
            return back()->with('error', 'Your message was flagged as spam. Please try again with different content.');
        }

        try {
            $contact = Contact::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'subject' => $request->subject,
                'message' => $request->message,
                'status' => 'new',
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            Log::info('Contact form submission successful', ['contact_id' => $contact->id]);

            // Send email notifications
            $this->sendNotifications($contact);

            $successMessage = "Thank you for your message! We have received your inquiry and assigned it ticket #" . $contact->id . ". Our team will get back to you within 24 hours. Please save this ticket number for your reference.";

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage,
                    'ticket_id' => $contact->id,
                ]);
            }

            return back()->with('success', $successMessage)->with('ticket_id', $contact->id);

        } catch (\Exception $e) {
            Log::error('Contact form submission error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax() || $request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Something went wrong. Please try again.',
                ], 500);
            }

            return back()->with('error', 'Something went wrong. Please try again.');
        }
    }

    /**
     * Send email notifications for new contact submission
     */
    private function sendNotifications(Contact $contact)
    {
        try {
            // Configure mail settings from database
            MailConfigService::configure();

            // Send confirmation email to user
            Mail::to($contact->email)->send(new ContactConfirmationMail($contact));

            // Send notification email to all admin users (same as order emails)
            $adminEmails = User::where('role', 'admin')->orWhere('role', 'super_admin')->pluck('email')->toArray();

            $sentToAdmins = [];
            foreach ($adminEmails as $adminEmail) {
                try {
                    Mail::to($adminEmail)->send(new ContactSubmissionNotification($contact));
                    $sentToAdmins[] = $adminEmail;
                } catch (\Exception $e) {
                    Log::error('Failed to send contact notification to admin', [
                        'contact_id' => $contact->id,
                        'admin_email' => $adminEmail,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            Log::info('Contact form emails sent successfully', [
                'contact_id' => $contact->id,
                'user_email' => $contact->email,
                'admin_emails' => $sentToAdmins
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to send contact form emails', [
                'contact_id' => $contact->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Don't fail the form submission if email fails
            // Just log the error for admin to investigate
        }
    }

    /**
     * Check if IP address is blocked
     */
    private function isIpBlocked($ip)
    {
        // Check if IP has been marked as spam more than 10 times in last 24 hours
        $spamCount = \DB::table('contacts')
            ->where('ip_address', $ip)
            ->where('status', 'spam')
            ->where('created_at', '>=', now()->subDay())
            ->count();

        return $spamCount >= 10;
    }

    /**
     * Detect spam patterns in contact form
     */
    private function isSpam($request)
    {
        $spamKeywords = [
            // Pharmaceutical
            'viagra', 'cialis', 'weight loss', 'diet pills', 'pharmacy', 'levitra', 'tramadol',
            // Gambling & Lottery
            'casino', 'lottery', 'jackpot', 'prize', 'win money', 'giveaway', 'slots', 'poker',
            'конкурс', 'лотерея', 'выигра', 'приз', 'бесплатно', 'поздравляем', 'выбраны',
            // Crypto & Finance
            'bitcoin', 'crypto', 'forex', 'trading', 'investment', 'ethereum', 'blockchain',
            // Scams
            'click here', 'buy now', 'limited offer', 'act now', 'urgent', 'hurry',
            'xxx', 'adult', 'porn', 'sex', 'cheap', 'free money', 'nigerian prince',
            'work from home', 'make money fast', 'guaranteed', 'earn money', 'passive income',
            // URLs (any URL is suspicious in contact form)
            'http://', 'https://', 'www.', '.com', '.net', '.org', '.ru',
            '.io', '.co', '.info', '.biz', '.xyz', '.top', '.click', '.tk', '.ml',
            // Russian spam patterns
            'участие', 'акции', 'бесплатные', 'переходи', 'ссылке', 'wilberries', 'ozon', 'aliexpress',
            // Additional spam patterns
            'click link', 'verify account', 'confirm identity', 'update payment', 'suspended',
            'congratulations', 'claim reward', 'collect prize', 'inheritance', 'refund',
        ];

        $content = strtolower($request->subject . ' ' . $request->message);
        $email = strtolower($request->email);
        $firstName = strtolower($request->first_name);
        $lastName = strtolower($request->last_name);

        // Check for spam keywords
        foreach ($spamKeywords as $keyword) {
            if (strpos($content, $keyword) !== false) {
                Log::warning('Spam keyword detected', ['keyword' => $keyword, 'email' => $email]);
                return true;
            }
        }

        // Check for ANY URL (very strict - contact forms shouldn't have URLs)
        $urlCount = preg_match_all('/https?:\/\/|www\.|\.com|\.net|\.org|\.ru|\.io|\.tk|\.ml/', $content);
        if ($urlCount >= 1) {
            Log::warning('URL detected in contact form', ['email' => $email]);
            return true;
        }

        // Check for excessive links in message
        $linkCount = preg_match_all('/\[.*?\]\(.*?\)/', $content);
        if ($linkCount >= 1) {
            Log::warning('Markdown links detected', ['email' => $email]);
            return true;
        }

        // Check for suspicious email patterns
        if (preg_match('/\d{10,}/', $email)) {
            Log::warning('Too many numbers in email', ['email' => $email]);
            return true; // Too many numbers in email
        }

        // Check for generic/suspicious names
        $suspiciousNames = ['admin', 'test', 'user', 'guest', 'support', 'info', 'contact', 'hello', 'hi'];
        if (in_array($firstName, $suspiciousNames) || in_array($lastName, $suspiciousNames)) {
            Log::warning('Suspicious name detected', ['first_name' => $firstName, 'last_name' => $lastName]);
            return true;
        }

        // Check for repeated characters (e.g., "aaaaaaa")
        if (preg_match('/(.)\1{4,}/', $content)) {
            Log::warning('Repeated characters detected', ['email' => $email]);
            return true;
        }

        // Check for all caps (likely spam)
        $words = str_word_count($content, 1);
        if (count($words) > 5) {
            $capsWords = array_filter($words, function($word) {
                return strlen($word) > 2 && $word === strtoupper($word);
            });
            if (count($capsWords) / count($words) > 0.5) {
                Log::warning('Excessive caps detected', ['email' => $email]);
                return true; // More than 50% all caps
            }
        }

        // Check for emoji/special characters (common in spam)
        if (preg_match('/[\x{1F300}-\x{1F9FF}]/u', $content)) {
            Log::warning('Emoji detected', ['email' => $email]);
            return true; // Contains emoji
        }

        // Check for excessive punctuation
        $punctCount = preg_match_all('/[!?*•★✓✗]/i', $content);
        if ($punctCount > 5) {
            Log::warning('Excessive punctuation detected', ['email' => $email, 'count' => $punctCount]);
            return true;
        }

        // Check for suspicious patterns like "..." at start
        if (preg_match('/^\.{2,}/', trim($content))) {
            Log::warning('Suspicious dots pattern detected', ['email' => $email]);
            return true;
        }

        // Check for very short messages (likely spam)
        if (strlen(trim($request->message)) < 10) {
            Log::warning('Message too short', ['email' => $email, 'length' => strlen($request->message)]);
            return true;
        }

        // Check for messages that are too long (likely spam/copy-paste)
        if (strlen(trim($request->message)) > 5000) {
            Log::warning('Message too long', ['email' => $email, 'length' => strlen($request->message)]);
            return true;
        }

        // Check for suspicious email domains
        $suspiciousDomains = ['tempmail', 'throwaway', '10minutemail', 'guerrillamail', 'mailinator', 'yopmail'];
        foreach ($suspiciousDomains as $domain) {
            if (strpos($email, $domain) !== false) {
                Log::warning('Suspicious email domain detected', ['email' => $email, 'domain' => $domain]);
                return true;
            }
        }

        // Check for rate limiting - same email multiple times
        $recentSubmissions = \DB::table('contacts')
            ->where('email', $email)
            ->where('created_at', '>=', now()->subHour())
            ->count();

        if ($recentSubmissions >= 3) {
            Log::warning('Rate limit exceeded for email', ['email' => $email, 'count' => $recentSubmissions]);
            return true;
        }

        return false;
    }

    /**
     * Verify reCAPTCHA token
     */
    private function verifyRecaptcha($request)
    {
        $token = $request->input('g-recaptcha-response');

        if (!$token) {
            Log::warning('No reCAPTCHA token provided');
            return false;
        }

        $settings = RecaptchaSetting::getCurrent();

        try {
            $response = Http::post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $settings->secret_key,
                'response' => $token,
            ]);

            $data = $response->json();

            if (!$response->successful() || !$data['success']) {
                Log::warning('reCAPTCHA API error', [
                    'errors' => $data['error-codes'] ?? [],
                ]);
                return false;
            }

            $score = $data['score'] ?? 0;
            $threshold = $settings->threshold;

            Log::info('reCAPTCHA verification', [
                'score' => $score,
                'threshold' => $threshold,
                'passed' => $score >= $threshold,
            ]);

            // If score is below threshold, it's likely spam
            if ($score < $threshold) {
                Log::warning('reCAPTCHA score below threshold', [
                    'score' => $score,
                    'threshold' => $threshold,
                ]);
                return false;
            }

            return true;

        } catch (\Exception $e) {
            Log::error('reCAPTCHA verification error', [
                'error' => $e->getMessage(),
            ]);
            return false;
        }
    }
}
