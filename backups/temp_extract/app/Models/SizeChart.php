<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SizeChart extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'size_data',
        'image_url',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'size_data' => 'array',
        'is_active' => 'boolean'
    ];

    // Auto-generate slug from name
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($sizeChart) {
            if (empty($sizeChart->slug)) {
                $sizeChart->slug = Str::slug($sizeChart->name);
            }
        });

        static::updating(function ($sizeChart) {
            if ($sizeChart->isDirty('name') && empty($sizeChart->slug)) {
                $sizeChart->slug = Str::slug($sizeChart->name);
            }
        });
    }

    // Scope for active size charts
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for ordered size charts
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    // Relationship with products
    public function products()
    {
        return $this->hasMany(Product::class, 'size_chart_id');
    }
}
