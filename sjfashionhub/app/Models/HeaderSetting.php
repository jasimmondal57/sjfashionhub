<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HeaderSetting extends Model
{
    protected $fillable = [
        'site_name',
        'logo_text',
        'logo_image',
        'navigation_menu',
        'show_search',
        'show_wishlist',
        'show_cart',
        'show_account',
        'search_placeholder',
        'contact_info',
        'social_links',
        'sticky_header',
        'header_style',
        'is_active',
    ];

    protected $casts = [
        'navigation_menu' => 'array',
        'contact_info' => 'array',
        'social_links' => 'array',
        'show_search' => 'boolean',
        'show_wishlist' => 'boolean',
        'show_cart' => 'boolean',
        'show_account' => 'boolean',
        'sticky_header' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo_image) {
            return Storage::url($this->logo_image);
        }
        return null;
    }

    public static function getActiveSettings()
    {
        return static::active()->first() ?? static::getDefaultSettings();
    }

    public static function getDefaultSettings()
    {
        return (object) [
            'site_name' => 'SJ Fashion Hub',
            'logo_text' => 'SJ Fashion Hub',
            'logo_image' => null,
            'navigation_menu' => [
                ['text' => 'Home', 'url' => '/', 'is_active' => true],
                ['text' => 'Shop', 'url' => '/products', 'is_active' => true],
                ['text' => 'Categories', 'url' => '/categories', 'is_active' => true],
                ['text' => 'About', 'url' => '/about', 'is_active' => true],
                ['text' => 'Contact', 'url' => '/contact', 'is_active' => true],
            ],
            'show_search' => true,
            'show_wishlist' => true,
            'show_cart' => true,
            'show_account' => true,
            'search_placeholder' => 'Search products...',
            'contact_info' => [
                'phone' => '+1 (555) 123-4567',
                'email' => 'info@sjfashionhub.com',
            ],
            'social_links' => [
                ['platform' => 'Facebook', 'url' => '#', 'icon' => 'facebook'],
                ['platform' => 'Instagram', 'url' => '#', 'icon' => 'instagram'],
                ['platform' => 'Twitter', 'url' => '#', 'icon' => 'twitter'],
            ],
            'sticky_header' => false,
            'header_style' => 'default',
            'is_active' => true,
        ];
    }
}
