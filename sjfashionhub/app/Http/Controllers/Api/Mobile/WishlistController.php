<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    /**
     * Get user's wishlist
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        $wishlistItems = Wishlist::where('user_id', $user->id)
            ->with('product')
            ->get()
            ->map(function ($item) {
                $product = $item->product;

                // Get product images
                $images = [];
                if ($product->images) {
                    $imageArray = is_string($product->images) ? json_decode($product->images, true) : $product->images;
                    if (is_array($imageArray)) {
                        foreach ($imageArray as $img) {
                            $images[] = url('storage/' . $img);
                        }
                    }
                }

                return [
                    'id' => $item->id,
                    'product' => [
                        'id' => $product->id,
                        'name' => $product->name,
                        'slug' => $product->slug,
                        'description' => $product->description,
                        'price' => $product->price,
                        'sale_price' => $product->sale_price,
                        'image' => $product->image ? url('storage/' . $product->image) : null,
                        'images' => $images,
                        'in_stock' => $product->stock > 0,
                        'stock' => $product->stock,
                        'rating' => $product->rating ?? 0,
                    ],
                    'added_at' => $item->created_at->toDateTimeString(),
                ];
            });

        return response()->json([
            'wishlist_items' => $wishlistItems,
            'items_count' => $wishlistItems->count(),
        ]);
    }

    /**
     * Add product to wishlist
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $user = $request->user();

        // Check if already in wishlist
        $exists = Wishlist::where('user_id', $user->id)
            ->where('product_id', $validated['product_id'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Product already in wishlist',
            ], 400);
        }

        $wishlistItem = Wishlist::create([
            'user_id' => $user->id,
            'product_id' => $validated['product_id'],
        ]);

        return response()->json([
            'message' => 'Product added to wishlist',
            'wishlist_item' => [
                'id' => $wishlistItem->id,
            ],
        ], 201);
    }

    /**
     * Remove product from wishlist
     */
    public function destroy(Request $request, $productId)
    {
        $user = $request->user();
        
        $wishlistItem = Wishlist::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if (!$wishlistItem) {
            return response()->json([
                'message' => 'Product not found in wishlist',
            ], 404);
        }

        $wishlistItem->delete();

        return response()->json([
            'message' => 'Product removed from wishlist',
        ]);
    }
}

