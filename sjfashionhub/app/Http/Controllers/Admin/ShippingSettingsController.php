<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShippingSettingsController extends Controller
{
    /**
     * Display shipping settings
     */
    public function index()
    {
        $settings = ShippingSetting::getSettings();
        
        return view('admin.shipping-settings.index', compact('settings'));
    }

    /**
     * Update shipping settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'shipping_method' => 'required|in:flat_rate,weight_based,location_based,free',
            'is_enabled' => 'boolean',
            'flat_rate' => 'required|numeric|min:0',
            'free_shipping_enabled' => 'boolean',
            'free_shipping_threshold' => 'required|numeric|min:0',
            'weight_based_enabled' => 'boolean',
            'location_based_enabled' => 'boolean',
            'express_shipping_enabled' => 'boolean',
            'express_shipping_rate' => 'required|numeric|min:0',
            'express_shipping_days' => 'required|integer|min:1|max:30',
            'standard_shipping_days' => 'required|integer|min:1|max:30',
            'shipping_tax_enabled' => 'boolean',
            'shipping_tax_rate' => 'required|numeric|min:0|max:100',
            'handling_fee' => 'required|numeric|min:0',
            'packaging_fee' => 'required|numeric|min:0',
            'cod_charges' => 'required|numeric|min:0',
            'cod_enabled' => 'boolean',
            'international_shipping_enabled' => 'boolean',
            'international_shipping_rate' => 'required|numeric|min:0',
            'default_weight' => 'required|numeric|min:0.1',
            'weight_unit' => 'required|in:kg,g,lb,oz',
            'dimension_unit' => 'required|in:cm,m,in,ft',
            'calculation_method' => 'required|in:highest_rate,sum_rates,average_rate',
        ]);

        try {
            $settings = ShippingSetting::getSettings();

            // Process weight rates
            $weightRates = [];
            if ($request->has('weight_rates')) {
                foreach ($request->weight_rates as $rate) {
                    if (!empty($rate['min_weight']) && !empty($rate['max_weight']) && !empty($rate['rate'])) {
                        $weightRates[] = [
                            'min_weight' => (float) $rate['min_weight'],
                            'max_weight' => (float) $rate['max_weight'],
                            'rate' => (float) $rate['rate'],
                        ];
                    }
                }
            }

            // Process location rates
            $locationRates = [];
            if ($request->has('location_rates')) {
                foreach ($request->location_rates as $rate) {
                    if (!empty($rate['zone']) && !empty($rate['rate'])) {
                        $locationRates[] = [
                            'zone' => $rate['zone'],
                            'rate' => (float) $rate['rate'],
                            'description' => $rate['description'] ?? '',
                        ];
                    }
                }
            }

            // Update settings
            $settings->update([
                'shipping_method' => $request->shipping_method,
                'is_enabled' => $request->has('is_enabled'),
                'flat_rate' => $request->flat_rate,
                'free_shipping_enabled' => $request->has('free_shipping_enabled'),
                'free_shipping_threshold' => $request->free_shipping_threshold,
                'weight_based_enabled' => $request->has('weight_based_enabled'),
                'weight_rates' => $weightRates,
                'location_based_enabled' => $request->has('location_based_enabled'),
                'location_rates' => $locationRates,
                'express_shipping_enabled' => $request->has('express_shipping_enabled'),
                'express_shipping_rate' => $request->express_shipping_rate,
                'express_shipping_days' => $request->express_shipping_days,
                'standard_shipping_days' => $request->standard_shipping_days,
                'shipping_tax_enabled' => $request->has('shipping_tax_enabled'),
                'shipping_tax_rate' => $request->shipping_tax_rate,
                'handling_fee' => $request->handling_fee,
                'packaging_fee' => $request->packaging_fee,
                'cod_charges' => $request->cod_charges,
                'cod_enabled' => $request->has('cod_enabled'),
                'international_shipping_enabled' => $request->has('international_shipping_enabled'),
                'international_shipping_rate' => $request->international_shipping_rate,
                'default_weight' => $request->default_weight,
                'weight_unit' => $request->weight_unit,
                'dimension_unit' => $request->dimension_unit,
                'calculation_method' => $request->calculation_method,
            ]);

            return redirect()->route('admin.shipping-settings.index')
                ->with('success', 'Shipping settings updated successfully!');

        } catch (\Exception $e) {
            Log::error('Failed to update shipping settings: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Failed to update shipping settings: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Test shipping calculation
     */
    public function testCalculation(Request $request)
    {
        $request->validate([
            'cart_total' => 'required|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'destination_city' => 'nullable|string',
        ]);

        try {
            $settings = ShippingSetting::getSettings();
            
            $destination = null;
            if ($request->destination_city) {
                $destination = ['city' => $request->destination_city];
            }

            $shippingCost = $settings->calculateShipping(
                $request->cart_total,
                $request->weight,
                $destination
            );

            $availableMethods = $settings->getAvailableShippingMethods($request->cart_total);

            return response()->json([
                'success' => true,
                'shipping_cost' => $shippingCost,
                'available_methods' => $availableMethods,
                'settings_used' => [
                    'method' => $settings->shipping_method,
                    'free_shipping_threshold' => $settings->free_shipping_threshold,
                    'free_shipping_enabled' => $settings->free_shipping_enabled,
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate shipping: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reset shipping settings to default
     */
    public function reset()
    {
        try {
            $settings = ShippingSetting::getSettings();
            $settings->delete();
            
            // Create new default settings
            ShippingSetting::createDefault();

            return redirect()->route('admin.shipping-settings.index')
                ->with('success', 'Shipping settings reset to default values!');

        } catch (\Exception $e) {
            Log::error('Failed to reset shipping settings: ' . $e->getMessage());
            
            return redirect()->back()
                ->with('error', 'Failed to reset shipping settings: ' . $e->getMessage());
        }
    }

    /**
     * Export shipping settings
     */
    public function export()
    {
        try {
            $settings = ShippingSetting::getSettings();
            
            $exportData = $settings->toArray();
            unset($exportData['id'], $exportData['created_at'], $exportData['updated_at']);

            $filename = 'shipping_settings_' . date('Y-m-d_H-i-s') . '.json';
            
            return response()->json($exportData)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                ->header('Content-Type', 'application/json');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to export shipping settings: ' . $e->getMessage());
        }
    }

    /**
     * Import shipping settings
     */
    public function import(Request $request)
    {
        $request->validate([
            'settings_file' => 'required|file|mimes:json|max:2048'
        ]);

        try {
            $file = $request->file('settings_file');
            $content = file_get_contents($file->getPathname());
            $importData = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON file');
            }

            $settings = ShippingSetting::getSettings();
            $settings->update($importData);

            return redirect()->route('admin.shipping-settings.index')
                ->with('success', 'Shipping settings imported successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to import shipping settings: ' . $e->getMessage());
        }
    }
}
