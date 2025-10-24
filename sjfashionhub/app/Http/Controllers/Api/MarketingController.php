<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\FlashDeal;
use App\Models\NewUserZone;
use Illuminate\Http\Request;

class MarketingController extends Controller
{
    /**
     * Get new user zone data
     */
    public function newUserZone(Request $request)
    {
        $newUserZones = [
            [
                'id' => 1,
                'title' => 'Welcome Deals',
                'slug' => 'welcome-deals',
                'description' => 'Special offers for new customers',
                'image' => asset('images/marketing/welcome-deals.jpg'),
                'discount_percentage' => 20,
                'is_active' => true
            ],
            [
                'id' => 2,
                'title' => 'First Purchase Bonus',
                'slug' => 'first-purchase-bonus',
                'description' => 'Extra savings on your first order',
                'image' => asset('images/marketing/first-purchase.jpg'),
                'discount_percentage' => 15,
                'is_active' => true
            ],
            [
                'id' => 3,
                'title' => 'New Arrivals',
                'slug' => 'new-arrivals',
                'description' => 'Latest fashion trends just for you',
                'image' => asset('images/marketing/new-arrivals.jpg'),
                'discount_percentage' => 10,
                'is_active' => true
            ]
        ];

        return response()->json([
            'success' => true,
            'data' => $newUserZones
        ]);
    }

    /**
     * Get flash deals
     */
    public function flashDeal(Request $request)
    {
        $flashDeals = Product::where('status', 'active')
            ->where('is_flash_deal', true)
            ->where('flash_deal_start', '<=', now())
            ->where('flash_deal_end', '>=', now())
            ->with(['images', 'category'])
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return $this->formatFlashDealProduct($product);
            });

        return response()->json([
            'success' => true,
            'data' => [
                'deals' => $flashDeals,
                'current_time' => now()->timestamp,
                'deals_end_time' => now()->addHours(24)->timestamp // Example: deals end in 24 hours
            ]
        ]);
    }

    /**
     * Fetch new user product data
     */
    public function fetchNewUserProductData($slug, Request $request)
    {
        $products = Product::where('status', 'active')
            ->where('is_new_user_deal', true)
            ->with(['images', 'category'])
            ->limit(20)
            ->get()
            ->map(function ($product) {
                return $this->formatProduct($product);
            });

        return response()->json([
            'success' => true,
            'data' => [
                'slug' => $slug,
                'products' => $products
            ]
        ]);
    }

    /**
     * Fetch new user category all products
     */
    public function fetchNewUserCategoryAllProducts($slug, Request $request)
    {
        $categories = Category::where('status', 'active')
            ->where('is_new_user_featured', true)
            ->with(['products' => function ($query) {
                $query->where('status', 'active')->limit(5);
            }])
            ->limit(10)
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image' => $category->image ? asset('storage/' . $category->image) : null,
                    'products' => $category->products->map(function ($product) {
                        return $this->formatProduct($product);
                    })
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'slug' => $slug,
                'categories' => $categories
            ]
        ]);
    }

    /**
     * Fetch new user coupon all products
     */
    public function fetchNewUserCouponAllProducts($slug, Request $request)
    {
        $products = Product::where('status', 'active')
            ->where('has_coupon_discount', true)
            ->with(['images', 'category'])
            ->limit(20)
            ->get()
            ->map(function ($product) {
                return $this->formatProduct($product);
            });

        return response()->json([
            'success' => true,
            'data' => [
                'slug' => $slug,
                'products' => $products,
                'coupon_info' => [
                    'code' => 'NEWUSER20',
                    'discount' => '20%',
                    'description' => 'Use code NEWUSER20 for 20% off'
                ]
            ]
        ]);
    }

    /**
     * Fetch new user category products
     */
    public function fetchNewUserCategoryProducts($slug, Request $request)
    {
        $categoryId = $request->get('category_id');
        
        $query = Product::where('status', 'active')
            ->where('is_new_user_deal', true)
            ->with(['images', 'category']);

        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        $products = $query->limit(15)
            ->get()
            ->map(function ($product) {
                return $this->formatProduct($product);
            });

        return response()->json([
            'success' => true,
            'data' => [
                'slug' => $slug,
                'category_id' => $categoryId,
                'products' => $products
            ]
        ]);
    }

    /**
     * Fetch new user coupon products
     */
    public function fetchNewUserCouponProducts($slug, Request $request)
    {
        $products = Product::where('status', 'active')
            ->where('has_coupon_discount', true)
            ->with(['images', 'category'])
            ->limit(15)
            ->get()
            ->map(function ($product) {
                return $this->formatProduct($product);
            });

        return response()->json([
            'success' => true,
            'data' => [
                'slug' => $slug,
                'products' => $products,
                'coupon_code' => 'NEWUSER20'
            ]
        ]);
    }

    /**
     * Format product data for API response
     */
    private function formatProduct($product)
    {
        $images = $product->images->pluck('image_path')->map(function ($path) {
            return asset('storage/' . $path);
        })->toArray();

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => number_format($product->price, 2),
            'sale_price' => $product->sale_price ? number_format($product->sale_price, 2) : null,
            'image' => $images[0] ?? null,
            'images' => $images,
            'is_featured' => $product->is_featured,
            'in_stock' => $product->stock_quantity > 0,
            'stock' => $product->stock_quantity,
            'rating' => $product->rating ?? 0,
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'slug' => $product->category->slug
            ] : null
        ];
    }

    /**
     * Format flash deal product data for API response
     */
    private function formatFlashDealProduct($product)
    {
        $data = $this->formatProduct($product);
        
        // Add flash deal specific data
        $data['flash_deal'] = [
            'original_price' => number_format($product->price, 2),
            'deal_price' => number_format($product->flash_deal_price ?? $product->sale_price ?? $product->price, 2),
            'discount_percentage' => $product->flash_deal_discount ?? 0,
            'start_time' => $product->flash_deal_start ? $product->flash_deal_start->timestamp : null,
            'end_time' => $product->flash_deal_end ? $product->flash_deal_end->timestamp : null,
            'sold_count' => $product->flash_deal_sold ?? 0,
            'total_quantity' => $product->flash_deal_quantity ?? $product->stock_quantity
        ];

        return $data;
    }
}
