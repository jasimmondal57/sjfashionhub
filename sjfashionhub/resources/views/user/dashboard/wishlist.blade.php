<x-layouts.user title="My Wishlist" subtitle="Save your favorite items for later">
    @if($wishlistItems->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($wishlistItems as $item)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="relative">
                        <img class="w-full h-48 object-cover" src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}">
                        <button class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-gray-50">
                            <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        @if($item->product->discount_percentage > 0)
                            <div class="absolute top-2 left-2 bg-red-500 text-white px-2 py-1 rounded-md text-xs font-medium">
                                -{{ $item->product->discount_percentage }}%
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ $item->product->name }}</h3>
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($item->product->description, 80) }}</p>
                        
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                @if($item->product->discount_percentage > 0)
                                    <span class="text-lg font-bold text-gray-900">${{ number_format($item->product->discounted_price, 2) }}</span>
                                    <span class="text-sm text-gray-500 line-through">${{ number_format($item->product->price, 2) }}</span>
                                @else
                                    <span class="text-lg font-bold text-gray-900">${{ number_format($item->product->price, 2) }}</span>
                                @endif
                            </div>
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="h-4 w-4 {{ $i <= $item->product->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                                <span class="ml-1 text-sm text-gray-600">({{ $item->product->reviews_count }})</span>
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            <button class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                                Add to Cart
                            </button>
                            <button class="p-2 border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                <svg class="h-5 w-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $wishlistItems->links() }}
        </div>
    @else
        <!-- Empty Wishlist -->
        <div class="text-center py-12">
            <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-900">Your wishlist is empty</h3>
            <p class="mt-2 text-gray-600">Save items you love to your wishlist so you can easily find them later.</p>
            <div class="mt-6">
                <a href="/" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                    Start Shopping
                </a>
            </div>
        </div>
    @endif

    <!-- Wishlist Actions -->
    @if($wishlistItems->count() > 0)
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Wishlist Actions</h3>
                    <p class="text-sm text-gray-600">Manage your saved items</p>
                </div>
                <div class="flex space-x-3">
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm">
                        Add All to Cart
                    </button>
                    <button class="border border-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-50 text-sm">
                        Share Wishlist
                    </button>
                    <button class="border border-red-300 text-red-700 px-4 py-2 rounded-md hover:bg-red-50 text-sm">
                        Clear Wishlist
                    </button>
                </div>
            </div>
        </div>
    @endif
</x-layouts.user>
