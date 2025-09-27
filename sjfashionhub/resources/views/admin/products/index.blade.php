<x-layouts.admin>
    <x-slot name="title">Products Management - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">Manage your product catalog</x-slot>
    <x-slot name="pageTitle">📦 Products Management</x-slot>

    <!-- Header Actions -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600">Manage your product catalog and inventory</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Product
        </a>
    </div>

    <!-- Search and Filters -->
    <div class="bg-white rounded-lg border border-gray-100 p-6 mb-6">
        <form method="GET" action="{{ route('admin.products.index') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Products</label>
                    <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Search by name, description, or SKU"
                           class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category" id="category"
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="status" id="status"
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700 mb-2">Sort By</label>
                    <select name="sort" id="sort"
                            class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>Date Created</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                        <option value="stock_quantity" {{ request('sort') == 'stock_quantity' ? 'selected' : '' }}>Stock</option>
                    </select>
                </div>
            </div>

            <div class="flex justify-between items-center">
                <div class="flex space-x-2">
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline">Clear</a>
                </div>

                <div class="text-sm text-gray-600">
                    Showing {{ $products->firstItem() ?? 0 }} to {{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                </div>
            </div>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Products</p>
                    <p class="text-lg font-bold text-black">{{ $products->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Active</p>
                    <p class="text-lg font-bold text-black">{{ $products->where('is_active', true)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Low Stock</p>
                    <p class="text-lg font-bold text-black">{{ $products->where('stock_quantity', '<', 10)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2H9a2 2 0 00-2 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Categories</p>
                    <p class="text-lg font-bold text-black">{{ $products->pluck('category_id')->unique()->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bulk Actions -->
    @if($products->count() > 0)
    <div class="bg-white rounded-lg border border-gray-100 p-4 mb-6">
        <form id="bulk-action-form" method="POST" action="{{ route('admin.products.bulk-action') }}">
            @csrf
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    <label class="flex items-center">
                        <input type="checkbox" id="select-all" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        <span class="ml-2 text-sm text-gray-700">Select All</span>
                    </label>

                    <select name="action" id="bulk-action" class="px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Bulk Actions</option>
                        <option value="activate">Activate Selected</option>
                        <option value="deactivate">Deactivate Selected</option>
                        <option value="delete">Delete Selected</option>
                    </select>

                    <button type="submit" class="btn btn-outline" onclick="return confirmBulkAction()">Apply</button>
                </div>

                <div class="text-sm text-gray-600">
                    <span id="selected-count">0</span> items selected
                </div>
            </div>
        </form>
    </div>
    @endif

    <!-- Products Table -->
    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-black">All Products</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="select-all-table" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SEO</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <input type="checkbox" name="products[]" value="{{ $product->id }}" form="bulk-action-form" class="product-checkbox rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center mr-3 overflow-hidden">
                                        @if($product->images && count($product->images) > 0)
                                            <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-black">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</div>
                                        @if($product->sku)
                                            <div class="text-xs text-gray-400">SKU: {{ $product->sku }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $product->category->name ?? 'No Category' }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm font-medium text-black">₹{{ number_format($product->price, 2) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->manage_stock)
                                    <span class="text-sm {{ $product->stock_quantity < 10 ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $product->stock_quantity }}
                                    </span>
                                @else
                                    <span class="text-sm text-gray-500">Not tracked</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->seo_title)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        ✓ SEO Ready
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Needs SEO
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="text-blue-600 hover:text-blue-900">View</a>
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>

                                    <!-- Social Media Posting -->
                                    <div class="relative inline-block text-left">
                                        <button onclick="toggleSocialDropdown({{ $product->id }})" class="text-green-600 hover:text-green-900 flex items-center">
                                            📱 Share
                                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                            </svg>
                                        </button>

                                        <div id="social-dropdown-{{ $product->id }}" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-md shadow-lg border border-gray-200 z-50">
                                            <div class="py-1">
                                                <button onclick="postToAllPlatforms({{ $product->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                    🚀 Post to All Platforms
                                                </button>
                                                <hr class="my-1">
                                                <button onclick="postToSingle({{ $product->id }}, 'instagram')"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                    📷 Instagram
                                                </button>
                                                <button onclick="postToSingle({{ $product->id }}, 'facebook')"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                    📘 Facebook
                                                </button>
                                                <button onclick="postToSingle({{ $product->id }}, 'twitter')"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                    🐦 Twitter/X
                                                </button>
                                                <button onclick="postToSingle({{ $product->id }}, 'linkedin')"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                    💼 LinkedIn
                                                </button>
                                                <button onclick="postToSingle({{ $product->id }}, 'pinterest')"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                    📌 Pinterest
                                                </button>
                                                <button onclick="postToSingle({{ $product->id }}, 'tiktok')"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                    🎵 TikTok
                                                </button>
                                                <button onclick="postToSingle({{ $product->id }}, 'threads')"
                                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 flex items-center">
                                                    🧵 Threads
                                                </button>
                                                <hr class="my-1">
                                                <button onclick="viewProductPosts({{ $product->id }})"
                                                        class="w-full text-left px-4 py-2 text-sm text-blue-600 hover:bg-blue-50 flex items-center">
                                                    📊 View Posts History
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <button onclick="deleteProduct({{ $product->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No products</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new product.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                                            Add New Product
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($products->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $products->links() }}
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/products/${productId}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Social Media Functions
        function toggleSocialDropdown(productId) {
            // Close all other dropdowns
            document.querySelectorAll('[id^="social-dropdown-"]').forEach(dropdown => {
                if (dropdown.id !== `social-dropdown-${productId}`) {
                    dropdown.classList.add('hidden');
                }
            });

            // Toggle current dropdown
            const dropdown = document.getElementById(`social-dropdown-${productId}`);
            dropdown.classList.toggle('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('[onclick*="toggleSocialDropdown"]') &&
                !event.target.closest('[id^="social-dropdown-"]')) {
                document.querySelectorAll('[id^="social-dropdown-"]').forEach(dropdown => {
                    dropdown.classList.add('hidden');
                });
            }
        });

        function postToAllPlatforms(productId) {
            if (!confirm('Post this product to all active social media platforms?')) {
                return;
            }

            showLoadingMessage('Posting to all platforms...');

            fetch(`/admin/social-media/products/${productId}/post-all`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                hideLoadingMessage();

                if (data.success) {
                    showSuccessMessage(`Posted to ${data.stats.success} platforms successfully! ${data.stats.failed} failed.`);

                    // Show detailed results
                    let details = 'Results:\n';
                    Object.entries(data.results).forEach(([platform, result]) => {
                        details += `${platform}: ${result.success ? '✅ Success' : '❌ ' + result.message}\n`;
                    });

                    setTimeout(() => {
                        alert(details);
                    }, 1000);
                } else {
                    showErrorMessage(data.message);
                }
            })
            .catch(error => {
                hideLoadingMessage();
                showErrorMessage('An error occurred while posting to social media.');
                console.error('Error:', error);
            });
        }

        function postToSingle(productId, platform) {
            if (!confirm(`Post this product to ${platform}?`)) {
                return;
            }

            showLoadingMessage(`Posting to ${platform}...`);

            fetch(`/admin/social-media/products/${productId}/post/${platform}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                hideLoadingMessage();

                if (data.success) {
                    showSuccessMessage(data.message);
                } else {
                    showErrorMessage(data.message);
                }
            })
            .catch(error => {
                hideLoadingMessage();
                showErrorMessage(`An error occurred while posting to ${platform}.`);
                console.error('Error:', error);
            });
        }

        function viewProductPosts(productId) {
            // Open posts history in a modal or new page
            window.open(`/admin/social-media/products/${productId}/posts`, '_blank');
        }

        function showLoadingMessage(message) {
            // Create or update loading overlay
            let overlay = document.getElementById('loading-overlay');
            if (!overlay) {
                overlay = document.createElement('div');
                overlay.id = 'loading-overlay';
                overlay.className = 'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                overlay.innerHTML = `
                    <div class="bg-white rounded-lg p-6 max-w-sm mx-4">
                        <div class="flex items-center space-x-3">
                            <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                            <span id="loading-message" class="text-gray-900">${message}</span>
                        </div>
                    </div>
                `;
                document.body.appendChild(overlay);
            } else {
                document.getElementById('loading-message').textContent = message;
                overlay.classList.remove('hidden');
            }
        }

        function hideLoadingMessage() {
            const overlay = document.getElementById('loading-overlay');
            if (overlay) {
                overlay.classList.add('hidden');
            }
        }

        function showSuccessMessage(message) {
            showToast(message, 'success');
        }

        function showErrorMessage(message) {
            showToast(message, 'error');
        }

        function showToast(message, type) {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 ${
                type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
            }`;
            toast.textContent = message;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.remove();
            }, 5000);
        }

        // Bulk action functionality
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckboxes = document.querySelectorAll('#select-all, #select-all-table');
            const productCheckboxes = document.querySelectorAll('.product-checkbox');
            const selectedCountElement = document.getElementById('selected-count');

            // Select all functionality
            selectAllCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    productCheckboxes.forEach(productCheckbox => {
                        productCheckbox.checked = this.checked;
                    });
                    updateSelectedCount();
                    syncSelectAllCheckboxes();
                });
            });

            // Individual checkbox functionality
            productCheckboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function() {
                    updateSelectedCount();
                    syncSelectAllCheckboxes();
                });
            });

            function updateSelectedCount() {
                const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
                if (selectedCountElement) {
                    selectedCountElement.textContent = checkedBoxes.length;
                }
            }

            function syncSelectAllCheckboxes() {
                const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');
                const allChecked = checkedBoxes.length === productCheckboxes.length && productCheckboxes.length > 0;

                selectAllCheckboxes.forEach(checkbox => {
                    checkbox.checked = allChecked;
                });
            }

            // Initialize count
            updateSelectedCount();
        });

        function confirmBulkAction() {
            const action = document.getElementById('bulk-action').value;
            const checkedBoxes = document.querySelectorAll('.product-checkbox:checked');

            if (!action) {
                alert('Please select an action.');
                return false;
            }

            if (checkedBoxes.length === 0) {
                alert('Please select at least one product.');
                return false;
            }

            let message = '';
            switch(action) {
                case 'delete':
                    message = `Are you sure you want to delete ${checkedBoxes.length} selected products? This action cannot be undone.`;
                    break;
                case 'activate':
                    message = `Are you sure you want to activate ${checkedBoxes.length} selected products?`;
                    break;
                case 'deactivate':
                    message = `Are you sure you want to deactivate ${checkedBoxes.length} selected products?`;
                    break;
            }

            return confirm(message);
        }
    </script>
    @endpush
</x-layouts.admin>
