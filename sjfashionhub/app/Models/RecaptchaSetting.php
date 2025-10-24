<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecaptchaSetting extends Model
{
    protected $table = 'recaptcha_settings';

    protected $fillable = [
        'enabled',
        'site_key',
        'secret_key',
        'threshold',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'threshold' => 'float',
    ];

    /**
     * Get the current reCAPTCHA settings (singleton pattern)
     */
    public static function getCurrent()
    {
        return self::first() ?? self::create([
            'enabled' => false,
            'site_key' => null,
            'secret_key' => null,
            'threshold' => 0.5,
        ]);
    }

    /**
     * Check if reCAPTCHA is enabled
     */
    public static function isEnabled()
    {
        return self::getCurrent()->enabled && !empty(self::getCurrent()->site_key);
    }

    /**
     * Get site key
     */
    public static function getSiteKey()
    {
        return self::getCurrent()->site_key;
    }

    /**
     * Get secret key
     */
    public static function getSecretKey()
    {
        return self::getCurrent()->secret_key;
    }

    /**
     * Get threshold
     */
    public static function getThreshold()
    {
        return self::getCurrent()->threshold;
    }
}

