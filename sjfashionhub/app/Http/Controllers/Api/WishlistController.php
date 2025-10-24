<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WishlistController extends Controller
{
    /**
     * Get user wishlist
     */
    public function index(Request $request)
    {
        $wishlistItems = Wishlist::where('user_id', $request->user()->id)
            ->with(['product.images', 'product.category'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item) {
                return $this->formatWishlistItem($item);
            });

        return response()->json([
            'success' => true,
            'data' => $wishlistItems
        ]);
    }

    /**
     * Remove item from wishlist
     */
    public function destroy(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $wishlistItem = Wishlist::where('user_id', $request->user()->id)
            ->where('product_id', $request->product_id)
            ->first();

        if (!$wishlistItem) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in wishlist'
            ], 404);
        }

        $wishlistItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from wishlist'
        ]);
    }

    /**
     * Format wishlist item data for API response
     */
    private function formatWishlistItem($wishlistItem)
    {
        $product = $wishlistItem->product;
        $images = $product->images->pluck('image_path')->map(function ($path) {
            return asset('storage/' . $path);
        })->toArray();

        return [
            'id' => $wishlistItem->id,
            'product_id' => $product->id,
            'product_name' => $product->name,
            'product_slug' => $product->slug,
            'price' => number_format($product->price, 2),
            'sale_price' => $product->sale_price ? number_format($product->sale_price, 2) : null,
            'image' => $images[0] ?? null,
            'in_stock' => $product->stock_quantity > 0,
            'rating' => $product->rating ?? 0,
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name
            ] : null,
            'added_at' => $wishlistItem->created_at->format('Y-m-d H:i:s')
        ];
    }
}
