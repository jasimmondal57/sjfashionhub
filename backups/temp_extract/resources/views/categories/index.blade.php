<x-layouts.main>
    <x-slot name="title">Shop by Categories - SJ Fashion Hub</x-slot>
    <x-slot name="description">Browse our fashion categories. Find exactly what you're looking for with our organized collection of men's, women's fashion, accessories and more.</x-slot>

    <!-- Breadcrumb -->
    <section class="bg-gray-50 py-4">
        <div class="container-custom">
            <nav class="text-sm">
                <ol class="flex items-center space-x-2">
                    <li><a href="{{ route('home') }}" class="text-gray-600 hover:text-black">Home</a></li>
                    <li class="text-gray-400">/</li>
                    <li class="text-black font-medium">Categories</li>
                </ol>
            </nav>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-12">
        <div class="container-custom">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-black mb-4">Shop by Categories</h1>
                <p class="text-gray-600 max-w-2xl mx-auto">Discover our wide range of fashion categories designed for every style and occasion. From casual wear to formal attire, find exactly what you're looking for.</p>
            </div>

            <!-- Categories Grid -->
            @if($categories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($categories as $category)
                <div class="bg-white rounded-lg border border-gray-200 overflow-hidden hover:shadow-lg transition-all duration-300 group">
                    <!-- Category Image -->
                    <div class="aspect-video bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center relative overflow-hidden">
                        @if($category->image)
                            <img src="{{ $category->image }}" alt="{{ $category->name }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="text-center text-gray-500">
                                <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                <p class="text-sm">{{ $category->name }}</p>
                            </div>
                        @endif
                        
                        <!-- Product Count Badge -->
                        <div class="absolute top-4 right-4 bg-black text-white text-xs px-2 py-1 rounded">
                            {{ $category->product_count }} Products
                        </div>
                    </div>

                    <!-- Category Info -->
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-black mb-2 group-hover:text-gray-700">{{ $category->name }}</h3>
                        @if($category->description)
                        <p class="text-gray-600 text-sm mb-4">{{ $category->description }}</p>
                        @endif

                        <!-- Subcategories -->
                        @if($category->children->count() > 0)
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700 mb-2">Subcategories:</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($category->children->take(4) as $subcategory)
                                <a href="{{ route('categories.show', $subcategory) }}" 
                                   class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded hover:bg-gray-200 transition-colors">
                                    {{ $subcategory->name }}
                                </a>
                                @endforeach
                                @if($category->children->count() > 4)
                                <span class="text-xs text-gray-500 px-2 py-1">+{{ $category->children->count() - 4 }} more</span>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Action Button -->
                        <a href="{{ route('categories.show', $category) }}" 
                           class="btn btn-primary w-full group-hover:bg-gray-800 transition-colors">
                            Shop {{ $category->name }}
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <!-- No Categories -->
            <div class="text-center py-12">
                <svg class="w-24 h-24 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                </svg>
                <h3 class="text-xl font-medium text-gray-900 mb-2">No categories available</h3>
                <p class="text-gray-600 mb-4">Categories will be displayed here once they are added.</p>
                <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
            </div>
            @endif
        </div>
    </section>

    <!-- Featured Categories Section -->
    <section class="py-16 bg-gray-50">
        <div class="container-custom">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-black mb-4">Why Shop by Category?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Shopping by category helps you find exactly what you're looking for quickly and efficiently.</p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Easy Discovery</h3>
                    <p class="text-gray-600 text-sm">Find products faster by browsing organized categories</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Curated Selection</h3>
                    <p class="text-gray-600 text-sm">Each category features hand-picked, quality products</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 bg-black rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-2">Quick Shopping</h3>
                    <p class="text-gray-600 text-sm">Save time with targeted browsing and filtering</p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.main>
