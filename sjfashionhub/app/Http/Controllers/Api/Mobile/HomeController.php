<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\MobileAppSection;
use App\Models\MobileAppBanner;
use App\Models\MobileAppFeaturedCategory;
use App\Models\Product;
use App\Models\Category;

class HomeController extends Controller
{
    /**
     * Get home screen data
     */
    public function index()
    {
        $sections = MobileAppSection::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->map(function ($section) {
                return $this->formatSection($section);
            });

        return response()->json([
            'sections' => $sections,
        ]);
    }

    /**
     * Format section data based on type
     */
    private function formatSection($section)
    {
        $data = [
            'id' => $section->id,
            'title' => $section->title,
            'description' => $section->description,
            'type' => $section->type,
            'config' => $section->config,
        ];

        switch ($section->type) {
            case 'banner':
                $data['items'] = $this->getBanners();
                break;

            case 'category':
                $data['items'] = $this->getCategories($section->config);
                break;

            case 'product_grid':
            case 'product_carousel':
            case 'featured':
            case 'deals':
            case 'category_products':
                $data['items'] = $this->getProducts($section->config);
                break;
        }

        return $data;
    }

    /**
     * Get active banners (ordered by mobile admin)
     */
    private function getBanners()
    {
        return MobileAppBanner::getActive()
            ->map(function ($banner) {
                return [
                    'id' => $banner->id,
                    'title' => $banner->title,
                    'description' => $banner->description,
                    'image_url' => $banner->image ? url('storage/' . $banner->image) : null,
                    'link_type' => $banner->link_type,
                    'link_value' => $banner->link_value,
                ];
            });
    }

    /**
     * Get categories (from Featured Categories managed in mobile admin)
     */
    private function getCategories($config = [])
    {
        $limit = $config['limit'] ?? 10;

        // Get featured categories in the order set by mobile admin
        return MobileAppFeaturedCategory::where('is_active', true)
            ->with('category')
            ->orderBy('order')
            ->limit($limit)
            ->get()
            ->map(function ($featuredCategory) {
                $category = $featuredCategory->category;
                if (!$category) {
                    return null;
                }

                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image' => $featuredCategory->image
                        ? url('storage/' . $featuredCategory->image)
                        : ($category->image ? url('storage/' . $category->image) : null),
                    'products_count' => $category->products()->where('is_active', true)->count(),
                ];
            })
            ->filter(); // Remove null entries
    }

    /**
     * Get products
     */
    private function getProducts($config = [])
    {
        $limit = $config['limit'] ?? 10;
        $categoryId = $config['category_id'] ?? null;
        
        $query = Product::where('is_active', true);
        
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }
        
        if (isset($config['featured']) && $config['featured']) {
            $query->where('is_featured', true);
        }
        
        if (isset($config['on_sale']) && $config['on_sale']) {
            $query->whereNotNull('sale_price');
        }
        
        return $query->limit($limit)
            ->with('category')
            ->get()
            ->map(function ($product) {
                // Get main image and convert to full URL
                $mainImage = $product->main_image;
                if ($mainImage && !str_starts_with($mainImage, 'http')) {
                    $mainImage = url($mainImage);
                }

                // Get all images and convert to full URLs
                $imageUrls = collect($product->image_urls)->map(function($url) {
                    if ($url && !str_starts_with($url, 'http')) {
                        return url($url);
                    }
                    return $url;
                })->toArray();

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => $product->description,
                    'price' => $product->price,
                    'sale_price' => $product->sale_price,
                    'image' => $mainImage,
                    'images' => $imageUrls,
                    'is_featured' => $product->is_featured,
                    'in_stock' => $product->stock_quantity > 0,
                    'stock' => $product->stock_quantity,
                    'rating' => $product->rating ?? 0,
                    'category_id' => $product->category_id,
                    'category' => $product->category ? [
                        'id' => $product->category->id,
                        'name' => $product->category->name,
                        'slug' => $product->category->slug,
                    ] : null,
                ];
            });
    }
}

