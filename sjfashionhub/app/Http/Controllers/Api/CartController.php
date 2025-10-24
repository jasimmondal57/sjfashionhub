<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CartController extends Controller
{
    /**
     * Get cart items
     */
    public function index(Request $request)
    {
        $cartItems = Cart::where('user_id', $request->user()->id)
            ->with(['product', 'product.category'])
            ->get()
            ->map(function ($item) {
                return $this->formatCartItem($item);
            });

        $subtotal = $cartItems->sum('total');
        $tax = $subtotal * 0.1; // 10% tax
        $total = $subtotal + $tax;

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $cartItems,
                'summary' => [
                    'subtotal' => number_format($subtotal, 2),
                    'tax' => number_format($tax, 2),
                    'total' => number_format($total, 2),
                    'items_count' => $cartItems->count()
                ]
            ]
        ]);
    }

    /**
     * Add item to cart
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'product_variant_id' => 'nullable|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::find($request->product_id);

        if (!$product->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Product is not available'
            ], 400);
        }

        // Check if item already exists in cart
        $existingItem = Cart::where('user_id', $request->user()->id)
            ->where('product_id', $request->product_id)
            ->where('product_variant_id', $request->product_variant_id)
            ->first();

        if ($existingItem) {
            // Update quantity
            $existingItem->quantity += $request->quantity;
            $existingItem->save();
            $cartItem = $existingItem;
        } else {
            // Create new cart item
            $cartItem = Cart::create([
                'user_id' => $request->user()->id,
                'product_id' => $request->product_id,
                'product_variant_id' => $request->product_variant_id,
                'quantity' => $request->quantity
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart successfully',
            'data' => $this->formatCartItem($cartItem->load(['product', 'product.category']))
        ]);
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $cartItem = Cart::where('id', $request->cart_id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        // Check stock availability
        $availableStock = $cartItem->variant 
            ? $cartItem->variant->stock_quantity 
            : $cartItem->product->stock_quantity;

        if ($request->quantity > $availableStock) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available'
            ], 400);
        }

        $cartItem->update([
            'quantity' => $request->quantity
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully',
            'data' => $this->formatCartItem($cartItem->fresh(['product', 'product.category']))
        ]);
    }

    /**
     * Select/unselect all items
     */
    public function selectAll(Request $request)
    {
        $selected = $request->boolean('selected', true);

        Cart::where('user_id', $request->user()->id)
            ->update(['is_selected' => $selected]);

        return response()->json([
            'success' => true,
            'message' => $selected ? 'All items selected' : 'All items unselected'
        ]);
    }

    /**
     * Select/unselect seller items
     */
    public function selectSellerItems(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'seller_id' => 'required|integer',
            'selected' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        Cart::where('user_id', $request->user()->id)
            ->whereHas('product', function ($query) use ($request) {
                $query->where('seller_id', $request->seller_id);
            })
            ->update(['is_selected' => $request->selected]);

        return response()->json([
            'success' => true,
            'message' => 'Seller items updated successfully'
        ]);
    }

    /**
     * Select/unselect single item
     */
    public function selectItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|exists:carts,id',
            'selected' => 'required|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $cartItem = Cart::where('id', $request->cart_id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cartItem->update(['is_selected' => $request->selected]);

        return response()->json([
            'success' => true,
            'message' => 'Item updated successfully'
        ]);
    }

    /**
     * Remove all cart items
     */
    public function removeAll(Request $request)
    {
        Cart::where('user_id', $request->user()->id)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }

    /**
     * Remove single cart item
     */
    public function removeItem(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart_id' => 'required|exists:carts,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $cartItem = Cart::where('id', $request->cart_id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found'
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart'
        ]);
    }

    /**
     * Update shipping method
     */
    public function updateShippingMethod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_method_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Update user's preferred shipping method
        $request->user()->update([
            'preferred_shipping_method_id' => $request->shipping_method_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Shipping method updated successfully'
        ]);
    }

    /**
     * Format cart item data for API response
     */
    private function formatCartItem($cartItem)
    {
        $product = $cartItem->product;

        $price = $product->price;
        $salePrice = $product->sale_price;
        $finalPrice = $salePrice ?? $price;

        // Get product images
        $images = [];
        if ($product->image) {
            $images[] = $product->image;
        }
        if (isset($product->images) && is_array($product->images)) {
            $images = array_merge($images, $product->images);
        }

        return [
            'id' => $cartItem->id,
            'product_id' => $product->id,
            'variant_id' => $cartItem->product_variant_id,
            'product_name' => $product->name,
            'variant_name' => null,
            'price' => number_format($price, 2),
            'sale_price' => $salePrice ? number_format($salePrice, 2) : null,
            'final_price' => number_format($finalPrice, 2),
            'quantity' => $cartItem->quantity,
            'total' => number_format($finalPrice * $cartItem->quantity, 2),
            'image' => $images[0] ?? null,
            'is_selected' => $cartItem->is_selected ?? false,
            'stock_available' => $product->stock ?? 0,
            'category' => $product->category ? [
                'id' => $product->category->id,
                'name' => $product->category->name
            ] : null
        ];
    }
}
