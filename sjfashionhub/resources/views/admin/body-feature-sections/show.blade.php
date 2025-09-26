<x-layouts.admin title="Body Feature Section Details" description="View section details and preview">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-black">{{ $bodyFeatureSection->title }}</h1>
                <p class="text-gray-600">Section details and preview</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.body-feature-sections.edit', $bodyFeatureSection) }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Section
                </a>
                <a href="{{ route('admin.body-feature-sections.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Section Information -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Basic Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <p class="text-black font-medium">{{ $bodyFeatureSection->title }}</p>
                    </div>
                    @if($bodyFeatureSection->subtitle)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                        <p class="text-gray-600">{{ $bodyFeatureSection->subtitle }}</p>
                    </div>
                    @endif
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Section Type</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ ucfirst($bodyFeatureSection->section_type) }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Display Style</label>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            {{ ucfirst($bodyFeatureSection->display_style) }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Items Limit</label>
                        <p class="text-black">{{ $bodyFeatureSection->items_limit }} items</p>
                    </div>
                </div>
            </div>

            <!-- Status & Settings -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Status & Settings</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        @if($bodyFeatureSection->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                Inactive
                            </span>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sort Order</label>
                        <p class="text-black">{{ $bodyFeatureSection->sort_order }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Background Color</label>
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 rounded border border-gray-300" style="background-color: {{ $bodyFeatureSection->background_color }};"></div>
                            <span class="text-sm text-gray-600">{{ $bodyFeatureSection->background_color }}</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Text Color</label>
                        <div class="flex items-center space-x-2">
                            <div class="w-6 h-6 rounded border border-gray-300" style="background-color: {{ $bodyFeatureSection->text_color }};"></div>
                            <span class="text-sm text-gray-600">{{ $bodyFeatureSection->text_color }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Button Settings -->
        @if($bodyFeatureSection->show_button)
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-medium text-black mb-4">Button Settings</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Button Text</label>
                    <p class="text-black">{{ $bodyFeatureSection->button_text }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Button URL</label>
                    <p class="text-blue-600 hover:text-blue-800">
                        <a href="{{ $bodyFeatureSection->button_url }}" target="_blank" class="flex items-center">
                            {{ $bodyFeatureSection->button_url }}
                            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                        </a>
                    </p>
                </div>
            </div>
        </div>
        @endif

        <!-- Content Settings -->
        @if($bodyFeatureSection->content_settings)
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-medium text-black mb-4">Content Settings</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ json_encode($bodyFeatureSection->content_settings, JSON_PRETTY_PRINT) }}</pre>
            </div>
        </div>
        @endif

        <!-- Content Preview -->
        @php
            $contentItems = $bodyFeatureSection->getContentItems();
        @endphp
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-black">Content Preview</h3>
                <span class="text-sm text-gray-600">{{ $contentItems->count() }} items found</span>
            </div>
            
            @if($contentItems->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    @foreach($contentItems->take(8) as $item)
                        @if($bodyFeatureSection->section_type === 'products' || (isset($item->content_type) && $item->content_type === 'product'))
                            <!-- Product Preview -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="aspect-square bg-gray-100 rounded mb-3 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-medium text-sm text-black mb-1 line-clamp-2">{{ $item->name }}</h4>
                                <p class="text-xs text-gray-600 mb-2">{{ $item->category->name }}</p>
                                <div class="flex items-center justify-between">
                                    @if($item->sale_price)
                                    <span class="text-sm font-semibold text-black">₹{{ number_format($item->sale_price) }}</span>
                                    @else
                                    <span class="text-sm font-semibold text-black">₹{{ number_format($item->price) }}</span>
                                    @endif
                                    @if($item->is_featured)
                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Featured</span>
                                    @endif
                                </div>
                            </div>
                        @elseif($bodyFeatureSection->section_type === 'categories' || (isset($item->content_type) && $item->content_type === 'category'))
                            <!-- Category Preview -->
                            <div class="border border-gray-200 rounded-lg p-4 text-center">
                                <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 overflow-hidden">
                                    @if($item->image)
                                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                        </svg>
                                    @endif
                                </div>
                                <h4 class="font-medium text-sm text-black">{{ $item->name }}</h4>
                                @if($item->description)
                                    <p class="text-xs text-gray-600 mt-1">{{ Str::limit($item->description, 30) }}</p>
                                @endif
                            </div>
                        @endif
                    @endforeach
                </div>
                
                @if($contentItems->count() > 8)
                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">... and {{ $contentItems->count() - 8 }} more items</p>
                    </div>
                @endif
            @else
                <div class="text-center py-8">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <p class="text-gray-600">No content items found for this section</p>
                    <p class="text-sm text-gray-500 mt-1">Check your content settings or add some products/categories</p>
                </div>
            @endif
        </div>

        <!-- Timestamps -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-medium text-black mb-4">Timestamps</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Created At</label>
                    <p class="text-gray-600">{{ $bodyFeatureSection->created_at->format('M d, Y \a\t g:i A') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                    <p class="text-gray-600">{{ $bodyFeatureSection->updated_at->format('M d, Y \a\t g:i A') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
