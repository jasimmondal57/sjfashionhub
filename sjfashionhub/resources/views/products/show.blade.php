<x-layouts.main>
    <x-slot name="title">{{ $product->seo_title ?? $product->name . ' - SJ Fashion Hub' }}</x-slot>
    <x-slot name="description">{{ $product->meta_description ?? $product->short_description ?? $product->description }}</x-slot>
    <x-slot name="keywords">{{ $product->meta_keywords }}</x-slot>
    @if($product->structured_data)
    <x-slot name="structuredData">{!! json_encode($product->structured_data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</x-slot>
    @endif

    <!-- Breadcrumb -->
    <section class="bg-gray-50 py-4">
        <div class="container-custom">
            <nav class="text-sm">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-black">Home</a></li>
                    <li class="text-gray-400">/</li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-600 hover:text-black">Shop</a></li>
                    <li class="text-gray-400">/</li>
                    <li><a href="{{ route('categories.show', $product->category) }}" class="text-gray-600 hover:text-black">{{ $product->category->name }}</a></li>
                    <li class="text-gray-400">/</li>
                    <li class="text-black font-medium">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Product Detail -->
    <section class="py-8">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Product Images -->
                <div class="space-y-4">
                    <!-- Main Image -->
                    <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                        @if($product->main_image)
                            <img src="{{ $product->main_image }}" alt="{{ $product->name }}" 
                                 class="w-full h-full object-cover" id="main-image">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-24 h-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnail Images -->
                    @if($product->images && count($product->images) > 1)
                    <div class="grid grid-cols-4 gap-2">
                        @foreach($product->images as $index => $image)
                        <button class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 {{ $index === 0 ? 'border-black' : 'border-transparent' }} hover:border-gray-400 transition-colors"
                                onclick="changeMainImage('{{ $image }}', this)">
                            <img src="{{ $image }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-6">
                    <!-- Product Title & Category -->
                    <div>
                        <p class="text-sm text-gray-600 mb-2">{{ $product->category->name }}</p>
                        <h1 class="text-3xl font-bold text-black mb-4">{{ $product->name }}</h1>
                        
                        <!-- Price -->
                        <div class="flex items-center space-x-4 mb-4">
                            @if($product->is_on_sale)
                            <span class="text-3xl font-bold text-black">{{ $product->formatted_sale_price }}</span>
                            <span class="text-xl text-gray-500 line-through">{{ $product->formatted_price }}</span>
                            <span class="bg-red-500 text-white text-sm px-2 py-1 rounded">{{ $product->discount_percentage }}% OFF</span>
                            @else
                            <span class="text-3xl font-bold text-black">{{ $product->formatted_price }}</span>
                            @endif
                        </div>

                        <!-- Stock Status -->
                        @if($product->stock_quantity > 0)
                        <p class="text-green-600 text-sm font-medium">✓ In Stock ({{ $product->stock_quantity }} available)</p>
                        @else
                        <p class="text-red-600 text-sm font-medium">✗ Out of Stock</p>
                        @endif
                    </div>

                    <!-- Short Description -->
                    @if($product->short_description)
                    <div>
                        <p class="text-gray-700 leading-relaxed">{{ $product->short_description }}</p>
                    </div>
                    @endif

                    <!-- Product Variants -->
                    @if($product->size || $product->color || $product->material || $product->pattern)
                    <div>
                        <h3 class="font-semibold text-lg mb-3">Product Details</h3>

                        <div class="grid grid-cols-2 gap-4 text-sm">
                            @if($product->size)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Size:</span>
                                <span class="font-medium text-gray-900">{{ $product->size }}</span>
                            </div>
                            @endif

                            @if($product->color)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Color:</span>
                                <span class="font-medium text-gray-900">{{ $product->color }}</span>
                            </div>
                            @endif

                            @if($product->material)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Material:</span>
                                <span class="font-medium text-gray-900">{{ $product->material }}</span>
                            </div>
                            @endif

                            @if($product->pattern)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Pattern:</span>
                                <span class="font-medium text-gray-900">{{ $product->pattern }}</span>
                            </div>
                            @endif

                            @if($product->brand)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Brand:</span>
                                <span class="font-medium text-gray-900">{{ $product->brand }}</span>
                            </div>
                            @endif

                            @if($product->gender)
                            <div class="flex items-center justify-between py-2 border-b border-gray-100">
                                <span class="text-gray-600">Gender:</span>
                                <span class="font-medium text-gray-900 capitalize">{{ $product->gender }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Quantity & Add to Cart -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                            <div class="flex items-center space-x-3">
                                <button class="w-10 h-10 border border-gray-300 rounded-md flex items-center justify-center hover:bg-gray-50" onclick="decreaseQuantity()">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}" 
                                       class="w-20 text-center border border-gray-300 rounded-md py-2">
                                <button class="w-10 h-10 border border-gray-300 rounded-md flex items-center justify-center hover:bg-gray-50" onclick="increaseQuantity()">+</button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 items-center">
                            @if($product->stock_quantity > 0)
                            <div class="flex-1">
                                <x-animated-order-button
                                    text="Add to Cart"
                                    success-text="Added to Cart!"
                                    id="add-to-cart-btn"
                                    class="w-full"
                                />
                            </div>
                            @else
                            <button class="btn btn-primary flex-1 py-3 text-lg opacity-50 cursor-not-allowed" disabled>Out of Stock</button>
                            @endif
                            <button class="btn btn-outline py-3 px-6">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                Add to Wishlist
                            </button>
                        </div>
                    </div>

                    <!-- Product Features -->
                    <div class="border-t border-gray-200 pt-6">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Free Shipping</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Easy Returns</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Secure Payment</span>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <span>Quality Assured</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Description -->
    <section class="py-8 border-t border-gray-200">
        <div class="container-custom">
            <div class="max-w-4xl mx-auto">
                <h2 class="text-2xl font-bold text-black mb-6">Product Description</h2>
                <div class="prose prose-gray max-w-none">
                    @if($product->long_description)
                        <div class="text-gray-700 leading-relaxed">{!! nl2br(e($product->long_description)) !!}</div>
                    @else
                        <p class="text-gray-700 leading-relaxed">{{ $product->description }}</p>
                    @endif
                    
                    @if($product->attributes)
                    <div class="mt-6">
                        <h3 class="text-lg font-semibold mb-3">Product Details</h3>
                        <ul class="space-y-2">
                            @foreach($product->attributes as $key => $value)
                            <li class="flex">
                                <span class="font-medium text-gray-900 w-32">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                <span class="text-gray-700">{{ $value }}</span>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <section class="py-16 bg-gray-50">
        <div class="container-custom">
            <h2 class="text-2xl font-bold text-black mb-8">You May Also Like</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $relatedProduct)
                <div class="product-card group">
                    <div class="relative">
                        <a href="{{ route('products.show', $relatedProduct) }}">
                            <div class="aspect-square bg-gray-100 rounded-t-lg flex items-center justify-center overflow-hidden">
                                @if($relatedProduct->main_image)
                                    <img src="{{ $relatedProduct->main_image }}" alt="{{ $relatedProduct->name }}" 
                                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                            </div>
                        </a>
                        @if($relatedProduct->is_on_sale)
                        <span class="product-badge product-badge-sale">{{ $relatedProduct->discount_percentage }}% OFF</span>
                        @endif
                    </div>
                    <div class="p-4">
                        <a href="{{ route('products.show', $relatedProduct) }}">
                            <h3 class="font-medium text-black mb-2 line-clamp-2 group-hover:text-gray-700">{{ $relatedProduct->name }}</h3>
                        </a>

                        <!-- Product Variants Info -->
                        @if($relatedProduct->size || $relatedProduct->color || $relatedProduct->material)
                        <div class="flex flex-wrap gap-1 mb-3">
                            @if($relatedProduct->size)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ $relatedProduct->size }}
                                </span>
                            @endif
                            @if($relatedProduct->color)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $relatedProduct->color }}
                                </span>
                            @endif
                            @if($relatedProduct->material)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                    {{ $relatedProduct->material }}
                                </span>
                            @endif
                        </div>
                        @endif

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-2">
                                @if($relatedProduct->is_on_sale)
                                <span class="text-lg font-semibold text-black">{{ $relatedProduct->formatted_sale_price }}</span>
                                <span class="text-sm text-gray-500 line-through">{{ $relatedProduct->formatted_price }}</span>
                                @else
                                <span class="text-lg font-semibold text-black">{{ $relatedProduct->formatted_price }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    @push('scripts')
    <script>
        function changeMainImage(imageSrc, button) {
            document.getElementById('main-image').src = imageSrc;

            // Update active thumbnail
            document.querySelectorAll('[onclick*="changeMainImage"]').forEach(btn => {
                btn.classList.remove('border-black');
                btn.classList.add('border-transparent');
            });
            button.classList.remove('border-transparent');
            button.classList.add('border-black');
        }

        function increaseQuantity() {
            const input = document.getElementById('quantity');
            const max = parseInt(input.getAttribute('max'));
            const current = parseInt(input.value);
            if (current < max) {
                input.value = current + 1;
            }
        }

        function decreaseQuantity() {
            const input = document.getElementById('quantity');
            const current = parseInt(input.value);
            if (current > 1) {
                input.value = current - 1;
            }
        }

        // Handle animated order button
        document.addEventListener('DOMContentLoaded', function() {
            const addToCartBtn = document.getElementById('add-to-cart-btn');

            if (addToCartBtn) {
                addToCartBtn.addEventListener('click', function(e) {
                    e.preventDefault();

                    // Get form data
                    const quantity = document.getElementById('quantity').value;
                    const productId = {{ $product->id }};

                    // Get selected size and color if available
                    const selectedSize = document.querySelector('button.border-black')?.textContent?.trim();
                    const selectedColor = document.querySelector('button[style*="background-color"]:focus')?.title;

                    // Simulate adding to cart (replace with actual AJAX call)
                    console.log('Adding to cart:', {
                        product_id: productId,
                        quantity: quantity,
                        size: selectedSize,
                        color: selectedColor
                    });

                    // Here you would normally make an AJAX call to add to cart
                    // For now, we'll just let the animation play
                });

                // Listen for animation completion
                addToCartBtn.addEventListener('orderAnimationComplete', function(e) {
                    console.log('Order animation completed!');
                    // You could redirect to cart page or show a success message here
                });
            }
        });
    </script>
    @endpush
</x-layouts.main>
