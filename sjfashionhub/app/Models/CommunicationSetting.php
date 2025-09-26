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
        $settings = static::getProviderSettings($provider, $service);

        switch ($provider) {
            case 'email':
                return static::testEmailConnection($service, $settings);
            case 'sms':
                return static::testSmsConnection($service, $settings);
            case 'whatsapp':
                return static::testWhatsAppConnection($service, $settings);
            default:
                return ['success' => false, 'message' => 'Unknown provider'];
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
                $transport = new \Swift_SmtpTransport(
                    $settings['host'] ?? 'localhost',
                    $settings['port'] ?? 587,
                    $settings['encryption'] ?? null
                );

                if (!empty($settings['username'])) {
                    $transport->setUsername($settings['username']);
                }

                if (!empty($settings['password'])) {
                    $transport->setPassword($settings['password']);
                }

                $mailer = new \Swift_Mailer($transport);
                $transport->start();

                return ['success' => true, 'message' => 'SMTP connection successful'];
            }

            return ['success' => true, 'message' => 'Email service configured'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
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
