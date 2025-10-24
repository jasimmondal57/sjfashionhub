<x-layouts.main>
    <x-slot name="pageTitle">PayU Payment - Order #{{ $order->order_number }}</x-slot>
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-md mx-auto">
        <!-- Payment Processing Card -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-6">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                </div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Secure Payment</h1>
                <p class="text-gray-600">You will be redirected to PayU for secure payment processing</p>
            </div>

            <!-- Order Summary -->
            <div class="border-t border-gray-200 pt-4 mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600">Order Number:</span>
                    <span class="font-medium">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600">Amount:</span>
                    <span class="font-bold text-lg text-green-600">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm text-gray-600">Payment Method:</span>
                    <span class="font-medium">PayU Gateway</span>
                </div>
            </div>

            <!-- Auto-submit form -->
            <form id="payuForm" action="{{ $paymentData['action'] }}" method="post" class="hidden">
                <input type="hidden" name="key" value="{{ $paymentData['key'] }}" />
                <input type="hidden" name="txnid" value="{{ $paymentData['txnid'] }}" />
                <input type="hidden" name="amount" value="{{ $paymentData['amount'] }}" />
                <input type="hidden" name="productinfo" value="{{ $paymentData['productinfo'] }}" />
                <input type="hidden" name="firstname" value="{{ $paymentData['firstname'] }}" />
                <input type="hidden" name="email" value="{{ $paymentData['email'] }}" />
                <input type="hidden" name="phone" value="{{ $paymentData['phone'] }}" />
                <input type="hidden" name="surl" value="{{ $paymentData['surl'] }}" />
                <input type="hidden" name="furl" value="{{ $paymentData['furl'] }}" />
                <input type="hidden" name="hash" value="{{ $paymentData['hash'] }}" />
                <input type="hidden" name="service_provider" value="{{ $paymentData['service_provider'] }}" />
            </form>

            <!-- Loading Animation -->
            <div class="text-center">
                <div class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg">
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Redirecting to PayU...
                </div>
                <p class="text-sm text-gray-500 mt-2">Please wait while we redirect you to the payment gateway</p>
            </div>

            <!-- Manual Submit Button (fallback) -->
            <div class="mt-6 text-center">
                <button type="button" onclick="submitPayment()" class="text-blue-600 hover:text-blue-800 text-sm underline">
                    Click here if not redirected automatically
                </button>
            </div>
        </div>

        <!-- Security Notice -->
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="text-sm font-medium text-green-800">Secure Payment</h3>
                    <p class="text-sm text-green-700 mt-1">Your payment is processed securely through PayU's encrypted gateway. Your card details are never stored on our servers.</p>
                </div>
            </div>
        </div>

        <!-- Back to Cart Link -->
        <div class="text-center mt-6">
            <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-gray-800 text-sm">
                ← Back to Cart
            </a>
        </div>
    </div>
</div>

<script>
function submitPayment() {
    document.getElementById('payuForm').submit();
}

// Auto-submit form after 3 seconds
setTimeout(function() {
    submitPayment();
}, 3000);
</script>
</x-layouts.main>
