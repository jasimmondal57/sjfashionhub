<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Banner;
use App\Models\MobileAppBanner;
use App\Models\MobileAppFeaturedCategory;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Get homepage data
     */
    public function homepageData(Request $request)
    {
        try {
            // Get featured categories (limit 8) - since there's no is_featured field, get all active categories
            $categories = Category::where('is_active', true)
                ->limit(8)
                ->get()
                ->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                        'image' => $category->image ? asset('storage/' . $category->image) : null,
                        'products_count' => $category->products()->count()
                    ];
                });

            // Get featured products (limit 10)
            $featuredProducts = Product::where('is_featured', true)
                ->where('is_active', true)
                ->with(['category'])
                ->limit(10)
                ->get()
                ->map(function ($product) {
                    return $this->formatProduct($product);
                });

            // Get product grid (all active products, limit 10)
            $productGrid = Product::where('is_active', true)
                ->with(['category'])
                ->limit(10)
                ->get()
                ->map(function ($product) {
                    return $this->formatProduct($product);
                });

            // Get product carousel (top-rated products, limit 10)
            $productCarousel = Product::where('is_active', true)
                ->orderBy('rating', 'desc')
                ->with(['category'])
                ->limit(10)
                ->get()
                ->map(function ($product) {
                    return $this->formatProduct($product);
                });

            // Get banners
            $banners = Banner::where('is_active', true)
                ->orderBy('sort_order')
                ->get()
                ->map(function ($banner) {
                    return [
                        'id' => $banner->id,
                        'title' => $banner->title,
                        'image' => $banner->image_path ? asset('storage/' . $banner->image_path) : null,
                        'link' => $banner->custom_link ?? $banner->button_link,
                        'sort_order' => $banner->sort_order
                    ];
                });

            // Build sections array
            $sections = [
                [
                    'id' => 1,
                    'title' => 'Main Banners',
                    'type' => 'banner',
                    'items' => $banners
                ],
                [
                    'id' => 2,
                    'title' => 'Featured Categories',
                    'type' => 'category',
                    'items' => $categories
                ],
                [
                    'id' => 3,
                    'title' => 'Featured Products',
                    'type' => 'featured',
                    'items' => $featuredProducts
                ],
                [
                    'id' => 4,
                    'title' => 'Product Grid',
                    'type' => 'product_grid',
                    'items' => $productGrid
                ],
                [
                    'id' => 5,
                    'title' => 'Product Carousel',
                    'type' => 'product_carousel',
                    'items' => $productCarousel
                ]
            ];

            return response()->json([
                'success' => true,
                'sections' => $sections
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load homepage data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Format product data for API response
     */
    private function formatProduct($product)
    {
        // Use the image_urls accessor from the Product model
        $images = $product->image_urls ?? [];

        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => number_format($product->price, 2),
            'sale_price' => $product->sale_price ? number_format($product->sale_price, 2) : null,
            'image' => $product->main_image,
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
     * Get mobile app home data with banners and featured categories
     */
    public function mobileHomeData(Request $request)
    {
        try {
            // Get mobile app banners
            $banners = MobileAppBanner::getActive();
            $formattedBanners = $banners->map(function ($banner) {
                return [
                    'id' => $banner->id,
                    'title' => $banner->title,
                    'image' => $banner->image ? url('storage/' . $banner->image) : null,
                    'link_type' => $banner->link_type,
                    'link_value' => $banner->link_value,
                    'order' => $banner->order,
                ];
            });

            // Get featured categories (limit 4 for mobile app display)
            $featuredCategories = MobileAppFeaturedCategory::getActive(4);
            $formattedCategories = $featuredCategories->map(function ($featuredCategory) {
                $category = $featuredCategory->category;
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image' => $category->image ? asset('storage/' . $category->image) : null,
                    'products_count' => $category->products()->count(),
                    'order' => $featuredCategory->order,
                ];
            });

            $sections = [
                [
                    'id' => 1,
                    'title' => 'Mobile App Banners',
                    'type' => 'mobile_banner',
                    'items' => $formattedBanners,
                ],
                [
                    'id' => 2,
                    'title' => 'Shop by Category',
                    'type' => 'featured_categories',
                    'items' => $formattedCategories,
                ]
            ];

            return response()->json([
                'success' => true,
                'sections' => $sections,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch mobile home data',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
