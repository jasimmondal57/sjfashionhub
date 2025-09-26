<x-layouts.admin>
    <x-slot name="title">Create Banner - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">Create a new promotional banner</x-slot>
    <x-slot name="pageTitle">🎨 Create New Banner</x-slot>

    <!-- Header Actions -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600">Create a new promotional banner for your homepage</p>
        </div>
        <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Banners
        </a>
    </div>

    <!-- Banner Form -->
    <div class="bg-white rounded-lg border border-gray-100 p-6">
        <form action="{{ route('admin.banners.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Basic Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Banner Title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                           placeholder="Enter banner title" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                           placeholder="0" min="0">
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                          placeholder="Enter banner description">{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Image Upload -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Banner Image *</label>

                <!-- Image Size Recommendations -->
                <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-800">
                            <p class="font-medium mb-1">Recommended Image Specifications:</p>
                            <ul class="space-y-1 text-xs">
                                <li><strong>Dimensions:</strong> 1920x600px (Desktop) or 1200x600px (minimum)</li>
                                <li><strong>Aspect Ratio:</strong> 16:5 or 2:1 for best results</li>
                                <li><strong>Format:</strong> JPG, PNG, or WebP</li>
                                <li><strong>File Size:</strong> Under 2MB for optimal loading</li>
                                <li><strong>Resolution:</strong> 72-150 DPI for web display</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                    <div class="space-y-1 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <div class="flex text-sm text-gray-600">
                            <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-black hover:text-gray-800 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-black">
                                <span>Upload a file</span>
                                <input id="image" name="image" type="file" class="sr-only" accept="image/*" required>
                            </label>
                            <p class="pl-1">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        <p class="text-xs text-gray-400">Recommended: 1920x600px for best quality</p>
                    </div>
                </div>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Button Configuration -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Button Configuration</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Button Text -->
                    <div>
                        <label for="button_text" class="block text-sm font-medium text-gray-700 mb-2">Button Text</label>
                        <input type="text" id="button_text" name="button_text" value="{{ old('button_text') }}" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                               placeholder="Shop Now">
                        @error('button_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Link Type -->
                    <div>
                        <label for="link_type" class="block text-sm font-medium text-gray-700 mb-2">Link Type</label>
                        <select id="link_type" name="link_type" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                onchange="toggleLinkOptions()">
                            <option value="none" {{ old('link_type') === 'none' ? 'selected' : '' }}>No Link</option>
                            <option value="category" {{ old('link_type') === 'category' ? 'selected' : '' }}>Category</option>
                            <option value="product" {{ old('link_type') === 'product' ? 'selected' : '' }}>Product</option>
                            <option value="custom" {{ old('link_type') === 'custom' ? 'selected' : '' }}>Custom URL</option>
                        </select>
                        @error('link_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Category Selection -->
                <div id="category_selection" class="mt-4 hidden">
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Select Category</label>
                    <select id="category_id" name="category_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                        <option value="">Choose a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Product Selection -->
                <div id="product_selection" class="mt-4 hidden">
                    <label for="product_id" class="block text-sm font-medium text-gray-700 mb-2">Select Product</label>
                    <select id="product_id" name="product_id" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                        <option value="">Choose a product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                {{ $product->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('product_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Custom URL -->
                <div id="custom_url" class="mt-4 hidden">
                    <label for="custom_link" class="block text-sm font-medium text-gray-700 mb-2">Custom URL</label>
                    <input type="url" id="custom_link" name="custom_link" value="{{ old('custom_link') }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                           placeholder="https://example.com">
                    @error('custom_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Styling Options -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Styling Options</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Text Position -->
                    <div>
                        <label for="text_position" class="block text-sm font-medium text-gray-700 mb-2">Text Position</label>
                        <select id="text_position" name="text_position" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                            <option value="left" {{ old('text_position') === 'left' ? 'selected' : '' }}>Left</option>
                            <option value="center" {{ old('text_position') === 'center' ? 'selected' : '' }}>Center</option>
                            <option value="right" {{ old('text_position') === 'right' ? 'selected' : '' }}>Right</option>
                        </select>
                        @error('text_position')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Text Color -->
                    <div>
                        <label for="text_color" class="block text-sm font-medium text-gray-700 mb-2">Text Color</label>
                        <input type="color" id="text_color" name="text_color" value="{{ old('text_color', '#ffffff') }}" 
                               class="w-full h-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                        @error('text_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Button Color -->
                    <div>
                        <label for="button_color" class="block text-sm font-medium text-gray-700 mb-2">Button Color</label>
                        <input type="color" id="button_color" name="button_color" value="{{ old('button_color', '#000000') }}" 
                               class="w-full h-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                        @error('button_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="border-t border-gray-200 pt-6">
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" 
                           {{ old('is_active', true) ? 'checked' : '' }}
                           class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Active (banner will be displayed on the website)
                    </label>
                </div>
                @error('is_active')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Banner</button>
            </div>
        </form>
    </div>

    <script>
        function toggleLinkOptions() {
            const linkType = document.getElementById('link_type').value;
            const categorySelection = document.getElementById('category_selection');
            const productSelection = document.getElementById('product_selection');
            const customUrl = document.getElementById('custom_url');

            // Hide all options first
            categorySelection.classList.add('hidden');
            productSelection.classList.add('hidden');
            customUrl.classList.add('hidden');

            // Show relevant option
            if (linkType === 'category') {
                categorySelection.classList.remove('hidden');
            } else if (linkType === 'product') {
                productSelection.classList.remove('hidden');
            } else if (linkType === 'custom') {
                customUrl.classList.remove('hidden');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleLinkOptions();
        });
    </script>
</x-layouts.admin>
