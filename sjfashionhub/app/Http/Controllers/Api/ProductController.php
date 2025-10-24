<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Get all products
     */
    public function index(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with(['category', 'variants']);

        // Apply filters
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage);

        $formattedProducts = $products->getCollection()->map(function ($product) {
            return $this->formatProduct($product);
        });

        return response()->json([
            'success' => true,
            'data' => $formattedProducts,
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ]);
    }

    /**
     * Get single product
     */
    public function show($id, Request $request)
    {
        $product = Product::where('is_active', true)
            ->with(['category', 'variants'])
            ->find($id);

        if (!$product) {
            return response()->json([
                'message' => 'not found'
            ], 404);
        }

        // Format product for Flutter app (ProductModel compatible)
        $formattedProduct = $this->formatProductForFlutter($product);

        return response()->json([
            'data' => $formattedProduct
        ]);
    }

    /**
     * Get SKU wise price
     */
    public function getSkuWisePrice(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::find($request->product_id);
        $variant = null;

        if ($request->variant_id) {
            $variant = ProductVariant::where('product_id', $product->id)
                ->find($request->variant_id);
        }

        $price = $variant ? $variant->price : $product->price;
        $salePrice = $variant ? $variant->sale_price : $product->sale_price;
        $stock = $variant ? $variant->stock_quantity : $product->stock_quantity;

        return response()->json([
            'success' => true,
            'data' => [
                'price' => number_format($price, 2),
                'sale_price' => $salePrice ? number_format($salePrice, 2) : null,
                'stock' => $stock,
                'in_stock' => $stock > 0
            ]
        ]);
    }

    /**
     * Get recommended products
     */
    public function recommended(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $page = $request->get('page', 1);

        $query = Product::where('is_active', true)
            ->with(['category']);

        $total = $query->count();
        $products = $query->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get()
            ->map(function ($product) {
                return $this->formatProduct($product);
            });

        return response()->json([
            'success' => true,
            'data' => $products,
            'meta' => [
                'current_page' => (int) $page,
                'from' => ($page - 1) * $perPage + 1,
                'last_page' => ceil($total / $perPage),
                'path' => $request->url(),
                'per_page' => (int) $perPage,
                'to' => min($page * $perPage, $total),
                'total' => $total
            ]
        ]);
    }

    /**
     * Get top picks products
     */
    public function topPicks(Request $request)
    {
        $products = Product::where('is_active', true)
            ->orderBy('rating', 'desc')
            ->orderBy('sales_count', 'desc')
            ->with(['category'])
            ->limit(10)
            ->get()
            ->map(function ($product) {
                return $this->formatProduct($product);
            });

        return response()->json([
            'success' => true,
            'data' => $products
        ]);
    }

    /**
     * Sort products before filter
     */
    public function sortBeforeFilter(Request $request)
    {
        $sortOptions = [
            'name_asc' => ['name', 'asc'],
            'name_desc' => ['name', 'desc'],
            'price_asc' => ['price', 'asc'],
            'price_desc' => ['price', 'desc'],
            'rating_desc' => ['rating', 'desc'],
            'newest' => ['created_at', 'desc'],
            'oldest' => ['created_at', 'asc'],
        ];

        return response()->json([
            'success' => true,
            'data' => [
                'sort_options' => $sortOptions,
                'default_sort' => 'newest'
            ]
        ]);
    }

    /**
     * Filter fetch data
     */
    public function filterFetchData(Request $request)
    {
        $categories = \App\Models\Category::where('status', 'active')->get();
        $brands = \App\Models\Brand::where('status', 'active')->get();
        
        $priceRange = Product::where('status', 'active')
            ->selectRaw('MIN(price) as min_price, MAX(price) as max_price')
            ->first();

        return response()->json([
            'success' => true,
            'data' => [
                'categories' => $categories,
                'brands' => $brands,
                'price_range' => [
                    'min' => $priceRange->min_price ?? 0,
                    'max' => $priceRange->max_price ?? 1000
                ]
            ]
        ]);
    }

    /**
     * Filter products by type
     */
    public function filterByType(Request $request)
    {
        $query = Product::where('is_active', true)
            ->with(['category']);

        // Apply filters based on request
        if ($request->has('categories')) {
            $query->whereIn('category_id', $request->categories);
        }

        if ($request->has('brands')) {
            $query->whereIn('brand_id', $request->brands);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        if ($request->has('rating')) {
            $query->where('rating', '>=', $request->rating);
        }

        // Sorting
        if ($request->has('sort')) {
            $sortMap = [
                'price_low_high' => ['price', 'asc'],
                'price_high_low' => ['price', 'desc'],
                'rating' => ['rating', 'desc'],
                'newest' => ['created_at', 'desc'],
                'name_a_z' => ['name', 'asc'],
                'name_z_a' => ['name', 'desc'],
            ];

            if (isset($sortMap[$request->sort])) {
                $query->orderBy($sortMap[$request->sort][0], $sortMap[$request->sort][1]);
            }
        }

        $perPage = $request->get('per_page', 15);
        $products = $query->paginate($perPage);

        $formattedProducts = $products->getCollection()->map(function ($product) {
            return $this->formatProduct($product);
        });

        return response()->json([
            'success' => true,
            'data' => $formattedProducts,
            'pagination' => [
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
            ]
        ]);
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
     * Format product details for API response
     */
    private function formatProductDetails($product)
    {
        $data = $this->formatProduct($product);
        
        // Add additional details
        $data['variants'] = $product->variants->map(function ($variant) {
            return [
                'id' => $variant->id,
                'name' => $variant->name,
                'price' => number_format($variant->price, 2),
                'sale_price' => $variant->sale_price ? number_format($variant->sale_price, 2) : null,
                'stock' => $variant->stock_quantity,
                'attributes' => $variant->attributes ?? []
            ];
        });

        $data['reviews'] = $product->reviews->map(function ($review) {
            return [
                'id' => $review->id,
                'rating' => $review->rating,
                'comment' => $review->comment,
                'user_name' => $review->user->name ?? 'Anonymous',
                'created_at' => $review->created_at->format('Y-m-d H:i:s')
            ];
        });

        return $data;
    }

    /**
     * Format product for Flutter app (ProductModel compatible)
     */
    private function formatProductForFlutter($product)
    {
        // Get images array
        $images = $product->image_urls ?? [];

        // Set main image to first image if available
        $mainImage = null;
        if (!empty($images)) {
            $mainImage = $images[0];
            // Add full URL if not already present
            if (!str_starts_with($mainImage, 'http')) {
                $mainImage = asset($mainImage);
            }
        }

        // Calculate prices
        $price = (float) $product->price;
        $salePrice = $product->sale_price ? (float) $product->sale_price : null;
        $sellingPrice = $salePrice ?? $price;

        // Format for Flutter ProductModel (simple format)
        return [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => number_format($price, 2),
            'sale_price' => $salePrice ? number_format($salePrice, 2) : null,
            'image' => $mainImage,
            'images' => array_map(function($img) {
                return str_starts_with($img, 'http') ? $img : asset($img);
            }, $images),
            'is_featured' => $product->is_featured,
            'in_stock' => $product->stock_quantity > 0,
            'stock' => $product->stock_quantity,
            'rating' => $product->rating ?? 0,
            'category' => [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'slug' => $product->category->slug,
            ],
            // Additional fields that ProductModel might expect
            'short_description' => $product->short_description,
            'long_description' => $product->long_description,
            'sku' => $product->sku,
            'brand' => $product->brand,
            'weight' => $product->weight,
            'dimensions' => $product->dimensions,
            'meta_title' => $product->meta_title,
            'meta_description' => $product->meta_description,
        ];
    }
}
