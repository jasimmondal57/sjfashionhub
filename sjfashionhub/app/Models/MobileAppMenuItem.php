<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileAppMenuItem extends Model
{
    protected $fillable = [
        'title',
        'icon',
        'type',
        'value',
        'order',
        'is_active',
        'show_in_bottom_nav',
        'show_in_drawer',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_in_bottom_nav' => 'boolean',
        'show_in_drawer' => 'boolean',
    ];

    /**
     * Get bottom navigation items
     */
    public static function getBottomNav()
    {
        return self::where('is_active', true)
            ->where('show_in_bottom_nav', true)
            ->orderBy('order')
            ->get();
    }

    /**
     * Get drawer menu items
     */
    public static function getDrawerMenu()
    {
        return self::where('is_active', true)
            ->where('show_in_drawer', true)
            ->orderBy('order')
            ->get();
    }
}

