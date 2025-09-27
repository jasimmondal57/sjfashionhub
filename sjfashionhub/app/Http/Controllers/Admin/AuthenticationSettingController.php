<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SocialLoginSetting;
use App\Models\AuthenticationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AuthenticationSettingController extends Controller
{
    /**
     * Display authentication settings
     */
    public function index()
    {
        $socialProviders = SocialLoginSetting::all();
        $authMethods = AuthenticationSetting::all();

        return view('admin.authentication-settings.index', compact('socialProviders', 'authMethods'));
    }

    /**
     * Update social login provider settings
     */
    public function updateSocialProvider(Request $request, $provider)
    {
        $request->validate([
            'enabled' => 'boolean',
            'client_id' => 'nullable|string',
            'client_secret' => 'nullable|string',
            'redirect_uri' => 'nullable|url',
        ]);

        $setting = SocialLoginSetting::where('provider', $provider)->firstOrFail();

        $setting->update([
            'enabled' => $request->boolean('enabled'),
            'client_id' => $request->client_id,
            'client_secret' => $request->client_secret,
            'redirect_uri' => $request->redirect_uri,
        ]);

        // Clear config cache to apply changes
        Artisan::call('config:clear');

        return redirect()->back()->with('success', ucfirst($provider) . ' settings updated successfully!');
    }

    /**
     * Update authentication method settings (only enable/disable)
     */
    public function updateAuthMethod(Request $request, $method)
    {
        $request->validate([
            'enabled' => 'boolean',
        ]);

        $setting = AuthenticationSetting::where('method', $method)->firstOrFail();

        $setting->update([
            'enabled' => $request->boolean('enabled'),
        ]);

        return redirect()->back()->with('success', $setting->display_name . ' has been ' . ($request->boolean('enabled') ? 'enabled' : 'disabled') . '!');
    }

    /**
     * Toggle provider/method status
     */
    public function toggleStatus(Request $request)
    {
        $type = $request->type; // 'social' or 'auth'
        $identifier = $request->identifier; // provider name or method name

        if ($type === 'social') {
            $setting = SocialLoginSetting::where('provider', $identifier)->firstOrFail();
        } else {
            $setting = AuthenticationSetting::where('method', $identifier)->firstOrFail();
        }

        $setting->update(['enabled' => !$setting->enabled]);

        $status = $setting->enabled ? 'enabled' : 'disabled';
        $name = $type === 'social' ? ucfirst($identifier) : $setting->display_name;

        return response()->json([
            'success' => true,
            'message' => "{$name} has been {$status}",
            'enabled' => $setting->enabled,
        ]);
    }

    /**
     * Test social provider configuration
     */
    public function testSocialProvider($provider)
    {
        $setting = SocialLoginSetting::where('provider', $provider)->firstOrFail();

        if (!$setting->enabled) {
            return response()->json([
                'success' => false,
                'message' => ucfirst($provider) . ' is not enabled',
            ]);
        }

        if (!$setting->client_id || !$setting->client_secret) {
            return response()->json([
                'success' => false,
                'message' => 'Client ID and Client Secret are required',
            ]);
        }

        // Here you could add actual API testing logic
        return response()->json([
            'success' => true,
            'message' => ucfirst($provider) . ' configuration appears valid',
            'redirect_url' => route('social.redirect', $provider),
        ]);
    }

    /**
     * Test authentication method configuration
     */
    public function testAuthMethod($method)
    {
        $setting = AuthenticationSetting::where('method', $method)->firstOrFail();

        if (!$setting->enabled) {
            return response()->json([
                'success' => false,
                'message' => $setting->display_name . ' is not enabled',
            ]);
        }

        // Redirect to communication settings for SMS/WhatsApp
        if ($method === 'mobile_sms') {
            return response()->json([
                'success' => false,
                'message' => 'SMS settings are configured in Communication → SMS Settings',
            ]);
        } elseif ($method === 'mobile_whatsapp') {
            return response()->json([
                'success' => false,
                'message' => 'WhatsApp settings are configured in Communication → WhatsApp Settings',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => $setting->display_name . ' is enabled',
        ]);
    }
}
