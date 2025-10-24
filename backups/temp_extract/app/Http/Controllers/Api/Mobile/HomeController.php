<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\MobileAppSection;
use App\Models\MobileAppBanner;
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
                $data['items'] = $this->getProducts($section->config);
                break;
        }

        return $data;
    }

    /**
     * Get active banners
     */
    private function getBanners()
    {
        return MobileAppBanner::getActive()
            ->map(function ($banner) {
                return [
                    'id' => $banner->id,
                    'title' => $banner->title,
                    'description' => $banner->description,
                    'image_url' => $banner->image_url ? url('storage/' . $banner->image_url) : null,
                    'link_type' => $banner->link_type,
                    'link_value' => $banner->link_value,
                ];
            });
    }

    /**
     * Get categories
     */
    private function getCategories($config = [])
    {
        $limit = $config['limit'] ?? 10;
        
        return Category::where('is_active', true)
            ->limit($limit)
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image' => $category->image ? url('storage/' . $category->image) : null,
                    'products_count' => $category->products()->count(),
                ];
            });
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
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'description' => $product->description,
                    'price' => $product->price,
                    'sale_price' => $product->sale_price,
                    'image' => $product->image ? url('storage/' . $product->image) : null,
                    'images' => $product->images ? array_map(function($img) {
                        return url('storage/' . $img);
                    }, $product->images) : [],
                    'is_featured' => $product->is_featured,
                    'in_stock' => $product->stock > 0,
                    'stock' => $product->stock,
                    'rating' => $product->rating ?? 0,
                ];
            });
    }
}

