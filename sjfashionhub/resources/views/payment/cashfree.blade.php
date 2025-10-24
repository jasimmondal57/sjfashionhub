<x-layouts.main>
    <x-slot name="pageTitle">Cashfree Payment - Order #{{ $order->order_number }}</x-slot>

    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <!-- Order Summary -->
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-gray-800 mb-4">Cashfree Payment</h1>
                
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
            </div>

            <!-- Payment Processing -->
            <div class="text-center mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Payment Options</h2>

                @if(session('error'))
                    <!-- Error Message -->
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-red-800 font-medium">{{ session('error') }}</span>
                        </div>
                    </div>
                @elseif(session('info'))
                    <!-- Info Message -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-blue-800 font-medium">{{ session('info') }}</span>
                        </div>
                    </div>
                @endif

                <p class="text-gray-600 mb-6">
                    Choose your preferred payment method for Order #{{ $order->order_number }}
                </p>

                @if(session('info'))
                    <!-- Test Mode Buttons -->
                    <div class="space-y-3 mb-6">
                        <button onclick="simulatePayment('success')" class="w-full bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 transition">
                            ✅ Simulate Successful Payment
                        </button>
                        <button onclick="simulatePayment('failed')" class="w-full bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 transition">
                            ❌ Simulate Failed Payment
                        </button>
                    </div>
                @elseif(!session('error'))
                    <!-- Normal Payment Loading -->
                    <div class="text-center mb-6">
                        <div class="flex justify-center mb-4">
                            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
                        </div>
                        <p class="text-gray-600">Redirecting to secure payment page...</p>
                    </div>
                @endif
            </div>

            <!-- Payment Actions -->
            <div class="space-y-4">
                @if(session('error'))
                    <!-- Cash on Delivery Option -->
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-green-800 mb-2">Alternative Payment Method</h3>
                        <p class="text-green-700 mb-3">You can complete your order using Cash on Delivery instead.</p>
                        <form action="{{ route('payment.cod-fallback', $order->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-green-600 text-white py-3 px-6 rounded-lg hover:bg-green-700 transition">
                                💰 Complete Order with Cash on Delivery
                            </button>
                        </form>
                    </div>
                @endif

                <div class="text-center">
                    <button id="payNowBtn" class="bg-blue-600 text-white py-3 px-8 rounded-lg font-semibold hover:bg-blue-700 transition">
                        {{ session('error') ? 'Try Online Payment Again' : 'Go Back to Checkout' }}
                    </button>

                    <div class="mt-4">
                        <a href="{{ route('checkout.index') }}" class="text-gray-600 hover:text-gray-800 text-sm">
                            ← Back to Checkout
                        </a>
                    </div>
                </div>
            </div>

            <!-- Security Notice -->
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mt-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-green-800 text-sm">
                        Your payment is secured by Cashfree's 256-bit SSL encryption
                    </p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        @if(!session('info'))
        // Auto-redirect message (this page should rarely be seen since we redirect directly to Cashfree)
        setTimeout(() => {
            const spinner = document.querySelector('.animate-spin');
            if (spinner) spinner.style.display = 'none';
            document.querySelector('h2').textContent = 'Redirecting to payment...';
            document.querySelector('p').textContent = 'If you are not redirected automatically, please click the button below.';
        }, 5000);
        @endif

        // Manual redirect button
        document.getElementById('payNowBtn').addEventListener('click', function() {
            window.location.href = "{{ route('checkout.index') }}";
        });

        // Test mode payment simulation
        window.simulatePayment = function(status) {
            if (status === 'success') {
                window.location.href = "{{ route('payment.success', $order->id) }}";
            } else {
                window.location.href = "{{ route('payment.failure', $order->id) }}";
            }
        };
    </script>
    @endpush
</x-layouts.main>
