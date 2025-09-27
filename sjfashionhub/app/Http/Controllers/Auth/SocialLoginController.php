<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SocialLoginSetting;
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
        // Check if provider is enabled in database
        $setting = SocialLoginSetting::getProviderConfig($provider);

        if (!$setting || !$setting->enabled) {
            return redirect()->route('login')->with('error', ucfirst($provider) . ' login is currently disabled');
        }

        if (!$setting->client_id || !$setting->client_secret) {
            return redirect()->route('login')->with('error', ucfirst($provider) . ' is not properly configured');
        }

        try {
            // Configure Socialite with database settings
            config([
                "services.{$provider}.client_id" => $setting->client_id,
                "services.{$provider}.client_secret" => $setting->client_secret,
                "services.{$provider}.redirect" => $setting->redirect_uri,
            ]);

            return Socialite::driver($provider)->redirect();
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Unable to connect to ' . ucfirst($provider));
        }
    }

    /**
     * Handle social provider callback
     */
    public function callback($provider)
    {
        // Check if provider is enabled
        $setting = SocialLoginSetting::getProviderConfig($provider);

        if (!$setting || !$setting->enabled) {
            return redirect()->route('login')->with('error', ucfirst($provider) . ' login is currently disabled');
        }

        try {
            // Configure Socialite with database settings
            config([
                "services.{$provider}.client_id" => $setting->client_id,
                "services.{$provider}.client_secret" => $setting->client_secret,
                "services.{$provider}.redirect" => $setting->redirect_uri,
            ]);

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
