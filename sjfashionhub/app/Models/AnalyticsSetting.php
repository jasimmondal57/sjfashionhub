<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalyticsSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'google_analytics_id',
        'google_tag_manager_id',
        'facebook_pixel_id',
        'google_analytics_enabled',
        'google_tag_manager_enabled',
        'facebook_pixel_enabled',
    ];

    protected $casts = [
        'google_analytics_enabled' => 'boolean',
        'google_tag_manager_enabled' => 'boolean',
        'facebook_pixel_enabled' => 'boolean',
    ];

    /**
     * Get the analytics settings instance (singleton pattern)
     */
    public static function getSettings()
    {
        return static::first() ?? new static();
    }

    /**
     * Check if Google Analytics is enabled and configured
     */
    public function isGoogleAnalyticsActive()
    {
        return $this->google_analytics_enabled && !empty($this->google_analytics_id);
    }

    /**
     * Check if Google Tag Manager is enabled and configured
     */
    public function isGoogleTagManagerActive()
    {
        return $this->google_tag_manager_enabled && !empty($this->google_tag_manager_id);
    }

    /**
     * Check if Facebook Pixel is enabled and configured
     */
    public function isFacebookPixelActive()
    {
        return $this->facebook_pixel_enabled && !empty($this->facebook_pixel_id);
    }
}
