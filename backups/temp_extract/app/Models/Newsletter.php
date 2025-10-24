<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'placeholder_text',
        'button_text',
        'background_color',
        'text_color',
        'button_color',
        'button_text_color',
        'show_social_links',
        'social_links',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'social_links' => 'array',
        'show_social_links' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Scope to get active newsletters
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get newsletters ordered by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    /**
     * Get the active newsletter for display
     */
    public static function getActiveNewsletter()
    {
        return static::active()->ordered()->first();
    }
}
