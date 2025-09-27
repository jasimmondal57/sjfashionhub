<x-layouts.admin>
    <x-slot name="title">Social Media Management</x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">📱 Social Media Management</h1>
                <p class="text-gray-600 mt-1">Manage your social media posts and platform configurations</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.social-media.config') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center font-medium shadow-lg border border-blue-500">
                    ⚙️ Configure Platforms
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center mr-4">
                        <span class="text-white text-xl">📊</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Total Posts</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['total_posts'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center mr-4">
                        <span class="text-white text-xl">📅</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Posted Today</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['posted_today'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-yellow-500 rounded-lg flex items-center justify-center mr-4">
                        <span class="text-white text-xl">⏳</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Pending</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['pending_posts'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center mr-4">
                        <span class="text-white text-xl">❌</span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Failed</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $stats['failed_posts'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Platform Status -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Platform Status</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                @forelse($configs as $config)
                <div class="flex items-center justify-between p-4 border border-gray-200 rounded-lg">
                    <div class="flex items-center">
                        <span class="text-2xl mr-3">{{ $config->platform_icon }}</span>
                        <div>
                            <p class="font-medium text-gray-900">{{ ucfirst($config->platform) }}</p>
                            <p class="text-sm text-gray-500">{{ $config->name ?? 'Not configured' }}</p>
                        </div>
                    </div>
                    <div>
                        {!! $config->status_badge !!}
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-500">No platforms configured yet.</p>
                    <a href="{{ route('admin.social-media.config') }}" class="text-blue-600 hover:text-blue-800">Configure platforms</a>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Recent Posts</h3>
            </div>
            
            @if($posts->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Platform</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Posted</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($posts as $post)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        @if($post->product->main_image)
                                            <img src="{{ $post->product->main_image }}" alt="{{ $post->product->name }}" 
                                                 class="w-10 h-10 rounded-lg object-cover mr-3">
                                        @else
                                            <div class="w-10 h-10 bg-gray-200 rounded-lg flex items-center justify-center mr-3">
                                                <span class="text-gray-400 text-xs">No Image</span>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $post->product->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $post->product->brand }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="text-lg mr-2">{{ $post->platform_icon }}</span>
                                        <span class="text-sm font-medium text-gray-900">{{ ucfirst($post->platform) }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="max-w-xs">
                                        <p class="text-sm text-gray-900 truncate">{{ Str::limit($post->content, 100) }}</p>
                                        @if($post->hashtags)
                                            <p class="text-xs text-blue-600 mt-1">{{ Str::limit($post->formatted_hashtags, 50) }}</p>
                                        @endif
                                        @if($post->metadata && isset($post->metadata['price_info']))
                                            <p class="text-xs text-green-600 mt-1">{{ $post->metadata['price_info'] }}</p>
                                        @endif
                                        @if($post->metadata && isset($post->metadata['product_url']))
                                            <p class="text-xs text-gray-500 mt-1">
                                                <a href="{{ $post->metadata['product_url'] }}" target="_blank" class="hover:text-blue-600">
                                                    🔗 Product Link
                                                </a>
                                            </p>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {!! $post->status_badge !!}
                                    @if($post->status === 'failed' && $post->error_message)
                                        <p class="text-xs text-red-600 mt-1" title="{{ $post->error_message }}">
                                            {{ Str::limit($post->error_message, 30) }}
                                        </p>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($post->posted_at)
                                        {{ $post->posted_at->format('M d, Y H:i') }}
                                    @else
                                        <span class="text-gray-400">Not posted</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        @if($post->status === 'failed')
                                            <button onclick="retryPost({{ $post->id }})" 
                                                    class="text-blue-600 hover:text-blue-900">Retry</button>
                                        @endif
                                        
                                        @if($post->post_id)
                                            <a href="#" class="text-green-600 hover:text-green-900">View Post</a>
                                        @endif
                                        
                                        <form action="{{ route('admin.social-media.posts.delete', $post) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Delete this post record?')">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-3.582 8-8 8a8.959 8.959 0 01-4.906-1.456l-3.815 1.456A2 2 0 013.156 18.444l1.456-3.815A8.959 8.959 0 013 12a8 8 0 018-8 8 8 0 018 8z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No posts yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Start by posting a product to social media from the products page.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.products.index') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            Go to Products
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

<script>
function retryPost(postId) {
    if (!confirm('Retry posting to social media?')) {
        return;
    }

    fetch(`/admin/social-media/posts/${postId}/retry`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        alert('An error occurred while retrying the post.');
        console.error('Error:', error);
    });
}
</script>

</x-layouts.admin>
