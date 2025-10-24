<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeroSection extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'description',
        'primary_button_text',
        'primary_button_url',
        'secondary_button_text',
        'secondary_button_url',
        'background_color',
        'text_color',
        'accent_color',
        'hero_image',
        'decorative_elements',
        'layout_style',
        'show_buttons',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'decorative_elements' => 'array',
        'show_buttons' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    public function getHeroImageUrlAttribute()
    {
        if ($this->hero_image) {
            return Storage::url($this->hero_image);
        }
        return null;
    }

    public static function getActiveHero()
    {
        return static::active()->ordered()->first() ?? static::getDefaultHero();
    }

    public static function getDefaultHero()
    {
        return (object) [
            'title' => 'Where Elegance',
            'subtitle' => 'Meets Comfort',
            'description' => 'Refined Style, Perfect Fit. Style Made Effortless. Elevate Your Style Everyday.',
            'primary_button_text' => 'Shop Now',
            'primary_button_url' => '/products',
            'secondary_button_text' => 'Browse Categories',
            'secondary_button_url' => '/categories',
            'background_color' => '#f9fafb',
            'text_color' => '#000000',
            'accent_color' => '#000000',
            'hero_image' => null,
            'decorative_elements' => null,
            'layout_style' => 'split',
            'show_buttons' => true,
            'is_active' => true,
        ];
    }
}
