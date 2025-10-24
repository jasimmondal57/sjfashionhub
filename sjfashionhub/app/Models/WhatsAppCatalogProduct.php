<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsAppCatalogProduct extends Model
{
    protected $table = 'whatsapp_catalog_products';

    protected $fillable = [
        'product_id', 'meta_product_id', 'retailer_id', 'sync_status',
        'last_synced_at', 'sync_error', 'meta_data'
    ];

    protected $casts = [
        'last_synced_at' => 'datetime',
        'meta_data' => 'array',
    ];

    // Relationships
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // Scopes
    public function scopeSynced($query)
    {
        return $query->where('sync_status', 'synced');
    }

    public function scopePending($query)
    {
        return $query->where('sync_status', 'pending');
    }

    public function scopeFailed($query)
    {
        return $query->where('sync_status', 'failed');
    }

    // Methods
    public function markAsSynced($metaProductId)
    {
        $this->update([
            'meta_product_id' => $metaProductId,
            'sync_status' => 'synced',
            'last_synced_at' => now(),
            'sync_error' => null,
        ]);
    }

    public function markAsFailed($error)
    {
        $this->update([
            'sync_status' => 'failed',
            'sync_error' => $error,
        ]);
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'synced' => 'bg-green-100 text-green-800',
            'failed' => 'bg-red-100 text-red-800',
        ];

        return $badges[$this->sync_status] ?? 'bg-gray-100 text-gray-800';
    }
}

