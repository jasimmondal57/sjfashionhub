<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShippingSetting;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page
     */
    public function index()
    {
        // Get cart items
        $cartItems = Cart::getCartItems();
        
        // If cart is empty, redirect to cart page
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Please add items before checkout.');
        }
        
        $cartTotal = Cart::getCartTotal();
        $cartCount = Cart::getCartCount();
        
        // Calculate totals with inclusive GST (reverse calculation)
        // Product prices include GST based on their individual tax_rate
        $total_with_tax = $cartTotal; // This is the final amount for products

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

        // Get shipping cost from settings
        $shippingSettings = ShippingSetting::getSettings();
        $shipping = $shippingSettings->calculateShipping($cartTotal);

        $total = $subtotal + $shipping + $tax; // Final total
        
        return view('checkout.index', compact(
            'cartItems', 
            'cartTotal', 
            'cartCount', 
            'subtotal', 
            'shipping', 
            'tax', 
            'total'
        ));
    }
    
    /**
     * Process the checkout
     */
    public function process(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'pincode' => 'required|string|max:10',
            'payment_method' => 'required|string|in:cod,online',
            'coupon_code' => 'nullable|string|max:50',
            'coupon_discount' => 'nullable|numeric|min:0',
        ]);
        
        // Get cart items
        $cartItems = Cart::getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate totals with inclusive GST (reverse calculation)
        $cartItems = Cart::getCartItems();
        $cartTotal = Cart::getCartTotal();
        $total_with_tax = $cartTotal; // Product prices include tax

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

        // Get shipping cost from settings
        $shippingSettings = ShippingSetting::getSettings();
        $shipping = $shippingSettings->calculateShipping($cartTotal);

        $total = $subtotal + $shipping + $tax; // Final total

        // Handle coupon discount
        $couponCode = null;
        $couponDiscount = 0;
        $appliedCoupon = null;

        if ($request->filled('coupon_code') && $request->filled('coupon_discount')) {
            $couponCode = strtoupper($request->coupon_code);
            $couponDiscount = (float) $request->coupon_discount;

            // Validate the coupon again for security
            $appliedCoupon = \App\Models\Coupon::where('code', $couponCode)->first();
            if ($appliedCoupon && $appliedCoupon->isValid() && $appliedCoupon->canBeUsedBy(Auth::id(), $total)) {
                $calculatedDiscount = $appliedCoupon->calculateDiscount($total, $shipping);

                // Ensure the discount matches what was calculated on frontend
                if (abs($calculatedDiscount - $couponDiscount) < 0.01) {
                    $total -= $couponDiscount;
                } else {
                    // Discount mismatch, recalculate
                    $couponDiscount = $calculatedDiscount;
                    $total -= $couponDiscount;
                }
            } else {
                // Invalid coupon, reset discount
                $couponCode = null;
                $couponDiscount = 0;
                $appliedCoupon = null;
            }
        }

        try {
            DB::beginTransaction();

            // Generate unique order number
            $orderNumber = 'ORD-' . date('Y') . '-' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);

            // Ensure order number is unique
            while (Order::where('order_number', $orderNumber)->exists()) {
                $orderNumber = 'ORD-' . date('Y') . '-' . str_pad(rand(100000, 999999), 6, '0', STR_PAD_LEFT);
            }

            // Create order
            $order = Order::create([
                'order_number' => $orderNumber,
                'user_id' => Auth::id(),
                'order_status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'shipping_amount' => $shipping,
                'discount_amount' => $couponDiscount,
                'coupon_code' => $couponCode,
                'total_amount' => $total,
                'currency' => 'INR',
                'is_cod' => $request->payment_method === 'cod',
                'cod_amount' => $request->payment_method === 'cod' ? $total : 0,
                'billing_address' => [
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'pincode' => $request->pincode,
                ],
                'shipping_address' => [
                    'full_name' => $request->full_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'pincode' => $request->pincode,
                ],
            ]);

            // Create order items
            foreach ($cartItems as $cartItem) {
                $price = $cartItem->product->sale_price ?? $cartItem->product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'unit_price' => $price,
                    'total_price' => $price * $cartItem->quantity,
                    'product_name' => $cartItem->product->name,
                    'product_sku' => $cartItem->product->sku ?? '',
                ]);
            }

            // Increment coupon usage if coupon was applied
            if ($appliedCoupon) {
                $appliedCoupon->incrementUsage();
            }

            // Clear cart after successful order
            Cart::clearCart();

            DB::commit();

            return redirect()->route('checkout.success')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Order creation failed: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->withErrors(['error' => 'Failed to place order: ' . $e->getMessage()])->withInput();
        }
    }
    
    /**
     * Show order success page
     */
    public function success()
    {
        return view('checkout.success');
    }
}
