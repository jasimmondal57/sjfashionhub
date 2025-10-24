<?php

namespace App\Services;

use App\Models\ShiprocketSetting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ShiprocketService
{
    private $email;
    private $password;
    private $baseUrl = 'https://apiv2.shiprocket.in/v1/external';

    public function __construct()
    {
        // Get credentials from database settings
        $this->email = ShiprocketSetting::get('shiprocket_email') ?? env('SHIPROCKET_EMAIL');
        $this->password = ShiprocketSetting::get('shiprocket_password') ?? env('SHIPROCKET_PASSWORD');
        $this->baseUrl = ShiprocketSetting::get('shiprocket_base_url') ?? 'https://apiv2.shiprocket.in/v1/external';
    }

    /**
     * Get authentication token
     */
    public function getToken()
    {
        // Cache token for 10 days (Shiprocket tokens are valid for 10 days)
        return Cache::remember('shiprocket_token', 60 * 24 * 10, function () {
            try {
                $response = Http::post($this->baseUrl . '/auth/login', [
                    'email' => $this->email,
                    'password' => $this->password,
                ]);

                if ($response->successful()) {
                    return $response->json()['token'];
                }

                Log::error('Shiprocket authentication failed', [
                    'response' => $response->json()
                ]);

                return null;
            } catch (\Exception $e) {
                Log::error('Shiprocket authentication error: ' . $e->getMessage());
                return null;
            }
        });
    }

    /**
     * Check delivery availability and get estimated delivery time
     *
     * @param string $pincode Customer's pincode
     * @param float $weight Product weight in kg
     * @param string $pickupPincode Warehouse/pickup pincode
     * @return array
     */
    public function checkDelivery($pincode, $weight = 0.5, $pickupPincode = null)
    {
        $token = $this->getToken();

        if (!$token) {
            return [
                'success' => false,
                'message' => 'Unable to connect to delivery service',
            ];
        }

        // Use pickup pincode from database settings if not provided
        $pickupPincode = $pickupPincode
                      ?? ShiprocketSetting::get('shiprocket_pickup_pin_code')
                      ?? env('SHIPROCKET_PICKUP_PINCODE', '700001');

        try {
            // Check serviceability
            $response = Http::withToken($token)
                ->get($this->baseUrl . '/courier/serviceability/', [
                    'pickup_postcode' => $pickupPincode,
                    'delivery_postcode' => $pincode,
                    'weight' => $weight,
                    'cod' => 1, // Check for both prepaid and COD
                ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['data']['available_courier_companies']) && count($data['data']['available_courier_companies']) > 0) {
                    // Get the fastest courier
                    $couriers = $data['data']['available_courier_companies'];
                    $fastestCourier = collect($couriers)->sortBy('etd')->first();

                    return [
                        'success' => true,
                        'available' => true,
                        'estimated_days' => $fastestCourier['etd'] ?? '5-7',
                        'courier_name' => $fastestCourier['courier_name'] ?? 'Standard',
                        'cod_available' => $fastestCourier['cod'] ?? false,
                        'message' => 'Delivery available',
                    ];
                } else {
                    return [
                        'success' => true,
                        'available' => false,
                        'message' => 'Delivery not available to this pincode',
                    ];
                }
            }

            return [
                'success' => false,
                'message' => 'Unable to check delivery availability',
            ];

        } catch (\Exception $e) {
            Log::error('Shiprocket delivery check error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Error checking delivery availability',
            ];
        }
    }

    /**
     * Get pincode details
     */
    public function getPincodeDetails($pincode)
    {
        $token = $this->getToken();

        if (!$token) {
            return null;
        }

        try {
            $response = Http::withToken($token)
                ->get($this->baseUrl . '/open/postcode/details', [
                    'postcode' => $pincode,
                ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Shiprocket pincode details error: ' . $e->getMessage());
            return null;
        }
    }
}

