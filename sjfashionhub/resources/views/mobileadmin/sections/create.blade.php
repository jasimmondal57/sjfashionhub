<x-layouts.mobileadmin>
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">➕ Create Body Section</h1>
            <p class="text-gray-600 mt-1">Add a new section to display products in your app</p>
        </div>

        <form action="{{ route('mobileadmin.sections.store') }}" method="POST">
            @csrf

            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <div class="space-y-6">
                    <!-- Section Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Section Title *
                            <span class="text-gray-500 text-xs font-normal">(e.g., "Trending Now", "Best Sellers", "New Arrivals")</span>
                        </label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title') }}"
                               placeholder="Enter section title"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Section Type (Hidden - always category_products) -->
                    <input type="hidden" name="type" value="category_products">

                    <!-- Select Category -->
                    <div>
                        <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Select Category *
                            <span class="text-gray-500 text-xs font-normal">(Products from this category will be displayed)</span>
                        </label>
                        <select id="category_id"
                                name="category_id"
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Choose a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }} ({{ $category->products()->where('is_active', true)->count() }} products)
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Display Order -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700 mb-2">
                            Display Order *
                            <span class="text-gray-500 text-xs font-normal">(Lower numbers appear first)</span>
                        </label>
                        <input type="number"
                               id="order"
                               name="order"
                               value="{{ old('order', 0) }}"
                               min="0"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        @error('order')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox"
                                   name="is_active"
                                   value="1"
                                   {{ old('is_active', true) ? 'checked' : '' }}
                                   class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm font-medium text-gray-700">Show this section in the app</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('mobileadmin.sections.index') }}"
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    ✓ Create Section
                </button>
            </div>
        </form>
    </div>
</x-layouts.mobileadmin>

