<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'minimum_amount',
        'maximum_discount',
        'usage_limit',
        'usage_limit_per_customer',
        'used_count',
        'starts_at',
        'expires_at',
        'applicable_products',
        'applicable_categories',
        'excluded_products',
        'excluded_categories',
        'applicable_customers',
        'first_order_only',
        'is_active',
        'is_public',
        'priority',
        'stackable',
        'created_by',
        'last_used_at'
    ];

    protected $casts = [
        'applicable_products' => 'array',
        'applicable_categories' => 'array',
        'excluded_products' => 'array',
        'excluded_categories' => 'array',
        'applicable_customers' => 'array',
        'first_order_only' => 'boolean',
        'is_active' => 'boolean',
        'is_public' => 'boolean',
        'stackable' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'last_used_at' => 'datetime',
        'value' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        $now = Carbon::now();
        return $query->where('is_active', true)
                    ->where(function ($q) use ($now) {
                        $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
                    })
                    ->where(function ($q) use ($now) {
                        $q->whereNull('expires_at')->orWhere('expires_at', '>=', $now);
                    });
    }

    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    // Relationships
    public function products()
    {
        if ($this->applicable_products) {
            return Product::whereIn('id', $this->applicable_products);
        }
        return collect();
    }

    public function categories()
    {
        if ($this->applicable_categories) {
            return Category::whereIn('id', $this->applicable_categories);
        }
        return collect();
    }

    // Helper Methods
    public function isValid()
    {
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();

        // Check start date
        if ($this->starts_at && $this->starts_at->gt($now)) {
            return false;
        }

        // Check expiry date
        if ($this->expires_at && $this->expires_at->lt($now)) {
            return false;
        }

        // Check usage limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    public function canBeUsedBy($customerId = null, $orderAmount = 0)
    {
        if (!$this->isValid()) {
            return false;
        }

        // Check minimum amount
        if ($this->minimum_amount && $orderAmount < $this->minimum_amount) {
            return false;
        }

        // Check customer restrictions
        if ($this->applicable_customers && $customerId) {
            if (!in_array($customerId, $this->applicable_customers)) {
                return false;
            }
        }

        return true;
    }

    public function calculateDiscount($orderAmount, $shippingCost = 0)
    {
        if (!$this->canBeUsedBy(null, $orderAmount)) {
            return 0;
        }

        $discount = 0;

        switch ($this->type) {
            case 'percentage':
                $discount = ($orderAmount * $this->value) / 100;
                if ($this->maximum_discount) {
                    $discount = min($discount, $this->maximum_discount);
                }
                break;

            case 'fixed_amount':
                $discount = min($this->value, $orderAmount);
                break;

            case 'free_shipping':
                $discount = $shippingCost;
                break;
        }

        return round($discount, 2);
    }

    public function incrementUsage()
    {
        $this->increment('used_count');
        $this->update(['last_used_at' => Carbon::now()]);
    }

    public function getStatusAttribute()
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        $now = Carbon::now();

        if ($this->starts_at && $this->starts_at->gt($now)) {
            return 'scheduled';
        }

        if ($this->expires_at && $this->expires_at->lt($now)) {
            return 'expired';
        }

        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return 'exhausted';
        }

        return 'active';
    }

    public function getUsagePercentageAttribute()
    {
        if (!$this->usage_limit) {
            return 0;
        }

        return round(($this->used_count / $this->usage_limit) * 100, 1);
    }

    public function getFormattedValueAttribute()
    {
        switch ($this->type) {
            case 'percentage':
                return $this->value . '%';
            case 'fixed_amount':
                return '₹' . number_format($this->value, 2);
            case 'free_shipping':
                return 'Free Shipping';
            default:
                return $this->value;
        }
    }
}
