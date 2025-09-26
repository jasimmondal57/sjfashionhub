<x-layouts.admin title="Edit Footer Settings" description="Edit footer content and settings">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Edit Footer Settings</h1>
                <p class="text-gray-100">Customize footer content, links, and appearance</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.footer-settings.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Footer Settings
                </a>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.footer-settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Company Information -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Company Information</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $footerSetting->company_name) }}" 
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('company_name')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="company_description" class="block text-sm font-medium text-gray-700 mb-2">Company Description</label>
                                <textarea name="company_description" id="company_description" rows="4" 
                                          class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Brief description about your company">{{ old('company_description', $footerSetting->company_description) }}</textarea>
                                @error('company_description')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="copyright_text" class="block text-sm font-medium text-gray-700 mb-2">Copyright Text</label>
                                <input type="text" name="copyright_text" id="copyright_text" value="{{ old('copyright_text', $footerSetting->copyright_text) }}" 
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="© 2024 Your Company Name | All rights reserved">
                                @error('copyright_text')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                                <input type="text" name="contact_info[phone]" id="contact_phone" value="{{ old('contact_info.phone', $footerSetting->contact_info['phone'] ?? '') }}" 
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="+1 (555) 123-4567">
                                @error('contact_info.phone')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                                <input type="email" name="contact_info[email]" id="contact_email" value="{{ old('contact_info.email', $footerSetting->contact_info['email'] ?? '') }}" 
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="info@company.com">
                                @error('contact_info.email')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="contact_address" class="block text-sm font-medium text-gray-700 mb-2">Address</label>
                                <textarea name="contact_info[address]" id="contact_address" rows="3" 
                                          class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="123 Main Street, City, State 12345">{{ old('contact_info.address', $footerSetting->contact_info['address'] ?? '') }}</textarea>
                                @error('contact_info.address')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Display Settings -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Display Settings</h3>

                        <div class="space-y-4">
                            <div class="flex items-center">
                                <input type="checkbox" name="show_payment_methods" id="show_payment_methods" value="1"
                                       {{ old('show_payment_methods', $footerSetting->show_payment_methods) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="show_payment_methods" class="ml-2 text-sm text-gray-700">Show Payment Methods</label>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Bottom Text Settings -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Footer Bottom Text</h3>

                        <div class="space-y-4">
                            <div>
                                <label for="made_in_text" class="block text-sm font-medium text-gray-700 mb-2">Made In Text</label>
                                <input type="text" name="made_in_text" id="made_in_text" value="{{ old('made_in_text', $footerSetting->made_in_text ?? 'Made with ❤️ in India') }}"
                                       placeholder="Made with ❤️ in India"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('made_in_text')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="designed_by_text" class="block text-sm font-medium text-gray-700 mb-2">Designed By Text</label>
                                <input type="text" name="designed_by_text" id="designed_by_text" value="{{ old('designed_by_text', $footerSetting->designed_by_text ?? 'Designed By') }}"
                                       placeholder="Designed By"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('designed_by_text')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 mb-2">Company Name</label>
                                <input type="text" name="company_name" id="company_name" value="{{ old('company_name', $footerSetting->company_name ?? 'JM Software') }}"
                                       placeholder="JM Software"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('company_name')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="company_url" class="block text-sm font-medium text-gray-700 mb-2">Company URL</label>
                                <input type="url" name="company_url" id="company_url" value="{{ old('company_url', $footerSetting->company_url ?? 'https://jmsoftware.shop/') }}"
                                       placeholder="https://jmsoftware.shop/"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('company_url')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Appearance Settings -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Appearance Settings</h3>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="background_color" class="block text-sm font-medium text-gray-700 mb-2">Background Color</label>
                                <input type="color" name="background_color" id="background_color" value="{{ old('background_color', $footerSetting->background_color) }}"
                                       class="w-full h-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('background_color')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="text_color" class="block text-sm font-medium text-gray-700 mb-2">Text Color</label>
                                <input type="color" name="text_color" id="text_color" value="{{ old('text_color', $footerSetting->text_color) }}"
                                       class="w-full h-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('text_color')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">

                    <!-- Quick Links -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200" data-section="quick_links">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Quick Links</h3>
                            <div class="flex space-x-2">
                                <button type="button" onclick="moveSection(this, 'up')" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600" title="Move Up">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="moveSection(this, 'down')" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600" title="Move Down">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="deleteSection(this)" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700" title="Delete Section">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="quick_links_title" class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                            <input type="text" name="quick_links_title" id="quick_links_title" value="{{ old('quick_links_title', $footerSetting->quick_links_title ?? 'Quick Links') }}"
                                   placeholder="Section Title"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        
                        <div id="quick-links-container" class="space-y-3">
                            @if($footerSetting->quick_links && count($footerSetting->quick_links) > 0)
                                @foreach($footerSetting->quick_links as $index => $link)
                                <div class="quick-link-item space-y-2">
                                    <div class="flex space-x-2">
                                        <input type="text" name="quick_links[{{ $index }}][text]" value="{{ old('quick_links.'.$index.'.text', $link['text']) }}"
                                               placeholder="Link Text"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" onclick="removeQuickLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex space-x-2">
                                        <select onchange="updateUrlField(this)" class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Select a page or enter custom URL</option>
                                            @foreach($availablePages as $group => $pages)
                                                <optgroup label="{{ $group }}">
                                                    @foreach($pages as $url => $name)
                                                        <option value="{{ $url }}" {{ old('quick_links.'.$index.'.url', $link['url']) == $url ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <input type="text" name="quick_links[{{ $index }}][url]" value="{{ old('quick_links.'.$index.'.url', $link['url']) }}"
                                               placeholder="Or enter custom URL"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="quick-link-item space-y-2">
                                    <div class="flex space-x-2">
                                        <input type="text" name="quick_links[0][text]" placeholder="Link Text"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" onclick="removeQuickLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex space-x-2">
                                        <select onchange="updateUrlField(this)" class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Select a page or enter custom URL</option>
                                            @foreach($availablePages as $group => $pages)
                                                <optgroup label="{{ $group }}">
                                                    @foreach($pages as $url => $name)
                                                        <option value="{{ $url }}">{{ $name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <input type="text" name="quick_links[0][url]" placeholder="Or enter custom URL"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <button type="button" onclick="addQuickLink()" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Add Quick Link
                        </button>
                    </div>

                    <!-- Customer Service Links -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200" data-section="customer_service">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Customer Service Links</h3>
                            <div class="flex space-x-2">
                                <button type="button" onclick="moveSection(this, 'up')" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600" title="Move Up">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="moveSection(this, 'down')" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600" title="Move Down">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="deleteSection(this)" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700" title="Delete Section">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="customer_service_title" class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                            <input type="text" name="customer_service_title" id="customer_service_title" value="{{ old('customer_service_title', $footerSetting->customer_service_title ?? 'Customer Service') }}"
                                   placeholder="Section Title"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div id="customer-service-links-container" class="space-y-3">
                            @if($footerSetting->customer_service_links && count($footerSetting->customer_service_links) > 0)
                                @foreach($footerSetting->customer_service_links as $index => $link)
                                <div class="customer-service-link-item space-y-2">
                                    <div class="flex space-x-2">
                                        <input type="text" name="customer_service_links[{{ $index }}][text]" value="{{ old('customer_service_links.'.$index.'.text', $link['text']) }}"
                                               placeholder="Link Text"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" onclick="removeCustomerServiceLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex space-x-2">
                                        <select onchange="updateUrlField(this)" class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Select a page or enter custom URL</option>
                                            @foreach($availablePages as $group => $pages)
                                                <optgroup label="{{ $group }}">
                                                    @foreach($pages as $url => $name)
                                                        <option value="{{ $url }}" {{ old('customer_service_links.'.$index.'.url', $link['url']) == $url ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <input type="text" name="customer_service_links[{{ $index }}][url]" value="{{ old('customer_service_links.'.$index.'.url', $link['url']) }}"
                                               placeholder="Or enter custom URL"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="customer-service-link-item space-y-2">
                                    <div class="flex space-x-2">
                                        <input type="text" name="customer_service_links[0][text]" placeholder="Link Text"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" onclick="removeCustomerServiceLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex space-x-2">
                                        <select onchange="updateUrlField(this)" class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Select a page or enter custom URL</option>
                                            @foreach($availablePages as $group => $pages)
                                                <optgroup label="{{ $group }}">
                                                    @foreach($pages as $url => $name)
                                                        <option value="{{ $url }}">{{ $name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <input type="text" name="customer_service_links[0][url]" placeholder="Or enter custom URL"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <button type="button" onclick="addCustomerServiceLink()" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Add Customer Service Link
                        </button>
                    </div>

                    <!-- Categories Links -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200" data-section="categories">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Categories Links</h3>
                            <div class="flex space-x-2">
                                <button type="button" onclick="moveSection(this, 'up')" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600" title="Move Up">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="moveSection(this, 'down')" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600" title="Move Down">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <button type="button" onclick="deleteSection(this)" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700" title="Delete Section">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="categories_title" class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                            <input type="text" name="categories_title" id="categories_title" value="{{ old('categories_title', $footerSetting->categories_title ?? 'Categories') }}"
                                   placeholder="Section Title"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <div id="categories-links-container" class="space-y-3">
                            @if($footerSetting->categories_links && count($footerSetting->categories_links) > 0)
                                @foreach($footerSetting->categories_links as $index => $link)
                                <div class="categories-link-item space-y-2">
                                    <div class="flex space-x-2">
                                        <input type="text" name="categories_links[{{ $index }}][text]" value="{{ old('categories_links.'.$index.'.text', $link['text']) }}"
                                               placeholder="Link Text"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" onclick="removeCategoriesLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex space-x-2">
                                        <select onchange="updateUrlField(this)" class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Select a page or enter custom URL</option>
                                            @foreach($availablePages as $group => $pages)
                                                <optgroup label="{{ $group }}">
                                                    @foreach($pages as $url => $name)
                                                        <option value="{{ $url }}" {{ old('categories_links.'.$index.'.url', $link['url']) == $url ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <input type="text" name="categories_links[{{ $index }}][url]" value="{{ old('categories_links.'.$index.'.url', $link['url']) }}"
                                               placeholder="Or enter custom URL"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="categories-link-item space-y-2">
                                    <div class="flex space-x-2">
                                        <input type="text" name="categories_links[0][text]" placeholder="Link Text"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" onclick="removeCategoriesLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="flex space-x-2">
                                        <select onchange="updateUrlField(this)" class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Select a page or enter custom URL</option>
                                            @foreach($availablePages as $group => $pages)
                                                <optgroup label="{{ $group }}">
                                                    @foreach($pages as $url => $name)
                                                        <option value="{{ $url }}">{{ $name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <input type="text" name="categories_links[0][url]" placeholder="Or enter custom URL"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <button type="button" onclick="addCategoriesLink()" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Add Categories Link
                        </button>
                    </div>



                    <!-- Payment Icons Section -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Methods Icons</h3>

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="show_payment_icons" value="1" {{ old('show_payment_icons', $footerSetting->show_payment_icons ?? true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Show Payment Icons</span>
                            </label>
                        </div>

                        <div id="payment-icons-container" class="space-y-3">
                            @if($footerSetting->payment_icons && count($footerSetting->payment_icons) > 0)
                                @foreach($footerSetting->payment_icons as $index => $icon)
                                <div class="payment-icon-item space-y-3 p-4 border border-gray-200 rounded-lg">
                                    <div class="flex space-x-2">
                                        <input type="text" name="payment_icons[{{ $index }}][name]" value="{{ old('payment_icons.'.$index.'.name', $icon['name']) }}"
                                               placeholder="Payment Method Name"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <input type="text" name="payment_icons[{{ $index }}][icon]" value="{{ old('payment_icons.'.$index.'.icon', $icon['icon']) }}"
                                               placeholder="Icon Name (e.g., upi, visa)"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" onclick="removePaymentIcon(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Image Type Selection -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-gray-700">Icon Type:</label>
                                        <div class="flex space-x-4">
                                            <label class="flex items-center">
                                                <input type="radio" name="payment_icons[{{ $index }}][image_type]" value="auto"
                                                       {{ old('payment_icons.'.$index.'.image_type', $icon['image_type'] ?? 'auto') == 'auto' ? 'checked' : '' }}
                                                       onchange="toggleImageType(this, {{ $index }})"
                                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">Auto Generated</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" name="payment_icons[{{ $index }}][image_type]" value="custom"
                                                       {{ old('payment_icons.'.$index.'.image_type', $icon['image_type'] ?? 'auto') == 'custom' ? 'checked' : '' }}
                                                       onchange="toggleImageType(this, {{ $index }})"
                                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">Custom Upload</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Custom Image Upload -->
                                    <div id="custom-upload-{{ $index }}" class="space-y-2 {{ old('payment_icons.'.$index.'.image_type', $icon['image_type'] ?? 'auto') == 'custom' ? '' : 'hidden' }}">
                                        <label class="text-sm font-medium text-gray-700">Upload Image (50x50px recommended):</label>
                                        <div class="flex items-center space-x-3">
                                            <input type="file" name="payment_icons[{{ $index }}][custom_image]" accept="image/*"
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            @if(!empty($icon['custom_image']))
                                                <div class="flex items-center space-x-2">
                                                    <img src="{{ asset('storage/' . $icon['custom_image']) }}" alt="{{ $icon['name'] }}" class="w-8 h-8 object-cover rounded border">
                                                    <span class="text-xs text-gray-500">Current</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="flex space-x-2">
                                        <select onchange="updateUrlField(this)" class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Select payment method or enter custom URL</option>
                                            @foreach($paymentPages as $group => $pages)
                                                <optgroup label="{{ $group }}">
                                                    @foreach($pages as $url => $name)
                                                        <option value="{{ $url }}" {{ old('payment_icons.'.$index.'.url', $icon['url'] ?? '') == $url ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <input type="text" name="payment_icons[{{ $index }}][url]" value="{{ old('payment_icons.'.$index.'.url', $icon['url'] ?? '') }}"
                                               placeholder="Or enter custom URL"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="payment-icon-item space-y-3 p-4 border border-gray-200 rounded-lg">
                                    <div class="flex space-x-2">
                                        <input type="text" name="payment_icons[0][name]" value="UPI" placeholder="Payment Method Name"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <input type="text" name="payment_icons[0][icon]" value="upi" placeholder="Icon Name"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" onclick="removePaymentIcon(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Image Type Selection -->
                                    <div class="space-y-2">
                                        <label class="text-sm font-medium text-gray-700">Icon Type:</label>
                                        <div class="flex space-x-4">
                                            <label class="flex items-center">
                                                <input type="radio" name="payment_icons[0][image_type]" value="auto" checked
                                                       onchange="toggleImageType(this, 0)"
                                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">Auto Generated</span>
                                            </label>
                                            <label class="flex items-center">
                                                <input type="radio" name="payment_icons[0][image_type]" value="custom"
                                                       onchange="toggleImageType(this, 0)"
                                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                                <span class="ml-2 text-sm text-gray-700">Custom Upload</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Custom Image Upload -->
                                    <div id="custom-upload-0" class="space-y-2 hidden">
                                        <label class="text-sm font-medium text-gray-700">Upload Image (50x50px recommended):</label>
                                        <input type="file" name="payment_icons[0][custom_image]" accept="image/*"
                                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                    </div>

                                    <div class="flex space-x-2">
                                        <select onchange="updateUrlField(this)" class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                            <option value="">Select payment method or enter custom URL</option>
                                            @foreach($paymentPages as $group => $pages)
                                                <optgroup label="{{ $group }}">
                                                    @foreach($pages as $url => $name)
                                                        <option value="{{ $url }}">{{ $name }}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        <input type="text" name="payment_icons[0][url]" placeholder="Or enter custom URL"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    </div>
                                </div>
                            @endif
                        </div>

                        <button type="button" onclick="addPaymentIcon()" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Add Payment Icon
                        </button>
                    </div>

                    <!-- App Download Links Section -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">App Download Links</h3>

                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="show_app_downloads" value="1" {{ old('show_app_downloads', $footerSetting->show_app_downloads ?? true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Show App Download Links</span>
                            </label>
                        </div>

                        <div id="app-downloads-container" class="space-y-3">
                            @if($footerSetting->app_download_links && count($footerSetting->app_download_links) > 0)
                                @foreach($footerSetting->app_download_links as $index => $app)
                                <div class="app-download-item space-y-2">
                                    <div class="flex space-x-2">
                                        <input type="text" name="app_download_links[{{ $index }}][platform]" value="{{ old('app_download_links.'.$index.'.platform', $app['platform']) }}"
                                               placeholder="Platform (Android/iOS)"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <input type="text" name="app_download_links[{{ $index }}][icon]" value="{{ old('app_download_links.'.$index.'.icon', $app['icon']) }}"
                                               placeholder="Icon (playstore/appstore)"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" onclick="removeAppDownload(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <input type="url" name="app_download_links[{{ $index }}][url]" value="{{ old('app_download_links.'.$index.'.url', $app['url']) }}"
                                           placeholder="Download URL"
                                           class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                @endforeach
                            @else
                                <div class="app-download-item space-y-2">
                                    <div class="flex space-x-2">
                                        <input type="text" name="app_download_links[0][platform]" value="Android" placeholder="Platform"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <input type="text" name="app_download_links[0][icon]" value="playstore" placeholder="Icon"
                                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" onclick="removeAppDownload(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                    <input type="url" name="app_download_links[0][url]" value="https://play.google.com/store/apps/details?id=com.sjfashionhub" placeholder="Download URL"
                                           class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                            @endif
                        </div>

                        <button type="button" onclick="addAppDownload()" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            Add App Download Link
                        </button>
                    </div>

                    <!-- Add New Section Button -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200 border-dashed">
                        <div class="text-center">
                            <button type="button" onclick="addNewSection()" class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 font-medium">
                                <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add New Section
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Save Button -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.footer-settings.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Save Footer Settings
                </button>
            </div>
        </form>
    </div>

    <x-slot name="scripts">
        <script>
            let quickLinkIndex = {{ $footerSetting->quick_links ? count($footerSetting->quick_links) : 1 }};
            let customerServiceLinkIndex = {{ $footerSetting->customer_service_links ? count($footerSetting->customer_service_links) : 1 }};
            let categoriesLinkIndex = {{ $footerSetting->categories_links ? count($footerSetting->categories_links) : 1 }};
            let paymentIconIndex = {{ $footerSetting->payment_icons ? count($footerSetting->payment_icons) : 1 }};
            let appDownloadIndex = {{ $footerSetting->app_download_links ? count($footerSetting->app_download_links) : 1 }};


            function addQuickLink() {
                const container = document.getElementById('quick-links-container');
                const div = document.createElement('div');
                div.className = 'quick-link-item space-y-2';
                div.innerHTML = `
                    <div class="flex space-x-2">
                        <input type="text" name="quick_links[${quickLinkIndex}][text]" placeholder="Link Text"
                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="removeQuickLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex space-x-2">
                        <select onchange="updateUrlField(this)" class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select a page or enter custom URL</option>
                            @foreach($availablePages as $group => $pages)
                                <optgroup label="{{ $group }}">
                                    @foreach($pages as $url => $name)
                                        <option value="{{ $url }}">{{ $name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <input type="text" name="quick_links[${quickLinkIndex}][url]" placeholder="Or enter custom URL"
                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                `;
                container.appendChild(div);
                quickLinkIndex++;
            }

            function removeQuickLink(button) {
                button.closest('.quick-link-item').remove();
            }

            function addCustomerServiceLink() {
                const container = document.getElementById('customer-service-links-container');
                const div = document.createElement('div');
                div.className = 'customer-service-link-item space-y-2';
                div.innerHTML = `
                    <div class="flex space-x-2">
                        <input type="text" name="customer_service_links[${customerServiceLinkIndex}][text]" placeholder="Link Text"
                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="removeCustomerServiceLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex space-x-2">
                        <select onchange="updateUrlField(this)" class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select a page or enter custom URL</option>
                            @foreach($availablePages as $group => $pages)
                                <optgroup label="{{ $group }}">
                                    @foreach($pages as $url => $name)
                                        <option value="{{ $url }}">{{ $name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <input type="text" name="customer_service_links[${customerServiceLinkIndex}][url]" placeholder="Or enter custom URL"
                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                `;
                container.appendChild(div);
                customerServiceLinkIndex++;
            }

            function removeCustomerServiceLink(button) {
                button.closest('.customer-service-link-item').remove();
            }

            function addCategoriesLink() {
                const container = document.getElementById('categories-links-container');
                const div = document.createElement('div');
                div.className = 'categories-link-item space-y-2';
                div.innerHTML = `
                    <div class="flex space-x-2">
                        <input type="text" name="categories_links[${categoriesLinkIndex}][text]" placeholder="Link Text"
                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="removeCategoriesLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex space-x-2">
                        <select onchange="updateUrlField(this)" class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select a page or enter custom URL</option>
                            @foreach($availablePages as $group => $pages)
                                <optgroup label="{{ $group }}">
                                    @foreach($pages as $url => $name)
                                        <option value="{{ $url }}">{{ $name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <input type="text" name="categories_links[${categoriesLinkIndex}][url]" placeholder="Or enter custom URL"
                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                `;
                container.appendChild(div);
                categoriesLinkIndex++;
            }

            function removeCategoriesLink(button) {
                button.closest('.categories-link-item').remove();
            }



            function updateUrlField(selectElement) {
                const urlInput = selectElement.parentElement.querySelector('input[type="text"]');
                if (selectElement.value) {
                    urlInput.value = selectElement.value;
                }
            }

            // Section Management Functions
            function moveSection(button, direction) {
                const section = button.closest('[data-section]');
                const container = section.parentElement;

                if (direction === 'up') {
                    const prevSection = section.previousElementSibling;
                    if (prevSection && prevSection.hasAttribute('data-section')) {
                        container.insertBefore(section, prevSection);
                    }
                } else if (direction === 'down') {
                    const nextSection = section.nextElementSibling;
                    if (nextSection && nextSection.hasAttribute('data-section')) {
                        container.insertBefore(nextSection, section);
                    }
                }
            }

            function deleteSection(button) {
                if (confirm('Are you sure you want to delete this section? This action cannot be undone.')) {
                    const section = button.closest('[data-section]');
                    section.remove();
                }
            }

            let newSectionIndex = 1;
            function addNewSection() {
                const container = document.querySelector('.space-y-6');
                const addButton = container.querySelector('.border-dashed');

                const newSection = document.createElement('div');
                newSection.className = 'bg-white rounded-lg p-6 shadow-sm border border-gray-200';
                newSection.setAttribute('data-section', 'custom_' + newSectionIndex);

                newSection.innerHTML = `
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Custom Section \${newSectionIndex}</h3>
                        <div class="flex space-x-2">
                            <button type="button" onclick="moveSection(this, 'up')" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600" title="Move Up">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                </svg>
                            </button>
                            <button type="button" onclick="moveSection(this, 'down')" class="px-2 py-1 bg-gray-500 text-white rounded hover:bg-gray-600" title="Move Down">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <button type="button" onclick="deleteSection(this)" class="px-2 py-1 bg-red-600 text-white rounded hover:bg-red-700" title="Delete Section">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Section Title</label>
                        <input type="text" name="custom_sections[\${newSectionIndex}][title]" value="Custom Section \${newSectionIndex}"
                               placeholder="Section Title"
                               class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>

                    <div id="custom-\${newSectionIndex}-links-container" class="space-y-3">
                        <div class="custom-link-item space-y-2">
                            <div class="flex space-x-2">
                                <input type="text" name="custom_sections[\${newSectionIndex}][links][0][text]" placeholder="Link Text"
                                       class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <button type="button" onclick="removeCustomLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="flex space-x-2">
                                <input type="text" name="custom_sections[\${newSectionIndex}][links][0][url]" placeholder="Enter URL"
                                       class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>

                    <button type="button" onclick="addCustomLink(this, \${newSectionIndex})" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                        Add Link
                    </button>
                `;

                container.insertBefore(newSection, addButton);
                newSectionIndex++;
            }

            function addCustomLink(button, sectionIndex) {
                const container = button.parentElement.querySelector(`#custom-\${sectionIndex}-links-container`);
                const linkCount = container.children.length;

                const div = document.createElement('div');
                div.className = 'custom-link-item space-y-2';
                div.innerHTML = `
                    <div class="flex space-x-2">
                        <input type="text" name="custom_sections[\${sectionIndex}][links][\${linkCount}][text]" placeholder="Link Text"
                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="removeCustomLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="flex space-x-2">
                        <input type="text" name="custom_sections[\${sectionIndex}][links][\${linkCount}][url]" placeholder="Enter URL"
                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                `;
                container.appendChild(div);
            }

            function removeCustomLink(button) {
                button.closest('.custom-link-item').remove();
            }

            // Payment Icons Functions
            function addPaymentIcon() {
                const container = document.getElementById('payment-icons-container');
                const div = document.createElement('div');
                div.className = 'payment-icon-item space-y-3 p-4 border border-gray-200 rounded-lg';
                div.innerHTML = `
                    <div class="flex space-x-2">
                        <input type="text" name="payment_icons[${paymentIconIndex}][name]" placeholder="Payment Method Name"
                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <input type="text" name="payment_icons[${paymentIconIndex}][icon]" placeholder="Icon Name"
                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="removePaymentIcon(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Image Type Selection -->
                    <div class="space-y-2">
                        <label class="text-sm font-medium text-gray-700">Icon Type:</label>
                        <div class="flex space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="payment_icons[${paymentIconIndex}][image_type]" value="auto" checked
                                       onchange="toggleImageType(this, ${paymentIconIndex})"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Auto Generated</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="payment_icons[${paymentIconIndex}][image_type]" value="custom"
                                       onchange="toggleImageType(this, ${paymentIconIndex})"
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Custom Upload</span>
                            </label>
                        </div>
                    </div>

                    <!-- Custom Image Upload -->
                    <div id="custom-upload-${paymentIconIndex}" class="space-y-2 hidden">
                        <label class="text-sm font-medium text-gray-700">Upload Image (50x50px recommended):</label>
                        <input type="file" name="payment_icons[${paymentIconIndex}][custom_image]" accept="image/*"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                    </div>

                    <div class="flex space-x-2">
                        <select onchange="updateUrlField(this)" class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select payment method or enter custom URL</option>
                            @foreach($paymentPages as $group => $pages)
                                <optgroup label="{{ $group }}">
                                    @foreach($pages as $url => $name)
                                        <option value="{{ $url }}">{{ $name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <input type="text" name="payment_icons[${paymentIconIndex}][url]" placeholder="Or enter custom URL"
                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                `;
                container.appendChild(div);
                paymentIconIndex++;
            }

            function removePaymentIcon(button) {
                button.closest('.payment-icon-item').remove();
            }

            // App Download Functions
            function addAppDownload() {
                const container = document.getElementById('app-downloads-container');
                const div = document.createElement('div');
                div.className = 'app-download-item space-y-2';
                div.innerHTML = `
                    <div class="flex space-x-2">
                        <input type="text" name="app_download_links[${appDownloadIndex}][platform]" placeholder="Platform"
                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <input type="text" name="app_download_links[${appDownloadIndex}][icon]" placeholder="Icon"
                               class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <button type="button" onclick="removeAppDownload(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                    <input type="url" name="app_download_links[${appDownloadIndex}][url]" placeholder="Download URL"
                           class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                `;
                container.appendChild(div);
                appDownloadIndex++;
            }

            function removeAppDownload(button) {
                button.closest('.app-download-item').remove();
            }

            // Toggle Image Type Function
            function toggleImageType(radio, index) {
                const customUpload = document.getElementById('custom-upload-' + index);
                if (radio.value === 'custom') {
                    customUpload.classList.remove('hidden');
                } else {
                    customUpload.classList.add('hidden');
                }
            }
        </script>
    </x-slot>
</x-layouts.admin>
