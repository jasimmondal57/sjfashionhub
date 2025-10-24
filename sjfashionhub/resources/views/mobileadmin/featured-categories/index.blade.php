<x-layouts.mobileadmin>
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">🏷️ Shop by Category</h1>
                <p class="text-gray-600 mt-1">Manage featured categories for the mobile app</p>
            </div>
        </div>

        <!-- Add New Featured Category -->
        <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Add Featured Category</h2>
            
            <form action="{{ route('mobileadmin.featured-categories.store') }}" method="POST" class="flex gap-4">
                @csrf
                <div class="flex-1">
                    <select name="category_id" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                        <option value="">Select a category...</option>
                        @foreach($availableCategories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition-all">
                    <i class="fas fa-plus mr-2"></i>Add Category
                </button>
            </form>
        </div>

        <!-- Featured Categories List -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">Featured Categories</h2>
                <p class="text-sm text-gray-600 mt-1">Drag to reorder • First 4 categories will show in the app</p>
            </div>

            @if($featuredCategories->count() > 0)
                <div id="sortable-categories" class="divide-y divide-gray-200">
                    @foreach($featuredCategories as $featuredCategory)
                        <div class="p-4 flex items-center justify-between hover:bg-gray-50 cursor-move" data-id="{{ $featuredCategory->id }}">
                            <div class="flex items-center space-x-4">
                                <!-- Drag Handle -->
                                <div class="text-gray-400">
                                    <i class="fas fa-grip-vertical"></i>
                                </div>
                                
                                <!-- Order Badge -->
                                <div class="flex-shrink-0">
                                    <span class="inline-flex items-center justify-center w-8 h-8 bg-purple-100 text-purple-800 text-sm font-semibold rounded-full">
                                        {{ $featuredCategory->order }}
                                    </span>
                                </div>

                                <!-- Category Info -->
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900">{{ $featuredCategory->category->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $featuredCategory->category->slug }}</p>
                                </div>

                                <!-- Status -->
                                <div class="flex-shrink-0">
                                    @if($featuredCategory->is_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Inactive
                                        </span>
                                    @endif
                                </div>

                                <!-- Show in App Badge -->
                                @if($loop->index < 4)
                                    <div class="flex-shrink-0">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Shows in App
                                        </span>
                                    </div>
                                @endif
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center space-x-2">
                                <!-- Toggle Active -->
                                <form action="{{ route('mobileadmin.featured-categories.update', $featuredCategory) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="is_active" value="{{ $featuredCategory->is_active ? '0' : '1' }}">
                                    <button type="submit" class="text-sm px-3 py-1 rounded {{ $featuredCategory->is_active ? 'bg-yellow-100 text-yellow-700 hover:bg-yellow-200' : 'bg-green-100 text-green-700 hover:bg-green-200' }} transition-colors">
                                        {{ $featuredCategory->is_active ? 'Deactivate' : 'Activate' }}
                                    </button>
                                </form>

                                <!-- Remove -->
                                <form action="{{ route('mobileadmin.featured-categories.destroy', $featuredCategory) }}" method="POST" class="inline" onsubmit="return confirm('Remove this category from featured list?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm px-3 py-1 rounded bg-red-100 text-red-700 hover:bg-red-200 transition-colors">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="text-gray-400">
                        <i class="fas fa-tags text-5xl mb-4"></i>
                        <p class="text-lg font-medium">No featured categories</p>
                        <p class="text-sm mt-2">Add categories to feature them in the mobile app</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
    <script>
        // Make the list sortable
        const sortable = Sortable.create(document.getElementById('sortable-categories'), {
            animation: 150,
            ghostClass: 'bg-purple-50',
            onEnd: function (evt) {
                const categoryIds = Array.from(document.querySelectorAll('#sortable-categories [data-id]'))
                    .map(el => el.getAttribute('data-id'));

                // Send AJAX request to update order
                fetch('{{ route("mobileadmin.featured-categories.update-order") }}', {
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
                        // Update order numbers in the UI
                        document.querySelectorAll('#sortable-categories [data-id]').forEach((el, index) => {
                            const orderBadge = el.querySelector('.bg-purple-100');
                            orderBadge.textContent = index + 1;
                        });
                    }
                })
                .catch(error => {
                    console.error('Error updating order:', error);
                });
            }
        });
    </script>
    @endpush
</x-layouts.mobileadmin>
