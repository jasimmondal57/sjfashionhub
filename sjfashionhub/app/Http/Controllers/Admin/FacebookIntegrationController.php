<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FacebookSetting;
use App\Models\FacebookCatalogProduct;
use App\Models\FacebookSyncLog;
use App\Models\Product;
use App\Services\FacebookCatalogService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FacebookIntegrationController extends Controller
{
    protected $catalogService;

    public function __construct(FacebookCatalogService $catalogService)
    {
        $this->catalogService = $catalogService;
    }

    /**
     * Show Facebook integration settings
     */
    public function index()
    {
        $settings = FacebookSetting::getInstance();
        
        $stats = [
            'total_products' => Product::where('status', 'active')->count(),
            'synced_products' => FacebookCatalogProduct::where('status', 'synced')->count(),
            'pending_products' => FacebookCatalogProduct::where('status', 'pending')->count(),
            'failed_products' => FacebookCatalogProduct::where('status', 'failed')->count(),
            'last_sync' => $settings->last_sync_at,
        ];

        $recentLogs = FacebookSyncLog::latest()->take(10)->get();
        $catalogProducts = FacebookCatalogProduct::with('product')
            ->latest()
            ->paginate(20);

        return view('admin.facebook.index', compact('settings', 'stats', 'recentLogs', 'catalogProducts'));
    }

    /**
     * Update Facebook Pixel settings
     */
    public function updatePixel(Request $request)
    {
        $validated = $request->validate([
            'pixel_id' => 'nullable|string',
            'event_tracking' => 'nullable|array',
        ]);

        $settings = FacebookSetting::getInstance();

        // Process event tracking checkboxes
        $eventTracking = [];
        foreach (FacebookSetting::getDefaultEventTracking() as $event => $default) {
            $eventTracking[$event] = $request->has("event_tracking.{$event}");
        }

        $pixelEnabled = $request->has('pixel_enabled');

        $settings->update([
            'pixel_id' => $validated['pixel_id'] ?? null,
            'pixel_enabled' => $pixelEnabled,
            'event_tracking' => $eventTracking,
        ]);

        // Also update AnalyticsSetting for backward compatibility
        $analyticsSetting = \App\Models\AnalyticsSetting::first();
        if (!$analyticsSetting) {
            $analyticsSetting = new \App\Models\AnalyticsSetting();
        }

        $analyticsSetting->update([
            'facebook_pixel_id' => $validated['pixel_id'] ?? null,
            'facebook_pixel_enabled' => $pixelEnabled,
        ]);

        return back()->with('success', 'Facebook Pixel settings updated successfully!');
    }

    /**
     * Update Facebook Catalog settings
     */
    public function updateCatalog(Request $request)
    {
        $validated = $request->validate([
            'access_token' => 'nullable|string',
            'catalog_id' => 'nullable|string',
            'business_id' => 'nullable|string',
            'app_id' => 'nullable|string',
            'app_secret' => 'nullable|string',
            'sync_frequency_hours' => 'nullable|integer|min:1|max:168',
        ]);

        $settings = FacebookSetting::getInstance();

        // Only update access_token if a new one is provided (not the masked value)
        $updateData = [
            'catalog_id' => $validated['catalog_id'] ?? $settings->catalog_id,
            'business_id' => $validated['business_id'] ?? $settings->business_id,
            'app_id' => $validated['app_id'] ?? $settings->app_id,
            'catalog_sync_enabled' => $request->has('catalog_sync_enabled'),
            'auto_sync_inventory' => $request->has('auto_sync_inventory'),
            'auto_sync_prices' => $request->has('auto_sync_prices'),
            'sync_frequency_hours' => $validated['sync_frequency_hours'] ?? 6,
        ];

        // Update access_token only if it's not the masked value
        if (!empty($validated['access_token']) && $validated['access_token'] !== '••••••••') {
            $updateData['access_token'] = $validated['access_token'];
        }

        // Update app_secret only if it's not the masked value
        if (!empty($validated['app_secret']) && $validated['app_secret'] !== '••••••••') {
            $updateData['app_secret'] = $validated['app_secret'];
        }

        $settings->update($updateData);

        return back()->with('success', 'Facebook Catalog settings updated successfully!');
    }

    /**
     * Sync all products to Facebook catalog
     */
    public function syncAllProducts()
    {
        try {
            $result = $this->catalogService->syncAllProducts();
            
            return back()->with('success', "Synced {$result['synced']} products successfully! Failed: {$result['failed']}");
        } catch (\Exception $e) {
            Log::error('Facebook catalog sync failed', ['error' => $e->getMessage()]);
            return back()->with('error', 'Sync failed: ' . $e->getMessage());
        }
    }

    /**
     * Sync single product
     */
    public function syncProduct(Product $product)
    {
        try {
            $this->catalogService->syncProduct($product);
            
            return back()->with('success', "Product '{$product->name}' synced successfully!");
        } catch (\Exception $e) {
            Log::error('Facebook product sync failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
            
            return back()->with('error', 'Sync failed: ' . $e->getMessage());
        }
    }

    /**
     * Update inventory for a product
     */
    public function updateInventory(Product $product)
    {
        try {
            $this->catalogService->updateInventory($product);
            
            return back()->with('success', "Inventory updated for '{$product->name}'!");
        } catch (\Exception $e) {
            return back()->with('error', 'Update failed: ' . $e->getMessage());
        }
    }

    /**
     * Delete product from Facebook catalog
     */
    public function deleteProduct(Product $product)
    {
        try {
            $this->catalogService->deleteProduct($product);
            
            return back()->with('success', "Product removed from Facebook catalog!");
        } catch (\Exception $e) {
            return back()->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }

    /**
     * Generate and download product feed XML
     */
    public function downloadFeed()
    {
        try {
            $xml = $this->catalogService->generateProductFeed();
            
            return response($xml, 200)
                ->header('Content-Type', 'application/xml')
                ->header('Content-Disposition', 'attachment; filename="facebook-product-feed.xml"');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to generate feed: ' . $e->getMessage());
        }
    }

    /**
     * View sync logs
     */
    public function syncLogs()
    {
        $logs = FacebookSyncLog::latest()->paginate(50);
        
        return view('admin.facebook.sync-logs', compact('logs'));
    }

    /**
     * Test Facebook API connection
     */
    public function testConnection()
    {
        $settings = FacebookSetting::getInstance();
        
        if (!$settings->access_token || !$settings->catalog_id) {
            return response()->json([
                'success' => false,
                'message' => 'Access token and catalog ID are required'
            ]);
        }

        try {
            $response = \Illuminate\Support\Facades\Http::withToken($settings->access_token)
                ->get("https://graph.facebook.com/v18.0/{$settings->catalog_id}");

            if ($response->successful()) {
                $data = $response->json();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Connection successful!',
                    'catalog_name' => $data['name'] ?? 'Unknown',
                    'product_count' => $data['product_count'] ?? 0,
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => $response->json()['error']['message'] ?? 'Connection failed'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}

