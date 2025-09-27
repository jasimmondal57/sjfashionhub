<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class SocialLoginSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider',
        'enabled',
        'client_id',
        'client_secret',
        'redirect_uri',
        'additional_settings',
    ];

    protected $casts = [
        'enabled' => 'boolean',
        'additional_settings' => 'array',
    ];

    /**
     * Get the client_id attribute (decrypt if needed)
     */
    protected function clientId(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? decrypt($value) : null,
            set: fn ($value) => $value ? encrypt($value) : null,
        );
    }

    /**
     * Get the client_secret attribute (decrypt if needed)
     */
    protected function clientSecret(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? decrypt($value) : null,
            set: fn ($value) => $value ? encrypt($value) : null,
        );
    }

    /**
     * Get enabled providers
     */
    public static function enabledProviders()
    {
        return self::where('enabled', true)->get();
    }

    /**
     * Check if a provider is enabled
     */
    public static function isProviderEnabled($provider)
    {
        return self::where('provider', $provider)->where('enabled', true)->exists();
    }

    /**
     * Get provider configuration
     */
    public static function getProviderConfig($provider)
    {
        return self::where('provider', $provider)->first();
    }

    /**
     * Get provider display name
     */
    public function getDisplayNameAttribute()
    {
        return match($this->provider) {
            'google' => 'Google',
            'facebook' => 'Facebook',
            'twitter' => 'Twitter/X',
            'linkedin' => 'LinkedIn',
            'github' => 'GitHub',
            default => ucfirst($this->provider),
        };
    }

    /**
     * Get provider icon
     */
    public function getIconAttribute()
    {
        return match($this->provider) {
            'google' => '🔍',
            'facebook' => '📘',
            'twitter' => '🐦',
            'linkedin' => '💼',
            'github' => '🐙',
            default => '🔗',
        };
    }

    /**
     * Get provider color
     */
    public function getColorAttribute()
    {
        return match($this->provider) {
            'google' => '#4285F4',
            'facebook' => '#1877F2',
            'twitter' => '#1DA1F2',
            'linkedin' => '#0A66C2',
            'github' => '#333333',
            default => '#6B7280',
        };
    }
}
