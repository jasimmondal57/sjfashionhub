<x-layouts.admin>
    <!-- Include jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header with Live Preview -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg shadow-lg p-6 mb-6 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold flex items-center">
                            <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                            </svg>
                            Shipping Settings
                        </h1>
                        <p class="text-blue-100 mt-2">Configure how shipping costs are calculated for your customers</p>
                    </div>
                    <div class="text-right">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg px-4 py-2">
                            <p class="text-sm text-blue-100">Current Status</p>
                            <p class="text-2xl font-bold">
                                @if($settings->is_enabled)
                                    <span class="text-green-300">✓ Active</span>
                                @else
                                    <span class="text-red-300">✗ Disabled</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-r-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-green-800 font-medium">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        <p class="text-red-800 font-medium">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.shipping-settings.update') }}" method="POST" id="shipping-form">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Main Settings (Left Column - 2/3) -->
                    <div class="lg:col-span-2 space-y-6">
                        
                        <!-- Quick Setup Card -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
                            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200">
                                <h2 class="text-xl font-bold text-gray-900 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Quick Setup
                                </h2>
                                <p class="text-sm text-gray-600 mt-1">Choose a shipping method to get started</p>
                            </div>
                            <div class="p-6">
                                <!-- Enable/Disable Shipping -->
                                <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="is_enabled" id="is_enabled" value="1"
                                               {{ $settings->is_enabled ? 'checked' : '' }}
                                               class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <span class="ml-3">
                                            <span class="text-lg font-semibold text-gray-900">Enable Shipping</span>
                                            <span class="block text-sm text-gray-600 mt-1">Turn on to charge shipping fees to customers</span>
                                        </span>
                                    </label>
                                </div>

                                <!-- Shipping Method Selection -->
                                <div class="space-y-3">
                                    <label class="block text-sm font-medium text-gray-700 mb-3">Select Shipping Method</label>
                                    
                                    <!-- Flat Rate Option -->
                                    <label class="relative flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $settings->shipping_method === 'flat_rate' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                        <input type="radio" name="shipping_method" value="flat_rate" 
                                               {{ $settings->shipping_method === 'flat_rate' ? 'checked' : '' }}
                                               class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500">
                                        <div class="ml-3 flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-semibold text-gray-900">📦 Flat Rate</span>
                                                <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full">Recommended</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">Charge the same shipping fee for all orders</p>
                                            <p class="text-xs text-gray-500 mt-1">✓ Simple • ✓ Easy to understand • ✓ Best for beginners</p>
                                        </div>
                                    </label>

                                    <!-- Weight Based Option -->
                                    <label class="relative flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $settings->shipping_method === 'weight_based' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                        <input type="radio" name="shipping_method" value="weight_based"
                                               {{ $settings->shipping_method === 'weight_based' ? 'checked' : '' }}
                                               class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500">
                                        <div class="ml-3 flex-1">
                                            <span class="font-semibold text-gray-900">⚖️ Weight Based</span>
                                            <p class="text-sm text-gray-600 mt-1">Calculate shipping based on total order weight</p>
                                            <p class="text-xs text-gray-500 mt-1">✓ Fair pricing • ✓ Accurate costs • ✓ For variable products</p>
                                        </div>
                                    </label>

                                    <!-- Location Based Option -->
                                    <label class="relative flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $settings->shipping_method === 'location_based' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                        <input type="radio" name="shipping_method" value="location_based"
                                               {{ $settings->shipping_method === 'location_based' ? 'checked' : '' }}
                                               class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500">
                                        <div class="ml-3 flex-1">
                                            <span class="font-semibold text-gray-900">📍 Location Based</span>
                                            <p class="text-sm text-gray-600 mt-1">Different rates for different cities/zones</p>
                                            <p class="text-xs text-gray-500 mt-1">✓ Zone pricing • ✓ Metro/Non-metro • ✓ Regional rates</p>
                                        </div>
                                    </label>

                                    <!-- Free Shipping Option -->
                                    <label class="relative flex items-start p-4 border-2 rounded-lg cursor-pointer hover:bg-gray-50 transition-colors {{ $settings->shipping_method === 'free' ? 'border-blue-500 bg-blue-50' : 'border-gray-200' }}">
                                        <input type="radio" name="shipping_method" value="free"
                                               {{ $settings->shipping_method === 'free' ? 'checked' : '' }}
                                               class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500">
                                        <div class="ml-3 flex-1">
                                            <div class="flex items-center justify-between">
                                                <span class="font-semibold text-gray-900">🎁 Free Shipping</span>
                                                <span class="text-xs bg-purple-100 text-purple-800 px-2 py-1 rounded-full">Popular</span>
                                            </div>
                                            <p class="text-sm text-gray-600 mt-1">No shipping charges for any order</p>
                                            <p class="text-xs text-gray-500 mt-1">✓ Increase sales • ✓ Customer favorite • ✓ Competitive edge</p>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Flat Rate Settings -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200" id="flat_rate_section">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900">Flat Rate Configuration</h3>
                                <p class="text-sm text-gray-600 mt-1">Set a fixed shipping charge for all orders</p>
                            </div>
                            <div class="p-6">
                                <div class="max-w-md">
                                    <label for="flat_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                        Shipping Charge (₹)
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">₹</span>
                                        <input type="number" name="flat_rate" id="flat_rate" 
                                               value="{{ old('flat_rate', $settings->flat_rate) }}" 
                                               step="0.01" min="0"
                                               class="pl-8 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-lg font-semibold">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">💡 Tip: ₹99 is a popular flat rate in India</p>
                                </div>
                            </div>
                        </div>

                        <!-- Location-Based Shipping -->
                        @include('admin.shipping-settings.partials.location-based')

                        <!-- Free Shipping Threshold -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Free Shipping Threshold
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Offer free shipping when cart total reaches a certain amount</p>
                            </div>
                            <div class="p-6">
                                <div class="mb-4 p-4 bg-green-50 rounded-lg border border-green-200">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="free_shipping_enabled" id="free_shipping_enabled" value="1"
                                               {{ $settings->free_shipping_enabled ? 'checked' : '' }}
                                               class="w-5 h-5 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                        <span class="ml-3">
                                            <span class="text-base font-semibold text-gray-900">Enable Free Shipping Threshold</span>
                                            <span class="block text-sm text-gray-600 mt-1">Encourage customers to buy more!</span>
                                        </span>
                                    </label>
                                </div>

                                <div class="max-w-md">
                                    <label for="free_shipping_threshold" class="block text-sm font-medium text-gray-700 mb-2">
                                        Minimum Order Amount for Free Shipping (₹)
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">₹</span>
                                        <input type="number" name="free_shipping_threshold" id="free_shipping_threshold"
                                               value="{{ old('free_shipping_threshold', $settings->free_shipping_threshold) }}"
                                               step="0.01" min="0"
                                               class="pl-8 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-lg font-semibold">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">💡 Example: Set ₹500 to offer free shipping on orders above ₹500</p>
                                    <div class="mt-3 p-3 bg-blue-50 rounded-lg">
                                        <p class="text-sm text-blue-800">
                                            <strong>How it works:</strong> If cart total is ₹<span id="threshold_display">{{ $settings->free_shipping_threshold }}</span> or more, shipping is FREE!
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Delivery Time Settings -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Delivery Time
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Set expected delivery times shown to customers</p>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="standard_shipping_days" class="block text-sm font-medium text-gray-700 mb-2">
                                            Standard Delivery (Days)
                                        </label>
                                        <input type="number" name="standard_shipping_days" id="standard_shipping_days"
                                               value="{{ old('standard_shipping_days', $settings->standard_shipping_days) }}"
                                               min="1" max="30"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <p class="text-xs text-gray-500 mt-1">Typical: 5-7 days</p>
                                    </div>
                                    <div>
                                        <label for="express_shipping_days" class="block text-sm font-medium text-gray-700 mb-2">
                                            Express Delivery (Days)
                                        </label>
                                        <input type="number" name="express_shipping_days" id="express_shipping_days"
                                               value="{{ old('express_shipping_days', $settings->express_shipping_days) }}"
                                               min="1" max="30"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <p class="text-xs text-gray-500 mt-1">Typical: 1-2 days</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Express Shipping -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-orange-50 to-red-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Express Shipping
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Offer faster delivery for an additional charge</p>
                            </div>
                            <div class="p-6">
                                <div class="mb-4 p-4 bg-orange-50 rounded-lg border border-orange-200">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="express_shipping_enabled" id="express_shipping_enabled" value="1"
                                               {{ $settings->express_shipping_enabled ? 'checked' : '' }}
                                               class="w-5 h-5 text-orange-600 focus:ring-orange-500 border-gray-300 rounded">
                                        <span class="ml-3">
                                            <span class="text-base font-semibold text-gray-900">Enable Express Shipping Option</span>
                                            <span class="block text-sm text-gray-600 mt-1">Give customers a faster delivery choice</span>
                                        </span>
                                    </label>
                                </div>

                                <div class="max-w-md">
                                    <label for="express_shipping_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                        Express Shipping Charge (₹)
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">₹</span>
                                        <input type="number" name="express_shipping_rate" id="express_shipping_rate"
                                               value="{{ old('express_shipping_rate', $settings->express_shipping_rate) }}"
                                               step="0.01" min="0"
                                               class="pl-8 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 text-lg font-semibold">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">💡 Typically 2-3x the standard rate</p>
                                </div>
                            </div>
                        </div>

                        <!-- COD Settings -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-yellow-50 to-amber-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    Cash on Delivery (COD)
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Allow customers to pay when they receive the order</p>
                            </div>
                            <div class="p-6">
                                <div class="mb-4 p-4 bg-yellow-50 rounded-lg border border-yellow-200">
                                    <label class="flex items-center cursor-pointer">
                                        <input type="checkbox" name="cod_enabled" id="cod_enabled" value="1"
                                               {{ $settings->cod_enabled ? 'checked' : '' }}
                                               class="w-5 h-5 text-yellow-600 focus:ring-yellow-500 border-gray-300 rounded">
                                        <span class="ml-3">
                                            <span class="text-base font-semibold text-gray-900">Enable Cash on Delivery</span>
                                            <span class="block text-sm text-gray-600 mt-1">Popular in India - increases conversions</span>
                                        </span>
                                    </label>
                                </div>

                                <div class="max-w-md">
                                    <label for="cod_charges" class="block text-sm font-medium text-gray-700 mb-2">
                                        COD Handling Charges (₹)
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">₹</span>
                                        <input type="number" name="cod_charges" id="cod_charges"
                                               value="{{ old('cod_charges', $settings->cod_charges) }}"
                                               step="0.01" min="0"
                                               class="pl-8 w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 text-lg font-semibold">
                                    </div>
                                    <p class="text-xs text-gray-500 mt-2">💡 Set to 0 for free COD, or ₹30-50 to cover handling costs</p>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Fees -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900">Additional Fees</h3>
                                <p class="text-sm text-gray-600 mt-1">Optional handling and packaging charges</p>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <label for="handling_fee" class="block text-sm font-medium text-gray-700 mb-2">
                                            Handling Fee (₹)
                                        </label>
                                        <input type="number" name="handling_fee" id="handling_fee"
                                               value="{{ old('handling_fee', $settings->handling_fee) }}"
                                               step="0.01" min="0"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <p class="text-xs text-gray-500 mt-1">Usually ₹0-20</p>
                                    </div>
                                    <div>
                                        <label for="packaging_fee" class="block text-sm font-medium text-gray-700 mb-2">
                                            Packaging Fee (₹)
                                        </label>
                                        <input type="number" name="packaging_fee" id="packaging_fee"
                                               value="{{ old('packaging_fee', $settings->packaging_fee) }}"
                                               step="0.01" min="0"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <p class="text-xs text-gray-500 mt-1">Usually ₹0-15</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Weight & Tax Settings -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-900">Advanced Settings</h3>
                                <p class="text-sm text-gray-600 mt-1">Weight units and shipping tax configuration</p>
                            </div>
                            <div class="p-6">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                    <div>
                                        <label for="default_weight" class="block text-sm font-medium text-gray-700 mb-2">
                                            Default Weight
                                        </label>
                                        <input type="number" name="default_weight" id="default_weight"
                                               value="{{ old('default_weight', $settings->default_weight) }}"
                                               step="0.1" min="0.1"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                    </div>
                                    <div>
                                        <label for="weight_unit" class="block text-sm font-medium text-gray-700 mb-2">
                                            Weight Unit
                                        </label>
                                        <select name="weight_unit" id="weight_unit"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                            <option value="kg" {{ $settings->weight_unit === 'kg' ? 'selected' : '' }}>Kilograms (kg)</option>
                                            <option value="g" {{ $settings->weight_unit === 'g' ? 'selected' : '' }}>Grams (g)</option>
                                            <option value="lb" {{ $settings->weight_unit === 'lb' ? 'selected' : '' }}>Pounds (lb)</option>
                                            <option value="oz" {{ $settings->weight_unit === 'oz' ? 'selected' : '' }}>Ounces (oz)</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label for="dimension_unit" class="block text-sm font-medium text-gray-700 mb-2">
                                            Dimension Unit
                                        </label>
                                        <select name="dimension_unit" id="dimension_unit"
                                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                            <option value="cm" {{ $settings->dimension_unit === 'cm' ? 'selected' : '' }}>Centimeters (cm)</option>
                                            <option value="m" {{ $settings->dimension_unit === 'm' ? 'selected' : '' }}>Meters (m)</option>
                                            <option value="in" {{ $settings->dimension_unit === 'in' ? 'selected' : '' }}>Inches (in)</option>
                                            <option value="ft" {{ $settings->dimension_unit === 'ft' ? 'selected' : '' }}>Feet (ft)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="border-t border-gray-200 pt-6">
                                    <div class="flex items-center mb-4">
                                        <input type="checkbox" name="shipping_tax_enabled" id="shipping_tax_enabled" value="1"
                                               {{ $settings->shipping_tax_enabled ? 'checked' : '' }}
                                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                        <label for="shipping_tax_enabled" class="ml-2 block text-sm font-medium text-gray-700">
                                            Apply Tax on Shipping
                                        </label>
                                    </div>
                                    <div class="max-w-xs">
                                        <label for="shipping_tax_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                            Shipping Tax Rate (%)
                                        </label>
                                        <input type="number" name="shipping_tax_rate" id="shipping_tax_rate"
                                               value="{{ old('shipping_tax_rate', $settings->shipping_tax_rate) }}"
                                               step="0.01" min="0" max="100"
                                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                                        <p class="text-xs text-gray-500 mt-1">GST rate for shipping (usually 18%)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden fields for calculation method and international shipping -->
                        <input type="hidden" name="calculation_method" value="{{ $settings->calculation_method }}">
                        <input type="hidden" name="international_shipping_enabled" value="0">
                        <input type="hidden" name="international_shipping_rate" value="{{ $settings->international_shipping_rate }}">

                    </div>

                    <!-- Right Sidebar - Preview & Actions -->
                    <div class="lg:col-span-1 space-y-6">
                        
                        <!-- Live Preview Card -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 sticky top-6">
                            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-indigo-50 to-purple-50">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                    Customer View Preview
                                </h3>
                            </div>
                            <div class="p-6">
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <p class="text-xs text-gray-500 uppercase tracking-wide mb-3">Checkout Page Preview</p>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Subtotal:</span>
                                            <span class="font-medium">₹1,000</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-gray-600">Shipping:</span>
                                            <span class="font-semibold text-blue-600" id="preview_shipping">₹{{ $settings->flat_rate }}</span>
                                        </div>
                                        <div class="border-t border-gray-300 pt-2 mt-2">
                                            <div class="flex justify-between">
                                                <span class="font-semibold text-gray-900">Total:</span>
                                                <span class="font-bold text-lg" id="preview_total">₹{{ 1000 + $settings->flat_rate }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mt-3 p-2 bg-green-50 rounded text-xs text-green-700" id="free_shipping_message" style="display: {{ $settings->free_shipping_enabled && 1000 >= $settings->free_shipping_threshold ? 'block' : 'none' }}">
                                        🎉 Free shipping applied!
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                            <div class="px-6 py-4 border-b border-gray-200">
                                <h3 class="text-lg font-semibold text-gray-900">Quick Actions</h3>
                            </div>
                            <div class="p-6 space-y-3">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg font-semibold transition-colors shadow-sm flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Save Settings
                                </button>
                                
                                <button type="button" onclick="testShipping()" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-lg font-semibold transition-colors shadow-sm flex items-center justify-center">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Test Calculator
                                </button>
                            </div>
                        </div>

                        <!-- Help Card -->
                        <div class="bg-gradient-to-br from-purple-50 to-pink-50 rounded-lg shadow-sm border border-purple-200 p-6">
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Need Help?
                            </h4>
                            <ul class="text-sm text-gray-700 space-y-2">
                                <li class="flex items-start">
                                    <span class="text-purple-600 mr-2">•</span>
                                    <span>Changes apply immediately to cart & checkout</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-purple-600 mr-2">•</span>
                                    <span>Test before saving with the calculator</span>
                                </li>
                                <li class="flex items-start">
                                    <span class="text-purple-600 mr-2">•</span>
                                    <span>Free shipping boosts average order value</span>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>

            </form>
        </div>
    </div>

    <!-- Test Calculator Modal -->
    <div id="test_modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Test Shipping Calculator</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Cart Total (₹)</label>
                        <input type="number" id="test_cart_total" value="1000" step="0.01" min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    </div>
                    <div id="test_result" class="hidden p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <p class="text-sm font-medium text-gray-900 mb-2">Result:</p>
                        <div id="test_result_content" class="text-sm text-gray-700"></div>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                <button onclick="closeTestModal()" class="px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                    Cancel
                </button>
                <button onclick="calculateTest()" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    Calculate
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Update preview in real-time - with null checks
            const flatRateEl = document.getElementById('flat_rate');
            const thresholdEl = document.getElementById('free_shipping_threshold');
            const freeShippingEl = document.getElementById('free_shipping_enabled');

            if (flatRateEl) flatRateEl.addEventListener('input', updatePreview);
            if (thresholdEl) thresholdEl.addEventListener('input', updatePreview);
            if (freeShippingEl) freeShippingEl.addEventListener('change', updatePreview);

            // Shipping method change listeners
            document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
                radio.addEventListener('change', function() {
                    updatePreview();
                    updateSectionVisibility();
                });
            });

            function updatePreview() {
                const flatRateEl = document.getElementById('flat_rate');
                const thresholdEl = document.getElementById('free_shipping_threshold');
                const freeShippingEl = document.getElementById('free_shipping_enabled');
                const methodEl = document.querySelector('input[name="shipping_method"]:checked');

                if (!flatRateEl || !thresholdEl || !freeShippingEl || !methodEl) return;

                const flatRate = parseFloat(flatRateEl.value) || 0;
                const threshold = parseFloat(thresholdEl.value) || 0;
                const freeShippingEnabled = freeShippingEl.checked;
                const method = methodEl.value;
                const cartTotal = 1000;

                let shipping = 0;
                if (method === 'free') {
                    shipping = 0;
                } else if (freeShippingEnabled && cartTotal >= threshold) {
                    shipping = 0;
                } else {
                    shipping = flatRate;
                }

                const previewShippingEl = document.getElementById('preview_shipping');
                const previewTotalEl = document.getElementById('preview_total');
                const thresholdDisplayEl = document.getElementById('threshold_display');
                const freeMsgEl = document.getElementById('free_shipping_message');

                if (previewShippingEl) {
                    previewShippingEl.textContent = shipping === 0 ? 'FREE' : '₹' + shipping.toFixed(2);
                }
                if (previewTotalEl) {
                    previewTotalEl.textContent = '₹' + (cartTotal + shipping).toFixed(2);
                }
                if (thresholdDisplayEl) {
                    thresholdDisplayEl.textContent = threshold.toFixed(2);
                }
                if (freeMsgEl) {
                    if (shipping === 0 && (method === 'free' || (freeShippingEnabled && cartTotal >= threshold))) {
                        freeMsgEl.style.display = 'block';
                    } else {
                        freeMsgEl.style.display = 'none';
                    }
                }
            }

            function updateSectionVisibility() {
                const flatSection = document.getElementById('flat_rate_section');
                const locationSection = document.getElementById('location_based_section');
                const methodEl = document.querySelector('input[name="shipping_method"]:checked');

                if (!methodEl) return;

                const method = methodEl.value;

                // Hide all sections first
                if (flatSection) flatSection.style.display = 'none';
                if (locationSection) locationSection.style.display = 'none';

                // Show relevant section
                if (method === 'flat_rate' && flatSection) {
                    flatSection.style.display = 'block';
                } else if (method === 'location_based' && locationSection) {
                    locationSection.style.display = 'block';
                }
            }

            // Initial updates
            updatePreview();
            updateSectionVisibility();
        });

        // Test shipping functions
        window.testShipping = function() {
            const modal = document.getElementById('test_modal');
            if (modal) modal.classList.remove('hidden');
        }

        window.closeTestModal = function() {
            const modal = document.getElementById('test_modal');
            if (modal) modal.classList.add('hidden');
        }

        window.calculateTest = function() {
            const cartTotalEl = document.getElementById('test_cart_total');
            const flatRateEl = document.getElementById('flat_rate');
            const thresholdEl = document.getElementById('free_shipping_threshold');
            const freeShippingEl = document.getElementById('free_shipping_enabled');
            const methodEl = document.querySelector('input[name="shipping_method"]:checked');

            if (!cartTotalEl || !flatRateEl || !thresholdEl || !freeShippingEl || !methodEl) return;

            const cartTotal = parseFloat(cartTotalEl.value) || 0;
            const flatRate = parseFloat(flatRateEl.value) || 0;
            const threshold = parseFloat(thresholdEl.value) || 0;
            const freeShippingEnabled = freeShippingEl.checked;
            const method = methodEl.value;

            let shipping = 0;
            let message = '';

            if (method === 'free') {
                shipping = 0;
                message = 'Free shipping (method set to free)';
            } else if (freeShippingEnabled && cartTotal >= threshold) {
                shipping = 0;
                message = `Free shipping (cart total ₹${cartTotal} ≥ threshold ₹${threshold})`;
            } else {
                shipping = flatRate;
                message = `Flat rate shipping: ₹${flatRate}`;
            }

            const total = cartTotal + shipping;

            const resultContent = document.getElementById('test_result_content');
            const resultDiv = document.getElementById('test_result');

            if (resultContent) {
                resultContent.innerHTML = `
                    <p><strong>Cart Total:</strong> ₹${cartTotal.toFixed(2)}</p>
                    <p><strong>Shipping:</strong> ₹${shipping.toFixed(2)}</p>
                    <p><strong>Final Total:</strong> ₹${total.toFixed(2)}</p>
                    <p class="mt-2 text-xs text-gray-600">${message}</p>
                `;
            }
            if (resultDiv) {
                resultDiv.classList.remove('hidden');
            }
        }
    </script>
</x-layouts.admin>

