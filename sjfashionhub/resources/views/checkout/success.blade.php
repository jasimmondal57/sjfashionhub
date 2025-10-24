<x-layouts.main>
    <!-- Facebook Pixel Purchase Event -->
    @if($order)
        <x-tracking.facebook-pixel-events event="Purchase" :order="$order" />
    @endif

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-sm p-8 text-center">
                <!-- Success Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 mb-6">
                    <svg class="h-8 w-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>

                <!-- Success Message -->
                <h1 class="text-3xl font-bold text-gray-900 mb-4">Order Placed Successfully!</h1>
                <p class="text-lg text-gray-600 mb-8">
                    Thank you for your order. We'll send you a confirmation email shortly.
                </p>

                <!-- Order Details -->
                <div class="bg-gray-50 rounded-lg p-6 mb-8">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">What's Next?</h2>
                    <div class="space-y-3 text-left">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span class="text-gray-700">Order confirmation email sent</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-gray-700">Order processing (1-2 business days)</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <span class="text-gray-700">Shipping (3-5 business days)</span>
                        </div>
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-purple-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m0 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"></path>
                            </svg>
                            <span class="text-gray-700">Delivery to your doorstep</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}" 
                       class="bg-indigo-600 text-white px-6 py-3 rounded-md hover:bg-indigo-700 transition-colors font-medium">
                        Continue Shopping
                    </a>
                    @auth
                        <a href="{{ route('user.orders') }}" 
                           class="bg-gray-200 text-gray-800 px-6 py-3 rounded-md hover:bg-gray-300 transition-colors font-medium">
                            View My Orders
                        </a>
                    @endauth
                </div>

                <!-- Support Information -->
                <div class="mt-8 pt-8 border-t border-gray-200">
                    @php
                        $headerSettings = \App\Models\HeaderSetting::getActiveSettings();
                        $contactInfo = is_array($headerSettings->contact_info) ? $headerSettings->contact_info : [];
                        $supportEmail = $contactInfo['email'] ?? config('mail.from.address', 'support@sjfashionhub.com');
                        $supportPhone = $contactInfo['phone'] ?? null;
                    @endphp
                    <p class="text-sm text-gray-600">
                        Need help? Contact our support team at
                        <a href="mailto:{{ $supportEmail }}" class="text-indigo-600 hover:text-indigo-500">
                            {{ $supportEmail }}
                        </a>
                        @if($supportPhone)
                            or call
                            <a href="tel:{{ str_replace(' ', '', $supportPhone) }}" class="text-indigo-600 hover:text-indigo-500">
                                {{ $supportPhone }}
                            </a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
