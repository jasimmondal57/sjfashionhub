<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OtpController extends Controller
{
    /**
     * Send OTP to user
     */
    public function sendOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'type' => 'required|in:registration,password_reset,verification'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->email;
        $type = $request->type;

        // Check if user exists for certain types
        $user = User::where('email', $email)->first();
        
        if ($type === 'password_reset' && !$user) {
            return response()->json([
                'success' => false,
                'message' => 'User with this email does not exist'
            ], 404);
        }

        if ($type === 'registration' && $user) {
            return response()->json([
                'success' => false,
                'message' => 'User with this email already exists'
            ], 400);
        }

        // Generate OTP
        $otp = rand(100000, 999999);
        
        // Store OTP in cache for 10 minutes
        $cacheKey = "otp_{$type}_{$email}";
        cache()->put($cacheKey, $otp, now()->addMinutes(10));

        try {
            // Send OTP via email (you can also implement SMS)
            $this->sendOtpEmail($email, $otp, $type);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully to your email',
                'data' => [
                    'email' => $email,
                    'type' => $type,
                    'expires_in' => 600 // 10 minutes in seconds
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify OTP
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|size:6',
            'type' => 'required|in:registration,password_reset,verification'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->email;
        $otp = $request->otp;
        $type = $request->type;

        // Check OTP from cache
        $cacheKey = "otp_{$type}_{$email}";
        $storedOtp = cache()->get($cacheKey);

        if (!$storedOtp) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired or does not exist'
            ], 400);
        }

        if ($storedOtp != $otp) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP'
            ], 400);
        }

        // OTP is valid, remove from cache
        cache()->forget($cacheKey);

        // Generate verification token for further actions
        $verificationToken = Str::random(60);
        $tokenCacheKey = "verification_token_{$type}_{$email}";
        cache()->put($tokenCacheKey, $verificationToken, now()->addMinutes(30));

        return response()->json([
            'success' => true,
            'message' => 'OTP verified successfully',
            'data' => [
                'verification_token' => $verificationToken,
                'email' => $email,
                'type' => $type,
                'expires_in' => 1800 // 30 minutes in seconds
            ]
        ]);
    }

    /**
     * Send OTP email
     */
    private function sendOtpEmail($email, $otp, $type)
    {
        $subject = '';
        $message = '';

        switch ($type) {
            case 'registration':
                $subject = 'Registration OTP - SJ Fashion Hub';
                $message = "Your registration OTP is: {$otp}. This OTP will expire in 10 minutes.";
                break;
            case 'password_reset':
                $subject = 'Password Reset OTP - SJ Fashion Hub';
                $message = "Your password reset OTP is: {$otp}. This OTP will expire in 10 minutes.";
                break;
            case 'verification':
                $subject = 'Verification OTP - SJ Fashion Hub';
                $message = "Your verification OTP is: {$otp}. This OTP will expire in 10 minutes.";
                break;
        }

        // Simple email sending (you can customize this with a proper email template)
        Mail::raw($message, function ($mail) use ($email, $subject) {
            $mail->to($email)
                 ->subject($subject)
                 ->from(config('mail.from.address'), config('mail.from.name'));
        });
    }
}
