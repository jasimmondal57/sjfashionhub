<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnnouncementBar extends Model
{
    protected $fillable = [
        'message',
        'background_color',
        'text_color',
        'links',
        'is_active',
        'is_scrolling',
        'scroll_speed',
        'sort_order',
    ];

    protected $casts = [
        'links' => 'array',
        'is_active' => 'boolean',
        'is_scrolling' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}
