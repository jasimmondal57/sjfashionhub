<x-layouts.main title="Shopping Cart - SJ Fashion Hub">
    <div class="min-h-screen bg-gray-50 py-4 md:py-8">
        <div class="container mx-auto px-4">
            <!-- Page Header -->
            <div class="mb-6 md:mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Shopping Cart</h1>
                <p class="text-gray-600 mt-2 text-sm md:text-base">Review your items and proceed to checkout</p>
            </div>

            @if($cartItems->count() > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="px-4 md:px-6 py-3 md:py-4 border-b border-gray-200">
                                <h2 class="text-base md:text-lg font-medium text-gray-900">Cart Items ({{ $cartItems->count() }})</h2>
                            </div>
                            <div class="p-4 md:p-6">
                                <div class="space-y-6">
                                    @foreach($cartItems as $item)
                                        @php
                                            $unitPrice = $item->product->sale_price ?? $item->product->price;
                                            $taxRate = $item->product->tax_rate ?? 5;
                                        @endphp
                                        <div class="bg-white border border-gray-200 rounded-lg p-3 md:p-4 shadow-sm" data-item-id="{{ $item->id }}" data-unit-price="{{ $unitPrice }}" data-tax-rate="{{ $taxRate }}">
                                            <!-- Mobile Layout -->
                                            <div class="block md:hidden">
                                                <div class="flex space-x-3">
                                                    <!-- Product Image -->
                                                    <div class="flex-shrink-0">
                                                        @if($item->product->main_image)
                                                            <img class="h-16 w-16 rounded-lg object-cover" src="{{ $item->product->main_image }}" alt="{{ $item->product->name }}">
                                                        @else
                                                            <div class="h-16 w-16 rounded-lg bg-gray-100 flex items-center justify-center">
                                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                                </svg>
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Product Details -->
                                                    <div class="flex-1 min-w-0">
                                                        <h3 class="text-sm font-semibold text-gray-900 mb-1 truncate">{{ $item->product->name }}</h3>
                                                        <p class="text-xs text-gray-600">{{ $item->product->category->name ?? 'No Category' }}</p>
                                                        @if($item->productVariant)
                                                            <p class="text-xs text-blue-600 font-medium mt-1">
                                                                Size: {{ $item->productVariant->option1_value }}
                                                            </p>
                                                        @endif
                                                        @php
                                                            $price = $item->product->sale_price ?? $item->product->price;
                                                        @endphp
                                                        <p class="text-base font-bold text-gray-900 mt-1">₹{{ number_format($price, 0) }}</p>

                                                        <!-- Mobile Quantity and Remove -->
                                                        <div class="flex items-center justify-between mt-2">
                                                            <div class="flex items-center space-x-2">
                                                                <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})" class="w-7 h-7 border border-gray-300 rounded flex items-center justify-center text-sm hover:bg-gray-50">-</button>
                                                                <span class="quantity-display text-sm font-medium w-8 text-center">{{ $item->quantity }}</span>
                                                                <button onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})" class="w-7 h-7 border border-gray-300 rounded flex items-center justify-center text-sm hover:bg-gray-50">+</button>
                                                            </div>
                                                            <button onclick="removeFromCart({{ $item->id }})" class="text-red-600 hover:text-red-800 text-xs">Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Desktop Layout -->
                                            <div class="hidden md:grid grid-cols-12 gap-4 items-center">
                                                <!-- Product Image -->
                                                <div class="col-span-2">
                                                    @if($item->product->main_image)
                                                        <img class="h-20 w-20 rounded-lg object-cover" src="{{ $item->product->main_image }}" alt="{{ $item->product->name }}">
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
                                                    @if($item->productVariant)
                                                        <p class="text-sm text-blue-600 font-medium mt-1">
                                                            Size: {{ $item->productVariant->option1_value }}
                                                        </p>
                                                    @endif
                                                    @php
                                                        $price = $item->product->sale_price ?? $item->product->price;
                                                    @endphp
                                                    <p class="text-lg font-bold text-gray-900 mt-2">₹{{ number_format($price, 0) }}</p>
                                                </div>

                                                <!-- Quantity Controls -->
                                                <div class="col-span-3 flex justify-center">
                                                    <div class="flex items-center border border-gray-300 rounded-md">
                                                        <button class="px-3 py-1 text-gray-600 hover:text-gray-800 hover:bg-gray-50" onclick="updateQuantity({{ $item->id }}, {{ $item->quantity - 1 }})">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                            </svg>
                                                        </button>
                                                        <span class="px-4 py-1 quantity-display border-l border-r border-gray-300 min-w-[3rem] text-center bg-gray-50 text-gray-900 font-bold">{{ $item->quantity }}</span>
                                                        <button class="px-3 py-1 text-gray-600 hover:text-gray-800 hover:bg-gray-50" onclick="updateQuantity({{ $item->id }}, {{ $item->quantity + 1 }})">
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
                                                    <button class="text-red-600 hover:text-red-500 p-2 rounded-lg hover:bg-red-50" onclick="removeFromCart({{ $item->id }})" title="Remove item">
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
                                <div class="mt-4 md:mt-6 flex flex-col md:flex-row justify-between items-center pt-4 md:pt-6 border-t border-gray-200 space-y-2 md:space-y-0">
                                    <button onclick="clearCart()" class="text-red-600 hover:text-red-500 font-medium text-sm md:text-base">
                                        Clear Cart
                                    </button>
                                    <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-500 font-medium text-sm md:text-base">
                                        Continue Shopping
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 md:p-6 lg:sticky lg:top-8">
                            <h2 class="text-base md:text-lg font-medium text-gray-900 mb-3 md:mb-4">Order Summary</h2>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Subtotal (excl. tax)</span>
                                    <span class="text-gray-900 font-medium" id="subtotal">₹{{ number_format($subtotal, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Tax (GST included)</span>
                                    <span class="text-gray-900" id="tax">₹{{ number_format($tax, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Shipping</span>
                                    <span class="text-gray-900" id="shipping">
                                        @if($shipping > 0)
                                            ₹{{ number_format($shipping, 2) }}
                                        @else
                                            <span class="text-green-600 font-medium">FREE</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="border-t border-gray-200 pt-3">
                                    <div class="flex justify-between">
                                        <span class="text-lg font-medium text-gray-900">Total</span>
                                        <span class="text-lg font-medium text-gray-900" id="total">
                                            ₹{{ number_format($total, 2) }}
                                        </span>
                                    </div>
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
        function updateQuantity(itemId, newQuantity) {
            const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
            const quantityDisplay = itemElement.querySelector('.quantity-display');
            const itemTotalElement = itemElement.querySelector('.item-total');

            let currentQuantity = parseInt(quantityDisplay.textContent);

            if (newQuantity < 1) {
                if (confirm('Remove this item from cart?')) {
                    removeFromCart(itemId);
                }
                return;
            }

            // Disable buttons during update
            const buttons = itemElement.querySelectorAll('button');
            buttons.forEach(btn => btn.disabled = true);

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
                    // Update quantity display
                    quantityDisplay.textContent = newQuantity;

                    // Update item total from server response
                    if (data.item_total) {
                        itemTotalElement.textContent = `₹${Math.round(data.item_total).toLocaleString()}`;
                    }

                    // Update cart totals
                    updateCartTotals();

                    // Update cart count in header
                    updateCartCount();
                } else {
                    // Show error message
                    alert(data.message || 'Failed to update cart');
                }
            })
            .catch(error => {
                console.error('Error updating cart:', error);
                alert('Failed to update cart. Please try again.');
            })
            .finally(() => {
                // Re-enable buttons
                buttons.forEach(btn => btn.disabled = false);
            });
        }

        function removeFromCart(itemId) {
            if (!confirm('Are you sure you want to remove this item from your cart?')) {
                return;
            }

            fetch(`/cart/remove/${itemId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Remove the item element from DOM
                    const itemElement = document.querySelector(`[data-item-id="${itemId}"]`);
                    if (itemElement) {
                        itemElement.remove();
                    }

                    // Update cart totals and count
                    updateCartTotals();
                    updateCartCount();

                    // Check if cart is empty and reload if needed
                    const remainingItems = document.querySelectorAll('[data-item-id]');
                    if (remainingItems.length === 0) {
                        location.reload(); // Reload to show empty cart message
                    }
                } else {
                    alert(data.message || 'Failed to remove item');
                }
            })
            .catch(error => {
                console.error('Error removing item:', error);
                alert('Failed to remove item. Please try again.');
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
            // Calculate total from all item totals (prices include tax)
            let totalWithTax = 0;
            document.querySelectorAll('.item-total').forEach(element => {
                const price = parseFloat(element.textContent.replace('₹', '').replace(',', ''));
                totalWithTax += price;
            });

            // Calculate inclusive GST based on actual product tax rates
            let tax = 0;
            let subtotal = 0;

            // Calculate tax for each item based on its product tax rate
            document.querySelectorAll('[data-item-id]').forEach(itemElement => {
                const itemTotal = parseFloat(itemElement.querySelector('.item-total').textContent.replace('₹', '').replace(',', ''));
                const taxRate = parseFloat(itemElement.dataset.taxRate) || 5; // Default to 5% if not set

                // Reverse GST calculation: tax portion from inclusive price
                const itemTax = itemTotal * (taxRate / (100 + taxRate));
                const itemSubtotal = itemTotal - itemTax;

                tax += itemTax;
                subtotal += itemSubtotal;
            });

            // Update displays
            document.getElementById('subtotal').textContent = `₹${Math.round(subtotal).toLocaleString()}`;
            document.getElementById('tax').textContent = `₹${Math.round(tax).toLocaleString()}`;

            // Calculate shipping dynamically via AJAX
            fetch('/cart/calculate-shipping', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart_total: totalWithTax // Use total with tax for shipping calculation
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const shipping = data.shipping;
                    const shippingElement = document.getElementById('shipping');

                    if (shipping > 0) {
                        shippingElement.innerHTML = `₹${Math.round(shipping).toLocaleString()}`;
                    } else {
                        shippingElement.innerHTML = '<span class="text-green-600 font-medium">FREE</span>';
                    }

                    // Calculate total
                    const total = subtotal + shipping + tax;
                    document.getElementById('total').textContent = `₹${Math.round(total).toLocaleString()}`;
                } else {
                    // Fallback to current shipping value if AJAX fails
                    const currentShipping = {{ $shipping }};
                    const total = subtotal + currentShipping + tax;
                    document.getElementById('total').textContent = `₹${Math.round(total).toLocaleString()}`;
                }
            })
            .catch(error => {
                console.error('Error calculating shipping:', error);
                // Fallback to current shipping value
                const currentShipping = {{ $shipping }};
                const total = subtotal + currentShipping + tax;
                document.getElementById('total').textContent = `₹${Math.round(total).toLocaleString()}`;
            });
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
