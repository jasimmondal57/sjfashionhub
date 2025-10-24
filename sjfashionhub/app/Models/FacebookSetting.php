<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookSetting extends Model
{
    protected $fillable = [
        'pixel_id',
        'pixel_enabled',
        'access_token',
        'catalog_id',
        'catalog_sync_enabled',
        'business_id',
        'app_id',
        'app_secret',
        'auto_sync_enabled',
        'auto_sync_inventory',
        'auto_sync_prices',
        'sync_frequency_hours',
        'last_sync_at',
        'sync_settings',
        'event_tracking',
    ];

    protected $casts = [
        'pixel_enabled' => 'boolean',
        'catalog_sync_enabled' => 'boolean',
        'auto_sync_enabled' => 'boolean',
        'auto_sync_inventory' => 'boolean',
        'auto_sync_prices' => 'boolean',
        'sync_frequency_hours' => 'integer',
        'last_sync_at' => 'datetime',
        'sync_settings' => 'array',
        'event_tracking' => 'array',
    ];

    /**
     * Get the singleton instance
     */
    public static function getInstance()
    {
        return static::firstOrCreate([]);
    }

    /**
     * Check if pixel is configured
     */
    public function isPixelConfigured()
    {
        return !empty($this->pixel_id) && $this->pixel_enabled;
    }

    /**
     * Check if catalog sync is configured
     */
    public function isCatalogConfigured()
    {
        return !empty($this->catalog_id) 
            && !empty($this->access_token) 
            && $this->catalog_sync_enabled;
    }

    /**
     * Check if sync is needed
     */
    public function needsSync()
    {
        if (!$this->isCatalogConfigured()) {
            return false;
        }

        if (!$this->last_sync_at) {
            return true;
        }

        $hoursSinceLastSync = now()->diffInHours($this->last_sync_at);
        return $hoursSinceLastSync >= $this->sync_frequency_hours;
    }

    /**
     * Get default event tracking settings
     */
    public static function getDefaultEventTracking()
    {
        return [
            'PageView' => true,
            'ViewContent' => true,
            'AddToCart' => true,
            'InitiateCheckout' => true,
            'Purchase' => true,
            'Search' => true,
            'AddToWishlist' => true,
        ];
    }
}

