<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class ShiprocketSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'encrypted_value',
        'type',
        'group',
        'description',
        'is_encrypted',
        'is_active'
    ];

    protected $casts = [
        'is_encrypted' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the decrypted value if encrypted, otherwise return the plain value
     */
    public function getDecryptedValueAttribute()
    {
        if ($this->is_encrypted && $this->encrypted_value) {
            try {
                return Crypt::decryptString($this->encrypted_value);
            } catch (\Exception $e) {
                return null;
            }
        }

        return $this->value;
    }

    /**
     * Set the value, encrypting if necessary
     */
    public function setValueAttribute($value)
    {
        if ($this->is_encrypted) {
            $this->attributes['encrypted_value'] = Crypt::encryptString($value);
            $this->attributes['value'] = null;
        } else {
            $this->attributes['value'] = $value;
            $this->attributes['encrypted_value'] = null;
        }
    }

    /**
     * Get setting by key
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->where('is_active', true)->first();

        if (!$setting) {
            return $default;
        }

        return $setting->decrypted_value ?? $default;
    }

    /**
     * Set setting by key
     */
    public static function set($key, $value, $type = 'text', $group = 'general', $description = null, $isEncrypted = false)
    {
        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'description' => $description,
                'is_encrypted' => $isEncrypted,
                'is_active' => true
            ]
        );
    }

    /**
     * Get all settings by group
     */
    public static function getByGroup($group)
    {
        return static::where('group', $group)
            ->where('is_active', true)
            ->get()
            ->mapWithKeys(function ($setting) {
                return [$setting->key => $setting->decrypted_value];
            });
    }

    /**
     * Get all Shiprocket API credentials
     */
    public static function getApiCredentials()
    {
        return [
            'email' => static::get('shiprocket_email'),
            'password' => static::get('shiprocket_password'),
            'api_token' => static::get('shiprocket_api_token'),
            'base_url' => static::get('shiprocket_base_url', 'https://apiv2.shiprocket.in/v1/external'),
            'is_sandbox' => static::get('shiprocket_is_sandbox', false),
        ];
    }

    /**
     * Get pickup address settings
     */
    public static function getPickupAddress()
    {
        return [
            'pickup_location' => static::get('shiprocket_pickup_location'),
            'name' => static::get('shiprocket_pickup_name'),
            'email' => static::get('shiprocket_pickup_email'),
            'phone' => static::get('shiprocket_pickup_phone'),
            'address' => static::get('shiprocket_pickup_address'),
            'address_2' => static::get('shiprocket_pickup_address_2'),
            'city' => static::get('shiprocket_pickup_city'),
            'state' => static::get('shiprocket_pickup_state'),
            'country' => static::get('shiprocket_pickup_country', 'India'),
            'pin_code' => static::get('shiprocket_pickup_pin_code'),
        ];
    }

    /**
     * Check if Shiprocket is properly configured
     */
    public static function isConfigured()
    {
        $email = static::get('shiprocket_email');
        $password = static::get('shiprocket_password');
        $pickupLocation = static::get('shiprocket_pickup_location');

        return !empty($email) && !empty($password) && !empty($pickupLocation);
    }
}
