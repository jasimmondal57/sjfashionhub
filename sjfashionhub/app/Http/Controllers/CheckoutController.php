<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

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
        
        // Calculate totals
        $subtotal = $cartTotal;
        $shipping = 99; // Fixed shipping cost
        $tax = $cartTotal * 0.18; // 18% GST
        $total = $subtotal + $shipping + $tax;
        
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
        ]);
        
        // Get cart items
        $cartItems = Cart::getCartItems();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        // Calculate totals
        $cartTotal = Cart::getCartTotal();
        $subtotal = $cartTotal;
        $shipping = 99; // Fixed shipping cost
        $tax = $cartTotal * 0.18; // 18% GST
        $total = $subtotal + $shipping + $tax;

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'user_id' => Auth::id(),
                'order_status' => 'pending',
                'payment_status' => 'pending',
                'payment_method' => $request->payment_method,
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'shipping_amount' => $shipping,
                'discount_amount' => 0,
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

            // Generate order number
            $order->order_number = $order->generateOrderNumber();
            $order->save();

            // Create order items
            foreach ($cartItems as $cartItem) {
                $price = $cartItem->product->sale_price ?? $cartItem->product->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $price,
                    'total' => $price * $cartItem->quantity,
                    'product_name' => $cartItem->product->name,
                    'product_sku' => $cartItem->product->sku ?? '',
                ]);
            }

            // Clear cart after successful order
            Cart::clearCart();

            DB::commit();

            return redirect()->route('checkout.success')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withErrors(['error' => 'Failed to place order. Please try again.'])->withInput();
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
