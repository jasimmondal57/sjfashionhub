<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display the shopping cart
     */
    public function index()
    {
        $cartItems = Cart::getCartItems();
        $cartTotal = Cart::getCartTotal();
        $cartCount = Cart::getCartCount();

        return view('cart.index', compact('cartItems', 'cartTotal', 'cartCount'));
    }

    /**
     * Add item to cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant_id' => 'nullable|integer|exists:product_variants,id'
        ]);

        try {
            $cartItem = Cart::addItem(
                $request->product_id,
                $request->quantity,
                $request->variant_id
            );

            $cartCount = Cart::getCartCount();

            return response()->json([
                'success' => true,
                'message' => 'Product added to cart successfully!',
                'cart_count' => $cartCount,
                'cart_item' => $cartItem
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add product to cart: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update cart item quantity
     */
    public function updateQuantity(Request $request, $itemId)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $userId = Auth::id();
            $sessionId = session()->getId();

            $cartItem = Cart::where('id', $itemId)
                           ->where(function($query) use ($userId, $sessionId) {
                               if ($userId) {
                                   $query->where('user_id', $userId);
                               } else {
                                   $query->where('session_id', $sessionId);
                               }
                           })
                           ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!',
                'cart_count' => Cart::getCartCount(),
                'cart_total' => Cart::getCartTotal()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove item from cart
     */
    public function remove($itemId)
    {
        try {
            $removed = Cart::removeItem($itemId);

            if ($removed) {
                return response()->json([
                    'success' => true,
                    'message' => 'Item removed from cart successfully!',
                    'cart_count' => Cart::getCartCount(),
                    'cart_total' => Cart::getCartTotal()
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to remove item: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Clear entire cart
     */
    public function clear()
    {
        try {
            Cart::clearCart();

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully!',
                'cart_count' => 0,
                'cart_total' => 0
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear cart: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get cart count for header display
     */
    public function count()
    {
        try {
            $count = Cart::getCartCount();

            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            return response()->json(['count' => 0]);
        }
    }
}
