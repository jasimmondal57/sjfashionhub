<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\MobileAppSetting;
use App\Models\MobileAppMenuItem;

class ConfigController extends Controller
{
    /**
     * Get app configuration
     */
    public function index()
    {
        $config = [
            'app_name' => MobileAppSetting::get('app_name', 'SJ Fashion Hub'),
            'api_base_url' => MobileAppSetting::get('api_base_url', url('/')),
            'app_version' => MobileAppSetting::get('app_version', '1.0.0'),
            
            // Theme colors
            'theme' => [
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
            ],
            
            // Features
            'features' => [
                'enable_wishlist' => MobileAppSetting::get('enable_wishlist', true),
                'enable_cart' => MobileAppSetting::get('enable_cart', true),
                'enable_notifications' => MobileAppSetting::get('enable_notifications', true),
                'enable_social_login' => MobileAppSetting::get('enable_social_login', false),
            ],
            
            // Menu items
            'menu_items' => MobileAppMenuItem::where('is_active', true)
                ->orderBy('order')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'title' => $item->title,
                        'icon' => $item->icon,
                        'type' => $item->type,
                        'route' => $item->route,
                    ];
                }),
        ];

        return response()->json($config);
    }
}

