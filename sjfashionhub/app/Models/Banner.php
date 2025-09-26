<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Banner extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'button_text',
        'button_link',
        'link_type',
        'category_id',
        'product_id',
        'custom_link',
        'is_active',
        'sort_order',
        'text_color',
        'button_color',
        'text_position',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function getButtonUrlAttribute(): ?string
    {
        return match ($this->link_type) {
            'category' => $this->category ? route('categories.show', $this->category->slug) : null,
            'product' => $this->product ? route('products.show', $this->product->slug) : null,
            'custom' => $this->custom_link,
            default => null,
        };
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }
}
