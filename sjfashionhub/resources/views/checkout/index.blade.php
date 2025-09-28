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

    <!-- Truck Button Animation Styles -->
    <style>
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

    <!-- JavaScript for Truck Button Animation -->
    <script>
        document.getElementById('place-order-btn').addEventListener('click', function(e) {
            e.preventDefault();

            const button = this;
            let box = button.querySelector('.box'),
                truck = button.querySelector('.truck');

            if(!button.classList.contains('done')) {

                if(!button.classList.contains('animation')) {

                    button.classList.add('animation');

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
                                    // Submit the form after animation completes
                                    setTimeout(() => {
                                        document.getElementById('checkout-form').submit();
                                    }, 1000);
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
    </script>
</x-layouts.main>
