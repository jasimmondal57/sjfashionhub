<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\ShiprocketSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShiprocketWebhookController extends Controller
{
    /**
     * Handle incoming webhook from Shiprocket
     */
    public function handle(Request $request)
    {
        // Log the incoming webhook
        Log::info('Shiprocket Webhook Received', [
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'headers' => $request->headers->all(),
            'payload' => $request->all()
        ]);

        // Verify webhook token (Shiprocket sends it in x-api-key header)
        $webhookToken = ShiprocketSetting::get('shiprocket_webhook_token');
        $requestToken = $request->header('x-api-key')
                     ?? $request->header('X-Api-Key')
                     ?? $request->header('X-Webhook-Token')
                     ?? $request->header('Authorization')
                     ?? $request->input('token')
                     ?? $request->input('webhook_token');

        // Only verify token if it's configured
        if ($webhookToken && $requestToken !== $webhookToken) {
            Log::warning('Shiprocket Webhook: Invalid token', [
                'expected' => $webhookToken,
                'received' => $requestToken,
                'x-api-key' => $request->header('x-api-key'),
                'headers' => $request->headers->all()
            ]);

            // Still process but log the warning
            // Uncomment below to enforce token validation:
            // return response()->json([
            //     'success' => false,
            //     'message' => 'Invalid webhook token'
            // ], 401);
        } else if ($webhookToken && $requestToken === $webhookToken) {
            Log::info('Shiprocket Webhook: Token validated successfully');
        }

        try {
            // Get webhook data
            $data = $request->all();

            // Extract order ID from webhook (Shiprocket sends channel_order_id)
            $orderId = $data['channel_order_id'] ?? $data['order_id'] ?? null;
            $awbCode = $data['awb'] ?? $data['awb_code'] ?? null;
            $status = $data['current_status'] ?? $data['shipment_status'] ?? $data['status'] ?? null;
            $shipmentId = $data['shipment_id'] ?? $data['order_id'] ?? null;
            $courierName = $data['courier_name'] ?? null;
            $etd = $data['etd'] ?? null;
            $scans = $data['scans'] ?? [];

            if (!$orderId) {
                Log::warning('Shiprocket Webhook: No order ID found in payload', ['data' => $data]);
                return response()->json([
                    'success' => false,
                    'message' => 'No order ID in webhook data'
                ], 400);
            }

            // Find the order by order number (channel_order_id should match our order_number)
            $order = Order::where('order_number', $orderId)
                ->orWhere('id', $orderId)
                ->first();

            if (!$order) {
                Log::warning('Shiprocket Webhook: Order not found', [
                    'channel_order_id' => $orderId,
                    'searched_by' => 'order_number or id'
                ]);

                // Return success to prevent Shiprocket from retrying
                return response()->json([
                    'success' => true,
                    'message' => 'Order not found in system, but webhook received'
                ]);
            }

            // Update order with shipping information
            if ($awbCode && !$order->awb_number) {
                $order->awb_number = $awbCode;
                $order->tracking_url = "https://shiprocket.co/tracking/" . $awbCode;
            }

            if ($shipmentId && !$order->shiprocket_shipment_id) {
                $order->shiprocket_shipment_id = $shipmentId;
            }

            if ($courierName && !$order->courier_name) {
                $order->courier_name = $courierName;
                $order->courier_company = $courierName;
            }

            if ($etd) {
                $order->estimated_delivery_date = $etd;
            }

            // Update order status based on Shiprocket status
            if ($status) {
                $this->updateOrderStatus($order, $status);
            }

            // Store webhook data in order metadata
            $webhookHistory = $order->webhook_history ?? [];
            $webhookHistory[] = [
                'timestamp' => now()->toDateTimeString(),
                'awb' => $awbCode,
                'status' => $status,
                'courier' => $courierName,
                'etd' => $etd,
                'scans' => $scans,
                'full_data' => $data
            ];
            $order->webhook_history = $webhookHistory;

            // Store latest scan information
            if (!empty($scans)) {
                $latestScan = $scans[0]; // First scan is the latest
                $order->latest_scan_activity = $latestScan['activity'] ?? null;
                $order->latest_scan_location = $latestScan['location'] ?? null;
                $order->latest_scan_date = $latestScan['date'] ?? null;
            }

            $order->save();

            Log::info('Shiprocket Webhook: Order updated successfully', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $status,
                'awb' => $awbCode,
                'courier' => $courierName
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Webhook processed successfully',
                'order_id' => $order->id,
                'order_number' => $order->order_number
            ]);

        } catch (\Exception $e) {
            Log::error('Shiprocket Webhook Error: ' . $e->getMessage(), [
                'payload' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error processing webhook'
            ], 500);
        }
    }

    /**
     * Update order status based on Shiprocket status
     */
    private function updateOrderStatus(Order $order, string $shiprocketStatus)
    {
        $statusMap = [
            // Shiprocket Status => Our Order Status
            'PICKUP SCHEDULED' => 'ready_to_ship',
            'PICKED UP' => 'in_transit',
            'IN TRANSIT' => 'in_transit',
            'OUT FOR DELIVERY' => 'out_for_delivery',
            'DELIVERED' => 'delivered',
            'CANCELLED' => 'cancelled',
            'CANCELED' => 'cancelled',
            'RTO INITIATED' => 'rto',
            'RTO IN TRANSIT' => 'rto',
            'RTO DELIVERED' => 'rto',
            'LOST' => 'cancelled',
            'DAMAGED' => 'cancelled',
        ];

        $newStatus = $statusMap[strtoupper($shiprocketStatus)] ?? null;

        if ($newStatus && $order->order_status !== $newStatus) {
            $oldStatus = $order->order_status;
            $order->order_status = $newStatus;

            // Update timestamp fields based on status
            switch ($newStatus) {
                case 'ready_to_ship':
                    if (!$order->ready_to_ship_at) {
                        $order->ready_to_ship_at = now();
                    }
                    break;
                case 'in_transit':
                    if (!$order->in_transit_at) {
                        $order->in_transit_at = now();
                    }
                    break;
                case 'out_for_delivery':
                    if (!$order->out_for_delivery_at) {
                        $order->out_for_delivery_at = now();
                    }
                    break;
                case 'delivered':
                    if (!$order->delivered_at) {
                        $order->delivered_at = now();
                    }
                    break;
                case 'cancelled':
                    if (!$order->cancelled_at) {
                        $order->cancelled_at = now();
                    }
                    break;
                case 'rto':
                    if (!$order->rto_at) {
                        $order->rto_at = now();
                    }
                    break;
            }

            // Add status history
            $statusHistory = $order->status_history ?? [];
            $statusHistory[] = [
                'status' => $newStatus,
                'timestamp' => now()->toDateTimeString(),
                'source' => 'shiprocket_webhook',
                'shiprocket_status' => $shiprocketStatus
            ];
            $order->status_history = $statusHistory;

            Log::info('Order status updated via webhook', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'old_status' => $oldStatus,
                'new_status' => $newStatus,
                'shiprocket_status' => $shiprocketStatus
            ]);
        }
    }

    /**
     * Test webhook endpoint
     */
    public function test(Request $request)
    {
        return response()->json([
            'success' => true,
            'message' => 'Webhook endpoint is working',
            'timestamp' => now()->toDateTimeString(),
            'received_data' => $request->all()
        ]);
    }
}

