<x-layouts.main>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
                <p class="text-gray-600 mt-2">Complete your order</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Checkout Form -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Shipping Information</h2>
                    
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                        @csrf
                        
                        <!-- Personal Information -->
                        <div class="mb-6">
                            <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" id="full_name" name="full_name" required
                                   value="{{ old('full_name', Auth::user()->name ?? '') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" id="email" name="email" required
                                       value="{{ old('email', Auth::user()->email ?? '') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">
                            </div>
                            <div>
                                <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                                <input type="tel" id="phone" name="phone" required
                                       value="{{ old('phone', Auth::user()->phone ?? '') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">
                            </div>
                        </div>

                        <!-- Address Information -->
                        <div class="mb-6">
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                            <textarea id="address" name="address" required rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">{{ old('address') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City *</label>
                                <input type="text" id="city" name="city" required
                                       value="{{ old('city') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">
                            </div>
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State *</label>
                                <input type="text" id="state" name="state" required
                                       value="{{ old('state') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">
                            </div>
                            <div>
                                <label for="pincode" class="block text-sm font-medium text-gray-700 mb-2">Pincode *</label>
                                <input type="text" id="pincode" name="pincode" required
                                       value="{{ old('pincode') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black">
                            </div>
                        </div>

                    </form>
                </div>

                <!-- Order Summary -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Order Summary</h2>
                    
                    <!-- Cart Items -->
                    <div class="space-y-4 mb-6">
                        @foreach($cartItems as $item)
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    @if($item->product->featured_image)
                                        <img class="h-16 w-16 rounded-lg object-cover" 
                                             src="{{ Storage::url($item->product->featured_image) }}" 
                                             alt="{{ $item->product->name }}">
                                    @else
                                        <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-600">Qty: {{ $item->quantity }}</p>
                                </div>
                                <div class="text-sm font-medium text-gray-900">
                                    @php
                                        $price = $item->product->sale_price ?? $item->product->price;
                                        $itemTotal = $price * $item->quantity;
                                    @endphp
                                    ₹{{ number_format($itemTotal, 2) }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Order Totals -->
                    <div class="border-t border-gray-200 pt-4">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="text-gray-900 font-medium">₹{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span class="text-gray-900">₹{{ number_format($shipping, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax (18% GST)</span>
                                <span class="text-gray-900">₹{{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-medium text-gray-900">Total</span>
                                    <span class="text-lg font-medium text-gray-900">₹{{ number_format($total, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Method</h3>
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="cod" checked form="checkout-form"
                                       class="h-4 w-4 text-black focus:ring-black border-gray-300">
                                <span class="ml-3 text-sm text-gray-700">Cash on Delivery (COD)</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="payment_method" value="online" form="checkout-form"
                                       class="h-4 w-4 text-black focus:ring-black border-gray-300">
                                <span class="ml-3 text-sm text-gray-700">Online Payment (UPI/Card)</span>
                            </label>
                        </div>
                    </div>

                    <!-- Place Order Button -->
                    <button type="submit" form="checkout-form" id="place-order-btn"
                            class="w-full mt-6 bg-black text-white py-4 px-6 rounded-lg hover:bg-gray-800 transition-all duration-200 font-bold text-lg relative overflow-hidden">
                        <span class="button-text">Place Order</span>
                        <span class="success-text hidden">Order Placed! 🚚</span>
                    </button>

                    <!-- Security Notice -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-sm text-gray-700">Secure checkout with SSL encryption</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Truck Animation Styles -->
    <style>
        .truck-animation {
            position: fixed;
            top: 50%;
            left: -100px;
            transform: translateY(-50%);
            font-size: 3rem;
            z-index: 1000;
            animation: truckDrive 3s ease-in-out;
        }

        @keyframes truckDrive {
            0% {
                left: -100px;
            }
            50% {
                left: 50%;
                transform: translateX(-50%) translateY(-50%);
            }
            100% {
                left: 100vw;
                transform: translateY(-50%);
            }
        }

        #place-order-btn.processing {
            background-color: #4b5563 !important;
            cursor: not-allowed;
        }

        #place-order-btn.success {
            background-color: #10b981 !important;
        }
    </style>

    <!-- JavaScript for Place Order Animation -->
    <script>
        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            e.preventDefault();

            const button = document.getElementById('place-order-btn');
            const buttonText = button.querySelector('.button-text');
            const successText = button.querySelector('.success-text');

            // Show processing state
            button.classList.add('processing');
            buttonText.textContent = 'Processing...';
            button.disabled = true;

            // Show truck animation
            showTruckAnimation();

            // Simulate processing time then submit
            setTimeout(() => {
                // Show success state
                button.classList.remove('processing');
                button.classList.add('success');
                buttonText.style.display = 'none';
                successText.style.display = 'inline';

                // Submit the form after animation
                setTimeout(() => {
                    this.submit();
                }, 1000);
            }, 2000);
        });

        function showTruckAnimation() {
            // Create truck element
            const truck = document.createElement('div');
            truck.className = 'truck-animation';
            truck.innerHTML = '🚚';

            // Add to page
            document.body.appendChild(truck);

            // Remove after animation
            setTimeout(() => {
                if (truck.parentNode) {
                    truck.parentNode.removeChild(truck);
                }
            }, 3000);
        }
    </script>
</x-layouts.main>
