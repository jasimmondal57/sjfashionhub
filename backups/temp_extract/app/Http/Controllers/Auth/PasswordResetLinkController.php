<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOtp;
use App\Services\SmsService;
use App\Services\WhatsAppService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class PasswordResetLinkController extends Controller
{
    protected $smsService;
    protected $whatsAppService;

    public function __construct(SmsService $smsService, WhatsAppService $whatsAppService)
    {
        $this->smsService = $smsService;
        $this->whatsAppService = $whatsAppService;
    }

    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset request with OTP verification.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'identifier' => ['required', 'string'],
            'method' => ['required', 'in:email,phone,whatsapp'],
        ]);

        $identifier = $request->identifier;
        $method = $request->method;

        // Find user by email or phone
        $user = null;
        if ($method === 'email') {
            $user = User::where('email', $identifier)->first();
        } else {
            // For phone/whatsapp, try to find by phone number
            $user = User::where('phone', $identifier)
                       ->orWhere('phone', 'LIKE', '%' . $identifier)
                       ->first();
        }

        if (!$user) {
            return back()->withErrors([
                'identifier' => 'No account found with this ' . ($method === 'email' ? 'email' : 'phone number') . '.'
            ]);
        }

        // Generate and send OTP
        $otpRecord = UserOtp::generateAndSend(
            $identifier,
            $method,
            'password_reset',
            $user->id
        );

        if (!$otpRecord) {
            return back()->withErrors([
                'identifier' => 'Failed to send verification code. Please try again.'
            ]);
        }

        // Store user ID and method in session for OTP verification
        $request->session()->put([
            'password_reset_user_id' => $user->id,
            'password_reset_identifier' => $identifier,
            'password_reset_method' => $method,
        ]);

        return redirect()->route('password.verify-otp')->with('success',
            'Verification code sent to your ' . ($method === 'email' ? 'email' : 'phone') . '!'
        );
    }

    /**
     * Show OTP verification form for password reset
     */
    public function showVerifyOtp(): View
    {
        if (!session('password_reset_user_id')) {
            return redirect()->route('password.request')->with('error', 'Session expired. Please try again.');
        }

        return view('auth.forgot-password-verify-otp', [
            'method' => session('password_reset_method'),
            'identifier' => session('password_reset_identifier'),
        ]);
    }

    /**
     * Verify OTP and show password reset form
     */
    public function verifyOtp(Request $request): RedirectResponse
    {
        $request->validate([
            'otp' => ['required', 'string', 'size:6'],
        ]);

        $userId = session('password_reset_user_id');
        $identifier = session('password_reset_identifier');
        $method = session('password_reset_method');

        if (!$userId || !$identifier || !$method) {
            return redirect()->route('password.request')->with('error', 'Session expired. Please try again.');
        }

        // Verify OTP
        $isValid = UserOtp::verifyOtp($identifier, $request->otp, 'password_reset');

        if (!$isValid) {
            return back()->withErrors(['otp' => 'Invalid or expired verification code.']);
        }

        // Generate password reset token and store in session
        $token = bin2hex(random_bytes(32));
        $request->session()->put([
            'password_reset_token' => $token,
            'password_reset_verified' => true,
        ]);

        return redirect()->route('password.reset.form', ['token' => $token]);
    }

    /**
     * Show password reset form
     */
    public function showResetForm(Request $request, $token): View
    {
        if (!session('password_reset_verified') || session('password_reset_token') !== $token) {
            return redirect()->route('password.request')->with('error', 'Invalid or expired reset token.');
        }

        return view('auth.reset-password-new', [
            'token' => $token,
            'user_id' => session('password_reset_user_id'),
        ]);
    }

    /**
     * Reset the password
     */
    public function resetPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $userId = session('password_reset_user_id');
        $token = session('password_reset_token');

        if (!$userId || !$token || $token !== $request->token) {
            return redirect()->route('password.request')->with('error', 'Invalid or expired reset token.');
        }

        $user = User::find($userId);
        if (!$user) {
            return redirect()->route('password.request')->with('error', 'User not found.');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Clear session data
        $request->session()->forget([
            'password_reset_user_id',
            'password_reset_identifier',
            'password_reset_method',
            'password_reset_token',
            'password_reset_verified',
        ]);

        return redirect()->route('login')->with('success', 'Password reset successfully! You can now login with your new password.');
    }

    /**
     * Resend OTP for password reset
     */
    public function resendOtp(Request $request)
    {
        $userId = session('password_reset_user_id');
        $identifier = session('password_reset_identifier');
        $method = session('password_reset_method');

        if (!$userId || !$identifier || !$method) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Session expired.']);
            }
            return redirect()->route('password.request')->with('error', 'Session expired. Please try again.');
        }

        // Generate and send new OTP
        $otpRecord = UserOtp::generateAndSend($identifier, $method, 'password_reset', $userId);

        if (!$otpRecord) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to send verification code.']);
            }
            return back()->with('error', 'Failed to send verification code. Please try again.');
        }

        $message = 'New verification code sent to your ' . ($method === 'email' ? 'email' : 'phone') . '!';

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return back()->with('success', $message);
    }
}
