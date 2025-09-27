<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialMediaPost extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'platform',
        'post_id',
        'content',
        'hashtags',
        'images',
        'status',
        'error_message',
        'platform_response',
        'scheduled_at',
        'posted_at',
        'engagement_stats',
        'is_ai_generated',
        'ai_prompt',
        'metadata',
    ];

    protected $casts = [
        'hashtags' => 'array',
        'images' => 'array',
        'platform_response' => 'array',
        'engagement_stats' => 'array',
        'metadata' => 'array',
        'is_ai_generated' => 'boolean',
        'scheduled_at' => 'datetime',
        'posted_at' => 'datetime',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePosted($query)
    {
        return $query->where('status', 'posted');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeForPlatform($query, $platform)
    {
        return $query->where('platform', $platform);
    }

    // Accessors
    public function getFormattedHashtagsAttribute()
    {
        return $this->hashtags ? implode(' ', array_map(fn($tag) => '#' . $tag, $this->hashtags)) : '';
    }

    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'pending' => '<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm">Pending</span>',
            'posted' => '<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">Posted</span>',
            'failed' => '<span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm">Failed</span>',
            'scheduled' => '<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm">Scheduled</span>',
            default => '<span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-sm">Unknown</span>',
        };
    }

    public function getPlatformIconAttribute()
    {
        return match($this->platform) {
            'instagram' => '📷',
            'facebook' => '📘',
            'twitter' => '🐦',
            'linkedin' => '💼',
            'pinterest' => '📌',
            'tiktok' => '🎵',
            default => '📱',
        };
    }
}
