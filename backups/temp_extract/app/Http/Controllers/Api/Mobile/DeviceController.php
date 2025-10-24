<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\MobileAppDevice;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    /**
     * Register device for push notifications
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'fcm_token' => 'required|string',
            'platform' => 'required|in:android,ios',
            'device_id' => 'nullable|string',
            'device_name' => 'nullable|string',
            'app_version' => 'nullable|string',
        ]);

        $user = $request->user();

        // Check if device already exists
        $device = MobileAppDevice::where('user_id', $user->id)
            ->where('fcm_token', $validated['fcm_token'])
            ->first();

        if ($device) {
            // Update existing device
            $device->update([
                'platform' => $validated['platform'],
                'device_id' => $validated['device_id'] ?? $device->device_id,
                'device_name' => $validated['device_name'] ?? $device->device_name,
                'app_version' => $validated['app_version'] ?? $device->app_version,
                'is_active' => true,
            ]);
        } else {
            // Create new device
            $device = MobileAppDevice::create([
                'user_id' => $user->id,
                'fcm_token' => $validated['fcm_token'],
                'platform' => $validated['platform'],
                'device_id' => $validated['device_id'] ?? null,
                'device_name' => $validated['device_name'] ?? null,
                'app_version' => $validated['app_version'] ?? null,
                'is_active' => true,
            ]);
        }

        return response()->json([
            'message' => 'Device registered successfully',
            'device_id' => $device->id,
        ]);
    }
}

