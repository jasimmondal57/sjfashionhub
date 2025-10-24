<x-layouts.admin>
    <x-slot name="title">Banner Details - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">View banner details</x-slot>
    <x-slot name="pageTitle">🎨 Banner Details</x-slot>

    <!-- Header Actions -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600">Banner: {{ $banner->title }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.banners.edit', $banner) }}" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Banner
            </a>
            <a href="{{ route('admin.banners.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Banners
            </a>
        </div>
    </div>

    <!-- Banner Preview -->
    <div class="bg-white rounded-lg border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-black mb-4">Banner Preview</h3>
        <div class="relative w-full h-96 bg-gray-100 rounded-lg overflow-hidden">
            @if($banner->image_path)
                <img src="{{ Storage::url($banner->image_path) }}" alt="{{ $banner->title }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-30"></div>
                
                <!-- Content Overlay -->
                <div class="absolute inset-0 flex items-center">
                    <div class="container mx-auto px-6">
                        <div class="max-w-4xl {{ $banner->text_position === 'center' ? 'mx-auto text-center' : ($banner->text_position === 'right' ? 'ml-auto text-right' : 'text-left') }}">
                            
                            <!-- Title -->
                            <h1 class="text-4xl md:text-5xl font-bold mb-4 leading-tight"
                                style="color: {{ $banner->text_color }}">
                                {{ $banner->title }}
                            </h1>

                            <!-- Description -->
                            @if($banner->description)
                                <p class="text-lg md:text-xl mb-8 leading-relaxed opacity-90"
                                   style="color: {{ $banner->text_color }}">
                                    {{ $banner->description }}
                                </p>
                            @endif

                            <!-- Button -->
                            @if($banner->button_text && $banner->button_url)
                                <a href="{{ $banner->button_url }}" 
                                   class="inline-flex items-center px-8 py-4 text-lg font-semibold rounded-lg transition-all duration-300"
                                   style="background-color: {{ $banner->button_color }}; color: {{ $banner->text_color }};">
                                    {{ $banner->button_text }}
                                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <div class="flex items-center justify-center h-full">
                    <div class="text-center text-gray-500">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p>No image uploaded</p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Banner Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-black mb-4">Basic Information</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $banner->title }}</p>
                </div>
                
                @if($banner->description)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $banner->description }}</p>
                    </div>
                @endif
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sort Order</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $banner->sort_order }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $banner->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $banner->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Created</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $banner->created_at->format('M j, Y \a\t g:i A') }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $banner->updated_at->format('M j, Y \a\t g:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Button & Link Configuration -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-black mb-4">Button & Link Configuration</h3>
            <div class="space-y-4">
                @if($banner->button_text)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Button Text</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $banner->button_text }}</p>
                    </div>
                @endif
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Link Type</label>
                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($banner->link_type === 'category') bg-purple-100 text-purple-800
                        @elseif($banner->link_type === 'product') bg-blue-100 text-blue-800
                        @elseif($banner->link_type === 'custom') bg-green-100 text-green-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($banner->link_type) }}
                    </span>
                </div>
                
                @if($banner->link_type === 'category' && $banner->category)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Linked Category</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $banner->category->name }}</p>
                    </div>
                @endif
                
                @if($banner->link_type === 'product' && $banner->product)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Linked Product</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $banner->product->name }}</p>
                    </div>
                @endif
                
                @if($banner->link_type === 'custom' && $banner->custom_link)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Custom Link</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <a href="{{ $banner->custom_link }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                {{ $banner->custom_link }}
                                <svg class="inline w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                        </p>
                    </div>
                @endif
                
                @if($banner->button_url)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Button URL</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <a href="{{ $banner->button_url }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                {{ $banner->button_url }}
                                <svg class="inline w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Styling Configuration -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-black mb-4">Styling Configuration</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Text Position</label>
                    <p class="mt-1 text-sm text-gray-900 capitalize">{{ $banner->text_position }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Text Color</label>
                    <div class="mt-1 flex items-center">
                        <div class="w-6 h-6 rounded border border-gray-300 mr-2" style="background-color: {{ $banner->text_color }}"></div>
                        <span class="text-sm text-gray-900">{{ $banner->text_color }}</span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Button Color</label>
                    <div class="mt-1 flex items-center">
                        <div class="w-6 h-6 rounded border border-gray-300 mr-2" style="background-color: {{ $banner->button_color }}"></div>
                        <span class="text-sm text-gray-900">{{ $banner->button_color }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Image Information -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-black mb-4">Image Information</h3>
            <div class="space-y-4">
                @if($banner->image_path)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Image Path</label>
                        <p class="mt-1 text-sm text-gray-900 font-mono">{{ $banner->image_path }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Image URL</label>
                        <p class="mt-1 text-sm text-gray-900">
                            <a href="{{ Storage::url($banner->image_path) }}" target="_blank" class="text-blue-600 hover:text-blue-800">
                                View Full Image
                                <svg class="inline w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                </svg>
                            </a>
                        </p>
                    </div>
                @else
                    <div class="text-center text-gray-500 py-4">
                        <svg class="mx-auto h-8 w-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="text-sm">No image uploaded</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex justify-end space-x-3">
        <form action="{{ route('admin.banners.toggle', $banner) }}" method="POST" class="inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn {{ $banner->is_active ? 'btn-secondary' : 'btn-primary' }}">
                {{ $banner->is_active ? 'Disable Banner' : 'Enable Banner' }}
            </button>
        </form>
        
        <button onclick="deleteBanner({{ $banner->id }})" class="btn btn-danger">
            Delete Banner
        </button>
    </div>

    <script>
        function deleteBanner(bannerId) {
            if (confirm('Are you sure you want to delete this banner? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/banners/${bannerId}`;
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
