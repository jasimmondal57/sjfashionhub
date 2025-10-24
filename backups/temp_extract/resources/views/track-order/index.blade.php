<x-layouts.main>
    <div class="min-h-screen bg-gray-50 py-12">
        <div class="max-w-md mx-auto">
            <div class="bg-white rounded-lg shadow-sm p-8">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="mx-auto w-16 h-16 bg-black rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">Track Your Order</h1>
                    <p class="text-gray-600">Enter your order details to track your package</p>
                </div>

                <!-- Error Messages -->
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

                <!-- Track Order Form -->
                <form action="{{ route('track-order.track') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <div>
                        <label for="order_number" class="block text-sm font-medium text-gray-700 mb-2">
                            Order Number *
                        </label>
                        <input type="text" 
                               id="order_number" 
                               name="order_number" 
                               value="{{ old('order_number') }}"
                               placeholder="e.g., ORD-2025-123456"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-black">
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address *
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="Enter your email address"
                               required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-black">
                    </div>

                    <button type="submit" 
                            class="w-full bg-black text-white py-3 px-4 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-black focus:ring-offset-2 font-medium">
                        Track Order
                    </button>
                </form>

                <!-- Alternative Options -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">Already have an account?</p>
                        @auth
                            <a href="{{ route('user.orders') }}" 
                               class="inline-flex items-center text-black hover:text-gray-700 font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                View My Orders
                            </a>
                        @else
                            <a href="{{ route('login') }}" 
                               class="inline-flex items-center text-black hover:text-gray-700 font-medium">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Login to View Orders
                            </a>
                        @endauth
                    </div>
                </div>

                <!-- Help Section -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="text-sm font-medium text-gray-900 mb-2">Need Help?</h3>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Order number can be found in your order confirmation email</li>
                        <li>• Use the email address you used during checkout</li>
                        <li>• Contact support if you can't find your order</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
