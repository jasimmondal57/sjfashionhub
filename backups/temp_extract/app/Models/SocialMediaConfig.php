<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class SocialMediaConfig extends Model
{
    protected $fillable = [
        'platform',
        'name',
        'description',
        'is_active',
        'credentials',
        'settings',
        'webhook_url',
        'last_connected_at',
        'connection_status',
        'rate_limits',
    ];

    // Auto-generate name if not provided
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($config) {
            if (empty($config->name)) {
                $platformNames = [
                    'instagram' => 'Instagram',
                    'facebook' => 'Facebook',
                    'twitter' => 'Twitter/X',
                    'linkedin' => 'LinkedIn',
                    'pinterest' => 'Pinterest',
                    'tiktok' => 'TikTok',
                    'threads' => 'Threads',
                ];

                $config->name = $platformNames[$config->platform] ?? ucfirst($config->platform);
            }
        });
    }

    protected $casts = [
        'is_active' => 'boolean',
        'credentials' => 'array',
        'settings' => 'array',
        'rate_limits' => 'array',
        'last_connected_at' => 'datetime',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForPlatform($query, $platform)
    {
        return $query->where('platform', $platform);
    }

    // Accessors & Mutators
    public function setCredentialsAttribute($value)
    {
        $this->attributes['credentials'] = $value ? Crypt::encryptString(json_encode($value)) : null;
    }

    public function getCredentialsAttribute($value)
    {
        if (!$value) return null;

        try {
            return json_decode(Crypt::decryptString($value), true);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getStatusBadgeAttribute()
    {
        if (!$this->is_active) {
            return '<span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">Inactive</span>';
        }

        if ($this->connection_status === 'connected') {
            return '<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Connected</span>';
        }

        return '<span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Disconnected</span>';
    }

    public function getPlatformIconAttribute()
    {
        return match($this->platform) {
            'instagram' => '📷',
            'facebook' => '📘',
            'twitter' => '🐦',
            'linkedin' => '💼',
            'pinterest' => '📌',
            'tiktok' => '🎵',
            'threads' => '🧵',
            default => '📱',
        };
    }

    // Helper methods
    public function isConnected(): bool
    {
        return $this->is_active && $this->connection_status === 'connected';
    }

    public function getCredential(string $key): ?string
    {
        $credentials = $this->credentials;
        return $credentials[$key] ?? null;
    }

    public function getSetting(string $key, $default = null)
    {
        $settings = $this->settings ?? [];
        return $settings[$key] ?? $default;
    }
}
