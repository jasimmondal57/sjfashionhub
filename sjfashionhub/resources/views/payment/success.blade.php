<x-layouts.main>
    <x-slot name="pageTitle">Payment Successful - Order #{{ $order->order_number }}</x-slot>

    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <!-- Success Icon -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 rounded-full mb-6">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>

            <!-- Success Message -->
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Payment Successful!</h1>
            <p class="text-gray-600 mb-6">Thank you for your payment. Your order has been confirmed.</p>

            <!-- Order Details -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Order Number:</span>
                    <span class="font-semibold text-gray-800">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Payment Date:</span>
                    <span class="font-semibold text-gray-800">{{ now()->format('d M Y, h:i A') }}</span>
                </div>
                <div class="flex justify-between items-center text-lg">
                    <span class="text-gray-800 font-semibold">Amount Paid:</span>
                    <span class="font-bold text-green-600">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <!-- Order Items -->
            <div class="border-t border-gray-200 pt-4 mb-6">
                <h3 class="font-semibold text-gray-800 mb-3">Order Items:</h3>
                <div class="space-y-2">
                    @foreach($order->items as $item)
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">{{ $item->product->name }} × {{ $item->quantity }}</span>
                        <span class="text-gray-800">₹{{ number_format($item->total_price, 2) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-blue-800 mb-2">What's Next?</h3>
                <ul class="text-blue-700 text-sm space-y-1">
                    <li>• You will receive an order confirmation email shortly</li>
                    <li>• We'll notify you when your order is shipped</li>
                    <li>• Track your order status in your account</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('user.orders') }}" class="block w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition">
                    View Order Details
                </a>
                <a href="{{ route('home') }}" class="block w-full bg-gray-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-700 transition">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Update order status to paid
        fetch("{{ route('payment.update-status') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                order_id: {{ $order->id }},
                status: 'paid'
            })
        });

        // Track purchase event with Meta Pixel
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                if (typeof trackMetaPixelPurchase !== 'undefined') {
                    const items = @json($order->items->map(function($item) {
                        return [
                            'id' => $item->product_id,
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'price' => $item->price
                        ];
                    })->toArray());

                    trackMetaPixelPurchase(
                        {{ $order->id }},
                        {{ $order->total_amount ?? $order->total }},
                        items
                    );

                    console.log('✅ Purchase event tracked for order #{{ $order->order_number }}');
                } else {
                    console.warn('trackMetaPixelPurchase function not available');
                }
            }, 500);
        });
    </script>
    @endpush
</x-layouts.main>
