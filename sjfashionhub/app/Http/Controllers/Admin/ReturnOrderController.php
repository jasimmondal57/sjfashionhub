<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\ReturnOrder;
use App\Models\Order;
use Carbon\Carbon;

class ReturnOrderController extends Controller
{
    /**
     * Display return orders with tabs
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'pending');

        // Get return orders based on tab
        $query = ReturnOrder::with(['order.items.product', 'order.items.productVariant', 'user', 'processedBy']);

        switch ($tab) {
            case 'pending':
                $query->pending();
                break;
            case 'ready_to_return':
                $query->readyToReturn();
                break;
            case 'in_transit':
                $query->inTransit();
                break;
            case 'pending_refund':
                $query->pendingRefund();
                break;
            case 'completed':
                $query->completed();
                break;
            case 'rejected':
                $query->rejected();
                break;
            default:
                $query->pending();
        }

        // Apply search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('return_number', 'like', "%{$search}%")
                  ->orWhere('return_awb_number', 'like', "%{$search}%")
                  ->orWhereHas('order', function ($orderQuery) use ($search) {
                      $orderQuery->where('order_number', 'like', "%{$search}%");
                  })
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $returnOrders = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics for each tab
        $stats = [
            'pending' => ReturnOrder::pending()->count(),
            'ready_to_return' => ReturnOrder::readyToReturn()->count(),
            'in_transit' => ReturnOrder::inTransit()->count(),
            'pending_refund' => ReturnOrder::pendingRefund()->count(),
            'completed' => ReturnOrder::completed()->count(),
            'rejected' => ReturnOrder::rejected()->count(),
        ];

        return view('admin.return-orders.index', compact('returnOrders', 'stats', 'tab'));
    }

    /**
     * Show return order details
     */
    public function show(ReturnOrder $returnOrder)
    {
        $returnOrder->load(['order.items.product', 'order.items.productVariant', 'user', 'processedBy', 'qualityCheckedBy']);
        return view('admin.return-orders.show', compact('returnOrder'));
    }

    /**
     * Approve return request
     */
    public function approve(Request $request, ReturnOrder $returnOrder)
    {
        if (!$returnOrder->canBeApproved()) {
            return back()->with('error', 'Return request cannot be approved in its current status.');
        }

        $request->validate([
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $returnOrder->update([
            'status' => 'ready_to_return',
            'approved_at' => now(),
            'processed_by' => auth()->id(),
            'admin_notes' => $request->admin_notes
        ]);

        return back()->with('success', 'Return request approved successfully!');
    }

    /**
     * Reject return request
     */
    public function reject(Request $request, ReturnOrder $returnOrder)
    {
        if (!$returnOrder->canBeRejected()) {
            return back()->with('error', 'Return request cannot be rejected in its current status.');
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        $returnOrder->update([
            'status' => 'rejected',
            'rejected_at' => now(),
            'processed_by' => auth()->id(),
            'rejection_reason' => $request->rejection_reason
        ]);

        return back()->with('success', 'Return request rejected successfully!');
    }

    /**
     * Show return shipping options
     */
    public function showReturnOptions(ReturnOrder $returnOrder)
    {
        if (!$returnOrder->canInitiateReturn()) {
            return back()->with('error', 'Return is not ready for shipping initiation.');
        }

        // Get Shiprocket return rates if not manual
        $courierRates = [];
        if (!$returnOrder->is_manual_return) {
            $courierRates = $this->getShiprocketReturnRates($returnOrder);
        }

        return view('admin.return-orders.return-options', compact('returnOrder', 'courierRates'));
    }

    /**
     * Initiate Shiprocket return
     */
    public function initiateShiprocketReturn(Request $request, ReturnOrder $returnOrder)
    {
        $request->validate([
            'courier_company_id' => 'required|integer',
            'package_weight' => 'required|numeric|min:0.1',
            'package_length' => 'required|numeric|min:1',
            'package_breadth' => 'required|numeric|min:1',
            'package_height' => 'required|numeric|min:1',
            'pickup_address' => 'required|array'
        ]);

        try {
            // Create return request in Shiprocket
            $shiprocketReturnId = $this->createShiprocketReturn($returnOrder, $request->all());

            if ($shiprocketReturnId) {
                // Schedule pickup
                $pickupData = $this->scheduleShiprocketPickup($returnOrder, $shiprocketReturnId, $request->all());

                if ($pickupData) {
                    $returnOrder->update([
                        'shiprocket_return_id' => $shiprocketReturnId,
                        'return_awb_number' => $pickupData['awb_number'],
                        'return_courier_company' => $pickupData['courier_name'],
                        'return_courier_company_id' => $request->courier_company_id,
                        'return_shipping_charges' => $pickupData['shipping_charges'],
                        'return_tracking_url' => $pickupData['tracking_url'],
                        'return_package_weight' => $request->package_weight,
                        'return_package_length' => $request->package_length,
                        'return_package_breadth' => $request->package_breadth,
                        'return_package_height' => $request->package_height,
                        'pickup_address' => $request->pickup_address,
                        'pickup_scheduled_at' => now(),
                        'status' => 'in_transit',
                        'in_transit_at' => now(),
                        'is_manual_return' => false
                    ]);

                    return redirect()->route('admin.return-orders.index', ['tab' => 'in_transit'])
                                   ->with('success', 'Return pickup scheduled successfully!');
                }
            }

            return back()->with('error', 'Failed to initiate return. Please try again.');

        } catch (\Exception $e) {
            Log::error('Shiprocket return initiation failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to initiate return: ' . $e->getMessage());
        }
    }

    /**
     * Initiate manual return
     */
    public function initiateManualReturn(Request $request, ReturnOrder $returnOrder)
    {
        $request->validate([
            'manual_return_tracking_id' => 'required|string|max:100',
            'manual_return_courier_name' => 'required|string|max:100',
            'package_weight' => 'required|numeric|min:0.1',
            'package_length' => 'required|numeric|min:1',
            'package_breadth' => 'required|numeric|min:1',
            'package_height' => 'required|numeric|min:1'
        ]);

        $returnOrder->update([
            'manual_return_tracking_id' => $request->manual_return_tracking_id,
            'manual_return_courier_name' => $request->manual_return_courier_name,
            'return_package_weight' => $request->package_weight,
            'return_package_length' => $request->package_length,
            'return_package_breadth' => $request->package_breadth,
            'return_package_height' => $request->package_height,
            'status' => 'in_transit',
            'in_transit_at' => now(),
            'is_manual_return' => true
        ]);

        return redirect()->route('admin.return-orders.index', ['tab' => 'in_transit'])
                       ->with('success', 'Manual return initiated successfully!');
    }

    /**
     * Mark return as received and start quality check
     */
    public function markReceived(Request $request, ReturnOrder $returnOrder)
    {
        $request->validate([
            'quality_check_notes' => 'nullable|string|max:500'
        ]);

        $returnOrder->update([
            'status' => 'pending_refund',
            'received_at' => now(),
            'quality_check_status' => 'pending',
            'quality_check_notes' => $request->quality_check_notes,
            'quality_checked_by' => auth()->id(),
            'quality_checked_at' => now()
        ]);

        return back()->with('success', 'Return marked as received. Quality check initiated.');
    }

    /**
     * Complete quality check
     */
    public function completeQualityCheck(Request $request, ReturnOrder $returnOrder)
    {
        $request->validate([
            'quality_check_status' => 'required|in:passed,failed',
            'quality_check_notes' => 'required|string|max:500',
            'deduction_amount' => 'nullable|numeric|min:0',
            'deduction_reason' => 'nullable|string|max:500'
        ]);

        $updateData = [
            'quality_check_status' => $request->quality_check_status,
            'quality_check_notes' => $request->quality_check_notes,
            'quality_checked_by' => auth()->id(),
            'quality_checked_at' => now()
        ];

        if ($request->deduction_amount > 0) {
            $updateData['deduction_amount'] = $request->deduction_amount;
            $updateData['deduction_reason'] = $request->deduction_reason;
            $updateData['refund_amount'] = $returnOrder->return_amount - $request->deduction_amount;
        } else {
            $updateData['refund_amount'] = $returnOrder->return_amount;
        }

        $returnOrder->update($updateData);

        return back()->with('success', 'Quality check completed successfully!');
    }

    /**
     * Process refund
     */
    public function processRefund(Request $request, ReturnOrder $returnOrder)
    {
        if (!$returnOrder->canProcessRefund()) {
            return back()->with('error', 'Return is not ready for refund processing.');
        }

        $request->validate([
            'refund_method' => 'required|in:original_payment,bank_transfer,store_credit',
            'refund_transaction_id' => 'nullable|string|max:100',
            'refund_notes' => 'nullable|string|max:500'
        ]);

        $refundAmount = $returnOrder->refund_amount ?? $returnOrder->return_amount;

        $returnOrder->update([
            'status' => 'completed',
            'refund_method' => $request->refund_method,
            'refund_transaction_id' => $request->refund_transaction_id,
            'refund_details' => [
                'method' => $request->refund_method,
                'amount' => $refundAmount,
                'transaction_id' => $request->refund_transaction_id,
                'notes' => $request->refund_notes,
                'processed_at' => now()->toISOString(),
                'processed_by' => auth()->user()->name
            ],
            'refund_processed_at' => now(),
            'completed_at' => now()
        ]);

        return redirect()->route('admin.return-orders.index', ['tab' => 'completed'])
                       ->with('success', 'Refund processed successfully!');
    }

    /**
     * Update return status manually
     */
    public function updateStatus(Request $request, ReturnOrder $returnOrder)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,ready_to_return,in_transit,pending_refund,completed,rejected',
            'notes' => 'nullable|string|max:500'
        ]);

        $oldStatus = $returnOrder->status;
        $newStatus = $request->status;

        // Update status with timestamp
        $returnOrder->updateStatus($newStatus, auth()->id());

        // Add admin notes if provided
        if ($request->filled('notes')) {
            $returnOrder->update(['admin_notes' => $request->notes]);
        }

        // Log status change
        Log::info("Return {$returnOrder->return_number} status changed from {$oldStatus} to {$newStatus} by " . auth()->user()->name);

        return back()->with('success', 'Return status updated successfully!');
    }

    /**
     * Sync return status with Shiprocket
     */
    public function syncWithShiprocket(ReturnOrder $returnOrder)
    {
        if (!$returnOrder->hasShiprocketIntegration()) {
            return back()->with('error', 'Return is not integrated with Shiprocket.');
        }

        try {
            $trackingData = $this->getShiprocketReturnTracking($returnOrder->return_awb_number);

            if ($trackingData) {
                // Update return status based on Shiprocket data
                $this->updateReturnFromShiprocketData($returnOrder, $trackingData);

                return back()->with('success', 'Return synced with Shiprocket successfully!');
            }

            return back()->with('error', 'Failed to sync with Shiprocket.');

        } catch (\Exception $e) {
            Log::error('Shiprocket return sync failed: ' . $e->getMessage());
            return back()->with('error', 'Failed to sync with Shiprocket: ' . $e->getMessage());
        }
    }

    /**
     * Export return orders to CSV
     */
    public function export(Request $request)
    {
        $query = ReturnOrder::with(['order', 'user']);

        // Apply filters
        if ($request->filled('tab') && $request->tab !== 'all') {
            switch ($request->tab) {
                case 'pending':
                    $query->pending();
                    break;
                case 'ready_to_return':
                    $query->readyToReturn();
                    break;
                case 'in_transit':
                    $query->inTransit();
                    break;
                case 'pending_refund':
                    $query->pendingRefund();
                    break;
                case 'completed':
                    $query->completed();
                    break;
                case 'rejected':
                    $query->rejected();
                    break;
            }
        }

        $returnOrders = $query->orderBy('created_at', 'desc')->get();

        $filename = 'return_orders_export_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function() use ($returnOrders) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Return Number', 'Order Number', 'Customer Name', 'Customer Email', 'Status',
                'Return Type', 'Return Amount', 'Refund Amount', 'Return Reason', 'Quality Check',
                'AWB Number', 'Courier Company', 'Created At', 'Completed At'
            ]);

            // Add return order data
            foreach ($returnOrders as $returnOrder) {
                fputcsv($file, [
                    $returnOrder->return_number,
                    $returnOrder->order->order_number,
                    $returnOrder->user->name,
                    $returnOrder->user->email,
                    ucfirst(str_replace('_', ' ', $returnOrder->status)),
                    $returnOrder->return_type_display,
                    $returnOrder->return_amount,
                    $returnOrder->refund_amount ?? $returnOrder->return_amount,
                    $returnOrder->return_reason,
                    $returnOrder->quality_check_status ? ucfirst($returnOrder->quality_check_status) : 'N/A',
                    $returnOrder->return_awb_number ?? $returnOrder->manual_return_tracking_id,
                    $returnOrder->return_shipping_method,
                    $returnOrder->created_at->format('Y-m-d H:i:s'),
                    $returnOrder->completed_at ? $returnOrder->completed_at->format('Y-m-d H:i:s') : ''
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get Shiprocket return courier rates
     */
    private function getShiprocketReturnRates(ReturnOrder $returnOrder)
    {
        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getShiprocketToken()
            ])->post('https://apiv2.shiprocket.in/v1/external/courier/serviceability/', [
                'pickup_postcode' => $returnOrder->pickup_address['postal_code'] ?? '110001',
                'delivery_postcode' => config('services.shiprocket.pickup_postcode', '110001'),
                'weight' => 0.5, // Default weight
                'cod' => 0 // Returns are typically not COD
            ]);

            if ($response->successful()) {
                return $response->json()['data']['available_courier_companies'] ?? [];
            }

            return [];
        } catch (\Exception $e) {
            Log::error('Failed to get Shiprocket return rates: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Create return request in Shiprocket
     */
    private function createShiprocketReturn(ReturnOrder $returnOrder, array $data)
    {
        try {
            $returnData = [
                'order_id' => $returnOrder->order->order_number,
                'order_date' => $returnOrder->order->created_at->format('Y-m-d H:i'),
                'pickup_customer_name' => $returnOrder->user->name,
                'pickup_last_name' => '',
                'pickup_address' => $data['pickup_address']['address'],
                'pickup_city' => $data['pickup_address']['city'],
                'pickup_state' => $data['pickup_address']['state'],
                'pickup_country' => $data['pickup_address']['country'] ?? 'India',
                'pickup_pincode' => $data['pickup_address']['postal_code'],
                'pickup_email' => $returnOrder->user->email,
                'pickup_phone' => $data['pickup_address']['phone'],
                'shipping_customer_name' => config('app.name'),
                'shipping_last_name' => '',
                'shipping_address' => config('services.shiprocket.pickup_address', 'Warehouse Address'),
                'shipping_city' => config('services.shiprocket.pickup_city', 'Delhi'),
                'shipping_country' => 'India',
                'shipping_pincode' => config('services.shiprocket.pickup_postcode', '110001'),
                'shipping_state' => config('services.shiprocket.pickup_state', 'Delhi'),
                'shipping_email' => config('services.shiprocket.email'),
                'shipping_phone' => config('services.shiprocket.phone', '9999999999'),
                'order_items' => collect($returnOrder->return_items)->map(function ($item) {
                    return [
                        'name' => $item['name'],
                        'sku' => $item['sku'] ?? 'N/A',
                        'units' => $item['quantity'],
                        'selling_price' => $item['price']
                    ];
                })->toArray(),
                'payment_method' => 'Prepaid',
                'sub_total' => $returnOrder->return_amount,
                'length' => $data['package_length'],
                'breadth' => $data['package_breadth'],
                'height' => $data['package_height'],
                'weight' => $data['package_weight']
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getShiprocketToken()
            ])->post('https://apiv2.shiprocket.in/v1/external/orders/create/return', $returnData);

            if ($response->successful()) {
                return $response->json()['order_id'];
            }

            Log::error('Shiprocket return creation failed: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('Shiprocket return creation exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Schedule pickup with Shiprocket
     */
    private function scheduleShiprocketPickup(ReturnOrder $returnOrder, $shiprocketReturnId, array $data)
    {
        try {
            $pickupData = [
                'order_id' => $shiprocketReturnId,
                'courier_id' => $data['courier_company_id'],
                'pickup_date' => now()->addDay()->format('Y-m-d'),
                'pickup_time' => '10:00-14:00'
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->getShiprocketToken()
            ])->post('https://apiv2.shiprocket.in/v1/external/courier/assign/awb', $pickupData);

            if ($response->successful()) {
                $responseData = $response->json();
                return [
                    'awb_number' => $responseData['response']['data']['awb_code'],
                    'courier_name' => $responseData['response']['data']['courier_name'],
                    'shipping_charges' => $responseData['response']['data']['charges'],
                    'tracking_url' => "https://shiprocket.co/tracking/{$responseData['response']['data']['awb_code']}"
                ];
            }

            Log::error('Shiprocket pickup scheduling failed: ' . $response->body());
            return null;

        } catch (\Exception $e) {
            Log::error('Shiprocket pickup scheduling exception: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get Shiprocket return tracking data
     */
    private function getShiprocketReturnTracking($awbNumber)
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
            Log::error('Shiprocket return tracking failed: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Update return from Shiprocket tracking data
     */
    private function updateReturnFromShiprocketData(ReturnOrder $returnOrder, array $trackingData)
    {
        $status = $trackingData['tracking_data']['track_status'] ?? '';
        $newReturnStatus = null;

        switch (strtolower($status)) {
            case 'picked up':
            case 'in transit':
                $newReturnStatus = 'in_transit';
                break;
            case 'delivered':
                $newReturnStatus = 'pending_refund';
                break;
            case 'rto':
            case 'returned':
                // Return failed, back to customer
                $newReturnStatus = 'rejected';
                break;
        }

        if ($newReturnStatus && $newReturnStatus !== $returnOrder->status) {
            $returnOrder->updateStatus($newReturnStatus);

            // If delivered to warehouse, mark as received
            if ($newReturnStatus === 'pending_refund') {
                $returnOrder->update([
                    'received_at' => now(),
                    'quality_check_status' => 'pending'
                ]);
            }
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
}
