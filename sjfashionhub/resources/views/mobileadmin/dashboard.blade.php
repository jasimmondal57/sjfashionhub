<x-layouts.mobileadmin>
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Welcome to Mobile App Admin! 📱</h1>
            <p class="text-gray-600 mt-2">Manage your mobile app configuration, content, and settings from here.</p>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Sections -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-blue-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Total Sections</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['total_sections'] }}</p>
                    </div>
                    <div class="bg-blue-100 rounded-full p-3">
                        <i class="fas fa-layer-group text-blue-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Active Sections -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-green-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Sections</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['active_sections'] }}</p>
                    </div>
                    <div class="bg-green-100 rounded-full p-3">
                        <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Active Banners -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-purple-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Active Banners</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['active_banners'] }}</p>
                    </div>
                    <div class="bg-purple-100 rounded-full p-3">
                        <i class="fas fa-image text-purple-600 text-2xl"></i>
                    </div>
                </div>
            </div>

            <!-- Menu Items -->
            <div class="bg-white rounded-xl shadow-sm p-6 border-l-4 border-orange-500">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-medium text-gray-600">Menu Items</p>
                        <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['menu_items'] }}</p>
                    </div>
                    <div class="bg-orange-100 rounded-full p-3">
                        <i class="fas fa-bars text-orange-600 text-2xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- API Information -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-600 rounded-xl shadow-lg p-6 mb-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold mb-2">API Base URL</h3>
                    <p class="font-mono text-sm bg-white bg-opacity-20 px-4 py-2 rounded inline-block">
                        {{ $stats['api_base_url'] }}/api/mobile
                    </p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-code text-3xl"></i>
                </div>
            </div>
        </div>

        <!-- Quick Actions Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- App Settings Card -->
            <a href="{{ route('mobileadmin.settings') }}" 
               class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-all transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="bg-blue-100 rounded-lg p-3">
                        <i class="fas fa-cog text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-900">App Settings</h3>
                </div>
                <p class="text-gray-600 text-sm mb-4">Configure API URL, app name, version, and general settings</p>
                <div class="flex items-center text-blue-600 font-medium">
                    <span>Configure</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            <!-- Home Sections Card -->
            <a href="{{ route('mobileadmin.sections.index') }}"
               class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-all transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="bg-green-100 rounded-lg p-3">
                        <i class="fas fa-layer-group text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-900">Home Sections</h3>
                </div>
                <p class="text-gray-600 text-sm mb-4">Add, edit, or remove sections displayed on app home screen</p>
                <div class="flex items-center text-green-600 font-medium">
                    <span>Manage Sections</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            <!-- Body Sections Card -->
            <a href="{{ route('mobileadmin.sections.index') }}"
               class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-all transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="bg-orange-100 rounded-lg p-3">
                        <i class="fas fa-th-large text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-900">Body Sections</h3>
                </div>
                <p class="text-gray-600 text-sm mb-4">Create dynamic body sections with categories and specific products</p>
                <div class="flex items-center text-orange-600 font-medium">
                    <span>Manage Body Sections</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            <!-- Banners Card -->
            <a href="{{ route('mobileadmin.banners.index') }}" 
               class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-all transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="bg-purple-100 rounded-lg p-3">
                        <i class="fas fa-image text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-900">Banners</h3>
                </div>
                <p class="text-gray-600 text-sm mb-4">Manage promotional banners and carousel images</p>
                <div class="flex items-center text-purple-600 font-medium">
                    <span>Manage Banners</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            <!-- Navigation Menu Card -->
            <a href="{{ route('mobileadmin.menu.index') }}" 
               class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-all transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="bg-orange-100 rounded-lg p-3">
                        <i class="fas fa-bars text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-900">Navigation Menu</h3>
                </div>
                <p class="text-gray-600 text-sm mb-4">Configure bottom navigation and drawer menu items</p>
                <div class="flex items-center text-orange-600 font-medium">
                    <span>Manage Menu</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            <!-- Theme & Colors Card -->
            <a href="{{ route('mobileadmin.theme') }}" 
               class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-all transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="bg-pink-100 rounded-lg p-3">
                        <i class="fas fa-palette text-pink-600 text-2xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-900">Theme & Colors</h3>
                </div>
                <p class="text-gray-600 text-sm mb-4">Customize app colors, theme, and visual appearance</p>
                <div class="flex items-center text-pink-600 font-medium">
                    <span>Customize Theme</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>

            <!-- Push Notifications Card -->
            <a href="{{ route('mobileadmin.notifications.index') }}" 
               class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-all transform hover:-translate-y-1">
                <div class="flex items-center mb-4">
                    <div class="bg-red-100 rounded-lg p-3">
                        <i class="fas fa-bell text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="ml-3 text-lg font-semibold text-gray-900">Push Notifications</h3>
                </div>
                <p class="text-gray-600 text-sm mb-4">Send push notifications to app users</p>
                <div class="flex items-center text-red-600 font-medium">
                    <span>Send Notifications</span>
                    <i class="fas fa-arrow-right ml-2"></i>
                </div>
            </a>
        </div>

        <!-- Help Section -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Getting Started</h3>
                    <ul class="text-blue-800 text-sm space-y-1">
                        <li>• Configure your API base URL in <strong>App Settings</strong></li>
                        <li>• Add promotional banners in <strong>Banners</strong> section</li>
                        <li>• Customize home screen layout in <strong>Home Sections</strong></li>
                        <li>• Set your brand colors in <strong>Theme & Colors</strong></li>
                        <li>• Configure navigation in <strong>Navigation Menu</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.mobileadmin>

