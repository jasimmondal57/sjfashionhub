<?php

namespace App\Services;

use App\Models\FacebookSetting;
use App\Models\FacebookCatalogProduct;
use App\Models\FacebookSyncLog;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FacebookCatalogService
{
    protected $settings;
    protected $baseUrl = 'https://graph.facebook.com/v18.0';

    public function __construct()
    {
        $this->settings = FacebookSetting::getInstance();
    }

    /**
     * Sync all products to Facebook catalog
     */
    public function syncAllProducts()
    {
        if (!$this->settings->isCatalogConfigured()) {
            throw new \Exception('Facebook Catalog is not configured');
        }

        $log = FacebookSyncLog::start('full');

        try {
            $products = Product::where('status', 'active')->get();
            $synced = 0;
            $failed = 0;

            foreach ($products as $product) {
                try {
                    $this->syncProduct($product);
                    $synced++;
                } catch (\Exception $e) {
                    $failed++;
                    Log::error('Failed to sync product to Facebook', [
                        'product_id' => $product->id,
                        'error' => $e->getMessage()
                    ]);
                }
            }

            $log->complete($synced, $failed);
            
            $this->settings->update(['last_sync_at' => now()]);

            return [
                'success' => true,
                'synced' => $synced,
                'failed' => $failed,
            ];

        } catch (\Exception $e) {
            $log->fail($e->getMessage());
            throw $e;
        }
    }

    /**
     * Sync single product to Facebook catalog
     */
    public function syncProduct(Product $product)
    {
        if (!$this->settings->isCatalogConfigured()) {
            throw new \Exception('Facebook Catalog is not configured');
        }

        // Get or create catalog product record
        $catalogProduct = FacebookCatalogProduct::firstOrCreate(
            ['product_id' => $product->id]
        );

        // Prepare product data for Facebook
        $productData = $this->prepareProductData($product);

        try {
            // Use batch API for product upload
            // Remove fields that should not be in 'data' parameter
            $dataFields = $productData;
            unset($dataFields['id']); // retailer_id is used instead

            $batchData = [
                'requests' => [
                    [
                        'method' => 'UPDATE',
                        'retailer_id' => (string) $product->id,
                        'data' => $dataFields,
                    ]
                ]
            ];

            $response = Http::withToken($this->settings->access_token)
                ->post("{$this->baseUrl}/{$this->settings->catalog_id}/batch", $batchData);

            \Log::info('Facebook Catalog API Response', [
                'status' => $response->status(),
                'body' => $response->body(),
                'product_id' => $product->id,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $handles = $data['handles'] ?? [];

                if (!empty($handles)) {
                    $catalogProduct->markAsSynced($handles[0] ?? null, $data);

                    return [
                        'success' => true,
                        'facebook_product_id' => $handles[0] ?? null,
                    ];
                }

                // Log the full response for debugging
                \Log::error('No handle in Facebook response', ['response' => $data]);
                throw new \Exception('No handle returned from Facebook. Response: ' . json_encode($data));
            } else {
                $errorData = $response->json();
                $error = $errorData['error']['message'] ?? 'Unknown error';
                \Log::error('Facebook Catalog API Error', ['error' => $errorData]);
                $catalogProduct->markAsFailed($error);

                throw new \Exception($error);
            }

        } catch (\Exception $e) {
            $catalogProduct->markAsFailed($e->getMessage());
            throw $e;
        }
    }

    /**
     * Update product inventory in Facebook catalog
     */
    public function updateInventory(Product $product)
    {
        $catalogProduct = FacebookCatalogProduct::where('product_id', $product->id)->first();

        if (!$catalogProduct || !$catalogProduct->facebook_product_id) {
            // Product not synced yet, sync it first
            return $this->syncProduct($product);
        }

        try {
            $availability = $product->stock > 0 ? 'in stock' : 'out of stock';
            
            $response = Http::withToken($this->settings->access_token)
                ->post("{$this->baseUrl}/{$catalogProduct->facebook_product_id}", [
                    'availability' => $availability,
                    'inventory' => $product->stock,
                ]);

            if ($response->successful()) {
                $catalogProduct->update([
                    'availability' => $availability,
                    'last_synced_at' => now(),
                ]);
                
                return ['success' => true];
            }

            throw new \Exception($response->json()['error']['message'] ?? 'Failed to update inventory');

        } catch (\Exception $e) {
            Log::error('Failed to update Facebook inventory', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Update product price in Facebook catalog
     */
    public function updatePrice(Product $product)
    {
        $catalogProduct = FacebookCatalogProduct::where('product_id', $product->id)->first();

        if (!$catalogProduct || !$catalogProduct->facebook_product_id) {
            return $this->syncProduct($product);
        }

        try {
            $price = $product->sale_price ?? $product->price;
            
            $response = Http::withToken($this->settings->access_token)
                ->post("{$this->baseUrl}/{$catalogProduct->facebook_product_id}", [
                    'price' => number_format($price, 2, '.', '') . ' INR',
                ]);

            if ($response->successful()) {
                $catalogProduct->update(['last_synced_at' => now()]);
                return ['success' => true];
            }

            throw new \Exception($response->json()['error']['message'] ?? 'Failed to update price');

        } catch (\Exception $e) {
            Log::error('Failed to update Facebook price', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Delete product from Facebook catalog
     */
    public function deleteProduct(Product $product)
    {
        $catalogProduct = FacebookCatalogProduct::where('product_id', $product->id)->first();

        if (!$catalogProduct || !$catalogProduct->facebook_product_id) {
            return ['success' => true];
        }

        try {
            $response = Http::withToken($this->settings->access_token)
                ->delete("{$this->baseUrl}/{$catalogProduct->facebook_product_id}");

            if ($response->successful()) {
                $catalogProduct->delete();
                return ['success' => true];
            }

            throw new \Exception($response->json()['error']['message'] ?? 'Failed to delete product');

        } catch (\Exception $e) {
            Log::error('Failed to delete Facebook product', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Prepare product data for Facebook catalog batch API
     */
    private function prepareProductData(Product $product)
    {
        $price = $product->sale_price ?? $product->price;
        $regularPrice = $product->price;
        $stockQty = $product->stock_quantity ?? 0;
        $availability = $stockQty > 0 ? 'in stock' : 'out of stock';

        // Get primary image URL - images is a JSON array
        $images = $product->images ?? [];
        if (!empty($images) && is_array($images)) {
            $imageUrl = url('storage/' . $images[0]);
        } else {
            // Use a default placeholder image
            $imageUrl = url('images/placeholder.jpg');
        }

        // Get additional images
        $additionalImages = [];
        if (!empty($images) && is_array($images) && count($images) > 1) {
            // Skip first image (already used as primary)
            for ($i = 1; $i < min(count($images), 10); $i++) { // Max 10 additional images
                $additionalImages[] = url('storage/' . $images[$i]);
            }
        }

        // Add more from additional_images field if available
        if ($product->additional_images && is_array($product->additional_images)) {
            foreach ($product->additional_images as $img) {
                if (count($additionalImages) >= 10) break; // Max 10 additional images
                $additionalImages[] = url('storage/' . $img);
            }
        }

        // Ensure product URL is absolute
        $productUrl = route('products.show', $product->slug);

        // Facebook batch API expects price as integer in smallest currency unit (paise for INR)
        // 1 INR = 100 paise
        $priceInPaise = (int) round($price * 100);
        $regularPriceInPaise = (int) round($regularPrice * 100);

        // Get description - ensure it's not empty
        $description = strip_tags($product->description ?? $product->short_description ?? $product->name);
        if (empty($description)) {
            $description = $product->name;
        }

        // Prepare the data array with correct field names for batch API
        // Note: 'id' is passed as 'retailer_id' in the batch request, not in data
        // Only include fields that Facebook batch API actually supports
        $data = [
            // Core required fields
            'name' => substr($product->name, 0, 150), // Max 150 chars
            'description' => substr($description, 0, 5000), // Max 5000 chars
            'availability' => $availability,
            'condition' => 'new',
            'price' => $priceInPaise, // Price in paise (smallest currency unit)
            'currency' => 'INR', // Currency code
            'url' => $productUrl,
            'image_url' => $imageUrl,
            'brand' => $product->brand ?? 'SJ Fashion Hub',

            // Inventory/Stock - always include
            'inventory' => max(0, (int) $stockQty),
        ];

        // Add optional fields only if they have values
        if ($product->sale_price && $product->sale_price < $regularPrice) {
            $data['sale_price'] = $priceInPaise; // Sale price in paise
        }

        if ($product->category) {
            $data['category'] = $product->category->name;
        }

        if ($product->gender) {
            $data['gender'] = strtolower($product->gender);
        }

        if ($product->age_group) {
            $data['age_group'] = strtolower($product->age_group);
        }

        if ($product->color) {
            $data['color'] = $product->color;
        }

        if ($product->size) {
            $data['size'] = $product->size;
        }

        if ($product->material) {
            $data['material'] = $product->material;
        }

        if ($product->pattern) {
            $data['pattern'] = $product->pattern;
        }

        return $data;
    }

    /**
     * Generate product feed XML for Facebook
     */
    public function generateProductFeed()
    {
        $products = Product::where('status', 'active')->with('category')->get();

        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><rss version="2.0" xmlns:g="http://base.google.com/ns/1.0"></rss>');
        $channel = $xml->addChild('channel');
        $channel->addChild('title', 'SJ Fashion Hub Product Feed');
        $channel->addChild('link', url('/'));
        $channel->addChild('description', 'Product catalog for SJ Fashion Hub');

        foreach ($products as $product) {
            $item = $channel->addChild('item');

            // Required fields
            $item->addChild('g:id', $product->id, 'http://base.google.com/ns/1.0');
            $item->addChild('g:title', htmlspecialchars(substr($product->name, 0, 150)), 'http://base.google.com/ns/1.0');

            $description = strip_tags($product->description ?? $product->short_description ?? $product->name);
            $item->addChild('g:description', htmlspecialchars(substr($description, 0, 5000)), 'http://base.google.com/ns/1.0');

            $item->addChild('g:link', htmlspecialchars(route('products.show', $product->slug)), 'http://base.google.com/ns/1.0');

            $imageUrl = $product->image ? url('storage/' . $product->image) : url('images/placeholder.jpg');
            $item->addChild('g:image_link', htmlspecialchars($imageUrl), 'http://base.google.com/ns/1.0');

            $price = $product->sale_price ?? $product->price;
            $priceInPaise = (int) ($price * 100);
            $item->addChild('g:price', $priceInPaise, 'http://base.google.com/ns/1.0');

            $availability = $product->stock > 0 ? 'in stock' : 'out of stock';
            $item->addChild('g:availability', $availability, 'http://base.google.com/ns/1.0');

            $item->addChild('g:condition', 'new', 'http://base.google.com/ns/1.0');

            // Optional but recommended fields
            $item->addChild('g:brand', htmlspecialchars($product->brand ?? 'SJ Fashion Hub'), 'http://base.google.com/ns/1.0');

            if ($product->category) {
                $item->addChild('g:product_type', htmlspecialchars($product->category->name), 'http://base.google.com/ns/1.0');
            }

            if ($product->stock > 0) {
                $item->addChild('g:inventory', $product->stock, 'http://base.google.com/ns/1.0');
            }
        }

        return $xml->asXML();
    }
}

