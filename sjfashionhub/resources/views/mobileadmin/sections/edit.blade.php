<x-layouts.mobileadmin>
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">✏️ Edit Section</h1>
            <p class="text-gray-600 mt-1">Update section details</p>
        </div>

        <form action="{{ route('mobileadmin.sections.update', $section) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Section Details</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Title -->
                    <div class="md:col-span-2">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Section Title *
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $section->title) }}"
                               required
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                            Section Type *
                        </label>
                        <select id="type" 
                                name="type" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <option value="">Select Type</option>
                            <option value="banner" {{ old('type', $section->type) == 'banner' ? 'selected' : '' }}>Banner Slider</option>
                            <option value="category" {{ old('type', $section->type) == 'category' ? 'selected' : '' }}>Category Grid</option>
                            <option value="product_grid" {{ old('type', $section->type) == 'product_grid' ? 'selected' : '' }}>Product Grid</option>
                            <option value="product_carousel" {{ old('type', $section->type) == 'product_carousel' ? 'selected' : '' }}>Product Carousel</option>
                            <option value="featured" {{ old('type', $section->type) == 'featured' ? 'selected' : '' }}>Featured Products</option>
                            <option value="deals" {{ old('type', $section->type) == 'deals' ? 'selected' : '' }}>Deals & Offers</option>
                            <option value="body" {{ old('type', $section->type) == 'body' ? 'selected' : '' }}>Body Section (Dynamic)</option>
                            <option value="category_products" {{ old('type', $section->type) == 'category_products' ? 'selected' : '' }}>Category Products</option>
                            <option value="custom" {{ old('type', $section->type) == 'custom' ? 'selected' : '' }}>Custom Section</option>
                        </select>
                        @error('type')
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
                               value="{{ old('order', $section->order) }}"
                               required
                               min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        @error('order')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="3"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">{{ old('description', $section->description) }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Configuration (JSON) -->
                    <div class="md:col-span-2">
                        <label for="config" class="block text-sm font-medium text-gray-700 mb-2">
                            Configuration (JSON)
                            <span class="text-gray-500 text-xs">Optional - Advanced settings</span>
                        </label>
                        <textarea id="config" 
                                  name="config" 
                                  rows="5"
                                  placeholder='{"limit": 10, "category_id": 1}'
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 font-mono text-sm">{{ old('config', is_array($section->config) ? json_encode($section->config, JSON_PRETTY_PRINT) : $section->config) }}</textarea>
                        @error('config')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Active Status -->
                    <div class="md:col-span-2">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $section->is_active) ? 'checked' : '' }}
                                   class="h-4 w-4 text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                            <span class="ml-2 text-sm font-medium text-gray-700">Active (Show on app)</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('mobileadmin.sections.index') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" 
                        class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-8 py-3 rounded-lg font-medium transition-all shadow-lg">
                    <i class="fas fa-save mr-2"></i>Update Section
                </button>
            </div>
        </form>
    </div>
</x-layouts.mobileadmin>

