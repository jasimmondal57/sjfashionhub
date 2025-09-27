<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'regex:/^[0-9]{7,15}$/', 'unique:'.User::class],
            'country_code' => ['required', 'string', 'in:+91,+1,+44,+971,+966,+65,+60,+61,+49,+33'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'verification_method' => ['required', 'in:phone,email'],
        ]);

        // Combine country code with phone number
        $fullPhoneNumber = $request->country_code . $request->phone;

        // Prepare user data for OTP verification
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $fullPhoneNumber,
            'password' => $request->password,
        ];

        // Determine verification identifier and type
        $verificationMethod = $request->verification_method;
        $identifier = $verificationMethod === 'email' ? $request->email : $fullPhoneNumber;
        $type = $verificationMethod;

        // Generate and send OTP
        $otpRecord = UserOtp::generateAndSend($identifier, $type, 'registration', null, $userData);

        if (!$otpRecord) {
            return back()->with('error', 'Failed to send verification code. Please try again.');
        }

        // Store verification data in session
        Session::put([
            'otp_identifier' => $identifier,
            'otp_type' => $type,
            'otp_purpose' => 'registration',
            'otp_method' => $otpRecord->method,
            'otp_metadata' => $userData,
        ]);

        return redirect()->route('otp.verify')->with('success', 'Verification code sent! Please check your ' . ($type === 'email' ? 'email' : 'phone') . '.');
    }

    /**
     * Show registration success page.
     */
    public function success(): View
    {
        return view('auth.register-success');
    }
}
