<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'product_id',
        'product_variant_id',
        'quantity'
    ];

    /**
     * Get the user that owns the cart item
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product for this cart item
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get cart items for current user or session
     */
    public static function getCartItems()
    {
        if (Auth::check()) {
            return self::where('user_id', Auth::id())
                       ->with('product')
                       ->get();
        } else {
            return self::where('session_id', session()->getId())
                       ->with('product')
                       ->get();
        }
    }

    /**
     * Add item to cart
     */
    public static function addItem($productId, $quantity = 1, $variantId = null)
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        // Check if item already exists in cart
        $cartItem = self::where('product_id', $productId)
                       ->where('product_variant_id', $variantId)
                       ->where(function($query) use ($userId, $sessionId) {
                           if ($userId) {
                               $query->where('user_id', $userId);
                           } else {
                               $query->where('session_id', $sessionId);
                           }
                       })
                       ->first();

        if ($cartItem) {
            // Update quantity
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            // Create new cart item
            $cartItem = self::create([
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'product_id' => $productId,
                'product_variant_id' => $variantId,
                'quantity' => $quantity
            ]);
        }

        return $cartItem;
    }

    /**
     * Get cart count
     */
    public static function getCartCount()
    {
        if (Auth::check()) {
            return self::where('user_id', Auth::id())->sum('quantity');
        } else {
            return self::where('session_id', session()->getId())->sum('quantity');
        }
    }

    /**
     * Get cart total
     */
    public static function getCartTotal()
    {
        $cartItems = self::getCartItems();
        $total = 0;

        foreach ($cartItems as $item) {
            $price = $item->product->sale_price ?? $item->product->price;
            $total += $price * $item->quantity;
        }

        return $total;
    }

    /**
     * Remove item from cart
     */
    public static function removeItem($cartItemId)
    {
        $userId = Auth::id();
        $sessionId = session()->getId();

        $cartItem = self::where('id', $cartItemId)
                       ->where(function($query) use ($userId, $sessionId) {
                           if ($userId) {
                               $query->where('user_id', $userId);
                           } else {
                               $query->where('session_id', $sessionId);
                           }
                       })
                       ->first();

        if ($cartItem) {
            $cartItem->delete();
            return true;
        }

        return false;
    }

    /**
     * Clear cart
     */
    public static function clearCart()
    {
        if (Auth::check()) {
            self::where('user_id', Auth::id())->delete();
        } else {
            self::where('session_id', session()->getId())->delete();
        }
    }
}
