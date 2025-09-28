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
                            <button class="text-black hover:text-gray-700 text-sm font-medium">
                                View Details
                            </button>
                            @if($order->order_status === 'delivered')
                                <button class="bg-black text-white px-4 py-2 rounded-md text-sm hover:bg-gray-800">
                                    Reorder
                                </button>
                            @elseif(in_array($order->order_status, ['in_transit', 'out_for_delivery']))
                                <button class="bg-black text-white px-4 py-2 rounded-md text-sm hover:bg-gray-800">
                                    Track Order
                                </button>
                            @endif
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
</x-layouts.user>
