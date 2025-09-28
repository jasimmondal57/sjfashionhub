<x-layouts.user title="Order Details" subtitle="View your order information and tracking details">
    <div class="bg-white rounded-lg shadow">
        <!-- Order Header -->
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-gray-900">Order #{{ $order->order_number }}</h2>
                    <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('F j, Y \a\t g:i A') }}</p>
                </div>
                <div class="text-right">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $order->status_badge['class'] }}">
                        {{ $order->status_badge['text'] }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Order Items</h3>
            <div class="space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                        @if($item->product && $item->product->featured_image)
                            <img class="h-20 w-20 rounded-lg object-cover" src="{{ Storage::url($item->product->featured_image) }}" alt="{{ $item->product_name }}">
                        @else
                            <div class="h-20 w-20 rounded-lg bg-gray-200 flex items-center justify-center">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="flex-1">
                            <h4 class="text-lg font-medium text-gray-900">{{ $item->product_name }}</h4>
                            @if($item->product_sku)
                                <p class="text-sm text-gray-600">SKU: {{ $item->product_sku }}</p>
                            @endif
                            <div class="flex items-center space-x-4 mt-2">
                                <span class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</span>
                                <span class="text-sm text-gray-600">Unit Price: ₹{{ number_format($item->unit_price, 0) }}</span>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-lg font-semibold text-gray-900">₹{{ number_format($item->total_price, 0) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="text-gray-900">₹{{ number_format($order->subtotal, 0) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Shipping</span>
                    <span class="text-gray-900">₹{{ number_format($order->shipping_amount, 0) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Tax (GST)</span>
                    <span class="text-gray-900">₹{{ number_format($order->tax_amount, 0) }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Discount</span>
                        <span class="text-green-600">-₹{{ number_format($order->discount_amount, 0) }}</span>
                    </div>
                @endif
                <div class="border-t pt-2">
                    <div class="flex justify-between">
                        <span class="text-lg font-semibold text-gray-900">Total</span>
                        <span class="text-lg font-semibold text-gray-900">₹{{ number_format($order->total_amount, 0) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Shipping Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Billing Address -->
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Billing Address</h4>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>{{ $order->billing_address['full_name'] }}</p>
                        <p>{{ $order->billing_address['address'] }}</p>
                        <p>{{ $order->billing_address['city'] }}, {{ $order->billing_address['state'] }} {{ $order->billing_address['pincode'] }}</p>
                        <p>Phone: {{ $order->billing_address['phone'] }}</p>
                        <p>Email: {{ $order->billing_address['email'] }}</p>
                    </div>
                </div>

                <!-- Shipping Address -->
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">Shipping Address</h4>
                    <div class="text-sm text-gray-600 space-y-1">
                        <p>{{ $order->shipping_address['full_name'] }}</p>
                        <p>{{ $order->shipping_address['address'] }}</p>
                        <p>{{ $order->shipping_address['city'] }}, {{ $order->shipping_address['state'] }} {{ $order->shipping_address['pincode'] }}</p>
                        <p>Phone: {{ $order->shipping_address['phone'] }}</p>
                        <p>Email: {{ $order->shipping_address['email'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Payment Information -->
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-600">Payment Method</p>
                    <p class="font-medium text-gray-900">
                        @if($order->payment_method === 'cod')
                            Cash on Delivery (COD)
                        @else
                            {{ ucfirst($order->payment_method) }}
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Payment Status</p>
                    <p class="font-medium text-gray-900">{{ ucfirst($order->payment_status) }}</p>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('user.orders') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Orders
                </a>
                
                <div class="flex space-x-3">
                    @if($order->order_status === 'pending')
                        <button onclick="cancelOrder('{{ $order->id }}')" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-red-600 hover:bg-red-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Cancel Order
                        </button>
                    @endif

                    @if(in_array($order->order_status, ['confirmed', 'ready_to_ship', 'in_transit', 'out_for_delivery']))
                        <a href="{{ route('track-order.authenticated', $order->order_number) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Track Order
                        </a>
                    @endif

                    @if(in_array($order->order_status, ['in_transit', 'out_for_delivery']) && $order->tracking_url)
                        <a href="{{ $order->tracking_url }}" target="_blank" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">
                            Track on Courier Site
                        </a>
                    @endif

                    @if($order->order_status === 'delivered')
                        @php
                            $deliveredDays = $order->delivered_at ? $order->delivered_at->diffInDays(now()) : 0;
                            $existingReturn = \App\Models\ReturnOrder::where('order_id', $order->id)->first();

                            // Check if any product in the order is eligible for return
                            $canReturn = false;
                            $returnEligibleItems = [];
                            foreach($order->items as $item) {
                                if($item->product && $item->product->has_return_policy && $deliveredDays <= $item->product->return_days) {
                                    $canReturn = true;
                                    $returnEligibleItems[] = [
                                        'product_name' => $item->product->name,
                                        'return_days' => $item->product->return_days,
                                        'days_left' => $item->product->return_days - $deliveredDays
                                    ];
                                }
                            }
                        @endphp

                        <!-- Track Order Button for delivered orders too -->
                        <a href="{{ route('track-order.authenticated', $order->order_number) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Track Order
                        </a>

                        @if($canReturn && !$existingReturn)
                            <a href="{{ route('user.returns.create', $order) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-orange-600 hover:bg-orange-700" title="Return eligible items">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3"></path>
                                </svg>
                                Return Order
                            </a>
                        @elseif($existingReturn)
                            <a href="{{ route('user.returns.show', $existingReturn) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                View Return
                            </a>
                        @endif

                        <button class="inline-flex items-center px-4 py-2 border border-transparent rounded-md text-sm font-medium text-white bg-black hover:bg-gray-800">
                            Reorder
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Cancel Order Modal -->
    <div id="cancelOrderModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-md w-full p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Cancel Order</h3>
                <p class="text-sm text-gray-600 mb-4">Are you sure you want to cancel this order? This action cannot be undone.</p>

                <form id="cancelOrderForm" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-4">
                        <label for="cancellation_reason" class="block text-sm font-medium text-gray-700 mb-2">Reason for cancellation</label>
                        <select name="cancellation_reason" id="cancellation_reason" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-black">
                            <option value="">Select a reason</option>
                            <option value="changed_mind">Changed my mind</option>
                            <option value="found_better_price">Found better price elsewhere</option>
                            <option value="ordered_by_mistake">Ordered by mistake</option>
                            <option value="delivery_too_long">Delivery taking too long</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeCancelModal()" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Keep Order
                        </button>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md text-sm font-medium hover:bg-red-700">
                            Cancel Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function cancelOrder(orderId) {
            document.getElementById('cancelOrderForm').action = `/account/orders/${orderId}/cancel`;
            document.getElementById('cancelOrderModal').classList.remove('hidden');
        }

        function closeCancelModal() {
            document.getElementById('cancelOrderModal').classList.add('hidden');
        }

        // Close modal when clicking outside
        document.getElementById('cancelOrderModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeCancelModal();
            }
        });
    </script>
</x-layouts.user>
