@props(['banners'])

@if($banners && $banners->count() > 0)
<div class="relative w-full h-96 md:h-[500px] lg:h-[600px] overflow-hidden bg-gray-100" 
     x-data="bannerSlider({{ $banners->count() }})" 
     x-init="init()">
    
    <!-- Banner Slides -->
    <div class="relative w-full h-full">
        @foreach($banners as $index => $banner)
            <div class="absolute inset-0 w-full h-full transition-opacity duration-500 ease-in-out"
                 :class="{ 'opacity-100': currentSlide === {{ $index }}, 'opacity-0': currentSlide !== {{ $index }} }">
                
                <!-- Background Image -->
                <div class="absolute inset-0 w-full h-full">
                    <img src="{{ Storage::url($banner->image_path) }}" 
                         alt="{{ $banner->title }}"
                         class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-30"></div>
                </div>

                <!-- Content Overlay -->
                <div class="relative z-10 h-full flex items-center">
                    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="max-w-4xl {{ $banner->text_position === 'center' ? 'mx-auto text-center' : ($banner->text_position === 'right' ? 'ml-auto text-right' : 'text-left') }}">
                            
                            <!-- Title -->
                            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-4 leading-tight"
                                style="color: {{ $banner->text_color }}">
                                {{ $banner->title }}
                            </h1>

                            <!-- Description -->
                            @if($banner->description)
                                <p class="text-lg md:text-xl lg:text-2xl mb-8 leading-relaxed opacity-90"
                                   style="color: {{ $banner->text_color }}">
                                    {{ $banner->description }}
                                </p>
                            @endif

                            <!-- Button -->
                            @if($banner->button_text && $banner->button_url)
                                <a href="{{ $banner->button_url }}" 
                                   class="inline-flex items-center px-8 py-4 text-lg font-semibold rounded-lg transition-all duration-300 hover:scale-105 hover:shadow-lg"
                                   style="background-color: {{ $banner->button_color }}; color: {{ $banner->text_color }};">
                                    {{ $banner->button_text }}
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Navigation Arrows (only show if more than 1 banner) -->
    @if($banners->count() > 1)
        <!-- Previous Button -->
        <button @click="previousSlide()" 
                class="absolute left-4 top-1/2 transform -translate-y-1/2 z-20 bg-white bg-opacity-20 hover:bg-opacity-30 text-white p-3 rounded-full transition-all duration-300 backdrop-blur-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
        </button>

        <!-- Next Button -->
        <button @click="nextSlide()" 
                class="absolute right-4 top-1/2 transform -translate-y-1/2 z-20 bg-white bg-opacity-20 hover:bg-opacity-30 text-white p-3 rounded-full transition-all duration-300 backdrop-blur-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </button>

        <!-- Dots Indicator -->
        <div class="absolute bottom-6 left-1/2 transform -translate-x-1/2 z-20 flex space-x-2">
            @foreach($banners as $index => $banner)
                <button @click="goToSlide({{ $index }})" 
                        class="w-3 h-3 rounded-full transition-all duration-300"
                        :class="{ 'bg-white': currentSlide === {{ $index }}, 'bg-white bg-opacity-50': currentSlide !== {{ $index }} }">
                </button>
            @endforeach
        </div>

        <!-- Auto-play Controls -->
        <div class="absolute top-4 right-4 z-20 flex space-x-2">
            <button @click="toggleAutoplay()" 
                    class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white p-2 rounded-full transition-all duration-300 backdrop-blur-sm"
                    :title="isPlaying ? 'Pause' : 'Play'">
                <svg x-show="isPlaying" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 9v6m4-6v6m7-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <svg x-show="!isPlaying" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h1m4 0h1m-6 4h1m4 0h1m-6-8h1m4 0h1M9 21V3a18 18 0 006 0v18a18 18 0 01-6 0z"></path>
                </svg>
            </button>
        </div>
    @endif
</div>

<script>
function bannerSlider(totalSlides) {
    return {
        currentSlide: 0,
        totalSlides: totalSlides,
        isPlaying: true,
        autoplayInterval: null,
        autoplayDelay: 5000, // 5 seconds

        init() {
            if (this.totalSlides > 1) {
                this.startAutoplay();
            }
        },

        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },

        previousSlide() {
            this.currentSlide = this.currentSlide === 0 ? this.totalSlides - 1 : this.currentSlide - 1;
        },

        goToSlide(index) {
            this.currentSlide = index;
        },

        startAutoplay() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
            }
            this.autoplayInterval = setInterval(() => {
                if (this.isPlaying) {
                    this.nextSlide();
                }
            }, this.autoplayDelay);
        },

        stopAutoplay() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
                this.autoplayInterval = null;
            }
        },

        toggleAutoplay() {
            this.isPlaying = !this.isPlaying;
            if (this.isPlaying) {
                this.startAutoplay();
            } else {
                this.stopAutoplay();
            }
        }
    }
}
</script>
@endif
