<x-layouts.user title="Edit Address" subtitle="Update your address information">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center space-x-4 mb-4">
                <a href="{{ route('user.addresses.index') }}" 
                   class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Edit Address</h1>
            </div>
            <p class="text-gray-600">Update your address information below.</p>
        </div>

        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <form method="POST" action="{{ route('user.addresses.update', $address) }}">
                @csrf
                @method('PUT')

                <!-- Address Type -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-3">Address Type</label>
                    <div class="grid grid-cols-3 gap-3">
                        <label class="relative">
                            <input type="radio" name="type" value="shipping" class="sr-only peer" {{ old('type', $address->type) === 'shipping' ? 'checked' : '' }}>
                            <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-blue-500 peer-checked:bg-blue-50 transition-all">
                                <div class="text-center">
                                    <svg class="w-6 h-6 mx-auto mb-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Shipping</span>
                                </div>
                            </div>
                        </label>
                        <label class="relative">
                            <input type="radio" name="type" value="billing" class="sr-only peer" {{ old('type', $address->type) === 'billing' ? 'checked' : '' }}>
                            <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-purple-500 peer-checked:bg-purple-50 transition-all">
                                <div class="text-center">
                                    <svg class="w-6 h-6 mx-auto mb-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Billing</span>
                                </div>
                            </div>
                        </label>
                        <label class="relative">
                            <input type="radio" name="type" value="both" class="sr-only peer" {{ old('type', $address->type) === 'both' ? 'checked' : '' }}>
                            <div class="p-4 border-2 border-gray-200 rounded-lg cursor-pointer peer-checked:border-green-500 peer-checked:bg-green-50 transition-all">
                                <div class="text-center">
                                    <svg class="w-6 h-6 mx-auto mb-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Both</span>
                                </div>
                            </div>
                        </label>
                    </div>
                    @error('type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address Label -->
                <div class="mb-6">
                    <label for="label" class="block text-sm font-medium text-gray-700 mb-2">
                        Address Label (Optional)
                    </label>
                    <input type="text" 
                           id="label" 
                           name="label" 
                           value="{{ old('label', $address->label) }}"
                           placeholder="e.g., Home, Office, etc."
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                    @error('label')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Information -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="full_name" 
                               name="full_name" 
                               value="{{ old('full_name', $address->full_name) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                        @error('full_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Phone Number <span class="text-red-500">*</span>
                        </label>
                        <input type="tel" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', $address->phone) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Address Lines -->
                <div class="mb-6">
                    <label for="address_line_1" class="block text-sm font-medium text-gray-700 mb-2">
                        Address Line 1 <span class="text-red-500">*</span>
                    </label>
                    <textarea id="address_line_1" 
                              name="address_line_1" 
                              rows="2"
                              required
                              placeholder="House/Flat number, Building name, Street name"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">{{ old('address_line_1', $address->address_line_1) }}</textarea>
                    @error('address_line_1')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="address_line_2" class="block text-sm font-medium text-gray-700 mb-2">
                        Address Line 2 (Optional)
                    </label>
                    <textarea id="address_line_2" 
                              name="address_line_2" 
                              rows="2"
                              placeholder="Area, Landmark, etc."
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">{{ old('address_line_2', $address->address_line_2) }}</textarea>
                    @error('address_line_2')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Location Details -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label for="city" class="block text-sm font-medium text-gray-700 mb-2">
                            City <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="city" 
                               name="city" 
                               value="{{ old('city', $address->city) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                        @error('city')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="state" class="block text-sm font-medium text-gray-700 mb-2">
                            State <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="state" 
                               name="state" 
                               value="{{ old('state', $address->state) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                        @error('state')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="pincode" class="block text-sm font-medium text-gray-700 mb-2">
                            Pincode <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="pincode" 
                               name="pincode" 
                               value="{{ old('pincode', $address->pincode) }}"
                               required
                               pattern="[0-9]{6}"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                        @error('pincode')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Country -->
                <div class="mb-6">
                    <label for="country" class="block text-sm font-medium text-gray-700 mb-2">
                        Country <span class="text-red-500">*</span>
                    </label>
                    <select id="country" 
                            name="country" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-black">
                        <option value="India" {{ old('country', $address->country) === 'India' ? 'selected' : '' }}>India</option>
                        <option value="United States" {{ old('country', $address->country) === 'United States' ? 'selected' : '' }}>United States</option>
                        <option value="United Kingdom" {{ old('country', $address->country) === 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                        <option value="Canada" {{ old('country', $address->country) === 'Canada' ? 'selected' : '' }}>Canada</option>
                        <option value="Australia" {{ old('country', $address->country) === 'Australia' ? 'selected' : '' }}>Australia</option>
                    </select>
                    @error('country')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Default Address -->
                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_default" 
                               value="1"
                               {{ old('is_default', $address->is_default) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-black focus:ring-black">
                        <span class="ml-2 text-sm text-gray-700">Set as default address</span>
                    </label>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('user.addresses.index') }}" 
                       class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors font-medium">
                        Update Address
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.user>
