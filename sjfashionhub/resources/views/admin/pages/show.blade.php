<x-layouts.admin>
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center">
                <a href="{{ route('admin.pages.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                    <i class="fas fa-arrow-left text-xl"></i>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $page->title }}</h1>
                    <p class="text-gray-600">Page details and preview</p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="/{{ $page->slug }}" target="_blank" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-external-link-alt mr-2"></i>View Live
                </a>
                <a href="{{ route('admin.pages.edit', $page) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    <i class="fas fa-edit mr-2"></i>Edit Page
                </a>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Page Content -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Page Content</h2>
                    </div>
                    <div class="p-6">
                        <div class="prose max-w-none">
                            {!! $page->content !!}
                        </div>
                    </div>
                </div>

                <!-- SEO Preview -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">SEO Preview</h2>
                        <p class="text-gray-600 text-sm">How this page might appear in search results</p>
                    </div>
                    <div class="p-6">
                        <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                            <div class="text-blue-600 text-lg hover:underline cursor-pointer">
                                {{ $page->seo_title ?: $page->title }}
                            </div>
                            <div class="text-green-700 text-sm">
                                {{ url('/' . $page->slug) }}
                            </div>
                            <div class="text-gray-600 text-sm mt-1">
                                {{ $page->meta_description ?: 'No meta description set for this page.' }}
                            </div>
                        </div>
                        
                        @if($page->meta_keywords)
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Meta Keywords:</h4>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(explode(',', $page->meta_keywords) as $keyword)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ trim($keyword) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Page Information -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Page Information</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            @if($page->is_active)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>Published
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-times-circle mr-1"></i>Draft
                                </span>
                            @endif
                        </div>

                        <!-- Page Type -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Page Type</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($page->page_type === 'about') bg-blue-100 text-blue-800
                                @elseif($page->page_type === 'contact') bg-green-100 text-green-800
                                @elseif($page->page_type === 'privacy') bg-purple-100 text-purple-800
                                @elseif($page->page_type === 'terms') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($page->page_type) }}
                            </span>
                        </div>

                        <!-- URL -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                            <div class="text-sm text-gray-600 bg-gray-50 p-2 rounded border">
                                {{ url('/' . $page->slug) }}
                            </div>
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                            <div class="text-sm text-gray-600">{{ $page->sort_order }}</div>
                        </div>

                        <!-- Dates -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Created</label>
                            <div class="text-sm text-gray-600">{{ $page->created_at->format('M d, Y g:i A') }}</div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                            <div class="text-sm text-gray-600">{{ $page->updated_at->format('M d, Y g:i A') }}</div>
                        </div>
                    </div>
                </div>

                <!-- SEO Information -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">SEO Information</h2>
                    </div>
                    <div class="p-6 space-y-4">
                        <!-- SEO Title -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">SEO Title</label>
                            <div class="text-sm text-gray-600">
                                {{ $page->seo_title ?: 'Using page title' }}
                            </div>
                            @if($page->seo_title)
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ strlen($page->seo_title) }} characters
                                </div>
                            @endif
                        </div>

                        <!-- Meta Description -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Meta Description</label>
                            <div class="text-sm text-gray-600">
                                {{ $page->meta_description ?: 'No meta description set' }}
                            </div>
                            @if($page->meta_description)
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ strlen($page->meta_description) }} characters
                                </div>
                            @endif
                        </div>

                        <!-- Meta Keywords -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Meta Keywords</label>
                            <div class="text-sm text-gray-600">
                                {{ $page->meta_keywords ?: 'No keywords set' }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow">
                    <div class="p-6">
                        <div class="flex flex-col space-y-3">
                            <a href="{{ route('admin.pages.edit', $page) }}" 
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-center transition-colors">
                                <i class="fas fa-edit mr-2"></i>Edit Page
                            </a>
                            <a href="/{{ $page->slug }}" target="_blank" 
                               class="w-full bg-green-600 hover:bg-green-700 text-white py-2 px-4 rounded-lg text-center transition-colors">
                                <i class="fas fa-external-link-alt mr-2"></i>View Live Page
                            </a>
                            <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this page?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg transition-colors">
                                    <i class="fas fa-trash mr-2"></i>Delete Page
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
