<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Product;

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
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
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
        
        // TODO: Create order logic here
        // For now, just redirect to a success page
        
        return redirect()->route('checkout.success')->with('success', 'Order placed successfully!');
    }
    
    /**
     * Show order success page
     */
    public function success()
    {
        return view('checkout.success');
    }
}
