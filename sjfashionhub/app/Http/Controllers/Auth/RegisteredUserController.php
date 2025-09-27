<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        ]);

        // Combine country code with phone number
        $fullPhoneNumber = $request->country_code . $request->phone;

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $fullPhoneNumber,
            'password' => Hash::make($request->password),
            'login_type' => 'email',
        ]);

        event(new Registered($user));

        // Don't auto-login, redirect to success page instead
        return redirect()->route('register.success')->with([
            'success' => 'Registration successful! Please login with your credentials.',
            'user_name' => $user->name,
            'user_email' => $user->email,
            'user_phone' => $user->phone,
        ]);
    }

    /**
     * Show registration success page.
     */
    public function success(): View
    {
        return view('auth.register-success');
    }
}
