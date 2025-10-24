<x-layouts.main>
    <x-slot name="title">Shop All Products - SJ Fashion Hub</x-slot>
    <x-slot name="description">Browse our complete collection of fashion products. Find the perfect style for every occasion with free shipping on orders above ₹999.</x-slot>

    <!-- Breadcrumb -->
    <section class="bg-gray-50 py-4">
        <div class="container-custom">
            <nav class="text-sm">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-black">Home</a></li>
                    <li class="text-gray-400">/</li>
                    <li class="text-black font-medium">Shop</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-8">
        <div class="container-custom">
            <div class="flex flex-col lg:flex-row gap-8">
                <!-- Sidebar Filters -->
                <aside class="lg:w-1/4">
                    <div class="bg-white rounded-lg border border-gray-200 p-6 sticky top-4">
                        <h3 class="font-semibold text-lg mb-6">Filters</h3>
                        
                        <form method="GET" action="{{ route('products.index') }}" id="filter-form">
                            <!-- Search -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                                <input type="text" name="search" value="{{ request('search') }}" 
                                       placeholder="Search products..." 
                                       class="form-input">
                            </div>

                            <!-- Categories -->
                            @if($categories->count() > 0)
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Categories</label>
                                <div class="space-y-2">
                                    @foreach($categories as $category)
                                    <label class="flex items-center">
                                        <input type="radio" name="category" value="{{ $category->id }}" 
                                               {{ request('category') == $category->id ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-black focus:ring-black">
                                        <span class="ml-2 text-sm text-gray-700">{{ $category->name }}</span>
                                    </label>
                                    @endforeach
                                    <label class="flex items-center">
                                        <input type="radio" name="category" value="" 
                                               {{ !request('category') ? 'checked' : '' }}
                                               class="rounded border-gray-300 text-black focus:ring-black">
                                        <span class="ml-2 text-sm text-gray-700">All Categories</span>
                                    </label>
                                </div>
                            </div>
                            @endif

                            <!-- Price Range -->
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                                <div class="grid grid-cols-2 gap-2">
                                    <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                           placeholder="Min" class="form-input">
                                    <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                           placeholder="Max" class="form-input">
                                </div>
                            </div>

                            <!-- Apply Filters Button -->
                            <button type="submit" class="btn btn-primary w-full">Apply Filters</button>
                            
                            <!-- Clear Filters -->
                            @if(request()->hasAny(['search', 'category', 'min_price', 'max_price']))
                            <a href="{{ route('products.index') }}" class="btn btn-outline w-full mt-2">Clear Filters</a>
                            @endif
                        </form>
                    </div>
                </aside>

                <!-- Products Grid -->
                <main class="lg:w-3/4">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                        <div>
                            <h1 class="text-2xl font-bold text-black mb-2">All Products</h1>
                            <p class="text-gray-600">{{ $products->total() }} products found</p>
                        </div>
                        
                        <!-- Sort Options -->
                        <div class="mt-4 sm:mt-0">
                            <form method="GET" action="{{ route('products.index') }}" class="flex items-center space-x-2">
                                <!-- Preserve existing filters -->
                                @foreach(request()->except(['sort', 'page']) as $key => $value)
                                    <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                                @endforeach
                                
                                <label class="text-sm text-gray-700">Sort by:</label>
                                <select name="sort" onchange="this.form.submit()" class="form-select">
                                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                    <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>Featured</option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                                </select>
                            </form>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                        @foreach($products as $product)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden group hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                            <div class="relative">
                                <a href="{{ route('products.show', $product) }}">
                                    <div class="aspect-square bg-gray-100 flex items-center justify-center overflow-hidden">
                                        @if($product->main_image)
                                            <img src="{{ $product->main_image }}" alt="{{ $product->name }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                </a>
                                
                                <!-- Badges -->
                                @if($product->is_on_sale)
                                <span class="product-badge product-badge-sale">
                                    {{ $product->discount_percentage }}% OFF
                                </span>
                                @endif
                                @if($product->is_featured)
                                <span class="product-badge {{ $product->is_on_sale ? 'top-10' : '' }}">Featured</span>
                                @endif
                                
                                <!-- Quick Actions -->
                                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button class="p-2 bg-white rounded-full shadow-md hover:bg-gray-50 mb-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="p-4">
                                <a href="{{ route('products.show', $product) }}">
                                    <h3 class="font-medium text-black mb-2 line-clamp-2 group-hover:text-gray-700">{{ $product->name }}</h3>
                                </a>
                                <p class="text-sm text-gray-600 mb-2">{{ $product->category->name }}</p>

                                <!-- Product Variants Info -->
                                @if($product->size || $product->color || $product->material)
                                <div class="flex flex-wrap gap-1 mb-3">
                                    @if($product->size)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $product->size }}
                                        </span>
                                    @endif
                                    @if($product->color)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            {{ $product->color }}
                                        </span>
                                    @endif
                                    @if($product->material)
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            {{ $product->material }}
                                        </span>
                                    @endif
                                </div>
                                @endif

                                <div class="flex items-center justify-between mb-3">
                                    <div class="flex items-center space-x-2">
                                        @if($product->is_on_sale)
                                        <span class="text-lg font-semibold text-black">{{ $product->formatted_sale_price }}</span>
                                        <span class="text-sm text-gray-500 line-through">{{ $product->formatted_price }}</span>
                                        @else
                                        <span class="text-lg font-semibold text-black">{{ $product->formatted_price }}</span>
                                        @endif
                                    </div>
                                </div>
                                <!-- Action Buttons -->
                                <div class="flex space-x-2">
                                    <button onclick="addToCartWithAnimation({{ $product->id }}, this)" class="cart-button flex-1 text-xs py-2 px-3 rounded transition-colors" style="background-color: #111827 !important; color: white !important; border: none !important;" onmouseover="this.style.backgroundColor='#374151'" onmouseout="this.style.backgroundColor='#111827'">
                                        <span class="button-text">Add to Cart</span>
                                        <span class="loading-text" style="display: none;">Adding...</span>
                                        <span class="success-text" style="display: none;">Added! ✓</span>
                                    </button>
                                    <button onclick="buyNow({{ $product->id }})" class="flex-1 text-xs py-2 px-3 rounded transition-colors" style="background-color: #4f46e5 !important; color: white !important; border: none !important;" onmouseover="this.style.backgroundColor='#4338ca'" onmouseout="this.style.backgroundColor='#4f46e5'">
                                        Buy Now
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center">
                        {{ $products->appends(request()->query())->links() }}
                    </div>
                    @else
                    <!-- No Products Found -->
                    <div class="text-center py-12">
                        <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <h3 class="text-xl font-medium text-gray-900 mb-2">No products found</h3>
                        <p class="text-gray-600 mb-4">Try adjusting your search or filter criteria.</p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary">View All Products</a>
                    </div>
                    @endif
                </main>
            </div>
        </div>
    </section>

    <script>
        // Add to cart with animation
        function addToCartWithAnimation(productId, button) {
            const buttonText = button.querySelector('.button-text');
            const loadingText = button.querySelector('.loading-text');
            const successText = button.querySelector('.success-text');

            // Show loading state
            buttonText.style.display = 'none';
            loadingText.style.display = 'inline';
            button.disabled = true;

            // Make AJAX request to add to cart
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Show success state
                    loadingText.style.display = 'none';
                    successText.style.display = 'inline';

                    // Update cart count if element exists
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount && data.cart_count) {
                        cartCount.textContent = data.cart_count;
                        cartCount.style.display = data.cart_count > 0 ? 'inline' : 'none';
                    }

                    // Reset button after 2 seconds
                    setTimeout(() => {
                        successText.style.display = 'none';
                        buttonText.style.display = 'inline';
                        button.disabled = false;
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Failed to add to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to add to cart. Please try again.');

                // Reset button
                loadingText.style.display = 'none';
                buttonText.style.display = 'inline';
                button.disabled = false;
            });
        }

        // Buy now function
        function buyNow(productId) {
            // Add to cart first, then redirect to checkout
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    quantity: 1
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirect to checkout
                    window.location.href = '/checkout';
                } else {
                    throw new Error(data.message || 'Failed to add to cart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to process order. Please try again.');
            });
        }
    </script>
</x-layouts.main>
