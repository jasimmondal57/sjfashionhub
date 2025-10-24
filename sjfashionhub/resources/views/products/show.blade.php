<x-layouts.main>
    <x-slot name="title">{{ $product->seo_title ?? $product->name . ' - SJ Fashion Hub' }}</x-slot>
    <x-slot name="description">{{ $product->meta_description ?? $product->short_description ?? $product->description }}</x-slot>
    <x-slot name="keywords">{{ $product->meta_keywords }}</x-slot>
    @if($product->structured_data)
    <x-slot name="structuredData">{!! json_encode($product->structured_data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</x-slot>
    @endif

    <!-- Breadcrumb -->
    <section class="bg-gray-50 py-3 md:py-4">
        <div class="container mx-auto px-4">
            <nav class="text-xs md:text-sm">
                <ol class="flex items-center space-x-1 md:space-x-2 overflow-x-auto">
                    <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 whitespace-nowrap">Home</a></li>
                    <li class="text-gray-400">/</li>
                    <li><a href="{{ route('products.index') }}" class="text-gray-600 hover:text-gray-900 whitespace-nowrap">Shop</a></li>
                    <li class="text-gray-400">/</li>
                    <li><a href="{{ route('categories.show', $product->category) }}" class="text-gray-600 hover:text-gray-900 whitespace-nowrap">{{ $product->category->name }}</a></li>
                    <li class="text-gray-400">/</li>
                    <li class="text-gray-900 font-medium truncate">{{ $product->name }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Product Detail -->
    <section class="py-6 md:py-8">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 lg:gap-12">
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
                    @if($product->image_urls && count($product->image_urls) > 1)
                    <div class="grid grid-cols-3 md:grid-cols-4 gap-2">
                        @foreach($product->image_urls as $index => $imageUrl)
                        <button class="aspect-square bg-gray-100 rounded-lg overflow-hidden border-2 {{ $index === 0 ? 'border-black' : 'border-transparent' }} hover:border-gray-400 transition-colors"
                                onclick="changeMainImage('{{ $imageUrl }}', this)">
                            <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        </button>
                        @endforeach
                    </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="space-y-4 md:space-y-6">
                    <!-- Product Title & Category -->
                    <div>
                        <p class="text-xs md:text-sm text-gray-600 mb-2">{{ $product->category->name }}</p>
                        <h1 class="text-xl md:text-2xl lg:text-3xl font-bold text-gray-900 mb-3 md:mb-4">{{ $product->name }}</h1>

                        <!-- Price -->
                        <div class="flex items-center flex-wrap gap-2 md:gap-4 mb-3 md:mb-4">
                            @if($product->is_on_sale)
                            <span class="text-2xl md:text-3xl font-bold text-gray-900">{{ $product->formatted_sale_price }}</span>
                            <span class="text-lg md:text-xl text-gray-500 line-through">{{ $product->formatted_price }}</span>
                            <span class="bg-red-500 text-white text-xs md:text-sm px-2 py-1 rounded">{{ $product->discount_percentage }}% OFF</span>
                            @else
                            <span class="text-2xl md:text-3xl font-bold text-gray-900">{{ $product->formatted_price }}</span>
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

                    <!-- Size Chart Button -->
                    @if($product->sizeChart)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <button onclick="openSizeChartModal()" class="flex items-center justify-center w-full text-blue-700 hover:text-blue-900 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            📏 View Size Guide
                        </button>
                    </div>
                    @endif

                    <!-- Size Variant Selector (for products with variants) -->
                    @if($product->productVariants && $product->productVariants->count() > 0)
                    <div>
                        <h3 class="font-semibold text-lg mb-2">Select Size</h3>
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($product->productVariants as $index => $variant)
                                @if($variant->is_active)
                                <button
                                    type="button"
                                    onclick="selectVariant({{ $variant->id }}, '{{ $variant->option1_value }}', {{ $variant->price }}, {{ $variant->stock_quantity }}, this)"
                                    class="variant-btn px-4 py-2 border-2 rounded-lg font-medium transition-all duration-200 hover:border-black hover:bg-gray-50 {{ $index === 0 ? 'border-black bg-gray-50' : 'border-gray-300' }}"
                                    data-variant-id="{{ $variant->id }}"
                                    data-stock="{{ $variant->stock_quantity }}">
                                    {{ $variant->option1_value }}
                                    @if($variant->stock_quantity <= 0)
                                        <span class="text-xs text-red-600 ml-1">(Out of Stock)</span>
                                    @elseif($variant->stock_quantity < 5)
                                        <span class="text-xs text-orange-600 ml-1">({{ $variant->stock_quantity }} left)</span>
                                    @endif
                                </button>
                                @endif
                            @endforeach
                        </div>
                        <input type="hidden" id="selected_variant_id" value="{{ $product->productVariants->first()->id }}">
                        <input type="hidden" id="selected_variant_size" value="{{ $product->productVariants->first()->option1_value }}">
                    </div>
                    @endif

                    <!-- Product Details -->
                    @if($product->size || $product->color || $product->material || $product->pattern || $product->brand)
                    <div>
                        <h3 class="font-semibold text-lg mb-3">Product Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 md:gap-4 text-sm">
                            @if($product->size && (!$product->productVariants || $product->productVariants->count() === 0))
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

                    <!-- Delivery Pincode Checker -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4 mb-4">
                        <div class="flex items-center mb-3">
                            <svg class="w-5 h-5 text-gray-700 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <h3 class="text-sm font-semibold text-gray-900">Check Delivery</h3>
                        </div>
                        <div class="flex gap-2">
                            <input type="text"
                                   id="delivery-pincode"
                                   placeholder="Enter Pincode"
                                   maxlength="6"
                                   pattern="[0-9]{6}"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                   value="{{ session('delivery_pincode', '') }}">
                            <button onclick="checkDelivery()"
                                    id="check-delivery-btn"
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors text-sm font-medium whitespace-nowrap">
                                Check
                            </button>
                        </div>
                        <div id="delivery-result" class="mt-3 text-sm"></div>
                    </div>

                    <!-- Quantity & Add to Cart -->
                    <div class="space-y-3 md:space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                            <div class="flex items-center space-x-3">
                                <button class="w-10 h-10 md:w-12 md:h-12 border border-gray-300 rounded-md flex items-center justify-center hover:bg-gray-50 text-lg" onclick="decreaseQuantity()">-</button>
                                <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                       class="w-16 md:w-20 text-center border border-gray-300 rounded-md py-2 text-base">
                                <button class="w-10 h-10 md:w-12 md:h-12 border border-gray-300 rounded-md flex items-center justify-center hover:bg-gray-50 text-lg" onclick="increaseQuantity()">+</button>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 md:gap-4 items-center">
                            @if($product->stock_quantity > 0)
                            <button onclick="addToCartWithAnimation({{ $product->id }}, this)" class="cart-button w-full sm:flex-1 py-3 px-4 md:px-6 rounded transition-colors bg-gray-900 text-white hover:bg-gray-800 text-sm md:text-base font-medium">
                                <span class="button-text">Add to Cart</span>
                                <span class="loading-text" style="display: none;">Adding...</span>
                                <span class="success-text" style="display: none;">Added! ✓</span>
                            </button>
                            <button onclick="buyNow({{ $product->id }})" class="w-full sm:flex-1 py-3 px-4 md:px-6 rounded transition-colors bg-blue-600 text-white hover:bg-blue-700 text-sm md:text-base font-medium">
                                Buy Now
                            </button>
                            @else
                            <button class="w-full py-3 px-4 md:px-6 rounded bg-gray-400 text-white opacity-50 cursor-not-allowed text-sm md:text-base font-medium" disabled>Out of Stock</button>
                            @endif
                        </div>

                        <!-- Wishlist & Share Buttons -->
                        <div class="mt-3 md:mt-4 flex gap-3">
                            <button onclick="toggleWishlist({{ $product->id }}, this)"
                                    class="wishlist-btn flex-1 py-3 px-4 md:px-6 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center justify-center text-sm md:text-base"
                                    data-product-id="{{ $product->id }}"
                                    data-in-wishlist="{{ Auth::check() && Auth::user()->wishlists()->where('product_id', $product->id)->exists() ? 'true' : 'false' }}">
                                <svg class="w-4 h-4 md:w-5 md:h-5 mr-2 wishlist-icon" fill="{{ Auth::check() && Auth::user()->wishlists()->where('product_id', $product->id)->exists() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span class="wishlist-text">{{ Auth::check() && Auth::user()->wishlists()->where('product_id', $product->id)->exists() ? 'In Wishlist' : 'Add to Wishlist' }}</span>
                            </button>
                            <button onclick="shareProduct()" class="py-3 px-4 md:px-6 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors flex items-center justify-center text-sm md:text-base">
                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                                </svg>
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

    <!-- Product Tabs Section -->
    <section class="py-8 border-t border-gray-200">
        <div class="container mx-auto px-4">
            <div class="max-w-6xl mx-auto">
                <!-- Tab Navigation -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="flex flex-wrap -mb-px" role="tablist">
                        <button class="tab-button active px-4 md:px-6 py-3 md:py-4 text-sm md:text-base font-medium border-b-2 border-black text-black"
                                onclick="switchTab(event, 'description')" role="tab">
                            Description
                        </button>
                        <button class="tab-button px-4 md:px-6 py-3 md:py-4 text-sm md:text-base font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300"
                                onclick="switchTab(event, 'specifications')" role="tab">
                            Specifications
                        </button>
                        @if($product->sizeChart)
                        <button class="tab-button px-4 md:px-6 py-3 md:py-4 text-sm md:text-base font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300"
                                onclick="switchTab(event, 'sizeguide')" role="tab">
                            Size Guide
                        </button>
                        @endif
                        <button class="tab-button px-4 md:px-6 py-3 md:py-4 text-sm md:text-base font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300"
                                onclick="switchTab(event, 'reviews')" role="tab">
                            Reviews <span class="ml-1 text-xs">(0)</span>
                        </button>
                        <button class="tab-button px-4 md:px-6 py-3 md:py-4 text-sm md:text-base font-medium border-b-2 border-transparent text-gray-600 hover:text-gray-900 hover:border-gray-300"
                                onclick="switchTab(event, 'shipping')" role="tab">
                            Shipping & Returns
                        </button>
                    </nav>
                </div>

                <!-- Tab Content -->
                <div class="tab-content-wrapper">
                    <!-- Description Tab -->
                    <div id="description" class="tab-content active">
                        <div class="prose prose-gray max-w-none">
                            @if($product->long_description)
                                <div class="text-gray-700 leading-relaxed text-sm md:text-base">{!! nl2br(e($product->long_description)) !!}</div>
                            @else
                                <p class="text-gray-700 leading-relaxed text-sm md:text-base">{{ $product->description }}</p>
                            @endif

                            @if($product->attributes)
                            <div class="mt-6">
                                <h3 class="text-lg font-semibold mb-3">Additional Details</h3>
                                <ul class="space-y-2">
                                    @foreach($product->attributes as $key => $value)
                                    <li class="flex flex-col sm:flex-row text-sm md:text-base">
                                        <span class="font-medium text-gray-900 sm:w-48">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                        <span class="text-gray-700">{{ $value }}</span>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Specifications Tab -->
                    <div id="specifications" class="tab-content hidden">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @if($product->material)
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50 w-1/3">Material</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $product->material }}</td>
                                    </tr>
                                    @endif
                                    @if($product->pattern)
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">Pattern</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $product->pattern }}</td>
                                    </tr>
                                    @endif
                                    @if($product->color)
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">Color</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $product->color }}</td>
                                    </tr>
                                    @endif
                                    @if($product->size)
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">Size</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $product->size }}</td>
                                    </tr>
                                    @endif
                                    @if($product->brand)
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">Brand</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $product->brand }}</td>
                                    </tr>
                                    @endif
                                    @if($product->gender)
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">Gender</td>
                                        <td class="px-4 py-3 text-sm text-gray-700 capitalize">{{ $product->gender }}</td>
                                    </tr>
                                    @endif
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">SKU</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">{{ $product->sku }}</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">Care Instructions</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">Machine wash cold, Do not bleach, Tumble dry low</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 py-3 text-sm font-medium text-gray-900 bg-gray-50">Country of Origin</td>
                                        <td class="px-4 py-3 text-sm text-gray-700">India</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Size Guide Tab -->
                    @if($product->sizeChart)
                    <div id="sizeguide" class="tab-content hidden">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold text-gray-900 mb-2">{{ $product->sizeChart->name }}</h3>
                            @if($product->sizeChart->description)
                            <p class="text-gray-600 text-sm mb-4">{{ $product->sizeChart->description }}</p>
                            @endif
                        </div>

                        @if(isset($product->sizeChart->size_data['headers']) && isset($product->sizeChart->size_data['rows']))
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        @foreach($product->sizeChart->size_data['headers'] as $header)
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200 last:border-r-0">
                                            {{ $header }}
                                        </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($product->sizeChart->size_data['rows'] as $row)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                            {{ $row['size'] ?? '' }}
                                        </td>
                                        @if(isset($row['measurements']))
                                            @foreach($row['measurements'] as $measurement)
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200 last:border-r-0">
                                                {{ $measurement }}
                                            </td>
                                            @endforeach
                                        @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="font-semibold text-gray-900 mb-2">📐 How to Measure</h4>
                            <ul class="text-sm text-gray-700 space-y-1">
                                <li>• <strong>Chest/Bust:</strong> Measure around the fullest part of your chest, keeping the tape horizontal</li>
                                <li>• <strong>Waist:</strong> Measure around your natural waistline</li>
                                <li>• <strong>Hip:</strong> Measure around the fullest part of your hips</li>
                                <li>• <strong>Length:</strong> Measure from the highest point of shoulder to desired hem length</li>
                                <li class="mt-2 text-xs text-gray-600">💡 Tip: If you're between sizes, we recommend sizing up for a comfortable fit</li>
                            </ul>
                        </div>
                        @endif
                    </div>
                    @endif

                    <!-- Reviews Tab -->
                    <div id="reviews" class="tab-content hidden">
                        <div class="text-center py-12">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">No Reviews Yet</h3>
                            <p class="text-gray-600 mb-6">Be the first to review this product!</p>
                            <button class="bg-black text-white px-6 py-3 rounded-lg hover:bg-gray-800 transition-colors">
                                Write a Review
                            </button>
                        </div>
                    </div>

                    <!-- Shipping & Returns Tab -->
                    <div id="shipping" class="tab-content hidden">
                        <div class="grid md:grid-cols-2 gap-8">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                    </svg>
                                    Shipping Information
                                </h3>
                                <ul class="space-y-3 text-sm text-gray-700">
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Free Shipping</strong> on all orders above ₹499</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Standard Delivery:</strong> 5-7 business days</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Express Delivery:</strong> 2-3 business days (Additional charges apply)</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>Cash on Delivery</strong> available</span>
                                    </li>
                                </ul>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                    <svg class="w-6 h-6 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Returns & Exchange
                                </h3>
                                <ul class="space-y-3 text-sm text-gray-700">
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span><strong>7-Day Easy Returns</strong> - No questions asked</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Free return pickup from your doorstep</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Exchange available for size and color</span>
                                    </li>
                                    <li class="flex items-start">
                                        <svg class="w-5 h-5 text-blue-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <span>Refund processed within 5-7 business days</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-8 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <p class="text-sm text-yellow-800">
                                <strong>Note:</strong> For hygiene reasons, certain products like innerwear and swimwear are not eligible for returns or exchanges.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Size Chart Modal -->
    @if($product->sizeChart)
    <div id="sizeChartModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4" onclick="closeSizeChartModal(event)">
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto" onclick="event.stopPropagation()">
            <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between">
                <h3 class="text-xl font-bold text-gray-900">{{ $product->sizeChart->name }}</h3>
                <button onclick="closeSizeChartModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="p-6">
                @if($product->sizeChart->description)
                <p class="text-gray-600 mb-6">{{ $product->sizeChart->description }}</p>
                @endif

                @if(isset($product->sizeChart->size_data['headers']) && isset($product->sizeChart->size_data['rows']))
                <div class="overflow-x-auto mb-6">
                    <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                @foreach($product->sizeChart->size_data['headers'] as $header)
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border-r border-gray-200 last:border-r-0">
                                    {{ $header }}
                                </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($product->sizeChart->size_data['rows'] as $row)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 border-r border-gray-200">
                                    {{ $row['size'] ?? '' }}
                                </td>
                                @if(isset($row['measurements']))
                                    @foreach($row['measurements'] as $measurement)
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 border-r border-gray-200 last:border-r-0">
                                        {{ $measurement }}
                                    </td>
                                    @endforeach
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif

                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h4 class="font-semibold text-gray-900 mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        How to Measure
                    </h4>
                    <ul class="text-sm text-gray-700 space-y-2">
                        <li>• <strong>Chest/Bust:</strong> Measure around the fullest part of your chest, keeping the tape horizontal</li>
                        <li>• <strong>Waist:</strong> Measure around your natural waistline, keeping the tape comfortably loose</li>
                        <li>• <strong>Hip:</strong> Measure around the fullest part of your hips</li>
                        <li>• <strong>Shoulder:</strong> Measure from one shoulder point to the other across the back</li>
                        <li>• <strong>Length:</strong> Measure from the highest point of shoulder to desired hem length</li>
                        <li class="mt-3 pt-3 border-t border-blue-200">
                            <strong>💡 Sizing Tip:</strong> If you're between sizes, we recommend sizing up for a more comfortable fit.
                            For a fitted look, choose the smaller size.
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

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

        // Add to cart with animation
        function addToCartWithAnimation(productId, button) {
            const buttonText = button.querySelector('.button-text');
            const loadingText = button.querySelector('.loading-text');
            const successText = button.querySelector('.success-text');

            // Get form data
            const quantity = document.getElementById('quantity').value || 1;

            // Get variant info if exists
            const variantIdInput = document.getElementById('selected_variant_id');
            const variantSizeInput = document.getElementById('selected_variant_size');
            const selectedVariantId = variantIdInput ? variantIdInput.value : null;
            const selectedSize = variantSizeInput ? variantSizeInput.value : document.querySelector('button.border-black')?.textContent?.trim();
            const selectedColor = document.querySelector('button[style*="background-color"]:focus')?.title;

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
                    variant_id: selectedVariantId,
                    quantity: quantity,
                    size: selectedSize,
                    color: selectedColor
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

        // Delivery check function
        function checkDelivery() {
            const pincodeInput = document.getElementById('delivery-pincode');
            const resultDiv = document.getElementById('delivery-result');
            const checkBtn = document.getElementById('check-delivery-btn');
            const pincode = pincodeInput.value.trim();

            // Validate pincode
            if (!pincode || pincode.length !== 6 || !/^\d{6}$/.test(pincode)) {
                resultDiv.innerHTML = '<div class="text-red-600 flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Please enter a valid 6-digit pincode</div>';
                return;
            }

            // Show loading state
            checkBtn.disabled = true;
            checkBtn.innerHTML = '<svg class="animate-spin h-4 w-4 mx-auto" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            resultDiv.innerHTML = '<div class="text-gray-600">Checking...</div>';

            // Make API call
            fetch('{{ route("check.delivery") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    pincode: pincode,
                    weight: {{ $product->weight ?? 0.5 }}
                })
            })
            .then(response => response.json())
            .then(data => {
                checkBtn.disabled = false;
                checkBtn.innerHTML = 'Check';

                if (data.success && data.available) {
                    resultDiv.innerHTML = `
                        <div class="bg-green-50 border border-green-200 rounded-md p-3">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-green-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-green-800 font-medium">Delivery Available!</p>
                                    <p class="text-green-700 text-xs mt-1">Estimated delivery: <strong>${data.estimated_days} days</strong></p>
                                    ${data.cod_available ? '<p class="text-green-700 text-xs mt-1">✓ Cash on Delivery available</p>' : ''}
                                </div>
                            </div>
                        </div>
                    `;
                } else if (data.success && !data.available) {
                    resultDiv.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-md p-3">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 text-red-600 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                <div class="flex-1">
                                    <p class="text-red-800 font-medium">Delivery Not Available</p>
                                    <p class="text-red-700 text-xs mt-1">Sorry, we don't deliver to this pincode yet.</p>
                                </div>
                            </div>
                        </div>
                    `;
                } else {
                    resultDiv.innerHTML = `
                        <div class="text-orange-600 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            ${data.message || 'Unable to check delivery. Please try again.'}
                        </div>
                    `;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                checkBtn.disabled = false;
                checkBtn.innerHTML = 'Check';
                resultDiv.innerHTML = '<div class="text-red-600 flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>Error checking delivery. Please try again.</div>';
            });
        }

        // Allow Enter key to trigger check
        document.getElementById('delivery-pincode')?.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                checkDelivery();
            }
        });

        // Buy now function
        function buyNow(productId) {
            const quantity = document.getElementById('quantity').value || 1;

            // Get variant info if exists
            const variantIdInput = document.getElementById('selected_variant_id');
            const variantSizeInput = document.getElementById('selected_variant_size');
            const selectedVariantId = variantIdInput ? variantIdInput.value : null;
            const selectedSize = variantSizeInput ? variantSizeInput.value : document.querySelector('button.border-black')?.textContent?.trim();
            const selectedColor = document.querySelector('button[style*="background-color"]:focus')?.title;

            // Add to cart first, then redirect to checkout
            fetch('/cart/add', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    product_id: productId,
                    variant_id: selectedVariantId,
                    quantity: quantity,
                    size: selectedSize,
                    color: selectedColor
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

        // Tab Switching Function
        function switchTab(event, tabName) {
            // Hide all tab contents
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('active');
            });

            // Remove active class from all tab buttons
            const tabButtons = document.querySelectorAll('.tab-button');
            tabButtons.forEach(button => {
                button.classList.remove('active', 'border-black', 'text-black');
                button.classList.add('border-transparent', 'text-gray-600');
            });

            // Show selected tab content
            const selectedTab = document.getElementById(tabName);
            if (selectedTab) {
                selectedTab.classList.remove('hidden');
                selectedTab.classList.add('active');
            }

            // Add active class to clicked button
            event.currentTarget.classList.add('active', 'border-black', 'text-black');
            event.currentTarget.classList.remove('border-transparent', 'text-gray-600');
        }

        // Variant Selection Function
        function selectVariant(variantId, size, price, stock, button) {
            // Update hidden inputs
            document.getElementById('selected_variant_id').value = variantId;
            document.getElementById('selected_variant_size').value = size;

            // Update all variant buttons
            document.querySelectorAll('.variant-btn').forEach(btn => {
                btn.classList.remove('border-black', 'bg-gray-50');
                btn.classList.add('border-gray-300');
            });

            // Highlight selected button
            button.classList.remove('border-gray-300');
            button.classList.add('border-black', 'bg-gray-50');

            // Update price if variant has different price
            // (Optional: if you want to show variant-specific pricing)

            // Disable add to cart if out of stock
            const addToCartBtn = document.querySelector('[onclick*="addToCartWithAnimation"]');
            if (addToCartBtn) {
                if (stock <= 0) {
                    addToCartBtn.disabled = true;
                    addToCartBtn.classList.add('opacity-50', 'cursor-not-allowed');
                } else {
                    addToCartBtn.disabled = false;
                    addToCartBtn.classList.remove('opacity-50', 'cursor-not-allowed');
                }
            }
        }

        // Size Chart Modal Functions
        function openSizeChartModal() {
            const modal = document.getElementById('sizeChartModal');
            if (modal) {
                modal.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }
        }

        function closeSizeChartModal(event) {
            if (!event || event.target.id === 'sizeChartModal') {
                const modal = document.getElementById('sizeChartModal');
                if (modal) {
                    modal.classList.add('hidden');
                    document.body.style.overflow = 'auto';
                }
            }
        }

        // Share Product Function
        function shareProduct() {
            const productUrl = window.location.href;
            const productTitle = document.querySelector('h1').textContent;

            if (navigator.share) {
                navigator.share({
                    title: productTitle,
                    text: 'Check out this product!',
                    url: productUrl
                }).catch(err => console.log('Error sharing:', err));
            } else {
                // Fallback: Copy to clipboard
                navigator.clipboard.writeText(productUrl).then(() => {
                    alert('Product link copied to clipboard!');
                }).catch(err => {
                    console.error('Failed to copy:', err);
                });
            }
        }

        // Toggle Wishlist Function
        async function toggleWishlist(productId, button) {
            @guest
                window.location.href = '{{ route("login") }}';
                return;
            @endguest

            try {
                const response = await fetch('{{ route("wishlist.toggle") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ product_id: productId })
                });

                const data = await response.json();

                if (data.success) {
                    const icon = button.querySelector('.wishlist-icon');
                    const text = button.querySelector('.wishlist-text');

                    if (data.in_wishlist) {
                        icon.setAttribute('fill', 'currentColor');
                        text.textContent = 'In Wishlist';
                        button.classList.add('text-red-600');
                        button.classList.remove('text-gray-700');
                    } else {
                        icon.setAttribute('fill', 'none');
                        text.textContent = 'Add to Wishlist';
                        button.classList.remove('text-red-600');
                        button.classList.add('text-gray-700');
                    }

                    // Show notification
                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Failed to update wishlist', 'error');
            }
        }

        // Show notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }

        // Close modal on Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeSizeChartModal({ target: { id: 'sizeChartModal' } });
            }
        });
    </script>
    @endpush

    <!-- Facebook Pixel ViewContent Event -->
    <x-tracking.facebook-pixel-events event="ViewContent" :product="$product" />
</x-layouts.main>
