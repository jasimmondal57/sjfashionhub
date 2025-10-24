<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'SJ Fashion Hub' }}</title>
    <meta name="description" content="{{ $description ?? 'Shop the latest fashion trends' }}">

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#000000">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="SJ Fashion">
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="/manifest.json">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        * {
            -webkit-tap-highlight-color: transparent;
            -webkit-touch-callout: none;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            padding-bottom: env(safe-area-inset-bottom);
        }
        
        /* App Container */
        .mobile-app-container {
            max-width: 100%;
            min-height: 100vh;
            background: #fff;
        }
        
        /* Top App Bar */
        .mobile-app-bar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: #000;
            color: #fff;
            padding: 12px 16px;
            padding-top: calc(12px + env(safe-area-inset-top));
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        
        .app-bar-title {
            font-size: 18px;
            font-weight: 600;
            flex: 1;
            text-align: center;
        }
        
        .app-bar-icon {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .app-bar-icon:active {
            background: rgba(255,255,255,0.1);
        }
        
        /* Bottom Navigation */
        .mobile-bottom-nav {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: #fff;
            border-top: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-around;
            padding: 8px 0;
            padding-bottom: calc(8px + env(safe-area-inset-bottom));
            z-index: 100;
            box-shadow: 0 -2px 8px rgba(0,0,0,0.05);
        }
        
        .nav-item {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            padding: 8px;
            text-decoration: none;
            color: #666;
            transition: all 0.2s;
            position: relative;
        }
        
        .nav-item.active {
            color: #000;
        }
        
        .nav-item:active {
            transform: scale(0.95);
        }
        
        .nav-icon {
            width: 24px;
            height: 24px;
        }
        
        .nav-label {
            font-size: 11px;
            font-weight: 500;
        }
        
        .nav-badge {
            position: absolute;
            top: 4px;
            right: 20%;
            background: #ff0000;
            color: #fff;
            font-size: 10px;
            padding: 2px 6px;
            border-radius: 10px;
            min-width: 18px;
            text-align: center;
        }
        
        /* Content Area */
        .mobile-content {
            padding-bottom: 80px;
            min-height: calc(100vh - 60px);
        }
        
        /* Category Grid */
        .category-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            padding: 16px;
        }
        
        .category-card {
            background: #fff;
            border-radius: 12px;
            padding: 16px 8px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }
        
        .category-card:active {
            transform: scale(0.95);
        }
        
        .category-icon {
            width: 48px;
            height: 48px;
            background: #f5f5f5;
            border-radius: 50%;
            margin: 0 auto 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .category-name {
            font-size: 13px;
            font-weight: 500;
            color: #333;
        }
        
        /* Product Grid */
        .product-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 12px;
            padding: 16px;
        }
        
        .product-card {
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s;
        }
        
        .product-card:active {
            transform: scale(0.98);
        }
        
        .product-image {
            width: 100%;
            aspect-ratio: 3/4;
            object-fit: cover;
            background: #f5f5f5;
        }
        
        .product-info {
            padding: 12px;
        }
        
        .product-name {
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 4px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        
        .product-price {
            font-size: 16px;
            font-weight: 600;
            color: #000;
        }
        
        .product-old-price {
            font-size: 13px;
            color: #999;
            text-decoration: line-through;
            margin-left: 6px;
        }
        
        /* Banner Slider */
        .banner-slider {
            width: 100%;
            overflow: hidden;
            position: relative;
        }
        
        .banner-slide {
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
        }
        
        /* Search Bar */
        .search-bar {
            padding: 12px 16px;
            background: #fff;
        }
        
        .search-input {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #e0e0e0;
            border-radius: 25px;
            font-size: 15px;
            background: #f5f5f5;
        }
        
        .search-input:focus {
            outline: none;
            border-color: #000;
            background: #fff;
        }
        
        /* Section Header */
        .section-header {
            padding: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #000;
        }
        
        .section-link {
            font-size: 14px;
            color: #666;
            text-decoration: none;
        }
        
        /* Floating Cart Button */
        .floating-cart {
            position: fixed;
            bottom: 80px;
            right: 16px;
            width: 56px;
            height: 56px;
            background: #000;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            z-index: 99;
            transition: transform 0.2s;
        }
        
        .floating-cart:active {
            transform: scale(0.9);
        }
        
        /* Loading Skeleton */
        .skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        /* Hide desktop elements */
        .desktop-only {
            display: none !important;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <div class="mobile-app-container">
        <!-- Top App Bar -->
        <div class="mobile-app-bar">
            <div class="app-bar-icon" onclick="window.history.back()">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </div>
            <div class="app-bar-title">{{ $appBarTitle ?? 'SJ Fashion' }}</div>
            <div class="app-bar-icon" onclick="document.getElementById('search-modal').classList.add('active')">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Main Content -->
        <div class="mobile-content">
            {{ $slot }}
        </div>

        <!-- Bottom Navigation -->
        <div class="mobile-bottom-nav">
            <a href="/" class="nav-item {{ request()->is('/') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="nav-label">Home</span>
            </a>
            
            <a href="/categories" class="nav-item {{ request()->is('categories*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                </svg>
                <span class="nav-label">Categories</span>
            </a>
            
            <a href="/cart" class="nav-item {{ request()->is('cart*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                <span class="nav-label">Cart</span>
                @if(session('cart') && count(session('cart')) > 0)
                <span class="nav-badge">{{ count(session('cart')) }}</span>
                @endif
            </a>
            
            <a href="/customer/orders" class="nav-item {{ request()->is('customer/orders*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <span class="nav-label">Orders</span>
            </a>
            
            <a href="/customer/dashboard" class="nav-item {{ request()->is('customer/dashboard*') ? 'active' : '' }}">
                <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                <span class="nav-label">Account</span>
            </a>
        </div>
    </div>

    <!-- PWA Installation Script -->
    <script src="{{ asset('js/pwa-install.js') }}"></script>
    
    @stack('scripts')
</body>
</html>

