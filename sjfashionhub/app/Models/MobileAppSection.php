<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileAppSection extends Model
{
    protected $fillable = [
        'title',
        'type',
        'description',
        'config',
        'order',
        'is_active',
    ];

    protected $casts = [
        'config' => 'array',
        'is_active' => 'boolean',
    ];

    /**
     * Get active sections ordered
     */
    public static function getActive()
    {
        return self::where('is_active', true)
            ->orderBy('order')
            ->get();
    }
}

