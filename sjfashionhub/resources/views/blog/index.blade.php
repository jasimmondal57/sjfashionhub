<x-layouts.main>
    <x-slot name="title">Fashion Blog - Style Tips & Trends | SJ Fashion Hub</x-slot>
    <x-slot name="description">Discover the latest fashion trends, style tips, and product guides on our fashion blog. Get inspired and stay updated with SJ Fashion Hub.</x-slot>
    <x-slot name="keywords">fashion blog, style tips, fashion trends, clothing guides, fashion advice</x-slot>

    <!-- Blog Header -->
    <div class="bg-gradient-to-br from-gray-900 to-gray-800 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto text-center">
                <h1 class="text-4xl md:text-6xl font-bold mb-6">Fashion Blog</h1>
                <p class="text-xl md:text-2xl text-gray-300 mb-8">
                    Discover the latest trends, style tips, and fashion insights
                </p>
                
                <!-- Search Bar -->
                <form action="{{ route('blog.index') }}" method="GET" class="max-w-2xl mx-auto">
                    <div class="flex">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Search articles..." 
                               class="flex-1 px-6 py-4 text-gray-900 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 px-8 py-4 rounded-r-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Featured Posts -->
    @if($featuredPosts->count() > 0)
        <div class="py-16 bg-gray-50">
            <div class="container mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-12">Featured Articles</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                    @foreach($featuredPosts as $post)
                        <article class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                            @if($post->featured_image_url)
                                <img src="{{ $post->featured_image_url }}"
                                     alt="{{ $post->title }}"
                                     class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                    <span class="text-white text-lg font-semibold">Featured</span>
                                </div>
                            @endif
                            <div class="p-6">
                                <div class="flex items-center space-x-2 text-sm text-gray-600 mb-3">
                                    <span>{{ $post->published_at->format('M j, Y') }}</span>
                                    @if($post->reading_time)
                                        <span>•</span>
                                        <span>{{ $post->reading_time }} min read</span>
                                    @endif
                                </div>
                                <h3 class="font-bold text-xl mb-3 line-clamp-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-blue-600">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                @if($post->excerpt)
                                    <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                                @endif
                                <a href="{{ route('blog.show', $post->slug) }}" 
                                   class="text-blue-600 hover:text-blue-800 font-semibold">
                                    Read More →
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <div class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-12 max-w-7xl mx-auto">
                <!-- Blog Posts -->
                <div class="lg:col-span-3">
                    <!-- Filter Bar -->
                    <div class="flex flex-wrap items-center justify-between mb-8 p-4 bg-gray-50 rounded-lg">
                        <div class="flex flex-wrap items-center space-x-4 mb-4 lg:mb-0">
                            <span class="text-gray-700 font-medium">Filter by:</span>
                            <select onchange="window.location.href=this.value" class="px-3 py-2 border border-gray-300 rounded-lg">
                                <option value="{{ route('blog.index') }}">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ route('blog.index', ['category' => $category->slug]) }}" 
                                            {{ request('category') == $category->slug ? 'selected' : '' }}>
                                        {{ $category->name }} ({{ $category->published_posts_count }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-sm text-gray-600">
                            Showing {{ $posts->firstItem() ?? 0 }}-{{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} articles
                        </div>
                    </div>

                    <!-- Posts Grid -->
                    @if($posts->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                            @foreach($posts as $post)
                                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                                    @if($post->featured_image_url)
                                        <img src="{{ $post->featured_image_url }}"
                                             alt="{{ $post->title }}"
                                             class="w-full h-48 object-cover">
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                            <span class="text-gray-500">No Image</span>
                                        </div>
                                    @endif
                                    <div class="p-6">
                                        <!-- Meta Info -->
                                        <div class="flex items-center space-x-2 text-sm text-gray-600 mb-3">
                                            @if($post->category)
                                                <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs">
                                                    {{ $post->category->name }}
                                                </span>
                                            @endif
                                            <span>{{ $post->published_at->format('M j, Y') }}</span>
                                            @if($post->reading_time)
                                                <span>•</span>
                                                <span>{{ $post->reading_time }} min read</span>
                                            @endif
                                        </div>

                                        <!-- Title -->
                                        <h3 class="font-bold text-xl mb-3 line-clamp-2">
                                            <a href="{{ route('blog.show', $post->slug) }}" class="hover:text-blue-600">
                                                {{ $post->title }}
                                            </a>
                                        </h3>

                                        <!-- Excerpt -->
                                        @if($post->excerpt)
                                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $post->excerpt }}</p>
                                        @endif

                                        <!-- Tags -->
                                        @if($post->tags->count() > 0)
                                            <div class="flex flex-wrap gap-2 mb-4">
                                                @foreach($post->tags->take(3) as $tag)
                                                    <span class="inline-block bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">
                                                        {{ $tag->name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif

                                        <!-- Read More -->
                                        <div class="flex items-center justify-between">
                                            <a href="{{ route('blog.show', $post->slug) }}" 
                                               class="text-blue-600 hover:text-blue-800 font-semibold">
                                                Read More →
                                            </a>
                                            <div class="flex items-center space-x-3 text-sm text-gray-500">
                                                <span>{{ $post->views_count }} views</span>
                                                @if($post->ai_generated)
                                                    <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded-full text-xs">
                                                        AI Generated
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="flex justify-center">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">No articles found</h3>
                            <p class="text-gray-500">Try adjusting your search or filter criteria.</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Categories -->
                    @if($categories->count() > 0)
                        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                            <h3 class="text-lg font-semibold mb-4">Categories</h3>
                            <ul class="space-y-2">
                                @foreach($categories as $category)
                                    <li>
                                        <a href="{{ route('blog.index', ['category' => $category->slug]) }}" 
                                           class="flex items-center justify-between text-gray-600 hover:text-gray-900 {{ request('category') == $category->slug ? 'text-blue-600 font-semibold' : '' }}">
                                            <span>{{ $category->name }}</span>
                                            <span class="text-sm bg-gray-100 px-2 py-1 rounded">{{ $category->published_posts_count }}</span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Popular Tags -->
                    @if($popularTags->count() > 0)
                        <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                            <h3 class="text-lg font-semibold mb-4">Popular Tags</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($popularTags as $tag)
                                    <a href="{{ route('blog.tag', $tag->slug) }}" 
                                       class="inline-block bg-gray-100 text-gray-700 text-sm px-3 py-1 rounded-full hover:bg-gray-200 transition-colors">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Newsletter Signup -->
                    <div class="bg-gradient-to-br from-blue-600 to-purple-600 text-white p-6 rounded-lg shadow-md">
                        <h3 class="text-lg font-semibold mb-2">Stay Updated</h3>
                        <p class="text-blue-100 mb-4">Get the latest fashion tips and trends delivered to your inbox.</p>
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                            @csrf
                            <input type="email" name="email" placeholder="Your email address" required
                                   class="w-full px-3 py-2 rounded-lg text-gray-900 placeholder-gray-500">
                            <button type="submit" 
                                    class="w-full bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
                                Subscribe
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.main>
