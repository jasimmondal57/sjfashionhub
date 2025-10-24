<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class NewsletterSubscriber extends Model
{
    use HasFactory;

    protected $fillable = [
        'email',
        'name',
        'status',
        'subscribed_at',
        'unsubscribed_at',
        'ip_address',
        'user_agent',
        'source',
        'preferences',
    ];

    protected $casts = [
        'preferences' => 'array',
        'subscribed_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
    ];

    /**
     * Scope to get active subscribers
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get unsubscribed subscribers
     */
    public function scopeUnsubscribed($query)
    {
        return $query->where('status', 'unsubscribed');
    }

    /**
     * Scope to get bounced subscribers
     */
    public function scopeBounced($query)
    {
        return $query->where('status', 'bounced');
    }

    /**
     * Scope to get recent subscribers
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('subscribed_at', '>=', Carbon::now()->subDays($days));
    }

    /**
     * Mark subscriber as unsubscribed
     */
    public function unsubscribe()
    {
        $this->update([
            'status' => 'unsubscribed',
            'unsubscribed_at' => now(),
        ]);
    }

    /**
     * Mark subscriber as active
     */
    public function resubscribe()
    {
        $this->update([
            'status' => 'active',
            'unsubscribed_at' => null,
        ]);
    }

    /**
     * Get subscriber statistics
     */
    public static function getStats()
    {
        return [
            'total' => static::count(),
            'active' => static::active()->count(),
            'unsubscribed' => static::unsubscribed()->count(),
            'bounced' => static::bounced()->count(),
            'recent' => static::recent(30)->count(),
        ];
    }
}
