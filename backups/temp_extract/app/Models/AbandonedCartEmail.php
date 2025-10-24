<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AbandonedCartEmail extends Model
{
    protected $fillable = [
        'abandoned_cart_id',
        'email_type',
        'subject',
        'content',
        'template',
        'status',
        'scheduled_at',
        'sent_at',
        'opened_at',
        'clicked_at',
        'email_provider',
        'message_id',
        'error_message',
        'retry_count',
        'tracking_data',
        'coupon_code',
        'discount_amount',
        'discount_type',
        'is_personalized',
        'personalization_data'
    ];

    protected $casts = [
        'tracking_data' => 'array',
        'personalization_data' => 'array',
        'is_personalized' => 'boolean',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'opened_at' => 'datetime',
        'clicked_at' => 'datetime',
        'discount_amount' => 'decimal:2',
    ];

    /**
     * Get the abandoned cart that owns the email
     */
    public function abandonedCart(): BelongsTo
    {
        return $this->belongsTo(AbandonedCart::class);
    }

    /**
     * Scope for pending emails
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for sent emails
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope for failed emails
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope for opened emails
     */
    public function scopeOpened($query)
    {
        return $query->where('status', 'opened');
    }

    /**
     * Scope for clicked emails
     */
    public function scopeClicked($query)
    {
        return $query->where('status', 'clicked');
    }

    /**
     * Scope for emails ready to send
     */
    public function scopeReadyToSend($query)
    {
        return $query->where('status', 'pending')
            ->where('scheduled_at', '<=', now());
    }

    /**
     * Mark email as sent
     */
    public function markAsSent($messageId = null)
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
            'message_id' => $messageId
        ]);
    }

    /**
     * Mark email as failed
     */
    public function markAsFailed($errorMessage = null)
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
            'retry_count' => $this->retry_count + 1
        ]);
    }

    /**
     * Mark email as opened
     */
    public function markAsOpened()
    {
        if ($this->status === 'sent') {
            $this->update([
                'status' => 'opened',
                'opened_at' => now()
            ]);
        }
    }

    /**
     * Mark email as clicked
     */
    public function markAsClicked()
    {
        $this->update([
            'status' => 'clicked',
            'clicked_at' => now()
        ]);
    }

    /**
     * Get formatted discount amount
     */
    public function getFormattedDiscountAttribute()
    {
        if (!$this->discount_amount) {
            return null;
        }

        if ($this->discount_type === 'percentage') {
            return $this->discount_amount . '%';
        }

        return '₹' . number_format($this->discount_amount, 2);
    }

    /**
     * Get email type label
     */
    public function getEmailTypeLabelAttribute()
    {
        return match($this->email_type) {
            'reminder_1' => 'First Reminder',
            'reminder_2' => 'Second Reminder',
            'reminder_3' => 'Third Reminder',
            'final_reminder' => 'Final Reminder',
            default => ucfirst(str_replace('_', ' ', $this->email_type))
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'sent' => 'blue',
            'failed' => 'red',
            'opened' => 'green',
            'clicked' => 'purple',
            default => 'gray'
        };
    }

    /**
     * Calculate email performance metrics
     */
    public static function getPerformanceMetrics($days = 30)
    {
        $total = static::where('created_at', '>=', now()->subDays($days))->count();
        $sent = static::where('created_at', '>=', now()->subDays($days))->sent()->count();
        $opened = static::where('created_at', '>=', now()->subDays($days))->opened()->count();
        $clicked = static::where('created_at', '>=', now()->subDays($days))->clicked()->count();

        return [
            'total' => $total,
            'sent' => $sent,
            'opened' => $opened,
            'clicked' => $clicked,
            'delivery_rate' => $total > 0 ? round(($sent / $total) * 100, 2) : 0,
            'open_rate' => $sent > 0 ? round(($opened / $sent) * 100, 2) : 0,
            'click_rate' => $sent > 0 ? round(($clicked / $sent) * 100, 2) : 0,
        ];
    }
}
