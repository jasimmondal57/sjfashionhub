<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsAppOrder extends Model
{
    protected $table = 'whatsapp_orders';

    protected $fillable = [
        'whatsapp_order_id', 'order_id', 'phone_number', 'user_id', 'status',
        'items', 'total_amount', 'customer_details', 'customer_message',
        'received_at', 'confirmed_at'
    ];

    protected $casts = [
        'items' => 'array',
        'customer_details' => 'array',
        'total_amount' => 'decimal:2',
        'received_at' => 'datetime',
        'confirmed_at' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    // Methods
    public function confirm()
    {
        $this->update([
            'status' => 'confirmed',
            'confirmed_at' => now(),
        ]);
    }

    public function cancel()
    {
        $this->update(['status' => 'cancelled']);
    }

    // Accessors
    public function getFormattedPhoneAttribute()
    {
        return '+' . $this->phone_number;
    }

    public function getFormattedTotalAttribute()
    {
        return '₹' . number_format($this->total_amount, 2);
    }

    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    public function getItemCountAttribute()
    {
        return count($this->items);
    }
}

