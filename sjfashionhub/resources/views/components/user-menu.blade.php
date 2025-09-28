@auth
    <!-- User Menu Dropdown -->
    <div class="relative" x-data="{ open: false }">
        <button @click="open = !open" class="flex items-center text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 bg-white border border-gray-200 px-3 py-2 hover:bg-gray-50">
            @if(Auth::user()->avatar)
                <img class="h-8 w-8 rounded-full object-cover" src="{{ Storage::url(Auth::user()->avatar) }}" alt="{{ Auth::user()->name }}">
            @else
                <div class="h-8 w-8 rounded-full bg-indigo-500 flex items-center justify-center">
                    <span class="text-white text-sm font-medium">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
            @endif
            <span class="ml-2 text-gray-700 font-medium">{{ Auth::user()->name }}</span>
            <svg class="ml-2 h-4 w-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>

        <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg py-1 z-50 border border-gray-200">
            <!-- User Info -->
            <div class="px-4 py-3 border-b border-gray-200">
                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->name }}</p>
                <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
            </div>

            <!-- Dashboard Link -->
            <a href="{{ route('user.dashboard') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                </svg>
                My Account
            </a>

            <!-- Profile Link -->
            <a href="{{ route('user.profile') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                My Profile
            </a>

            <!-- Orders Link -->
            <a href="{{ route('user.orders') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                My Orders
            </a>



            <!-- Wishlist Link -->
            <a href="{{ route('user.wishlist') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                </svg>
                Wishlist
                <span class="ml-auto bg-red-100 text-red-800 text-xs font-medium px-2 py-0.5 rounded-full">0</span>
            </a>

            <div class="border-t border-gray-200 mt-1 pt-1">
                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50">
                        <svg class="mr-3 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
@else
    <!-- Login/Register Links -->
    <div class="flex items-center space-x-3">
        <a href="{{ route('login') }}" class="flex items-center text-gray-800 hover:text-gray-900 px-3 py-2 rounded-lg text-sm font-medium border border-gray-300 hover:bg-gray-50 bg-white">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
            </svg>
            Login
        </a>
        <a href="{{ route('register') }}" class="flex items-center bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">
            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
            </svg>
            Register
        </a>
    </div>
@endauth


