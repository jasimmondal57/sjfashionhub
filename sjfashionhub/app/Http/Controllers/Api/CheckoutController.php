<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\ShippingMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Get checkout data
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Get selected cart items
        $cartItems = Cart::where('user_id', $user->id)
            ->where('is_selected', true)
            ->with(['product.images', 'variant'])
            ->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No items selected for checkout'
            ], 400);
        }

        // Calculate totals
        $subtotal = 0;
        $formattedItems = $cartItems->map(function ($item) use (&$subtotal) {
            $product = $item->product;
            $variant = $item->variant;
            
            $price = $variant ? $variant->price : $product->price;
            $salePrice = $variant ? $variant->sale_price : $product->sale_price;
            $finalPrice = $salePrice ?? $price;
            $itemTotal = $finalPrice * $item->quantity;
            $subtotal += $itemTotal;
            
            $images = $product->images->pluck('image_path')->map(function ($path) {
                return asset('storage/' . $path);
            })->toArray();

            return [
                'id' => $item->id,
                'product_id' => $product->id,
                'product_name' => $product->name,
                'variant_id' => $variant ? $variant->id : null,
                'variant_name' => $variant ? $variant->name : null,
                'price' => number_format($price, 2),
                'sale_price' => $salePrice ? number_format($salePrice, 2) : null,
                'final_price' => number_format($finalPrice, 2),
                'quantity' => $item->quantity,
                'total' => number_format($itemTotal, 2),
                'image' => $images[0] ?? null
            ];
        });

        // Get user addresses
        $addresses = Address::where('user_id', $user->id)
            ->orderBy('is_default', 'desc')
            ->get()
            ->map(function ($address) {
                return [
                    'id' => $address->id,
                    'type' => $address->type,
                    'name' => $address->name,
                    'phone' => $address->phone,
                    'full_address' => $this->getFullAddress($address),
                    'is_default' => $address->is_default
                ];
            });

        // Get shipping methods
        $shippingMethods = $this->getShippingMethods($subtotal);

        // Calculate costs
        $tax = $subtotal * 0.1; // 10% tax
        $defaultShipping = $shippingMethods->first()['cost'] ?? 50;
        $total = $subtotal + $tax + $defaultShipping;

        return response()->json([
            'success' => true,
            'data' => [
                'items' => $formattedItems,
                'addresses' => $addresses,
                'shipping_methods' => $shippingMethods,
                'payment_methods' => $this->getPaymentMethods(),
                'summary' => [
                    'subtotal' => number_format($subtotal, 2),
                    'tax' => number_format($tax, 2),
                    'shipping' => number_format($defaultShipping, 2),
                    'discount' => '0.00',
                    'total' => number_format($total, 2),
                    'items_count' => $cartItems->count()
                ]
            ]
        ]);
    }

    /**
     * Check price updates
     */
    public function checkPriceUpdate(Request $request)
    {
        $user = $request->user();
        
        $cartItems = Cart::where('user_id', $user->id)
            ->where('is_selected', true)
            ->with(['product', 'variant'])
            ->get();

        $priceChanges = [];
        $hasChanges = false;

        foreach ($cartItems as $item) {
            $product = $item->product;
            $variant = $item->variant;
            
            $currentPrice = $variant ? $variant->price : $product->price;
            $currentSalePrice = $variant ? $variant->sale_price : $product->sale_price;
            $currentStock = $variant ? $variant->stock_quantity : $product->stock_quantity;
            
            $changes = [];
            
            // Check if product is still available
            if ($product->status !== 'active') {
                $changes[] = 'Product is no longer available';
                $hasChanges = true;
            }
            
            // Check stock availability
            if ($currentStock < $item->quantity) {
                $changes[] = "Only {$currentStock} items available (you have {$item->quantity} in cart)";
                $hasChanges = true;
            }
            
            // You can add price change detection here if needed
            
            if (!empty($changes)) {
                $priceChanges[] = [
                    'cart_id' => $item->id,
                    'product_name' => $product->name,
                    'variant_name' => $variant ? $variant->name : null,
                    'changes' => $changes
                ];
            }
        }

        return response()->json([
            'success' => true,
            'data' => [
                'has_changes' => $hasChanges,
                'changes' => $priceChanges
            ]
        ]);
    }

    /**
     * Apply coupon
     */
    public function applyCoupon(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $couponCode = $request->coupon_code;
        
        // Find coupon
        $coupon = Coupon::where('code', $couponCode)
            ->where('status', 'active')
            ->where('starts_at', '<=', now())
            ->where('expires_at', '>=', now())
            ->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired coupon code'
            ], 400);
        }

        // Check usage limits
        if ($coupon->usage_limit && $coupon->used_count >= $coupon->usage_limit) {
            return response()->json([
                'success' => false,
                'message' => 'Coupon usage limit exceeded'
            ], 400);
        }

        // Calculate cart total
        $cartItems = Cart::where('user_id', $request->user()->id)
            ->where('is_selected', true)
            ->with(['product', 'variant'])
            ->get();

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $price = $item->variant ? $item->variant->price : $item->product->price;
            $salePrice = $item->variant ? $item->variant->sale_price : $item->product->sale_price;
            $finalPrice = $salePrice ?? $price;
            $subtotal += $finalPrice * $item->quantity;
        }

        // Check minimum order amount
        if ($coupon->minimum_amount && $subtotal < $coupon->minimum_amount) {
            return response()->json([
                'success' => false,
                'message' => "Minimum order amount of {$coupon->minimum_amount} required"
            ], 400);
        }

        // Calculate discount
        $discount = 0;
        if ($coupon->type === 'percentage') {
            $discount = ($subtotal * $coupon->value) / 100;
            if ($coupon->maximum_discount && $discount > $coupon->maximum_discount) {
                $discount = $coupon->maximum_discount;
            }
        } else {
            $discount = $coupon->value;
        }

        // Store coupon in session or cache for checkout
        session(['applied_coupon' => [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'discount' => $discount
        ]]);

        return response()->json([
            'success' => true,
            'message' => 'Coupon applied successfully',
            'data' => [
                'coupon_code' => $coupon->code,
                'discount_amount' => number_format($discount, 2),
                'discount_type' => $coupon->type,
                'discount_value' => $coupon->value
            ]
        ]);
    }

    /**
     * Tabby checkout (placeholder)
     */
    public function tabbyCheckout(Request $request)
    {
        // Placeholder for Tabby payment integration
        return response()->json([
            'success' => true,
            'message' => 'Tabby checkout not implemented yet',
            'data' => [
                'redirect_url' => null
            ]
        ]);
    }

    /**
     * Get shipping methods
     */
    private function getShippingMethods($subtotal)
    {
        $methods = collect([
            [
                'id' => 1,
                'name' => 'Standard Shipping',
                'description' => '5-7 business days',
                'cost' => $subtotal >= 100 ? 0 : 50,
                'estimated_days' => '5-7'
            ],
            [
                'id' => 2,
                'name' => 'Express Shipping',
                'description' => '2-3 business days',
                'cost' => 100,
                'estimated_days' => '2-3'
            ],
            [
                'id' => 3,
                'name' => 'Overnight Shipping',
                'description' => 'Next business day',
                'cost' => 200,
                'estimated_days' => '1'
            ]
        ]);

        return $methods;
    }

    /**
     * Get payment methods
     */
    private function getPaymentMethods()
    {
        return [
            ['id' => 'card', 'name' => 'Credit/Debit Card', 'icon' => 'card'],
            ['id' => 'paypal', 'name' => 'PayPal', 'icon' => 'paypal'],
            ['id' => 'stripe', 'name' => 'Stripe', 'icon' => 'stripe'],
            ['id' => 'cod', 'name' => 'Cash on Delivery', 'icon' => 'cash']
        ];
    }

    /**
     * Get formatted full address
     */
    private function getFullAddress($address)
    {
        $parts = [
            $address->address_line_1,
            $address->address_line_2,
            $address->city,
            $address->state,
            $address->country,
            $address->postal_code
        ];

        return implode(', ', array_filter($parts));
    }
}
