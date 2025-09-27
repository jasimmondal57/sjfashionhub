<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnalyticsSetting;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    /**
     * Display analytics settings
     */
    public function index()
    {
        $settings = AnalyticsSetting::firstOrCreate([], [
            'google_analytics_enabled' => false,
            'google_tag_manager_enabled' => false,
            'facebook_pixel_enabled' => false,
        ]);

        return view('admin.analytics.index', compact('settings'));
    }

    /**
     * Update analytics settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'google_analytics_id' => 'nullable|string|max:255',
            'google_tag_manager_id' => 'nullable|string|max:255',
            'facebook_pixel_id' => 'nullable|string|max:255',
            'google_analytics_enabled' => 'boolean',
            'google_tag_manager_enabled' => 'boolean',
            'facebook_pixel_enabled' => 'boolean',
        ]);

        try {
            $settings = AnalyticsSetting::first();
            
            if (!$settings) {
                $settings = new AnalyticsSetting();
            }

            $settings->fill([
                'google_analytics_id' => $request->google_analytics_id,
                'google_tag_manager_id' => $request->google_tag_manager_id,
                'facebook_pixel_id' => $request->facebook_pixel_id,
                'google_analytics_enabled' => $request->boolean('google_analytics_enabled'),
                'google_tag_manager_enabled' => $request->boolean('google_tag_manager_enabled'),
                'facebook_pixel_enabled' => $request->boolean('facebook_pixel_enabled'),
            ]);

            $settings->save();

            return response()->json([
                'success' => true,
                'message' => 'Analytics settings updated successfully!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update analytics settings: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Test Google Analytics connection
     */
    public function testGoogleAnalytics(Request $request)
    {
        $request->validate([
            'tracking_id' => 'required|string'
        ]);

        // This is a simple validation - in a real implementation you might want to
        // make an API call to Google Analytics to verify the tracking ID
        $trackingId = $request->tracking_id;
        
        if (preg_match('/^(G-|GA_MEASUREMENT_ID|UA-)\w+/', $trackingId)) {
            return response()->json([
                'success' => true,
                'message' => 'Google Analytics tracking ID format is valid!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid Google Analytics tracking ID format!'
        ], 400);
    }

    /**
     * Test Facebook Pixel connection
     */
    public function testFacebookPixel(Request $request)
    {
        $request->validate([
            'pixel_id' => 'required|string'
        ]);

        // Simple validation for Facebook Pixel ID (should be numeric)
        $pixelId = $request->pixel_id;
        
        if (is_numeric($pixelId) && strlen($pixelId) >= 10) {
            return response()->json([
                'success' => true,
                'message' => 'Facebook Pixel ID format is valid!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid Facebook Pixel ID format! Should be a numeric ID.'
        ], 400);
    }
}
