<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

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

        // NEW FIELDS - Inventory & Stock Management
        'barcode',
        'supplier_name',
        'supplier_sku',
        'supplier_cost',
        'supplier_lead_time_days',
        'reorder_point',
        'reorder_quantity',
        'stock_location',
        'backorder_status',
        'allow_preorder',
        'preorder_release_date',

        // Product Attributes (Fashion-Specific)
        'fabric_composition',
        'care_instructions',
        'fit_type',
        'occasion',
        'sleeve_type',
        'neck_type',
        'length_type',
        'closure_type',
        'pocket_details',
        'has_lining',
        'transparency',
        'is_stretchable',
        'season',
        'style_code',
        'collection_name',

        // Shipping & Dimensions (Detailed)
        'length_cm',
        'width_cm',
        'height_cm',
        'volumetric_weight',
        'package_type',
        'is_fragile',
        'requires_signature',
        'shipping_class',

        // Pricing & Promotions
        'bulk_price_tier1_qty',
        'bulk_price_tier1_price',
        'bulk_price_tier2_qty',
        'bulk_price_tier2_price',
        'bulk_price_tier3_qty',
        'bulk_price_tier3_price',
        'member_price',
        'sale_start_date',
        'sale_end_date',
        'min_order_quantity',
        'max_order_quantity',
        'quantity_increment',
        'wholesale_price',
        'margin_percentage',

        // Media & Content
        'video_url',
        'model_info',
        'lifestyle_images',
        'image_360_urls',
        'product_documents',

        // SEO & Marketing
        'url_slug',
        'canonical_url',
        'meta_robots',
        'og_image_url',
        'twitter_card_type',
        'schema_type',
        'product_badges',
        'product_labels',
        'launch_date',
        'discontinue_date',

        // Additional Features
        'enable_reviews',
        'enable_questions',
        'allow_personalization',
        'personalization_instructions',
        'gift_wrap_available',
        'gift_wrap_price',
        'allow_gift_message',
        'assembly_required',
        'certifications',
        'sustainability_info',
        'made_to_order',
        'production_time_days',

        // Additional Info
        'wash_care_symbols',
        'country_of_manufacture',
        'is_eco_friendly',
        'is_handmade',
        'special_features',
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

        // NEW CASTS
        'supplier_cost' => 'decimal:2',
        'reorder_point' => 'integer',
        'reorder_quantity' => 'integer',
        'supplier_lead_time_days' => 'integer',
        'allow_preorder' => 'boolean',
        'preorder_release_date' => 'date',
        'has_lining' => 'boolean',
        'is_stretchable' => 'boolean',
        'length_cm' => 'decimal:2',
        'width_cm' => 'decimal:2',
        'height_cm' => 'decimal:2',
        'volumetric_weight' => 'decimal:2',
        'is_fragile' => 'boolean',
        'requires_signature' => 'boolean',
        'bulk_price_tier1_qty' => 'decimal:2',
        'bulk_price_tier1_price' => 'decimal:2',
        'bulk_price_tier2_qty' => 'decimal:2',
        'bulk_price_tier2_price' => 'decimal:2',
        'bulk_price_tier3_qty' => 'decimal:2',
        'bulk_price_tier3_price' => 'decimal:2',
        'member_price' => 'decimal:2',
        'sale_start_date' => 'datetime',
        'sale_end_date' => 'datetime',
        'min_order_quantity' => 'integer',
        'max_order_quantity' => 'integer',
        'quantity_increment' => 'integer',
        'wholesale_price' => 'decimal:2',
        'margin_percentage' => 'decimal:2',
        'lifestyle_images' => 'array',
        'image_360_urls' => 'array',
        'product_documents' => 'array',
        'product_badges' => 'array',
        'product_labels' => 'array',
        'launch_date' => 'date',
        'discontinue_date' => 'date',
        'enable_reviews' => 'boolean',
        'enable_questions' => 'boolean',
        'allow_personalization' => 'boolean',
        'gift_wrap_available' => 'boolean',
        'gift_wrap_price' => 'decimal:2',
        'allow_gift_message' => 'boolean',
        'assembly_required' => 'boolean',
        'certifications' => 'array',
        'made_to_order' => 'boolean',
        'production_time_days' => 'integer',
        'is_eco_friendly' => 'boolean',
        'is_handmade' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function productVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->ordered();
    }

    public function activeVariants(): HasMany
    {
        return $this->hasMany(ProductVariant::class)->active()->ordered();
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
        if ($this->images && count($this->images) > 0) {
            $firstImage = $this->images[0];
            $imagePath = null;

            if (is_array($firstImage)) {
                $imagePath = $firstImage['image_path'] ?? $firstImage['path'] ?? $firstImage['url'] ?? $firstImage['file'] ?? null;
            } elseif (is_string($firstImage)) {
                $imagePath = $firstImage;
            }

            if ($imagePath) {
                // If it's a full URL (Shopify or external), return it as-is
                if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
                    return $imagePath;
                }

                // If it's a local path, generate the full storage URL
                return Storage::url($imagePath);
            }
        }
        return null;
    }

    public function getImageUrlsAttribute()
    {
        if (!$this->images || count($this->images) === 0) {
            return [];
        }

        $imageUrls = [];
        foreach ($this->images as $image) {
            $imagePath = null;

            if (is_array($image)) {
                $imagePath = $image['image_path'] ?? $image['path'] ?? $image['url'] ?? $image['file'] ?? null;
            } elseif (is_string($image)) {
                $imagePath = $image;
            }

            if ($imagePath) {
                // If it's a full URL (Shopify or external), return it as-is
                if (str_starts_with($imagePath, 'http://') || str_starts_with($imagePath, 'https://')) {
                    $imageUrls[] = $imagePath;
                } else {
                    // If it's a local path, generate the full storage URL
                    $imageUrls[] = Storage::url($imagePath);
                }
            }
        }

        return $imageUrls;
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

    // Blog Posts relationship
    public function blogPosts(): HasMany
    {
        return $this->hasMany(BlogPost::class);
    }
}
