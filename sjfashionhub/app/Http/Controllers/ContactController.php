<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Mail\ContactSubmissionNotification;
use App\Mail\ContactConfirmationMail;
use App\Services\MailConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

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
            'viagra', 'cialis', 'weight loss', 'diet pills', 'pharmacy',
            // Gambling & Lottery
            'casino', 'lottery', 'jackpot', 'prize', 'win money', 'giveaway',
            'конкурс', 'лотерея', 'выигра', 'приз', 'бесплатно',
            // Crypto & Finance
            'bitcoin', 'crypto', 'forex', 'trading', 'investment',
            // Scams
            'click here', 'buy now', 'limited offer', 'act now', 'urgent',
            'xxx', 'adult', 'porn', 'sex', 'cheap', 'free money',
            'work from home', 'make money fast', 'guaranteed', 'earn money',
            // URLs (any URL is suspicious in contact form)
            'http://', 'https://', 'www.', '.com', '.net', '.org', '.ru',
            '.io', '.co', '.info', '.biz', '.xyz', '.top', '.click',
            // Russian spam patterns
            'поздравляем', 'выбраны', 'участие', 'акции', 'бесплатные',
            'переходи', 'ссылке', 'wilberries', 'ozon', 'aliexpress',
        ];

        $content = strtolower($request->subject . ' ' . $request->message);
        $email = strtolower($request->email);

        // Check for spam keywords
        foreach ($spamKeywords as $keyword) {
            if (strpos($content, $keyword) !== false) {
                return true;
            }
        }

        // Check for ANY URL (very strict - contact forms shouldn't have URLs)
        $urlCount = preg_match_all('/https?:\/\/|www\.|\.com|\.net|\.org|\.ru|\.io/', $content);
        if ($urlCount >= 1) {
            return true;
        }

        // Check for excessive links in message
        $linkCount = preg_match_all('/\[.*?\]\(.*?\)/', $content);
        if ($linkCount >= 1) {
            return true;
        }

        // Check for suspicious email patterns
        if (preg_match('/\d{10,}/', $email)) {
            return true; // Too many numbers in email
        }

        // Check for repeated characters (e.g., "aaaaaaa")
        if (preg_match('/(.)\1{4,}/', $content)) {
            return true;
        }

        // Check for all caps (likely spam)
        $words = str_word_count($content, 1);
        if (count($words) > 5) {
            $capsWords = array_filter($words, function($word) {
                return strlen($word) > 2 && $word === strtoupper($word);
            });
            if (count($capsWords) / count($words) > 0.5) {
                return true; // More than 50% all caps
            }
        }

        // Check for emoji/special characters (common in spam)
        if (preg_match('/[\x{1F300}-\x{1F9FF}]/u', $content)) {
            return true; // Contains emoji
        }

        // Check for excessive punctuation
        $punctCount = preg_match_all('/[!?*•★✓✗]/i', $content);
        if ($punctCount > 5) {
            return true;
        }

        // Check for suspicious patterns like "..." at start
        if (preg_match('/^\.{2,}/', trim($content))) {
            return true;
        }

        return false;
    }
}
