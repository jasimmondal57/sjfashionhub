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
                                <p class="text-lg font-semibold text-gray-900">${{ number_format($order->total, 2) }}</p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($order->status === 'delivered') bg-green-100 text-green-800
                                    @elseif($order->status === 'shipped') bg-blue-100 text-blue-800
                                    @elseif($order->status === 'processing') bg-yellow-100 text-yellow-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($order->items as $item)
                                <div class="flex items-center space-x-4">
                                    <img class="h-16 w-16 rounded-lg object-cover" src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h4>
                                        <p class="text-sm text-gray-600">Quantity: {{ $item->quantity }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">${{ number_format($item->price * $item->quantity, 2) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="mt-6 flex justify-between items-center">
                            <button class="text-indigo-600 hover:text-indigo-500 text-sm font-medium">
                                View Details
                            </button>
                            @if($order->status === 'delivered')
                                <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
                                    Reorder
                                </button>
                            @elseif($order->status === 'shipped')
                                <button class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm hover:bg-blue-700">
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
                <a href="/" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Start Shopping
                </a>
            </div>
        </div>
    @endif
</x-layouts.user>
