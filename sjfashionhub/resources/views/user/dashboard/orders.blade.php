<x-layouts.user title="My Orders" subtitle="Track your orders and view order history">
    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">Order #{{ $order->order_number }}</h3>
                                <p class="text-sm text-gray-600">Placed on {{ $order->created_at->format('F j, Y') }}</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-semibold text-gray-900">₹{{ number_format($order->total_amount, 0) }}</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $order->status_badge['class'] }}">
                                    {{ $order->status_badge['text'] }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center space-x-4">
                                    @if($item->product && $item->product->featured_image)
                                        <img class="h-16 w-16 rounded-lg object-cover" src="{{ Storage::url($item->product->featured_image) }}" alt="{{ $item->product_name }}">
                                    @else
                                        <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $item->product_name }}</h4>
                                        <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">₹{{ number_format($item->total_price, 0) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 flex justify-between items-center">
                            <a href="{{ route('user.orders.show', $order) }}" class="text-black hover:text-gray-700 text-sm font-medium">
                                View Details
                            </a>
                            <div class="flex space-x-2">
                                @if($order->order_status === 'pending')
                                    <button onclick="cancelOrder('{{ $order->id }}')" class="bg-red-600 text-white px-4 py-2 rounded-md text-sm hover:bg-red-700">
                                        Cancel Order
                                    </button>
                                @elseif(in_array($order->order_status, ['confirmed', 'ready_to_ship', 'in_transit', 'out_for_delivery']))
                                    <a href="{{ route('track-order.authenticated', $order->order_number) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 inline-block">
                                        Track Order
                                    </a>
                                @elseif($order->order_status === 'delivered')
                                    @php
                                        $deliveredDays = $order->delivered_at ? $order->delivered_at->diffInDays(now()) : 0;
                                        $existingReturn = \App\Models\ReturnOrder::where('order_id', $order->id)->first();

                                        // Check if any product in the order is eligible for return
                                        $canReturn = false;
                                        foreach($order->items as $item) {
                                            if($item->product && $item->product->has_return_policy && $deliveredDays <= $item->product->return_days) {
                                                $canReturn = true;
                                                break;
                                            }
                                        }
                                    @endphp

                                    <!-- Track Order Button for delivered orders too -->
                                    <a href="{{ route('track-order.authenticated', $order->order_number) }}" class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700 inline-block">
                                        Track Order
                                    </a>

                                    @if($canReturn && !$existingReturn)
                                        <a href="{{ route('user.returns.create', $order) }}" class="bg-orange-600 text-white px-4 py-2 rounded-md text-sm hover:bg-orange-700 inline-block">
                                            Return Order
                                        </a>
                                    @elseif($existingReturn)
                                        <a href="{{ route('user.returns.show', $existingReturn) }}" class="bg-gray-600 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-700 inline-block">
                                            View Return
                                        </a>
                                    @endif

                                    <button class="bg-black text-white px-4 py-2 rounded-md text-sm hover:bg-gray-800">
                                        Reorder
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">No orders yet</h3>
            <p class="mt-2 text-gray-600">You haven't placed any orders yet. Start shopping to see your orders here.</p>
            <div class="mt-6">
                <a href="/" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-black hover:bg-gray-800">
                    Start Shopping
                </a>
            </div>
        </div>
    @endif

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
