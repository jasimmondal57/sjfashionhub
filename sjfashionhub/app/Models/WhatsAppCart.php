<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsAppCart extends Model
{
    protected $table = 'whatsapp_carts';

    protected $fillable = [
        'phone_number',
        'user_id',
        'product_id',
        'variant_id',
        'quantity',
        'price'
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'decimal:2'
    ];

    /**
     * Get the user
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variant
     */
    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }

    /**
     * Get cart items for a phone number
     */
    public static function getCartItems($phoneNumber)
    {
        return self::where('phone_number', $phoneNumber)
            ->with(['product', 'variant'])
            ->get();
    }

    /**
     * Get cart total
     */
    public static function getCartTotal($phoneNumber)
    {
        return self::where('phone_number', $phoneNumber)
            ->get()
            ->sum(function ($item) {
                return $item->price * $item->quantity;
            });
    }

    /**
     * Get cart count
     */
    public static function getCartCount($phoneNumber)
    {
        return self::where('phone_number', $phoneNumber)->sum('quantity');
    }

    /**
     * Add item to cart
     */
    public static function addItem($phoneNumber, $productId, $quantity = 1, $variantId = null)
    {
        $product = Product::find($productId);
        
        if (!$product) {
            throw new \Exception('Product not found');
        }

        $price = $product->sale_price ?? $product->price;

        // Check if item already exists
        $cartItem = self::where('phone_number', $phoneNumber)
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
            $cartItem->save();
        } else {
            $cartItem = self::create([
                'phone_number' => $phoneNumber,
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
                'price' => $price
            ]);
        }

        return $cartItem;
    }

    /**
     * Update quantity
     */
    public static function updateQuantity($phoneNumber, $productId, $quantity, $variantId = null)
    {
        $cartItem = self::where('phone_number', $phoneNumber)
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->first();

        if ($cartItem) {
            if ($quantity <= 0) {
                $cartItem->delete();
                return null;
            }
            
            $cartItem->quantity = $quantity;
            $cartItem->save();
            return $cartItem;
        }

        return null;
    }

    /**
     * Remove item from cart
     */
    public static function removeItem($phoneNumber, $productId, $variantId = null)
    {
        return self::where('phone_number', $phoneNumber)
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->delete();
    }

    /**
     * Clear cart
     */
    public static function clearCart($phoneNumber)
    {
        return self::where('phone_number', $phoneNumber)->delete();
    }

    /**
     * Get subtotal for this item
     */
    public function getSubtotalAttribute()
    {
        return $this->price * $this->quantity;
    }
}

