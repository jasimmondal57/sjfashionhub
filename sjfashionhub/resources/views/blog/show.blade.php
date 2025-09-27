<x-layouts.main>
    <x-slot name="title">{{ $post->seo_title ?? $post->title }}</x-slot>
    <x-slot name="description">{{ $post->seo_description ?? $post->excerpt }}</x-slot>
    <x-slot name="keywords">{{ $post->seo_keywords }}</x-slot>

    <!-- Blog Post Header -->
    <div class="bg-gray-50 py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <!-- Breadcrumb -->
                <nav class="text-sm text-gray-600 mb-6">
                    <a href="{{ route('home') }}" class="hover:text-gray-900">Home</a>
                    <span class="mx-2">/</span>
                    <a href="{{ route('blog.index') }}" class="hover:text-gray-900">Blog</a>
                    <span class="mx-2">/</span>
                    <span class="text-gray-900">{{ $post->title }}</span>
                </nav>

                <!-- Post Meta -->
                <div class="flex items-center space-x-4 text-sm text-gray-600 mb-4">
                    <span>By {{ $post->author->name ?? 'SJ Fashion Hub' }}</span>
                    <span>•</span>
                    <time datetime="{{ $post->published_at->format('Y-m-d') }}">
                        {{ $post->published_at->format('F j, Y') }}
                    </time>
                    @if($post->reading_time)
                        <span>•</span>
                        <span>{{ $post->reading_time }} min read</span>
                    @endif
                    <span>•</span>
                    <span>{{ $post->views_count }} views</span>
                </div>

                <!-- Post Title -->
                <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6 leading-tight">
                    {{ $post->title }}
                </h1>

                <!-- Post Excerpt -->
                @if($post->excerpt)
                    <p class="text-xl text-gray-600 mb-8 leading-relaxed">
                        {{ $post->excerpt }}
                    </p>
                @endif

                <!-- Tags -->
                @if($post->tags->count() > 0)
                    <div class="flex flex-wrap gap-2 mb-8">
                        @foreach($post->tags as $tag)
                            <span class="inline-block bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                                {{ $tag->name }}
                            </span>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Blog Post Content -->
    <div class="py-12">
        <div class="container mx-auto px-4">
            <div class="max-w-4xl mx-auto">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                    <!-- Main Content -->
                    <div class="lg:col-span-2">
                        <!-- Featured Image -->
                        @if($post->featured_image)
                            <div class="mb-8">
                                <img src="{{ asset('storage/' . $post->featured_image) }}" 
                                     alt="{{ $post->title }}"
                                     class="w-full h-64 md:h-96 object-cover rounded-lg shadow-lg">
                            </div>
                        @endif

                        <!-- Post Content -->
                        <div class="prose prose-lg max-w-none">
                            {!! $post->content !!}
                        </div>

                        <!-- Related Product -->
                        @if($post->product)
                            <div class="mt-12 p-6 bg-gray-50 rounded-lg">
                                <h3 class="text-xl font-semibold mb-4">Featured Product</h3>
                                <div class="flex items-center space-x-4">
                                    @if($post->product->images && count($post->product->images) > 0)
                                        <img src="{{ asset('storage/' . $post->product->images[0]['image_path']) }}" 
                                             alt="{{ $post->product->name }}"
                                             class="w-20 h-20 object-cover rounded-lg">
                                    @endif
                                    <div class="flex-1">
                                        <h4 class="font-semibold text-lg">{{ $post->product->name }}</h4>
                                        <p class="text-gray-600 text-sm mb-2">{{ $post->product->short_description }}</p>
                                        <div class="flex items-center justify-between">
                                            <span class="text-2xl font-bold text-green-600">₹{{ number_format($post->product->price, 2) }}</span>
                                            <a href="{{ route('products.show', $post->product->slug) }}" 
                                               class="bg-black text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition-colors">
                                                View Product
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Social Share -->
                        <div class="mt-12 pt-8 border-t border-gray-200">
                            <h3 class="text-lg font-semibold mb-4">Share this article</h3>
                            <div class="flex space-x-4">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" 
                                   target="_blank"
                                   class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                    Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->title) }}" 
                                   target="_blank"
                                   class="bg-blue-400 text-white px-4 py-2 rounded-lg hover:bg-blue-500 transition-colors">
                                    Twitter
                                </a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->url()) }}" 
                                   target="_blank"
                                   class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition-colors">
                                    LinkedIn
                                </a>
                                <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . request()->url()) }}" 
                                   target="_blank"
                                   class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                                    WhatsApp
                                </a>
                            </div>
                        </div>
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
                                            <a href="{{ route('blog.category', $category->slug) }}" 
                                               class="flex items-center justify-between text-gray-600 hover:text-gray-900">
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
                            <p class="text-blue-100 mb-4">Get the latest fashion tips and product updates delivered to your inbox.</p>
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
    </div>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
        <div class="bg-gray-50 py-12">
            <div class="container mx-auto px-4">
                <div class="max-w-6xl mx-auto">
                    <h2 class="text-3xl font-bold text-center mb-12">Related Articles</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                        @foreach($relatedPosts as $relatedPost)
                            <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                                @if($relatedPost->featured_image)
                                    <img src="{{ asset('storage/' . $relatedPost->featured_image) }}" 
                                         alt="{{ $relatedPost->title }}"
                                         class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                        <span class="text-gray-500 text-sm">No Image</span>
                                    </div>
                                @endif
                                <div class="p-6">
                                    <h3 class="font-semibold text-lg mb-2 line-clamp-2">
                                        <a href="{{ route('blog.show', $relatedPost->slug) }}" class="hover:text-blue-600">
                                            {{ $relatedPost->title }}
                                        </a>
                                    </h3>
                                    @if($relatedPost->excerpt)
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $relatedPost->excerpt }}</p>
                                    @endif
                                    <div class="flex items-center justify-between text-sm text-gray-500">
                                        <span>{{ $relatedPost->published_at->format('M j, Y') }}</span>
                                        @if($relatedPost->reading_time)
                                            <span>{{ $relatedPost->reading_time }} min read</span>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Schema.org structured data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "BlogPosting",
        "headline": "{{ $post->title }}",
        "description": "{{ $post->excerpt ?? strip_tags(Str::limit($post->content, 160)) }}",
        "author": {
            "@type": "Person",
            "name": "{{ $post->author->name ?? 'SJ Fashion Hub' }}"
        },
        "publisher": {
            "@type": "Organization",
            "name": "SJ Fashion Hub",
            "logo": {
                "@type": "ImageObject",
                "url": "{{ asset('images/logo.png') }}"
            }
        },
        "datePublished": "{{ $post->published_at->toISOString() }}",
        "dateModified": "{{ $post->updated_at->toISOString() }}",
        @if($post->featured_image)
        "image": "{{ asset('storage/' . $post->featured_image) }}",
        @endif
        "mainEntityOfPage": {
            "@type": "WebPage",
            "@id": "{{ request()->url() }}"
        }
    }
    </script>
</x-layouts.main>
