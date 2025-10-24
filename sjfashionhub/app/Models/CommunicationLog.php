<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CommunicationLog extends Model
{
    protected $fillable = [
        'type',
        'provider',
        'recipient',
        'sender',
        'subject',
        'content',
        'template_id',
        'event',
        'status',
        'message_id',
        'error_message',
        'metadata',
        'variables',
        'cost',
        'sent_at',
        'delivered_at',
        'read_at',
        'failed_at',
        'retry_count',
        'next_retry_at',
        'user_id',
        'order_id',
        'reference_type',
        'reference_id'
    ];

    protected $casts = [
        'metadata' => 'array',
        'variables' => 'array',
        'cost' => 'decimal:4',
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
        'read_at' => 'datetime',
        'failed_at' => 'datetime',
        'next_retry_at' => 'datetime',
        'retry_count' => 'integer'
    ];

    /**
     * Get the template used for this communication
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(CommunicationTemplate::class, 'template_id');
    }

    /**
     * Get the user who received this communication
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Get the order related to this communication
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Order::class);
    }

    /**
     * Get the reference model (polymorphic)
     */
    public function reference(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Mark as sent
     */
    public function markAsSent($messageId = null, $cost = null)
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'message_id' => $messageId,
            'cost' => $cost
        ]);
    }

    /**
     * Mark as delivered
     */
    public function markAsDelivered()
    {
        $this->update([
            'status' => 'delivered',
            'delivered_at' => now()
        ]);
    }

    /**
     * Mark as read
     */
    public function markAsRead()
    {
        $this->update([
            'status' => 'read',
            'read_at' => now()
        ]);
    }

    /**
     * Mark as failed
     */
    public function markAsFailed($errorMessage = null)
    {
        $this->update([
            'status' => 'failed',
            'failed_at' => now(),
            'error_message' => $errorMessage,
            'retry_count' => $this->retry_count + 1,
            'next_retry_at' => $this->calculateNextRetry()
        ]);
    }

    /**
     * Calculate next retry time
     */
    private function calculateNextRetry()
    {
        $retryDelays = [5, 15, 60, 300, 1800]; // 5min, 15min, 1hr, 5hr, 30min
        $delayIndex = min($this->retry_count, count($retryDelays) - 1);

        return now()->addMinutes($retryDelays[$delayIndex]);
    }

    /**
     * Check if can retry
     */
    public function canRetry()
    {
        return $this->status === 'failed' &&
               $this->retry_count < 5 &&
               $this->next_retry_at &&
               $this->next_retry_at <= now();
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'sent' => 'blue',
            'delivered' => 'green',
            'read' => 'purple',
            'failed' => 'red',
            default => 'gray'
        };
    }

    /**
     * Get formatted cost
     */
    public function getFormattedCostAttribute()
    {
        return $this->cost ? '₹' . number_format($this->cost, 4) : 'Free';
    }

    /**
     * Get delivery time
     */
    public function getDeliveryTimeAttribute()
    {
        if ($this->sent_at && $this->delivered_at) {
            return $this->sent_at->diffInSeconds($this->delivered_at) . 's';
        }
        return null;
    }

    /**
     * Scope for status
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for type
     */
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope for provider
     */
    public function scopeProvider($query, $provider)
    {
        return $query->where('provider', $provider);
    }

    /**
     * Scope for recipient
     */
    public function scopeRecipient($query, $recipient)
    {
        return $query->where('recipient', $recipient);
    }

    /**
     * Scope for event
     */
    public function scopeEvent($query, $event)
    {
        return $query->where('event', $event);
    }

    /**
     * Scope for failed communications that can be retried
     */
    public function scopeRetryable($query)
    {
        return $query->where('status', 'failed')
            ->where('retry_count', '<', 5)
            ->where('next_retry_at', '<=', now());
    }

    /**
     * Scope for recent communications
     */
    public function scopeRecent($query, $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Get statistics
     */
    public static function getStats($days = 30)
    {
        $baseQuery = static::where('created_at', '>=', now()->subDays($days));

        return [
            'total' => (clone $baseQuery)->count(),
            'sent' => (clone $baseQuery)->where('status', 'sent')->count(),
            'delivered' => (clone $baseQuery)->where('status', 'delivered')->count(),
            'failed' => (clone $baseQuery)->where('status', 'failed')->count(),
            'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
            'total_cost' => (clone $baseQuery)->sum('cost') ?? 0,
            'email_count' => (clone $baseQuery)->where('type', 'email')->count(),
            'sms_count' => (clone $baseQuery)->where('type', 'sms')->count(),
            'whatsapp_count' => (clone $baseQuery)->where('type', 'whatsapp')->count(),
        ];
    }
}
