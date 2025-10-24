<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class AbandonedCart extends Model
{
    protected $fillable = [
        'session_id',
        'user_id',
        'email',
        'phone',
        'first_name',
        'last_name',
        'cart_items',
        'cart_total',
        'cart_subtotal',
        'cart_tax',
        'cart_shipping',
        'items_count',
        'currency',
        'status',
        'abandoned_at',
        'last_activity_at',
        'recovered_at',
        'expires_at',
        'recovery_token',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'browser_info',
        'ip_address',
        'country',
        'city',
        'is_guest',
        'email_sent',
        'email_count',
        'last_email_sent_at',
        'coupon_codes',
        'notes'
    ];

    protected $casts = [
        'cart_items' => 'array',
        'browser_info' => 'array',
        'coupon_codes' => 'array',
        'is_guest' => 'boolean',
        'email_sent' => 'boolean',
        'abandoned_at' => 'datetime',
        'last_activity_at' => 'datetime',
        'recovered_at' => 'datetime',
        'expires_at' => 'datetime',
        'last_email_sent_at' => 'datetime',
        'cart_total' => 'decimal:2',
        'cart_subtotal' => 'decimal:2',
        'cart_tax' => 'decimal:2',
        'cart_shipping' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->recovery_token)) {
                $model->recovery_token = Str::random(64);
            }
        });
    }

    /**
     * Get the user that owns the abandoned cart
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the emails sent for this abandoned cart
     */
    public function emails(): HasMany
    {
        return $this->hasMany(AbandonedCartEmail::class);
    }

    /**
     * Scope for abandoned carts
     */
    public function scopeAbandoned($query)
    {
        return $query->where('status', 'abandoned');
    }

    /**
     * Scope for recovered carts
     */
    public function scopeRecovered($query)
    {
        return $query->where('status', 'recovered');
    }

    /**
     * Scope for expired carts
     */
    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    /**
     * Scope for carts that need email reminders
     */
    public function scopeNeedsReminder($query)
    {
        return $query->where('status', 'abandoned')
            ->where('email_sent', false)
            ->where('abandoned_at', '<=', now()->subHours(1));
    }

    /**
     * Scope for guest carts
     */
    public function scopeGuest($query)
    {
        return $query->where('is_guest', true);
    }

    /**
     * Scope for registered user carts
     */
    public function scopeRegistered($query)
    {
        return $query->where('is_guest', false);
    }

    /**
     * Get the customer name
     */
    public function getCustomerNameAttribute()
    {
        if ($this->user) {
            return $this->user->name;
        }

        return trim($this->first_name . ' ' . $this->last_name) ?: 'Guest Customer';
    }

    /**
     * Get the customer email
     */
    public function getCustomerEmailAttribute()
    {
        return $this->user?->email ?? $this->email;
    }

    /**
     * Get the recovery URL
     */
    public function getRecoveryUrlAttribute()
    {
        return route('cart.recover', $this->recovery_token);
    }

    /**
     * Get formatted cart total
     */
    public function getFormattedTotalAttribute()
    {
        return '₹' . number_format($this->cart_total, 2);
    }

    /**
     * Get time since abandoned
     */
    public function getTimeSinceAbandonedAttribute()
    {
        return $this->abandoned_at->diffForHumans();
    }

    /**
     * Check if cart is recoverable
     */
    public function isRecoverable()
    {
        return $this->status === 'abandoned' &&
               $this->expires_at > now() &&
               !empty($this->cart_items);
    }

    /**
     * Mark cart as recovered
     */
    public function markAsRecovered()
    {
        $this->update([
            'status' => 'recovered',
            'recovered_at' => now()
        ]);
    }

    /**
     * Mark cart as expired
     */
    public function markAsExpired()
    {
        $this->update([
            'status' => 'expired'
        ]);
    }

    /**
     * Get cart items with product details
     */
    public function getCartItemsWithDetailsAttribute()
    {
        $items = [];

        foreach ($this->cart_items as $item) {
            $product = Product::find($item['product_id'] ?? null);

            $items[] = [
                'product_id' => $item['product_id'] ?? null,
                'product' => $product,
                'name' => $item['name'] ?? $product?->name ?? 'Unknown Product',
                'price' => $item['price'] ?? 0,
                'quantity' => $item['quantity'] ?? 1,
                'total' => ($item['price'] ?? 0) * ($item['quantity'] ?? 1),
                'image' => $item['image'] ?? $product?->featured_image ?? null,
                'sku' => $item['sku'] ?? $product?->sku ?? null,
                'variant' => $item['variant'] ?? null,
            ];
        }

        return $items;
    }

    /**
     * Calculate recovery rate
     */
    public static function getRecoveryRate($days = 30)
    {
        $total = static::where('created_at', '>=', now()->subDays($days))->count();
        $recovered = static::where('created_at', '>=', now()->subDays($days))
            ->where('status', 'recovered')->count();

        return $total > 0 ? round(($recovered / $total) * 100, 2) : 0;
    }

    /**
     * Get total revenue lost
     */
    public static function getTotalRevenueLost($days = 30)
    {
        return static::where('created_at', '>=', now()->subDays($days))
            ->where('status', 'abandoned')
            ->sum('cart_total');
    }

    /**
     * Get total revenue recovered
     */
    public static function getTotalRevenueRecovered($days = 30)
    {
        return static::where('created_at', '>=', now()->subDays($days))
            ->where('status', 'recovered')
            ->sum('cart_total');
    }
}
