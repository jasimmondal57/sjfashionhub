<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;

class OrderController extends Controller
{
    /**
     * Display orders with tabs
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'pending');

        // Get orders based on tab
        $query = Order::with(['user', 'items.product']);

        switch ($tab) {
            case 'pending':
                $query->pending();
                break;
            case 'ready_to_ship':
                $query->readyToShip();
                break;
            case 'in_transit':
                $query->inTransit();
                break;
            case 'out_for_delivery':
                $query->outForDelivery();
                break;
            case 'delivered':
                $query->delivered();
                break;
            case 'cancelled':
                $query->cancelled();
                break;
            case 'rto':
                $query->rto();
                break;
            default:
                $query->pending();
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('awb_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics for each tab
        $stats = [
            'pending' => Order::pending()->count(),
            'ready_to_ship' => Order::readyToShip()->count(),
            'in_transit' => Order::inTransit()->count(),
            'out_for_delivery' => Order::outForDelivery()->count(),
            'delivered' => Order::delivered()->count(),
            'cancelled' => Order::cancelled()->count(),
            'rto' => Order::rto()->count(),
        ];

        return view('admin.orders.index', compact('orders', 'stats', 'tab'));
    }

    /**
     * Show order details
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.product', 'confirmedBy']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Confirm order (move from pending to ready_to_ship)
     */
    public function confirm(Order $order)
    {
        if (!$order->canBeConfirmed()) {
            return back()->with('error', 'Order cannot be confirmed in its current status.');
        }

        $order->updateStatus('ready_to_ship', auth()->id());

        return back()->with('success', 'Order confirmed successfully!');
    }

    /**
     * Decline order (move to cancelled)
     */
    public function decline(Request $request, Order $order)
    {
        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Order cannot be cancelled in its current status.');
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500'
        ]);

        $order->update([
            'order_status' => 'cancelled',
            'cancelled_at' => now(),
            'cancellation_reason' => $request->cancellation_reason
        ]);

        return back()->with('success', 'Order cancelled successfully!');
    }

    /**
     * Show shipping label creation options
     */
    public function showShippingOptions(Order $order)
    {
        if (!$order->canBeShipped()) {
            return back()->with('error', 'Order is not ready for shipping.');
        }

        // Get Shiprocket courier rates if not manual shipping
        $courierRates = [];
        if (!$order->is_manual_shipping) {
            $courierRates = $this->getShiprocketCourierRates($order);
        }

        return view('admin.orders.shipping-options', compact('order', 'courierRates'));
    }

    /**
     * Create Shiprocket shipping label
     */
    public function createShiprocketLabel(Request $request, Order $order)
    {
        $request->validate([
            'courier_company_id' => 'required|integer',
            'package_weight' => 'required|numeric|min:0.1',
            'package_length' => 'required|numeric|min:1',
            'package_breadth' => 'required|numeric|min:1',
            'package_height' => 'required|numeric|min:1'
        ]);

        try {
            // Create order in Shiprocket
            $shiprocketOrderId = $this->createShiprocketOrder($order, $request->all());

            if ($shiprocketOrderId) {
                // Create shipment
                $shipmentData = $this->createShiprocketShipment($order, $shiprocketOrderId, $request->all());

                if ($shipmentData) {
                    $order->update([
                        'shiprocket_order_id' => $shiprocketOrderId,
                        'shiprocket_shipment_id' => $shipmentData['shipment_id'],
                        'awb_number' => $shipmentData['awb_code'],
                        'courier_company' => $shipmentData['courier_name'],
                        'courier_company_id' => $request->courier_company_id,
                        'shipping_charges' => $shipmentData['shipping_charges'],
                        'tracking_url' => $shipmentData['tracking_url'],
                        'package_weight' => $request->package_weight,
                        'package_length' => $request->package_length,
                        'package_breadth' => $request->package_breadth,
                        'package_height' => $request->package_height,
                        'order_status' => 'in_transit',
                        'in_transit_at' => now(),
                        'is_manual_shipping' => false
                    ]);

                    return redirect()->route('admin.orders.index', ['tab' => 'in_transit'])
                                   ->with('success', 'Shipping label created successfully!');
                }
            }

            return back()->with('error', 'Failed to create shipping label. Please try again.');

        } catch (\Exception $e) {
            Log::error('Shiprocket label creation failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to create shipping label: ' . $e->getMessage());
        }
    }

    /**
     * Create manual shipping label
     */
    public function createManualLabel(Request $request, Order $order)
    {
        $request->validate([
            'manual_tracking_id' => 'required|string|max:100',
            'manual_courier_name' => 'required|string|max:100',
            'package_weight' => 'required|numeric|min:0.1',
            'package_length' => 'required|numeric|min:1',
            'package_breadth' => 'required|numeric|min:1',
            'package_height' => 'required|numeric|min:1'
        ]);

        $order->update([
            'manual_tracking_id' => $request->manual_tracking_id,
            'manual_courier_name' => $request->manual_courier_name,
            'package_weight' => $request->package_weight,
            'package_length' => $request->package_length,
            'package_breadth' => $request->package_breadth,
            'package_height' => $request->package_height,
            'order_status' => 'in_transit',
            'in_transit_at' => now(),
            'is_manual_shipping' => true
        ]);

        return redirect()->route('admin.orders.index', ['tab' => 'in_transit'])
                       ->with('success', 'Manual shipping label created successfully!');
    }

    /**
     * Update order status manually
     */
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,ready_to_ship,in_transit,out_for_delivery,delivered,cancelled,rto',
            'notes' => 'nullable|string|max:500'
        ]);

        $oldStatus = $order->order_status;
        $newStatus = $request->status;

        // Update status with timestamp
        $order->updateStatus($newStatus, auth()->id());

        // Add admin notes if provided
        if ($request->filled('notes')) {
            $order->update(['admin_notes' => $request->notes]);
        }

        // Log status change
        Log::info("Order {$order->order_number} status changed from {$oldStatus} to {$newStatus} by " . auth()->user()->name);

        return back()->with('success', 'Order status updated successfully!');
    }

    /**
     * Sync order status with Shiprocket
     */
    public function syncWithShiprocket(Order $order)
    {
        if (!$order->hasShiprocketIntegration()) {
            return back()->with('error', 'Order is not integrated with Shiprocket.');
        }

        try {
            $trackingData = $this->getShiprocketTrackingData($order->awb_number);

            if ($trackingData) {
                // Update order status based on Shiprocket data
                $this->updateOrderFromShiprocketData($order, $trackingData);

                return back()->with('success', 'Order synced with Shiprocket successfully!');
            }

            return back()->with('error', 'Failed to sync with Shiprocket.');

        } catch (\Exception $e) {
            Log::error('Shiprocket sync failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to sync with Shiprocket: ' . $e->getMessage());
        }
    }

    /**
     * Get Shiprocket courier rates
     */
    private function getShiprocketCourierRates(Order $order)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getShiprocketToken()
            ])->post('https://apiv2.shiprocket.in/v1/external/courier/serviceability/', [
                'pickup_postcode' => config('services.shiprocket.pickup_postcode', '110001'),
                'delivery_postcode' => $order->shipping_address['postal_code'],
                'weight' => 0.5, // Default weight
                'cod' => $order->is_cod ? 1 : 0
            ]);

            if ($response->successful()) {
                return $response->json()['data']['available_courier_companies'] ?? [];
            }

            return [];
        } catch (\Exception $e) {
            Log::error('Failed to get Shiprocket courier rates: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Create order in Shiprocket
     */
    private function createShiprocketOrder(Order $order, array $data)
    {
        try {
            $orderData = [
                'order_id' => $order->order_number,
                'order_date' => $order->created_at->format('Y-m-d H:i'),
                'pickup_location' => config('services.shiprocket.pickup_location', 'Primary'),
                'billing_customer_name' => $order->billing_address['name'],
                'billing_last_name' => '',
                'billing_address' => $order->billing_address['address'],
                'billing_city' => $order->billing_address['city'],
                'billing_pincode' => $order->billing_address['postal_code'],
                'billing_state' => $order->billing_address['state'],
                'billing_country' => $order->billing_address['country'] ?? 'India',
                'billing_email' => $order->user->email,
                'billing_phone' => $order->billing_address['phone'],
                'shipping_is_billing' => true,
                'order_items' => $order->items->map(function ($item) {
                    return [
                        'name' => $item->product->name,
                        'sku' => $item->product->sku ?? $item->product->id,
                        'units' => $item->quantity,
                        'selling_price' => $item->price
                    ];
                })->toArray(),
                'payment_method' => $order->payment_method === 'cod' ? 'COD' : 'Prepaid',
                'sub_total' => $order->subtotal,
                'length' => $data['package_length'],
                'breadth' => $data['package_breadth'],
                'height' => $data['package_height'],
                'weight' => $data['package_weight']
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getShiprocketToken()
            ])->post('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', $orderData);

            if ($response->successful()) {
                return $response->json()['order_id'];
            }

            Log::error('Shiprocket order creation failed: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('Shiprocket order creation exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create shipment in Shiprocket
     */
    private function createShiprocketShipment(Order $order, $shiprocketOrderId, array $data)
    {
        try {
            $shipmentData = [
                'order_id' => $shiprocketOrderId,
                'courier_id' => $data['courier_company_id'],
                'is_return' => false,
                'is_insurance' => false
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getShiprocketToken()
            ])->post('https://apiv2.shiprocket.in/v1/external/courier/assign/awb', $shipmentData);

            if ($response->successful()) {
                $responseData = $response->json();
                return [
                    'shipment_id' => $responseData['shipment_id'],
                    'awb_code' => $responseData['response']['data']['awb_code'],
                    'courier_name' => $responseData['response']['data']['courier_name'],
                    'shipping_charges' => $responseData['response']['data']['charges'],
                    'tracking_url' => "https://shiprocket.co/tracking/{$responseData['response']['data']['awb_code']}"
                ];
            }

            Log::error('Shiprocket shipment creation failed: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('Shiprocket shipment creation exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get Shiprocket tracking data
     */
    private function getShiprocketTrackingData($awbNumber)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getShiprocketToken()
            ])->get("https://apiv2.shiprocket.in/v1/external/courier/track/awb/{$awbNumber}");

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Shiprocket tracking failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Update order from Shiprocket tracking data
     */
    private function updateOrderFromShiprocketData(Order $order, array $trackingData)
    {
        $status = $trackingData['tracking_data']['track_status'] ?? '';
        $newOrderStatus = null;

        switch (strtolower($status)) {
            case 'shipped':
            case 'in transit':
                $newOrderStatus = 'in_transit';
                break;
            case 'out for delivery':
                $newOrderStatus = 'out_for_delivery';
                break;
            case 'delivered':
                $newOrderStatus = 'delivered';
                break;
            case 'rto':
            case 'returned':
                $newOrderStatus = 'rto';
                break;
            case 'cancelled':
                $newOrderStatus = 'cancelled';
                break;
        }

        if ($newOrderStatus && $newOrderStatus !== $order->order_status) {
            $order->updateStatus($newOrderStatus);

            // Update delivery updates
            $order->update([
                'delivery_updates' => $trackingData['tracking_data']['shipment_track'] ?? []
            ]);
        }
    }

    /**
     * Get Shiprocket authentication token
     */
    private function getShiprocketToken()
    {
        // In a real application, you would cache this token
        try {
            $response = Http::post('https://apiv2.shiprocket.in/v1/external/auth/login', [
                'email' => config('services.shiprocket.email'),
                'password' => config('services.shiprocket.password')
            ]);

            if ($response->successful()) {
                return $response->json()['token'];
            }

            throw new \Exception('Failed to authenticate with Shiprocket');
        } catch (\Exception $e) {
            Log::error('Shiprocket authentication failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Export orders to CSV
     */
    public function export(Request $request)
    {
        $query = Order::with(['user', 'items']);

        // Apply filters
        if ($request->filled('tab') && $request->tab !== 'all') {
            switch ($request->tab) {
                case 'pending':
                    $query->pending();
                    break;
                case 'ready_to_ship':
                    $query->readyToShip();
                    break;
                case 'in_transit':
                    $query->inTransit();
                    break;
                case 'out_for_delivery':
                    $query->outForDelivery();
                    break;
                case 'delivered':
                    $query->delivered();
                    break;
                case 'cancelled':
                    $query->cancelled();
                    break;
                case 'rto':
                    $query->rto();
                    break;
            }
        }

        $orders = $query->orderBy('created_at', 'desc')->get();

        $filename = 'orders_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Order Number', 'Customer Name', 'Customer Email', 'Status', 'Total Amount',
                'Payment Status', 'Payment Method', 'AWB Number', 'Courier Company',
                'Created At', 'Delivered At'
            ]);

            // Add order data
            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->order_number,
                    $order->user->name,
                    $order->user->email,
                    ucfirst(str_replace('_', ' ', $order->order_status)),
                    $order->total_amount,
                    ucfirst($order->payment_status),
                    $order->payment_method,
                    $order->awb_number,
                    $order->shipping_method,
                    $order->created_at->format('Y-m-d H:i:s'),
                    $order->delivered_at ? $order->delivered_at->format('Y-m-d H:i:s') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
