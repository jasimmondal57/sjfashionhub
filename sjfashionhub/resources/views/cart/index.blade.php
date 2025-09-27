<x-layouts.main title="Shopping Cart - SJ Fashion Hub">
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Shopping Cart</h1>
                <p class="text-gray-600 mt-2">Review your items and proceed to checkout</p>
            </div>

            @if($cartItems->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h2 class="text-lg font-medium text-gray-900">Cart Items ({{ $cartItems->count() }})</h2>
                            </div>
                            <div class="p-6">
                                <div class="space-y-6">
                                    @foreach($cartItems as $item)
                                        <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg" data-item-id="{{ $item->id }}">
                                            <!-- Product Image -->
                                            <div class="flex-shrink-0">
                                                @if($item->product->featured_image)
                                                    <img class="h-24 w-24 rounded-lg object-cover" src="{{ Storage::url($item->product->featured_image) }}" alt="{{ $item->product->name }}">
                                                @else
                                                    <div class="h-24 w-24 rounded-lg bg-gray-200 flex items-center justify-center">
                                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Product Details -->
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-lg font-medium text-gray-900">{{ $item->product->name }}</h3>
                                                <p class="text-sm text-gray-600 mt-1">{{ $item->product->category->name ?? 'No Category' }}</p>
                                                @php
                                                    $price = $item->product->sale_price ?? $item->product->price;
                                                @endphp
                                                <p class="text-lg font-semibold text-gray-900 mt-2">₹{{ number_format($price, 2) }}</p>
                                            </div>
                                            
                                            <!-- Quantity Controls -->
                                            <div class="flex items-center space-x-3">
                                                <div class="flex items-center border border-gray-300 rounded-md">
                                                    <button class="px-3 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-50" onclick="updateQuantity({{ $item->id }}, -1)">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        </svg>
                                                    </button>
                                                    <span class="px-4 py-2 text-gray-900 font-medium quantity-display">{{ $item->quantity }}</span>
                                                    <button class="px-3 py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-50" onclick="updateQuantity({{ $item->id }}, 1)">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                                
                                                <!-- Remove Button -->
                                                <button class="text-red-600 hover:text-red-500 p-2" onclick="removeItem({{ $item->id }})">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                            
                                            <!-- Item Total -->
                                            <div class="text-right">
                                                @php
                                                    $itemPrice = $item->product->sale_price ?? $item->product->price;
                                                    $itemTotal = $itemPrice * $item->quantity;
                                                @endphp
                                                <p class="text-lg font-semibold text-gray-900 item-total">
                                                    ₹{{ number_format($itemTotal, 2) }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                
                                <!-- Cart Actions -->
                                <div class="mt-6 flex justify-between items-center pt-6 border-t border-gray-200">
                                    <button onclick="clearCart()" class="text-red-600 hover:text-red-500 font-medium">
                                        Clear Cart
                                    </button>
                                    <a href="{{ route('products.index') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">
                                        Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 sticky top-8">
                            <h2 class="text-lg font-medium text-gray-900 mb-4">Order Summary</h2>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal</span>
                                    <span class="text-gray-900 font-medium" id="subtotal">₹{{ number_format($cartTotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="text-gray-900">₹99</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax (18% GST)</span>
                                    <span class="text-gray-900" id="tax">₹{{ number_format($cartTotal * 0.18, 2) }}</span>
                                </div>
                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-medium text-gray-900">Total</span>
                                        <span class="text-lg font-medium text-gray-900" id="total">
                                            ₹{{ number_format($cartTotal * 1.18 + 99, 2) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <button class="w-full mt-6 bg-indigo-600 text-white py-3 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 font-medium">
                                Proceed to Checkout
                            </button>

                            <!-- Promo Code -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h3 class="text-sm font-medium text-gray-900 mb-3">Promo Code</h3>
                                <div class="flex space-x-2">
                                    <input type="text" placeholder="Enter code" 
                                           class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <button class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-900 text-sm font-medium">
                                        Apply
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="text-center py-16">
                    <div class="mx-auto h-24 w-24 text-gray-400 mb-6">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="w-full h-full">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-medium text-gray-900 mb-2">Your cart is empty</h3>
                    <p class="text-gray-600 mb-8">Add some amazing products to your cart and they'll show up here.</p>
                    <a href="{{ route('products.index') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                        Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- JavaScript for Cart Functionality -->
    <script>
        function updateQuantity(itemId, change) {
            const quantityDisplay = document.querySelector(`[data-item-id="${itemId}"] .quantity-display`);
            let currentQuantity = parseInt(quantityDisplay.textContent);
            let newQuantity = currentQuantity + change;
            
            if (newQuantity < 1) {
                if (confirm('Remove this item from cart?')) {
                    removeItem(itemId);
                }
                return;
            }
            
            // Update display immediately for better UX
            quantityDisplay.textContent = newQuantity;
            
            // Send AJAX request to update quantity
            fetch(`/cart/update/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ quantity: newQuantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateCartTotals();
                } else {
                    // Revert on error
                    quantityDisplay.textContent = currentQuantity;
                    alert('Failed to update cart');
                }
            })
            .catch(error => {
                // Revert on error
                quantityDisplay.textContent = currentQuantity;
                alert('Failed to update cart');
            });
        }
        
        function removeItem(itemId) {
            fetch(`/cart/remove/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector(`[data-item-id="${itemId}"]`).remove();
                    updateCartTotals();
                    location.reload(); // Reload to show empty cart if no items left
                } else {
                    alert('Failed to remove item');
                }
            });
        }
        
        function clearCart() {
            if (confirm('Are you sure you want to clear your entire cart?')) {
                fetch('/cart/clear', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Failed to clear cart');
                    }
                });
            }
        }
        
        function updateCartTotals() {
            // This would calculate totals from current cart items
            // For now, just a placeholder
        }
    </script>
</x-layouts.main>
