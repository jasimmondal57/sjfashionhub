<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mobile App Admin - SJ Fashion Hub</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100" x-data="{ sidebarOpen: false }">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div class="hidden lg:flex lg:flex-shrink-0">
            <div class="flex flex-col w-64 bg-gradient-to-b from-purple-900 to-indigo-900">
                <!-- Logo -->
                <div class="flex items-center justify-center h-16 px-4 bg-purple-950">
                    <h1 class="text-xl font-bold text-white">📱 Mobile Admin</h1>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
                    <a href="{{ route('mobileadmin.dashboard') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('mobileadmin.dashboard') ? 'bg-white bg-opacity-20 text-white' : 'text-purple-100 hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-home w-5 mr-3"></i>
                        Dashboard
                    </a>

                    <a href="{{ route('mobileadmin.settings') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('mobileadmin.settings') ? 'bg-white bg-opacity-20 text-white' : 'text-purple-100 hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-cog w-5 mr-3"></i>
                        App Settings
                    </a>

                    <a href="{{ route('mobileadmin.sections.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('mobileadmin.sections*') ? 'bg-white bg-opacity-20 text-white' : 'text-purple-100 hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-layer-group w-5 mr-3"></i>
                        Home Sections
                    </a>

                    <a href="{{ route('mobileadmin.banners.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('mobileadmin.banners*') ? 'bg-white bg-opacity-20 text-white' : 'text-purple-100 hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-image w-5 mr-3"></i>
                        Banners
                    </a>

                    <a href="{{ route('mobileadmin.menu.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('mobileadmin.menu*') ? 'bg-white bg-opacity-20 text-white' : 'text-purple-100 hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-bars w-5 mr-3"></i>
                        Navigation Menu
                    </a>

                    <a href="{{ route('mobileadmin.theme') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('mobileadmin.theme') ? 'bg-white bg-opacity-20 text-white' : 'text-purple-100 hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-palette w-5 mr-3"></i>
                        Theme & Colors
                    </a>

                    <a href="{{ route('mobileadmin.notifications.index') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('mobileadmin.notifications*') ? 'bg-white bg-opacity-20 text-white' : 'text-purple-100 hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-bell w-5 mr-3"></i>
                        Push Notifications
                    </a>

                    <a href="{{ route('mobileadmin.analytics') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('mobileadmin.analytics') ? 'bg-white bg-opacity-20 text-white' : 'text-purple-100 hover:bg-white hover:bg-opacity-10' }}">
                        <i class="fas fa-chart-line w-5 mr-3"></i>
                        Analytics
                    </a>

                    <div class="border-t border-purple-700 my-4"></div>

                    <a href="{{ route('admin.dashboard') }}" 
                       class="flex items-center px-4 py-3 text-sm font-medium rounded-lg text-purple-100 hover:bg-white hover:bg-opacity-10">
                        <i class="fas fa-arrow-left w-5 mr-3"></i>
                        Back to Main Admin
                    </a>
                </nav>

                <!-- User Info -->
                <div class="flex-shrink-0 p-4 border-t border-purple-700">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-10 h-10 rounded-full bg-purple-600 flex items-center justify-center text-white font-bold">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-xs text-purple-200 hover:text-white">Logout</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile sidebar -->
        <div x-show="sidebarOpen" 
             x-cloak
             @click="sidebarOpen = false"
             class="fixed inset-0 z-40 lg:hidden">
            <div class="fixed inset-0 bg-gray-600 bg-opacity-75"></div>
            <div @click.stop class="fixed inset-y-0 left-0 flex flex-col w-64 bg-gradient-to-b from-purple-900 to-indigo-900">
                <!-- Same navigation as desktop -->
                <div class="flex items-center justify-between h-16 px-4 bg-purple-950">
                    <h1 class="text-xl font-bold text-white">📱 Mobile Admin</h1>
                    <button @click="sidebarOpen = false" class="text-white">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <nav class="flex-1 px-2 py-4 space-y-1 overflow-y-auto">
                    <!-- Same links as desktop -->
                </nav>
            </div>
        </div>

        <!-- Main content -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Top bar -->
            <div class="flex items-center justify-between h-16 px-4 bg-white border-b border-gray-200 lg:px-8">
                <button @click="sidebarOpen = true" class="text-gray-500 lg:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <div class="flex items-center space-x-4">
                    <div class="text-sm text-gray-600">
                        <i class="fas fa-globe mr-2"></i>
                        API: <span class="font-mono text-blue-600">{{ url('/api/mobile') }}</span>
                    </div>
                </div>
            </div>

            <!-- Page content -->
            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <i class="fas fa-check-circle mr-2"></i>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div x-data="{ show: true }" 
             x-show="show" 
             x-init="setTimeout(() => show = false, 3000)"
             class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
            <i class="fas fa-exclamation-circle mr-2"></i>
            {{ session('error') }}
        </div>
    @endif

    @if($errors->any())
        <div x-data="{ show: true }" 
             x-show="show" 
             class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 max-w-md">
            <div class="flex items-start">
                <i class="fas fa-exclamation-circle mr-2 mt-1"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <p class="text-sm">{{ $error }}</p>
                    @endforeach
                </div>
                <button @click="show = false" class="ml-4 text-white hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
        </div>
    @endif
</body>
</html>

