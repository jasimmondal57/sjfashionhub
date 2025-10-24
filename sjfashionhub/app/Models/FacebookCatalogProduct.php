<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FacebookCatalogProduct extends Model
{
    protected $table = 'facebook_catalog_products';
    
    protected $fillable = [
        'product_id',
        'facebook_product_id',
        'status',
        'availability',
        'last_synced_at',
        'sync_error',
        'facebook_data',
    ];

    protected $casts = [
        'last_synced_at' => 'datetime',
        'facebook_data' => 'array',
    ];

    /**
     * Get the product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Mark as synced
     */
    public function markAsSynced($facebookProductId = null, $data = null)
    {
        $this->update([
            'status' => 'synced',
            'facebook_product_id' => $facebookProductId ?? $this->facebook_product_id,
            'last_synced_at' => now(),
            'sync_error' => null,
            'facebook_data' => $data,
        ]);
    }

    /**
     * Mark as failed
     */
    public function markAsFailed($error)
    {
        $this->update([
            'status' => 'failed',
            'sync_error' => $error,
        ]);
    }

    /**
     * Update availability based on stock
     */
    public function updateAvailability()
    {
        $product = $this->product;
        
        if (!$product) {
            return;
        }

        $availability = 'out of stock';
        
        if ($product->stock > 0) {
            $availability = 'in stock';
        } elseif ($product->allow_backorder ?? false) {
            $availability = 'preorder';
        }

        $this->update(['availability' => $availability]);
    }

    /**
     * Get status badge color
     */
    public function getStatusBadgeAttribute()
    {
        return match($this->status) {
            'synced' => 'badge-success',
            'pending' => 'badge-warning',
            'failed' => 'badge-danger',
            default => 'badge-secondary',
        };
    }
}

