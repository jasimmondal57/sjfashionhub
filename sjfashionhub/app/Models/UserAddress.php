<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'label',
        'full_name',
        'phone',
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'pincode',
        'country',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    /**
     * Get the user that owns the address
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the full formatted address
     */
    public function getFullAddressAttribute(): string
    {
        $parts = array_filter([
            $this->address_line_1,
            $this->address_line_2,
            $this->city,
            $this->state,
            $this->pincode,
            $this->country
        ]);

        return implode(', ', $parts);
    }

    /**
     * Get the formatted address for display
     */
    public function getFormattedAddressAttribute(): string
    {
        $address = $this->address_line_1;
        if ($this->address_line_2) {
            $address .= ', ' . $this->address_line_2;
        }
        $address .= '<br>' . $this->city . ', ' . $this->state . ' ' . $this->pincode;
        if ($this->country !== 'India') {
            $address .= '<br>' . $this->country;
        }
        return $address;
    }

    /**
     * Scope for default addresses
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    /**
     * Scope for shipping addresses
     */
    public function scopeShipping($query)
    {
        return $query->whereIn('type', ['shipping', 'both']);
    }

    /**
     * Scope for billing addresses
     */
    public function scopeBilling($query)
    {
        return $query->whereIn('type', ['billing', 'both']);
    }

    /**
     * Set this address as default and unset others
     */
    public function setAsDefault(): void
    {
        // Unset other default addresses for this user
        static::where('user_id', $this->user_id)
            ->where('id', '!=', $this->id)
            ->update(['is_default' => false]);

        // Set this as default
        $this->update(['is_default' => true]);
    }

    /**
     * Create address from order data
     */
    public static function createFromOrder(array $addressData, int $userId, string $type = 'both'): self
    {
        return static::create([
            'user_id' => $userId,
            'type' => $type,
            'full_name' => $addressData['full_name'],
            'phone' => $addressData['phone'],
            'address_line_1' => $addressData['address'],
            'city' => $addressData['city'],
            'state' => $addressData['state'],
            'pincode' => $addressData['pincode'],
            'country' => 'India',
            'is_default' => false,
        ]);
    }
}
