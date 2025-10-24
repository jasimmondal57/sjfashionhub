<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\OtpVerification;
use App\Services\SmsService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MobileLoginController extends Controller
{
    protected $smsService;
    protected $whatsAppService;

    public function __construct(SmsService $smsService, WhatsAppService $whatsAppService)
    {
        $this->smsService = $smsService;
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Show mobile login form
     */
    public function showLoginForm()
    {
        return view('auth.mobile-login');
    }

    /**
     * Send OTP to mobile number
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^[0-9]{10,15}$/',
            'type' => 'required|in:sms,whatsapp'
        ]);

        $phone = $request->phone;
        $type = $request->type;

        // Check rate limiting (max 3 OTPs per hour)
        $recentOtps = OtpVerification::where('phone', $phone)
            ->where('created_at', '>', now()->subHour())
            ->count();

        if ($recentOtps >= 3) {
            throw ValidationException::withMessages([
                'phone' => 'Too many OTP requests. Please try again later.'
            ]);
        }

        // Generate OTP
        $otpRecord = OtpVerification::generateOtp($phone, $type);

        try {
            // Send OTP via SMS or WhatsApp
            if ($type === 'whatsapp') {
                $this->whatsAppService->sendOtp($phone, $otpRecord->otp);
                $message = 'OTP sent to your WhatsApp number.';
            } else {
                $this->smsService->sendOtp($phone, $otpRecord->otp);
                $message = 'OTP sent to your mobile number.';
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'expires_in' => 600 // 10 minutes
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.'
            ], 500);
        }
    }

    /**
     * Verify OTP and login
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^[0-9]{10,15}$/',
            'otp' => 'required|string|size:6'
        ]);

        $phone = $request->phone;
        $otp = $request->otp;

        // Verify OTP
        if (!OtpVerification::verifyOtp($phone, $otp)) {
            throw ValidationException::withMessages([
                'otp' => 'Invalid or expired OTP.'
            ]);
        }

        // Normalize phone number for searching (remove all non-digits)
        $normalizedPhone = preg_replace('/[^0-9]/', '', $phone);

        // Try to find user with different phone number formats
        $user = User::where(function($query) use ($phone, $normalizedPhone) {
            $query->where('phone', $phone)
                  ->orWhere('phone', $normalizedPhone)
                  ->orWhere('phone', '+91' . $normalizedPhone)
                  ->orWhere('phone', '91' . $normalizedPhone);

            // If phone starts with country code, also try without it
            if (strlen($normalizedPhone) > 10) {
                $withoutCountryCode = substr($normalizedPhone, -10);
                $query->orWhere('phone', $withoutCountryCode);
            }
        })->first();

        if (!$user) {
            // Create new user with phone number (store in normalized format)
            $user = User::create([
                'name' => 'User ' . substr($normalizedPhone, -4), // Default name
                'email' => $normalizedPhone . '@mobile.local', // Temporary email
                'phone' => $normalizedPhone, // Store normalized phone (digits only)
                'phone_verified_at' => now(),
                'login_type' => 'phone',
                'password' => Hash::make(Str::random(24)), // Random password
            ]);
        } else {
            // Update phone verification and normalize phone format
            $user->update([
                'phone' => $normalizedPhone, // Update to normalized format
                'phone_verified_at' => now(),
                'login_type' => 'phone'
            ]);
        }

        // Login user
        Auth::login($user);

        // Fire login event for tracking
        Event::dispatch(new Login('mobile', $user, false));

        return response()->json([
            'success' => true,
            'message' => 'Login successful!',
            'redirect' => url('/')
        ]);
    }

    /**
     * Show OTP verification form
     */
    public function showVerifyForm(Request $request)
    {
        $phone = $request->get('phone');
        $type = $request->get('type', 'sms');

        if (!$phone) {
            return redirect()->route('mobile.login');
        }

        return view('auth.mobile-verify', compact('phone', 'type'));
    }
}
