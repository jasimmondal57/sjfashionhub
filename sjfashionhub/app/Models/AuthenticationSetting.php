<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthenticationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'method',
        'enabled',
        'settings',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'settings' => 'array',
    ];

    /**
     * Get enabled authentication methods
     */
    public static function enabledMethods()
    {
        return self::where('enabled', true)->get();
    }

    /**
     * Check if a method is enabled
     */
    public static function isMethodEnabled($method)
    {
        return self::where('method', $method)->where('enabled', true)->exists();
    }

    /**
     * Get method configuration
     */
    public static function getMethodConfig($method)
    {
        return self::where('method', $method)->first();
    }

    /**
     * Get method display name
     */
    public function getDisplayNameAttribute()
    {
        return match($this->method) {
            'email' => 'Email & Password',
            'mobile_sms' => 'Mobile SMS OTP',
            'mobile_whatsapp' => 'WhatsApp OTP',
            default => ucfirst(str_replace('_', ' ', $this->method)),
        };
    }

    /**
     * Get method icon
     */
    public function getIconAttribute()
    {
        return match($this->method) {
            'email' => '📧',
            'mobile_sms' => '📱',
            'mobile_whatsapp' => '💬',
            default => '🔐',
        };
    }

    /**
     * Get method color
     */
    public function getColorAttribute()
    {
        return match($this->method) {
            'email' => '#3B82F6',
            'mobile_sms' => '#10B981',
            'mobile_whatsapp' => '#25D366',
            default => '#6B7280',
        };
    }

    /**
     * Get setting value
     */
    public function getSetting($key, $default = null)
    {
        return $this->settings[$key] ?? $default;
    }

    /**
     * Set setting value
     */
    public function setSetting($key, $value)
    {
        $settings = $this->settings ?? [];
        $settings[$key] = $value;
        $this->settings = $settings;
        return $this;
    }
}
