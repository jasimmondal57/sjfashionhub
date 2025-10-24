<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class OtpVerificationController extends Controller
{
    /**
     * Show OTP verification form
     */
    public function show(Request $request)
    {
        $identifier = $request->session()->get('otp_identifier');
        $type = $request->session()->get('otp_type');
        $purpose = $request->session()->get('otp_purpose');
        $method = $request->session()->get('otp_method');

        if (!$identifier || !$type || !$purpose) {
            return redirect()->route('register')->with('error', 'Invalid verification session');
        }

        return view('auth.verify-otp', compact('identifier', 'type', 'purpose', 'method'));
    }

    /**
     * Verify OTP
     */
    public function verify(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|size:6',
        ]);

        $identifier = $request->session()->get('otp_identifier');
        $purpose = $request->session()->get('otp_purpose');

        if (!$identifier || !$purpose) {
            return back()->with('error', 'Invalid verification session');
        }

        $otpRecord = UserOtp::verify($identifier, $request->otp, $purpose);

        if (!$otpRecord) {
            return back()->with('error', 'Invalid or expired OTP. Please try again.');
        }

        // Handle different purposes
        switch ($purpose) {
            case 'registration':
                return $this->handleRegistrationVerification($otpRecord);
            case 'login':
                return $this->handleLoginVerification($otpRecord);
            default:
                return redirect()->route('login')->with('error', 'Unknown verification purpose');
        }
    }

    /**
     * Handle registration verification
     */
    private function handleRegistrationVerification($otpRecord)
    {
        $userData = $otpRecord->metadata;

        // Create user account
        $user = User::create([
            'name' => $userData['name'],
            'email' => $userData['email'],
            'phone' => $userData['phone'],
            'password' => Hash::make($userData['password']),
            'login_type' => 'email',
            'phone_verified_at' => $otpRecord->type === 'phone' ? now() : null,
            'email_verified_at' => $otpRecord->type === 'email' ? now() : null,
        ]);

        // Clear session data
        Session::forget(['otp_identifier', 'otp_type', 'otp_purpose', 'otp_method']);

        return redirect()->route('register.success')->with([
            'success' => 'Registration completed successfully! Your account has been verified.',
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
        ]);
    }

    /**
     * Handle login verification
     */
    private function handleLoginVerification($otpRecord)
    {
        $user = User::where('phone', $otpRecord->identifier)
                   ->orWhere('email', $otpRecord->identifier)
                   ->first();

        if (!$user) {
            return redirect()->route('login')->with('error', 'User not found');
        }

        // Update verification status
        if ($otpRecord->type === 'phone') {
            $user->phone_verified_at = now();
        } else {
            $user->email_verified_at = now();
        }
        $user->save();

        // Log in user
        Auth::login($user);

        // Fire login event for tracking
        Event::dispatch(new Login('otp', $user, false));

        // Clear session data
        Session::forget(['otp_identifier', 'otp_type', 'otp_purpose', 'otp_method']);

        return redirect()->intended('/')->with('success', 'Login successful!');
    }

    /**
     * Resend OTP
     */
    public function resend(Request $request)
    {
        $identifier = $request->session()->get('otp_identifier');
        $type = $request->session()->get('otp_type');
        $purpose = $request->session()->get('otp_purpose');
        $metadata = $request->session()->get('otp_metadata');

        if (!$identifier || !$type || !$purpose) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid verification session. Please start again.',
                    'redirect' => route('register')
                ]);
            }
            return back()->with('error', 'Invalid verification session');
        }

        // Check rate limiting - allow resend after 60 seconds
        $lastOtp = UserOtp::where('identifier', $identifier)
            ->where('purpose', $purpose)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastOtp && $lastOtp->created_at->diffInSeconds(now()) < 60) {
            $remainingTime = 60 - $lastOtp->created_at->diffInSeconds(now());
            $message = "Please wait {$remainingTime} seconds before requesting a new code.";

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'remaining_time' => $remainingTime
                ]);
            }
            return back()->with('error', $message);
        }

        // Delete previous unverified OTPs for this identifier and purpose
        UserOtp::where('identifier', $identifier)
            ->where('purpose', $purpose)
            ->where('verified', false)
            ->delete();

        // Generate and send new OTP
        $otpRecord = UserOtp::generateAndSend($identifier, $type, $purpose, null, $metadata);

        if (!$otpRecord) {
            $message = 'Failed to send verification code. Please try again.';
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $message
                ]);
            }
            return back()->with('error', $message);
        }

        // Update session with new method
        $request->session()->put('otp_method', $otpRecord->method);

        $message = 'New verification code sent to your ' . ($type === 'email' ? 'email' : 'phone') . '!';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'method' => $otpRecord->method
            ]);
        }

        return back()->with('success', $message);
    }
}
