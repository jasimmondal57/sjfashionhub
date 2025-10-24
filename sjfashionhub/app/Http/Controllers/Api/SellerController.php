<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class SellerController extends Controller
{
    /**
     * Get seller profile
     */
    public function profile(Request $request)
    {
        $sellerId = $request->get('seller_id');
        
        if (!$sellerId) {
            return response()->json([
                'success' => false,
                'message' => 'Seller ID is required'
            ], 400);
        }

        $seller = User::where('id', $sellerId)
            ->where('role', 'seller')
            ->where('status', 'active')
            ->first();

        if (!$seller) {
            return response()->json([
                'success' => false,
                'message' => 'Seller not found'
            ], 404);
        }

        // Get seller statistics
        $totalProducts = Product::where('seller_id', $seller->id)
            ->where('status', 'active')
            ->count();

        $totalSales = $seller->orders()
            ->where('status', 'completed')
            ->sum('total_amount');

        $averageRating = $seller->reviews()
            ->avg('rating') ?? 0;

        $totalReviews = $seller->reviews()->count();

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $seller->id,
                'name' => $seller->name,
                'email' => $seller->email,
                'phone' => $seller->phone,
                'profile_photo' => $seller->profile_photo ? asset('storage/' . $seller->profile_photo) : null,
                'business_name' => $seller->business_name,
                'business_description' => $seller->business_description,
                'business_address' => $seller->business_address,
                'business_logo' => $seller->business_logo ? asset('storage/' . $seller->business_logo) : null,
                'joined_at' => $seller->created_at->format('Y-m-d'),
                'statistics' => [
                    'total_products' => $totalProducts,
                    'total_sales' => number_format($totalSales, 2),
                    'average_rating' => round($averageRating, 1),
                    'total_reviews' => $totalReviews,
                    'response_rate' => '95%', // Placeholder
                    'response_time' => '2 hours' // Placeholder
                ],
                'policies' => [
                    'return_policy' => $seller->return_policy ?? 'Standard return policy applies',
                    'shipping_policy' => $seller->shipping_policy ?? 'Standard shipping policy applies',
                    'warranty_policy' => $seller->warranty_policy ?? 'Manufacturer warranty applies'
                ],
                'social_links' => [
                    'website' => $seller->website,
                    'facebook' => $seller->facebook_url,
                    'instagram' => $seller->instagram_url,
                    'twitter' => $seller->twitter_url
                ]
            ]
        ]);
    }

    /**
     * Filter products by seller type
     */
    public function filterByType(Request $request)
    {
        $type = $request->get('type', 'all');
        $sellerId = $request->get('seller_id');

        $query = Product::where('status', 'active')
            ->with(['images', 'category', 'seller']);

        // Filter by seller if provided
        if ($sellerId) {
            $query->where('seller_id', $sellerId);
        }

        // Filter by type
        switch ($type) {
            case 'featured':
                $query->where('is_featured', true);
                break;
            case 'bestselling':
                $query->orderBy('sales_count', 'desc');
                break;
            case 'newest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price_low_high':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high_low':
                $query->orderBy('price', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            case 'discount':
                $query->whereNotNull('sale_price')
                      ->orderByRaw('((price - sale_price) / price) DESC');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        // Apply additional filters
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
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
            ],
            'filters' => [
                'type' => $type,
                'seller_id' => $sellerId
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
            'sales_count' => $product->sales_count ?? 0,
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name,
                'slug' => $product->category->slug
            ] : null,
            'seller' => $product->seller ? [
                'id' => $product->seller->id,
                'name' => $product->seller->name,
                'business_name' => $product->seller->business_name,
                'rating' => $product->seller->average_rating ?? 0
            ] : null
        ];
    }
}
