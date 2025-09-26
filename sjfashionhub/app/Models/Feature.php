<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        'title',
        'description',
        'icon_type',
        'icon_svg',
        'icon_image',
        'icon_class',
        'background_color',
        'icon_color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Scope for active features
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordered features
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    /**
     * Get the icon HTML based on type
     */
    public function getIconHtmlAttribute()
    {
        switch ($this->icon_type) {
            case 'svg':
                return $this->icon_svg;
            case 'image':
                return $this->icon_image ? '<img src="' . asset('storage/' . $this->icon_image) . '" alt="' . $this->title . '" class="w-8 h-8">' : '';
            case 'icon_class':
                return '<i class="' . $this->icon_class . ' text-2xl"></i>';
            default:
                return $this->icon_svg;
        }
    }
}
