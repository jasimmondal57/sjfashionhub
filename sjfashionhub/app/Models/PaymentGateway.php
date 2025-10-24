<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Crypt;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'display_name',
        'type',
        'description',
        'credentials',
        'settings',
        'is_active',
        'is_test_mode',
        'min_amount',
        'max_amount',
        'transaction_fee',
        'fixed_fee',
        'currency',
        'supported_currencies',
        'logo_url',
        'sort_order'
    ];

    protected $casts = [
        'credentials' => 'array',
        'settings' => 'array',
        'supported_currencies' => 'array',
        'is_active' => 'boolean',
        'is_test_mode' => 'boolean',
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'transaction_fee' => 'decimal:4',
        'fixed_fee' => 'decimal:2'
    ];

    /**
     * Relationships
     */
    public function transactions()
    {
        return $this->hasMany(PaymentTransaction::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOnline($query)
    {
        return $query->where('type', 'online');
    }

    public function scopeOffline($query)
    {
        return $query->where('type', 'offline');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('display_name');
    }

    /**
     * Accessors & Mutators
     */
    public function getDecryptedCredentialsAttribute()
    {
        if (!$this->credentials) {
            return [];
        }

        $decrypted = [];
        foreach ($this->credentials as $key => $value) {
            try {
                $decrypted[$key] = is_string($value) && $value ? Crypt::decryptString($value) : $value;
            } catch (\Exception $e) {
                $decrypted[$key] = $value; // Return as-is if decryption fails
            }
        }
        return $decrypted;
    }

    public function setCredentialsAttribute($value)
    {
        if (!is_array($value)) {
            $this->attributes['credentials'] = $value;
            return;
        }

        $encrypted = [];
        foreach ($value as $key => $val) {
            if (in_array($key, $this->getEncryptedFields()) && $val) {
                $encrypted[$key] = Crypt::encryptString($val);
            } else {
                $encrypted[$key] = $val;
            }
        }
        $this->attributes['credentials'] = json_encode($encrypted);
    }

    /**
     * Get fields that should be encrypted
     */
    protected function getEncryptedFields()
    {
        $encryptedFields = [
            'razorpay' => ['key_id', 'key_secret', 'webhook_secret'],
            'cashfree' => ['app_id', 'secret_key', 'webhook_secret'],
            'payu' => ['merchant_key', 'merchant_salt'],
            'paytm' => ['merchant_id', 'merchant_key'],
            'paypal' => ['client_id', 'client_secret'],
        ];

        return $encryptedFields[$this->name] ?? [];
    }

    /**
     * Static methods for gateway management
     */
    public static function getActiveGateways()
    {
        return static::active()->ordered()->get();
    }

    public static function getOnlineGateways()
    {
        return static::active()->online()->ordered()->get();
    }

    public static function getOfflineGateways()
    {
        return static::active()->offline()->ordered()->get();
    }

    /**
     * Check if gateway supports amount
     */
    public function supportsAmount($amount)
    {
        if ($amount < $this->min_amount) {
            return false;
        }

        if ($this->max_amount && $amount > $this->max_amount) {
            return false;
        }

        return true;
    }

    /**
     * Calculate total fee for amount
     */
    public function calculateFee($amount)
    {
        $percentageFee = ($amount * $this->transaction_fee) / 100;
        return $percentageFee + $this->fixed_fee;
    }

    /**
     * Get gateway configuration
     */
    public function getConfig()
    {
        $credentials = $this->getDecryptedCredentialsAttribute();

        return [
            'name' => $this->name,
            'display_name' => $this->display_name,
            'is_test_mode' => $this->is_test_mode,
            'credentials' => $credentials,
            'settings' => $this->settings ?? []
        ];
    }

    /**
     * Create default gateways
     */
    public static function createDefaults()
    {
        $gateways = [
            [
                'name' => 'razorpay',
                'display_name' => 'Razorpay',
                'type' => 'online',
                'description' => 'Accept payments via Razorpay - Cards, Net Banking, UPI, Wallets',
                'transaction_fee' => 2.00,
                'currency' => 'INR',
                'supported_currencies' => ['INR', 'USD'],
                'sort_order' => 1
            ],
            [
                'name' => 'cashfree',
                'display_name' => 'Cashfree',
                'type' => 'online',
                'description' => 'Accept payments via Cashfree - Cards, Net Banking, UPI, Wallets',
                'transaction_fee' => 1.95,
                'currency' => 'INR',
                'supported_currencies' => ['INR'],
                'sort_order' => 2
            ],
            [
                'name' => 'payu',
                'display_name' => 'PayU',
                'type' => 'online',
                'description' => 'Accept payments via PayU - Cards, Net Banking, UPI, Wallets',
                'transaction_fee' => 2.40,
                'currency' => 'INR',
                'supported_currencies' => ['INR'],
                'sort_order' => 3
            ],
            [
                'name' => 'paytm',
                'display_name' => 'Paytm',
                'type' => 'online',
                'description' => 'Accept payments via Paytm - Wallet, Cards, Net Banking, UPI',
                'transaction_fee' => 1.99,
                'currency' => 'INR',
                'supported_currencies' => ['INR'],
                'sort_order' => 4
            ],
            [
                'name' => 'paypal',
                'display_name' => 'PayPal',
                'type' => 'online',
                'description' => 'Accept international payments via PayPal',
                'transaction_fee' => 3.49,
                'fixed_fee' => 0.49,
                'currency' => 'USD',
                'supported_currencies' => ['USD', 'EUR', 'GBP', 'INR'],
                'sort_order' => 5
            ],
            [
                'name' => 'cod',
                'display_name' => 'Cash on Delivery',
                'type' => 'offline',
                'description' => 'Pay cash when your order is delivered',
                'transaction_fee' => 0,
                'currency' => 'INR',
                'supported_currencies' => ['INR'],
                'is_active' => true,
                'sort_order' => 6
            ]
        ];

        foreach ($gateways as $gateway) {
            static::updateOrCreate(
                ['name' => $gateway['name']],
                $gateway
            );
        }
    }
}
