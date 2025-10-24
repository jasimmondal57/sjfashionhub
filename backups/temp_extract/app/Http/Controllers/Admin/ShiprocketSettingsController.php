<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShiprocketSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class ShiprocketSettingsController extends Controller
{
    /**
     * Display Shiprocket settings
     */
    public function index()
    {
        $settings = [
            'api' => ShiprocketSetting::getByGroup('api'),
            'pickup' => ShiprocketSetting::getByGroup('pickup'),
            'webhook' => ShiprocketSetting::getByGroup('webhook'),
            'general' => ShiprocketSetting::getByGroup('general'),
        ];

        $isConfigured = ShiprocketSetting::isConfigured();
        $connectionStatus = null;

        if ($isConfigured) {
            $connectionStatus = $this->testConnection();
        }

        return view('admin.shiprocket-settings.index', compact('settings', 'isConfigured', 'connectionStatus'));
    }

    /**
     * Update Shiprocket settings
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shiprocket_email' => 'required|email',
            'shiprocket_password' => 'required|min:6',
            'shiprocket_pickup_location' => 'required|string|max:255',
            'shiprocket_pickup_name' => 'required|string|max:255',
            'shiprocket_pickup_email' => 'required|email',
            'shiprocket_pickup_phone' => 'required|string|max:20',
            'shiprocket_pickup_address' => 'required|string',
            'shiprocket_pickup_city' => 'required|string|max:255',
            'shiprocket_pickup_state' => 'required|string|max:255',
            'shiprocket_pickup_pin_code' => 'required|string|max:10',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // API Settings
            ShiprocketSetting::set('shiprocket_email', $request->shiprocket_email, 'email', 'api', 'Shiprocket account email', true);
            ShiprocketSetting::set('shiprocket_password', $request->shiprocket_password, 'password', 'api', 'Shiprocket account password', true);
            ShiprocketSetting::set('shiprocket_base_url', $request->shiprocket_base_url ?? 'https://apiv2.shiprocket.in/v1/external', 'url', 'api', 'Shiprocket API base URL');
            ShiprocketSetting::set('shiprocket_is_sandbox', $request->has('shiprocket_is_sandbox'), 'boolean', 'api', 'Enable sandbox mode for testing');

            // Pickup Address Settings
            ShiprocketSetting::set('shiprocket_pickup_location', $request->shiprocket_pickup_location, 'text', 'pickup', 'Pickup location name');
            ShiprocketSetting::set('shiprocket_pickup_name', $request->shiprocket_pickup_name, 'text', 'pickup', 'Pickup contact name');
            ShiprocketSetting::set('shiprocket_pickup_email', $request->shiprocket_pickup_email, 'email', 'pickup', 'Pickup contact email');
            ShiprocketSetting::set('shiprocket_pickup_phone', $request->shiprocket_pickup_phone, 'text', 'pickup', 'Pickup contact phone');
            ShiprocketSetting::set('shiprocket_pickup_address', $request->shiprocket_pickup_address, 'textarea', 'pickup', 'Pickup address line 1');
            ShiprocketSetting::set('shiprocket_pickup_address_2', $request->shiprocket_pickup_address_2, 'text', 'pickup', 'Pickup address line 2');
            ShiprocketSetting::set('shiprocket_pickup_city', $request->shiprocket_pickup_city, 'text', 'pickup', 'Pickup city');
            ShiprocketSetting::set('shiprocket_pickup_state', $request->shiprocket_pickup_state, 'text', 'pickup', 'Pickup state');
            ShiprocketSetting::set('shiprocket_pickup_country', $request->shiprocket_pickup_country ?? 'India', 'text', 'pickup', 'Pickup country');
            ShiprocketSetting::set('shiprocket_pickup_pin_code', $request->shiprocket_pickup_pin_code, 'text', 'pickup', 'Pickup PIN code');

            // Webhook Settings
            if ($request->filled('shiprocket_webhook_url')) {
                ShiprocketSetting::set('shiprocket_webhook_url', $request->shiprocket_webhook_url, 'url', 'webhook', 'Webhook URL for status updates');
            }

            // Save webhook token (generate if not provided)
            $webhookToken = $request->shiprocket_webhook_token ?? \Illuminate\Support\Str::random(32);
            ShiprocketSetting::set('shiprocket_webhook_token', $webhookToken, 'text', 'webhook', 'Webhook authentication token', true);

            // General Settings
            ShiprocketSetting::set('shiprocket_auto_assign_awb', $request->has('shiprocket_auto_assign_awb'), 'boolean', 'general', 'Automatically assign AWB numbers');
            ShiprocketSetting::set('shiprocket_auto_pickup', $request->has('shiprocket_auto_pickup'), 'boolean', 'general', 'Automatically schedule pickups');
            ShiprocketSetting::set('shiprocket_default_weight', $request->shiprocket_default_weight ?? 0.5, 'number', 'general', 'Default package weight (kg)');
            ShiprocketSetting::set('shiprocket_default_length', $request->shiprocket_default_length ?? 10, 'number', 'general', 'Default package length (cm)');
            ShiprocketSetting::set('shiprocket_default_breadth', $request->shiprocket_default_breadth ?? 10, 'number', 'general', 'Default package breadth (cm)');
            ShiprocketSetting::set('shiprocket_default_height', $request->shiprocket_default_height ?? 10, 'number', 'general', 'Default package height (cm)');

            return redirect()->route('admin.shiprocket-settings.index')
                ->with('success', 'Shiprocket settings updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update settings: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Test Shiprocket connection
     */
    public function testConnection()
    {
        try {
            $credentials = ShiprocketSetting::getApiCredentials();

            if (empty($credentials['email']) || empty($credentials['password'])) {
                return [
                    'status' => 'error',
                    'message' => 'API credentials not configured'
                ];
            }

            // Attempt to authenticate with Shiprocket
            $response = Http::timeout(10)->post($credentials['base_url'] . '/auth/login', [
                'email' => $credentials['email'],
                'password' => $credentials['password']
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['token'])) {
                    // Store the token for future use
                    ShiprocketSetting::set('shiprocket_api_token', $data['token'], 'text', 'api', 'Current API token', true);

                    return [
                        'status' => 'success',
                        'message' => 'Connection successful! API token updated.',
                        'token_expires' => $data['expires_at'] ?? null
                    ];
                }
            }

            return [
                'status' => 'error',
                'message' => 'Authentication failed: ' . ($response->json()['message'] ?? 'Invalid credentials')
            ];

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Connection failed: ' . $e->getMessage()
            ];
        }
    }

    /**
     * Test connection via AJAX
     */
    public function testConnectionAjax(Request $request)
    {
        $result = $this->testConnection();
        return response()->json($result);
    }

    /**
     * Get pickup locations from Shiprocket
     */
    public function getPickupLocations()
    {
        try {
            $token = ShiprocketSetting::get('shiprocket_api_token');
            $baseUrl = ShiprocketSetting::get('shiprocket_base_url', 'https://apiv2.shiprocket.in/v1/external');

            if (!$token) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'API token not available. Please test connection first.'
                ]);
            }

            $response = Http::timeout(10)
                ->withHeaders(['Authorization' => 'Bearer ' . $token])
                ->get($baseUrl . '/settings/company/pickup');

            if ($response->successful()) {
                $data = $response->json();
                return response()->json([
                    'status' => 'success',
                    'pickup_locations' => $data['data']['shipping_address'] ?? []
                ]);
            }

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch pickup locations: ' . ($response->json()['message'] ?? 'Unknown error')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error fetching pickup locations: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Reset all Shiprocket settings
     */
    public function reset()
    {
        try {
            ShiprocketSetting::where('key', 'like', 'shiprocket_%')->delete();

            return redirect()->route('admin.shiprocket-settings.index')
                ->with('success', 'All Shiprocket settings have been reset!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to reset settings: ' . $e->getMessage());
        }
    }
}
