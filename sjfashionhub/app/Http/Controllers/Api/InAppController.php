<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class InAppController extends Controller
{
    /**
     * Add item to in-app cart
     */
    public function cartStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $product = Product::find($request->product_id);

        if ($product->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Product is not available'
            ], 400);
        }

        // Check stock availability
        $variant = null;
        if ($request->variant_id) {
            $variant = $product->variants()->find($request->variant_id);
            if (!$variant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product variant not found'
                ], 404);
            }
            $availableStock = $variant->stock_quantity;
        } else {
            $availableStock = $product->stock_quantity;
        }

        if ($request->quantity > $availableStock) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available'
            ], 400);
        }

        try {
            // Check if item already exists in cart
            $existingCartItem = Cart::where('user_id', $user->id)
                ->where('product_id', $request->product_id)
                ->where('variant_id', $request->variant_id)
                ->first();

            if ($existingCartItem) {
                // Update quantity
                $newQuantity = $existingCartItem->quantity + $request->quantity;
                
                if ($newQuantity > $availableStock) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Total quantity exceeds available stock'
                    ], 400);
                }

                $existingCartItem->update(['quantity' => $newQuantity]);
                $cartItem = $existingCartItem;
            } else {
                // Create new cart item
                $cartItem = Cart::create([
                    'user_id' => $user->id,
                    'product_id' => $request->product_id,
                    'variant_id' => $request->variant_id,
                    'quantity' => $request->quantity,
                    'is_selected' => true
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully',
                'data' => [
                    'cart_id' => $cartItem->id,
                    'product_id' => $cartItem->product_id,
                    'variant_id' => $cartItem->variant_id,
                    'quantity' => $cartItem->quantity
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to add item to cart',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create in-app purchase order
     */
    public function orderStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'transaction_id' => 'required|string',
            'receipt_data' => 'nullable|string', // For iOS receipt validation
            'purchase_token' => 'nullable|string', // For Android purchase validation
            'shipping_address' => 'required|array',
            'billing_address' => 'required|array'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user = $request->user();
        $product = Product::find($request->product_id);

        if ($product->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Product is not available'
            ], 400);
        }

        // Check stock availability
        $variant = null;
        if ($request->variant_id) {
            $variant = $product->variants()->find($request->variant_id);
            if (!$variant) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product variant not found'
                ], 404);
            }
            $availableStock = $variant->stock_quantity;
            $price = $variant->sale_price ?? $variant->price;
        } else {
            $availableStock = $product->stock_quantity;
            $price = $product->sale_price ?? $product->price;
        }

        if ($request->quantity > $availableStock) {
            return response()->json([
                'success' => false,
                'message' => 'Insufficient stock available'
            ], 400);
        }

        try {
            DB::beginTransaction();

            // Calculate totals
            $subtotal = $price * $request->quantity;
            $tax = $subtotal * 0.1; // 10% tax
            $shipping = 50; // Fixed shipping cost
            $total = $subtotal + $tax + $shipping;

            // Create order
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'IAP-' . time() . '-' . rand(1000, 9999),
                'status' => 'pending',
                'payment_status' => 'completed', // In-app purchases are pre-paid
                'delivery_status' => 'pending',
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'shipping_amount' => $shipping,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'transaction_id' => $request->transaction_id,
                'payment_gateway' => 'in_app_purchase',
                'shipping_address' => json_encode($request->shipping_address),
                'billing_address' => json_encode($request->billing_address),
                'paid_at' => now(),
                'is_in_app_purchase' => true,
                'receipt_data' => $request->receipt_data,
                'purchase_token' => $request->purchase_token
            ]);

            // Create order item
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $request->product_id,
                'variant_id' => $request->variant_id,
                'quantity' => $request->quantity,
                'price' => $price,
                'total' => $price * $request->quantity,
            ]);

            // Update stock
            if ($variant) {
                $variant->decrement('stock_quantity', $request->quantity);
            } else {
                $product->decrement('stock_quantity', $request->quantity);
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'In-app purchase order created successfully',
                'data' => [
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'total_amount' => number_format($order->total_amount, 2),
                    'status' => $order->status,
                    'payment_status' => $order->payment_status
                ]
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create in-app purchase order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete in-app cart item
     */
    public function cartDelete(Request $request)
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
            'message' => 'Cart item deleted successfully'
        ]);
    }
}
