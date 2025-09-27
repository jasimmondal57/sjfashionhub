<x-layouts.user title="My Cart" subtitle="Review items in your cart and proceed to checkout">
    @if($cartItems->count() > 0)
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Cart Items -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Shopping Cart ({{ $cartItems->count() }} items)</h3>
                    </div>
                    <div class="p-6">
                        <div class="space-y-6">
                            @foreach($cartItems as $item)
                                <div class="flex items-center space-x-4">
                                    <img class="h-20 w-20 rounded-lg object-cover" src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-medium text-gray-900">{{ $item->product->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $item->product->description }}</p>
                                        <div class="mt-2 flex items-center space-x-4">
                                            <div class="flex items-center border border-gray-300 rounded-md">
                                                <button class="px-3 py-1 text-gray-600 hover:text-gray-800">-</button>
                                                <span class="px-3 py-1 border-l border-r border-gray-300">{{ $item->quantity }}</span>
                                                <button class="px-3 py-1 text-gray-600 hover:text-gray-800">+</button>
                                            </div>
                                            <button class="text-red-600 hover:text-red-500 text-sm">Remove</button>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-medium text-gray-900">${{ number_format($item->product->price * $item->quantity, 2) }}</p>
                                        <p class="text-sm text-gray-600">${{ number_format($item->product->price, 2) }} each</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="text-gray-900">${{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity; }), 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Shipping</span>
                            <span class="text-gray-900">$5.99</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tax</span>
                            <span class="text-gray-900">${{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity; }) * 0.08, 2) }}</span>
                        </div>
                        <div class="border-t border-gray-200 pt-3">
                            <div class="flex justify-between">
                                <span class="text-lg font-medium text-gray-900">Total</span>
                                <span class="text-lg font-medium text-gray-900">
                                    ${{ number_format($cartItems->sum(function($item) { return $item->product->price * $item->quantity; }) * 1.08 + 5.99, 2) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <button class="w-full mt-6 bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        Proceed to Checkout
                    </button>

                    <button class="w-full mt-3 bg-gray-200 text-gray-800 py-2 px-4 rounded-md hover:bg-gray-300">
                        Continue Shopping
                    </button>
                </div>

                <!-- Promo Code -->
                <div class="bg-white rounded-lg shadow p-6 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Promo Code</h3>
                    <div class="flex space-x-2">
                        <input type="text" placeholder="Enter promo code" 
                               class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <button class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900">
                            Apply
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Empty Cart -->
        <div class="text-center py-12">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Your cart is empty</h3>
            <p class="mt-2 text-gray-600">Add some items to your cart to see them here.</p>
            <div class="mt-6">
                <a href="/" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Start Shopping
                </a>
            </div>
        </div>
    @endif
</x-layouts.user>
