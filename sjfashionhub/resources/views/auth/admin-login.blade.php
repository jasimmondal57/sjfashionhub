<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login - {{ config('app.name', 'SJ Fashion Hub') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        <!-- Logo -->
        <div class="mb-6">
            <a href="/" class="flex items-center">
                @php
                    $headerSettings = \App\Models\HeaderSetting::getActiveSettings();
                @endphp
                @if($headerSettings && $headerSettings->logo_image)
                    <img src="{{ Storage::url($headerSettings->logo_image) }}" alt="{{ config('app.name') }}" class="h-16 w-auto">
                @else
                    <!-- Fallback text logo -->
                    <div class="flex flex-col items-center justify-center bg-gradient-to-br from-purple-600 to-pink-600 text-white rounded-lg shadow-lg p-4">
                        <div class="text-2xl font-bold mb-1">👗</div>
                        <div class="text-lg font-bold">SJ</div>
                        <div class="text-sm font-medium">FASHION</div>
                        <div class="text-xs">HUB</div>
                    </div>
                @endif
            </a>
        </div>

        <!-- Admin Login Card -->
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-2xl overflow-hidden sm:rounded-lg border border-gray-200">
            <!-- Header -->
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Admin Login</h2>
                <p class="text-sm text-gray-600">Access the administration panel</p>
            </div>

            <!-- Session Status -->
            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 bg-green-50 border border-green-200 rounded-lg p-3">
                    {{ session('status') }}
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 rounded-lg p-3">
                    <div class="text-sm text-red-600">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}" id="admin-login-form">
                @csrf

                <!-- Email Address -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                    <input id="email"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('email') border-red-300 @enderror"
                           type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           autofocus
                           autocomplete="username"
                           placeholder="Enter your admin email">
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input id="password"
                           class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('password') border-red-300 @enderror"
                           type="password"
                           name="password"
                           required
                           autocomplete="current-password"
                           placeholder="Enter your password">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mb-6">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me"
                               type="checkbox"
                               class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500"
                               name="remember">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-600 hover:text-blue-500 underline" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <div class="mb-6">
                    <button type="submit"
                            id="admin-login-btn"
                            class="w-full flex justify-center py-2 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition duration-150 ease-in-out">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        Login to Admin Panel
                    </button>
                </div>

                <!-- Divider -->
                <div class="relative mb-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">or</span>
                    </div>
                </div>

                <!-- Customer Login Link -->
                <div class="text-center">
                    <p class="text-sm text-gray-600">
                        Not an admin? 
                        <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-500">
                            Customer Login
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>
    </div>

    <!-- Admin Login Loading Popup -->
    <div id="admin-login-loading-popup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden backdrop-blur-sm">
        <div class="bg-white rounded-lg shadow-2xl p-8 max-w-sm mx-4 text-center animate-popup-in">
            <!-- Animated Spinner -->
            <div class="mb-6 flex justify-center">
                <div class="relative w-20 h-20">
                    <!-- Outer rotating circle -->
                    <div class="absolute inset-0 rounded-full border-4 border-gray-100 animate-spin-slow"></div>

                    <!-- Inner pulsing circle -->
                    <div class="absolute inset-2 rounded-full border-2 border-blue-600 animate-pulse"></div>

                    <!-- Center dot -->
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="w-3 h-3 bg-blue-600 rounded-full animate-bounce-slow"></div>
                    </div>
                </div>
            </div>

            <!-- Loading Text -->
            <h3 class="text-xl font-semibold text-gray-900 mb-2 animate-fade-in" style="animation-delay: 0.2s;">Logging you in...</h3>
            <p class="text-gray-600 text-sm animate-fade-in" style="animation-delay: 0.4s;">Please wait while we verify your admin credentials and load the admin panel</p>

            <!-- Animated Dots -->
            <div class="mt-4 flex justify-center space-x-1">
                <span class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0s;"></span>
                <span class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.2s;"></span>
                <span class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0.4s;"></span>
            </div>

            <!-- Progress Bar -->
            <div class="mt-6 w-full bg-gray-200 rounded-full h-1 overflow-hidden">
                <div class="bg-blue-600 h-full animate-progress-bar" style="width: 100%;"></div>
            </div>
        </div>
    </div>

    <!-- Admin Login Specific Styles -->
    <style>
        body {
            background-image:
                radial-gradient(circle at 25% 25%, rgba(59, 130, 246, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(99, 102, 241, 0.1) 0%, transparent 50%);
        }

        .shadow-2xl {
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        input:focus {
            transform: translateY(-1px);
            transition: all 0.2s ease-in-out;
        }

        button:hover {
            transform: translateY(-1px);
            transition: all 0.2s ease-in-out;
        }

        /* Loading Popup Animations */
        @keyframes popup-in {
            from {
                opacity: 0;
                transform: scale(0.8);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes fade-in {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes bounce-slow {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.2);
            }
        }

        @keyframes progress-bar {
            0% {
                opacity: 0.3;
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0.3;
            }
        }

        .animate-popup-in {
            animation: popup-in 0.4s ease-out;
        }

        .animate-fade-in {
            animation: fade-in 0.6s ease-out forwards;
            opacity: 0;
        }

        .animate-spin-slow {
            animation: spin-slow 3s linear infinite;
        }

        .animate-bounce-slow {
            animation: bounce-slow 1.5s ease-in-out infinite;
        }

        .animate-progress-bar {
            animation: progress-bar 1.5s ease-in-out infinite;
        }

        .backdrop-blur-sm {
            backdrop-filter: blur(4px);
        }
    </style>

    <!-- Admin Login Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const adminLoginForm = document.getElementById('admin-login-form');
            const adminLoginBtn = document.getElementById('admin-login-btn');
            const adminLoadingPopup = document.getElementById('admin-login-loading-popup');

            if (adminLoginForm) {
                adminLoginForm.addEventListener('submit', function(e) {
                    // Show loading popup
                    adminLoadingPopup.classList.remove('hidden');

                    // Disable button to prevent multiple submissions
                    if (adminLoginBtn) {
                        adminLoginBtn.disabled = true;
                    }
                });
            }
        });

        // Disable right-click context menu for security
        document.addEventListener('contextmenu', function(e) {
            e.preventDefault();
        });

        // Disable F12 and other developer tools shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.key === 'F12' ||
                (e.ctrlKey && e.shiftKey && e.key === 'I') ||
                (e.ctrlKey && e.shiftKey && e.key === 'C') ||
                (e.ctrlKey && e.shiftKey && e.key === 'J') ||
                (e.ctrlKey && e.key === 'U')) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
