<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'long_description',
        'sku',
        'price',
        'sale_price',
        'stock_quantity',
        'category_id',
        'images',
        'attributes',
        'is_featured',
        'is_active',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'structured_data',
        'seo_generated',
        'seo_generated_at',

        // Google Merchant Center Fields
        'brand',
        'gtin',
        'mpn',
        'identifier_exists',
        'google_product_category',
        'condition',
        'availability',
        'age_group',
        'gender',
        'size',
        'color',
        'material',
        'pattern',
        'item_group_id',

        // Shipping Information
        'weight',
        'dimensions',
        'shipping_weight',
        'shipping_dimensions',
        'shipping_cost',
        'shipping_service',

        // Additional Product Details
        'additional_images',
        'product_type',
        'custom_labels',
        'tags',
        'size_chart_id',

        // Meta Pixel & Facebook Catalog
        'facebook_product_id',
        'cost_of_goods',

        // Product Quality & Trust
        'has_warranty',
        'warranty_period',
        'has_return_policy',
        'return_days',
        'rating',
        'review_count',

        // Inventory Management
        'manage_stock',
        'low_stock_threshold',
        'track_quantity',
        'stock_status',

        // Pricing Strategy
        'compare_at_price',
        'cost_price',
        'price_includes_tax',
        'tax_rate',
    ];

    protected $casts = [
        'images' => 'array',
        'additional_images' => 'array',
        'attributes' => 'array',
        'custom_labels' => 'array',
        'tags' => 'array',
        'structured_data' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'seo_generated' => 'boolean',
        'identifier_exists' => 'boolean',
        'has_warranty' => 'boolean',
        'has_return_policy' => 'boolean',
        'track_quantity' => 'boolean',
        'manage_stock' => 'boolean',
        'price_includes_tax' => 'boolean',
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'compare_at_price' => 'decimal:2',
        'cost_price' => 'decimal:2',
        'cost_of_goods' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'weight' => 'decimal:2',
        'shipping_weight' => 'decimal:2',
        'tax_rate' => 'decimal:2',
        'rating' => 'decimal:2',
        'seo_generated_at' => 'datetime',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return '₹' . number_format($this->price, 0);
    }

    public function getFormattedSalePriceAttribute()
    {
        return $this->sale_price ? '₹' . number_format($this->sale_price, 0) : null;
    }

    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->price > $this->sale_price) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    public function getMainImageAttribute()
    {
        return $this->images && count($this->images) > 0 ? $this->images[0] : null;
    }

    public function getIsOnSaleAttribute()
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }

    // Size Chart relationship
    public function sizeChart()
    {
        return $this->belongsTo(SizeChart::class);
    }
}
