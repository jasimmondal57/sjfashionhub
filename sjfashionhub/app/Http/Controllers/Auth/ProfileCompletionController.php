<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules;

class ProfileCompletionController extends Controller
{
    /**
     * Show profile completion form
     */
    public function show()
    {
        $socialData = session('social_user_data');
        $provider = session('social_provider');

        if (!$socialData || !$provider) {
            return redirect()->route('login')->with('error', 'Invalid session. Please try logging in again.');
        }

        return view('auth.complete-profile', compact('socialData', 'provider'));
    }

    /**
     * Handle profile completion
     */
    public function store(Request $request)
    {
        $socialData = session('social_user_data');
        $provider = session('social_provider');

        if (!$socialData || !$provider) {
            return redirect()->route('login')->with('error', 'Invalid session. Please try logging in again.');
        }

        // Validate only missing fields
        $rules = [];
        $messages = [];

        // Name validation (if not provided by social)
        if (empty($socialData['name']) || $request->filled('name')) {
            $rules['name'] = ['required', 'string', 'max:255'];
        }

        // Email validation (if not provided by social)
        if (empty($socialData['email']) || $request->filled('email')) {
            $rules['email'] = ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class];
        }

        // Phone is always required for social signups
        $rules['phone'] = ['required', 'string', 'regex:/^[0-9]{7,15}$/', 'unique:'.User::class];
        $rules['country_code'] = ['required', 'string', 'in:+91,+1,+44,+971,+966,+65,+60,+61,+49,+33'];

        // Password is optional for social signups
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Rules\Password::defaults()];
        }

        // Verification method
        $rules['verification_method'] = ['required', 'in:phone,email'];

        $request->validate($rules, $messages);

        // Combine country code with phone number
        $fullPhoneNumber = $request->country_code . $request->phone;

        // Prepare complete user data
        $userData = array_merge($socialData, [
            'name' => $request->name ?: $socialData['name'],
            'email' => $request->email ?: $socialData['email'],
            'phone' => $fullPhoneNumber,
        ]);

        // Add password if provided
        if ($request->filled('password')) {
            $userData['password'] = $request->password;
        } else {
            $userData['password'] = \Illuminate\Support\Str::random(24); // Random password
        }

        // Determine verification method and identifier
        $verificationMethod = $request->verification_method;
        $identifier = $verificationMethod === 'email' ? $userData['email'] : $fullPhoneNumber;

        // Generate and send OTP
        $otpRecord = UserOtp::generateAndSend($identifier, $verificationMethod, 'registration', null, $userData);

        if (!$otpRecord) {
            return back()->with('error', 'Failed to send verification code. Please try again.');
        }

        // Store verification data in session
        Session::put([
            'otp_identifier' => $identifier,
            'otp_type' => $verificationMethod,
            'otp_purpose' => 'registration',
            'otp_method' => $otpRecord->method,
            'otp_metadata' => $userData,
        ]);

        // Clear social data from session
        Session::forget(['social_user_data', 'social_provider']);

        return redirect()->route('otp.verify')->with('success', 'Verification code sent! Please check your ' . ($verificationMethod === 'email' ? 'email' : 'phone') . '.');
    }
}
