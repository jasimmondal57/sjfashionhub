<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">📱 Mobile App Admin</h1>
                        <p class="text-gray-600 mt-1">Manage your mobile app configuration and content</p>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                            <i class="fas fa-layer-group text-blue-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Total Sections</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['total_sections'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                            <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Active Sections</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['active_sections'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                            <i class="fas fa-image text-purple-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Active Banners</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['active_banners'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-orange-100 rounded-lg p-3">
                            <i class="fas fa-bars text-orange-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-600">Menu Items</p>
                            <p class="text-2xl font-bold text-gray-900">{{ $stats['menu_items'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Settings Card -->
                <a href="{{ route('admin.mobile.settings') }}" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 bg-blue-100 rounded-lg p-3">
                            <i class="fas fa-cog text-blue-600 text-xl"></i>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">App Settings</h3>
                    </div>
                    <p class="text-gray-600 text-sm">Configure API URL, app name, theme colors, and general settings</p>
                    <div class="mt-4">
                        <span class="text-blue-600 text-sm font-medium">Manage Settings →</span>
                    </div>
                </a>

                <!-- Sections Card -->
                <a href="{{ route('admin.mobile.sections') }}" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 bg-green-100 rounded-lg p-3">
                            <i class="fas fa-layer-group text-green-600 text-xl"></i>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">Home Sections</h3>
                    </div>
                    <p class="text-gray-600 text-sm">Add, edit, or remove sections on the app home screen</p>
                    <div class="mt-4">
                        <span class="text-green-600 text-sm font-medium">Manage Sections →</span>
                    </div>
                </a>

                <!-- Banners Card -->
                <a href="{{ route('admin.mobile.banners') }}" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 bg-purple-100 rounded-lg p-3">
                            <i class="fas fa-image text-purple-600 text-xl"></i>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">Banners</h3>
                    </div>
                    <p class="text-gray-600 text-sm">Manage promotional banners and sliders</p>
                    <div class="mt-4">
                        <span class="text-purple-600 text-sm font-medium">Manage Banners →</span>
                    </div>
                </a>

                <!-- Menu Card -->
                <a href="{{ route('admin.mobile.menu') }}" class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 bg-orange-100 rounded-lg p-3">
                            <i class="fas fa-bars text-orange-600 text-xl"></i>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">Navigation Menu</h3>
                    </div>
                    <p class="text-gray-600 text-sm">Configure bottom navigation and drawer menu items</p>
                    <div class="mt-4">
                        <span class="text-orange-600 text-sm font-medium">Manage Menu →</span>
                    </div>
                </a>

                <!-- API Documentation Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 bg-indigo-100 rounded-lg p-3">
                            <i class="fas fa-code text-indigo-600 text-xl"></i>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold text-gray-900">API Endpoints</h3>
                    </div>
                    <p class="text-gray-600 text-sm mb-2">Mobile app API base URL:</p>
                    <code class="bg-gray-100 px-3 py-1 rounded text-sm">{{ url('/api/mobile') }}</code>
                </div>

                <!-- App Preview Card -->
                <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-sm p-6 text-white">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 bg-white bg-opacity-20 rounded-lg p-3">
                            <i class="fas fa-mobile-alt text-white text-xl"></i>
                        </div>
                        <h3 class="ml-3 text-lg font-semibold">App Preview</h3>
                    </div>
                    <p class="text-white text-opacity-90 text-sm">Download the mobile app to see your changes in real-time</p>
                    <div class="mt-4 flex gap-2">
                        <span class="bg-white bg-opacity-20 px-3 py-1 rounded text-sm">Android</span>
                        <span class="bg-white bg-opacity-20 px-3 py-1 rounded text-sm">iOS</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>

