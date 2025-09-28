<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Order extends Model
{
    protected $fillable = [
        'order_number', 'user_id', 'status', 'order_status', 'subtotal', 'tax_amount',
        'shipping_amount', 'discount_amount', 'total_amount', 'currency', 'payment_status',
        'payment_method', 'payment_id', 'billing_address', 'shipping_address', 'notes',
        'shipped_at', 'delivered_at', 'shiprocket_order_id', 'shiprocket_shipment_id',
        'awb_number', 'courier_company', 'courier_company_id', 'shipping_charges',
        'tracking_url', 'courier_details', 'is_manual_shipping', 'manual_tracking_id',
        'manual_courier_name', 'confirmed_at', 'ready_to_ship_at', 'in_transit_at',
        'out_for_delivery_at', 'cancelled_at', 'rto_at', 'confirmed_by', 'admin_notes',
        'cancellation_reason', 'rto_reason', 'delivery_attempts', 'delivery_updates',
        'cod_amount', 'is_cod', 'package_weight', 'package_length', 'package_breadth',
        'package_height', 'estimated_delivery_date', 'estimated_delivery_days'
    ];

    protected $casts = [
        'billing_address' => 'array',
        'shipping_address' => 'array',
        'courier_details' => 'array',
        'delivery_updates' => 'array',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'ready_to_ship_at' => 'datetime',
        'in_transit_at' => 'datetime',
        'out_for_delivery_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'rto_at' => 'datetime',
        'estimated_delivery_date' => 'date',
        'is_manual_shipping' => 'boolean',
        'is_cod' => 'boolean',
        'subtotal' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'shipping_charges' => 'decimal:2',
        'cod_amount' => 'decimal:2',
        'package_weight' => 'decimal:3',
        'package_length' => 'decimal:2',
        'package_breadth' => 'decimal:2',
        'package_height' => 'decimal:2'
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function returns(): HasMany
    {
        return $this->hasMany(ReturnOrder::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('order_status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('order_status', 'confirmed');
    }

    public function scopeReadyToShip($query)
    {
        return $query->where('order_status', 'ready_to_ship');
    }

    public function scopeInTransit($query)
    {
        return $query->where('order_status', 'in_transit');
    }

    public function scopeOutForDelivery($query)
    {
        return $query->where('order_status', 'out_for_delivery');
    }

    public function scopeDelivered($query)
    {
        return $query->where('order_status', 'delivered');
    }

    public function scopeCancelled($query)
    {
        return $query->where('order_status', 'cancelled');
    }

    public function scopeRto($query)
    {
        return $query->where('order_status', 'rto');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'Pending'],
            'confirmed' => ['class' => 'bg-blue-100 text-blue-800', 'text' => 'Confirmed'],
            'ready_to_ship' => ['class' => 'bg-purple-100 text-purple-800', 'text' => 'Ready to Ship'],
            'in_transit' => ['class' => 'bg-indigo-100 text-indigo-800', 'text' => 'In Transit'],
            'out_for_delivery' => ['class' => 'bg-orange-100 text-orange-800', 'text' => 'Out for Delivery'],
            'delivered' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Delivered'],
            'cancelled' => ['class' => 'bg-red-100 text-red-800', 'text' => 'Cancelled'],
            'rto' => ['class' => 'bg-gray-100 text-gray-800', 'text' => 'RTO']
        ];

        return $badges[$this->order_status] ?? $badges['pending'];
    }

    public function getFormattedTotalAttribute()
    {
        return '₹' . number_format($this->total_amount, 2);
    }

    public function getShippingMethodAttribute()
    {
        if ($this->is_manual_shipping) {
            return $this->manual_courier_name ?? 'Manual Shipping';
        }

        return $this->courier_company ?? 'Not Assigned';
    }

    // Helper methods
    public function canBeConfirmed()
    {
        return $this->order_status === 'pending';
    }

    public function canBeShipped()
    {
        return $this->order_status === 'confirmed' || $this->order_status === 'ready_to_ship';
    }

    public function canBeCancelled()
    {
        return in_array($this->order_status, ['pending', 'confirmed', 'ready_to_ship']);
    }

    public function hasShiprocketIntegration()
    {
        return !empty($this->shiprocket_order_id);
    }

    public function updateStatus($status, $userId = null)
    {
        $this->order_status = $status;

        $timestampField = $status . '_at';
        if (in_array($timestampField, ['confirmed_at', 'ready_to_ship_at', 'in_transit_at', 'out_for_delivery_at', 'delivered_at', 'cancelled_at', 'rto_at'])) {
            $this->$timestampField = now();
        }

        if ($status === 'confirmed' && $userId) {
            $this->confirmed_by = $userId;
        }

        $this->save();
    }

    public function generateOrderNumber()
    {
        return 'ORD-' . date('Y') . '-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }
}
