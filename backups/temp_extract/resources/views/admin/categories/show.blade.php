<x-layouts.admin>
    <x-slot name="title">Category Details - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">View category details</x-slot>
    <x-slot name="pageTitle">📂 Category Details</x-slot>

    <!-- Header Actions -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600">Category: {{ $category->name }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('categories.show', $category->slug) }}" target="_blank" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                </svg>
                View on Site
            </a>
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Category
            </a>
            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Categories
            </a>
        </div>
    </div>

    <!-- Category Preview -->
    <div class="bg-white rounded-lg border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-black mb-4">Category Preview</h3>
        <div class="bg-gray-50 p-6 rounded-lg">
            <div class="text-center max-w-xs mx-auto">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 overflow-hidden">
                    @if($category->image)
                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-8 h-8 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    @endif
                </div>
                <h3 class="font-medium text-black">{{ $category->name }}</h3>
                @if($category->description)
                    <p class="text-gray-600 text-sm mt-1">{{ Str::limit($category->description, 100) }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Category Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-black mb-4">Basic Information</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Name</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->name }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Slug</label>
                    <p class="mt-1 text-sm text-gray-900 font-mono">{{ $category->slug }}</p>
                </div>
                
                @if($category->description)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->description }}</p>
                </div>
                @endif
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Parent Category</label>
                    @if($category->parent)
                        <p class="mt-1 text-sm text-gray-900">{{ $category->parent->name }}</p>
                    @else
                        <p class="mt-1 text-sm text-gray-500">None (Main Category)</p>
                    @endif
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sort Order</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->sort_order }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Created</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->created_at->format('M j, Y \a\t g:i A') }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $category->updated_at->format('M j, Y \a\t g:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- SEO Information -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-black mb-4">SEO Information</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Meta Title</label>
                    @if($category->meta_title)
                        <p class="mt-1 text-sm text-gray-900">{{ $category->meta_title }}</p>
                        <p class="text-xs text-gray-500">{{ strlen($category->meta_title) }} characters</p>
                    @else
                        <p class="mt-1 text-sm text-gray-500">Not set</p>
                    @endif
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Meta Description</label>
                    @if($category->meta_description)
                        <p class="mt-1 text-sm text-gray-900">{{ $category->meta_description }}</p>
                        <p class="text-xs text-gray-500">{{ strlen($category->meta_description) }} characters</p>
                    @else
                        <p class="mt-1 text-sm text-gray-500">Not set</p>
                    @endif
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Meta Keywords</label>
                    @if($category->meta_keywords)
                        <p class="mt-1 text-sm text-gray-900">{{ $category->meta_keywords }}</p>
                    @else
                        <p class="mt-1 text-sm text-gray-500">Not set</p>
                    @endif
                </div>
                
                @if($category->image)
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category Image</label>
                    <div class="mt-2">
                        <img src="{{ Storage::url($category->image) }}" alt="{{ $category->name }}" class="w-24 h-24 object-cover rounded border border-gray-200">
                        <p class="mt-1 text-xs text-gray-500">{{ $category->image }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Subcategories -->
    @if($category->children->count() > 0)
    <div class="bg-white rounded-lg border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-black mb-4">Subcategories ({{ $category->children->count() }})</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($category->children as $child)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center mr-3 overflow-hidden">
                        @if($child->image)
                            <img src="{{ Storage::url($child->image) }}" alt="{{ $child->name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-black">{{ $child->name }}</h4>
                        <p class="text-xs text-gray-500">{{ $child->products_count }} products</p>
                    </div>
                    <a href="{{ route('admin.categories.show', $child) }}" class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Products in Category -->
    @if($category->products->count() > 0)
    <div class="bg-white rounded-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-black">Products in Category ({{ $category->products_count }})</h3>
            <a href="{{ route('admin.products.index') }}?category={{ $category->id }}" class="text-blue-600 hover:text-blue-900 text-sm">View All</a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($category->products->take(6) as $product)
            <div class="border border-gray-200 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-3 overflow-hidden">
                        @if($product->image)
                            <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-medium text-black">{{ Str::limit($product->name, 30) }}</h4>
                        <p class="text-xs text-gray-500">₹{{ number_format($product->price, 2) }}</p>
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 hover:text-blue-900 text-sm">View</a>
                </div>
            </div>
            @endforeach
        </div>
        @if($category->products_count > 6)
        <div class="mt-4 text-center">
            <a href="{{ route('admin.products.index') }}?category={{ $category->id }}" class="text-blue-600 hover:text-blue-900 text-sm">
                View all {{ $category->products_count }} products →
            </a>
        </div>
        @endif
    </div>
    @else
    <div class="bg-white rounded-lg border border-gray-100 p-6">
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No products in this category</h3>
            <p class="mt-1 text-sm text-gray-500">Start by adding products to this category.</p>
            <div class="mt-6">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    Add Product
                </a>
            </div>
        </div>
    </div>
    @endif

    <!-- Actions -->
    <div class="mt-6 flex justify-end space-x-3">
        <form action="{{ route('admin.categories.toggle', $category) }}" method="POST" class="inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn {{ $category->is_active ? 'btn-secondary' : 'btn-primary' }}">
                {{ $category->is_active ? 'Disable Category' : 'Enable Category' }}
            </button>
        </form>
        
        <button onclick="deleteCategory({{ $category->id }})" class="btn btn-danger">
            Delete Category
        </button>
    </div>

    <script>
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
</x-layouts.admin>
