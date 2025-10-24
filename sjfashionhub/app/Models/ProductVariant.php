<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'option1_name',
        'option1_value',
        'option2_name',
        'option2_value',
        'option3_name',
        'option3_value',
        'sku',
        'barcode',
        'price',
        'compare_at_price',
        'cost_price',
        'stock_quantity',
        'low_stock_threshold',
        'track_inventory',
        'stock_location',
        'weight',
        'length_cm',
        'width_cm',
        'height_cm',
        'image_url',
        'additional_images',
        'is_active',
        'is_default',
        'sort_order',
        'metadata',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'length_cm' => 'decimal:2',
        'width_cm' => 'decimal:2',
        'height_cm' => 'decimal:2',
        'stock_quantity' => 'integer',
        'low_stock_threshold' => 'integer',
        'track_inventory' => 'boolean',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
        'sort_order' => 'integer',
        'additional_images' => 'array',
        'metadata' => 'array',
    ];

    /**
     * Get the product that owns the variant.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variant title (combination of options).
     */
    public function getTitleAttribute(): string
    {
        $parts = array_filter([
            $this->option1_value,
            $this->option2_value,
            $this->option3_value,
        ]);

        return implode(' / ', $parts);
    }

    /**
     * Get the display price (use variant price or fall back to product price).
     */
    public function getDisplayPriceAttribute(): float
    {
        return $this->price ?? $this->product->price;
    }

    /**
     * Check if variant is in stock.
     */
    public function isInStock(): bool
    {
        if (!$this->track_inventory) {
            return true;
        }

        return $this->stock_quantity > 0;
    }

    /**
     * Check if variant is low on stock.
     */
    public function isLowStock(): bool
    {
        if (!$this->track_inventory) {
            return false;
        }

        return $this->stock_quantity > 0 && $this->stock_quantity <= $this->low_stock_threshold;
    }

    /**
     * Get the variant image or fall back to product image.
     */
    public function getImageAttribute(): ?string
    {
        if ($this->image_url) {
            // Check if it's an external URL
            if (filter_var($this->image_url, FILTER_VALIDATE_URL)) {
                return $this->image_url;
            }
            // Local storage
            return asset('storage/' . $this->image_url);
        }

        // Fall back to product's main image
        return $this->product->main_image ?? null;
    }

    /**
     * Scope to get active variants.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get in-stock variants.
     */
    public function scopeInStock($query)
    {
        return $query->where(function ($q) {
            $q->where('track_inventory', false)
              ->orWhere('stock_quantity', '>', 0);
        });
    }

    /**
     * Scope to order by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('id');
    }

    /**
     * Get formatted option display.
     */
    public function getOptionsArrayAttribute(): array
    {
        $options = [];

        if ($this->option1_name && $this->option1_value) {
            $options[$this->option1_name] = $this->option1_value;
        }

        if ($this->option2_name && $this->option2_value) {
            $options[$this->option2_name] = $this->option2_value;
        }

        if ($this->option3_name && $this->option3_value) {
            $options[$this->option3_name] = $this->option3_value;
        }

        return $options;
    }

    /**
     * Calculate profit margin.
     */
    public function getProfitMarginAttribute(): ?float
    {
        $price = $this->price ?? $this->product->price;
        $cost = $this->cost_price ?? $this->product->cost_price;

        if (!$price || !$cost || $price <= 0) {
            return null;
        }

        return (($price - $cost) / $price) * 100;
    }

    /**
     * Decrease stock quantity.
     */
    public function decreaseStock(int $quantity): bool
    {
        if (!$this->track_inventory) {
            return true;
        }

        if ($this->stock_quantity < $quantity) {
            return false;
        }

        $this->decrement('stock_quantity', $quantity);
        return true;
    }

    /**
     * Increase stock quantity.
     */
    public function increaseStock(int $quantity): void
    {
        if ($this->track_inventory) {
            $this->increment('stock_quantity', $quantity);
        }
    }
}
