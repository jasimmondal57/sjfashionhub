<x-layouts.admin>
    <x-slot name="title">{{ $post->title }}</x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">{{ $post->title }}</h1>
                <div class="flex items-center space-x-4 mt-2 text-sm text-gray-600">
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        {{ $post->author->name ?? 'Unknown Author' }}
                    </span>
                    <span class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not Published' }}
                    </span>
                    @if($post->reading_time)
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $post->reading_time }} min read
                        </span>
                    @endif
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.blog.edit', $post) }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Post
                </a>
                <a href="{{ route('admin.blog.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                    Back to Posts
                </a>
            </div>
        </div>

        <!-- Status Badges -->
        <div class="flex items-center space-x-3 mb-6">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                {{ $post->status === 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                {{ ucfirst($post->status) }}
            </span>
            
            @if($post->is_featured)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    Featured
                </span>
            @endif

            @if($post->category)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                    {{ $post->category->name }}
                </span>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Featured Image -->
                @if($post->featured_image)
                    <div class="mb-6">
                        <img src="{{ asset('storage/' . $post->featured_image) }}" 
                             alt="{{ $post->title }}" 
                             class="w-full h-64 object-cover rounded-lg shadow-md">
                    </div>
                @endif

                <!-- Excerpt -->
                @if($post->excerpt)
                    <div class="bg-gray-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r-lg">
                        <p class="text-lg text-gray-700 italic">{{ $post->excerpt }}</p>
                    </div>
                @endif

                <!-- Content -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="prose prose-lg max-w-none">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                </div>

                <!-- Tags -->
                @if($post->tags->count() > 0)
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-3">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($post->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    #{{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Post Details -->
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Post Details</h3>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium {{ $post->status === 'published' ? 'text-green-600' : 'text-yellow-600' }}">
                                {{ ucfirst($post->status) }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Created:</span>
                            <span class="font-medium">{{ $post->created_at->format('M d, Y H:i') }}</span>
                        </div>
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Updated:</span>
                            <span class="font-medium">{{ $post->updated_at->format('M d, Y H:i') }}</span>
                        </div>
                        
                        @if($post->published_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Published:</span>
                                <span class="font-medium">{{ $post->published_at->format('M d, Y H:i') }}</span>
                            </div>
                        @endif
                        
                        <div class="flex justify-between">
                            <span class="text-gray-600">Views:</span>
                            <span class="font-medium">{{ number_format($post->views_count ?? 0) }}</span>
                        </div>
                        
                        @if($post->reading_time)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Reading Time:</span>
                                <span class="font-medium">{{ $post->reading_time }} minutes</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- SEO Information -->
                @if($post->seo_title || $post->seo_description || $post->seo_keywords)
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">SEO Information</h3>
                        
                        <div class="space-y-3 text-sm">
                            @if($post->seo_title)
                                <div>
                                    <span class="text-gray-600 block">SEO Title:</span>
                                    <span class="font-medium">{{ $post->seo_title }}</span>
                                </div>
                            @endif
                            
                            @if($post->seo_description)
                                <div>
                                    <span class="text-gray-600 block">SEO Description:</span>
                                    <span class="font-medium">{{ $post->seo_description }}</span>
                                </div>
                            @endif
                            
                            @if($post->seo_keywords)
                                <div>
                                    <span class="text-gray-600 block">SEO Keywords:</span>
                                    <span class="font-medium">{{ $post->seo_keywords }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Associated Product -->
                @if($post->product)
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Associated Product</h3>
                        
                        <div class="flex items-center space-x-3">
                            @if($post->product->main_image)
                                <img src="{{ asset('storage/' . $post->product->main_image) }}" 
                                     alt="{{ $post->product->name }}" 
                                     class="w-12 h-12 object-cover rounded-lg">
                            @else
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            
                            <div class="flex-1">
                                <h4 class="font-medium text-gray-900">{{ $post->product->name }}</h4>
                                <p class="text-sm text-gray-600">₹{{ number_format($post->product->price, 2) }}</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('admin.products.show', $post->product) }}" 
                           class="mt-3 w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg text-sm transition duration-200 block">
                            View Product
                        </a>
                    </div>
                @endif

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                    
                    <div class="space-y-2">
                        <a href="{{ route('admin.blog.edit', $post) }}" 
                           class="w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-2 px-4 rounded-lg text-sm transition duration-200 block">
                            Edit Post
                        </a>
                        
                        @if($post->status === 'published')
                            <form action="{{ route('admin.blog.bulk-action') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="posts[]" value="{{ $post->id }}">
                                <input type="hidden" name="action" value="unpublish">
                                <button type="submit" 
                                        class="w-full bg-yellow-600 hover:bg-yellow-700 text-white text-center py-2 px-4 rounded-lg text-sm transition duration-200">
                                    Unpublish
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.blog.bulk-action') }}" method="POST" class="w-full">
                                @csrf
                                <input type="hidden" name="posts[]" value="{{ $post->id }}">
                                <input type="hidden" name="action" value="publish">
                                <button type="submit" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white text-center py-2 px-4 rounded-lg text-sm transition duration-200">
                                    Publish
                                </button>
                            </form>
                        @endif
                        
                        <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this post?')" class="w-full">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white text-center py-2 px-4 rounded-lg text-sm transition duration-200">
                                Delete Post
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
