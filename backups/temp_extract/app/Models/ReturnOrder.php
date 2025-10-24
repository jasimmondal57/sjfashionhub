<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class ReturnOrder extends Model
{
    protected $fillable = [
        'return_number', 'order_id', 'user_id', 'status', 'return_type', 'return_reason',
        'customer_notes', 'return_items', 'return_amount', 'return_images', 'processed_by',
        'admin_notes', 'rejection_reason', 'approved_at', 'rejected_at', 'shiprocket_return_id',
        'return_awb_number', 'return_courier_company', 'return_courier_company_id',
        'return_shipping_charges', 'return_tracking_url', 'return_courier_details',
        'is_manual_return', 'manual_return_tracking_id', 'manual_return_courier_name',
        'ready_to_return_at', 'in_transit_at', 'received_at', 'refund_processed_at',
        'completed_at', 'quality_check_status', 'quality_check_notes', 'quality_checked_by',
        'quality_checked_at', 'refund_amount', 'deduction_amount', 'deduction_reason',
        'refund_method', 'refund_transaction_id', 'refund_details', 'return_package_weight',
        'return_package_length', 'return_package_breadth', 'return_package_height',
        'pickup_address', 'pickup_scheduled_at', 'pickup_completed_at'
    ];

    protected $casts = [
        'return_items' => 'array',
        'return_images' => 'array',
        'return_courier_details' => 'array',
        'refund_details' => 'array',
        'pickup_address' => 'array',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'ready_to_return_at' => 'datetime',
        'in_transit_at' => 'datetime',
        'received_at' => 'datetime',
        'refund_processed_at' => 'datetime',
        'completed_at' => 'datetime',
        'quality_checked_at' => 'datetime',
        'pickup_scheduled_at' => 'datetime',
        'pickup_completed_at' => 'datetime',
        'return_amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'deduction_amount' => 'decimal:2',
        'return_shipping_charges' => 'decimal:2',
        'return_package_weight' => 'decimal:3',
        'return_package_length' => 'decimal:2',
        'return_package_breadth' => 'decimal:2',
        'return_package_height' => 'decimal:2',
        'is_manual_return' => 'boolean'
    ];

    // Relationships
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function processedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

    public function qualityCheckedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'quality_checked_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeReadyToReturn($query)
    {
        return $query->where('status', 'ready_to_return');
    }

    public function scopeInTransit($query)
    {
        return $query->where('status', 'in_transit');
    }

    public function scopePendingRefund($query)
    {
        return $query->where('status', 'pending_refund');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => ['class' => 'bg-yellow-100 text-yellow-800', 'text' => 'Pending'],
            'approved' => ['class' => 'bg-blue-100 text-blue-800', 'text' => 'Approved'],
            'ready_to_return' => ['class' => 'bg-purple-100 text-purple-800', 'text' => 'Ready to Return'],
            'in_transit' => ['class' => 'bg-indigo-100 text-indigo-800', 'text' => 'In Transit'],
            'pending_refund' => ['class' => 'bg-orange-100 text-orange-800', 'text' => 'Pending Refund'],
            'completed' => ['class' => 'bg-green-100 text-green-800', 'text' => 'Completed'],
            'rejected' => ['class' => 'bg-red-100 text-red-800', 'text' => 'Rejected']
        ];

        return $badges[$this->status] ?? $badges['pending'];
    }

    public function getFormattedReturnAmountAttribute()
    {
        return '₹' . number_format($this->return_amount, 2);
    }

    public function getFormattedRefundAmountAttribute()
    {
        return '₹' . number_format($this->refund_amount ?? $this->return_amount, 2);
    }

    public function getReturnTypeDisplayAttribute()
    {
        $types = [
            'refund' => 'Refund',
            'exchange' => 'Exchange',
            'store_credit' => 'Store Credit'
        ];

        return $types[$this->return_type] ?? 'Refund';
    }

    public function getReturnShippingMethodAttribute()
    {
        if ($this->is_manual_return) {
            return $this->manual_return_courier_name ?? 'Manual Return';
        }

        return $this->return_courier_company ?? 'Not Assigned';
    }

    // Helper methods
    public function canBeApproved()
    {
        return $this->status === 'pending';
    }

    public function canBeRejected()
    {
        return $this->status === 'pending';
    }

    public function canInitiateReturn()
    {
        return $this->status === 'approved' || $this->status === 'ready_to_return';
    }

    public function canProcessRefund()
    {
        return $this->status === 'pending_refund' && $this->quality_check_status === 'passed';
    }

    public function hasShiprocketIntegration()
    {
        return !empty($this->shiprocket_return_id);
    }

    public function updateStatus($status, $userId = null)
    {
        $this->status = $status;

        $timestampField = $status . '_at';
        if (in_array($timestampField, ['approved_at', 'rejected_at', 'ready_to_return_at', 'in_transit_at', 'received_at', 'refund_processed_at', 'completed_at'])) {
            $this->$timestampField = now();
        }

        if ($status === 'approved' && $userId) {
            $this->processed_by = $userId;
        }

        $this->save();
    }

    public function generateReturnNumber()
    {
        return 'RET-' . date('Y') . '-' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    public function getDaysFromCreationAttribute()
    {
        return $this->created_at->diffInDays(now());
    }
}
