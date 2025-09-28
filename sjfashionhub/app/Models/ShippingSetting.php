<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShippingSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipping_method',
        'is_enabled',
        'flat_rate',
        'free_shipping_enabled',
        'free_shipping_threshold',
        'weight_based_enabled',
        'weight_rates',
        'location_based_enabled',
        'location_rates',
        'express_shipping_enabled',
        'express_shipping_rate',
        'express_shipping_days',
        'standard_shipping_days',
        'shipping_tax_enabled',
        'shipping_tax_rate',
        'handling_fee',
        'packaging_fee',
        'cod_charges',
        'cod_enabled',
        'international_shipping_enabled',
        'international_shipping_rate',
        'shipping_zones',
        'default_weight',
        'weight_unit',
        'dimension_unit',
        'calculation_method',
        'settings_data'
    ];

    protected $casts = [
        'is_enabled' => 'boolean',
        'free_shipping_enabled' => 'boolean',
        'weight_based_enabled' => 'boolean',
        'location_based_enabled' => 'boolean',
        'express_shipping_enabled' => 'boolean',
        'shipping_tax_enabled' => 'boolean',
        'cod_enabled' => 'boolean',
        'international_shipping_enabled' => 'boolean',
        'weight_rates' => 'array',
        'location_rates' => 'array',
        'shipping_zones' => 'array',
        'settings_data' => 'array',
        'flat_rate' => 'decimal:2',
        'free_shipping_threshold' => 'decimal:2',
        'express_shipping_rate' => 'decimal:2',
        'shipping_tax_rate' => 'decimal:2',
        'handling_fee' => 'decimal:2',
        'packaging_fee' => 'decimal:2',
        'cod_charges' => 'decimal:2',
        'international_shipping_rate' => 'decimal:2',
        'default_weight' => 'decimal:2',
    ];

    /**
     * Get the shipping settings instance (singleton pattern)
     */
    public static function getSettings()
    {
        return static::first() ?? static::createDefault();
    }

    /**
     * Create default shipping settings
     */
    public static function createDefault()
    {
        return static::create([
            'shipping_method' => 'flat_rate',
            'is_enabled' => true,
            'flat_rate' => 99.00,
            'free_shipping_enabled' => false,
            'free_shipping_threshold' => 500.00,
            'weight_based_enabled' => false,
            'weight_rates' => [
                ['min_weight' => 0, 'max_weight' => 1, 'rate' => 50],
                ['min_weight' => 1, 'max_weight' => 5, 'rate' => 99],
                ['min_weight' => 5, 'max_weight' => 10, 'rate' => 149],
            ],
            'location_based_enabled' => false,
            'location_rates' => [
                ['zone' => 'metro', 'rate' => 99],
                ['zone' => 'non_metro', 'rate' => 149],
            ],
            'express_shipping_enabled' => false,
            'express_shipping_rate' => 199.00,
            'express_shipping_days' => 1,
            'standard_shipping_days' => 5,
            'shipping_tax_enabled' => false,
            'shipping_tax_rate' => 18.00,
            'handling_fee' => 0.00,
            'packaging_fee' => 0.00,
            'cod_charges' => 0.00,
            'cod_enabled' => true,
            'international_shipping_enabled' => false,
            'international_shipping_rate' => 999.00,
            'default_weight' => 0.5,
            'weight_unit' => 'kg',
            'dimension_unit' => 'cm',
            'calculation_method' => 'highest_rate',
        ]);
    }

    /**
     * Calculate shipping cost based on settings
     */
    public function calculateShipping($cartTotal, $totalWeight = null, $destination = null, $items = null)
    {
        if (!$this->is_enabled) {
            return 0;
        }

        // Check for free shipping
        if ($this->free_shipping_enabled && $cartTotal >= $this->free_shipping_threshold) {
            return 0;
        }

        $shippingCost = 0;

        switch ($this->shipping_method) {
            case 'flat_rate':
                $shippingCost = $this->flat_rate;
                break;

            case 'weight_based':
                $shippingCost = $this->calculateWeightBasedShipping($totalWeight ?? $this->default_weight);
                break;

            case 'location_based':
                $shippingCost = $this->calculateLocationBasedShipping($destination);
                break;

            case 'free':
                $shippingCost = 0;
                break;

            default:
                $shippingCost = $this->flat_rate;
        }

        // Add handling and packaging fees
        $shippingCost += $this->handling_fee + $this->packaging_fee;

        return round($shippingCost, 2);
    }

    /**
     * Calculate weight-based shipping
     */
    private function calculateWeightBasedShipping($weight)
    {
        if (!$this->weight_based_enabled || empty($this->weight_rates)) {
            return $this->flat_rate;
        }

        foreach ($this->weight_rates as $rate) {
            if ($weight >= $rate['min_weight'] && $weight <= $rate['max_weight']) {
                return $rate['rate'];
            }
        }

        // If weight exceeds all ranges, use the highest rate
        return end($this->weight_rates)['rate'];
    }

    /**
     * Calculate location-based shipping
     */
    private function calculateLocationBasedShipping($destination)
    {
        if (!$this->location_based_enabled || empty($this->location_rates) || !$destination) {
            return $this->flat_rate;
        }

        // Simple zone detection (can be enhanced)
        $zone = $this->detectShippingZone($destination);
        
        foreach ($this->location_rates as $rate) {
            if ($rate['zone'] === $zone) {
                return $rate['rate'];
            }
        }

        return $this->flat_rate;
    }

    /**
     * Detect shipping zone based on destination
     */
    private function detectShippingZone($destination)
    {
        // Simple implementation - can be enhanced with proper zone mapping
        $metroCities = ['mumbai', 'delhi', 'bangalore', 'chennai', 'kolkata', 'hyderabad', 'pune', 'ahmedabad'];
        
        if (is_array($destination) && isset($destination['city'])) {
            $city = strtolower($destination['city']);
            return in_array($city, $metroCities) ? 'metro' : 'non_metro';
        }

        return 'non_metro'; // Default to non-metro
    }

    /**
     * Get available shipping methods
     */
    public function getAvailableShippingMethods($cartTotal = 0)
    {
        $methods = [];

        // Standard shipping
        $standardCost = $this->calculateShipping($cartTotal);
        $methods[] = [
            'id' => 'standard',
            'name' => 'Standard Shipping',
            'cost' => $standardCost,
            'delivery_days' => $this->standard_shipping_days,
            'description' => "Delivery in {$this->standard_shipping_days} business days"
        ];

        // Express shipping
        if ($this->express_shipping_enabled) {
            $methods[] = [
                'id' => 'express',
                'name' => 'Express Shipping',
                'cost' => $this->express_shipping_rate,
                'delivery_days' => $this->express_shipping_days,
                'description' => "Express delivery in {$this->express_shipping_days} business day(s)"
            ];
        }

        return $methods;
    }
}
