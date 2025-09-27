<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SJ Fashion Hub - Your Everyday Fashion Brand' }}</title>
    <meta name="description" content="{{ $description ?? 'Discover the latest fashion trends at SJ Fashion Hub. Premium quality clothing for men and women with free shipping on orders above ₹999.' }}">

    @if(isset($keywords))
    <meta name="keywords" content="{{ $keywords }}">
    @endif

    <!-- Structured Data -->
    @if(isset($structuredData))
    <script type="application/ld+json">
        {!! $structuredData !!}
    </script>
    @endif

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional Head Content -->
    @stack('head')

    <!-- Announcement Bar Styles -->
    <style>
        .announcement-bar {
            position: relative;
            overflow: hidden;
        }

        .scrolling-text {
            white-space: nowrap;
            animation: scroll-left linear infinite;
        }

        @keyframes scroll-left {
            0% {
                transform: translateX(100%);
            }
            100% {
                transform: translateX(-100%);
            }
        }

        /* Dynamic animation duration based on scroll speed */
        .scrolling-text[data-scroll-speed="10"] { animation-duration: 20s; }
        .scrolling-text[data-scroll-speed="20"] { animation-duration: 15s; }
        .scrolling-text[data-scroll-speed="30"] { animation-duration: 12s; }
        .scrolling-text[data-scroll-speed="40"] { animation-duration: 10s; }
        .scrolling-text[data-scroll-speed="50"] { animation-duration: 8s; }
        .scrolling-text[data-scroll-speed="60"] { animation-duration: 7s; }
        .scrolling-text[data-scroll-speed="70"] { animation-duration: 6s; }
        .scrolling-text[data-scroll-speed="80"] { animation-duration: 5s; }
        .scrolling-text[data-scroll-speed="90"] { animation-duration: 4s; }
        .scrolling-text[data-scroll-speed="100"] { animation-duration: 3s; }
        .scrolling-text[data-scroll-speed="150"] { animation-duration: 2s; }
        .scrolling-text[data-scroll-speed="200"] { animation-duration: 1.5s; }
    </style>
</head>
<body class="font-sans antialiased bg-white">
    <!-- Announcement Bars -->
    @php
        $announcementBars = \App\Models\AnnouncementBar::active()->ordered()->get();
    @endphp

    @foreach($announcementBars as $bar)
        <div class="announcement-bar"
             style="background-color: {{ $bar->background_color }}; color: {{ $bar->text_color }};">
            <div class="container-custom">
                <div class="flex items-center justify-between py-2">
                    <div class="text-sm {{ $bar->is_scrolling ? 'scrolling-text' : '' }}"
                         @if($bar->is_scrolling)
                         data-scroll-speed="{{ $bar->scroll_speed }}"
                         @endif>
                        {{ $bar->message }}
                    </div>
                    @if($bar->links && count($bar->links) > 0)
                        <div class="hidden md:flex items-center space-x-4 text-sm">
                            @foreach($bar->links as $link)
                                <a href="{{ $link['url'] }}" class="hover:opacity-75 transition-opacity">
                                    {{ $link['text'] }}
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endforeach

    <!-- Main Header -->
    @php
        $headerSettings = \App\Models\HeaderSetting::getActiveSettings();
    @endphp
    <header class="header-main {{ $headerSettings->sticky_header ? 'sticky top-0 z-50 bg-white shadow-sm' : '' }}">
        <div class="container-custom">
            <div class="flex items-center justify-between py-4">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center">
                        @if($headerSettings->logo_image)
                            <img src="{{ Storage::url($headerSettings->logo_image) }}"
                                 alt="{{ $headerSettings->site_name }}"
                                 class="h-8 w-auto">
                        @else
                            <span class="text-2xl font-bold text-black">
                                {{ $headerSettings->logo_text ?? $headerSettings->site_name }}
                            </span>
                        @endif
                    </a>
                </div>

                <!-- Desktop Navigation -->
                @if($headerSettings->navigation_menu && count($headerSettings->navigation_menu) > 0)
                    <nav class="hidden lg:flex items-center space-x-8">
                        @foreach($headerSettings->navigation_menu as $menuItem)
                            @if($menuItem['is_active'] ?? true)
                                <a href="{{ $menuItem['url'] }}"
                                   class="nav-link {{ request()->url() === url($menuItem['url']) ? 'nav-link-active' : '' }}">
                                    {{ $menuItem['text'] }}
                                </a>
                            @endif
                        @endforeach
                    </nav>
                @endif

                <!-- Right Side Icons -->
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    @if($headerSettings->show_search)
                        <div class="flex items-center space-x-2">
                            <form id="search-form" action="{{ route('search') }}" method="GET" class="relative">
                                <input type="text"
                                       name="q"
                                       value="{{ request('q') }}"
                                       placeholder="{{ $headerSettings->search_placeholder }}"
                                       class="w-48 md:w-64 px-4 py-2 text-sm border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                       onkeypress="if(event.key==='Enter') submitSearch()">
                            </form>
                            <button type="button" onclick="submitSearch()" class="p-2 hover:bg-gray-100 rounded-full">
                                <svg class="w-5 h-5 text-gray-600 hover:text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    @endif

                    <!-- User Account -->
                    @if($headerSettings->show_account)
                        <x-user-menu />
                    @endif

                    <!-- Wishlist -->
                    @if($headerSettings->show_wishlist)
                        @auth
                            <a href="{{ route('user.wishlist') }}" class="p-2 hover:bg-gray-100 rounded-full relative">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span class="absolute -top-1 -right-1 bg-black text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="p-2 hover:bg-gray-100 rounded-full relative">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                                <span class="absolute -top-1 -right-1 bg-black text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                            </a>
                        @endauth
                    @endif

                    <!-- Cart -->
                    @if($headerSettings->show_cart)
                        <a href="{{ route('cart.index') }}" class="p-2 hover:bg-gray-100 rounded-full relative">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                            </svg>
                            <span class="absolute -top-1 -right-1 bg-black text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">0</span>
                        </a>
                    @endif

                    <!-- Mobile Menu Toggle -->
                    <button class="lg:hidden p-2 hover:bg-gray-100 rounded-full" onclick="toggleMobileMenu()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <!-- Banner Slider (Homepage Only) -->
    @if(request()->routeIs('home'))
        @php
            $banners = \App\Models\Banner::active()->ordered()->get();
        @endphp
        <x-banner-slider :banners="$banners" />
    @endif

    <!-- Main Content -->
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    <!-- Footer -->
    @php
        $footerSettings = \App\Models\FooterSetting::getActiveSettings();
    @endphp
    <footer class="footer" style="background-color: {{ $footerSettings->background_color }}; color: {{ $footerSettings->text_color }};">
        <div class="container-custom py-12">
            <div class="flex flex-wrap justify-between gap-6 lg:gap-8">
                <!-- About Store -->
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-lg mb-4">{{ $footerSettings->company_name }}</h3>
                    <p class="text-sm leading-relaxed opacity-80">
                        {{ $footerSettings->company_description }}
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-lg mb-4">{{ $footerSettings->quick_links_title ?? 'Quick Links' }}</h3>
                    <ul class="space-y-2 text-sm">
                        @if($footerSettings->quick_links && count($footerSettings->quick_links) > 0)
                            @foreach($footerSettings->quick_links as $link)
                            <li><a href="{{ $link['url'] }}" class="opacity-80 hover:opacity-100 transition-opacity">{{ $link['text'] }}</a></li>
                            @endforeach
                        @else
                            <li><a href="/about" class="opacity-80 hover:opacity-100 transition-opacity">About Us</a></li>
                            <li><a href="/contact" class="opacity-80 hover:opacity-100 transition-opacity">Contact</a></li>
                            <li><a href="/privacy" class="opacity-80 hover:opacity-100 transition-opacity">Privacy Policy</a></li>
                            <li><a href="/terms" class="opacity-80 hover:opacity-100 transition-opacity">Terms of Service</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Customer Service -->
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-lg mb-4">{{ $footerSettings->customer_service_title ?? 'Customer Service' }}</h3>
                    <ul class="space-y-2 text-sm">
                        @if($footerSettings->customer_service_links && count($footerSettings->customer_service_links) > 0)
                            @foreach($footerSettings->customer_service_links as $link)
                            <li><a href="{{ $link['url'] }}" class="opacity-80 hover:opacity-100 transition-opacity">{{ $link['text'] }}</a></li>
                            @endforeach
                        @else
                            <li><a href="/faq" class="opacity-80 hover:opacity-100 transition-opacity">FAQ</a></li>
                            <li><a href="/shipping" class="opacity-80 hover:opacity-100 transition-opacity">Shipping Info</a></li>
                            <li><a href="/returns" class="opacity-80 hover:opacity-100 transition-opacity">Returns</a></li>
                            <li><a href="/size-guide" class="opacity-80 hover:opacity-100 transition-opacity">Size Guide</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Categories -->
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-lg mb-4">{{ $footerSettings->categories_title ?? 'Categories' }}</h3>
                    <ul class="space-y-2 text-sm">
                        @if($footerSettings->categories_links && count($footerSettings->categories_links) > 0)
                            @foreach($footerSettings->categories_links as $link)
                            <li><a href="{{ $link['url'] }}" class="opacity-80 hover:opacity-100 transition-opacity">{{ $link['text'] }}</a></li>
                            @endforeach
                        @else
                            <li><a href="/categories/mens-fashion" class="opacity-80 hover:opacity-100 transition-opacity">Men's Fashion</a></li>
                            <li><a href="/categories/womens-fashion" class="opacity-80 hover:opacity-100 transition-opacity">Women's Fashion</a></li>
                            <li><a href="/categories/accessories" class="opacity-80 hover:opacity-100 transition-opacity">Accessories</a></li>
                            <li><a href="/categories/footwear" class="opacity-80 hover:opacity-100 transition-opacity">Footwear</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Contact Information (Fifth Section) -->
                <div class="flex-1 min-w-0">
                    <h3 class="font-semibold text-lg mb-4">Get In Touch</h3>
                    <ul class="space-y-2 text-sm">
                        @if($footerSettings->contact_info && (($footerSettings->contact_info['phone'] ?? null) || ($footerSettings->contact_info['email'] ?? null) || ($footerSettings->contact_info['address'] ?? null)))
                            @if($footerSettings->contact_info['phone'] ?? null)
                            <li class="opacity-80">{{ $footerSettings->contact_info['phone'] }}</li>
                            @endif
                            @if($footerSettings->contact_info['email'] ?? null)
                            <li class="opacity-80">{{ $footerSettings->contact_info['email'] }}</li>
                            @endif
                            @if($footerSettings->contact_info['address'] ?? null)
                            <li class="opacity-80">{{ $footerSettings->contact_info['address'] }}</li>
                            @endif
                        @else
                            <li class="opacity-80">+1 (555) 123-4567</li>
                            <li class="opacity-80">info@sjfashionhub.com</li>
                            <li class="opacity-80">123 Fashion Street, Style City, SC 12345</li>
                        @endif
                    </ul>
                </div>
            </div>



            <!-- Payment Icons and App Downloads Section -->
            <div class="mt-8 pt-6 border-t border-gray-700">
                <div class="flex flex-col lg:flex-row justify-between items-center space-y-4 lg:space-y-0">

                    <!-- Payment Icons (Left Side) -->
                    @if($footerSettings->show_payment_icons && $footerSettings->payment_icons && count($footerSettings->payment_icons) > 0)
                    <div class="flex flex-col items-center lg:items-start">
                        <p class="text-sm opacity-80 mb-3">We Accept:</p>
                        <div class="flex flex-wrap justify-center lg:justify-start gap-3">
                            @foreach($footerSettings->payment_icons as $icon)
                            @if(!empty($icon['url']))
                                <a href="{{ $icon['url'] }}" class="block hover:opacity-80 transition-opacity">
                            @endif
                            <div class="bg-white rounded-lg p-1 shadow-sm flex items-center justify-center w-16 h-10" title="{{ $icon['name'] }}">
                                @if(isset($icon['image_type']) && $icon['image_type'] === 'custom' && !empty($icon['custom_image']))
                                    <img src="{{ asset('storage/' . $icon['custom_image']) }}" alt="{{ $icon['name'] }}" class="w-14 h-8 object-contain">
                                @elseif($icon['icon'] == 'upi')
                                    <svg class="w-14 h-8" viewBox="0 0 56 24" fill="none">
                                        <rect width="56" height="24" rx="3" fill="#FF6600"/>
                                        <path d="M8 6h2v6c0 1-0.5 1.5-1.5 1.5S7 13 7 12V6h1v6c0 .3.1.5.5.5s.5-.2.5-.5V6zm3 0h2.5c1 0 1.5.5 1.5 1.5v2c0 1-.5 1.5-1.5 1.5H12v1.5h-1V6zm1 1v2h1.5c.2 0 .3-.1.3-.3v-1.4c0-.2-.1-.3-.3-.3H12zm5 5.5V6h1v6.5h-1z" fill="white"/>
                                        <circle cx="19" cy="9.5" r="1" fill="white"/>
                                    </svg>
                                @elseif($icon['icon'] == 'visa')
                                    <svg class="w-14 h-8" viewBox="0 0 56 24" fill="none">
                                        <rect width="56" height="24" rx="3" fill="#1A1F71"/>
                                        <path d="M10 6l-2 9h2l2-9h-2zm5 0l-1.5 6L12 6h-2l3 9h2l4-9h-2zm8 0c-.7 0-1.3.3-1.3 1 0 1 2 1 2 2 0 .3-.3.7-1 .7s-1.3-.3-1.3-.7h-1.4c0 1.3 1.3 2 2.7 2s2.7-.7 2.7-2c0-1.3-2-1.3-2-2 0-.2.2-.3.5-.3s.8.1.8.3h1.4c0-1-1-1.7-2.4-1.7zm5.3 0l-1 9h1.7l.2-1.5h2l.1 1.5h2L33 6h-2zm.7 2l.7 3.5h-1.4L28 8z" fill="white"/>
                                    </svg>
                                @elseif($icon['icon'] == 'mastercard')
                                    <svg class="w-14 h-8" viewBox="0 0 56 24" fill="none">
                                        <rect width="56" height="24" rx="3" fill="white" stroke="#ddd"/>
                                        <circle cx="21" cy="12" r="7" fill="#EB001B"/>
                                        <circle cx="35" cy="12" r="7" fill="#F79E1B"/>
                                        <path d="M28 6.5c1.5 1.3 2.5 3.2 2.5 5.5s-1 4.2-2.5 5.5c-1.5-1.3-2.5-3.2-2.5-5.5s1-4.2 2.5-5.5z" fill="#FF5F00"/>
                                    </svg>
                                @elseif($icon['icon'] == 'rupay')
                                    <svg class="w-14 h-8" viewBox="0 0 56 24" fill="none">
                                        <rect width="56" height="24" rx="3" fill="#00A651"/>
                                        <path d="M8 6h3c1.3 0 2 .7 2 1.7 0 .7-.3 1.2-1 1.5L13 12h-1.7l-.8-2H9v2H8V6zm1 1v1.7h1.3c.3 0 .7-.1.7-.5s-.4-.5-.7-.5H9zm5 4V6h1v5h3v1h-4zm5-5h2v5c0 1-.7 1.7-1.7 1.7S18 13 18 12V6h1v5c0 .3.1.5.5.5s.5-.2.5-.5V6zm4 0h4v1h-3v1h2v1h-2v1h3v1h-4V6z" fill="white"/>
                                    </svg>
                                @elseif($icon['icon'] == 'paytm')
                                    <svg class="w-14 h-8" viewBox="0 0 56 24" fill="none">
                                        <rect width="56" height="24" rx="3" fill="#00BAF2"/>
                                        <path d="M7 6h3c1.3 0 2 .7 2 1.7 0 1-.7 1.7-2 1.7H8v2.6H7V6zm1 1v1.4h1.3c.3 0 .7-.1.7-.5s-.4-.5-.7-.5H8zm4 4.6l2-6h1.4l2 6h-1.4l-.3-1h-2l-.3 1H13zm2-2h1.4l-.7-2-.7 2zm5-3.6l.7 4 .7-4h1.4l-1.4 6h-1.4l-1.4-6H20zm5 0h1.4l1.4 4V6H29v6h-1.4l-1.4-4v4H25V6z" fill="white"/>
                                    </svg>
                                @elseif($icon['icon'] == 'phonepe')
                                    <svg class="w-14 h-8" viewBox="0 0 56 24" fill="none">
                                        <rect width="56" height="24" rx="3" fill="#5F259F"/>
                                        <circle cx="11" cy="12" r="4" fill="white"/>
                                        <path d="M11 9v6l3-3-3-3z" fill="#5F259F"/>
                                        <path d="M18 6h3c1.3 0 2 .7 2 1.7 0 .7-.3 1.2-1 1.5L23 12h-1.7l-.8-2H19v2h-1V6zm1 1v1.7h1.3c.3 0 .7-.1.7-.5s-.4-.5-.7-.5H19zm5 4V6h4v1h-3v1h2v1h-2v1h3v1h-4z" fill="white"/>
                                    </svg>
                                @elseif($icon['icon'] == 'googlepay')
                                    <svg class="w-14 h-8" viewBox="0 0 56 24" fill="none">
                                        <rect width="56" height="24" rx="3" fill="#4285F4"/>
                                        <path d="M10 6c1.3 0 2.3 1 2.3 2.3S11.3 11 10 11H9v2H8V6h2zm0 1H9v2h1c.7 0 1-.3 1-1s-.3-1-1-1zm4 4l2-6h1.4l2 6h-1.4l-.3-1h-2l-.3 1H14zm2-2h1.4l-.7-2-.7 2zm5-3l.7 4 .7-4h1.4l-1.4 6h-1.4l-1.4-6H21z" fill="white"/>
                                    </svg>
                                @elseif($icon['icon'] == 'bhim')
                                    <svg class="w-14 h-8" viewBox="0 0 56 24" fill="none">
                                        <rect width="56" height="24" rx="3" fill="#FF6600"/>
                                        <path d="M8 6h3c1 0 1.7.7 1.7 1.7 0 .7-.3 1-.7 1.2.3.2.7.5.7 1.1 0 1-.7 1.7-1.7 1.7H8V6zm1 1v1.4h1.3c.3 0 .5-.2.5-.5s-.2-.5-.5-.5H9zm0 2.8v1.4h1.3c.3 0 .5-.2.5-.5s-.2-.5-.5-.5H9zm5-3.8h1v2h2V6h1v6h-1V9h-2v3h-1V6zm7 0h1v6h-1V6zm3 0h1l1.4 3.5V6H27v6h-1l-1.4-3.5V12H23V6z" fill="white"/>
                                    </svg>
                                @else
                                    <span class="text-xs text-gray-600 font-medium">{{ $icon['name'] }}</span>
                                @endif
                            </div>
                            @if(!empty($icon['url']))
                                </a>
                            @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- App Download Links (Right Side) -->
                    @if($footerSettings->show_app_downloads && $footerSettings->app_download_links && count($footerSettings->app_download_links) > 0)
                    <div class="flex flex-col items-center lg:items-end">
                        <p class="text-sm opacity-80 mb-3">Download Our App:</p>
                        <div class="flex space-x-3">
                            @foreach($footerSettings->app_download_links as $app)
                            <a href="{{ $app['url'] }}" target="_blank" rel="noopener" class="block hover:opacity-80 transition-opacity">
                                @if($app['icon'] == 'playstore')
                                    <div class="bg-black rounded-lg px-4 py-2 flex items-center space-x-2">
                                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.61 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.53,12.9 20.18,13.18L17.89,14.5L15.39,12L17.89,9.5L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z"/>
                                        </svg>
                                        <div class="text-white">
                                            <div class="text-xs">GET IT ON</div>
                                            <div class="text-sm font-semibold">Google Play</div>
                                        </div>
                                    </div>
                                @elseif($app['icon'] == 'appstore')
                                    <div class="bg-black rounded-lg px-4 py-2 flex items-center space-x-2">
                                        <svg class="w-6 h-6 text-white" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M18.71,19.5C17.88,20.74 17,21.95 15.66,21.97C14.32,22 13.89,21.18 12.37,21.18C10.84,21.18 10.37,21.95 9.1,22C7.79,22.05 6.8,20.68 5.96,19.47C4.25,17 2.94,12.45 4.7,9.39C5.57,7.87 7.13,6.91 8.82,6.88C10.1,6.86 11.32,7.75 12.11,7.75C12.89,7.75 14.37,6.68 15.92,6.84C16.57,6.87 18.39,7.1 19.56,8.82C19.47,8.88 17.39,10.1 17.41,12.63C17.44,15.65 20.06,16.66 20.09,16.67C20.06,16.74 19.67,18.11 18.71,19.5M13,3.5C13.73,2.67 14.94,2.04 15.94,2C16.07,3.17 15.6,4.35 14.9,5.19C14.21,6.04 13.07,6.7 11.95,6.61C11.8,5.46 12.36,4.26 13,3.5Z"/>
                                        </svg>
                                        <div class="text-white">
                                            <div class="text-xs">Download on the</div>
                                            <div class="text-sm font-semibold">App Store</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-gray-800 rounded-lg px-4 py-2 text-white">
                                        <div class="text-sm font-semibold">{{ $app['platform'] }}</div>
                                    </div>
                                @endif
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Bottom Footer -->
            <div class="border-t border-opacity-20 mt-8 pt-6" style="border-color: {{ $footerSettings->text_color }};">
                <div class="text-center">
                    <div class="flex flex-wrap justify-center items-center text-sm opacity-75" style="color: {{ $footerSettings->text_color }};">
                        <!-- Copyright -->
                        <span class="whitespace-nowrap px-2">{{ $footerSettings->copyright_text }}</span>

                        <!-- First Dot Separator -->
                        <span class="text-lg font-bold opacity-60 px-1">•</span>

                        <!-- Made with love in India -->
                        <div class="flex items-center space-x-1 whitespace-nowrap px-2">
                            @php
                                $madeInText = $footerSettings->made_in_text ?? 'Made with ❤️ in India';
                                $parts = explode('❤️', $madeInText);
                            @endphp

                            @if(count($parts) >= 2)
                                <span>{{ trim($parts[0]) }}</span>
                                <svg class="w-4 h-4 text-red-500 mx-1" style="animation: heartbeat 1.5s ease-in-out infinite;" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"/>
                                </svg>
                                <span>{{ trim($parts[1]) }}</span>
                            @else
                                <span>{{ $madeInText }}</span>
                            @endif
                        </div>

                        <!-- Second Dot Separator -->
                        <span class="text-lg font-bold opacity-60 px-1">•</span>

                        <!-- Designed by JM Software -->
                        <div class="flex items-center space-x-2 whitespace-nowrap px-2">
                            <span>{{ $footerSettings->designed_by_text ?? 'Designed By' }}</span>
                            <a href="{{ $footerSettings->company_url ?? 'https://jmsoftware.shop/' }}" target="_blank" rel="noopener" class="font-medium hover:opacity-100 transition-all duration-300 hover:scale-105 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent hover:from-purple-600 hover:to-blue-600">
                                {{ $footerSettings->company_name ?? 'JM Software' }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Custom CSS for heartbeat animation -->
            <style>
                @keyframes heartbeat {
                    0% {
                        transform: scale(1);
                    }
                    14% {
                        transform: scale(1.3);
                    }
                    28% {
                        transform: scale(1);
                    }
                    42% {
                        transform: scale(1.3);
                    }
                    70% {
                        transform: scale(1);
                    }
                }
            </style>
        </div>
    </footer>

    <!-- Mobile Menu Overlay -->
    <div id="mobile-menu" class="mobile-menu mobile-menu-closed lg:hidden">
        <!-- Mobile menu content would go here -->
    </div>

    <!-- Cart Drawer -->
    <div id="cart-drawer" class="cart-drawer cart-drawer-closed">
        <!-- Cart content would go here -->
    </div>



    <!-- Scripts -->
    <script>
        function toggleMobileMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('mobile-menu-open');
            menu.classList.toggle('mobile-menu-closed');
        }

        function toggleCart() {
            const cart = document.getElementById('cart-drawer');
            cart.classList.toggle('cart-drawer-open');
            cart.classList.toggle('cart-drawer-closed');
        }

        function submitSearch() {
            const form = document.getElementById('search-form');
            const input = form.querySelector('input[name="q"]');

            // Only submit if there's a search query
            if (input.value.trim()) {
                form.submit();
            } else {
                // Focus the input if empty
                input.focus();
            }
        }

        function showLoginPrompt() {
            if (confirm('Please login to access your cart. Would you like to login now?')) {
                window.location.href = '{{ route("login") }}';
            }
        }

        // Add to Cart function with animation
        function addToCartWithAnimation(productId, buttonElement) {
            // Don't trigger if already animating or completed
            if (buttonElement.classList.contains('adding') || buttonElement.classList.contains('added')) {
                return;
            }

            // Start animation
            buttonElement.classList.add('adding');
            const buttonText = buttonElement.querySelector('.button-text');
            const loadingText = buttonElement.querySelector('.loading-text');
            const successText = buttonElement.querySelector('.success-text');

            // Show loading state
            buttonText.style.display = 'none';
            loadingText.style.display = 'inline';

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
                    buttonElement.classList.remove('adding');
                    buttonElement.classList.add('added');

                    // Show truck animation
                    showTruckAnimation(buttonElement);

                    // Update cart count
                    updateCartCount();

                    // Reset after 3 seconds
                    setTimeout(() => {
                        buttonElement.classList.remove('added');
                        successText.style.display = 'none';
                        buttonText.style.display = 'inline';
                    }, 3000);
                } else {
                    // Show error state
                    loadingText.style.display = 'none';
                    buttonText.style.display = 'inline';
                    buttonElement.classList.remove('adding');
                    showNotification('Failed to add product to cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                loadingText.style.display = 'none';
                buttonText.style.display = 'inline';
                buttonElement.classList.remove('adding');
                showNotification('Failed to add product to cart', 'error');
            });
        }

        // Legacy add to cart function (for compatibility)
        function addToCart(productId) {
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
                    // Show success message
                    showNotification('Product added to cart!', 'success');
                    // Update cart count if element exists
                    updateCartCount();
                } else {
                    showNotification('Failed to add product to cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to add product to cart', 'error');
            });
        }

        // Buy Now function
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
                    // Redirect to checkout page
                    window.location.href = '/checkout';
                } else {
                    showNotification('Failed to add product to cart', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Failed to add product to cart', 'error');
            });
        }

        // Update cart count
        function updateCartCount() {
            fetch('/cart/count')
                .then(response => response.json())
                .then(data => {
                    const cartCountElements = document.querySelectorAll('.cart-count');
                    cartCountElements.forEach(element => {
                        element.textContent = data.count;
                    });
                })
                .catch(error => console.error('Error updating cart count:', error));
        }

        // Show truck animation
        function showTruckAnimation(buttonElement) {
            // Create truck element
            const truck = document.createElement('div');
            truck.innerHTML = '🚚';
            truck.style.cssText = `
                position: fixed;
                font-size: 24px;
                z-index: 1000;
                pointer-events: none;
                transition: all 1.5s ease-in-out;
            `;

            // Get button position
            const buttonRect = buttonElement.getBoundingClientRect();
            truck.style.left = buttonRect.left + 'px';
            truck.style.top = buttonRect.top + 'px';

            document.body.appendChild(truck);

            // Animate to cart icon (top right)
            setTimeout(() => {
                truck.style.left = window.innerWidth - 100 + 'px';
                truck.style.top = '20px';
                truck.style.opacity = '0';
                truck.style.transform = 'scale(0.5)';
            }, 100);

            // Remove truck after animation
            setTimeout(() => {
                document.body.removeChild(truck);
            }, 1600);
        }

        // Show notification
        function showNotification(message, type = 'info') {
            // Create notification element
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg text-white transition-all duration-300 transform translate-x-full ${
                type === 'success' ? 'bg-green-500' :
                type === 'error' ? 'bg-red-500' :
                'bg-blue-500'
            }`;
            notification.textContent = message;

            document.body.appendChild(notification);

            // Animate in
            setTimeout(() => {
                notification.classList.remove('translate-x-full');
            }, 100);

            // Remove after 3 seconds
            setTimeout(() => {
                notification.classList.add('translate-x-full');
                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 300);
            }, 3000);
        }
    </script>

    <!-- GSAP Library for Animated Order Button -->
    <script src="https://cdn.jsdelivr.net/npm/gsap@3.0.1/dist/gsap.min.js"></script>
    <script src="{{ asset('js/animated-order-button.js') }}"></script>
    <script src="{{ asset('js/cart-animation-button.js') }}"></script>

    @stack('scripts')
</body>
</html>