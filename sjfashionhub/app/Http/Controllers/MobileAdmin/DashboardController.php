<?php

namespace App\Http\Controllers\MobileAdmin;

use App\Http\Controllers\Controller;
use App\Models\MobileAppSetting;
use App\Models\MobileAppSection;
use App\Models\MobileAppBanner;
use App\Models\MobileAppMenuItem;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display mobile admin dashboard
     */
    public function index()
    {
        $stats = [
            'total_sections' => MobileAppSection::count(),
            'active_sections' => MobileAppSection::where('is_active', true)->count(),
            'total_banners' => MobileAppBanner::count(),
            'active_banners' => MobileAppBanner::getActive()->count(),
            'menu_items' => MobileAppMenuItem::count(),
            'api_base_url' => MobileAppSetting::get('api_base_url', url('/')),
        ];

        return view('mobileadmin.dashboard', compact('stats'));
    }

    /**
     * Display settings page
     */
    public function settings()
    {
        $settings = MobileAppSetting::getAllGrouped();
        return view('mobileadmin.settings', compact('settings'));
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            $setting = MobileAppSetting::where('key', $key)->first();
            if ($setting) {
                // Handle file uploads
                if ($request->hasFile($key)) {
                    $path = $request->file($key)->store('mobile/settings', 'public');
                    $setting->update(['value' => $path]);
                } else {
                    $setting->update(['value' => $value ?? '']);
                }
            }
        }

        MobileAppSetting::clearCache();

        return back()->with('success', 'Settings updated successfully!');
    }

    /**
     * Show theme customization page
     */
    public function theme()
    {
        $settings = [
            'primary_color' => MobileAppSetting::get('primary_color', '#7C3AED'),
            'secondary_color' => MobileAppSetting::get('secondary_color', '#6366F1'),
            'accent_color' => MobileAppSetting::get('accent_color', '#EC4899'),
            'background_color' => MobileAppSetting::get('background_color', '#F9FAFB'),
            'text_color' => MobileAppSetting::get('text_color', '#1F2937'),
            'success_color' => MobileAppSetting::get('success_color', '#10B981'),
            'error_color' => MobileAppSetting::get('error_color', '#EF4444'),
            'warning_color' => MobileAppSetting::get('warning_color', '#F59E0B'),
            'font_family' => MobileAppSetting::get('font_family', 'system'),
            'border_radius' => MobileAppSetting::get('border_radius', 8),
        ];

        return view('mobileadmin.theme', compact('settings'));
    }

    /**
     * Update theme settings
     */
    public function updateTheme(Request $request)
    {
        $validated = $request->validate([
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
            'accent_color' => 'required|string',
            'background_color' => 'required|string',
            'text_color' => 'required|string',
            'success_color' => 'required|string',
            'error_color' => 'required|string',
            'warning_color' => 'required|string',
            'font_family' => 'required|string',
            'border_radius' => 'required|integer|min:0|max:50',
        ]);

        foreach ($validated as $key => $value) {
            $setting = MobileAppSetting::where('key', $key)->first();
            if ($setting) {
                $setting->update(['value' => $value]);
            } else {
                MobileAppSetting::create([
                    'key' => $key,
                    'value' => $value,
                    'type' => in_array($key, ['border_radius']) ? 'number' : 'color',
                    'group' => 'theme',
                    'order' => 0,
                ]);
            }
        }

        MobileAppSetting::clearCache();

        return back()->with('success', 'Theme updated successfully!');
    }

    /**
     * Display analytics
     */
    public function analytics()
    {
        return view('mobileadmin.analytics');
    }
}

