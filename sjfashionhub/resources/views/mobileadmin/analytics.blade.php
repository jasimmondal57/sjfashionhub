<x-layouts.mobileadmin>
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">📊 App Analytics</h1>
            <p class="text-gray-600 mt-1">Monitor mobile app usage and performance</p>
        </div>

        <!-- Overview Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Total Downloads</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                        <p class="text-xs text-green-600 mt-1">
                            <i class="fas fa-arrow-up mr-1"></i>Coming Soon
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-download text-blue-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Active Users</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                        <p class="text-xs text-green-600 mt-1">
                            <i class="fas fa-arrow-up mr-1"></i>Coming Soon
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-users text-green-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">App Sessions</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">0</p>
                        <p class="text-xs text-green-600 mt-1">
                            <i class="fas fa-arrow-up mr-1"></i>Coming Soon
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-mobile-alt text-purple-600 text-xl"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600">Avg. Session Time</p>
                        <p class="text-2xl font-bold text-gray-900 mt-1">0m</p>
                        <p class="text-xs text-green-600 mt-1">
                            <i class="fas fa-arrow-up mr-1"></i>Coming Soon
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-indigo-600 text-xl"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Distribution -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Platform Distribution</h2>
                <div class="space-y-4">
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">
                                <i class="fab fa-android text-green-600 mr-2"></i>Android
                            </span>
                            <span class="text-sm font-semibold text-gray-900">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm font-medium text-gray-700">
                                <i class="fab fa-apple text-gray-800 mr-2"></i>iOS
                            </span>
                            <span class="text-sm font-semibold text-gray-900">0%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-gray-800 h-2 rounded-full" style="width: 0%"></div>
                        </div>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-4 text-center">Analytics data will be available once the app is live</p>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Top Screens</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-home text-purple-600"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Home</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">0 views</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-shopping-bag text-blue-600"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Products</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">0 views</span>
                    </div>

                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-shopping-cart text-green-600"></i>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Cart</span>
                        </div>
                        <span class="text-sm font-semibold text-gray-900">0 views</span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-4 text-center">Analytics data will be available once the app is live</p>
            </div>
        </div>

        <!-- User Engagement -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">User Engagement (Last 7 Days)</h2>
            <div class="h-64 flex items-center justify-center bg-gray-50 rounded-lg">
                <div class="text-center text-gray-400">
                    <i class="fas fa-chart-line text-5xl mb-4"></i>
                    <p class="text-lg font-medium">Analytics Chart Coming Soon</p>
                    <p class="text-sm mt-2">Integrate with Firebase Analytics or Google Analytics</p>
                </div>
            </div>
        </div>

        <!-- Info Box -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="fas fa-info-circle text-blue-600 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <h3 class="text-sm font-semibold text-blue-900 mb-2">Analytics Integration</h3>
                    <p class="text-sm text-blue-800">
                        To enable full analytics tracking, integrate Firebase Analytics or Google Analytics in your Flutter app. 
                        The analytics data will automatically appear here once users start using the app.
                    </p>
                    <div class="mt-3">
                        <a href="https://firebase.google.com/docs/analytics" 
                           target="_blank"
                           class="text-sm font-medium text-blue-600 hover:text-blue-700">
                            Learn more about Firebase Analytics <i class="fas fa-external-link-alt ml-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.mobileadmin>

