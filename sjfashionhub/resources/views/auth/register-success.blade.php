<x-guest-layout>
    <div class="text-center">
        <!-- Success Icon -->
        <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-green-100 dark:bg-green-900 mb-6">
            <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>

        <!-- Success Message -->
        <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4">
            🎉 Registration Successful!
        </h2>

        <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-6 mb-6">
            <p class="text-green-800 dark:text-green-200 text-lg font-medium mb-2">
                Welcome to SJ Fashion Hub!
            </p>
            <p class="text-green-700 dark:text-green-300 text-sm">
                Your account has been created successfully. You can now login with your email and password to start shopping.
            </p>
        </div>

        <!-- Account Details Summary -->
        <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-6 text-left">
            <h3 class="text-sm font-medium text-gray-900 dark:text-gray-100 mb-3">Account Details:</h3>
            <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400">
                @if(session('user_name'))
                    <div class="flex justify-between">
                        <span>Name:</span>
                        <span class="font-medium">{{ session('user_name') }}</span>
                    </div>
                @endif
                @if(session('user_email'))
                    <div class="flex justify-between">
                        <span>Email:</span>
                        <span class="font-medium">{{ session('user_email') }}</span>
                    </div>
                @endif
                @if(session('user_phone'))
                    <div class="flex justify-between">
                        <span>Phone:</span>
                        <span class="font-medium">{{ session('user_phone') }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- What's Next -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
            <h3 class="text-sm font-medium text-blue-900 dark:text-blue-100 mb-2">What's Next?</h3>
            <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1 text-left">
                <li>✅ Login to your account</li>
                <li>🛍️ Browse our latest fashion collections</li>
                <li>❤️ Add items to your wishlist</li>
                <li>🛒 Start shopping with exclusive deals</li>
                <li>📱 Get updates via SMS and email</li>
            </ul>
        </div>

        <!-- Login Button -->
        <div class="space-y-4">
            <a href="{{ route('login') }}"
               class="w-full inline-flex justify-center items-center px-6 py-4 border-2 border-indigo-600 text-base font-bold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 hover:border-indigo-700 focus:outline-none focus:ring-4 focus:ring-indigo-300 shadow-xl transition-all duration-200 transform hover:scale-105">
                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                </svg>
                🚀 Login to Your Account
            </a>

            <!-- Alternative Login Methods -->
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <p class="mb-3">Or login with:</p>
                <div class="flex justify-center space-x-4">
                    <a href="{{ route('social.redirect', 'google') }}" 
                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                        </svg>
                        Google
                    </a>
                    
                    <a href="{{ route('social.redirect', 'facebook') }}" 
                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="#1877F2" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </a>
                    
                    <a href="{{ route('mobile.login') }}" 
                       class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 dark:bg-gray-700 dark:border-gray-600 dark:text-gray-300 dark:hover:bg-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>
                        Mobile OTP
                    </a>
                </div>
            </div>
        </div>

        <!-- Home Link -->
        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ url('/') }}" class="text-sm text-gray-600 hover:text-gray-500 dark:text-gray-400 dark:hover:text-gray-300">
                ← Back to SJ Fashion Hub Home
            </a>
        </div>
    </div>

    <script>
        // Auto-redirect to login after 30 seconds (optional)
        setTimeout(function() {
            const loginBtn = document.querySelector('a[href="{{ route('login') }}"]');
            if (loginBtn && !document.hidden) {
                // Add a subtle animation to draw attention
                loginBtn.classList.add('animate-pulse');
                
                // Show countdown (optional)
                // window.location.href = "{{ route('login') }}";
            }
        }, 30000);
    </script>
</x-guest-layout>
