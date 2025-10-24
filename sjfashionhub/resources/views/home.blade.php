<x-layouts.main>
    <x-slot name="title">SJ Fashion Hub - Your Everyday Fashion Brand</x-slot>
    <x-slot name="description">Discover the latest fashion trends at SJ Fashion Hub. Premium quality clothing for men and women with free shipping on orders above ₹999.</x-slot>

    <!-- Categories Section -->
    @if($categories->count() > 0)
    <section class="py-8 md:py-16 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-8 md:mb-12">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900 mb-3 md:mb-4">Shop by Category</h2>
                <p class="text-gray-600 max-w-2xl mx-auto text-sm md:text-base">Discover our wide range of fashion categories designed for every style and occasion.</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 md:gap-6">
                @foreach($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="group">
                    <div class="bg-white rounded-lg p-3 md:p-6 text-center hover:shadow-lg transition-all duration-300 group-hover:-translate-y-1">
                        <div class="w-12 h-12 md:w-16 md:h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-2 md:mb-4 group-hover:bg-gray-900 group-hover:text-white transition-colors overflow-hidden">
                            @if($category->image)
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            @else
                                <svg class="w-6 h-6 md:w-8 md:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            @endif
                        </div>
                        <h3 class="font-medium text-gray-900 text-sm md:text-base group-hover:text-gray-900">{{ $category->name }}</h3>
                        @if($category->description)
                            <p class="text-xs text-gray-500 mt-1 hidden md:block">{{ Str::limit($category->description, 40) }}</p>
                        @endif
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif



    <!-- Hero Section -->
    @php
        $heroSection = \App\Models\HeroSection::getActiveHero();
    @endphp
    @if($heroSection)
        <section class="relative overflow-hidden" style="background-color: {{ $heroSection->background_color }};">
            <div class="container mx-auto px-4">
                @if($heroSection->layout_style === 'split')
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 md:gap-8 items-center min-h-[400px] md:min-h-[500px] py-8 md:py-12">
                        <div class="space-y-4 md:space-y-6 text-center lg:text-left">
                            <h1 class="text-2xl md:text-4xl lg:text-6xl font-bold leading-tight" style="color: {{ $heroSection->text_color }};">
                                {{ $heroSection->title }}<br>
                                <span style="color: {{ $heroSection->accent_color }};">{{ $heroSection->subtitle }}</span>
                            </h1>
                            <p class="text-base md:text-lg max-w-md mx-auto lg:mx-0" style="color: {{ $heroSection->text_color }}; opacity: 0.8;">
                                {{ $heroSection->description }}
                            </p>
                            @if($heroSection->show_buttons)
                                <div class="flex flex-col sm:flex-row gap-3 md:gap-4 justify-center lg:justify-start">
                                    <a href="{{ $heroSection->primary_button_url }}" class="btn btn-primary btn-lg">
                                        {{ $heroSection->primary_button_text }}
                                    </a>
                                    @if($heroSection->secondary_button_text)
                                        <a href="{{ $heroSection->secondary_button_url }}" class="btn btn-secondary btn-lg">
                                            {{ $heroSection->secondary_button_text }}
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                        <div class="relative">
                            @if($heroSection->hero_image_url)
                                <img src="{{ $heroSection->hero_image_url }}" alt="Hero Image" class="aspect-square object-cover rounded-2xl">
                            @else
                                <div class="aspect-square bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center">
                                    <div class="text-center text-gray-500">
                                        <svg class="w-24 h-24 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p>Hero Image Placeholder</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif($heroSection->layout_style === 'centered')
                    <div class="text-center py-12 md:py-20">
                        <div class="max-w-4xl mx-auto space-y-4 md:space-y-6">
                            <h1 class="text-3xl md:text-5xl lg:text-7xl font-bold leading-tight" style="color: {{ $heroSection->text_color }};">
                                {{ $heroSection->title }} <span style="color: {{ $heroSection->accent_color }};">{{ $heroSection->subtitle }}</span>
                            </h1>
                            <p class="text-lg md:text-xl max-w-2xl mx-auto" style="color: {{ $heroSection->text_color }}; opacity: 0.8;">
                                {{ $heroSection->description }}
                            </p>
                            @if($heroSection->show_buttons)
                                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                    <a href="{{ $heroSection->primary_button_url }}" class="btn btn-primary btn-lg">
                                        {{ $heroSection->primary_button_text }}
                                    </a>
                                    @if($heroSection->secondary_button_text)
                                        <a href="{{ $heroSection->secondary_button_url }}" class="btn btn-secondary btn-lg">
                                            {{ $heroSection->secondary_button_text }}
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @elseif($heroSection->layout_style === 'full-width')
                    <div class="relative min-h-[400px] md:min-h-[600px] flex items-center justify-center"
                         @if($heroSection->hero_image_url)
                         style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ $heroSection->hero_image_url }}'); background-size: cover; background-position: center;"
                         @endif>
                        <div class="text-center space-y-4 md:space-y-6 z-10 px-4">
                            <h1 class="text-3xl md:text-5xl lg:text-7xl font-bold leading-tight text-white">
                                {{ $heroSection->title }}<br>
                                <span style="color: {{ $heroSection->accent_color }};">{{ $heroSection->subtitle }}</span>
                            </h1>
                            <p class="text-lg md:text-xl max-w-2xl mx-auto text-white opacity-90">
                                {{ $heroSection->description }}
                            </p>
                            @if($heroSection->show_buttons)
                                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                    <a href="{{ $heroSection->primary_button_url }}" class="btn btn-primary btn-lg">
                                        {{ $heroSection->primary_button_text }}
                                    </a>
                                    @if($heroSection->secondary_button_text)
                                        <a href="{{ $heroSection->secondary_button_url }}" class="btn btn-secondary btn-lg">
                                            {{ $heroSection->secondary_button_text }}
                                        </a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </section>
    @endif

    <!-- Dynamic Body Feature Sections -->
    @php
        $bodyFeatureSections = \App\Models\BodyFeatureSection::getActiveSections();
    @endphp
    @foreach($bodyFeatureSections as $section)
        <x-body-feature-section :section="$section" />
    @endforeach



    <!-- Features Section -->
    @php
        $features = \App\Models\Feature::active()->ordered()->get();
    @endphp
    @if($features->count() > 0)
    <section class="py-8 md:py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-{{ min($features->count(), 4) }} gap-6 md:gap-8">
                @foreach($features as $feature)
                <div class="text-center">
                    <div class="w-12 h-12 md:w-16 md:h-16 rounded-full flex items-center justify-center mx-auto mb-3 md:mb-4" style="background-color: {{ $feature->background_color }}">
                        @if($feature->icon_type === 'svg' && $feature->icon_svg)
                            <div style="color: {{ $feature->icon_color }}">
                                {!! $feature->icon_svg !!}
                            </div>
                        @elseif($feature->icon_type === 'image' && $feature->icon_image)
                            <img src="{{ asset('storage/' . $feature->icon_image) }}" alt="{{ $feature->title }}" class="w-6 h-6 md:w-8 md:h-8">
                        @elseif($feature->icon_type === 'icon_class' && $feature->icon_class)
                            <i class="{{ $feature->icon_class }}" style="color: {{ $feature->icon_color }}"></i>
                        @else
                            <svg class="w-6 h-6 md:w-8 md:h-8" style="color: {{ $feature->icon_color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <h3 class="font-semibold text-base md:text-lg mb-2">{{ $feature->title }}</h3>
                    <p class="text-gray-600 text-sm">{{ $feature->description }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- Newsletter Section -->
    <x-newsletter-section />
</x-layouts.main>
