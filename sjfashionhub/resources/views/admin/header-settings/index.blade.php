<x-layouts.admin title="Header Settings" description="Manage website header settings">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-black">Header Settings</h1>
                <p class="text-gray-600">Manage your website header configuration</p>
            </div>
            <div class="flex space-x-3">
                <form action="{{ route('admin.header-settings.reset') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" onclick="return confirm('Are you sure you want to reset header settings to default? This will remove any custom logo and reset all settings.')" class="btn btn-secondary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset to Default
                    </button>
                </form>
                <a href="{{ route('admin.header-settings.edit') }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Settings
                </a>
            </div>
        </div>

        <!-- Current Header Preview -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-medium text-black mb-4">Current Header Preview</h3>
            <div class="border border-gray-300 rounded-md overflow-hidden">
                <!-- Header Preview -->
                <div class="bg-white border-b border-gray-200 {{ $headerSetting->sticky_header ? 'sticky top-0 z-50' : '' }}">
                    <div class="container mx-auto px-4">
                        <div class="flex items-center justify-between py-4">
                            <!-- Logo -->
                            <div class="flex items-center">
                                @if($headerSetting->logo_image)
                                    <img src="{{ Storage::url($headerSetting->logo_image) }}" alt="{{ $headerSetting->site_name }}" class="h-8 w-auto">
                                @else
                                    <span class="text-xl font-bold text-black">{{ $headerSetting->logo_text ?? $headerSetting->site_name }}</span>
                                @endif
                            </div>

                            <!-- Navigation -->
                            @if($headerSetting->navigation_menu && count($headerSetting->navigation_menu) > 0)
                                <nav class="hidden md:flex space-x-8">
                                    @foreach($headerSetting->navigation_menu as $item)
                                        @if($item['is_active'] ?? true)
                                            <a href="{{ $item['url'] }}" class="text-gray-700 hover:text-black font-medium">
                                                {{ $item['text'] }}
                                            </a>
                                        @endif
                                    @endforeach
                                </nav>
                            @endif

                            <!-- Header Actions -->
                            <div class="flex items-center space-x-4">
                                @if($headerSetting->show_search)
                                    <div class="hidden md:block">
                                        <input type="text" placeholder="{{ $headerSetting->search_placeholder }}" class="px-3 py-2 border border-gray-300 rounded-md text-sm">
                                    </div>
                                @endif
                                
                                @if($headerSetting->show_account)
                                    <button class="text-gray-700 hover:text-black">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </button>
                                @endif
                                
                                @if($headerSetting->show_wishlist)
                                    <button class="text-gray-700 hover:text-black relative">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                @endif
                                
                                @if($headerSetting->show_cart)
                                    <button class="text-gray-700 hover:text-black relative">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.293 2.293A1 1 0 005 16v0a1 1 0 001 1h11M9 19a2 2 0 11-4 0 2 2 0 014 0zm8 0a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                        </svg>
                                        <span class="absolute -top-2 -right-2 bg-black text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-500">This is how your header currently appears on the website</p>
        </div>

        <!-- Settings Overview -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Basic Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Site Name</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $headerSetting->site_name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Logo</label>
                        @if($headerSetting->logo_image)
                            <div class="mt-1 flex items-center space-x-3">
                                <img src="{{ Storage::url($headerSetting->logo_image) }}" alt="Logo" class="h-8 w-auto">
                                <span class="text-sm text-gray-500">Image Logo</span>
                            </div>
                        @else
                            <p class="mt-1 text-sm text-gray-900">{{ $headerSetting->logo_text ?? 'Text Logo: ' . $headerSetting->site_name }}</p>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Header Style</label>
                        <p class="mt-1 text-sm text-gray-900 capitalize">{{ $headerSetting->header_style }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sticky Header</label>
                        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $headerSetting->sticky_header ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $headerSetting->sticky_header ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Features -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Header Features</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Search Bar</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $headerSetting->show_search ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $headerSetting->show_search ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Wishlist Icon</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $headerSetting->show_wishlist ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $headerSetting->show_wishlist ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Shopping Cart</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $headerSetting->show_cart ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $headerSetting->show_cart ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-700">Account Menu</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $headerSetting->show_account ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $headerSetting->show_account ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                    
                    @if($headerSetting->show_search)
                        <div class="pt-2 border-t border-gray-200">
                            <label class="block text-sm font-medium text-gray-700">Search Placeholder</label>
                            <p class="mt-1 text-sm text-gray-500">"{{ $headerSetting->search_placeholder }}"</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        @if($headerSetting->navigation_menu && count($headerSetting->navigation_menu) > 0)
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Navigation Menu ({{ count($headerSetting->navigation_menu) }} items)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Text</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($headerSetting->navigation_menu as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $item['text'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item['url'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ ($item['is_active'] ?? true) ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ($item['is_active'] ?? true) ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <!-- Contact Info & Social Links -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Contact Information -->
            @if($headerSetting->contact_info)
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-medium text-black mb-4">Contact Information</h3>
                    <div class="space-y-3">
                        @if($headerSetting->contact_info['phone'] ?? null)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="text-sm text-gray-900">{{ $headerSetting->contact_info['phone'] }}</span>
                            </div>
                        @endif
                        
                        @if($headerSetting->contact_info['email'] ?? null)
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-400 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm text-gray-900">{{ $headerSetting->contact_info['email'] }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <!-- Social Links -->
            @if($headerSetting->social_links && count($headerSetting->social_links) > 0)
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-medium text-black mb-4">Social Media Links</h3>
                    <div class="space-y-3">
                        @foreach($headerSetting->social_links as $link)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-900">{{ $link['platform'] }}</span>
                                </div>
                                <a href="{{ $link['url'] }}" target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                                    Visit Link
                                    <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
