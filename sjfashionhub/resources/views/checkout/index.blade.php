<x-layouts.main>
    <!-- Facebook Pixel InitiateCheckout Event -->
    <x-tracking.facebook-pixel-events
        event="InitiateCheckout"
        :cartTotal="$total"
        :cartItemCount="$cartCount"
        :cartItems="$cartItems"
    />

    <div class="min-h-screen bg-gray-50 py-4 md:py-8">
        <div class="container mx-auto px-4">
            <!-- Header -->
            <div class="mb-6 md:mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Checkout</h1>
                <p class="text-gray-600 mt-2 text-sm md:text-base">Complete your order</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8">
                <!-- Checkout Form -->
                <div class="bg-white rounded-lg shadow-sm p-4 md:p-6">
                    @auth
                        @if($userAddresses->count() > 0)
                            <!-- Saved Addresses Section -->
                            <div class="mb-6">
                                <h2 class="text-lg md:text-xl font-semibold text-gray-900 mb-4">Select Delivery Address</h2>

                                <div class="space-y-3 mb-4">
                                    @foreach($userAddresses as $address)
                                        <label class="relative block">
                                            <input type="radio"
                                                   name="saved_address"
                                                   value="{{ $address->id }}"
                                                   {{ $address->is_default ? 'checked' : '' }}
                                                   class="sr-only peer address-radio"
                                                   data-full-name="{{ $address->full_name }}"
                                                   data-phone="{{ $address->phone }}"
                                                   data-address="{{ $address->address_line_1 }}"
                                                   data-city="{{ $address->city }}"
                                                   data-state="{{ $address->state }}"
                                                   data-pincode="{{ $address->pincode }}">
                                            <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-black peer-checked:bg-gray-50 transition-all">
                                                <div class="flex justify-between items-start">
                                                    <div>
                                                        <div class="flex items-center space-x-2 mb-2">
                                                            <h3 class="font-semibold text-gray-900">{{ $address->full_name }}</h3>
                                                            @if($address->label)
                                                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">{{ $address->label }}</span>
                                                            @endif
                                                            @if($address->is_default)
                                                                <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded">Default</span>
                                                            @endif
                                                        </div>
                                                        <p class="text-sm text-gray-600">{{ $address->phone }}</p>
                                                        <p class="text-sm text-gray-600">
                                                            {{ $address->address_line_1 }}
                                                            @if($address->address_line_2), {{ $address->address_line_2 }}@endif
                                                        </p>
                                                        <p class="text-sm text-gray-600">{{ $address->city }}, {{ $address->state }} {{ $address->pincode }}</p>
                                                    </div>
                                                    <div class="text-right">
                                                        <div class="w-5 h-5 border-2 border-gray-300 rounded-full peer-checked:border-black peer-checked:bg-black flex items-center justify-center">
                                                            <div class="w-2 h-2 bg-white rounded-full opacity-0 peer-checked:opacity-100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach

                                    <!-- Add New Address Option -->
                                    <label class="relative block">
                                        <input type="radio"
                                               name="saved_address"
                                               value="new"
                                               class="sr-only peer address-radio">
                                        <div class="p-4 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer peer-checked:border-black peer-checked:bg-gray-50 transition-all">
                                            <div class="flex items-center justify-center space-x-2 text-gray-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                <span class="font-medium">Add New Address</span>
                                            </div>
                                        </div>
                                    </label>
                                </div>

                                <div class="flex justify-between items-center">
                                    <a href="{{ route('user.addresses.index') }}"
                                       class="text-sm text-blue-600 hover:text-blue-800">
                                        Manage Addresses
                                    </a>
                                </div>
                            </div>

                            <!-- Address Form (hidden by default if addresses exist) -->
                            <div id="address-form" class="{{ $userAddresses->count() > 0 ? 'hidden' : '' }}">
                                <h2 class="text-lg md:text-xl font-semibold text-gray-900 mb-4 md:mb-6">Shipping Information</h2>
                        @else
                            <h2 class="text-lg md:text-xl font-semibold text-gray-900 mb-4 md:mb-6">Shipping Information</h2>
                        @endif
                    @else
                        <h2 class="text-lg md:text-xl font-semibold text-gray-900 mb-4 md:mb-6">Shipping Information</h2>
                    @endauth
                    
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkout-form">
                        @csrf

                        <!-- Error Display -->
                        @if($errors->any())
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                                {{ session('error') }}
                            </div>
                        @endif

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

                        <!-- Hidden Coupon Fields -->
                        <input type="hidden" name="coupon_code" id="form-coupon-code" value="">
                        <input type="hidden" name="coupon_discount" id="form-coupon-discount" value="0">

                    @auth
                        @if($userAddresses->count() > 0)
                            </div> <!-- Close address-form div -->
                        @endif
                    @endauth

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
                                    @if($item->product->main_image)
                                        <img class="h-16 w-16 rounded-lg object-cover"
                                             src="{{ $item->product->main_image }}"
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
                                    @if($item->productVariant)
                                        <p class="text-xs text-blue-600 font-medium">Size: {{ $item->productVariant->option1_value }}</p>
                                    @endif
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

                    <!-- Promo Code Section -->
                    <div class="border-t border-gray-200 pt-4 mb-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-gray-900">🎫 Have a Promo Code?</h3>
                            <span class="text-sm text-green-600 font-medium">Save money with coupons!</span>
                        </div>
                        <div class="bg-gray-50 rounded-lg p-4" id="coupon-input-section">
                            <div class="flex flex-col sm:flex-row gap-3">
                                <input type="text"
                                       id="coupon-code"
                                       placeholder="Enter your promo code"
                                       class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black text-sm font-medium"
                                       style="text-transform: uppercase;">
                                <button type="button"
                                        id="apply-coupon-btn"
                                        class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-500 font-medium text-sm transition-all duration-200 whitespace-nowrap">
                                    Apply Code
                                </button>
                            </div>

                            <!-- Available Coupons Hint -->
                            <div class="mt-2 text-xs text-gray-500">
                                💡 Try: <span class="font-mono bg-gray-100 px-2 py-1 rounded">NEW10</span> for new customers
                            </div>

                            <!-- Coupon Status Messages -->
                            <div id="coupon-message" class="mt-3 hidden">
                                <div id="coupon-success" class="hidden bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span id="coupon-success-text"></span>
                                    </div>
                                </div>
                                <div id="coupon-error" class="hidden bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span id="coupon-error-text"></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Applied Coupon Display -->
                            <div id="applied-coupon" class="hidden mt-3 bg-green-50 border border-green-200 rounded-lg p-3">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <div>
                                            <span class="text-green-800 font-medium" id="applied-coupon-code"></span>
                                            <p class="text-green-700 text-sm" id="applied-coupon-description"></p>
                                        </div>
                                    </div>
                                    <button type="button"
                                            id="remove-coupon-btn"
                                            class="text-green-600 hover:text-green-800 font-medium text-sm">
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Totals -->
                    <div class="border-t border-gray-200 pt-4">
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal (excl. tax)</span>
                                <span class="text-gray-900 font-medium">₹{{ number_format($subtotal, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax (GST included)</span>
                                <span class="text-gray-900">₹{{ number_format($tax, 2) }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Shipping</span>
                                <span class="text-gray-900">
                                    @if($shipping > 0)
                                        ₹{{ number_format($shipping, 2) }}
                                    @else
                                        <span class="text-green-600 font-medium">FREE</span>
                                    @endif
                                </span>
                            </div>
                            <!-- Discount Line (Hidden by default) -->
                            <div id="discount-line" class="hidden flex justify-between">
                                <span class="text-green-600 font-medium">Discount (<span id="discount-code"></span>)</span>
                                <span class="text-green-600 font-medium">-₹<span id="discount-amount">0.00</span></span>
                            </div>
                            <div class="border-t border-gray-200 pt-3">
                                <div class="flex justify-between">
                                    <span class="text-lg font-medium text-gray-900">Total</span>
                                    <span class="text-lg font-medium text-gray-900" id="final-total">₹{{ number_format($total, 2) }}</span>
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
                            <!-- Online payment option temporarily removed -->
                        </div>
                    </div>

                    <!-- Place Order Button with Truck Animation -->
                    <button type="button" id="place-order-btn" class="truck-button w-full mt-6">
                        <span class="default">Place Order</span>
                        <span class="success">
                            Order Placed
                            <svg viewbox="0 0 12 10">
                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                            </svg>
                        </span>
                        <div class="truck">
                            <div class="wheel"></div>
                            <div class="back"></div>
                            <div class="front"></div>
                            <div class="box"></div>
                        </div>
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

    <!-- Loading Popup Modal -->
    <div id="checkout-loading-popup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-2xl p-8 max-w-sm mx-4 text-center animate-popup-in">
            <!-- Animated Checkmark Icon -->
            <div class="mb-6 flex justify-center">
                <div class="relative w-20 h-20">
                    <!-- Outer rotating circle -->
                    <div class="absolute inset-0 rounded-full border-4 border-gray-100 animate-spin-slow"></div>

                    <!-- Inner pulsing circle -->
                    <div class="absolute inset-2 rounded-full border-2 border-black animate-pulse"></div>

                    <!-- Checkmark icon -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <svg class="w-10 h-10 text-black animate-bounce-slow" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Animated Loading Text -->
            <h3 class="text-xl font-semibold text-gray-900 mb-2 animate-fade-in" style="animation-delay: 0.2s;">Processing Your Order</h3>
            <p class="text-gray-600 text-sm animate-fade-in" style="animation-delay: 0.4s;">Please wait while we confirm your order...</p>

            <!-- Animated Dots -->
            <div class="mt-4 flex justify-center space-x-1">
                <span class="w-2 h-2 bg-black rounded-full animate-bounce" style="animation-delay: 0s;"></span>
                <span class="w-2 h-2 bg-black rounded-full animate-bounce" style="animation-delay: 0.2s;"></span>
                <span class="w-2 h-2 bg-black rounded-full animate-bounce" style="animation-delay: 0.4s;"></span>
            </div>

            <!-- Animated Progress Bar -->
            <div class="mt-6 w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                <div class="bg-black h-full animate-progress-bar" style="width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Truck Button Animation Styles -->
    <style>
        /* Loading Popup Animations */
        @keyframes popup-in {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes bounce-slow {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
        }

        @keyframes progress-bar {
            0% {
                opacity: 0.3;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0.3;
            }
        }

        .animate-popup-in {
            animation: popup-in 0.4s ease-out;
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out forwards;
            opacity: 0;
        }

        .animate-spin-slow {
            animation: spin-slow 3s linear infinite;
        }

        .animate-bounce-slow {
            animation: bounce-slow 1.5s ease-in-out infinite;
        }

        .animate-progress-bar {
            animation: progress-bar 1.5s ease-in-out infinite;
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
        }

        .truck-button {
            --color: #fff;
            --background: #000000;
            --tick: #16BF78;
            --base: #0D0F18;
            --wheel: #2B3044;
            --wheel-inner: #646B8C;
            --wheel-dot: #fff;
            --back: #6D58FF;
            --back-inner: #362A89;
            --back-inner-shadow: #2D246B;
            --front: #A6ACCD;
            --front-shadow: #535A79;
            --front-light: #FFF8B1;
            --window: #2B3044;
            --window-shadow: #404660;
            --street: #646B8C;
            --street-fill: #404660;
            --box: #DCB97A;
            --box-shadow: #B89B66;
            padding: 12px 0;
            cursor: pointer;
            text-align: center;
            position: relative;
            border: none;
            outline: none;
            color: var(--color);
            background: var(--background);
            border-radius: var(--br, 15px);
            -webkit-appearance: none;
            -webkit-tap-highlight-color: transparent;
            transform-style: preserve-3d;
            transform: rotateX(var(--rx, 0deg)) translateZ(0);
            transition: transform 0.5s, border-radius 0.3s linear var(--br-d, 0s);
        }
        .truck-button:before, .truck-button:after {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 6px;
            display: block;
            background: var(--b, var(--street));
            transform-origin: 0 100%;
            transform: rotateX(90deg) scaleX(var(--sy, 1));
        }
        .truck-button:after {
            --sy: var(--progress, 0);
            --b: var(--street-fill);
        }
        .truck-button .default,
        .truck-button .success {
            display: block;
            font-weight: 700;
            font-size: 16px;
            line-height: 24px;
            opacity: var(--o, 1);
            transition: opacity 0.3s;
        }
        .truck-button .success {
            --o: 0;
            position: absolute;
            top: 12px;
            left: 0;
            right: 0;
        }
        .truck-button .success svg {
            width: 12px;
            height: 10px;
            display: inline-block;
            vertical-align: top;
            fill: none;
            margin: 7px 0 0 12px;
            stroke: var(--tick);
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
            stroke-dasharray: 16px;
            stroke-dashoffset: var(--offset, 16px);
            transition: stroke-dashoffset 0.4s ease 0.45s;
        }
        .truck-button .truck {
            position: absolute;
            width: 72px;
            height: 28px;
            left: 50%;
            transform: translateX(-50%) rotateX(90deg) translate3d(var(--truck-x, 4px), calc(var(--truck-y-n, -26) * 1px), 12px);
        }
        .truck-button .truck:before, .truck-button .truck:after {
            content: "";
            position: absolute;
            bottom: -6px;
            left: var(--l, 18px);
            width: 10px;
            height: 10px;
            border-radius: 50%;
            z-index: 2;
            box-shadow: inset 0 0 0 2px var(--wheel), inset 0 0 0 4px var(--wheel-inner);
            background: var(--wheel-dot);
            transform: translateY(calc(var(--truck-y) * -1px)) translateZ(0);
        }
        .truck-button .truck:after {
            --l: 54px;
        }
        .truck-button .truck .wheel,
        .truck-button .truck .wheel:before {
            position: absolute;
            bottom: var(--b, -6px);
            left: var(--l, 6px);
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--wheel);
            transform: translateZ(0);
        }
        .truck-button .truck .wheel {
            transform: translateY(calc(var(--truck-y) * -1px)) translateZ(0);
        }
        .truck-button .truck .wheel:before {
            --l: 35px;
            --b: 0;
            content: "";
        }
        .truck-button .truck .front,
        .truck-button .truck .back,
        .truck-button .truck .box {
            position: absolute;
        }
        .truck-button .truck .back {
            left: 0;
            bottom: 0;
            z-index: 1;
            width: 47px;
            height: 28px;
            border-radius: 1px 1px 0 0;
            background: linear-gradient(68deg, var(--back-inner) 0%, var(--back-inner) 22%, var(--back-inner-shadow) 22.1%, var(--back-inner-shadow) 100%);
        }
        .truck-button .truck .back:before, .truck-button .truck .back:after {
            content: "";
            position: absolute;
        }
        .truck-button .truck .back:before {
            left: 11px;
            top: 0;
            right: 0;
            bottom: 0;
            z-index: 2;
            border-radius: 0 1px 0 0;
            background: var(--back);
        }
        .truck-button .truck .back:after {
            border-radius: 1px;
            width: 73px;
            height: 2px;
            left: -1px;
            bottom: -2px;
            background: var(--base);
        }
        .truck-button .truck .front {
            left: 47px;
            bottom: -1px;
            height: 22px;
            width: 24px;
            clip-path: polygon(55% 0, 72% 44%, 100% 58%, 100% 100%, 0 100%, 0 0);
            background: linear-gradient(84deg, var(--front-shadow) 0%, var(--front-shadow) 10%, var(--front) 12%, var(--front) 100%);
        }
        .truck-button .truck .front:before, .truck-button .truck .front:after {
            content: "";
            position: absolute;
        }
        .truck-button .truck .front:before {
            width: 7px;
            height: 8px;
            background: #fff;
            left: 7px;
            top: 2px;
            clip-path: polygon(0 0, 60% 0%, 100% 100%, 0% 100%);
            background: linear-gradient(59deg, var(--window) 0%, var(--window) 57%, var(--window-shadow) 55%, var(--window-shadow) 100%);
        }
        .truck-button .truck .front:after {
            width: 3px;
            height: 2px;
            right: 0;
            bottom: 3px;
            background: var(--front-light);
        }
        .truck-button .truck .box {
            width: 13px;
            height: 13px;
            right: 56px;
            bottom: 0;
            z-index: 1;
            border-radius: 1px;
            overflow: hidden;
            transform: translate(calc(var(--box-x, -24) * 1px), calc(var(--box-y, -6) * 1px)) scale(var(--box-s, 0.5));
            opacity: var(--box-o, 0);
            background: linear-gradient(68deg, var(--box) 0%, var(--box) 50%, var(--box-shadow) 50.2%, var(--box-shadow) 100%);
            background-size: 250% 100%;
            background-position-x: calc(var(--bx, 0) * 1%);
        }
        .truck-button .truck .box:before, .truck-button .truck .box:after {
            content: "";
            position: absolute;
        }
        .truck-button .truck .box:before {
            content: "";
            background: rgba(255, 255, 255, 0.2);
            left: 0;
            right: 0;
            top: 6px;
            height: 1px;
        }
        .truck-button .truck .box:after {
            width: 6px;
            left: 100%;
            top: 0;
            bottom: 0;
            background: var(--back);
            transform: translateX(calc(var(--hx, 0) * 1px));
        }
        .truck-button.animation {
            --rx: -90deg;
            --br: 0;
        }
        .truck-button.animation .default {
            --o: 0;
        }
        .truck-button.animation.done {
            --rx: 0deg;
            --br: 15px;
            --br-d: .2s;
        }
        .truck-button.animation.done .success {
            --o: 1;
            --offset: 0;
        }
    </style>

    <!-- GSAP Library -->
    <script src='https://cdn.jsdelivr.net/npm/gsap@3.0.1/dist/gsap.min.js'></script>

    <!-- JavaScript for Address Selection -->
    <script>
        // Handle address selection
        document.addEventListener('DOMContentLoaded', function() {
            const addressRadios = document.querySelectorAll('.address-radio');
            const addressForm = document.getElementById('address-form');

            addressRadios.forEach(radio => {
                radio.addEventListener('change', function() {
                    if (this.value === 'new') {
                        // Show address form for new address
                        if (addressForm) {
                            addressForm.classList.remove('hidden');
                            // Clear form fields
                            document.getElementById('full_name').value = '{{ Auth::user()->name ?? '' }}';
                            document.getElementById('email').value = '{{ Auth::user()->email ?? '' }}';
                            document.getElementById('phone').value = '{{ Auth::user()->phone ?? '' }}';
                            document.getElementById('address').value = '';
                            document.getElementById('city').value = '';
                            document.getElementById('state').value = '';
                            document.getElementById('pincode').value = '';
                        }
                    } else {
                        // Hide address form and populate with selected address
                        if (addressForm) {
                            addressForm.classList.add('hidden');
                        }

                        // Populate form fields with selected address data
                        document.getElementById('full_name').value = this.dataset.fullName;
                        document.getElementById('phone').value = this.dataset.phone;
                        document.getElementById('address').value = this.dataset.address;
                        document.getElementById('city').value = this.dataset.city;
                        document.getElementById('state').value = this.dataset.state;
                        document.getElementById('pincode').value = this.dataset.pincode;
                    }
                });
            });

            // Auto-populate with default address if available
            const defaultAddressRadio = document.querySelector('.address-radio:checked');
            if (defaultAddressRadio && defaultAddressRadio.value !== 'new') {
                defaultAddressRadio.dispatchEvent(new Event('change'));
            }
        });
    </script>

    <!-- JavaScript for Truck Button Animation -->
    <script>
        // Track InitiateCheckout event with Meta Pixel
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(function() {
                if (typeof trackMetaPixelInitiateCheckout !== 'undefined') {
                    const items = {!! json_encode($cartItems->map(function($item) {
                        return [
                            'id' => $item->product_id,
                            'product_id' => $item->product_id,
                            'quantity' => $item->quantity,
                            'price' => $item->product->sale_price ?? $item->product->price
                        ];
                    })->toArray()) !!};

                    trackMetaPixelInitiateCheckout(
                        {{ $total }},
                        {{ $cartItems->count() }},
                        items
                    );

                    console.log('✅ InitiateCheckout event tracked');
                }
            }, 300);
        });

        document.getElementById('place-order-btn').addEventListener('click', function(e) {
            e.preventDefault();

            const button = this;
            let box = button.querySelector('.box'),
                truck = button.querySelector('.truck');

            if(!button.classList.contains('done')) {

                if(!button.classList.contains('animation')) {

                    button.classList.add('animation');
                    button.disabled = true;

                    gsap.to(button, {
                        '--box-s': 1,
                        '--box-o': 1,
                        duration: .3,
                        delay: .5
                    });

                    gsap.to(box, {
                        x: 0,
                        duration: .4,
                        delay: .7
                    });

                    gsap.to(button, {
                        '--hx': -5,
                        '--bx': 50,
                        duration: .18,
                        delay: .92
                    });

                    gsap.to(box, {
                        y: 0,
                        duration: .1,
                        delay: 1.15
                    });

                    gsap.set(button, {
                        '--truck-y': 0,
                        '--truck-y-n': -26
                    });

                    gsap.to(button, {
                        '--truck-y': 1,
                        '--truck-y-n': -25,
                        duration: .2,
                        delay: 1.25,
                        onComplete() {
                            gsap.timeline({
                                onComplete() {
                                    button.classList.add('done');

                                    // Show loading popup
                                    const loadingPopup = document.getElementById('checkout-loading-popup');
                                    loadingPopup.classList.remove('hidden');

                                    // Submit the form after showing loading popup
                                    setTimeout(() => {
                                        document.getElementById('checkout-form').submit();
                                    }, 500);
                                }
                            }).to(truck, {
                                x: 0,
                                duration: .4
                            }).to(truck, {
                                x: 40,
                                duration: 1
                            }).to(truck, {
                                x: 20,
                                duration: .6
                            }).to(truck, {
                                x: 96,
                                duration: .4
                            });
                            gsap.to(button, {
                                '--progress': 1,
                                duration: 2.4,
                                ease: "power2.in"
                            });
                        }
                    });

                }

            }
        });

        // Coupon functionality
        let appliedCoupon = null;
        let originalTotal = {{ $total }};

        document.getElementById('apply-coupon-btn').addEventListener('click', function() {
            const couponCode = document.getElementById('coupon-code').value.trim().toUpperCase();

            if (!couponCode) {
                showCouponError('Please enter a coupon code');
                return;
            }

            // Show loading state
            this.disabled = true;
            this.textContent = 'Applying...';

            // Make AJAX request to validate coupon
            fetch('/api/validate-coupon', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    code: couponCode,
                    order_amount: originalTotal
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Invalid JSON response:', text);
                        throw new Error('Server returned invalid response');
                    }
                });
            })
            .then(data => {
                if (data.valid) {
                    applyCoupon(data.coupon, data.message);
                } else {
                    showCouponError(data.message);
                }
            })
            .catch(error => {
                console.error('Coupon validation error:', error);
                showCouponError('Failed to validate coupon. Please try again.');
            })
            .finally(() => {
                // Reset button state
                this.disabled = false;
                this.textContent = 'Apply Code';
            });
        });

        document.getElementById('remove-coupon-btn').addEventListener('click', function() {
            removeCoupon();
        });

        // Allow Enter key to apply coupon
        document.getElementById('coupon-code').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                document.getElementById('apply-coupon-btn').click();
            }
        });

        function applyCoupon(coupon, message) {
            appliedCoupon = coupon;

            // Hide coupon input section
            const couponInputSection = document.getElementById('coupon-input-section');
            if (couponInputSection) {
                couponInputSection.style.display = 'none';
            }

            // Show applied coupon
            const appliedCouponEl = document.getElementById('applied-coupon');
            const appliedCouponCodeEl = document.getElementById('applied-coupon-code');
            const appliedCouponDescEl = document.getElementById('applied-coupon-description');

            if (appliedCouponEl) appliedCouponEl.classList.remove('hidden');
            if (appliedCouponCodeEl) appliedCouponCodeEl.textContent = coupon.code;
            if (appliedCouponDescEl) appliedCouponDescEl.textContent = coupon.name;

            // Show discount in totals
            document.getElementById('discount-line').classList.remove('hidden');
            document.getElementById('discount-code').textContent = coupon.code;
            document.getElementById('discount-amount').textContent = coupon.discount_amount.toFixed(2);

            // Update final total
            const newTotal = originalTotal - coupon.discount_amount;
            document.getElementById('final-total').textContent = '₹' + newTotal.toFixed(2);

            // Update hidden form fields
            document.getElementById('form-coupon-code').value = coupon.code;
            document.getElementById('form-coupon-discount').value = coupon.discount_amount;

            // Show success message
            showCouponSuccess(message);

            // Clear input
            document.getElementById('coupon-code').value = '';
        }

        function removeCoupon() {
            appliedCoupon = null;

            // Show coupon input section
            document.getElementById('coupon-input-section').style.display = 'block';

            // Hide applied coupon
            document.getElementById('applied-coupon').classList.add('hidden');

            // Hide discount in totals
            document.getElementById('discount-line').classList.add('hidden');

            // Reset final total
            document.getElementById('final-total').textContent = '₹' + originalTotal.toFixed(2);

            // Clear hidden form fields
            document.getElementById('form-coupon-code').value = '';
            document.getElementById('form-coupon-discount').value = '0';

            // Hide messages
            hideCouponMessages();
        }

        function showCouponSuccess(message) {
            hideCouponMessages();
            document.getElementById('coupon-message').classList.remove('hidden');
            document.getElementById('coupon-success').classList.remove('hidden');
            document.getElementById('coupon-success-text').textContent = message;
        }

        function showCouponError(message) {
            hideCouponMessages();
            document.getElementById('coupon-message').classList.remove('hidden');
            document.getElementById('coupon-error').classList.remove('hidden');
            document.getElementById('coupon-error-text').textContent = message;
        }

        function hideCouponMessages() {
            document.getElementById('coupon-message').classList.add('hidden');
            document.getElementById('coupon-success').classList.add('hidden');
            document.getElementById('coupon-error').classList.add('hidden');
        }
    </script>
</x-layouts.main>
