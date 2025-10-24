<x-layouts.admin title="Edit Header Settings" description="Edit website header settings">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-black">Edit Header Settings</h1>
                <p class="text-gray-600">Customize your website header configuration</p>
            </div>
            <a href="{{ route('admin.header-settings.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Overview
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.header-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Basic Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Site Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="site_name" 
                               name="site_name" 
                               value="{{ old('site_name', $headerSetting->site_name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                               required>
                        @error('site_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="logo_text" class="block text-sm font-medium text-gray-700 mb-2">
                            Logo Text (if no image)
                        </label>
                        <input type="text" 
                               id="logo_text" 
                               name="logo_text" 
                               value="{{ old('logo_text', $headerSetting->logo_text) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                               placeholder="Leave empty to use site name">
                        @error('logo_text')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Logo Image -->
                <div class="mt-6">
                    <label for="logo_image" class="block text-sm font-medium text-gray-700 mb-2">
                        Logo Image
                    </label>
                    @if($headerSetting->logo_image)
                        <div class="mb-3">
                            <p class="text-sm text-gray-600 mb-2">Current Logo:</p>
                            <img src="{{ Storage::url($headerSetting->logo_image) }}" alt="Current Logo" class="h-12 w-auto border border-gray-200 rounded">
                        </div>
                    @endif
                    <input type="file" 
                           id="logo_image" 
                           name="logo_image" 
                           accept="image/*"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">Upload a logo image (JPG, PNG, SVG). Recommended size: 200x60px. Leave empty to use text logo.</p>
                    @error('logo_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-black">Navigation Menu</h3>
                    <button type="button" onclick="addMenuItem()" class="btn btn-secondary btn-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Menu Item
                    </button>
                </div>
                
                <div id="menu-container" class="space-y-3">
                    @php
                        $menuItems = old('navigation_menu', $headerSetting->navigation_menu ?? []);
                    @endphp
                    
                    @if($menuItems && count($menuItems) > 0)
                        @foreach($menuItems as $index => $item)
                            <div class="menu-item flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <input type="text"
                                       name="navigation_menu[{{ $index }}][text]"
                                       value="{{ $item['text'] ?? '' }}"
                                       placeholder="Menu Text (e.g., Home)"
                                       class="w-48 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">

                                <div class="flex-1 relative">
                                    <select onchange="handleUrlSelect(this, {{ $index }})"
                                            class="url-select w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent bg-white">
                                        <option value="">Select a page or enter custom URL</option>
                                        <option value="custom">Custom URL</option>
                                    </select>
                                    <input type="text"
                                           name="navigation_menu[{{ $index }}][url]"
                                           value="{{ $item['url'] ?? '' }}"
                                           placeholder="Enter custom URL (e.g., /custom-page)"
                                           class="url-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent mt-2">
                                </div>

                                <label class="flex items-center">
                                    <input type="checkbox"
                                           name="navigation_menu[{{ $index }}][is_active]"
                                           value="1"
                                           {{ ($item['is_active'] ?? true) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-black focus:ring-black">
                                    <span class="ml-2 text-sm text-gray-700">Active</span>
                                </label>
                                <button type="button" onclick="removeMenuItem(this)" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-md">
                    <h4 class="text-sm font-medium text-blue-800 mb-2">💡 How to use URL selection:</h4>
                    <ul class="text-sm text-blue-700 space-y-1">
                        <li>• <strong>Select from dropdown:</strong> Choose from existing pages, categories, or products</li>
                        <li>• <strong>Custom URL:</strong> Select "Custom URL" to enter your own link (e.g., /custom-page, https://external-site.com)</li>
                        <li>• <strong>Auto-fill text:</strong> When you select a page, the menu text will be automatically filled if empty</li>
                        <li>• <strong>Active/Inactive:</strong> Use the checkbox to show/hide menu items without deleting them</li>
                    </ul>
                </div>
            </div>

            <!-- Header Features -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Header Features</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="show_search" 
                                   value="1"
                                   {{ old('show_search', $headerSetting->show_search) ? 'checked' : '' }}
                                   onchange="toggleSearchPlaceholder()"
                                   class="rounded border-gray-300 text-black focus:ring-black">
                            <span class="ml-2 text-sm font-medium text-gray-700">Show Search Bar</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="show_wishlist" 
                                   value="1"
                                   {{ old('show_wishlist', $headerSetting->show_wishlist) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-black focus:ring-black">
                            <span class="ml-2 text-sm font-medium text-gray-700">Show Wishlist Icon</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="show_cart" 
                                   value="1"
                                   {{ old('show_cart', $headerSetting->show_cart) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-black focus:ring-black">
                            <span class="ml-2 text-sm font-medium text-gray-700">Show Shopping Cart</span>
                        </label>
                        
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="show_account" 
                                   value="1"
                                   {{ old('show_account', $headerSetting->show_account) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-black focus:ring-black">
                            <span class="ml-2 text-sm font-medium text-gray-700">Show Account Menu</span>
                        </label>
                    </div>
                    
                    <div>
                        <div id="search-placeholder-container" class="{{ old('show_search', $headerSetting->show_search) ? '' : 'hidden' }}">
                            <label for="search_placeholder" class="block text-sm font-medium text-gray-700 mb-2">
                                Search Placeholder Text
                            </label>
                            <input type="text" 
                                   id="search_placeholder" 
                                   name="search_placeholder" 
                                   value="{{ old('search_placeholder', $headerSetting->search_placeholder) }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                   placeholder="Search products...">
                            @error('search_placeholder')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header Style & Settings -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Header Style & Settings</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="header_style" class="block text-sm font-medium text-gray-700 mb-2">
                            Header Style
                        </label>
                        <select id="header_style" 
                                name="header_style" 
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                            <option value="default" {{ old('header_style', $headerSetting->header_style) == 'default' ? 'selected' : '' }}>Default</option>
                            <option value="minimal" {{ old('header_style', $headerSetting->header_style) == 'minimal' ? 'selected' : '' }}>Minimal</option>
                            <option value="modern" {{ old('header_style', $headerSetting->header_style) == 'modern' ? 'selected' : '' }}>Modern</option>
                        </select>
                        @error('header_style')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex items-center">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   name="sticky_header" 
                                   value="1"
                                   {{ old('sticky_header', $headerSetting->sticky_header) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-black focus:ring-black">
                            <span class="ml-2 text-sm font-medium text-gray-700">Sticky Header (stays at top when scrolling)</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Contact Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Phone Number
                        </label>
                        <input type="text" 
                               id="contact_phone" 
                               name="contact_info[phone]" 
                               value="{{ old('contact_info.phone', $headerSetting->contact_info['phone'] ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                               placeholder="+1 (555) 123-4567">
                        @error('contact_info.phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>
                        <input type="email" 
                               id="contact_email" 
                               name="contact_info[email]" 
                               value="{{ old('contact_info.email', $headerSetting->contact_info['email'] ?? '') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                               placeholder="info@sjfashionhub.com">
                        @error('contact_info.email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-black">Social Media Links</h3>
                    <button type="button" onclick="addSocialLink()" class="btn btn-secondary btn-sm">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Social Link
                    </button>
                </div>
                
                <div id="social-container" class="space-y-3">
                    @php
                        $socialLinks = old('social_links', $headerSetting->social_links ?? []);
                    @endphp
                    
                    @if($socialLinks && count($socialLinks) > 0)
                        @foreach($socialLinks as $index => $link)
                            <div class="social-item flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <input type="text" 
                                       name="social_links[{{ $index }}][platform]" 
                                       value="{{ $link['platform'] ?? '' }}"
                                       placeholder="Platform (e.g., Facebook)"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                                <input type="text" 
                                       name="social_links[{{ $index }}][url]" 
                                       value="{{ $link['url'] ?? '' }}"
                                       placeholder="URL (e.g., https://facebook.com/...)"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                                <input type="text" 
                                       name="social_links[{{ $index }}][icon]" 
                                       value="{{ $link['icon'] ?? '' }}"
                                       placeholder="Icon (e.g., facebook)"
                                       class="w-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                                <button type="button" onclick="removeSocialLink(this)" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        @endforeach
                    @endif
                </div>
                <p class="mt-2 text-sm text-gray-500">Add social media links for your website</p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.header-settings.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Header Settings</button>
            </div>
        </form>
    </div>

    <script>
        let menuIndex = {{ count($headerSetting->navigation_menu ?? []) }};
        let socialIndex = {{ count($headerSetting->social_links ?? []) }};
        let availableUrls = {};

        // Fetch available URLs on page load
        document.addEventListener('DOMContentLoaded', function() {
            fetchAvailableUrls();
            populateExistingSelects();
        });

        async function fetchAvailableUrls() {
            try {
                const response = await fetch('{{ route("admin.header-settings.urls") }}');
                availableUrls = await response.json();
                populateAllSelects();
            } catch (error) {
                console.error('Error fetching URLs:', error);
            }
        }

        function populateAllSelects() {
            const selects = document.querySelectorAll('select[onchange*="handleUrlSelect"]');
            selects.forEach(select => {
                populateUrlSelect(select);
            });
        }

        function populateExistingSelects() {
            // Wait a bit for the selects to be populated with options
            setTimeout(() => {
                const menuItems = document.querySelectorAll('.menu-item');
                menuItems.forEach((item, index) => {
                    const urlInput = item.querySelector('input[name*="[url]"]');
                    const select = item.querySelector('select');
                    if (urlInput && select && urlInput.value) {
                        // Check if current URL matches any predefined URLs
                        let found = false;
                        const options = select.querySelectorAll('option');
                        options.forEach(option => {
                            if (option.value === urlInput.value) {
                                select.value = urlInput.value;
                                urlInput.classList.add('hidden');
                                found = true;
                            }
                        });
                        if (!found && urlInput.value) {
                            select.value = 'custom';
                            urlInput.classList.remove('hidden');
                        } else if (!urlInput.value) {
                            urlInput.classList.add('hidden');
                        }
                    }
                });
            }, 500);
        }

        function populateUrlSelect(select) {
            // Clear existing options except the first two
            while (select.children.length > 2) {
                select.removeChild(select.lastChild);
            }

            // Add URL options
            Object.entries(availableUrls).forEach(([groupName, urls]) => {
                if (Array.isArray(urls) && urls.length > 0) {
                    const optgroup = document.createElement('optgroup');
                    optgroup.label = groupName;

                    urls.forEach(urlItem => {
                        const option = document.createElement('option');
                        option.value = urlItem.url;
                        option.textContent = urlItem.text;
                        optgroup.appendChild(option);
                    });

                    select.appendChild(optgroup);
                }
            });
        }

        function handleUrlSelect(select, index) {
            const urlInput = select.parentElement.querySelector('.url-input');
            const textInput = select.parentElement.parentElement.querySelector('input[name*="[text]"]');

            if (select.value === 'custom') {
                urlInput.classList.remove('hidden');
                urlInput.focus();
                urlInput.value = '';
            } else if (select.value === '') {
                urlInput.classList.add('hidden');
                urlInput.value = '';
            } else {
                urlInput.classList.add('hidden');
                urlInput.value = select.value;

                // Auto-fill text if empty
                if (!textInput.value) {
                    const selectedOption = select.options[select.selectedIndex];
                    if (selectedOption && selectedOption.textContent) {
                        textInput.value = selectedOption.textContent;
                    }
                }
            }

            // Show a small preview of the URL
            showUrlPreview(select, urlInput.value || select.value);
        }

        function showUrlPreview(select, url) {
            // Remove existing preview
            const existingPreview = select.parentElement.querySelector('.url-preview');
            if (existingPreview) {
                existingPreview.remove();
            }

            if (url && url !== 'custom' && url !== '') {
                const preview = document.createElement('div');
                preview.className = 'url-preview text-xs text-gray-500 mt-1';
                preview.innerHTML = `🔗 <span class="font-mono">${url}</span>`;
                select.parentElement.appendChild(preview);
            }
        }

        function addMenuItem() {
            const container = document.getElementById('menu-container');
            const menuItem = document.createElement('div');
            menuItem.className = 'menu-item flex items-center space-x-3 p-3 bg-gray-50 rounded-lg';
            menuItem.innerHTML = `
                <input type="text"
                       name="navigation_menu[${menuIndex}][text]"
                       placeholder="Menu Text"
                       class="w-48 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">

                <div class="flex-1 relative">
                    <select onchange="handleUrlSelect(this, ${menuIndex})"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent bg-white">
                        <option value="">Select a page or enter custom URL</option>
                        <option value="custom">Custom URL</option>
                    </select>
                    <input type="text"
                           name="navigation_menu[${menuIndex}][url]"
                           placeholder="Enter custom URL (e.g., /custom-page)"
                           class="url-input w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent mt-2 hidden">
                </div>

                <label class="flex items-center">
                    <input type="checkbox"
                           name="navigation_menu[${menuIndex}][is_active]"
                           value="1"
                           checked
                           class="rounded border-gray-300 text-black focus:ring-black">
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
                <button type="button" onclick="removeMenuItem(this)" class="text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            `;
            container.appendChild(menuItem);

            // Populate the new select with URLs
            const newSelect = menuItem.querySelector('select');
            populateUrlSelect(newSelect);

            menuIndex++;
        }

        function removeMenuItem(button) {
            button.closest('.menu-item').remove();
        }

        function addSocialLink() {
            const container = document.getElementById('social-container');
            const socialItem = document.createElement('div');
            socialItem.className = 'social-item flex items-center space-x-3 p-3 bg-gray-50 rounded-lg';
            socialItem.innerHTML = `
                <input type="text" 
                       name="social_links[${socialIndex}][platform]" 
                       placeholder="Platform"
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                <input type="text" 
                       name="social_links[${socialIndex}][url]" 
                       placeholder="URL"
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                <input type="text" 
                       name="social_links[${socialIndex}][icon]" 
                       placeholder="Icon"
                       class="w-32 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                <button type="button" onclick="removeSocialLink(this)" class="text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            `;
            container.appendChild(socialItem);
            socialIndex++;
        }

        function removeSocialLink(button) {
            button.closest('.social-item').remove();
        }

        function toggleSearchPlaceholder() {
            const checkbox = document.querySelector('input[name="show_search"]');
            const container = document.getElementById('search-placeholder-container');
            
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }
    </script>
</x-layouts.admin>
