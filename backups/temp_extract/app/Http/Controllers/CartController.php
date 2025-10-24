<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\ShippingSetting;
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

        // Calculate shipping using settings
        $shippingSettings = ShippingSetting::getSettings();
        $shipping = $shippingSettings->calculateShipping($cartTotal);

        // Calculate totals with inclusive GST (reverse calculation)
        // Product prices include GST based on their individual tax_rate
        $total_with_tax = $cartTotal; // This is the final amount customer pays

        // Calculate tax based on actual product tax rates
        $tax = 0;
        $subtotal = 0;

        foreach ($cartItems as $item) {
            $price = $item->product->sale_price ?? $item->product->price;
            $itemTotal = $price * $item->quantity;
            $taxRate = $item->product->tax_rate ?? 5; // Default to 5% if not set

            // Reverse GST calculation: tax portion from inclusive price
            $itemTax = $itemTotal * ($taxRate / (100 + $taxRate));
            $itemSubtotal = $itemTotal - $itemTax;

            $tax += $itemTax;
            $subtotal += $itemSubtotal;
        }

        $total = $subtotal + $shipping + $tax; // Final total (subtotal + shipping + tax)

        return view('cart.index', compact('cartItems', 'cartTotal', 'cartCount', 'subtotal', 'shipping', 'tax', 'total'));
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
                           ->with('product')
                           ->first();

            if (!$cartItem) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cart item not found'
                ], 404);
            }

            // Check stock availability
            $product = $cartItem->product;
            if ($product->manage_stock && $request->quantity > $product->stock_quantity) {
                return response()->json([
                    'success' => false,
                    'message' => "Only {$product->stock_quantity} items available in stock",
                    'max_quantity' => $product->stock_quantity
                ], 400);
            }

            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            return response()->json([
                'success' => true,
                'message' => 'Cart updated successfully!',
                'cart_count' => Cart::getCartCount(),
                'cart_total' => Cart::getCartTotal(),
                'item_total' => ($product->sale_price ?? $product->price) * $request->quantity
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update cart: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Calculate shipping cost for cart total
     */
    public function calculateShipping(Request $request)
    {
        $request->validate([
            'cart_total' => 'required|numeric|min:0',
            'state' => 'nullable|string',
            'country' => 'nullable|string'
        ]);

        try {
            $shippingSettings = ShippingSetting::getSettings();

            // Build destination array for location-based shipping
            $destination = null;
            if ($request->state || $request->country) {
                $destination = [
                    'state' => $request->state,
                    'country' => $request->country ?? 'India'
                ];
            }

            $shipping = $shippingSettings->calculateShipping(
                $request->cart_total,
                null, // weight
                $destination
            );

            return response()->json([
                'success' => true,
                'shipping' => $shipping,
                'is_free' => $shipping == 0,
                'method' => $shippingSettings->shipping_method,
                'destination' => $destination
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to calculate shipping: ' . $e->getMessage()
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
