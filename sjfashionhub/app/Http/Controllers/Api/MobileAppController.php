<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MobileAppBanner;
use App\Models\MobileAppSetting;
use Illuminate\Http\Request;

class MobileAppController extends Controller
{
    /**
     * Get mobile app banners
     */
    public function getBanners()
    {
        try {
            $banners = MobileAppBanner::getActive();
            
            $formattedBanners = $banners->map(function ($banner) {
                return [
                    'id' => $banner->id,
                    'title' => $banner->title,
                    'image' => $banner->image ? url('storage/' . $banner->image) : null,
                    'link_type' => $banner->link_type,
                    'link_value' => $banner->link_value,
                    'order' => $banner->order,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $formattedBanners,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch banners',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get mobile app settings
     */
    public function getSettings()
    {
        try {
            $settings = MobileAppSetting::getAllGrouped();
            
            return response()->json([
                'success' => true,
                'data' => $settings,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch settings',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get mobile app home data (banners + other sections)
     */
    public function getHomeData()
    {
        try {
            // Get banners
            $banners = MobileAppBanner::getActive();
            
            $formattedBanners = $banners->map(function ($banner) {
                return [
                    'id' => $banner->id,
                    'title' => $banner->title,
                    'image' => $banner->image ? url('storage/' . $banner->image) : null,
                    'link_type' => $banner->link_type,
                    'link_value' => $banner->link_value,
                    'order' => $banner->order,
                ];
            });

            // For now, return banners in the same format as the main homepage API
            // but specifically for mobile app
            $sections = [
                [
                    'id' => 1,
                    'title' => 'Mobile App Banners',
                    'type' => 'mobile_banner',
                    'items' => $formattedBanners,
                ]
            ];

            return response()->json([
                'success' => true,
                'sections' => $sections,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch home data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
