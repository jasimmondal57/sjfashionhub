<x-layouts.admin>
    <x-slot name="title">AI Blog Generator</x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">AI Blog Generator</h1>
                <p class="text-gray-600 mt-1">Generate SEO-optimized blog posts using AI based on your products</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.blog.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Blog
                </a>
            </div>
        </div>

        <!-- AI Status Check -->
        <div id="ai-status" class="mb-6"></div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Total Products</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['total_products'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-100 rounded-lg">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">AI Posts Generated</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['ai_posts_generated'] }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="p-2 bg-green-100 rounded-lg">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-600">Products with Blogs</p>
                        <p class="text-2xl font-semibold text-gray-900">{{ $stats['products_with_blogs'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <button onclick="loadProductsWithoutBlogs()" class="flex items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-purple-500 hover:bg-purple-50 transition-colors">
                    <div class="text-center">
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-900">Generate for Products Without Blogs</p>
                        <p class="text-xs text-gray-500">Find products that need blog content</p>
                    </div>
                </button>
                
                <a href="{{ route('admin.blog.ai.create') }}" class="flex items-center justify-center p-4 border-2 border-dashed border-gray-300 rounded-lg hover:border-blue-500 hover:bg-blue-50 transition-colors">
                    <div class="text-center">
                        <svg class="w-8 h-8 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        <p class="text-sm font-medium text-gray-900">Custom AI Generation</p>
                        <p class="text-xs text-gray-500">Choose specific product and settings</p>
                    </div>
                </a>
            </div>
        </div>

        <!-- Recent AI Generated Posts -->
        @if($recentAiPosts->count() > 0)
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent AI Generated Posts</h2>
            <div class="space-y-4">
                @foreach($recentAiPosts as $post)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            @if($post->featured_image)
                                <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-12 h-12 rounded-lg object-cover mr-4">
                            @endif
                            <div>
                                <h3 class="font-medium text-gray-900">{{ Str::limit($post->title, 60) }}</h3>
                                <div class="flex items-center space-x-2 mt-1">
                                    @if($post->product)
                                        <span class="text-xs text-blue-600">{{ $post->product->name }}</span>
                                    @endif
                                    @if($post->category)
                                        <span class="text-xs text-gray-500">• {{ $post->category->name }}</span>
                                    @endif
                                    <span class="text-xs text-gray-500">• {{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <a href="{{ route('admin.blog.edit', $post) }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                            <a href="{{ route('admin.blog.show', $post) }}" class="text-green-600 hover:text-green-800 text-sm">View</a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Product Selection -->
        <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Select Product for AI Blog Generation</h2>
                <p class="text-sm text-gray-600 mt-1">Choose a product to generate an AI-powered blog post</p>
            </div>

            <div class="p-6">
                <!-- Search and Filter -->
                <div class="mb-6">
                    <div class="flex space-x-4">
                        <div class="flex-1">
                            <input type="text" id="product-search" placeholder="Search products..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        <div>
                            <select id="category-filter" class="px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="products-grid">
                    @foreach($products as $product)
                        <div class="product-card border border-gray-200 rounded-lg overflow-hidden hover:shadow-lg transition-shadow" 
                             data-category="{{ $product->category_id }}" data-name="{{ strtolower($product->name) }}">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ $product->images[0]['image_path'] }}" alt="{{ $product->name }}" 
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="p-4">
                                <h3 class="font-medium text-gray-900 mb-2">{{ Str::limit($product->name, 40) }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $product->category->name }}</p>
                                <p class="text-lg font-semibold text-gray-900 mb-3">{{ $product->formatted_price }}</p>
                                
                                @if($product->blogPosts->count() > 0)
                                    <div class="mb-3">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $product->blogPosts->count() }} Blog{{ $product->blogPosts->count() > 1 ? 's' : '' }}
                                        </span>
                                    </div>
                                @endif
                                
                                <a href="{{ route('admin.blog.ai.create', ['product_id' => $product->id]) }}" 
                                   class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                    Generate Blog
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Check AI status on page load
        document.addEventListener('DOMContentLoaded', function() {
            checkAiStatus();
        });

        function checkAiStatus() {
            fetch('{{ route("admin.blog.ai.status") }}')
                .then(response => response.json())
                .then(data => {
                    const statusDiv = document.getElementById('ai-status');
                    if (data.configured) {
                        statusDiv.innerHTML = `
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-green-800 font-medium">${data.message}</span>
                                </div>
                            </div>
                        `;
                    } else {
                        statusDiv.innerHTML = `
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 text-red-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-red-800 font-medium">${data.message}</span>
                                </div>
                            </div>
                        `;
                    }
                })
                .catch(error => {
                    console.error('Error checking AI status:', error);
                });
        }

        // Product search and filter functionality
        const searchInput = document.getElementById('product-search');
        const categoryFilter = document.getElementById('category-filter');
        const productCards = document.querySelectorAll('.product-card');

        function filterProducts() {
            const searchTerm = searchInput.value.toLowerCase();
            const selectedCategory = categoryFilter.value;

            productCards.forEach(card => {
                const productName = card.dataset.name;
                const productCategory = card.dataset.category;
                
                const matchesSearch = productName.includes(searchTerm);
                const matchesCategory = !selectedCategory || productCategory === selectedCategory;
                
                if (matchesSearch && matchesCategory) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterProducts);
        categoryFilter.addEventListener('change', filterProducts);

        function loadProductsWithoutBlogs() {
            fetch('{{ route("admin.blog.ai.products-without-blogs") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.products.length > 0) {
                        // Hide all products first
                        productCards.forEach(card => {
                            card.style.display = 'none';
                        });
                        
                        // Show only products without blogs
                        data.products.forEach(product => {
                            const card = document.querySelector(`[data-product-id="${product.id}"]`);
                            if (card) {
                                card.style.display = 'block';
                            }
                        });
                        
                        // Clear filters
                        searchInput.value = '';
                        categoryFilter.value = '';
                        
                        alert(`Found ${data.products.length} products without blog posts.`);
                    } else {
                        alert('All products already have blog posts!');
                    }
                })
                .catch(error => {
                    console.error('Error loading products:', error);
                    alert('Error loading products without blogs.');
                });
        }
    </script>
</x-layouts.admin>
