<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'My Account' }} - {{ config('app.name', 'SJ Fashion Hub') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-white shadow-sm border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo -->
                    <div class="flex items-center">
                        <a href="/" class="flex items-center">
                            <img src="{{ Storage::url('logo/logo.png') }}" alt="SJ Fashion Hub" class="h-8 w-auto">
                            <span class="ml-2 text-xl font-bold text-gray-900">SJ Fashion Hub</span>
                        </a>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center space-x-4">
                        <a href="/" class="text-gray-600 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            🏠 Home
                        </a>
                        
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                @if(Auth::user()->avatar)
                                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
                                @else
                                    <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center">
                                        <span class="text-white text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <span class="ml-2 text-gray-700">{{ Auth::user()->name }}</span>
                                <svg class="ml-1 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>

                            <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                                <a href="{{ route('user.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    👤 My Account
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        🚪 Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex">
            <!-- Sidebar -->
            <div class="w-64 bg-white shadow-sm min-h-screen">
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">My Account</h2>
                    
                    <nav class="space-y-2">
                        <a href="{{ route('user.dashboard') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('user.dashboard') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('user.profile') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('user.profile') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            My Profile
                        </a>

                        <a href="{{ route('user.orders') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('user.orders') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            My Orders
                        </a>

                        <a href="{{ route('user.cart') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('user.cart') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                            </svg>
                            My Cart
                        </a>

                        <a href="{{ route('user.wishlist') }}" 
                           class="flex items-center px-3 py-2 text-sm font-medium rounded-md {{ request()->routeIs('user.wishlist') ? 'bg-indigo-100 text-indigo-700' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50' }}">
                            <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                            </svg>
                            Wishlist
                        </a>

                        <div class="border-t border-gray-200 pt-4 mt-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="flex items-center w-full px-3 py-2 text-sm font-medium text-red-600 rounded-md hover:text-red-900 hover:bg-red-50">
                                    <svg class="mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                    </svg>
                                    Logout
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 p-6">
                <!-- Page Header -->
                <div class="mb-6">
                    <h1 class="text-2xl font-bold text-gray-900">{{ $title ?? 'Dashboard' }}</h1>
                    @if(isset($subtitle))
                        <p class="text-gray-600 mt-1">{{ $subtitle }}</p>
                    @endif
                </div>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Page Content -->
                {{ $slot }}
            </div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</body>
</html>
