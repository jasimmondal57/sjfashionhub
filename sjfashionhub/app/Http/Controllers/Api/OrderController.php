<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Get user orders
     */
    public function index(Request $request)
    {
        $query = Order::where('user_id', $request->user()->id)
            ->with(['items.product.images', 'items.variant']);

        // Apply filters
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $orders = $query->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        $formattedOrders = $orders->getCollection()->map(function ($order) {
            return $this->formatOrder($order);
        });

        return response()->json([
            'success' => true,
            'data' => $formattedOrders,
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ]
        ]);
    }

    /**
     * Get orders by delivery status
     */
    public function byDeliveryStatus(Request $request)
    {
        $status = $request->get('status');
        $orders = Order::where('user_id', $request->user()->id)
            ->where('delivery_status', $status)
            ->with(['items.product.images', 'items.variant'])
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 15));

        $formattedOrders = $orders->getCollection()->map(function ($order) {
            return $this->formatOrder($order);
        });

        return response()->json([
            'success' => true,
            'data' => $formattedOrders,
            'pagination' => [
                'current_page' => $orders->currentPage(),
                'last_page' => $orders->lastPage(),
                'per_page' => $orders->perPage(),
                'total' => $orders->total(),
            ]
        ]);
    }

    /**
     * Get delivery processes
     */
    public function deliveryProcesses(Request $request)
    {
        $processes = [
            ['id' => 1, 'name' => 'Order Placed', 'status' => 'pending'],
            ['id' => 2, 'name' => 'Processing', 'status' => 'processing'],
            ['id' => 3, 'name' => 'Shipped', 'status' => 'shipped'],
            ['id' => 4, 'name' => 'Out for Delivery', 'status' => 'out_for_delivery'],
            ['id' => 5, 'name' => 'Delivered', 'status' => 'delivered'],
        ];

        return response()->json([
            'success' => true,
            'data' => $processes
        ]);
    }

    /**
     * Get pending orders
     */
    public function pendingOrders(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->where('status', 'pending')
            ->with(['items.product.images', 'items.variant'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                return $this->formatOrder($order);
            });

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Get cancelled orders
     */
    public function cancelledOrders(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->where('status', 'cancelled')
            ->with(['items.product.images', 'items.variant'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                return $this->formatOrder($order);
            });

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Get refund orders
     */
    public function refundOrders(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->where('status', 'refunded')
            ->with(['items.product.images', 'items.variant'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                return $this->formatOrder($order);
            });

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Get orders to ship
     */
    public function ordersToShip(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->whereIn('delivery_status', ['processing', 'ready_to_ship'])
            ->with(['items.product.images', 'items.variant'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                return $this->formatOrder($order);
            });

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Get orders to receive
     */
    public function ordersToReceive(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->whereIn('delivery_status', ['shipped', 'out_for_delivery'])
            ->with(['items.product.images', 'items.variant'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                return $this->formatOrder($order);
            });

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Get orders for review
     */
    public function ordersForReview(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->where('delivery_status', 'delivered')
            ->whereDoesntHave('reviews')
            ->with(['items.product.images', 'items.variant'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($order) {
                return $this->formatOrder($order);
            });

        return response()->json([
            'success' => true,
            'data' => $orders
        ]);
    }

    /**
     * Create new order
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'shipping_address_id' => 'required|exists:addresses,id',
            'billing_address_id' => 'required|exists:addresses,id',
            'payment_method' => 'required|string',
            'shipping_method_id' => 'required|integer',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            // Get selected cart items
            $cartItems = Cart::where('user_id', $request->user()->id)
                ->where('is_selected', true)
                ->with(['product', 'variant'])
                ->get();

            if ($cartItems->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No items selected in cart'
                ], 400);
            }

            // Calculate totals
            $subtotal = 0;
            foreach ($cartItems as $item) {
                $price = $item->variant ? $item->variant->price : $item->product->price;
                $salePrice = $item->variant ? $item->variant->sale_price : $item->product->sale_price;
                $finalPrice = $salePrice ?? $price;
                $subtotal += $finalPrice * $item->quantity;
            }

            $tax = $subtotal * 0.1; // 10% tax
            $shipping = 50; // Fixed shipping cost
            $total = $subtotal + $tax + $shipping;

            // Create order
            $order = Order::create([
                'user_id' => $request->user()->id,
                'order_number' => 'ORD-' . time() . '-' . rand(1000, 9999),
                'status' => 'pending',
                'payment_status' => 'pending',
                'delivery_status' => 'pending',
                'subtotal' => $subtotal,
                'tax_amount' => $tax,
                'shipping_amount' => $shipping,
                'total_amount' => $total,
                'payment_method' => $request->payment_method,
                'shipping_address_id' => $request->shipping_address_id,
                'billing_address_id' => $request->billing_address_id,
                'shipping_method_id' => $request->shipping_method_id,
                'notes' => $request->notes,
            ]);

            // Create order items
            foreach ($cartItems as $item) {
                $price = $item->variant ? $item->variant->price : $item->product->price;
                $salePrice = $item->variant ? $item->variant->sale_price : $item->product->sale_price;
                $finalPrice = $salePrice ?? $price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'variant_id' => $item->variant_id,
                    'quantity' => $item->quantity,
                    'price' => $finalPrice,
                    'total' => $finalPrice * $item->quantity,
                ]);

                // Update stock
                if ($item->variant) {
                    $item->variant->decrement('stock_quantity', $item->quantity);
                } else {
                    $item->product->decrement('stock_quantity', $item->quantity);
                }
            }

            // Clear selected cart items
            Cart::where('user_id', $request->user()->id)
                ->where('is_selected', true)
                ->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => $this->formatOrder($order->load(['items.product.images', 'items.variant']))
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store payment information
     */
    public function storePaymentInfo(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'transaction_id' => 'required|string',
            'payment_gateway' => 'required|string',
            'payment_status' => 'required|in:pending,completed,failed'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $order = Order::where('id', $request->order_id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found'
            ], 404);
        }

        $order->update([
            'transaction_id' => $request->transaction_id,
            'payment_gateway' => $request->payment_gateway,
            'payment_status' => $request->payment_status,
            'paid_at' => $request->payment_status === 'completed' ? now() : null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment information updated successfully'
        ]);
    }

    /**
     * Format order data for API response
     */
    private function formatOrder($order)
    {
        return [
            'id' => $order->id,
            'order_number' => $order->order_number,
            'status' => $order->status,
            'payment_status' => $order->payment_status,
            'delivery_status' => $order->delivery_status,
            'subtotal' => number_format($order->subtotal, 2),
            'tax_amount' => number_format($order->tax_amount, 2),
            'shipping_amount' => number_format($order->shipping_amount, 2),
            'total_amount' => number_format($order->total_amount, 2),
            'payment_method' => $order->payment_method,
            'transaction_id' => $order->transaction_id,
            'created_at' => $order->created_at->format('Y-m-d H:i:s'),
            'items' => $order->items->map(function ($item) {
                $images = $item->product->images->pluck('image_path')->map(function ($path) {
                    return asset('storage/' . $path);
                })->toArray();

                return [
                    'id' => $item->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'variant_id' => $item->variant_id,
                    'variant_name' => $item->variant ? $item->variant->name : null,
                    'quantity' => $item->quantity,
                    'price' => number_format($item->price, 2),
                    'total' => number_format($item->total, 2),
                    'image' => $images[0] ?? null
                ];
            })
        ];
    }
}
