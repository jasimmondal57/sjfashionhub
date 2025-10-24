<x-layouts.main>
    <x-slot name="pageTitle">Payment Failed - Order #{{ $order->order_number }}</x-slot>

    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <div class="bg-white rounded-lg shadow-lg p-6 text-center">
            <!-- Failure Icon -->
            <div class="inline-flex items-center justify-center w-20 h-20 bg-red-100 rounded-full mb-6">
                <svg class="w-10 h-10 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </div>

            <!-- Failure Message -->
            <h1 class="text-3xl font-bold text-gray-800 mb-4">Payment Failed</h1>
            <p class="text-gray-600 mb-6">We're sorry, but your payment could not be processed. Please try again.</p>

            <!-- Order Details -->
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Order Number:</span>
                    <span class="font-semibold text-gray-800">{{ $order->order_number }}</span>
                </div>
                <div class="flex justify-between items-center mb-2">
                    <span class="text-gray-600">Attempted Date:</span>
                    <span class="font-semibold text-gray-800">{{ now()->format('d M Y, h:i A') }}</span>
                </div>
                <div class="flex justify-between items-center text-lg">
                    <span class="text-gray-800 font-semibold">Amount:</span>
                    <span class="font-bold text-red-600">₹{{ number_format($order->total_amount, 2) }}</span>
                </div>
            </div>

            <!-- Possible Reasons -->
            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <h3 class="font-semibold text-yellow-800 mb-2">Possible Reasons:</h3>
                <ul class="text-yellow-700 text-sm space-y-1 text-left">
                    <li>• Insufficient funds in your account</li>
                    <li>• Card expired or blocked</li>
                    <li>• Network connectivity issues</li>
                    <li>• Bank server temporarily unavailable</li>
                    <li>• Transaction limit exceeded</li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="{{ route('payment.show', $order->id) }}" class="block w-full bg-blue-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Try Payment Again
                </a>
                <a href="{{ route('checkout.index') }}" class="block w-full bg-gray-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-gray-700 transition">
                    Modify Order
                </a>
                <a href="{{ route('home') }}" class="block w-full bg-gray-300 text-gray-700 py-3 px-6 rounded-lg font-semibold hover:bg-gray-400 transition">
                    Continue Shopping
                </a>
            </div>

            <!-- Support -->
            <div class="mt-6 pt-6 border-t border-gray-200">
                <p class="text-gray-600 text-sm mb-2">Need help?</p>
                <a href="{{ route('contact') }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">
                    Contact Support
                </a>
            </div>
        </div>
    </div>
</x-layouts.main>
