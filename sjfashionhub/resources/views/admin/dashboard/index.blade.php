<x-layouts.admin>
    <x-slot name="title">Dashboard - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">Admin dashboard with overview and analytics</x-slot>
    <x-slot name="pageTitle">📊 Dashboard</x-slot>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Products -->
        <div class="bg-white rounded-lg border border-gray-100 p-6 hover:shadow-sm transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-2xl font-bold text-black">{{ $stats['total_products'] }}</p>
                    <p class="text-xs text-gray-500">{{ $stats['active_products'] }} active</p>
                </div>
                <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Total Categories -->
        <div class="bg-white rounded-lg border border-gray-100 p-6 hover:shadow-sm transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Categories</p>
                    <p class="text-2xl font-bold text-black">{{ $stats['total_categories'] }}</p>
                    <p class="text-xs text-gray-500">Product categories</p>
                </div>
                <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- SEO Coverage -->
        <div class="bg-white rounded-lg border border-gray-100 p-6 hover:shadow-sm transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">SEO Coverage</p>
                    <p class="text-2xl font-bold text-black">{{ round(($stats['products_with_seo'] / max($stats['total_products'], 1)) * 100) }}%</p>
                    <p class="text-xs text-gray-500">{{ $stats['products_with_seo'] }}/{{ $stats['total_products'] }} products</p>
                </div>
                <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Revenue (Placeholder) -->
        <div class="bg-white rounded-lg border border-gray-100 p-6 hover:shadow-sm transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Revenue</p>
                    <p class="text-2xl font-bold text-black">₹0</p>
                    <p class="text-xs text-gray-500">Coming soon</p>
                </div>
                <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-black mb-4">🚀 Quick Actions</h3>
            <div class="space-y-3">
                <a href="{{ route('admin.products.create') }}" class="w-full btn btn-primary">
                    Add New Product
                </a>
                <a href="{{ route('admin.categories.create') }}" class="w-full btn btn-secondary">
                    Add New Category
                </a>
                <a href="{{ route('admin.seo.index') }}" class="w-full btn btn-outline">
                    Manage SEO Content
                </a>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.products.index') }}" class="flex-1 btn btn-outline">
                        View Products
                    </a>
                    <a href="{{ route('admin.orders.index') }}" class="flex-1 btn btn-outline">
                        View Orders
                    </a>
                </div>
            </div>
        </div>

        <!-- System Status -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-black mb-4">⚡ System Status</h3>
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Laravel Version</span>
                    <span class="text-sm font-medium text-black">{{ app()->version() }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">PHP Version</span>
                    <span class="text-sm font-medium text-black">{{ PHP_VERSION }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Database</span>
                    <span class="text-sm font-medium text-black">SQLite</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">AI SEO Service</span>
                    <span class="text-sm font-medium text-green-600">✓ Active</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Cache</span>
                    <span class="text-sm font-medium text-green-600">✓ Enabled</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Products & Low Stock -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Products -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-black">📦 Recent Products</h3>
                <a href="{{ route('admin.products.index') }}" class="text-sm text-gray-600 hover:text-black">View All</a>
            </div>
            <div class="space-y-3">
                @forelse($recent_products as $product)
                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                        <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-black">{{ $product->name }}</p>
                            <p class="text-xs text-gray-500">{{ $product->category->name ?? 'No Category' }} • ₹{{ number_format($product->price, 2) }}</p>
                        </div>
                        <span class="text-xs text-gray-400">{{ $product->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">No products yet</p>
                @endforelse
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-black">⚠️ Low Stock Alert</h3>
                <span class="text-sm text-gray-600">< 10 items</span>
            </div>
            <div class="space-y-3">
                @forelse($low_stock_products as $product)
                    <div class="flex items-center space-x-3 p-3 bg-red-50 rounded-lg">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-black">{{ $product->name }}</p>
                            <p class="text-xs text-red-600">Only {{ $product->stock_quantity }} left</p>
                        </div>
                        <a href="{{ route('admin.products.edit', $product) }}" class="text-xs text-blue-600 hover:text-blue-800">Update</a>
                    </div>
                @empty
                    <p class="text-gray-500 text-center py-4">All products are well stocked! 🎉</p>
                @endforelse
            </div>
        </div>
    </div>
</x-layouts.admin>
