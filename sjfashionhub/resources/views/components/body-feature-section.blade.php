@props(['section'])

@php
    $contentItems = $section->getContentItems();
@endphp

@if($contentItems->count() > 0)
    <section class="py-16" style="background-color: {{ $section->background_color }};">
        <div class="container-custom">
            <!-- Section Header -->
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-bold mb-2" style="color: {{ $section->text_color }};">{{ $section->title }}</h2>
                    @if($section->subtitle)
                        <p class="text-gray-600">{{ $section->subtitle }}</p>
                    @endif
                </div>
                @if($section->show_button && $section->button_text)
                    <a href="{{ $section->button_url }}" class="btn btn-outline">{{ $section->button_text }}</a>
                @endif
            </div>

            <!-- Content Display -->
            @if($section->display_style === 'grid')
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($contentItems as $item)
                        @if($section->section_type === 'products' || (isset($item->content_type) && $item->content_type === 'product'))
                            <!-- Product Card -->
                            <div class="product-card group">
                                <div class="relative">
                                    <a href="{{ route('products.show', $item) }}" class="block">
                                        <div class="aspect-square bg-gray-100 rounded-t-lg flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </a>
                                    @if($item->sale_price)
                                    <span class="product-badge product-badge-sale">Sale</span>
                                    @endif
                                    @if($item->is_featured)
                                    <span class="product-badge">Featured</span>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <a href="{{ route('products.show', $item) }}">
                                        <h3 class="font-medium text-black mb-2 line-clamp-2 group-hover:text-gray-700 transition-colors">{{ $item->name }}</h3>
                                    </a>
                                    <p class="text-sm text-gray-600 mb-2">{{ $item->category->name }}</p>
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center space-x-2">
                                            @if($item->sale_price)
                                            <span class="text-lg font-semibold text-black">₹{{ number_format($item->sale_price) }}</span>
                                            <span class="text-sm text-gray-500 line-through">₹{{ number_format($item->price) }}</span>
                                            @else
                                            <span class="text-lg font-semibold text-black">₹{{ number_format($item->price) }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        <button onclick="addToCartWithAnimation({{ $item->id }}, this)" class="cart-button flex-1 text-xs py-2 px-3 rounded transition-colors" style="background-color: #111827 !important; color: white !important; border: none !important;" onmouseover="this.style.backgroundColor='#374151'" onmouseout="this.style.backgroundColor='#111827'">
                                            <span class="button-text">Add to Cart</span>
                                            <span class="loading-text" style="display: none;">Adding...</span>
                                            <span class="success-text" style="display: none;">Added! ✓</span>
                                        </button>
                                        <button onclick="buyNow({{ $item->id }})" class="flex-1 text-xs py-2 px-3 rounded transition-colors" style="background-color: #4f46e5 !important; color: white !important; border: none !important;" onmouseover="this.style.backgroundColor='#4338ca'" onmouseout="this.style.backgroundColor='#4f46e5'">
                                            Buy Now
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @elseif($section->section_type === 'categories' || (isset($item->content_type) && $item->content_type === 'category'))
                            <!-- Category Card -->
                            <a href="{{ route('categories.show', $item) }}" class="group">
                                <div class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition-all duration-300 group-hover:-translate-y-1">
                                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-black group-hover:text-white transition-colors overflow-hidden">
                                        @if($item->image)
                                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        @else
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <h3 class="font-medium text-black group-hover:text-gray-900">{{ $item->name }}</h3>
                                    @if($item->description)
                                        <p class="text-xs text-gray-500 mt-1">{{ Str::limit($item->description, 40) }}</p>
                                    @endif
                                </div>
                            </a>
                        @endif
                    @endforeach
                </div>

            @elseif($section->display_style === 'carousel')
                <div class="relative">
                    <div class="overflow-x-auto scrollbar-hide">
                        <div class="flex space-x-6 pb-4" style="width: max-content;">
                            @foreach($contentItems as $item)
                                @if($section->section_type === 'products' || (isset($item->content_type) && $item->content_type === 'product'))
                                    <!-- Product Card -->
                                    <div class="product-card w-64 flex-shrink-0 group">
                                        <div class="relative">
                                            <a href="{{ route('products.show', $item) }}" class="block">
                                                <div class="aspect-square bg-gray-100 rounded-t-lg flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                                                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            </a>
                                            @if($item->sale_price)
                                            <span class="product-badge product-badge-sale">Sale</span>
                                            @endif
                                            @if($item->is_featured)
                                            <span class="product-badge">Featured</span>
                                            @endif
                                        </div>
                                        <div class="p-4">
                                            <a href="{{ route('products.show', $item) }}">
                                                <h3 class="font-medium text-black mb-2 line-clamp-2 group-hover:text-gray-700 transition-colors">{{ $item->name }}</h3>
                                            </a>
                                            <p class="text-sm text-gray-600 mb-2">{{ $item->category->name }}</p>
                                            <div class="flex items-center justify-between mb-3">
                                                <div class="flex items-center space-x-2">
                                                    @if($item->sale_price)
                                                    <span class="text-lg font-semibold text-black">₹{{ number_format($item->sale_price) }}</span>
                                                    <span class="text-sm text-gray-500 line-through">₹{{ number_format($item->price) }}</span>
                                                    @else
                                                    <span class="text-lg font-semibold text-black">₹{{ number_format($item->price) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- Action Buttons -->
                                            <div class="flex space-x-2">
                                                <button onclick="addToCartWithAnimation({{ $item->id }}, this)" class="cart-button flex-1 text-xs py-2 px-3 rounded transition-colors" style="background-color: #111827 !important; color: white !important; border: none !important;" onmouseover="this.style.backgroundColor='#374151'" onmouseout="this.style.backgroundColor='#111827'">
                                                    <span class="button-text">Add to Cart</span>
                                                    <span class="loading-text" style="display: none;">Adding...</span>
                                                    <span class="success-text" style="display: none;">Added! ✓</span>
                                                </button>
                                                <button onclick="buyNow({{ $item->id }})" class="flex-1 text-xs py-2 px-3 rounded transition-colors" style="background-color: #4f46e5 !important; color: white !important; border: none !important;" onmouseover="this.style.backgroundColor='#4338ca'" onmouseout="this.style.backgroundColor='#4f46e5'">
                                                    Buy Now
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($section->section_type === 'categories' || (isset($item->content_type) && $item->content_type === 'category'))
                                    <!-- Category Card -->
                                    <a href="{{ route('categories.show', $item) }}" class="group w-48 flex-shrink-0">
                                        <div class="bg-white rounded-lg p-6 text-center hover:shadow-lg transition-all duration-300 group-hover:-translate-y-1">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-black group-hover:text-white transition-colors overflow-hidden">
                                                @if($item->image)
                                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                                @else
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                                    </svg>
                                                @endif
                                            </div>
                                            <h3 class="font-medium text-black group-hover:text-gray-900">{{ $item->name }}</h3>
                                            @if($item->description)
                                                <p class="text-xs text-gray-500 mt-1">{{ Str::limit($item->description, 40) }}</p>
                                            @endif
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>

            @elseif($section->display_style === 'list')
                <div class="space-y-4">
                    @foreach($contentItems as $item)
                        @if($section->section_type === 'products' || (isset($item->content_type) && $item->content_type === 'product'))
                            <!-- Product List Item -->
                            <div class="bg-white rounded-lg p-4 flex items-center space-x-4 hover:shadow-md transition-shadow group">
                                <a href="{{ route('products.show', $item) }}" class="flex-shrink-0">
                                    <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center group-hover:bg-gray-200 transition-colors">
                                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                </a>
                                <div class="flex-1">
                                    <a href="{{ route('products.show', $item) }}">
                                        <h3 class="font-medium text-black group-hover:text-gray-700 transition-colors">{{ $item->name }}</h3>
                                    </a>
                                    <p class="text-sm text-gray-600">{{ $item->category->name }}</p>
                                    <div class="flex items-center space-x-2 mt-1">
                                        @if($item->sale_price)
                                        <span class="text-lg font-semibold text-black">₹{{ number_format($item->sale_price) }}</span>
                                        <span class="text-sm text-gray-500 line-through">₹{{ number_format($item->price) }}</span>
                                        @else
                                        <span class="text-lg font-semibold text-black">₹{{ number_format($item->price) }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button onclick="addToCartWithAnimation({{ $item->id }}, this)" class="cart-button text-xs py-2 px-3 rounded transition-colors" style="background-color: #111827 !important; color: white !important; border: none !important;" onmouseover="this.style.backgroundColor='#374151'" onmouseout="this.style.backgroundColor='#111827'">
                                        <span class="button-text">Add to Cart</span>
                                        <span class="loading-text" style="display: none;">Adding...</span>
                                        <span class="success-text" style="display: none;">Added! ✓</span>
                                    </button>
                                    <button onclick="buyNow({{ $item->id }})" class="text-xs py-2 px-3 rounded transition-colors" style="background-color: #4f46e5 !important; color: white !important; border: none !important;" onmouseover="this.style.backgroundColor='#4338ca'" onmouseout="this.style.backgroundColor='#4f46e5'">
                                        Buy Now
                                    </button>
                                </div>
                            </div>
                        @elseif($section->section_type === 'categories' || (isset($item->content_type) && $item->content_type === 'category'))
                            <!-- Category List Item -->
                            <a href="{{ route('categories.show', $item) }}" class="bg-white rounded-lg p-4 flex items-center space-x-4 hover:shadow-md transition-shadow group">
                                <div class="w-20 h-20 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0 group-hover:bg-black group-hover:text-white transition-colors overflow-hidden">
                                    @if($item->image)
                                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-medium text-black group-hover:text-gray-900">{{ $item->name }}</h3>
                                    @if($item->description)
                                        <p class="text-sm text-gray-600">{{ $item->description }}</p>
                                    @endif
                                </div>
                                <svg class="w-5 h-5 text-gray-400 group-hover:text-black transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </section>
@endif
