<!-- Include Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple {
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem !important;
        min-height: 42px !important;
        padding: 4px !important;
    }
    .select2-container--default.select2-container--focus .select2-selection--multiple {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
        background-color: #3b82f6 !important;
        border: none !important;
        color: white !important;
        padding: 4px 8px !important;
        border-radius: 0.25rem !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
        color: white !important;
        margin-right: 5px !important;
    }
    .select2-container {
        width: 100% !important;
    }
</style>

<!-- Location-Based Shipping Section -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200" id="location_based_section" style="display: {{ $settings->shipping_method === 'location_based' ? 'block' : 'none' }}">
    <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            Location-Based Shipping
        </h3>
        <p class="text-sm text-gray-600 mt-1">Set different shipping rates for domestic (state-wise) and international (country-wise) destinations</p>
    </div>
    
    <div class="p-6 space-y-6">
        <!-- Enable Location-Based Shipping -->
        <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
            <label class="flex items-center cursor-pointer">
                <input type="checkbox" name="location_based_enabled" id="location_based_enabled" value="1"
                       {{ $settings->location_based_enabled ? 'checked' : '' }}
                       class="w-5 h-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <span class="ml-3">
                    <span class="text-base font-semibold text-gray-900">Enable Location-Based Shipping</span>
                    <span class="block text-sm text-gray-600 mt-1">Charge different rates based on customer location</span>
                </span>
            </label>
        </div>

        <!-- Tabs for Domestic and International -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <button type="button" onclick="switchLocationTab('domestic')" id="tab-domestic"
                        class="location-tab border-b-2 border-blue-500 py-4 px-1 text-center border-b-2 font-medium text-sm text-blue-600">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                    Domestic (India)
                </button>
                <button type="button" onclick="switchLocationTab('international')" id="tab-international"
                        class="location-tab border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-center border-b-2 font-medium text-sm">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    International
                </button>
            </nav>
        </div>

        <!-- Domestic Shipping Zones -->
        <div id="domestic-shipping-content" class="location-content">
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-green-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-green-900">How Domestic Shipping Works</h4>
                        <p class="text-sm text-green-800 mt-1">Create shipping zones by selecting Indian states. For example, create a "West Bengal" zone with special rates, and a "Rest of India" zone for all other states.</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mb-4">
                <h4 class="text-sm font-medium text-gray-900">Domestic Shipping Zones</h4>
                <button type="button" onclick="addDomesticZone()"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Domestic Zone
                </button>
            </div>

            <div id="domestic_zones_list" class="space-y-4">
                @php
                    $domesticZones = collect($settings->location_rates ?? [])->filter(function($rate) {
                        return isset($rate['type']) && $rate['type'] === 'domestic';
                    })->values();
                @endphp

                @if($domesticZones->count() > 0)
                    @foreach($domesticZones as $index => $zone)
                        <div class="domestic-zone-card border-2 border-blue-200 rounded-lg p-5 bg-gradient-to-br from-white to-blue-50 shadow-sm hover:shadow-md transition-shadow" data-zone-id="{{ $index }}">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex-1">
                                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                        </svg>
                                        Zone Name
                                    </label>
                                    <input type="text" name="location_rates[{{ $index }}][zone_name]"
                                           value="{{ $zone['zone_name'] ?? '' }}"
                                           placeholder="e.g., West Bengal, Rest of India"
                                           class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-medium">
                                    <input type="hidden" name="location_rates[{{ $index }}][type]" value="domestic">
                                </div>
                                <button type="button" onclick="removeDomesticZone(this)"
                                        class="ml-3 text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-all"
                                        title="Delete Zone">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Shipping Rate (₹)
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-600 font-bold text-lg">₹</span>
                                        <input type="number" name="location_rates[{{ $index }}][rate]"
                                               value="{{ $zone['rate'] ?? 0 }}" step="0.01" min="0"
                                               placeholder="99.00"
                                               class="pl-8 w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-semibold">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                                        <svg class="w-4 h-4 inline-block mr-1 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Delivery Days
                                    </label>
                                    <input type="number" name="location_rates[{{ $index }}][delivery_days]"
                                           value="{{ $zone['delivery_days'] ?? 5 }}" min="1" max="30"
                                           placeholder="5"
                                           class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-semibold">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-semibold text-gray-800 mb-2">
                                    <svg class="w-4 h-4 inline-block mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Select States for this Zone
                                    <span class="text-xs text-gray-500 font-normal ml-2">(Search or click to select multiple)</span>
                                </label>
                                <select name="location_rates[{{ $index }}][states][]" multiple
                                        class="state-select-{{ $index }} w-full">
                                    @php
                                        $selectedStates = $zone['states'] ?? [];
                                        $allStates = \App\Helpers\IndianStates::all();
                                    @endphp
                                    @foreach($allStates as $state)
                                        <option value="{{ $state }}" {{ in_array($state, $selectedStates) ? 'selected' : '' }}>
                                            {{ $state }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-blue-600 mt-2 font-medium">
                                    <svg class="w-3 h-3 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    Selected: <span class="selected-count-{{ $index }}">{{ count($selectedStates) }}</span> state(s)
                                </p>
                            </div>

                            <!-- Save Button for this Zone -->
                            <div class="flex justify-end pt-3 border-t border-blue-200">
                                <button type="button" onclick="saveDomesticZone({{ $index }})"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition-all shadow-sm hover:shadow-md flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Save Zone
                                </button>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        <p class="text-sm">No domestic zones configured yet.</p>
                        <p class="text-xs mt-1">Click "Add Domestic Zone" to create your first shipping zone.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- International Shipping Zones -->
        <div id="international-shipping-content" class="location-content hidden">
            <div class="bg-purple-50 border border-purple-200 rounded-lg p-4 mb-4">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-purple-600 mt-0.5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-purple-900">How International Shipping Works</h4>
                        <p class="text-sm text-purple-800 mt-1">Enable international shipping and set rates for specific countries. You can create zones like "Asia", "Europe", "North America" with different rates.</p>
                    </div>
                </div>
            </div>

            <!-- Enable International Shipping -->
            <div class="p-4 bg-purple-50 rounded-lg border border-purple-200 mb-4">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="international_shipping_enabled" id="international_shipping_enabled" value="1"
                           {{ $settings->international_shipping_enabled ? 'checked' : '' }}
                           class="w-5 h-5 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                    <span class="ml-3">
                        <span class="text-base font-semibold text-gray-900">Enable International Shipping</span>
                        <span class="block text-sm text-gray-600 mt-1">Allow customers from other countries to place orders</span>
                    </span>
                </label>
            </div>

            <!-- Default International Rate -->
            <div class="mb-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
                <label class="block text-sm font-medium text-gray-700 mb-2">Default International Shipping Rate (₹)</label>
                <div class="relative max-w-xs">
                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 font-medium">₹</span>
                    <input type="number" name="international_shipping_rate" id="international_shipping_rate"
                           value="{{ old('international_shipping_rate', $settings->international_shipping_rate) }}"
                           step="0.01" min="0"
                           class="pl-8 w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 text-lg font-semibold">
                </div>
                <p class="text-xs text-gray-500 mt-2">This rate applies to countries not in any specific zone below</p>
            </div>

            <div class="flex justify-between items-center mb-4">
                <h4 class="text-sm font-medium text-gray-900">International Shipping Zones</h4>
                <button type="button" onclick="addInternationalZone()"
                        class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition-colors flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add International Zone
                </button>
            </div>

            <div id="international_zones_list" class="space-y-4">
                @php
                    $internationalZones = collect($settings->location_rates ?? [])->filter(function($rate) {
                        return isset($rate['type']) && $rate['type'] === 'international';
                    })->values();
                    $domesticCount = collect($settings->location_rates ?? [])->filter(function($rate) {
                        return isset($rate['type']) && $rate['type'] === 'domestic';
                    })->count();
                @endphp

                @if($internationalZones->count() > 0)
                    @foreach($internationalZones as $intIndex => $zone)
                        @php
                            $actualIndex = $domesticCount + $intIndex;
                        @endphp
                        <div class="international-zone-card border border-gray-300 rounded-lg p-4 bg-gray-50">
                            <div class="flex justify-between items-start mb-3">
                                <div class="flex-1">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Zone Name</label>
                                    <input type="text" name="location_rates[{{ $actualIndex }}][zone_name]"
                                           value="{{ $zone['zone_name'] ?? '' }}"
                                           placeholder="e.g., Asia, Europe, North America"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-purple-500">
                                    <input type="hidden" name="location_rates[{{ $actualIndex }}][type]" value="international">
                                </div>
                                <button type="button" onclick="removeInternationalZone(this)"
                                        class="ml-3 text-red-600 hover:text-red-800 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Shipping Rate (₹)</label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">₹</span>
                                        <input type="number" name="location_rates[{{ $actualIndex }}][rate]"
                                               value="{{ $zone['rate'] ?? 0 }}" step="0.01" min="0"
                                               placeholder="499.00"
                                               class="pl-8 w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-purple-500">
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Days</label>
                                    <input type="number" name="location_rates[{{ $actualIndex }}][delivery_days]"
                                           value="{{ $zone['delivery_days'] ?? 10 }}" min="1" max="60"
                                           placeholder="10"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-purple-500">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Select Countries for this Zone
                                    <span class="text-xs text-gray-500">(Hold Ctrl/Cmd to select multiple)</span>
                                </label>
                                <select name="location_rates[{{ $actualIndex }}][countries][]" multiple
                                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-purple-500 h-40">
                                    @php
                                        $selectedCountries = $zone['countries'] ?? [];
                                        $allCountries = \App\Helpers\Countries::all();
                                    @endphp
                                    @foreach($allCountries as $country)
                                        @if($country !== 'India')
                                            <option value="{{ $country }}" {{ in_array($country, $selectedCountries) ? 'selected' : '' }}>
                                                {{ $country }}
                                            </option>
                                        @endif
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">
                                    Selected: <span class="font-medium">{{ count($selectedCountries) }}</span> country(ies)
                                </p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8 text-gray-500">
                        <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-sm">No international zones configured yet.</p>
                        <p class="text-xs mt-1">Click "Add International Zone" to create your first international shipping zone.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
// Tab switching
function switchLocationTab(tab) {
    // Update tab buttons
    document.querySelectorAll('.location-tab').forEach(btn => {
        btn.classList.remove('border-blue-500', 'text-blue-600');
        btn.classList.add('border-transparent', 'text-gray-500');
    });
    
    if (tab === 'domestic') {
        document.getElementById('tab-domestic').classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('tab-domestic').classList.add('border-blue-500', 'text-blue-600');
    } else {
        document.getElementById('tab-international').classList.remove('border-transparent', 'text-gray-500');
        document.getElementById('tab-international').classList.add('border-blue-500', 'text-blue-600');
    }
    
    // Update content
    document.querySelectorAll('.location-content').forEach(content => {
        content.classList.add('hidden');
    });
    
    if (tab === 'domestic') {
        document.getElementById('domestic-shipping-content').classList.remove('hidden');
    } else {
        document.getElementById('international-shipping-content').classList.remove('hidden');
    }
}

// Add domestic zone
let domesticZoneIndex = {{ $domesticZones->count() }};
function addDomesticZone() {
    const container = document.getElementById('domestic_zones_list');
    const allStates = @json(\App\Helpers\IndianStates::all());

    const zoneHtml = `
        <div class="domestic-zone-card border-2 border-blue-200 rounded-lg p-5 bg-gradient-to-br from-white to-blue-50 shadow-sm hover:shadow-md transition-shadow" data-zone-id="${domesticZoneIndex}">
            <div class="flex justify-between items-start mb-4">
                <div class="flex-1">
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Zone Name
                    </label>
                    <input type="text" name="location_rates[${domesticZoneIndex}][zone_name]"
                           placeholder="e.g., West Bengal, Rest of India"
                           class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-medium">
                    <input type="hidden" name="location_rates[${domesticZoneIndex}][type]" value="domestic">
                </div>
                <button type="button" onclick="removeDomesticZone(this)"
                        class="ml-3 text-red-600 hover:text-red-800 hover:bg-red-50 p-2 rounded-lg transition-all"
                        title="Delete Zone">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Shipping Rate (₹)
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-600 font-bold text-lg">₹</span>
                        <input type="number" name="location_rates[${domesticZoneIndex}][rate]"
                               value="99" step="0.01" min="0" placeholder="99.00"
                               class="pl-8 w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-semibold">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">
                        <svg class="w-4 h-4 inline-block mr-1 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Delivery Days
                    </label>
                    <input type="number" name="location_rates[${domesticZoneIndex}][delivery_days]"
                           value="5" min="1" max="30" placeholder="5"
                           class="w-full px-4 py-2.5 border-2 border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-semibold">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-800 mb-2">
                    <svg class="w-4 h-4 inline-block mr-1 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Select States for this Zone
                    <span class="text-xs text-gray-500 font-normal ml-2">(Search or click to select multiple)</span>
                </label>
                <select name="location_rates[${domesticZoneIndex}][states][]" multiple
                        class="state-select-${domesticZoneIndex} w-full">
                    ${allStates.map(state => `<option value="${state}">${state}</option>`).join('')}
                </select>
                <p class="text-xs text-blue-600 mt-2 font-medium">
                    <svg class="w-3 h-3 inline-block mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Selected: <span class="selected-count-${domesticZoneIndex}">0</span> state(s)
                </p>
            </div>

            <!-- Save Button for this Zone -->
            <div class="flex justify-end pt-3 border-t border-blue-200">
                <button type="button" onclick="saveDomesticZone(${domesticZoneIndex})"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg text-sm font-semibold transition-all shadow-sm hover:shadow-md flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Zone
                </button>
            </div>
        </div>
    `;

    container.insertAdjacentHTML('beforeend', zoneHtml);

    // Initialize Select2 for the new zone
    $(`.state-select-${domesticZoneIndex}`).select2({
        placeholder: 'Search and select states...',
        allowClear: true,
        width: '100%'
    }).on('change', function() {
        $(`.selected-count-${domesticZoneIndex}`).text($(this).val() ? $(this).val().length : 0);
    });

    domesticZoneIndex++;
}

function removeDomesticZone(button) {
    if (confirm('Are you sure you want to remove this zone?')) {
        button.closest('.domestic-zone-card').remove();
    }
}

// Add international zone
let internationalZoneIndex = {{ $domesticCount + $internationalZones->count() }};
function addInternationalZone() {
    const container = document.getElementById('international_zones_list');
    const allCountries = @json(array_values(array_filter(\App\Helpers\Countries::all(), function($c) { return $c !== 'India'; })));
    
    const zoneHtml = `
        <div class="international-zone-card border border-gray-300 rounded-lg p-4 bg-gray-50">
            <div class="flex justify-between items-start mb-3">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Zone Name</label>
                    <input type="text" name="location_rates[${internationalZoneIndex}][zone_name]"
                           placeholder="e.g., Asia, Europe, North America"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-purple-500">
                    <input type="hidden" name="location_rates[${internationalZoneIndex}][type]" value="international">
                </div>
                <button type="button" onclick="removeInternationalZone(this)"
                        class="ml-3 text-red-600 hover:text-red-800 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Shipping Rate (₹)</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">₹</span>
                        <input type="number" name="location_rates[${internationalZoneIndex}][rate]"
                               value="499" step="0.01" min="0" placeholder="499.00"
                               class="pl-8 w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-purple-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Delivery Days</label>
                    <input type="number" name="location_rates[${internationalZoneIndex}][delivery_days]"
                           value="10" min="1" max="60" placeholder="10"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-purple-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Select Countries for this Zone
                    <span class="text-xs text-gray-500">(Hold Ctrl/Cmd to select multiple)</span>
                </label>
                <select name="location_rates[${internationalZoneIndex}][countries][]" multiple
                        class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-purple-500 h-40">
                    ${allCountries.map(country => `<option value="${country}">${country}</option>`).join('')}
                </select>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', zoneHtml);
    internationalZoneIndex++;
}

function removeInternationalZone(button) {
    if (confirm('Are you sure you want to remove this zone?')) {
        button.closest('.international-zone-card').remove();
    }
}

// Save individual domestic zone
function saveDomesticZone(zoneIndex) {
    const zoneCard = document.querySelector(`.domestic-zone-card[data-zone-id="${zoneIndex}"]`);
    if (!zoneCard) return;

    const zoneName = zoneCard.querySelector('input[name*="[zone_name]"]').value;
    const rate = zoneCard.querySelector('input[name*="[rate]"]').value;
    const deliveryDays = zoneCard.querySelector('input[name*="[delivery_days]"]').value;
    const statesSelect = zoneCard.querySelector('select[name*="[states]"]');
    const selectedStates = Array.from(statesSelect.selectedOptions).map(opt => opt.value);

    if (!zoneName) {
        alert('Please enter a zone name');
        return;
    }

    if (selectedStates.length === 0) {
        alert('Please select at least one state for this zone');
        return;
    }

    // Create FormData
    const formData = new FormData();
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
    formData.append('zone_index', zoneIndex);
    formData.append('zone_name', zoneName);
    formData.append('rate', rate);
    formData.append('delivery_days', deliveryDays);
    formData.append('type', 'domestic');
    selectedStates.forEach(state => {
        formData.append('states[]', state);
    });

    // Show loading state
    const saveBtn = zoneCard.querySelector('button[onclick*="saveDomesticZone"]');
    const originalText = saveBtn.innerHTML;
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<svg class="w-4 h-4 mr-2 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg> Saving...';

    // Send AJAX request
    fetch('/admin/shipping-settings/save-zone', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            saveBtn.innerHTML = '<svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Saved!';
            saveBtn.classList.remove('bg-blue-600', 'hover:bg-blue-700');
            saveBtn.classList.add('bg-green-600');

            // Reset after 2 seconds
            setTimeout(() => {
                saveBtn.innerHTML = originalText;
                saveBtn.classList.remove('bg-green-600');
                saveBtn.classList.add('bg-blue-600', 'hover:bg-blue-700');
                saveBtn.disabled = false;
            }, 2000);
        } else {
            alert('Error saving zone: ' + (data.message || 'Unknown error'));
            saveBtn.innerHTML = originalText;
            saveBtn.disabled = false;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error saving zone. Please try again.');
        saveBtn.innerHTML = originalText;
        saveBtn.disabled = false;
    });
}

// Initialize Select2 for all state/country selects
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2 for existing zones
    @foreach($domesticZones as $index => $zone)
        $('.state-select-{{ $index }}').select2({
            placeholder: 'Search and select states...',
            allowClear: true,
            width: '100%'
        }).on('change', function() {
            $('.selected-count-{{ $index }}').text($(this).val() ? $(this).val().length : 0);
        });
    @endforeach
});
</script>

<!-- Include Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

