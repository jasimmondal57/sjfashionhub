<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Currency;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Get general settings
     */
    public function generalSettings(Request $request)
    {
        // Return format expected by Flutter app
        $response = [
            'settings' => [
                'site_title' => 'SJ Fashion Hub',
                'company_name' => 'SJ Fashion Hub',
                'country_name' => 'India',
                'zip_code' => '400001',
                'address' => 'Mumbai, Maharashtra, India',
                'phone' => '+91-9876543210',
                'email' => 'support@sjfashionhub.com',
                'currency_symbol' => '₹',
                'logo' => url('/images/logo.png'),
                'favicon' => url('/images/favicon.ico'),
                'currency_code' => 'INR',
                'copyright_text' => '© 2024 SJ Fashion Hub. All rights reserved.',
                'language_code' => 'en',
                'country_id' => 1,
                'state_id' => 1,
                'city_id' => 1,
                'currency_symbol_position' => 'before'
            ],
            'currencies' => [
                [
                    'id' => 1,
                    'name' => 'US Dollar',
                    'code' => 'USD',
                    'symbol' => '$',
                    'convert_rate' => 1.0,
                    'status' => 1
                ]
            ],
            'languages' => [
                [
                    'id' => 1,
                    'name' => 'English',
                    'code' => 'en',
                    'status' => 1,
                    'rtl' => 0
                ]
            ],
            'vendorType' => 'multi',
            'free_shipping' => [
                'id' => 1,
                'name' => 'Free Shipping',
                'status' => 1,
                'cost' => 0.0,
                'minimum_shopping' => 100.0,
                'is_active' => 1,
                'carrier_id' => null,
                'cost_based_on' => 'order_amount',
                'logo' => null,
                'phone' => null,
                'shipment_time' => '3-5 business days',
                'request_by_user' => 0,
                'is_approved' => 1,
                'created_at' => now()->toISOString(),
                'updated_at' => now()->toISOString()
            ],
            'pickup_locations' => [],
            'otp_configuration' => [
                [
                    'id' => 1,
                    'type' => 'email',
                    'status' => 1,
                    'value' => 1
                ],
                [
                    'id' => 2,
                    'type' => 'code_validation_time',
                    'status' => 1,
                    'value' => 300
                ],
                [
                    'id' => 3,
                    'type' => 'otp_on_customer_registration',
                    'status' => 1,
                    'value' => 1
                ],
                [
                    'id' => 4,
                    'type' => 'otp_on_login',
                    'status' => 1,
                    'value' => 0
                ],
                [
                    'id' => 5,
                    'type' => 'otp_on_password_reset',
                    'status' => 1,
                    'value' => 1
                ],
                [
                    'id' => 6,
                    'type' => 'otp_on_order_verification',
                    'status' => 1,
                    'value' => 0
                ],
                [
                    'id' => 7,
                    'type' => 'otp_on_order_with_cod',
                    'status' => 1,
                    'value' => 0
                ],
                [
                    'id' => 8,
                    'type' => 'order_otp_on_verified_customer',
                    'status' => 1,
                    'value' => 0
                ],
                [
                    'id' => 9,
                    'type' => 'order_cancel_limit_on_verified_customer',
                    'status' => 1,
                    'value' => 24
                ]
            ],
            'modules' => [
                'refund' => true,
                'otp_configuration' => true,
                'google_login' => true,
                'facebook_login' => true
            ],
            'msg' => 'success'
        ];

        return response()->json($response);
    }

    /**
     * Get currency list
     */
    public function currencies(Request $request)
    {
        $currencies = [
            ['code' => 'USD', 'name' => 'US Dollar', 'symbol' => '$'],
            ['code' => 'EUR', 'name' => 'Euro', 'symbol' => '€'],
            ['code' => 'GBP', 'name' => 'British Pound', 'symbol' => '£'],
            ['code' => 'JPY', 'name' => 'Japanese Yen', 'symbol' => '¥'],
            ['code' => 'CAD', 'name' => 'Canadian Dollar', 'symbol' => 'C$'],
            ['code' => 'AUD', 'name' => 'Australian Dollar', 'symbol' => 'A$'],
            ['code' => 'INR', 'name' => 'Indian Rupee', 'symbol' => '₹'],
        ];

        return response()->json([
            'success' => true,
            'data' => $currencies
        ]);
    }

    /**
     * Get shipping methods
     */
    public function shippingMethods(Request $request)
    {
        $shippingMethods = [
            [
                'id' => 1,
                'name' => 'Standard Shipping',
                'description' => '5-7 business days',
                'cost' => 50.00,
                'estimated_days' => '5-7',
                'is_active' => true
            ],
            [
                'id' => 2,
                'name' => 'Express Shipping',
                'description' => '2-3 business days',
                'cost' => 100.00,
                'estimated_days' => '2-3',
                'is_active' => true
            ],
            [
                'id' => 3,
                'name' => 'Overnight Shipping',
                'description' => 'Next business day',
                'cost' => 200.00,
                'estimated_days' => '1',
                'is_active' => true
            ],
            [
                'id' => 4,
                'name' => 'Free Shipping',
                'description' => 'Orders over $100',
                'cost' => 0.00,
                'estimated_days' => '7-10',
                'is_active' => true,
                'minimum_order' => 100.00
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $shippingMethods
        ]);
    }
}
