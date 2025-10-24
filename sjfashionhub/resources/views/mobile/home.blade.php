<x-layouts.mobile-app>
    <x-slot name="title">SJ Fashion Hub</x-slot>
    <x-slot name="appBarTitle">SJ Fashion</x-slot>

    <!-- Banner Slider -->
    @if($banners && $banners->count() > 0)
    <div class="banner-slider">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach($banners as $banner)
                <div class="swiper-slide">
                    <img src="{{ Storage::url($banner->image) }}" alt="{{ $banner->title }}" class="banner-slide">
                </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    @endif

    <!-- Categories -->
    @if($categories && $categories->count() > 0)
    <div>
        <div class="section-header">
            <h2 class="section-title">Shop by Category</h2>
            <a href="/categories" class="section-link">See All →</a>
        </div>
        <div class="category-grid">
            @foreach($categories->take(6) as $category)
            <a href="{{ route('categories.show', $category) }}" class="category-card">
                <div class="category-icon">
                    @if($category->image)
                    <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                    @else
                    <svg style="width: 24px; height: 24px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    @endif
                </div>
                <div class="category-name">{{ $category->name }}</div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Featured Products -->
    @if($featuredProducts && $featuredProducts->count() > 0)
    <div>
        <div class="section-header">
            <h2 class="section-title">Featured Products</h2>
            <a href="/shop" class="section-link">See All →</a>
        </div>
        <div class="product-grid">
            @foreach($featuredProducts as $product)
            <a href="{{ route('products.show', $product) }}" class="product-card">
                <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="product-image">
                <div class="product-info">
                    <div class="product-name">{{ $product->name }}</div>
                    <div>
                        <span class="product-price">₹{{ number_format($product->sale_price ?? $product->price) }}</span>
                        @if($product->sale_price)
                        <span class="product-old-price">₹{{ number_format($product->price) }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- New Arrivals -->
    @if($newArrivals && $newArrivals->count() > 0)
    <div>
        <div class="section-header">
            <h2 class="section-title">New Arrivals</h2>
            <a href="/shop?sort=newest" class="section-link">See All →</a>
        </div>
        <div class="product-grid">
            @foreach($newArrivals as $product)
            <a href="{{ route('products.show', $product) }}" class="product-card">
                <img src="{{ $product->main_image }}" alt="{{ $product->name }}" class="product-image">
                <div class="product-info">
                    <div class="product-name">{{ $product->name }}</div>
                    <div>
                        <span class="product-price">₹{{ number_format($product->sale_price ?? $product->price) }}</span>
                        @if($product->sale_price)
                        <span class="product-old-price">₹{{ number_format($product->price) }}</span>
                        @endif
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    @push('scripts')
    <!-- Swiper JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.css">
    <script src="https://cdn.jsdelivr.net/npm/swiper@8/swiper-bundle.min.js"></script>
    <script>
        const swiper = new Swiper('.swiper-container', {
            loop: true,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    </script>
    @endpush
</x-layouts.mobile-app>

