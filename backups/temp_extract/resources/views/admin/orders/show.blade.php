<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">📦 Order Details</h1>
                        <p class="text-gray-600 mt-1">Order #{{ $order->order_number }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->status_badge['class'] }}">
                            {{ $order->status_badge['text'] }}
                        </span>
                        <a href="{{ route('admin.orders.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Orders
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Order Information -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Order Items -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Order Items</h3>
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                                    @if($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-16 h-16 object-cover rounded-lg">
                                    @else
                                        <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900">{{ $item->product->name }}</h4>
                                        <p class="text-sm text-gray-600">SKU: {{ $item->product->sku ?? 'N/A' }}</p>
                                        @if($item->variant_details)
                                            <p class="text-sm text-gray-600">
                                                Variant: {{ collect($item->variant_details)->map(fn($value, $key) => "$key: $value")->join(', ') }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="text-right">
                                        <p class="font-medium text-gray-900">₹{{ number_format($item->price, 2) }}</p>
                                        <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                        <p class="text-sm font-medium text-gray-900">₹{{ number_format($item->price * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Order Timeline -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Order Timeline</h3>
                        <div class="space-y-4">
                            @php
                                $timeline = [];
                                if ($order->created_at) $timeline[] = ['date' => $order->created_at, 'status' => 'Order Placed', 'icon' => 'plus-circle', 'color' => 'blue'];
                                if ($order->confirmed_at) $timeline[] = ['date' => $order->confirmed_at, 'status' => 'Order Confirmed', 'icon' => 'check-circle', 'color' => 'green'];
                                if ($order->ready_to_ship_at) $timeline[] = ['date' => $order->ready_to_ship_at, 'status' => 'Ready to Ship', 'icon' => 'box', 'color' => 'purple'];
                                if ($order->in_transit_at) $timeline[] = ['date' => $order->in_transit_at, 'status' => 'In Transit', 'icon' => 'truck', 'color' => 'indigo'];
                                if ($order->out_for_delivery_at) $timeline[] = ['date' => $order->out_for_delivery_at, 'status' => 'Out for Delivery', 'icon' => 'shipping-fast', 'color' => 'orange'];
                                if ($order->delivered_at) $timeline[] = ['date' => $order->delivered_at, 'status' => 'Delivered', 'icon' => 'check-circle', 'color' => 'green'];
                                if ($order->cancelled_at) $timeline[] = ['date' => $order->cancelled_at, 'status' => 'Cancelled', 'icon' => 'times-circle', 'color' => 'red'];
                                if ($order->rto_at) $timeline[] = ['date' => $order->rto_at, 'status' => 'RTO', 'icon' => 'undo', 'color' => 'gray'];
                                
                                $timeline = collect($timeline)->sortBy('date');
                            @endphp

                            @foreach($timeline as $event)
                                <div class="flex items-center space-x-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 bg-{{ $event['color'] }}-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-{{ $event['icon'] }} text-{{ $event['color'] }}-600 text-sm"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-gray-900">{{ $event['status'] }}</p>
                                        <p class="text-sm text-gray-600">{{ $event['date']->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    @if($order->awb_number || $order->manual_tracking_id)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Shipping Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Tracking Number</p>
                                    <p class="text-sm text-gray-900">{{ $order->awb_number ?? $order->manual_tracking_id }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Courier Company</p>
                                    <p class="text-sm text-gray-900">{{ $order->shipping_method }}</p>
                                </div>
                                @if($order->shipping_charges)
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Shipping Charges</p>
                                        <p class="text-sm text-gray-900">₹{{ number_format($order->shipping_charges, 2) }}</p>
                                    </div>
                                @endif
                                @if($order->estimated_delivery_date)
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Estimated Delivery</p>
                                        <p class="text-sm text-gray-900">{{ $order->estimated_delivery_date->format('M d, Y') }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="mt-4 flex gap-3">
                                @if($order->tracking_url)
                                    <a href="{{ $order->tracking_url }}" target="_blank"
                                       class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-md hover:bg-blue-200 transition-colors text-sm font-medium">
                                        <i class="fas fa-external-link-alt mr-2"></i>Track Package
                                    </a>
                                @endif

                                @if($order->shiprocket_shipment_id && $order->awb_number)
                                    <a href="{{ route('admin.orders.download-shiprocket-label', $order) }}"
                                       target="_blank"
                                       class="inline-flex items-center px-3 py-2 bg-green-100 text-green-700 rounded-md hover:bg-green-200 transition-colors text-sm font-medium">
                                        <i class="fas fa-download mr-2"></i>Download Label
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Customer Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-700">Name</p>
                                <p class="text-sm text-gray-900">{{ $order->user->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Email</p>
                                <p class="text-sm text-gray-900">{{ $order->user->email }}</p>
                            </div>
                            @if($order->user->phone)
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Phone</p>
                                    <p class="text-sm text-gray-900">{{ $order->user->phone }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Billing Address -->
                    @if($order->billing_address)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Billing Address</h3>
                            <div class="text-sm text-gray-900">
                                <p>{{ $order->billing_address['name'] ?? $order->user->name }}</p>
                                <p>{{ $order->billing_address['address'] ?? 'N/A' }}</p>
                                <p>{{ $order->billing_address['city'] ?? 'N/A' }}, {{ $order->billing_address['state'] ?? 'N/A' }}</p>
                                <p>{{ $order->billing_address['postal_code'] ?? 'N/A' }}</p>
                                <p>{{ $order->billing_address['country'] ?? 'India' }}</p>
                                @if($order->billing_address['phone'])
                                    <p class="mt-2">Phone: {{ $order->billing_address['phone'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Shipping Address -->
                    @if($order->shipping_address)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Shipping Address</h3>
                            <div class="text-sm text-gray-900">
                                <p>{{ $order->shipping_address['name'] ?? $order->user->name }}</p>
                                <p>{{ $order->shipping_address['address'] ?? 'N/A' }}</p>
                                <p>{{ $order->shipping_address['city'] ?? 'N/A' }}, {{ $order->shipping_address['state'] ?? 'N/A' }}</p>
                                <p>{{ $order->shipping_address['postal_code'] ?? 'N/A' }}</p>
                                <p>{{ $order->shipping_address['country'] ?? 'India' }}</p>
                                @if($order->shipping_address['phone'])
                                    <p class="mt-2">Phone: {{ $order->shipping_address['phone'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Order Summary -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>
                        <div class="space-y-2">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-900">₹{{ number_format($order->subtotal, 2) }}</span>
                            </div>
                            @if($order->tax_amount > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Tax</span>
                                    <span class="text-gray-900">₹{{ number_format($order->tax_amount, 2) }}</span>
                                </div>
                            @endif
                            @if($order->shipping_amount > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="text-gray-900">₹{{ number_format($order->shipping_amount, 2) }}</span>
                                </div>
                            @endif
                            @if($order->discount_amount > 0)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Discount</span>
                                    <span class="text-red-600">-₹{{ number_format($order->discount_amount, 2) }}</span>
                                </div>
                            @endif
                            <div class="border-t border-gray-200 pt-2">
                                <div class="flex justify-between">
                                    <span class="text-base font-medium text-gray-900">Total</span>
                                    <span class="text-base font-bold text-gray-900">₹{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-700">Payment Method</p>
                                <p class="text-sm text-gray-900">{{ ucfirst($order->payment_method) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Payment Status</p>
                                @php
                                    $paymentStatusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'paid' => 'bg-green-100 text-green-800',
                                        'failed' => 'bg-red-100 text-red-800',
                                        'refunded' => 'bg-gray-100 text-gray-800'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $paymentStatusColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                            @if($order->payment_id)
                                <div>
                                    <p class="text-sm font-medium text-gray-700">Payment ID</p>
                                    <p class="text-sm text-gray-900 font-mono">{{ $order->payment_id }}</p>
                                </div>
                            @endif
                            @if($order->is_cod)
                                <div>
                                    <p class="text-sm font-medium text-gray-700">COD Amount</p>
                                    <p class="text-sm text-gray-900">₹{{ number_format($order->cod_amount ?? $order->total_amount, 2) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Admin Notes -->
                    @if($order->admin_notes || $order->cancellation_reason || $order->rto_reason)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Admin Notes</h3>
                            <div class="space-y-3">
                                @if($order->admin_notes)
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Notes</p>
                                        <p class="text-sm text-gray-900">{{ $order->admin_notes }}</p>
                                    </div>
                                @endif
                                @if($order->cancellation_reason)
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Cancellation Reason</p>
                                        <p class="text-sm text-gray-900">{{ $order->cancellation_reason }}</p>
                                    </div>
                                @endif
                                @if($order->rto_reason)
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">RTO Reason</p>
                                        <p class="text-sm text-gray-900">{{ $order->rto_reason }}</p>
                                    </div>
                                @endif
                                @if($order->confirmedBy)
                                    <div>
                                        <p class="text-sm font-medium text-gray-700">Confirmed By</p>
                                        <p class="text-sm text-gray-900">{{ $order->confirmedBy->name }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                        <div class="space-y-3">
                            @if($order->canBeConfirmed())
                                <form action="{{ route('admin.orders.confirm', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                        <i class="fas fa-check mr-2"></i>Confirm Order
                                    </button>
                                </form>
                            @endif

                            @if($order->canBeShipped())
                                <a href="{{ route('admin.orders.shipping-options', $order) }}" 
                                   class="block w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md font-medium transition-colors text-center">
                                    <i class="fas fa-shipping-fast mr-2"></i>Create Shipping Label
                                </a>
                            @endif

                            @if($order->hasShiprocketIntegration())
                                <form action="{{ route('admin.orders.sync-shiprocket', $order) }}" method="POST">
                                    @csrf
                                    <button type="submit" 
                                            class="w-full bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                        <i class="fas fa-sync mr-2"></i>Sync with Shiprocket
                                    </button>
                                </form>
                            @endif

                            <button onclick="showStatusModal({{ $order->id }}, '{{ $order->order_status }}')" 
                                    class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                <i class="fas fa-edit mr-2"></i>Update Status
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Update Modal -->
    <div id="statusModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Update Order Status</h3>
                <form id="statusForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            New Status *
                        </label>
                        <select name="status" id="status" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="">Select Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="ready_to_ship">Ready to Ship</option>
                            <option value="in_transit">In Transit</option>
                            <option value="out_for_delivery">Out for Delivery</option>
                            <option value="delivered">Delivered</option>
                            <option value="cancelled">Cancelled</option>
                            <option value="rto">RTO</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes (Optional)
                        </label>
                        <textarea name="notes" id="notes" rows="3"
                                  placeholder="Add any notes about this status change..."
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                    </div>
                    <div class="flex items-center justify-end space-x-3">
                        <button type="button" onclick="hideStatusModal()" 
                                class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showStatusModal(orderId, currentStatus) {
            document.getElementById('statusForm').action = `/admin/orders/${orderId}/status`;
            document.getElementById('status').value = currentStatus;
            document.getElementById('statusModal').classList.remove('hidden');
        }

        function hideStatusModal() {
            document.getElementById('statusModal').classList.add('hidden');
            document.getElementById('notes').value = '';
        }

        // Auto-download label if available
        @if(session('auto_download') && session('label_url'))
            window.addEventListener('load', function() {
                const labelUrl = "{{ session('label_url') }}";
                if (labelUrl) {
                    // Open label in new tab for download
                    window.open(labelUrl, '_blank');
                }
            });
        @endif

        // Close modal when clicking outside
        window.onclick = function(event) {
            const statusModal = document.getElementById('statusModal');
            
            if (event.target === statusModal) {
                hideStatusModal();
            }
        }
    </script>
</x-layouts.admin>
