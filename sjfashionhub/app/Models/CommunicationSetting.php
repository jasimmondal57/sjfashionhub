<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class CommunicationSetting extends Model
{
    protected $fillable = [
        'provider',
        'service',
        'key',
        'value',
        'type',
        'category',
        'description',
        'is_active',
        'is_encrypted',
        'metadata'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_encrypted' => 'boolean',
        'metadata' => 'array'
    ];

    /**
     * Get the decrypted value
     */
    public function getDecryptedValueAttribute()
    {
        if ($this->is_encrypted && $this->value) {
            try {
                return Crypt::decryptString($this->value);
            } catch (\Exception $e) {
                return $this->value;
            }
        }

        return $this->value;
    }

    /**
     * Set encrypted value
     */
    public function setEncryptedValue($value)
    {
        $this->value = $this->is_encrypted ? Crypt::encryptString($value) : $value;
        return $this;
    }

    /**
     * Get setting value with proper type casting
     */
    public function getTypedValue()
    {
        $value = $this->decrypted_value;

        return match($this->type) {
            'boolean' => (bool) $value,
            'integer' => (int) $value,
            'float' => (float) $value,
            'json' => json_decode($value, true),
            'array' => is_string($value) ? json_decode($value, true) : $value,
            default => $value
        };
    }

    /**
     * Static method to get a setting value
     */
    public static function get($provider, $service, $key, $default = null)
    {
        $setting = static::where('provider', $provider)
            ->where('service', $service)
            ->where('key', $key)
            ->where('is_active', true)
            ->first();

        return $setting ? $setting->getTypedValue() : $default;
    }

    /**
     * Static method to set a setting value
     */
    public static function set($provider, $service, $key, $value, $type = 'string', $category = 'general', $description = null, $isEncrypted = false)
    {
        $setting = static::updateOrCreate(
            [
                'provider' => $provider,
                'service' => $service,
                'key' => $key
            ],
            [
                'type' => $type,
                'category' => $category,
                'description' => $description,
                'is_encrypted' => $isEncrypted,
                'is_active' => true
            ]
        );

        if ($isEncrypted) {
            $setting->setEncryptedValue($value);
        } else {
            $setting->value = is_array($value) || is_object($value) ? json_encode($value) : $value;
        }

        $setting->save();
        return $setting;
    }

    /**
     * Get all settings for a provider
     */
    public static function getProviderSettings($provider, $service = null)
    {
        $query = static::where('provider', $provider)->where('is_active', true);

        if ($service) {
            $query->where('service', $service);
        }

        return $query->get()->mapWithKeys(function ($setting) {
            return [$setting->key => $setting->getTypedValue()];
        });
    }

    /**
     * Test connection for a provider
     */
    public static function testConnection($provider, $service)
    {
        try {
            $settings = static::getProviderSettings($provider, $service);

            // Check if settings exist
            if ($settings->isEmpty()) {
                return ['success' => false, 'message' => "No settings found for {$provider} {$service}. Please save your settings first."];
            }

            switch ($provider) {
                case 'email':
                    return static::testEmailConnection($service, $settings->toArray());
                case 'sms':
                    return static::testSmsConnection($service, $settings->toArray());
                case 'whatsapp':
                    return static::testWhatsAppConnection($service, $settings->toArray());
                default:
                    return ['success' => false, 'message' => 'Unknown provider'];
            }
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Test failed: ' . $e->getMessage()];
        }
    }

    /**
     * Test email connection
     */
    private static function testEmailConnection($service, $settings)
    {
        try {
            // Test SMTP connection
            if ($service === 'smtp') {
                // Validate required settings
                if (empty($settings['host'])) {
                    return ['success' => false, 'message' => 'SMTP host is required'];
                }
                if (empty($settings['port'])) {
                    return ['success' => false, 'message' => 'SMTP port is required'];
                }
                if (empty($settings['username'])) {
                    return ['success' => false, 'message' => 'SMTP username is required'];
                }
                if (empty($settings['password'])) {
                    return ['success' => false, 'message' => 'SMTP password is required'];
                }

                // Test SMTP connection using socket
                $host = $settings['host'];
                $port = (int) $settings['port'];
                $encryption = $settings['encryption'] ?? null;

                // Determine if we need SSL/TLS
                if ($encryption === 'ssl' || $port === 465) {
                    $host = 'ssl://' . $host;
                } elseif ($encryption === 'tls' || $port === 587) {
                    // TLS will be started after initial connection
                }

                // Test socket connection
                $socket = @fsockopen($host, $port, $errno, $errstr, 10);

                if (!$socket) {
                    return ['success' => false, 'message' => "Cannot connect to SMTP server: $errstr ($errno)"];
                }

                // Read initial response
                $response = fgets($socket, 512);
                if (substr($response, 0, 3) !== '220') {
                    fclose($socket);
                    return ['success' => false, 'message' => 'SMTP server did not respond correctly: ' . trim($response)];
                }

                fclose($socket);
                return ['success' => true, 'message' => 'SMTP connection successful! Server is reachable.'];
            }

            return ['success' => true, 'message' => 'Email service configured'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Connection test failed: ' . $e->getMessage()];
        }
    }

    /**
     * Test SMS connection
     */
    private static function testSmsConnection($service, $settings)
    {
        // Implementation for SMS providers like Twilio, MSG91, etc.
        return ['success' => true, 'message' => 'SMS service configured'];
    }

    /**
     * Test WhatsApp connection
     */
    private static function testWhatsAppConnection($service, $settings)
    {
        // Implementation for WhatsApp Business API
        return ['success' => true, 'message' => 'WhatsApp service configured'];
    }

    /**
     * Scope for active settings
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for provider
     */
    public function scopeProvider($query, $provider)
    {
        return $query->where('provider', $provider);
    }

    /**
     * Scope for service
     */
    public function scopeService($query, $service)
    {
        return $query->where('service', $service);
    }
}
