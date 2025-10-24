<x-layouts.user title="My Wishlist" subtitle="Save your favorite items for later">
    @if($wishlistItems->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($wishlistItems as $item)
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="relative">
                        <a href="{{ route('products.show', $item->product) }}">
                            <img class="w-full h-48 object-cover" src="{{ $item->product->main_image }}" alt="{{ $item->product->name }}">
                        </a>
                        <button onclick="removeFromWishlist({{ $item->id }}, this)" class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-md hover:bg-red-50 transition-colors">
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
                        <a href="{{ route('products.show', $item->product) }}">
                            <h3 class="text-lg font-medium text-gray-900 mb-2 hover:text-gray-700">{{ $item->product->name }}</h3>
                        </a>
                        <p class="text-sm text-gray-600 mb-3">{{ Str::limit($item->product->description, 80) }}</p>

                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center space-x-2">
                                @if($item->product->is_on_sale)
                                    <span class="text-lg font-bold text-gray-900">{{ $item->product->formatted_sale_price }}</span>
                                    <span class="text-sm text-gray-500 line-through">{{ $item->product->formatted_price }}</span>
                                @else
                                    <span class="text-lg font-bold text-gray-900">{{ $item->product->formatted_price }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="flex space-x-2">
                            @php
                                $hasVariants = $item->product->activeVariants && $item->product->activeVariants->count() > 0;
                            @endphp
                            <button onclick="addToCartFromWishlist({{ $item->product->id }}, {{ $hasVariants ? 'true' : 'false' }}, '{{ $item->product->slug }}', this)"
                                    class="flex-1 bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm">
                                {{ $hasVariants ? 'Select Size' : 'Add to Cart' }}
                            </button>
                            <button onclick="removeFromWishlist({{ $item->id }}, this)"
                                    class="p-2 border border-red-300 text-red-600 rounded-md hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500"
                                    title="Remove from wishlist">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

    @push('scripts')
    <script>
        // Remove from wishlist
        async function removeFromWishlist(wishlistId, button) {
            if (!confirm('Are you sure you want to remove this item from your wishlist?')) {
                return;
            }

            try {
                const response = await fetch(`/wishlist/${wishlistId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (data.success) {
                    // Remove the card from DOM
                    const card = button.closest('.bg-white');
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.9)';

                    setTimeout(() => {
                        card.remove();

                        // Check if wishlist is empty
                        const grid = document.querySelector('.grid');
                        if (grid && grid.children.length === 0) {
                            location.reload();
                        }
                    }, 300);

                    showNotification(data.message, 'success');
                } else {
                    showNotification(data.message, 'error');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification('Failed to remove from wishlist', 'error');
            }
        }

        // Add to cart from wishlist
        async function addToCartFromWishlist(productId, hasVariants, slug, button) {
            if (hasVariants) {
                // Redirect to product page to select variant
                window.location.href = `/products/${slug}`;
                return;
            }

            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = 'Adding...';

            try {
                const response = await fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        product_id: productId,
                        quantity: 1
                    })
                });

                const data = await response.json();

                if (data.success) {
                    button.textContent = 'Added! ✓';
                    showNotification('Product added to cart', 'success');

                    setTimeout(() => {
                        button.textContent = originalText;
                        button.disabled = false;
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Failed to add to cart');
                }
            } catch (error) {
                console.error('Error:', error);
                showNotification(error.message || 'Failed to add to cart', 'error');
                button.textContent = originalText;
                button.disabled = false;
            }
        }

        // Show notification
        function showNotification(message, type = 'success') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
            notification.textContent = message;
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    </script>
    @endpush
</x-layouts.user>
