<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class TrackOrderController extends Controller
{
    /**
     * Show the track order form
     */
    public function index()
    {
        return view('track-order.index');
    }

    /**
     * Track an order by order number
     */
    public function track(Request $request)
    {
        $request->validate([
            'order_number' => 'required|string',
            'email' => 'required|email',
        ]);

        $order = Order::where('order_number', $request->order_number)
                     ->whereJsonContains('billing_address->email', $request->email)
                     ->orWhereJsonContains('shipping_address->email', $request->email)
                     ->with('items.product')
                     ->first();

        if (!$order) {
            return back()->withErrors(['error' => 'Order not found. Please check your order number and email address.'])->withInput();
        }

        return view('track-order.result', compact('order'));
    }

    /**
     * Track order for authenticated users
     */
    public function trackAuthenticated($orderNumber)
    {
        if (!Auth::check()) {
            return redirect()->route('track-order.index')->with('error', 'Please login to track your orders.');
        }

        $order = Order::where('order_number', $orderNumber)
                     ->where('user_id', Auth::id())
                     ->with('items.product')
                     ->first();

        if (!$order) {
            return redirect()->route('track-order.index')->with('error', 'Order not found.');
        }

        return view('track-order.result', compact('order'));
    }

    /**
     * Get order tracking timeline
     */
    public function getTrackingTimeline(Order $order)
    {
        $timeline = [];

        // Order placed
        $timeline[] = [
            'status' => 'Order Placed',
            'description' => 'Your order has been placed successfully',
            'date' => $order->created_at,
            'completed' => true,
            'icon' => 'check'
        ];

        // Order confirmed
        if ($order->confirmed_at) {
            $timeline[] = [
                'status' => 'Order Confirmed',
                'description' => 'Your order has been confirmed and is being prepared',
                'date' => $order->confirmed_at,
                'completed' => true,
                'icon' => 'check'
            ];
        }

        // Ready to ship
        if ($order->ready_to_ship_at) {
            $timeline[] = [
                'status' => 'Ready to Ship',
                'description' => 'Your order is packed and ready for shipment',
                'date' => $order->ready_to_ship_at,
                'completed' => true,
                'icon' => 'check'
            ];
        }

        // In transit
        if ($order->in_transit_at) {
            $timeline[] = [
                'status' => 'In Transit',
                'description' => 'Your order is on the way',
                'date' => $order->in_transit_at,
                'completed' => true,
                'icon' => 'truck'
            ];
        }

        // Out for delivery
        if ($order->out_for_delivery_at) {
            $timeline[] = [
                'status' => 'Out for Delivery',
                'description' => 'Your order is out for delivery',
                'date' => $order->out_for_delivery_at,
                'completed' => true,
                'icon' => 'truck'
            ];
        }

        // Delivered
        if ($order->delivered_at) {
            $timeline[] = [
                'status' => 'Delivered',
                'description' => 'Your order has been delivered successfully',
                'date' => $order->delivered_at,
                'completed' => true,
                'icon' => 'check'
            ];
        } else {
            // Add expected delivery if not delivered yet
            $timeline[] = [
                'status' => 'Delivered',
                'description' => 'Your order will be delivered soon',
                'date' => $order->estimated_delivery_date,
                'completed' => false,
                'icon' => 'clock'
            ];
        }

        return $timeline;
    }
}
