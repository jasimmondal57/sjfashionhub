<x-layouts.mobileadmin>
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">➕ Create Menu Item</h1>
            <p class="text-gray-600 mt-1">Add a new item to the navigation menu</p>
        </div>

        <form action="{{ route('mobileadmin.menu.store') }}" method="POST">
            @csrf

            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Menu Item Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Menu Title *
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icon -->
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">
                            Icon (Font Awesome class) *
                        </label>
                        <input type="text" 
                               id="icon" 
                               name="icon" 
                               value="{{ old('icon', 'fas fa-home') }}"
                               required
                               placeholder="fas fa-home"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        <p class="text-xs text-gray-500 mt-1">Example: fas fa-home, fas fa-shopping-cart</p>
                        @error('icon')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                            Display Order *
                        </label>
                        <input type="number" 
                               id="order" 
                               name="order" 
                               value="{{ old('order', 0) }}"
                               required
                               min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        @error('order')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Menu Type *
                        </label>
                        <select id="type" 
                                name="type" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Select Type</option>
                            <option value="home" {{ old('type') == 'home' ? 'selected' : '' }}>Home</option>
                            <option value="categories" {{ old('type') == 'categories' ? 'selected' : '' }}>Categories</option>
                            <option value="cart" {{ old('type') == 'cart' ? 'selected' : '' }}>Cart</option>
                            <option value="profile" {{ old('type') == 'profile' ? 'selected' : '' }}>Profile</option>
                            <option value="orders" {{ old('type') == 'orders' ? 'selected' : '' }}>Orders</option>
                            <option value="wishlist" {{ old('type') == 'wishlist' ? 'selected' : '' }}>Wishlist</option>
                            <option value="custom" {{ old('type') == 'custom' ? 'selected' : '' }}>Custom Screen</option>
                            <option value="url" {{ old('type') == 'url' ? 'selected' : '' }}>External URL</option>
                        </select>
                        @error('type')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Route/URL -->
                    <div>
                        <label for="route" class="block text-sm font-medium text-gray-700 mb-2">
                            Route/URL
                            <span class="text-gray-500 text-xs">For custom or URL types</span>
                        </label>
                        <input type="text" 
                               id="route" 
                               name="route" 
                               value="{{ old('route') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        @error('route')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="md:col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm font-medium text-gray-700">Active (Show in menu)</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('mobileadmin.menu.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" 
                        class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-8 py-3 rounded-lg font-medium transition-all shadow-lg">
                    <i class="fas fa-save mr-2"></i>Create Menu Item
                </button>
            </div>
        </form>
    </div>
</x-layouts.mobileadmin>

