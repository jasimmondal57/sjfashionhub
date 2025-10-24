<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">🚚 Shipping Settings</h1>
                        <p class="text-gray-600 mt-1">Configure shipping methods, rates, and delivery options</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button onclick="testShippingCalculation()" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-calculator mr-2"></i>Test Calculator
                        </button>
                        <button onclick="showResetModal()" 
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-undo mr-2"></i>Reset to Default
                        </button>
                    </div>
                </div>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-check-circle text-green-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-circle text-red-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Settings Form -->
            <form action="{{ route('admin.shipping-settings.update') }}" method="POST" class="space-y-6" onsubmit="logFormData(event)">
                @csrf
                @method('PUT')

                <!-- Basic Shipping Configuration -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Basic Configuration</h3>
                        <p class="text-sm text-gray-600 mt-1">Configure primary shipping method and basic settings</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="shipping_method" class="block text-sm font-medium text-gray-700 mb-2">
                                    Shipping Method
                                </label>
                                <select name="shipping_method" id="shipping_method"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="flat_rate" {{ $settings->shipping_method === 'flat_rate' ? 'selected' : '' }}>
                                        Flat Rate
                                    </option>
                                    <option value="weight_based" {{ $settings->shipping_method === 'weight_based' ? 'selected' : '' }}>
                                        Weight Based
                                    </option>
                                    <option value="location_based" {{ $settings->shipping_method === 'location_based' ? 'selected' : '' }}>
                                        Location Based
                                    </option>
                                    <option value="free" {{ $settings->shipping_method === 'free' ? 'selected' : '' }}>
                                        Free Shipping
                                    </option>
                                </select>
                                <!-- Debug info for shipping method -->
                                <p class="text-xs text-red-600 font-mono mt-1">
                                    Current DB Value: "{{ $settings->shipping_method }}"
                                </p>
                            </div>
                            <div>
                                <label for="flat_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                    Flat Rate Amount (₹)
                                </label>
                                <input type="number" name="flat_rate" id="flat_rate" 
                                       value="{{ old('flat_rate', $settings->flat_rate) }}" 
                                       step="0.01" min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="flex items-center space-x-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_enabled" id="is_enabled" value="1"
                                       {{ $settings->is_enabled ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="is_enabled" class="ml-2 block text-sm text-gray-700">
                                    Enable Shipping
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="cod_enabled" id="cod_enabled" value="1"
                                       {{ $settings->cod_enabled ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="cod_enabled" class="ml-2 block text-sm text-gray-700">
                                    Enable Cash on Delivery
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Free Shipping Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Free Shipping</h3>
                        <p class="text-sm text-gray-600 mt-1">Configure free shipping thresholds and conditions</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="flex items-center">
                            <input type="checkbox" name="free_shipping_enabled" id="free_shipping_enabled" value="1"
                                   @if($settings->free_shipping_enabled) checked @endif
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="free_shipping_enabled" class="ml-2 block text-sm text-gray-700">
                                Enable Free Shipping Above Threshold
                            </label>
                            <!-- Debug info -->
                            <span class="ml-4 text-xs text-red-600 font-mono">
                                DB: {{ $settings->free_shipping_enabled ? 'TRUE' : 'FALSE' }} |
                                Raw: {{ $settings->getAttributes()['free_shipping_enabled'] ?? 'NULL' }} |
                                Checkbox: {{ $settings->free_shipping_enabled ? 'CHECKED' : 'UNCHECKED' }}
                            </span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="free_shipping_threshold" class="block text-sm font-medium text-gray-700 mb-2">
                                    Free Shipping Threshold (₹)
                                </label>
                                <input type="number" name="free_shipping_threshold" id="free_shipping_threshold"
                                       value="{{ old('free_shipping_threshold', $settings->free_shipping_threshold) }}"
                                       step="0.01" min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-xs text-gray-500 mt-1">Orders above this amount get free shipping</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quick Actions</label>
                                <div class="space-y-2">
                                    <button type="button" onclick="enableFreeShipping()"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white px-3 py-2 rounded text-sm">
                                        ✅ Enable Free Shipping (₹500+)
                                    </button>
                                    <button type="button" onclick="disableFreeShipping()"
                                            class="w-full bg-red-600 hover:bg-red-700 text-white px-3 py-2 rounded text-sm">
                                        ❌ Disable Free Shipping
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Express Shipping -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Express Shipping</h3>
                        <p class="text-sm text-gray-600 mt-1">Configure express delivery options</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="flex items-center">
                            <input type="checkbox" name="express_shipping_enabled" id="express_shipping_enabled" value="1"
                                   {{ $settings->express_shipping_enabled ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="express_shipping_enabled" class="ml-2 block text-sm text-gray-700">
                                Enable Express Shipping Option
                            </label>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="express_shipping_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                    Express Shipping Rate (₹)
                                </label>
                                <input type="number" name="express_shipping_rate" id="express_shipping_rate" 
                                       value="{{ old('express_shipping_rate', $settings->express_shipping_rate) }}" 
                                       step="0.01" min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="express_shipping_days" class="block text-sm font-medium text-gray-700 mb-2">
                                    Express Delivery Days
                                </label>
                                <input type="number" name="express_shipping_days" id="express_shipping_days" 
                                       value="{{ old('express_shipping_days', $settings->express_shipping_days) }}" 
                                       min="1" max="30"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="standard_shipping_days" class="block text-sm font-medium text-gray-700 mb-2">
                                    Standard Delivery Days
                                </label>
                                <input type="number" name="standard_shipping_days" id="standard_shipping_days" 
                                       value="{{ old('standard_shipping_days', $settings->standard_shipping_days) }}" 
                                       min="1" max="30"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Weight-Based Shipping -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100" id="weight_based_section" style="display: {{ $settings->shipping_method === 'weight_based' ? 'block' : 'none' }}">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Weight-Based Shipping Rates</h3>
                        <p class="text-sm text-gray-600 mt-1">Configure shipping rates based on package weight</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="flex items-center">
                            <input type="checkbox" name="weight_based_enabled" id="weight_based_enabled" value="1"
                                   {{ $settings->weight_based_enabled ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="weight_based_enabled" class="ml-2 block text-sm text-gray-700">
                                Enable Weight-Based Shipping
                            </label>
                        </div>

                        <div id="weight_rates_container">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-sm font-medium text-gray-900">Weight Ranges & Rates</h4>
                                <button type="button" onclick="addWeightRate()"
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                    Add Range
                                </button>
                            </div>

                            <div id="weight_rates_list" class="space-y-3">
                                @if($settings->weight_rates && count($settings->weight_rates) > 0)
                                    @foreach($settings->weight_rates as $index => $rate)
                                        <div class="weight-rate-row grid grid-cols-4 gap-3 items-center">
                                            <input type="number" name="weight_rates[{{ $index }}][min_weight]"
                                                   value="{{ $rate['min_weight'] }}" step="0.1" min="0"
                                                   placeholder="Min Weight"
                                                   class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                                            <input type="number" name="weight_rates[{{ $index }}][max_weight]"
                                                   value="{{ $rate['max_weight'] }}" step="0.1" min="0"
                                                   placeholder="Max Weight"
                                                   class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                                            <input type="number" name="weight_rates[{{ $index }}][rate]"
                                                   value="{{ $rate['rate'] }}" step="0.01" min="0"
                                                   placeholder="Rate (₹)"
                                                   class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                                            <button type="button" onclick="removeWeightRate(this)"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-sm">
                                                Remove
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="weight-rate-row grid grid-cols-4 gap-3 items-center">
                                        <input type="number" name="weight_rates[0][min_weight]" value="0" step="0.1" min="0"
                                               placeholder="Min Weight" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                                        <input type="number" name="weight_rates[0][max_weight]" value="1" step="0.1" min="0"
                                               placeholder="Max Weight" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                                        <input type="number" name="weight_rates[0][rate]" value="50" step="0.01" min="0"
                                               placeholder="Rate (₹)" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                                        <button type="button" onclick="removeWeightRate(this)"
                                                class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-sm">
                                            Remove
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="default_weight" class="block text-sm font-medium text-gray-700 mb-2">
                                    Default Weight ({{ $settings->weight_unit }})
                                </label>
                                <input type="number" name="default_weight" id="default_weight"
                                       value="{{ old('default_weight', $settings->default_weight) }}"
                                       step="0.1" min="0.1"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="weight_unit" class="block text-sm font-medium text-gray-700 mb-2">
                                    Weight Unit
                                </label>
                                <select name="weight_unit" id="weight_unit"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="kg" {{ $settings->weight_unit === 'kg' ? 'selected' : '' }}>Kilograms (kg)</option>
                                    <option value="g" {{ $settings->weight_unit === 'g' ? 'selected' : '' }}>Grams (g)</option>
                                    <option value="lb" {{ $settings->weight_unit === 'lb' ? 'selected' : '' }}>Pounds (lb)</option>
                                    <option value="oz" {{ $settings->weight_unit === 'oz' ? 'selected' : '' }}>Ounces (oz)</option>
                                </select>
                            </div>
                            <div>
                                <label for="calculation_method" class="block text-sm font-medium text-gray-700 mb-2">
                                    Calculation Method
                                </label>
                                <select name="calculation_method" id="calculation_method"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <option value="highest_rate" {{ $settings->calculation_method === 'highest_rate' ? 'selected' : '' }}>Highest Rate</option>
                                    <option value="sum_rates" {{ $settings->calculation_method === 'sum_rates' ? 'selected' : '' }}>Sum of Rates</option>
                                    <option value="average_rate" {{ $settings->calculation_method === 'average_rate' ? 'selected' : '' }}>Average Rate</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Location-Based Shipping -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100" id="location_based_section" style="display: {{ $settings->shipping_method === 'location_based' ? 'block' : 'none' }}">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Location-Based Shipping Rates</h3>
                        <p class="text-sm text-gray-600 mt-1">Configure shipping rates based on delivery location</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="flex items-center">
                            <input type="checkbox" name="location_based_enabled" id="location_based_enabled" value="1"
                                   {{ $settings->location_based_enabled ? 'checked' : '' }}
                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                            <label for="location_based_enabled" class="ml-2 block text-sm text-gray-700">
                                Enable Location-Based Shipping
                            </label>
                        </div>

                        <div id="location_rates_container">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-sm font-medium text-gray-900">Shipping Zones & Rates</h4>
                                <button type="button" onclick="addLocationRate()"
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-sm">
                                    Add Zone
                                </button>
                            </div>

                            <div id="location_rates_list" class="space-y-3">
                                @if($settings->location_rates && count($settings->location_rates) > 0)
                                    @foreach($settings->location_rates as $index => $rate)
                                        <div class="location-rate-row grid grid-cols-4 gap-3 items-center">
                                            <input type="text" name="location_rates[{{ $index }}][zone]"
                                                   value="{{ $rate['zone'] }}"
                                                   placeholder="Zone Name"
                                                   class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                                            <input type="number" name="location_rates[{{ $index }}][rate]"
                                                   value="{{ $rate['rate'] }}" step="0.01" min="0"
                                                   placeholder="Rate (₹)"
                                                   class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                                            <input type="text" name="location_rates[{{ $index }}][description]"
                                                   value="{{ $rate['description'] ?? '' }}"
                                                   placeholder="Description"
                                                   class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                                            <button type="button" onclick="removeLocationRate(this)"
                                                    class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-sm">
                                                Remove
                                            </button>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="location-rate-row grid grid-cols-4 gap-3 items-center">
                                        <input type="text" name="location_rates[0][zone]" value="metro"
                                               placeholder="Zone Name" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                                        <input type="number" name="location_rates[0][rate]" value="99" step="0.01" min="0"
                                               placeholder="Rate (₹)" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                                        <input type="text" name="location_rates[0][description]" value="Metro Cities"
                                               placeholder="Description" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                                        <button type="button" onclick="removeLocationRate(this)"
                                                class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-sm">
                                            Remove
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Fees -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Additional Fees & Charges</h3>
                        <p class="text-sm text-gray-600 mt-1">Configure handling fees, packaging costs, and COD charges</p>
                    </div>
                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <div>
                                <label for="handling_fee" class="block text-sm font-medium text-gray-700 mb-2">
                                    Handling Fee (₹)
                                </label>
                                <input type="number" name="handling_fee" id="handling_fee" 
                                       value="{{ old('handling_fee', $settings->handling_fee) }}" 
                                       step="0.01" min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="packaging_fee" class="block text-sm font-medium text-gray-700 mb-2">
                                    Packaging Fee (₹)
                                </label>
                                <input type="number" name="packaging_fee" id="packaging_fee" 
                                       value="{{ old('packaging_fee', $settings->packaging_fee) }}" 
                                       step="0.01" min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="cod_charges" class="block text-sm font-medium text-gray-700 mb-2">
                                    COD Charges (₹)
                                </label>
                                <input type="number" name="cod_charges" id="cod_charges" 
                                       value="{{ old('cod_charges', $settings->cod_charges) }}" 
                                       step="0.01" min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                            <div>
                                <label for="international_shipping_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                    International Rate (₹)
                                </label>
                                <input type="number" name="international_shipping_rate" id="international_shipping_rate" 
                                       value="{{ old('international_shipping_rate', $settings->international_shipping_rate) }}" 
                                       step="0.01" min="0"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div class="flex items-center space-x-6">
                            <div class="flex items-center">
                                <input type="checkbox" name="shipping_tax_enabled" id="shipping_tax_enabled" value="1"
                                       {{ $settings->shipping_tax_enabled ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="shipping_tax_enabled" class="ml-2 block text-sm text-gray-700">
                                    Apply Tax on Shipping
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" name="international_shipping_enabled" id="international_shipping_enabled" value="1"
                                       {{ $settings->international_shipping_enabled ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                <label for="international_shipping_enabled" class="ml-2 block text-sm text-gray-700">
                                    Enable International Shipping
                                </label>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="shipping_tax_rate" class="block text-sm font-medium text-gray-700 mb-2">
                                    Shipping Tax Rate (%)
                                </label>
                                <input type="number" name="shipping_tax_rate" id="shipping_tax_rate" 
                                       value="{{ old('shipping_tax_rate', $settings->shipping_tax_rate) }}" 
                                       step="0.01" min="0" max="100"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Test Calculator Modal -->
    <div id="testCalculatorModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Test Shipping Calculator</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cart Total (₹)</label>
                            <input type="number" id="test_cart_total" step="0.01" min="0" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                            <input type="number" id="test_weight" step="0.1" min="0" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Destination City</label>
                            <input type="text" id="test_destination" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md">
                        </div>
                    </div>
                    <div id="test_results" class="mt-4 hidden">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <h4 class="font-medium text-gray-900 mb-2">Calculation Results:</h4>
                            <div id="test_results_content"></div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 border-t border-gray-200 flex justify-end space-x-3">
                    <button onclick="closeTestModal()" 
                            class="px-4 py-2 text-gray-700 border border-gray-300 rounded-md hover:bg-gray-50">
                        Close
                    </button>
                    <button onclick="calculateTestShipping()" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Calculate
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Force checkbox state on page load
        document.addEventListener('DOMContentLoaded', function() {
            const freeShippingCheckbox = document.getElementById('free_shipping_enabled');
            const dbValue = {{ $settings->free_shipping_enabled ? 'true' : 'false' }};

            // Force the checkbox to match database state
            freeShippingCheckbox.checked = dbValue;

            console.log('Free shipping DB value:', dbValue);
            console.log('Checkbox checked:', freeShippingCheckbox.checked);
        });

        // Quick action functions
        function enableFreeShipping() {
            document.getElementById('free_shipping_enabled').checked = true;
            document.getElementById('free_shipping_threshold').value = 500;
            alert('Free shipping enabled! Don\'t forget to save the settings.');
        }

        function disableFreeShipping() {
            document.getElementById('free_shipping_enabled').checked = false;
            alert('Free shipping disabled! Don\'t forget to save the settings.');
        }

        // Log form data before submission
        function logFormData(event) {
            const formData = new FormData(event.target);
            const data = {};
            for (let [key, value] of formData.entries()) {
                data[key] = value;
            }

            console.log('Form submission data:', data);
            console.log('Shipping method selected:', document.getElementById('shipping_method').value);
            console.log('Free shipping checkbox checked:', document.getElementById('free_shipping_enabled').checked);

            // Don't prevent form submission, just log
            return true;
        }

        // Show/hide sections based on shipping method
        document.getElementById('shipping_method').addEventListener('change', function() {
            const method = this.value;
            const weightSection = document.getElementById('weight_based_section');
            const locationSection = document.getElementById('location_based_section');

            weightSection.style.display = method === 'weight_based' ? 'block' : 'none';
            locationSection.style.display = method === 'location_based' ? 'block' : 'none';
        });

        // Weight rate management
        let weightRateIndex = {{ $settings->weight_rates ? count($settings->weight_rates) : 1 }};

        function addWeightRate() {
            const container = document.getElementById('weight_rates_list');
            const newRow = document.createElement('div');
            newRow.className = 'weight-rate-row grid grid-cols-4 gap-3 items-center';
            newRow.innerHTML = `
                <input type="number" name="weight_rates[${weightRateIndex}][min_weight]" step="0.1" min="0"
                       placeholder="Min Weight" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                <input type="number" name="weight_rates[${weightRateIndex}][max_weight]" step="0.1" min="0"
                       placeholder="Max Weight" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                <input type="number" name="weight_rates[${weightRateIndex}][rate]" step="0.01" min="0"
                       placeholder="Rate (₹)" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                <button type="button" onclick="removeWeightRate(this)"
                        class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-sm">
                    Remove
                </button>
            `;
            container.appendChild(newRow);
            weightRateIndex++;
        }

        function removeWeightRate(button) {
            button.closest('.weight-rate-row').remove();
        }

        // Location rate management
        let locationRateIndex = {{ $settings->location_rates ? count($settings->location_rates) : 1 }};

        function addLocationRate() {
            const container = document.getElementById('location_rates_list');
            const newRow = document.createElement('div');
            newRow.className = 'location-rate-row grid grid-cols-4 gap-3 items-center';
            newRow.innerHTML = `
                <input type="text" name="location_rates[${locationRateIndex}][zone]"
                       placeholder="Zone Name" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                <input type="number" name="location_rates[${locationRateIndex}][rate]" step="0.01" min="0"
                       placeholder="Rate (₹)" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                <input type="text" name="location_rates[${locationRateIndex}][description]"
                       placeholder="Description" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                <button type="button" onclick="removeLocationRate(this)"
                        class="bg-red-600 hover:bg-red-700 text-white px-2 py-1 rounded text-sm">
                    Remove
                </button>
            `;
            container.appendChild(newRow);
            locationRateIndex++;
        }

        function removeLocationRate(button) {
            button.closest('.location-rate-row').remove();
        }

        function testShippingCalculation() {
            document.getElementById('testCalculatorModal').classList.remove('hidden');
        }

        function closeTestModal() {
            document.getElementById('testCalculatorModal').classList.add('hidden');
            document.getElementById('test_results').classList.add('hidden');
        }

        function calculateTestShipping() {
            const cartTotal = document.getElementById('test_cart_total').value;
            const weight = document.getElementById('test_weight').value;
            const destination = document.getElementById('test_destination').value;

            fetch('{{ route("admin.shipping-settings.test") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart_total: cartTotal,
                    weight: weight,
                    destination_city: destination
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let html = `<p><strong>Shipping Cost:</strong> ₹${data.shipping_cost}</p>`;
                    html += `<p><strong>Method Used:</strong> ${data.settings_used.method}</p>`;
                    
                    if (data.available_methods.length > 0) {
                        html += '<div class="mt-3"><strong>Available Methods:</strong><ul class="mt-1 space-y-1">';
                        data.available_methods.forEach(method => {
                            html += `<li class="text-sm">• ${method.name}: ₹${method.cost} (${method.description})</li>`;
                        });
                        html += '</ul></div>';
                    }
                    
                    document.getElementById('test_results_content').innerHTML = html;
                    document.getElementById('test_results').classList.remove('hidden');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to calculate shipping');
            });
        }

        function showResetModal() {
            if (confirm('Are you sure you want to reset all shipping settings to default values? This action cannot be undone.')) {
                window.location.href = '{{ route("admin.shipping-settings.reset") }}';
            }
        }
    </script>
</x-layouts.admin>
