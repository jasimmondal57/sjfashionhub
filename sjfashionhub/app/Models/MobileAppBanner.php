<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileAppBanner extends Model
{
    protected $fillable = [
        'title',
        'image',
        'link_type',
        'link_value',
        'order',
        'is_active',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Get active banners
     */
    public static function getActive()
    {
        return self::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->orderBy('order')
            ->get();
    }
}

