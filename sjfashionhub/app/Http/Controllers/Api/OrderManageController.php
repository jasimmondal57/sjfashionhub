<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderCancelReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderManageController extends Controller
{
    /**
     * Get cancel reasons
     */
    public function cancelReasons(Request $request)
    {
        $reasons = [
            ['id' => 1, 'reason' => 'Changed my mind'],
            ['id' => 2, 'reason' => 'Found a better price elsewhere'],
            ['id' => 3, 'reason' => 'Ordered by mistake'],
            ['id' => 4, 'reason' => 'Product no longer needed'],
            ['id' => 5, 'reason' => 'Delivery taking too long'],
            ['id' => 6, 'reason' => 'Payment issues'],
            ['id' => 7, 'reason' => 'Product out of stock'],
            ['id' => 8, 'reason' => 'Other']
        ];

        return response()->json([
            'success' => true,
            'data' => $reasons
        ]);
    }

    /**
     * Cancel order
     */
    public function cancelOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'reason_id' => 'required|integer',
            'reason_text' => 'nullable|string|max:500',
            'additional_notes' => 'nullable|string|max:1000'
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

        // Check if order can be cancelled
        if (!in_array($order->status, ['pending', 'processing'])) {
            return response()->json([
                'success' => false,
                'message' => 'Order cannot be cancelled at this stage'
            ], 400);
        }

        if ($order->delivery_status === 'shipped') {
            return response()->json([
                'success' => false,
                'message' => 'Order has already been shipped and cannot be cancelled'
            ], 400);
        }

        try {
            // Get reason text
            $reasons = [
                1 => 'Changed my mind',
                2 => 'Found a better price elsewhere',
                3 => 'Ordered by mistake',
                4 => 'Product no longer needed',
                5 => 'Delivery taking too long',
                6 => 'Payment issues',
                7 => 'Product out of stock',
                8 => 'Other'
            ];

            $reasonText = $reasons[$request->reason_id] ?? 'Other';
            if ($request->reason_id == 8 && $request->reason_text) {
                $reasonText = $request->reason_text;
            }

            // Update order status
            $order->update([
                'status' => 'cancelled',
                'delivery_status' => 'cancelled',
                'cancelled_at' => now(),
                'cancel_reason' => $reasonText,
                'cancel_notes' => $request->additional_notes
            ]);

            // Restore product stock
            foreach ($order->items as $item) {
                if ($item->variant) {
                    $item->variant->increment('stock_quantity', $item->quantity);
                } else {
                    $item->product->increment('stock_quantity', $item->quantity);
                }
            }

            // Process refund if payment was completed
            if ($order->payment_status === 'completed') {
                $order->update([
                    'payment_status' => 'refund_pending',
                    'refund_amount' => $order->total_amount,
                    'refund_requested_at' => now()
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully',
                'data' => [
                    'order_id' => $order->id,
                    'status' => $order->status,
                    'cancel_reason' => $reasonText,
                    'refund_status' => $order->payment_status === 'refund_pending' ? 'Refund will be processed within 3-5 business days' : 'No refund required'
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel order',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
