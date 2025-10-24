<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">🎫 Create New Coupon</h1>
                        <p class="text-gray-600 mt-1">Set up a new discount coupon for your customers</p>
                    </div>
                    <a href="{{ route('admin.coupons.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Coupons
                    </a>
                </div>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mr-3 mt-0.5"></i>
                        <div>
                            <h3 class="text-sm font-medium text-red-800">There were some errors:</h3>
                            <ul class="mt-2 text-sm text-red-700">
                                @foreach($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.coupons.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">📝 Basic Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="code" class="block text-sm font-medium text-gray-700 mb-2">
                                Coupon Code *
                            </label>
                            <div class="flex">
                                <input type="text" name="code" id="code" value="{{ old('code') }}" required
                                       placeholder="SAVE20"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-blue-500 uppercase">
                                <button type="button" onclick="generateCode()" 
                                        class="px-4 py-2 bg-gray-100 border border-l-0 border-gray-300 rounded-r-md hover:bg-gray-200 transition-colors">
                                    <i class="fas fa-random"></i>
                                </button>
                            </div>
                            <p class="mt-1 text-xs text-gray-500">Unique code customers will use</p>
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Coupon Name *
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   placeholder="20% Off Summer Sale"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Internal name for this coupon</p>
                        </div>

                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="3" 
                                      placeholder="Special discount for summer collection..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Discount Configuration -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">💰 Discount Configuration</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                Discount Type *
                            </label>
                            <select name="type" id="type" required onchange="updateDiscountFields()"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Type</option>
                                <option value="percentage" {{ old('type') === 'percentage' ? 'selected' : '' }}>Percentage</option>
                                <option value="fixed_amount" {{ old('type') === 'fixed_amount' ? 'selected' : '' }}>Fixed Amount</option>
                                <option value="free_shipping" {{ old('type') === 'free_shipping' ? 'selected' : '' }}>Free Shipping</option>
                            </select>
                        </div>

                        <div id="value-field">
                            <label for="value" class="block text-sm font-medium text-gray-700 mb-2">
                                <span id="value-label">Discount Value *</span>
                            </label>
                            <div class="relative">
                                <input type="number" name="value" id="value" value="{{ old('value') }}" 
                                       step="0.01" min="0" required
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <span id="value-suffix" class="absolute right-3 top-2 text-gray-500"></span>
                            </div>
                        </div>

                        <div>
                            <label for="minimum_amount" class="block text-sm font-medium text-gray-700 mb-2">
                                Minimum Order Amount
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">₹</span>
                                <input type="number" name="minimum_amount" id="minimum_amount" value="{{ old('minimum_amount') }}" 
                                       step="0.01" min="0" placeholder="0.00"
                                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>

                        <div id="maximum-discount-field" style="display: none;">
                            <label for="maximum_discount" class="block text-sm font-medium text-gray-700 mb-2">
                                Maximum Discount Cap
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-2 text-gray-500">₹</span>
                                <input type="number" name="maximum_discount" id="maximum_discount" value="{{ old('maximum_discount') }}" 
                                       step="0.01" min="0" placeholder="0.00"
                                       class="w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Usage Limits -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Usage Limits</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="usage_limit" class="block text-sm font-medium text-gray-700 mb-2">
                                Total Usage Limit
                            </label>
                            <input type="number" name="usage_limit" id="usage_limit" value="{{ old('usage_limit') }}" 
                                   min="1" placeholder="Unlimited"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Leave empty for unlimited usage</p>
                        </div>

                        <div>
                            <label for="usage_limit_per_customer" class="block text-sm font-medium text-gray-700 mb-2">
                                Usage Limit Per Customer
                            </label>
                            <input type="number" name="usage_limit_per_customer" id="usage_limit_per_customer" value="{{ old('usage_limit_per_customer') }}" 
                                   min="1" placeholder="Unlimited"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">How many times each customer can use this coupon</p>
                        </div>
                    </div>
                </div>

                <!-- Date Restrictions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">📅 Date Restrictions</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="starts_at" class="block text-sm font-medium text-gray-700 mb-2">
                                Start Date
                            </label>
                            <input type="datetime-local" name="starts_at" id="starts_at" value="{{ old('starts_at') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Leave empty to start immediately</p>
                        </div>

                        <div>
                            <label for="expires_at" class="block text-sm font-medium text-gray-700 mb-2">
                                Expiry Date
                            </label>
                            <input type="datetime-local" name="expires_at" id="expires_at" value="{{ old('expires_at') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Leave empty for no expiry</p>
                        </div>
                    </div>
                </div>

                <!-- Settings -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">⚙️ Settings</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="space-y-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Active</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" name="is_public" value="1" {{ old('is_public', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Public Coupon</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" name="stackable" value="1" {{ old('stackable') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Can be stacked with other coupons</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" name="first_order_only" value="1" {{ old('first_order_only') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">First-time customers only</span>
                            </label>
                        </div>

                        <div>
                            <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                                Priority
                            </label>
                            <input type="number" name="priority" id="priority" value="{{ old('priority', 0) }}" 
                                   min="0" placeholder="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Higher priority coupons are applied first</p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('admin.coupons.index') }}" 
                       class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-md font-medium transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md font-medium transition-colors">
                        <i class="fas fa-save mr-2"></i>Create Coupon
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function generateCode() {
            fetch('{{ route("admin.coupons.generate-code") }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('code').value = data.code;
                })
                .catch(error => console.error('Error:', error));
        }

        function updateDiscountFields() {
            const type = document.getElementById('type').value;
            const valueLabel = document.getElementById('value-label');
            const valueSuffix = document.getElementById('value-suffix');
            const valueField = document.getElementById('value-field');
            const maxDiscountField = document.getElementById('maximum-discount-field');

            switch(type) {
                case 'percentage':
                    valueLabel.textContent = 'Percentage *';
                    valueSuffix.textContent = '%';
                    valueField.style.display = 'block';
                    maxDiscountField.style.display = 'block';
                    document.getElementById('value').max = '100';
                    break;
                case 'fixed_amount':
                    valueLabel.textContent = 'Amount *';
                    valueSuffix.textContent = '₹';
                    valueField.style.display = 'block';
                    maxDiscountField.style.display = 'none';
                    document.getElementById('value').removeAttribute('max');
                    break;
                case 'free_shipping':
                    valueField.style.display = 'none';
                    maxDiscountField.style.display = 'none';
                    document.getElementById('value').value = '0';
                    break;
                default:
                    valueLabel.textContent = 'Discount Value *';
                    valueSuffix.textContent = '';
                    valueField.style.display = 'block';
                    maxDiscountField.style.display = 'none';
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateDiscountFields();
        });
    </script>
</x-layouts.admin>
