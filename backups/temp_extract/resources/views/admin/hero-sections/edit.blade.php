<x-layouts.admin title="Edit Hero Section" description="Edit hero section">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-black">Edit Hero Section</h1>
                <p class="text-gray-600">Update the hero section settings</p>
            </div>
            <a href="{{ route('admin.hero-sections.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.hero-sections.update', $heroSection) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Content Section -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Hero Content</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Title (First Line) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $heroSection->title) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                            Subtitle (Second Line) <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="subtitle" 
                               name="subtitle" 
                               value="{{ old('subtitle', $heroSection->subtitle) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                               required>
                        @error('subtitle')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                              required>{{ old('description', $heroSection->description) }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Buttons Section -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-black">Action Buttons</h3>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="show_buttons" 
                               value="1"
                               {{ old('show_buttons', $heroSection->show_buttons) ? 'checked' : '' }}
                               onchange="toggleButtons()"
                               class="rounded border-gray-300 text-black focus:ring-black">
                        <span class="ml-2 text-sm font-medium text-gray-700">Show buttons</span>
                    </label>
                </div>
                
                <div id="buttons-container" class="{{ old('show_buttons', $heroSection->show_buttons) ? '' : 'hidden' }}">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Primary Button -->
                        <div class="space-y-4">
                            <h4 class="text-sm font-medium text-gray-900">Primary Button</h4>
                            <div>
                                <label for="primary_button_text" class="block text-sm font-medium text-gray-700 mb-2">
                                    Button Text <span class="text-red-500">*</span>
                                </label>
                                <input type="text" 
                                       id="primary_button_text" 
                                       name="primary_button_text" 
                                       value="{{ old('primary_button_text', $heroSection->primary_button_text) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                       required>
                                @error('primary_button_text')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="primary_button_url" class="block text-sm font-medium text-gray-700 mb-2">
                                    Button URL <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <select id="primary_button_url_select"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                            onchange="handlePrimaryUrlSelection()">
                                        <option value="">Select a URL or choose Custom...</option>
                                        <optgroup label="Static Pages">
                                            <option value="/">Home</option>
                                            <option value="/products">All Products</option>
                                            <option value="/categories">All Categories</option>
                                            <option value="/about">About Us</option>
                                            <option value="/contact">Contact Us</option>
                                        </optgroup>
                                        <optgroup label="Categories" id="primary-categories-group">
                                            <!-- Categories will be loaded here -->
                                        </optgroup>
                                        <optgroup label="Featured Products" id="primary-products-group">
                                            <!-- Products will be loaded here -->
                                        </optgroup>
                                        <optgroup label="User Pages">
                                            <option value="/login">Login</option>
                                            <option value="/register">Register</option>
                                            <option value="/profile">Profile</option>
                                            <option value="/orders">Orders</option>
                                            <option value="/wishlist">Wishlist</option>
                                            <option value="/cart">Cart</option>
                                        </optgroup>
                                        <option value="custom">🔗 Custom URL</option>
                                    </select>
                                </div>
                                <input type="text"
                                       id="primary_button_url"
                                       name="primary_button_url"
                                       value="{{ old('primary_button_url', $heroSection->primary_button_url) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent mt-2"
                                       placeholder="/products or https://example.com"
                                       required>
                                <p class="mt-1 text-xs text-gray-500">Selected URL will appear above. You can also type a custom URL directly.</p>
                                @error('primary_button_url')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Secondary Button -->
                        <div class="space-y-4">
                            <h4 class="text-sm font-medium text-gray-900">Secondary Button (Optional)</h4>
                            <div>
                                <label for="secondary_button_text" class="block text-sm font-medium text-gray-700 mb-2">
                                    Button Text
                                </label>
                                <input type="text" 
                                       id="secondary_button_text" 
                                       name="secondary_button_text" 
                                       value="{{ old('secondary_button_text', $heroSection->secondary_button_text) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                                @error('secondary_button_text')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="secondary_button_url" class="block text-sm font-medium text-gray-700 mb-2">
                                    Button URL
                                </label>
                                <div class="relative">
                                    <select id="secondary_button_url_select"
                                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                            onchange="handleSecondaryUrlSelection()">
                                        <option value="">Select a URL or choose Custom...</option>
                                        <optgroup label="Static Pages">
                                            <option value="/">Home</option>
                                            <option value="/products">All Products</option>
                                            <option value="/categories">All Categories</option>
                                            <option value="/about">About Us</option>
                                            <option value="/contact">Contact Us</option>
                                        </optgroup>
                                        <optgroup label="Categories" id="secondary-categories-group">
                                            <!-- Categories will be loaded here -->
                                        </optgroup>
                                        <optgroup label="Featured Products" id="secondary-products-group">
                                            <!-- Products will be loaded here -->
                                        </optgroup>
                                        <optgroup label="User Pages">
                                            <option value="/login">Login</option>
                                            <option value="/register">Register</option>
                                            <option value="/profile">Profile</option>
                                            <option value="/orders">Orders</option>
                                            <option value="/wishlist">Wishlist</option>
                                            <option value="/cart">Cart</option>
                                        </optgroup>
                                        <option value="custom">🔗 Custom URL</option>
                                    </select>
                                </div>
                                <input type="text"
                                       id="secondary_button_url"
                                       name="secondary_button_url"
                                       value="{{ old('secondary_button_url', $heroSection->secondary_button_url) }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent mt-2"
                                       placeholder="/categories or https://example.com">
                                <p class="mt-1 text-xs text-gray-500">Selected URL will appear above. You can also type a custom URL directly.</p>
                                @error('secondary_button_url')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Design Section -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Design & Layout</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="background_color" class="block text-sm font-medium text-gray-700 mb-2">
                            Background Color <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center space-x-3">
                            <input type="color" 
                                   id="background_color" 
                                   name="background_color" 
                                   value="{{ old('background_color', $heroSection->background_color) }}"
                                   class="w-12 h-10 border border-gray-300 rounded cursor-pointer">
                            <input type="text" 
                                   id="background_color_text" 
                                   value="{{ old('background_color', $heroSection->background_color) }}"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                   placeholder="#f9fafb">
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
                                   value="{{ old('text_color', $heroSection->text_color) }}"
                                   class="w-12 h-10 border border-gray-300 rounded cursor-pointer">
                            <input type="text" 
                                   id="text_color_text" 
                                   value="{{ old('text_color', $heroSection->text_color) }}"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                   placeholder="#000000">
                        </div>
                        @error('text_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="accent_color" class="block text-sm font-medium text-gray-700 mb-2">
                            Accent Color (Subtitle) <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center space-x-3">
                            <input type="color" 
                                   id="accent_color" 
                                   name="accent_color" 
                                   value="{{ old('accent_color', $heroSection->accent_color) }}"
                                   class="w-12 h-10 border border-gray-300 rounded cursor-pointer">
                            <input type="text" 
                                   id="accent_color_text" 
                                   value="{{ old('accent_color', $heroSection->accent_color) }}"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                   placeholder="#000000">
                        </div>
                        @error('accent_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="layout_style" class="block text-sm font-medium text-gray-700 mb-2">
                            Layout Style <span class="text-red-500">*</span>
                        </label>
                        <select id="layout_style" 
                                name="layout_style" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                            <option value="split" {{ old('layout_style', $heroSection->layout_style) == 'split' ? 'selected' : '' }}>Split (Text + Image)</option>
                            <option value="centered" {{ old('layout_style', $heroSection->layout_style) == 'centered' ? 'selected' : '' }}>Centered (Text Only)</option>
                            <option value="full-width" {{ old('layout_style', $heroSection->layout_style) == 'full-width' ? 'selected' : '' }}>Full Width (Background Image)</option>
                        </select>
                        @error('layout_style')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                            Sort Order
                        </label>
                        <input type="number" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', $heroSection->sort_order) }}"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="mt-6">
                    <label for="hero_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Hero Image (Optional)
                    </label>
                    @if($heroSection->hero_image_url)
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                            <img src="{{ $heroSection->hero_image_url }}" alt="Current Hero Image" class="h-32 w-auto border border-gray-200 rounded">
                        </div>
                    @endif
                    <input type="file" 
                           id="hero_image" 
                           name="hero_image" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">Upload a hero image (JPG, PNG, WebP). Recommended size: 1200x800px or larger. Leave empty to keep current image.</p>
                    @error('hero_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Status</h3>
                <label class="flex items-center">
                    <input type="checkbox" 
                           name="is_active" 
                           value="1"
                           {{ old('is_active', $heroSection->is_active) ? 'checked' : '' }}
                           class="rounded border-gray-300 text-black focus:ring-black">
                    <span class="ml-2 text-sm font-medium text-gray-700">Active (display on website)</span>
                </label>
                <p class="mt-2 text-sm text-gray-500">Note: Only one hero section can be active at a time. Activating this will deactivate others.</p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.hero-sections.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Hero Section</button>
            </div>
        </form>
    </div>

    <script>
        // Color picker sync
        function syncColorPickers() {
            const colorInputs = [
                { picker: 'background_color', text: 'background_color_text' },
                { picker: 'text_color', text: 'text_color_text' },
                { picker: 'accent_color', text: 'accent_color_text' }
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

        function toggleButtons() {
            const checkbox = document.querySelector('input[name="show_buttons"]');
            const container = document.getElementById('buttons-container');

            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }

        // URL selection handlers
        function handlePrimaryUrlSelection() {
            const select = document.getElementById('primary_button_url_select');
            const input = document.getElementById('primary_button_url');

            if (select.value === 'custom') {
                input.focus();
                input.placeholder = 'Enter custom URL (e.g., https://example.com)';
            } else if (select.value) {
                input.value = select.value;
            }
        }

        function handleSecondaryUrlSelection() {
            const select = document.getElementById('secondary_button_url_select');
            const input = document.getElementById('secondary_button_url');

            if (select.value === 'custom') {
                input.focus();
                input.placeholder = 'Enter custom URL (e.g., https://example.com)';
            } else if (select.value) {
                input.value = select.value;
            }
        }

        // Load dynamic URLs
        function loadDynamicUrls() {
            fetch('{{ route("admin.header-settings.urls") }}')
                .then(response => response.json())
                .then(data => {
                    // Load categories for primary button
                    const primaryCategoriesGroup = document.getElementById('primary-categories-group');
                    primaryCategoriesGroup.innerHTML = '';
                    data.categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.url;
                        option.textContent = category.text;
                        primaryCategoriesGroup.appendChild(option);
                    });

                    // Load products for primary button
                    const primaryProductsGroup = document.getElementById('primary-products-group');
                    primaryProductsGroup.innerHTML = '';
                    data.products.forEach(product => {
                        const option = document.createElement('option');
                        option.value = product.url;
                        option.textContent = product.text;
                        primaryProductsGroup.appendChild(option);
                    });

                    // Load categories for secondary button
                    const secondaryCategoriesGroup = document.getElementById('secondary-categories-group');
                    secondaryCategoriesGroup.innerHTML = '';
                    data.categories.forEach(category => {
                        const option = document.createElement('option');
                        option.value = category.url;
                        option.textContent = category.text;
                        secondaryCategoriesGroup.appendChild(option);
                    });

                    // Load products for secondary button
                    const secondaryProductsGroup = document.getElementById('secondary-products-group');
                    secondaryProductsGroup.innerHTML = '';
                    data.products.forEach(product => {
                        const option = document.createElement('option');
                        option.value = product.url;
                        option.textContent = product.text;
                        secondaryProductsGroup.appendChild(option);
                    });
                })
                .catch(error => {
                    console.error('Error loading URLs:', error);
                });
        }

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            syncColorPickers();
            loadDynamicUrls();
        });
    </script>
</x-layouts.admin>
