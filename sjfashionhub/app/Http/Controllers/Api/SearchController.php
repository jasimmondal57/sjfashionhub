<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    /**
     * Live search functionality
     */
    public function liveSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'query' => 'required|string|min:2',
            'limit' => 'nullable|integer|min:1|max:50'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $query = $request->get('query');
        $limit = $request->get('limit', 10);

        // Search products
        $products = Product::where('status', 'active')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', '%' . $query . '%')
                  ->orWhere('description', 'like', '%' . $query . '%')
                  ->orWhere('sku', 'like', '%' . $query . '%');
            })
            ->with(['images', 'category'])
            ->limit($limit)
            ->get()
            ->map(function ($product) {
                return $this->formatProduct($product);
            });

        // Search categories
        $categories = Category::where('status', 'active')
            ->where('name', 'like', '%' . $query . '%')
            ->limit(5)
            ->get()
            ->map(function ($category) {
                return [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'image' => $category->image ? asset('storage/' . $category->image) : null,
                    'type' => 'category'
                ];
            });

        // Search brands
        $brands = Brand::where('status', 'active')
            ->where('name', 'like', '%' . $query . '%')
            ->limit(5)
            ->get()
            ->map(function ($brand) {
                return [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'slug' => $brand->slug,
                    'logo' => $brand->logo ? asset('storage/' . $brand->logo) : null,
                    'type' => 'brand'
                ];
            });

        return response()->json([
            'success' => true,
            'data' => [
                'products' => $products,
                'categories' => $categories,
                'brands' => $brands,
                'total_results' => $products->count() + $categories->count() + $brands->count()
            ]
        ]);
    }

    /**
     * Format product data for search results
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
            'price' => number_format($product->price, 2),
            'sale_price' => $product->sale_price ? number_format($product->sale_price, 2) : null,
            'image' => $images[0] ?? null,
            'rating' => $product->rating ?? 0,
            'in_stock' => $product->stock_quantity > 0,
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name
            ] : null,
            'type' => 'product'
        ];
    }
}
