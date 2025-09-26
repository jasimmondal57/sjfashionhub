<x-layouts.admin title="Footer Settings" description="Manage footer content and settings">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Footer Settings</h1>
                <p class="text-gray-100">Manage footer content, links, and appearance</p>
            </div>
            <a href="{{ route('admin.footer-settings.edit') }}" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2h-5m-1.414-1.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Footer Settings
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                {{ session('success') }}
            </div>
        @endif

        <!-- Footer Preview -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-medium text-gray-900">Footer Preview</h2>
                <p class="text-sm text-gray-600">This is how your footer currently appears on the website</p>
            </div>
            
            <div class="p-6">
                <!-- Footer Content Preview -->
                <div class="bg-gray-50 rounded-lg p-6" style="background-color: {{ $footerSetting->background_color }}; color: {{ $footerSetting->text_color }};">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        <!-- About Store -->
                        <div>
                            <h3 class="font-semibold text-lg mb-4">{{ $footerSetting->company_name }}</h3>
                            <p class="text-sm leading-relaxed opacity-80">
                                {{ $footerSetting->company_description }}
                            </p>
                        </div>

                        <!-- Quick Links -->
                        @if($footerSetting->quick_links && count($footerSetting->quick_links) > 0)
                        <div>
                            <h3 class="font-semibold text-lg mb-4">Quick Links</h3>
                            <ul class="space-y-2">
                                @foreach($footerSetting->quick_links as $link)
                                <li>
                                    <a href="{{ $link['url'] }}" class="text-sm opacity-80 hover:opacity-100 transition-opacity">
                                        {{ $link['text'] }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Customer Service -->
                        @if($footerSetting->customer_service_links && count($footerSetting->customer_service_links) > 0)
                        <div>
                            <h3 class="font-semibold text-lg mb-4">Customer Service</h3>
                            <ul class="space-y-2">
                                @foreach($footerSetting->customer_service_links as $link)
                                <li>
                                    <a href="{{ $link['url'] }}" class="text-sm opacity-80 hover:opacity-100 transition-opacity">
                                        {{ $link['text'] }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif

                        <!-- Categories -->
                        @if($footerSetting->categories_links && count($footerSetting->categories_links) > 0)
                        <div>
                            <h3 class="font-semibold text-lg mb-4">Categories</h3>
                            <ul class="space-y-2">
                                @foreach($footerSetting->categories_links as $link)
                                <li>
                                    <a href="{{ $link['url'] }}" class="text-sm opacity-80 hover:opacity-100 transition-opacity">
                                        {{ $link['text'] }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                    </div>

                    <!-- Contact Info -->
                    @if($footerSetting->contact_info)
                    <div class="mt-8 pt-8 border-t border-opacity-20" style="border-color: {{ $footerSetting->text_color }};">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if($footerSetting->contact_info['phone'] ?? null)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                <span class="text-sm">{{ $footerSetting->contact_info['phone'] }}</span>
                            </div>
                            @endif

                            @if($footerSetting->contact_info['email'] ?? null)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                <span class="text-sm">{{ $footerSetting->contact_info['email'] }}</span>
                            </div>
                            @endif

                            @if($footerSetting->contact_info['address'] ?? null)
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 opacity-80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span class="text-sm">{{ $footerSetting->contact_info['address'] }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Social Links -->
                    @if($footerSetting->show_social_links && $footerSetting->social_links && count($footerSetting->social_links) > 0)
                    <div class="mt-6 flex space-x-4">
                        @foreach($footerSetting->social_links as $social)
                        <a href="{{ $social['url'] }}" class="opacity-80 hover:opacity-100 transition-opacity">
                            <span class="sr-only">{{ $social['platform'] }}</span>
                            <div class="w-6 h-6 bg-current rounded"></div>
                        </a>
                        @endforeach
                    </div>
                    @endif

                    <!-- Payment Methods -->
                    @if($footerSetting->show_payment_methods && $footerSetting->payment_methods && count($footerSetting->payment_methods) > 0)
                    <div class="mt-6">
                        <p class="text-sm opacity-80 mb-2">We Accept:</p>
                        <div class="flex space-x-2">
                            @foreach($footerSetting->payment_methods as $method)
                            <div class="bg-white rounded px-2 py-1">
                                <span class="text-xs text-gray-600">{{ $method['name'] }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Copyright -->
                    <div class="mt-8 pt-8 border-t border-opacity-20 text-center text-sm opacity-80" style="border-color: {{ $footerSetting->text_color }};">
                        {{ $footerSetting->copyright_text }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Settings Summary -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Company Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Company Information</h3>
                <div class="space-y-3">
                    <div>
                        <span class="text-sm font-medium text-gray-500">Company Name:</span>
                        <p class="text-gray-900">{{ $footerSetting->company_name }}</p>
                    </div>
                    <div>
                        <span class="text-sm font-medium text-gray-500">Description:</span>
                        <p class="text-gray-900 text-sm">{{ Str::limit($footerSetting->company_description, 100) }}</p>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                <div class="space-y-3">
                    @if($footerSetting->contact_info['phone'] ?? null)
                    <div>
                        <span class="text-sm font-medium text-gray-500">Phone:</span>
                        <p class="text-gray-900">{{ $footerSetting->contact_info['phone'] }}</p>
                    </div>
                    @endif
                    @if($footerSetting->contact_info['email'] ?? null)
                    <div>
                        <span class="text-sm font-medium text-gray-500">Email:</span>
                        <p class="text-gray-900">{{ $footerSetting->contact_info['email'] }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Display Settings -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Display Settings</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Newsletter Section:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $footerSetting->show_newsletter ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $footerSetting->show_newsletter ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Social Links:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $footerSetting->show_social_links ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $footerSetting->show_social_links ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Payment Methods:</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $footerSetting->show_payment_methods ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $footerSetting->show_payment_methods ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
