<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class PaymentTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_gateway_id',
        'order_id',
        'user_id',
        'transaction_id',
        'gateway_transaction_id',
        'gateway_payment_id',
        'gateway_order_id',
        'amount',
        'gateway_fee',
        'net_amount',
        'currency',
        'status',
        'type',
        'payment_method',
        'gateway_response',
        'metadata',
        'gateway_created_at',
        'completed_at',
        'failed_at',
        'failure_reason',
        'refund_id',
        'refund_amount'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'gateway_fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'gateway_response' => 'array',
        'metadata' => 'array',
        'gateway_created_at' => 'datetime',
        'completed_at' => 'datetime',
        'failed_at' => 'datetime'
    ];

    /**
     * Relationships
     */
    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scopes
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByGateway($query, $gateway)
    {
        return $query->whereHas('paymentGateway', function ($q) use ($gateway) {
            $q->where('name', $gateway);
        });
    }

    /**
     * Boot method
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (!$transaction->transaction_id) {
                $transaction->transaction_id = static::generateTransactionId();
            }
        });
    }

    /**
     * Generate unique transaction ID
     */
    public static function generateTransactionId()
    {
        do {
            $id = 'TXN_' . strtoupper(Str::random(12));
        } while (static::where('transaction_id', $id)->exists());

        return $id;
    }

    /**
     * Mark transaction as completed
     */
    public function markAsCompleted($gatewayResponse = null)
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'gateway_response' => $gatewayResponse
        ]);
    }

    /**
     * Mark transaction as failed
     */
    public function markAsFailed($reason = null, $gatewayResponse = null)
    {
        $this->update([
            'status' => 'failed',
            'failed_at' => now(),
            'failure_reason' => $reason,
            'gateway_response' => $gatewayResponse
        ]);
    }

    /**
     * Check if transaction can be refunded
     */
    public function canBeRefunded()
    {
        return $this->status === 'completed' &&
               $this->type === 'payment' &&
               (!$this->refund_amount || $this->refund_amount < $this->amount);
    }

    /**
     * Get refundable amount
     */
    public function getRefundableAmount()
    {
        if (!$this->canBeRefunded()) {
            return 0;
        }

        return $this->amount - ($this->refund_amount ?? 0);
    }

    /**
     * Get formatted amount
     */
    public function getFormattedAmountAttribute()
    {
        return $this->currency . ' ' . number_format($this->amount, 2);
    }

    /**
     * Get status badge
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'completed' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
            'cancelled' => 'bg-gray-100 text-gray-800',
            'refunded' => 'bg-purple-100 text-purple-800',
            'partially_refunded' => 'bg-orange-100 text-orange-800'
        ];

        return $badges[$this->status] ?? 'bg-gray-100 text-gray-800';
    }

    /**
     * Get statistics
     */
    public static function getStats($days = 30)
    {
        $query = static::where('created_at', '>=', now()->subDays($days));

        return [
            'total_transactions' => $query->count(),
            'completed_transactions' => $query->where('status', 'completed')->count(),
            'failed_transactions' => $query->where('status', 'failed')->count(),
            'total_amount' => $query->where('status', 'completed')->sum('amount'),
            'total_fees' => $query->where('status', 'completed')->sum('gateway_fee'),
            'success_rate' => $query->count() > 0 ?
                round(($query->where('status', 'completed')->count() / $query->count()) * 100, 2) : 0
        ];
    }
}
