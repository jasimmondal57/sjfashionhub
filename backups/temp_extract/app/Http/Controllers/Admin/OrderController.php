<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ShiprocketSetting;
use App\Services\ShiprocketService;
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

        // Don't pre-fetch courier rates, let user enter package details first
        $courierRates = [];

        return view('admin.orders.shipping-options', compact('order', 'courierRates'));
    }

    /**
     * Get courier rates via AJAX
     */
    public function getCourierRates(Request $request, Order $order)
    {
        try {
            $request->validate([
                'weight' => 'required|numeric|min:0.1',
                'length' => 'required|numeric|min:1',
                'breadth' => 'required|numeric|min:1',
                'height' => 'required|numeric|min:1',
            ]);

            Log::info('Getting courier rates for order', [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'weight' => $request->weight,
                'shipping_address' => $order->shipping_address
            ]);

            $courierRates = $this->getShiprocketCourierRates($order, $request->weight);

            if (empty($courierRates)) {
                Log::warning('No courier rates returned', [
                    'order_id' => $order->id,
                    'pincode' => $order->shipping_address['pincode'] ?? 'N/A'
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'No couriers available for this delivery location'
                ]);
            }

            return response()->json([
                'success' => true,
                'couriers' => $courierRates
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to get courier rates: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch courier rates: ' . $e->getMessage()
            ], 500);
        }
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
            Log::info('Creating Shiprocket label', [
                'order_id' => $order->id,
                'courier_company_id' => $request->courier_company_id,
                'package_details' => $request->only(['package_weight', 'package_length', 'package_breadth', 'package_height'])
            ]);

            // Create order in Shiprocket
            $shiprocketData = $this->createShiprocketOrder($order, $request->all());

            if (!$shiprocketData || !isset($shiprocketData['order_id']) || !isset($shiprocketData['shipment_id'])) {
                Log::error('Failed to create Shiprocket order', ['response' => $shiprocketData]);
                return back()->with('error', 'Failed to create order in Shiprocket. Please check logs.');
            }

            Log::info('Shiprocket order created', $shiprocketData);

            // Assign courier to shipment
            $shipmentData = $this->createShiprocketShipment($order, $shiprocketData['order_id'], $shiprocketData['shipment_id'], $request->all());

            if (!$shipmentData) {
                Log::error('Failed to assign courier to Shiprocket shipment');
                return back()->with('error', 'Failed to assign courier. Please check logs.');
            }

            Log::info('Courier assigned to shipment', $shipmentData);

            // Update order with shipment details
            $order->update([
                'shiprocket_order_id' => $shiprocketData['order_id'],
                'shiprocket_shipment_id' => $shipmentData['shipment_id'],
                'awb_number' => $shipmentData['awb_code'],
                'courier_name' => $shipmentData['courier_name'],
                'courier_company' => $shipmentData['courier_name'],
                'courier_company_id' => $request->courier_company_id,
                'tracking_url' => $shipmentData['tracking_url'] ?? null,
                'order_status' => 'in_transit',
                'in_transit_at' => now()
            ]);

            Log::info('Order updated with shipping details', [
                'order_id' => $order->id,
                'shipment_id' => $shipmentData['shipment_id'],
                'awb_number' => $shipmentData['awb_code'],
                'courier_name' => $shipmentData['courier_name'],
                'status' => 'in_transit'
            ]);

            // Generate label and get URL
            $labelUrl = $this->generateShiprocketLabel($shipmentData['shipment_id']);

            if ($labelUrl) {
                Log::info('Label generated', ['label_url' => $labelUrl]);

                return redirect()->route('admin.orders.show', $order)
                               ->with('success', 'Shipping label created successfully! AWB: ' . $shipmentData['awb_code'])
                               ->with('label_url', $labelUrl)
                               ->with('auto_download', true);
            }

            return redirect()->route('admin.orders.show', $order)
                           ->with('success', 'Shipping label created successfully! AWB: ' . $shipmentData['awb_code'])
                           ->with('info', 'Click "Download Label" button to get the shipping label.');

        } catch (\Exception $e) {
            Log::error('Shiprocket label creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Failed to create shipping label: ' . $e->getMessage());
        }
    }

    /**
     * Download Shiprocket label
     */
    public function downloadShiprocketLabel(Order $order)
    {
        try {
            if (!$order->shiprocket_shipment_id) {
                return back()->with('error', 'No Shiprocket shipment found for this order.');
            }

            Log::info('Downloading label for shipment', ['shipment_id' => $order->shiprocket_shipment_id]);

            // Generate label using shipment_id
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getShiprocketToken()
            ])->post('https://apiv2.shiprocket.in/v1/external/courier/generate/label', [
                'shipment_id' => [(int)$order->shiprocket_shipment_id]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Label download response', ['response' => $data]);

                // Check if label URL is returned
                if (isset($data['label_url'])) {
                    return redirect($data['label_url']);
                }

                // If label_created is 1, try to get the label URL from order details
                if (isset($data['label_created']) && $data['label_created'] == 1) {
                    // Wait a moment for label to be generated
                    sleep(2);

                    // Get order details to fetch label URL
                    $orderResponse = Http::withHeaders([
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $this->getShiprocketToken()
                    ])->get('https://apiv2.shiprocket.in/v1/external/orders/show/' . $order->shiprocket_order_id);

                    if ($orderResponse->successful()) {
                        $orderData = $orderResponse->json();
                        $labelUrl = $orderData['data']['shipments'][0]['label_url'] ?? null;

                        if ($labelUrl) {
                            return redirect($labelUrl);
                        }
                    }
                }
            }

            Log::error('Label download failed', ['response' => $response->json()]);

            // Fallback: Open Shiprocket dashboard
            return redirect('https://app.shiprocket.in/seller/orders/processing')
                        ->with('info', 'Please download the label from Shiprocket dashboard.');

        } catch (\Exception $e) {
            Log::error('Failed to download label', [
                'error' => $e->getMessage(),
                'order_id' => $order->id
            ]);
            return back()->with('error', 'Failed to download label: ' . $e->getMessage());
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
    private function getShiprocketCourierRates(Order $order, $weight = null)
    {
        try {
            // Get pickup pincode from database settings
            $pickupPincode = ShiprocketSetting::get('shiprocket_pickup_pin_code')
                          ?? config('services.shiprocket.pickup_postcode', '110001');

            // Use provided weight or calculate from order items
            if ($weight) {
                $totalWeight = $weight;
            } else {
                $totalWeight = $order->items->sum(function($item) {
                    return ($item->product->weight ?? 0.5) * $item->quantity;
                });
                // Minimum weight 0.5 kg
                $totalWeight = max($totalWeight, 0.5);
            }

            // Get delivery pincode (try both 'pincode' and 'postal_code' fields)
            $deliveryPincode = $order->shipping_address['pincode']
                            ?? $order->shipping_address['postal_code']
                            ?? null;

            if (!$deliveryPincode) {
                Log::error('Order shipping address missing pincode', ['order_id' => $order->id, 'shipping_address' => $order->shipping_address]);
                return [];
            }

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getShiprocketToken()
            ])->get('https://apiv2.shiprocket.in/v1/external/courier/serviceability/', [
                'pickup_postcode' => $pickupPincode,
                'delivery_postcode' => $deliveryPincode,
                'weight' => $totalWeight,
                'cod' => $order->payment_method === 'cod' ? 1 : 0
            ]);

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Shiprocket courier rates response', ['data' => $data]);
                return $data['data']['available_courier_companies'] ?? [];
            }

            Log::error('Shiprocket courier rates failed', ['response' => $response->json()]);
            return [];
        } catch (\Exception $e) {
            Log::error('Failed to get Shiprocket courier rates: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get available pickup locations from Shiprocket
     */
    private function getShiprocketPickupLocations()
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getShiprocketToken()
            ])->get('https://apiv2.shiprocket.in/v1/external/settings/company/pickup');

            if ($response->successful()) {
                $data = $response->json();
                Log::info('Shiprocket pickup locations', ['locations' => $data]);
                return $data['data']['shipping_address'] ?? [];
            }

            Log::error('Failed to fetch pickup locations', ['response' => $response->json()]);
            return [];
        } catch (\Exception $e) {
            Log::error('Exception fetching pickup locations: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Create order in Shiprocket
     */
    private function createShiprocketOrder(Order $order, array $data)
    {
        try {
            // Get pickup locations and use the first one
            $pickupLocations = $this->getShiprocketPickupLocations();
            $pickupLocation = !empty($pickupLocations) ? $pickupLocations[0]['pickup_location'] : 'Primary';

            Log::info('Using pickup location', ['pickup_location' => $pickupLocation, 'available_locations' => $pickupLocations]);

            $orderData = [
                'order_id' => $order->order_number,
                'order_date' => $order->created_at->format('Y-m-d H:i'),
                'pickup_location' => $pickupLocation,
                'billing_customer_name' => $order->billing_address['full_name'] ?? $order->billing_address['name'] ?? '',
                'billing_last_name' => '',
                'billing_address' => $order->billing_address['address'],
                'billing_city' => $order->billing_address['city'],
                'billing_pincode' => $order->billing_address['pincode'] ?? $order->billing_address['postal_code'],
                'billing_state' => $order->billing_address['state'],
                'billing_country' => $order->billing_address['country'] ?? 'India',
                'billing_email' => $order->billing_address['email'] ?? $order->user->email,
                'billing_phone' => $order->billing_address['phone'],
                'shipping_is_billing' => true,
                'order_items' => $order->items->map(function ($item) {
                    return [
                        'name' => $item->product_name ?? $item->product->name,
                        'sku' => $item->product_sku ?? $item->product->sku ?? $item->product->id,
                        'units' => $item->quantity,
                        'selling_price' => $item->unit_price ?? $item->price ?? 0
                    ];
                })->toArray(),
                'payment_method' => $order->payment_method === 'cod' ? 'COD' : 'Prepaid',
                'sub_total' => $order->total_amount - ($order->shipping_amount ?? 0),
                'length' => $data['package_length'],
                'breadth' => $data['package_breadth'],
                'height' => $data['package_height'],
                'weight' => $data['package_weight']
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getShiprocketToken()
            ])->post('https://apiv2.shiprocket.in/v1/external/orders/create/adhoc', $orderData);

            $responseData = $response->json();
            Log::info('Shiprocket order creation response', ['response' => $responseData]);

            if ($response->successful() && isset($responseData['order_id']) && isset($responseData['shipment_id'])) {
                return [
                    'order_id' => $responseData['order_id'],
                    'shipment_id' => $responseData['shipment_id']
                ];
            }

            Log::error('Shiprocket order creation failed', [
                'status' => $response->status(),
                'response' => $responseData
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('Shiprocket order creation exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Create shipment in Shiprocket
     */
    private function createShiprocketShipment(Order $order, $shiprocketOrderId, $shipmentId, array $data)
    {
        try {
            $shipmentData = [
                'shipment_id' => $shipmentId,
                'courier_id' => $data['courier_company_id']
            ];

            Log::info('Assigning courier to Shiprocket shipment', $shipmentData);

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getShiprocketToken()
            ])->post('https://apiv2.shiprocket.in/v1/external/courier/assign/awb', $shipmentData);

            $responseData = $response->json();
            Log::info('Shiprocket courier assignment response', ['response' => $responseData]);

            if ($response->successful() && isset($responseData['awb_assign_status']) && $responseData['awb_assign_status'] == 1) {
                return [
                    'shipment_id' => $shipmentId,
                    'awb_code' => $responseData['response']['data']['awb_code'] ?? $responseData['awb_code'],
                    'courier_name' => $responseData['response']['data']['courier_name'] ?? $responseData['courier_name'],
                    'shipping_charges' => $responseData['response']['data']['freight_charge'] ?? $responseData['freight_charge'] ?? 0,
                    'tracking_url' => "https://shiprocket.co/tracking/" . ($responseData['response']['data']['awb_code'] ?? $responseData['awb_code'])
                ];
            }

            Log::error('Shiprocket shipment creation failed', [
                'status' => $response->status(),
                'response' => $responseData
            ]);
            return null;

        } catch (\Exception $e) {
            Log::error('Shiprocket shipment creation exception', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    /**
     * Generate Shiprocket label
     */
    private function generateShiprocketLabel($shipmentId)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getShiprocketToken()
            ])->post('https://apiv2.shiprocket.in/v1/external/courier/generate/label', [
                'shipment_id' => [$shipmentId]
            ]);

            if ($response->successful()) {
                $responseData = $response->json();
                Log::info('Label generation response', ['response' => $responseData]);

                // Return the label URL
                if (isset($responseData['label_url'])) {
                    return $responseData['label_url'];
                } else if (isset($responseData['label_created']) && $responseData['label_created'] == 1) {
                    // Label will be available shortly, return Shiprocket dashboard URL
                    return "https://app.shiprocket.in/seller/orders/processing";
                }
            }

            Log::error('Label generation failed', ['response' => $response->json()]);
            return null;
        } catch (\Exception $e) {
            Log::error('Label generation exception: ' . $e->getMessage());
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
        // Use ShiprocketService to get token (it handles caching and database settings)
        try {
            $service = new ShiprocketService();
            $token = $service->getToken();

            if (!$token) {
                throw new \Exception('Failed to authenticate with Shiprocket. Please check your credentials in Shiprocket Settings.');
            }

            return $token;
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
