<x-layouts.admin>
    <x-slot name="title">Categories Management - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">Manage your product categories</x-slot>
    <x-slot name="pageTitle">📂 Categories Management</x-slot>

    <!-- Header Actions -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600">Organize your products with categories</p>
        </div>
        <div class="flex space-x-3">
            <button onclick="toggleSortMode()" id="sortToggle" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                </svg>
                <span class="sort-btn-text">Sort Categories</span>
            </button>
            <button onclick="openQuickSort()" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
                Quick Sort
            </button>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add New Category
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 mb-8">
        <!-- Total -->
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-600">Total</p>
                    <p class="text-xl font-bold text-black">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <!-- Active -->
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-600">Active</p>
                    <p class="text-xl font-bold text-black">{{ $stats['active'] }}</p>
                </div>
            </div>
        </div>

        <!-- Inactive -->
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-600">Inactive</p>
                    <p class="text-xl font-bold text-black">{{ $stats['inactive'] }}</p>
                </div>
            </div>
        </div>

        <!-- Parent -->
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-600">Parent</p>
                    <p class="text-xl font-bold text-black">{{ $stats['parent'] }}</p>
                </div>
            </div>
        </div>

        <!-- Child -->
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-600">Child</p>
                    <p class="text-xl font-bold text-black">{{ $stats['child'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sort Mode Notification -->
    <div id="sortNotification" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="flex-1">
                <h4 class="text-sm font-medium text-blue-800">Sort Mode Active</h4>
                <p class="text-sm text-blue-700">Drag and drop categories to reorder them. Changes are saved automatically.</p>
            </div>
            <button onclick="toggleSortMode()" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                Exit Sort Mode
            </button>
        </div>
    </div>

    <!-- Categories Table -->
    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-black">All Categories</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <span class="sort-handle-header hidden">⋮⋮</span>
                            <span class="normal-header">Category</span>
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sort Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="sortableTable" class="bg-white divide-y divide-gray-200">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 sortable-row" data-category-id="{{ $category->id }}">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <!-- Drag Handle -->
                                    <div class="drag-handle hidden mr-3 cursor-move text-gray-400 hover:text-gray-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                        </svg>
                                    </div>
                                    <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center mr-3 overflow-hidden">
                                        @if($category->image)
                                            <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-black">{{ $category->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($category->description, 50) }}</div>
                                        <div class="text-xs text-gray-400">{{ $category->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($category->parent)
                                    <span class="text-sm text-gray-900">{{ $category->parent->name }}</span>
                                @else
                                    <span class="text-sm text-gray-500">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    #{{ $category->sort_order }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="text-sm text-gray-900">{{ $category->products_count }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <form action="{{ route('admin.categories.toggle', $category) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-gray-100 text-gray-800 hover:bg-gray-200' }}">
                                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.categories.show', $category) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <button onclick="deleteCategory({{ $category->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No categories</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new category.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                                            Add New Category
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

    <!-- Quick Sort Modal -->
    <div id="quickSortModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
        <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Quick Sort Options</h3>
                    <button onclick="closeQuickSort()" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="space-y-3">
                    <button onclick="sortCategories('name_asc')" class="w-full text-left px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">
                        Sort by Name (A-Z)
                    </button>
                    <button onclick="sortCategories('name_desc')" class="w-full text-left px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">
                        Sort by Name (Z-A)
                    </button>
                    <button onclick="sortCategories('products_asc')" class="w-full text-left px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">
                        Sort by Product Count (Low to High)
                    </button>
                    <button onclick="sortCategories('products_desc')" class="w-full text-left px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">
                        Sort by Product Count (High to Low)
                    </button>
                    <button onclick="sortCategories('created_asc')" class="w-full text-left px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">
                        Sort by Date Created (Oldest First)
                    </button>
                    <button onclick="sortCategories('created_desc')" class="w-full text-left px-4 py-2 bg-gray-50 hover:bg-gray-100 rounded-md">
                        Sort by Date Created (Newest First)
                    </button>
                </div>
                <div class="mt-6 flex justify-end space-x-3">
                    <button onclick="closeQuickSort()" class="btn btn-secondary">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        let sortMode = false;
        let sortable = null;

        function toggleSortMode() {
            sortMode = !sortMode;
            const notification = document.getElementById('sortNotification');
            const toggleBtn = document.getElementById('sortToggle');
            const dragHandles = document.querySelectorAll('.drag-handle');
            const sortHandleHeader = document.querySelector('.sort-handle-header');
            const normalHeader = document.querySelector('.normal-header');

            if (sortMode) {
                // Enable sort mode
                notification.classList.remove('hidden');
                document.querySelector('.sort-btn-text').textContent = 'Exit Sort Mode';
                toggleBtn.classList.remove('btn-secondary');
                toggleBtn.classList.add('btn-danger');

                // Show drag handles
                dragHandles.forEach(handle => handle.classList.remove('hidden'));
                sortHandleHeader.classList.remove('hidden');
                normalHeader.classList.add('hidden');

                // Initialize sortable
                const table = document.getElementById('sortableTable');
                sortable = Sortable.create(table, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    onEnd: function(evt) {
                        updateSortOrder();
                    }
                });
            } else {
                // Disable sort mode
                notification.classList.add('hidden');
                toggleBtn.innerHTML = `
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                    </svg>
                    Sort Categories
                `;
                toggleBtn.classList.remove('btn-danger');
                toggleBtn.classList.add('btn-secondary');

                // Hide drag handles
                dragHandles.forEach(handle => handle.classList.add('hidden'));
                sortHandleHeader.classList.add('hidden');
                normalHeader.classList.remove('hidden');

                // Destroy sortable
                if (sortable) {
                    sortable.destroy();
                    sortable = null;
                }
            }
        }

        function updateSortOrder() {
            const rows = document.querySelectorAll('.sortable-row');
            const categoryIds = Array.from(rows).map(row => row.dataset.categoryId);

            fetch('/admin/categories/sort', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    category_ids: categoryIds
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update sort order numbers in the table
                    rows.forEach((row, index) => {
                        const sortOrderCell = row.querySelector('td:nth-child(3) span');
                        if (sortOrderCell) {
                            sortOrderCell.textContent = index + 1;
                        }
                    });
                } else {
                    alert('Failed to update sort order. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update sort order. Please try again.');
            });
        }

        function openQuickSort() {
            document.getElementById('quickSortModal').classList.remove('hidden');
        }

        function closeQuickSort() {
            document.getElementById('quickSortModal').classList.add('hidden');
        }

        function sortCategories(sortType) {
            fetch('/admin/categories/quick-sort', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    sort_type: sortType
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeQuickSort();
                    location.reload(); // Reload to show new order
                } else {
                    alert('Failed to sort categories. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to sort categories. Please try again.');
            });
        }

        function deleteCategory(categoryId) {
            if (confirm('Are you sure you want to delete this category? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/categories/${categoryId}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>

    <style>
        .sortable-ghost {
            opacity: 0.4;
            background: #f3f4f6;
        }

        .sortable-chosen {
            background: #e5e7eb;
        }

        .sortable-drag {
            background: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .drag-handle {
            transition: all 0.2s ease;
        }

        .drag-handle:hover {
            transform: scale(1.1);
        }
    </style>
</x-layouts.admin>
