<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Get products list
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 20);
        $category = $request->get('category');
        $search = $request->get('search');
        
        $query = Product::where('is_active', true);
        
        if ($category) {
            $query->where('category_id', $category);
        }
        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        $products = $query->paginate($perPage);
        
        return response()->json([
            'products' => $products->map(function ($product) {
                return $this->formatProduct($product);
            }),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ],
        ]);
    }

    /**
     * Get single product
     */
    public function show($id)
    {
        $product = Product::where('is_active', true)->findOrFail($id);
        
        return response()->json([
            'product' => $this->formatProduct($product, true),
        ]);
    }

    /**
     * Format product data
     */
    private function formatProduct($product, $detailed = false)
    {
        $data = [
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
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'slug' => $product->category->slug,
            ] : null,
        ];
        
        if ($detailed) {
            $data['long_description'] = $product->long_description;
            $data['specifications'] = $product->specifications;
            $data['sku'] = $product->sku;
            $data['weight'] = $product->weight;
            $data['dimensions'] = $product->dimensions;
        }
        
        return $data;
    }
}

