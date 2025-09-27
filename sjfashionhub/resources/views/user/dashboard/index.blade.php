<x-layouts.user title="Dashboard" subtitle="Welcome back, {{ $user->name }}!">
    <!-- Welcome Card -->
    <div class="bg-gradient-to-r from-indigo-500 to-purple-600 rounded-lg shadow-lg p-6 text-white mb-6">
        <div class="flex items-center">
            @if($user->avatar)
                <img class="h-16 w-16 rounded-full object-cover border-4 border-white" src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}">
            @else
                <div class="h-16 w-16 rounded-full bg-white bg-opacity-20 flex items-center justify-center border-4 border-white">
                    <span class="text-2xl font-bold">{{ substr($user->name, 0, 1) }}</span>
                </div>
            @endif
            <div class="ml-4">
                <h2 class="text-2xl font-bold">Welcome back, {{ $user->name }}!</h2>
                <p class="text-indigo-100">Manage your account and track your orders</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        <!-- Total Orders -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Total Orders</p>
                    <p class="text-2xl font-semibold text-gray-900">0</p>
                </div>
            </div>
        </div>

        <!-- Cart Items -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Cart Items</p>
                    <p class="text-2xl font-semibold text-gray-900">0</p>
                </div>
            </div>
        </div>

        <!-- Wishlist Items -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Wishlist</p>
                    <p class="text-2xl font-semibold text-gray-900">0</p>
                </div>
            </div>
        </div>

        <!-- Account Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-600">Account Status</p>
                    <p class="text-lg font-semibold text-green-600">Verified</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        <!-- Update Profile -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center">
                <div class="mx-auto h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center mb-4">
                    <svg class="h-6 w-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Update Profile</h3>
                <p class="text-gray-600 text-sm mb-4">Edit your personal information and profile picture</p>
                <a href="{{ route('user.profile') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Edit Profile
                </a>
            </div>
        </div>

        <!-- View Orders -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center">
                <div class="mx-auto h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center mb-4">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">My Orders</h3>
                <p class="text-gray-600 text-sm mb-4">Track your orders and view order history</p>
                <a href="{{ route('user.orders') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                    View Orders
                </a>
            </div>
        </div>

        <!-- Shopping Cart -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="text-center">
                <div class="mx-auto h-12 w-12 rounded-full bg-green-100 flex items-center justify-center mb-4">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m8 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Shopping Cart</h3>
                <p class="text-gray-600 text-sm mb-4">Review items in your cart and proceed to checkout</p>
                <a href="{{ route('user.cart') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                    View Cart
                </a>
            </div>
        </div>
    </div>

    <!-- Account Information -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Account Information</h3>
        </div>
        <div class="p-6">
            <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                <div>
                    <dt class="text-sm font-medium text-gray-500">Full Name</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $user->name }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email Address</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $user->email }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $user->phone ?? 'Not provided' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                    <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F j, Y') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Email Verified</dt>
                    <dd class="mt-1 text-sm">
                        @if($user->email_verified_at)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                ✓ Verified
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                ✗ Not Verified
                            </span>
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500">Phone Verified</dt>
                    <dd class="mt-1 text-sm">
                        @if($user->phone_verified_at)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                ✓ Verified
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                ✗ Not Verified
                            </span>
                        @endif
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</x-layouts.user>
