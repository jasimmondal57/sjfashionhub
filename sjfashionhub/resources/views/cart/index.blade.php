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
                                        @php
                                            $unitPrice = $item->product->sale_price ?? $item->product->price;
                                        @endphp
                                        <div class="bg-white border border-gray-200 rounded-lg p-4 shadow-sm" data-item-id="{{ $item->id }}" data-unit-price="{{ $unitPrice }}">
                                            <div class="grid grid-cols-12 gap-4 items-center">
                                                <!-- Product Image -->
                                                <div class="col-span-2">
                                                    @if($item->product->featured_image)
                                                        <img class="h-20 w-20 rounded-lg object-cover" src="{{ Storage::url($item->product->featured_image) }}" alt="{{ $item->product->name }}">
                                                    @else
                                                        <div class="h-20 w-20 rounded-lg bg-gray-100 flex items-center justify-center">
                                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>

                                                <!-- Product Details -->
                                                <div class="col-span-4">
                                                    <h3 class="text-lg font-semibold text-gray-900 mb-1">{{ $item->product->name }}</h3>
                                                    <p class="text-sm text-gray-600">{{ $item->product->category->name ?? 'No Category' }}</p>
                                                    @php
                                                        $price = $item->product->sale_price ?? $item->product->price;
                                                    @endphp
                                                    <p class="text-lg font-bold text-gray-900 mt-2">₹{{ number_format($price, 0) }}</p>
                                                </div>

                                                <!-- Quantity Controls -->
                                                <div class="col-span-3 flex justify-center">
                                                    <div class="flex items-center border border-gray-300 rounded-md">
                                                        <button class="px-3 py-1 text-gray-600 hover:text-gray-800 hover:bg-gray-50" onclick="updateQuantity({{ $item->id }}, -1)">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                            </svg>
                                                        </button>
                                                        <span class="px-4 py-1 quantity-display border-l border-r border-gray-300 min-w-[3rem] text-center" style="background-color: #f9fafb !important; color: #000000 !important; font-weight: bold !important;">{{ $item->quantity }}</span>
                                                        <button class="px-3 py-1 text-gray-600 hover:text-gray-800 hover:bg-gray-50" onclick="updateQuantity({{ $item->id }}, 1)">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>

                                                <!-- Item Total -->
                                                <div class="col-span-2 text-center">
                                                    @php
                                                        $itemPrice = $item->product->sale_price ?? $item->product->price;
                                                        $itemTotal = $itemPrice * $item->quantity;
                                                    @endphp
                                                    <p class="text-lg font-bold text-gray-900 item-total">
                                                        ₹{{ number_format($itemTotal, 0) }}
                                                    </p>
                                                </div>

                                                <!-- Remove Button -->
                                                <div class="col-span-1 text-center">
                                                    <button class="text-red-600 hover:text-red-500 p-2 rounded-lg hover:bg-red-50" onclick="removeItem({{ $item->id }})" title="Remove item">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                        </svg>
                                                    </button>
                                                </div>
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

                            <!-- Promo Code -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h3 class="text-sm font-medium text-gray-900 mb-3">Promo Code</h3>
                                <div class="flex space-x-2">
                                    <input type="text" placeholder="Enter code"
                                           class="flex-1 border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                    <button class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 text-sm font-medium">
                                        Apply
                                    </button>
                                </div>
                            </div>

                            <a href="{{ route('checkout.index') }}" class="w-full mt-6 bg-black text-white py-3 px-4 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 font-bold text-center block transition-all duration-200">
                                Proceed to Checkout
                            </a>
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
            const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
            const quantityDisplay = itemElement.querySelector('.quantity-display');
            const itemTotalElement = itemElement.querySelector('.item-total');

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

            // Get unit price from the data attribute or calculate from current total
            const unitPrice = parseFloat(itemElement.dataset.unitPrice) || (parseFloat(itemTotalElement.textContent.replace('₹', '').replace(',', '')) / currentQuantity);
            const newTotal = unitPrice * newQuantity;

            // Update item total display
            itemTotalElement.textContent = `₹${Math.round(newTotal).toLocaleString()}`;

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
                    itemTotalElement.textContent = `₹${Math.round(unitPrice * currentQuantity).toLocaleString()}`;
                    alert('Failed to update cart');
                }
            })
            .catch(error => {
                // Revert on error
                quantityDisplay.textContent = currentQuantity;
                itemTotalElement.textContent = `₹${Math.round(unitPrice * currentQuantity).toLocaleString()}`;
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
            // Calculate subtotal from all item totals
            let subtotal = 0;
            document.querySelectorAll('.item-total').forEach(element => {
                const price = parseFloat(element.textContent.replace('₹', '').replace(',', ''));
                subtotal += price;
            });

            // Update subtotal display
            document.getElementById('subtotal').textContent = `₹${Math.round(subtotal).toLocaleString()}`;

            // Calculate tax (18% GST)
            const tax = subtotal * 0.18;
            document.getElementById('tax').textContent = `₹${Math.round(tax).toLocaleString()}`;

            // Calculate total (subtotal + shipping + tax)
            const shipping = 99;
            const total = subtotal + shipping + tax;
            document.getElementById('total').textContent = `₹${Math.round(total).toLocaleString()}`;
        }

        // Initialize cart count when page loads
        document.addEventListener('DOMContentLoaded', function() {
            updateCartCount();
        });

        // Update cart count function (same as in main layout)
        function updateCartCount() {
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    const cartCountElements = document.querySelectorAll('.cart-count');
                    cartCountElements.forEach(element => {
                        element.textContent = data.count;
                    });
                })
                .catch(error => console.error('Error updating cart count:', error));
        }
    </script>
</x-layouts.main>
