<x-layouts.admin title="Edit Body Feature Section" description="Edit homepage content section">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-black">Edit Body Feature Section</h1>
                <p class="text-gray-600">Update the content section settings</p>
            </div>
            <a href="{{ route('admin.body-feature-sections.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.body-feature-sections.update', $bodyFeatureSection) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Section Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $bodyFeatureSection->title) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                            Subtitle (Optional)
                        </label>
                        <input type="text" 
                               id="subtitle" 
                               name="subtitle" 
                               value="{{ old('subtitle', $bodyFeatureSection->subtitle) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                        @error('subtitle')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Section Configuration -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Section Configuration</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="section_type" class="block text-sm font-medium text-gray-700 mb-2">
                            Section Type <span class="text-red-500">*</span>
                        </label>
                        <select id="section_type" 
                                name="section_type" 
                                onchange="toggleContentSettings()"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                            <option value="products" {{ old('section_type', $bodyFeatureSection->section_type) === 'products' ? 'selected' : '' }}>Products</option>
                            <option value="categories" {{ old('section_type', $bodyFeatureSection->section_type) === 'categories' ? 'selected' : '' }}>Categories</option>
                            <option value="mixed" {{ old('section_type', $bodyFeatureSection->section_type) === 'mixed' ? 'selected' : '' }}>Mixed (Products + Categories)</option>
                        </select>
                        @error('section_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="display_style" class="block text-sm font-medium text-gray-700 mb-2">
                            Display Style <span class="text-red-500">*</span>
                        </label>
                        <select id="display_style" 
                                name="display_style" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                            <option value="grid" {{ old('display_style', $bodyFeatureSection->display_style) === 'grid' ? 'selected' : '' }}>Grid Layout</option>
                            <option value="carousel" {{ old('display_style', $bodyFeatureSection->display_style) === 'carousel' ? 'selected' : '' }}>Carousel (Scrollable)</option>
                            <option value="list" {{ old('display_style', $bodyFeatureSection->display_style) === 'list' ? 'selected' : '' }}>List Layout</option>
                        </select>
                        @error('display_style')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="items_limit" class="block text-sm font-medium text-gray-700 mb-2">
                            Items to Show <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               id="items_limit" 
                               name="items_limit" 
                               value="{{ old('items_limit', $bodyFeatureSection->items_limit) }}"
                               min="1" 
                               max="50"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                        @error('items_limit')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Content Settings -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Content Settings</h3>
                
                @php
                    $settings = $bodyFeatureSection->content_settings ?? [];
                @endphp

                <!-- Products Settings -->
                <div id="products-settings" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Specific Products (Optional)</label>
                        <div class="relative">
                            <select id="product-suggestions" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent mb-2">
                                <option value="">Select products to add...</option>
                                <optgroup label="Featured Products">
                                    @foreach($products->where('is_featured', true) as $product)
                                        <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-category="{{ $product->category->name }}">
                                            {{ $product->name }} ({{ $product->category->name }}) - Featured
                                        </option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="All Products">
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-category="{{ $product->category->name }}">
                                            {{ $product->name }} ({{ $product->category->name }})
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <button type="button" onclick="addSelectedProduct()" class="btn btn-sm btn-outline">Add Selected Product</button>
                        </div>
                        <div id="selected-products" class="space-y-2 mt-3">
                            @foreach($settings['specific_products'] ?? [] as $productId)
                                @php $product = $products->find($productId); @endphp
                                @if($product)
                                <div class="flex items-center justify-between bg-gray-100 px-3 py-2 rounded">
                                    <span class="text-sm">{{ $product->name }} ({{ $product->category->name }})</span>
                                    <button type="button" onclick="removeProduct('{{ $product->id }}')" class="text-red-600 hover:text-red-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        <input type="hidden" name="specific_products" id="specific_products_input" value="{{ implode(',', $settings['specific_products'] ?? []) }}">
                        <p class="mt-1 text-xs text-gray-500">Select products from dropdown above. Leave empty to use filters below.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Categories</label>
                            <select name="filter_categories[]" multiple class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent" size="4">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ in_array($category->id, $settings['categories'] ?? []) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <label for="sort_by" class="block text-sm font-medium text-gray-700 mb-2">Sort Products By</label>
                                <select id="sort_by" name="sort_by" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                                    <option value="newest" {{ ($settings['sort_by'] ?? 'newest') === 'newest' ? 'selected' : '' }}>Newest First</option>
                                    <option value="featured" {{ ($settings['sort_by'] ?? '') === 'featured' ? 'selected' : '' }}>Featured First</option>
                                    <option value="price_low" {{ ($settings['sort_by'] ?? '') === 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high" {{ ($settings['sort_by'] ?? '') === 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="featured_only" value="1" {{ ($settings['featured_only'] ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-black focus:ring-black">
                                    <span class="ml-2 text-sm text-gray-700">Featured products only</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="checkbox" name="on_sale_only" value="1" {{ ($settings['on_sale_only'] ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-black focus:ring-black">
                                    <span class="ml-2 text-sm text-gray-700">On sale products only</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Categories Settings -->
                <div id="categories-settings" class="space-y-6 hidden">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Specific Categories (Optional)</label>
                        <div class="relative">
                            <select id="category-suggestions" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent mb-2">
                                <option value="">Select categories to add...</option>
                                <optgroup label="Parent Categories">
                                    @foreach($categories->whereNull('parent_id') as $category)
                                        <option value="{{ $category->id }}" data-name="{{ $category->name }}">
                                            {{ $category->name }} (Parent)
                                        </option>
                                    @endforeach
                                </optgroup>
                                <optgroup label="All Categories">
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" data-name="{{ $category->name }}">
                                            {{ $category->name }}{{ $category->parent_id ? ' (Subcategory)' : '' }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            </select>
                            <button type="button" onclick="addSelectedCategory()" class="btn btn-sm btn-outline">Add Selected Category</button>
                        </div>
                        <div id="selected-categories" class="space-y-2 mt-3">
                            @foreach($settings['specific_categories'] ?? [] as $categoryId)
                                @php $category = $categories->find($categoryId); @endphp
                                @if($category)
                                <div class="flex items-center justify-between bg-gray-100 px-3 py-2 rounded">
                                    <span class="text-sm">{{ $category->name }}</span>
                                    <button type="button" onclick="removeCategory('{{ $category->id }}')" class="text-red-600 hover:text-red-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                                @endif
                            @endforeach
                        </div>
                        <input type="hidden" name="specific_categories" id="specific_categories_input" value="{{ implode(',', $settings['specific_categories'] ?? []) }}">
                        <p class="mt-1 text-xs text-gray-500">Select categories from dropdown above. Leave empty to show all categories.</p>
                    </div>

                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="parent_only" value="1" {{ ($settings['parent_only'] ?? false) ? 'checked' : '' }} class="rounded border-gray-300 text-black focus:ring-black">
                            <span class="ml-2 text-sm text-gray-700">Show parent categories only (exclude subcategories)</span>
                        </label>
                    </div>
                </div>

                <!-- Mixed Settings -->
                <div id="mixed-settings" class="space-y-6 hidden">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Products</label>
                            <div class="relative">
                                <select id="mixed-product-suggestions" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent mb-2">
                                    <option value="">Select products to add...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" data-name="{{ $product->name }}" data-category="{{ $product->category->name }}">
                                            {{ $product->name }} ({{ $product->category->name }})
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" onclick="addSelectedMixedProduct()" class="btn btn-sm btn-outline">Add Product</button>
                            </div>
                            <div id="selected-mixed-products" class="space-y-2 mt-3">
                                @foreach($settings['products'] ?? [] as $productId)
                                    @php $product = $products->find($productId); @endphp
                                    @if($product)
                                    <div class="flex items-center justify-between bg-gray-100 px-3 py-2 rounded">
                                        <span class="text-sm">{{ $product->name }}</span>
                                        <button type="button" onclick="removeMixedProduct('{{ $product->id }}')" class="text-red-600 hover:text-red-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            <input type="hidden" name="mixed_products" id="mixed_products_input" value="{{ implode(',', $settings['products'] ?? []) }}">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Categories</label>
                            <div class="relative">
                                <select id="mixed-category-suggestions" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent mb-2">
                                    <option value="">Select categories to add...</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" data-name="{{ $category->name }}">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <button type="button" onclick="addSelectedMixedCategory()" class="btn btn-sm btn-outline">Add Category</button>
                            </div>
                            <div id="selected-mixed-categories" class="space-y-2 mt-3">
                                @foreach($settings['categories'] ?? [] as $categoryId)
                                    @php $category = $categories->find($categoryId); @endphp
                                    @if($category)
                                    <div class="flex items-center justify-between bg-gray-100 px-3 py-2 rounded">
                                        <span class="text-sm">{{ $category->name }}</span>
                                        <button type="button" onclick="removeMixedCategory('{{ $category->id }}')" class="text-red-600 hover:text-red-800">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                            <input type="hidden" name="mixed_categories" id="mixed_categories_input" value="{{ implode(',', $settings['categories'] ?? []) }}">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Design Settings -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Design Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="background_color" class="block text-sm font-medium text-gray-700 mb-2">
                            Background Color <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center space-x-3">
                            <input type="color" 
                                   id="background_color" 
                                   name="background_color" 
                                   value="{{ old('background_color', $bodyFeatureSection->background_color) }}"
                                   class="w-12 h-10 border border-gray-300 rounded cursor-pointer">
                            <input type="text" 
                                   id="background_color_text" 
                                   value="{{ old('background_color', $bodyFeatureSection->background_color) }}"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                   placeholder="#ffffff">
                        </div>
                        @error('background_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="text_color" class="block text-sm font-medium text-gray-700 mb-2">
                            Text Color <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center space-x-3">
                            <input type="color" 
                                   id="text_color" 
                                   name="text_color" 
                                   value="{{ old('text_color', $bodyFeatureSection->text_color) }}"
                                   class="w-12 h-10 border border-gray-300 rounded cursor-pointer">
                            <input type="text" 
                                   id="text_color_text" 
                                   value="{{ old('text_color', $bodyFeatureSection->text_color) }}"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                   placeholder="#000000">
                        </div>
                        @error('text_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Button Settings -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-black">Button Settings</h3>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="show_button" 
                               value="1"
                               {{ old('show_button', $bodyFeatureSection->show_button) ? 'checked' : '' }}
                               onchange="toggleButtonSettings()"
                               class="rounded border-gray-300 text-black focus:ring-black">
                        <span class="ml-2 text-sm font-medium text-gray-700">Show section button</span>
                    </label>
                </div>
                
                <div id="button-settings" class="{{ old('show_button', $bodyFeatureSection->show_button) ? '' : 'hidden' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="button_text" class="block text-sm font-medium text-gray-700 mb-2">
                                Button Text
                            </label>
                            <input type="text" 
                                   id="button_text" 
                                   name="button_text" 
                                   value="{{ old('button_text', $bodyFeatureSection->button_text) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                            @error('button_text')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="button_url" class="block text-sm font-medium text-gray-700 mb-2">
                                Button URL
                            </label>
                            <input type="text" 
                                   id="button_url" 
                                   name="button_url" 
                                   value="{{ old('button_url', $bodyFeatureSection->button_url) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                   placeholder="/products">
                            @error('button_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status & Order -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Status & Order</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="is_active" 
                                   value="1"
                                   {{ old('is_active', $bodyFeatureSection->is_active) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-black focus:ring-black">
                            <span class="ml-2 text-sm font-medium text-gray-700">Active (display on website)</span>
                        </label>
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                            Sort Order
                        </label>
                        <input type="number" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', $bodyFeatureSection->sort_order) }}"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.body-feature-sections.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Section</button>
            </div>
        </form>
    </div>

    <script>
        function toggleContentSettings() {
            const sectionType = document.getElementById('section_type').value;
            const productsSettings = document.getElementById('products-settings');
            const categoriesSettings = document.getElementById('categories-settings');
            const mixedSettings = document.getElementById('mixed-settings');

            // Hide all settings first
            productsSettings.classList.add('hidden');
            categoriesSettings.classList.add('hidden');
            mixedSettings.classList.add('hidden');

            // Show relevant settings
            if (sectionType === 'products') {
                productsSettings.classList.remove('hidden');
            } else if (sectionType === 'categories') {
                categoriesSettings.classList.remove('hidden');
            } else if (sectionType === 'mixed') {
                mixedSettings.classList.remove('hidden');
            }
        }

        function toggleButtonSettings() {
            const checkbox = document.querySelector('input[name="show_button"]');
            const container = document.getElementById('button-settings');
            
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }

        // Color picker sync
        function syncColorPickers() {
            const colorInputs = [
                { picker: 'background_color', text: 'background_color_text' },
                { picker: 'text_color', text: 'text_color_text' }
            ];

            colorInputs.forEach(({ picker, text }) => {
                document.getElementById(picker).addEventListener('change', function() {
                    document.getElementById(text).value = this.value;
                });

                document.getElementById(text).addEventListener('input', function() {
                    document.getElementById(picker).value = this.value;
                });
            });
        }

        // Content selection functions
        let selectedProducts = @json($settings['specific_products'] ?? []);
        let selectedCategories = @json($settings['specific_categories'] ?? []);
        let selectedMixedProducts = @json($settings['products'] ?? []);
        let selectedMixedCategories = @json($settings['categories'] ?? []);

        function addSelectedProduct() {
            const select = document.getElementById('product-suggestions');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption.value && !selectedProducts.includes(selectedOption.value)) {
                selectedProducts.push(selectedOption.value);

                const container = document.getElementById('selected-products');
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between bg-gray-100 px-3 py-2 rounded';
                item.innerHTML = `
                    <span class="text-sm">${selectedOption.text}</span>
                    <button type="button" onclick="removeProduct('${selectedOption.value}')" class="text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;
                container.appendChild(item);

                document.getElementById('specific_products_input').value = selectedProducts.join(',');
                select.selectedIndex = 0;
            }
        }

        function removeProduct(productId) {
            selectedProducts = selectedProducts.filter(id => id !== productId);
            document.getElementById('specific_products_input').value = selectedProducts.join(',');

            const container = document.getElementById('selected-products');
            const items = container.children;
            for (let i = 0; i < items.length; i++) {
                if (items[i].querySelector('button').getAttribute('onclick').includes(productId)) {
                    container.removeChild(items[i]);
                    break;
                }
            }
        }

        function addSelectedCategory() {
            const select = document.getElementById('category-suggestions');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption.value && !selectedCategories.includes(selectedOption.value)) {
                selectedCategories.push(selectedOption.value);

                const container = document.getElementById('selected-categories');
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between bg-gray-100 px-3 py-2 rounded';
                item.innerHTML = `
                    <span class="text-sm">${selectedOption.text}</span>
                    <button type="button" onclick="removeCategory('${selectedOption.value}')" class="text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;
                container.appendChild(item);

                document.getElementById('specific_categories_input').value = selectedCategories.join(',');
                select.selectedIndex = 0;
            }
        }

        function removeCategory(categoryId) {
            selectedCategories = selectedCategories.filter(id => id !== categoryId);
            document.getElementById('specific_categories_input').value = selectedCategories.join(',');

            const container = document.getElementById('selected-categories');
            const items = container.children;
            for (let i = 0; i < items.length; i++) {
                if (items[i].querySelector('button').getAttribute('onclick').includes(categoryId)) {
                    container.removeChild(items[i]);
                    break;
                }
            }
        }

        function addSelectedMixedProduct() {
            const select = document.getElementById('mixed-product-suggestions');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption.value && !selectedMixedProducts.includes(selectedOption.value)) {
                selectedMixedProducts.push(selectedOption.value);

                const container = document.getElementById('selected-mixed-products');
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between bg-gray-100 px-3 py-2 rounded';
                item.innerHTML = `
                    <span class="text-sm">${selectedOption.text}</span>
                    <button type="button" onclick="removeMixedProduct('${selectedOption.value}')" class="text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;
                container.appendChild(item);

                document.getElementById('mixed_products_input').value = selectedMixedProducts.join(',');
                select.selectedIndex = 0;
            }
        }

        function removeMixedProduct(productId) {
            selectedMixedProducts = selectedMixedProducts.filter(id => id !== productId);
            document.getElementById('mixed_products_input').value = selectedMixedProducts.join(',');

            const container = document.getElementById('selected-mixed-products');
            const items = container.children;
            for (let i = 0; i < items.length; i++) {
                if (items[i].querySelector('button').getAttribute('onclick').includes(productId)) {
                    container.removeChild(items[i]);
                    break;
                }
            }
        }

        function addSelectedMixedCategory() {
            const select = document.getElementById('mixed-category-suggestions');
            const selectedOption = select.options[select.selectedIndex];

            if (selectedOption.value && !selectedMixedCategories.includes(selectedOption.value)) {
                selectedMixedCategories.push(selectedOption.value);

                const container = document.getElementById('selected-mixed-categories');
                const item = document.createElement('div');
                item.className = 'flex items-center justify-between bg-gray-100 px-3 py-2 rounded';
                item.innerHTML = `
                    <span class="text-sm">${selectedOption.text}</span>
                    <button type="button" onclick="removeMixedCategory('${selectedOption.value}')" class="text-red-600 hover:text-red-800">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                `;
                container.appendChild(item);

                document.getElementById('mixed_categories_input').value = selectedMixedCategories.join(',');
                select.selectedIndex = 0;
            }
        }

        function removeMixedCategory(categoryId) {
            selectedMixedCategories = selectedMixedCategories.filter(id => id !== categoryId);
            document.getElementById('mixed_categories_input').value = selectedMixedCategories.join(',');

            const container = document.getElementById('selected-mixed-categories');
            const items = container.children;
            for (let i = 0; i < items.length; i++) {
                if (items[i].querySelector('button').getAttribute('onclick').includes(categoryId)) {
                    container.removeChild(items[i]);
                    break;
                }
            }
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            toggleContentSettings();
            syncColorPickers();
        });
    </script>
</x-layouts.admin>
