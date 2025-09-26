<x-layouts.admin>
    <x-slot name="title">SEO Management Dashboard</x-slot>
    <x-slot name="description">Manage AI-powered SEO content for products and categories</x-slot>
    <x-slot name="pageTitle">🤖 AI-Powered SEO Management</x-slot>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg border border-gray-100 p-6 hover:shadow-sm transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Products</p>
                    <p class="text-2xl font-bold text-black">{{ $stats['total_products'] }}</p>
                </div>
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    </div>
                </div>

        <div class="bg-white rounded-lg border border-gray-100 p-6 hover:shadow-sm transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Products with SEO</p>
                    <p class="text-2xl font-bold text-black">{{ $stats['products_with_seo'] }}</p>
                    <p class="text-xs text-gray-500">{{ round(($stats['products_with_seo'] / max($stats['total_products'], 1)) * 100) }}% coverage</p>
                </div>
                <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-100 p-6 hover:shadow-sm transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Total Categories</p>
                    <p class="text-2xl font-bold text-black">{{ $stats['total_categories'] }}</p>
                </div>
                <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-100 p-6 hover:shadow-sm transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600">Categories with SEO</p>
                    <p class="text-2xl font-bold text-black">{{ $stats['categories_with_seo'] }}</p>
                    <p class="text-xs text-gray-500">{{ round(($stats['categories_with_seo'] / max($stats['total_categories'], 1)) * 100) }}% coverage</p>
                </div>
                <div class="w-12 h-12 bg-black rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-black mb-4">🚀 Quick Actions</h3>
            <div class="space-y-3">
                <button onclick="bulkGenerate('products')" class="w-full btn btn-primary">
                    Generate SEO for All Products
                </button>
                <button onclick="bulkGenerate('categories')" class="w-full btn btn-secondary">
                    Generate SEO for All Categories
                </button>
                <div class="flex space-x-3">
                    <a href="#" class="flex-1 btn btn-outline">
                        Manage Products
                            </a>
                            <a href="{{ route('admin.seo.categories') }}" class="flex-1 btn btn-outline">
                                Manage Categories
                            </a>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">📊 SEO Features</h3>
                    <div class="space-y-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">AI-generated SEO titles (50-60 chars)</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">Meta descriptions (150-160 chars)</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">Enhanced product descriptions</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">Targeted meta keywords</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">JSON-LD structured data</span>
                        </div>
                        <div class="flex items-center space-x-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                            <span class="text-sm text-gray-700">Automatic regeneration on updates</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">📦 Recently Updated Products</h3>
                    @if($recentProducts->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentProducts as $product)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-black">{{ $product->name }}</p>
                                <p class="text-sm text-gray-600">{{ $product->category->name }}</p>
                                <p class="text-xs text-gray-500">{{ $product->seo_generated_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">SEO Ready</span>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-4">No products with SEO content yet</p>
                    @endif
                </div>

                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">📂 Recently Updated Categories</h3>
                    @if($recentCategories->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentCategories as $category)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div>
                                <p class="font-medium text-black">{{ $category->name }}</p>
                                <p class="text-xs text-gray-500">{{ $category->seo_generated_at->diffForHumans() }}</p>
                            </div>
                            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">SEO Ready</span>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-gray-500 text-center py-4">No categories with SEO content yet</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function bulkGenerate(type) {
            if (!confirm(`Are you sure you want to generate SEO content for all ${type}? This may take a few minutes.`)) {
                return;
            }

            const button = event.target;
            const originalText = button.textContent;
            button.textContent = 'Generating...';
            button.disabled = true;

            fetch('{{ route("admin.seo.bulk.generate") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    type: type,
                    force: false
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    location.reload();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                alert('Error: ' + error.message);
            })
            .finally(() => {
                button.textContent = originalText;
                button.disabled = false;
            });
        }
    </script>
</x-layouts.admin>
