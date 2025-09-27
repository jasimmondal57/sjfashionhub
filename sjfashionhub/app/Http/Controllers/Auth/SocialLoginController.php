<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    /**
     * Redirect to social provider
     */
    public function redirect($provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            return redirect()->route('login')->with('error', 'Invalid social provider.');
        }

        try {
            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Social login is not configured properly.');
        }
    }

    /**
     * Handle social provider callback
     */
    public function callback($provider)
    {
        if (!in_array($provider, ['google', 'facebook'])) {
            return redirect()->route('login')->with('error', 'Invalid social provider.');
        }

        try {
            $socialUser = Socialite::driver($provider)->user();
            
            // Check if user already exists with this provider
            $user = User::where('provider', $provider)
                       ->where('provider_id', $socialUser->getId())
                       ->first();

            if ($user) {
                // User exists, log them in
                Auth::login($user);
                return redirect()->intended('/');
            }

            // Check if user exists with same email
            $existingUser = User::where('email', $socialUser->getEmail())->first();
            
            if ($existingUser) {
                // Link social account to existing user
                $existingUser->update([
                    'provider' => $provider,
                    'provider_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                    'login_type' => $provider
                ]);
                
                Auth::login($existingUser);
                return redirect()->intended('/');
            }

            // Create new user
            $user = User::create([
                'name' => $socialUser->getName(),
                'email' => $socialUser->getEmail(),
                'provider' => $provider,
                'provider_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
                'login_type' => $provider,
                'email_verified_at' => now(),
                'password' => Hash::make(Str::random(24)), // Random password
            ]);

            Auth::login($user);
            return redirect()->intended('/');

        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Unable to login with ' . ucfirst($provider) . '. Please try again.');
        }
    }
}
