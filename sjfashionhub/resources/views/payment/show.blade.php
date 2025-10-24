<x-layouts.main>
    <x-slot name="pageTitle">Complete Payment - Order #{{ $order->order_number }}</x-slot>

    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Order Summary -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Complete Your Payment</h1>
                
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600">Order Number:</span>
                        <span class="font-semibold text-gray-800">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-gray-600">Order Date:</span>
                        <span class="font-semibold text-gray-800">{{ $order->created_at->format('d M Y, h:i A') }}</span>
                    </div>
                    <div class="flex justify-between items-center text-lg">
                        <span class="text-gray-800 font-semibold">Total Amount:</span>
                        <span class="font-bold text-blue-600">₹{{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="font-semibold text-gray-800 mb-3">Order Items:</h3>
                    <div class="space-y-2">
                        @foreach($order->items as $item)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ $item->product->name }} × {{ $item->quantity }}</span>
                            <span class="text-gray-800">₹{{ number_format($item->subtotal, 2) }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Payment Methods -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Select Payment Method</h2>
                
                @if($paymentGateways->isEmpty())
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <p class="text-yellow-800">No payment methods available. Please contact support.</p>
                    </div>
                @else
                    <form action="{{ route('payment.process', $order->id) }}" method="POST" id="paymentForm">
                        @csrf
                        
                        <div class="space-y-3">
                            @foreach($paymentGateways as $gateway)
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input type="radio" name="payment_gateway" value="{{ $gateway->name }}" class="mr-3" required>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800">{{ $gateway->display_name }}</div>
                                    <div class="text-sm text-gray-600">{{ $gateway->description }}</div>
                                </div>
                            </label>
                            @endforeach

                            <!-- COD Option -->
                            <label class="flex items-center p-4 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-500 transition">
                                <input type="radio" name="payment_gateway" value="cod" class="mr-3" required>
                                <div class="flex-1">
                                    <div class="font-semibold text-gray-800">💵 Cash on Delivery</div>
                                    <div class="text-sm text-gray-600">Pay when you receive your order</div>
                                </div>
                            </label>
                        </div>

                        <button type="submit" class="w-full mt-6 bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition">
                            Proceed to Payment
                        </button>
                    </form>
                @endif
            </div>

            <!-- Timer -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
                <p class="text-red-800 text-sm">
                    ⏰ Complete payment within <span id="timer" class="font-bold">30:00</span> minutes
                </p>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Payment timer
        let timeLeft = 30 * 60; // 30 minutes in seconds
        const timerElement = document.getElementById('timer');

        function updateTimer() {
            const minutes = Math.floor(timeLeft / 60);
            const seconds = timeLeft % 60;
            timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
            
            if (timeLeft <= 0) {
                window.location.reload();
            } else {
                timeLeft--;
            }
        }

        setInterval(updateTimer, 1000);
    </script>
    @endpush
</x-layouts.main>

