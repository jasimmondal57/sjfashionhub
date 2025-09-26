<x-layouts.admin title="Newsletter Section Details" description="View newsletter section details">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">Newsletter Section Details</h1>
                <p class="text-gray-300">View newsletter section configuration and preview</p>
            </div>
            <div class="flex items-center space-x-3">
                <button onclick="toggleStatus({{ $newsletter->id }})" 
                        class="inline-flex items-center px-4 py-2 rounded-md text-sm font-medium transition-colors {{ $newsletter->is_active ? 'bg-green-600 hover:bg-green-700 text-white' : 'bg-red-600 hover:bg-red-700 text-white' }}">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                        @if($newsletter->is_active)
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        @else
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        @endif
                    </svg>
                    {{ $newsletter->is_active ? 'Active' : 'Inactive' }}
                </button>
                <a href="{{ route('admin.newsletters.edit', $newsletter) }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.newsletters.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Newsletter
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column - Details -->
            <div class="space-y-6">
                <!-- Basic Information -->
                <div class="bg-gray-800 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-white mb-4">Basic Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Title</label>
                            <p class="text-white">{{ $newsletter->title }}</p>
                        </div>

                        @if($newsletter->subtitle)
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Subtitle</label>
                            <p class="text-white">{{ $newsletter->subtitle }}</p>
                        </div>
                        @endif

                        @if($newsletter->description)
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Description</label>
                            <p class="text-white">{{ $newsletter->description }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Form Settings -->
                <div class="bg-gray-800 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-white mb-4">Form Settings</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Email Placeholder Text</label>
                            <p class="text-white">{{ $newsletter->placeholder_text }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Button Text</label>
                            <p class="text-white">{{ $newsletter->button_text }}</p>
                        </div>
                    </div>
                </div>

                <!-- Color Settings -->
                <div class="bg-gray-800 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-white mb-4">Color Settings</h3>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Background Color</label>
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded border border-gray-600" style="background-color: {{ $newsletter->background_color }};"></div>
                                <span class="text-white text-sm">{{ $newsletter->background_color }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Text Color</label>
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded border border-gray-600" style="background-color: {{ $newsletter->text_color }};"></div>
                                <span class="text-white text-sm">{{ $newsletter->text_color }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Button Color</label>
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded border border-gray-600" style="background-color: {{ $newsletter->button_color }};"></div>
                                <span class="text-white text-sm">{{ $newsletter->button_color }}</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Button Text Color</label>
                            <div class="flex items-center space-x-2">
                                <div class="w-8 h-8 rounded border border-gray-600" style="background-color: {{ $newsletter->button_text_color }};"></div>
                                <span class="text-white text-sm">{{ $newsletter->button_text_color }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Social Links -->
                <div class="bg-gray-800 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-white mb-4">Social Links</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Show Social Links</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $newsletter->show_social_links ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $newsletter->show_social_links ? 'Yes' : 'No' }}
                            </span>
                        </div>

                        @if($newsletter->show_social_links && $newsletter->social_links)
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-2">Social Links</label>
                            <div class="space-y-2">
                                @foreach($newsletter->social_links as $link)
                                    @if(!empty($link['platform']) && !empty($link['url']))
                                    <div class="flex items-center justify-between bg-gray-700 rounded-lg p-3">
                                        <div class="flex items-center space-x-3">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                                                {{ $link['platform'] }}
                                            </span>
                                            <span class="text-white text-sm">{{ $link['url'] }}</span>
                                        </div>
                                        <a href="{{ $link['url'] }}" target="_blank" class="text-blue-400 hover:text-blue-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Settings -->
                <div class="bg-gray-800 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-white mb-4">Settings</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Status</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $newsletter->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    @if($newsletter->is_active)
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    @else
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    @endif
                                </svg>
                                {{ $newsletter->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Sort Order</label>
                            <p class="text-white">{{ $newsletter->sort_order }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Created</label>
                            <p class="text-white">{{ $newsletter->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-300 mb-1">Last Updated</label>
                            <p class="text-white">{{ $newsletter->updated_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Preview -->
            <div class="space-y-6">
                <!-- Live Preview -->
                <div class="bg-gray-800 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-white mb-4">Live Preview</h3>
                    
                    <div class="border border-gray-600 rounded-lg p-6" style="background-color: {{ $newsletter->background_color }};">
                        <div class="text-center">
                            <h4 class="text-xl font-bold mb-2" style="color: {{ $newsletter->text_color }};">{{ $newsletter->title }}</h4>
                            
                            @if($newsletter->subtitle)
                            <p class="text-sm mb-2" style="color: {{ $newsletter->text_color }};">{{ $newsletter->subtitle }}</p>
                            @endif
                            
                            @if($newsletter->description)
                            <p class="text-sm mb-4" style="color: {{ $newsletter->text_color }};">{{ $newsletter->description }}</p>
                            @endif
                            
                            <div class="flex items-center space-x-2 mb-4">
                                <input type="email" placeholder="{{ $newsletter->placeholder_text }}" 
                                       class="flex-1 px-3 py-2 border rounded-md text-sm" readonly>
                                <button class="px-4 py-2 rounded-md text-sm font-medium" 
                                        style="background-color: {{ $newsletter->button_color }}; color: {{ $newsletter->button_text_color }};">
                                    {{ $newsletter->button_text }}
                                </button>
                            </div>
                            
                            @if($newsletter->show_social_links && $newsletter->social_links)
                            <div class="flex justify-center items-center space-x-3">
                                <span class="text-xs" style="color: {{ $newsletter->text_color }};">Follow us:</span>
                                @foreach($newsletter->social_links as $link)
                                    @if(!empty($link['platform']) && !empty($link['url']))
                                    <a href="{{ $link['url'] }}" target="_blank" class="text-xs px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 transition-colors">
                                        {{ ucfirst($link['platform']) }}
                                    </a>
                                    @endif
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-gray-800 rounded-lg p-6">
                    <h3 class="text-lg font-medium text-white mb-4">Quick Actions</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.newsletters.edit', $newsletter) }}" class="w-full btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Newsletter Section
                        </a>

                        <a href="{{ route('admin.newsletter-subscribers.index') }}" class="w-full btn btn-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            View Subscribers
                        </a>

                        <button onclick="toggleStatus({{ $newsletter->id }})" 
                                class="w-full btn {{ $newsletter->is_active ? 'btn-danger' : 'btn-success' }}">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                @if($newsletter->is_active)
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                @else
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                @endif
                            </svg>
                            {{ $newsletter->is_active ? 'Deactivate' : 'Activate' }}
                        </button>

                        <form action="{{ route('admin.newsletters.destroy', $newsletter) }}" method="POST" class="w-full" onsubmit="return confirm('Are you sure you want to delete this newsletter section? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full btn btn-danger">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete Newsletter Section
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Information -->
                <div class="bg-blue-900 rounded-lg p-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-300 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-medium text-blue-100 mb-2">Newsletter Section</h3>
                            <div class="text-blue-200 space-y-1 text-sm">
                                <p>• This newsletter section will appear on your website when active</p>
                                <p>• Only one newsletter section can be active at a time</p>
                                <p>• Subscribers will be saved to the newsletter subscribers list</p>
                                <p>• You can customize colors, text, and social media links</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleStatus(newsletterId) {
            fetch(`/admin/newsletters/${newsletterId}/toggle`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the status.');
            });
        }
    </script>
</x-layouts.admin>
