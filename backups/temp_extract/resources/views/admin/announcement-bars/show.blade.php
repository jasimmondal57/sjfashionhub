<x-layouts.admin title="View Announcement Bar" description="View announcement bar details">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-black">Announcement Bar Details</h1>
                <p class="text-gray-600">View announcement bar information and settings</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.announcement-bars.edit', $announcementBar) }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.announcement-bars.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Preview -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-medium text-black mb-4">Live Preview</h3>
            <div class="border border-gray-300 rounded-md p-4 text-center" 
                 style="background-color: {{ $announcementBar->background_color }}; color: {{ $announcementBar->text_color }};">
                <span class="{{ $announcementBar->is_scrolling ? 'scrolling-text' : '' }}" 
                      @if($announcementBar->is_scrolling) 
                      data-scroll-speed="{{ $announcementBar->scroll_speed }}"
                      @endif>
                    {{ $announcementBar->message }}
                </span>
                @if($announcementBar->links && count($announcementBar->links) > 0)
                    <span class="ml-4">
                        @foreach($announcementBar->links as $link)
                            <a href="{{ $link['url'] }}" class="ml-4 hover:underline">{{ $link['text'] }}</a>
                        @endforeach
                    </span>
                @endif
            </div>
        </div>

        <!-- Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Basic Information -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Basic Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Message</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $announcementBar->message }}</p>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Background Color</label>
                            <div class="mt-1 flex items-center space-x-2">
                                <div class="w-6 h-6 rounded border border-gray-200" style="background-color: {{ $announcementBar->background_color }}"></div>
                                <span class="text-sm text-gray-900">{{ $announcementBar->background_color }}</span>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Text Color</label>
                            <div class="mt-1 flex items-center space-x-2">
                                <div class="w-6 h-6 rounded border border-gray-200" style="background-color: {{ $announcementBar->text_color }}"></div>
                                <span class="text-sm text-gray-900">{{ $announcementBar->text_color }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sort Order</label>
                        <p class="mt-1 text-sm text-gray-900">#{{ $announcementBar->sort_order }}</p>
                    </div>
                </div>
            </div>

            <!-- Settings -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Settings</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $announcementBar->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $announcementBar->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Scrolling</label>
                        <div class="mt-1">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $announcementBar->is_scrolling ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $announcementBar->is_scrolling ? 'Enabled' : 'Disabled' }}
                            </span>
                            @if($announcementBar->is_scrolling)
                                <span class="ml-2 text-sm text-gray-500">({{ $announcementBar->scroll_speed }}px/s)</span>
                            @endif
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Created</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $announcementBar->created_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $announcementBar->updated_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Links -->
        @if($announcementBar->links && count($announcementBar->links) > 0)
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Links ({{ count($announcementBar->links) }})</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Text</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preview</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($announcementBar->links as $link)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $link['text'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $link['url'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <a href="{{ $link['url'] }}" target="_blank" class="text-blue-600 hover:text-blue-800 hover:underline">
                                            Visit Link
                                            <svg class="w-3 h-3 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Links</h3>
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No links</h3>
                    <p class="mt-1 text-sm text-gray-500">This announcement bar doesn't have any links.</p>
                </div>
            </div>
        @endif

        <!-- Actions -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-medium text-black mb-4">Actions</h3>
            <div class="flex space-x-4">
                <form action="{{ route('admin.announcement-bars.toggle', $announcementBar) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn {{ $announcementBar->is_active ? 'btn-secondary' : 'btn-primary' }}">
                        {{ $announcementBar->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
                
                <a href="{{ route('admin.announcement-bars.edit', $announcementBar) }}" class="btn btn-primary">
                    Edit Announcement Bar
                </a>
                
                <button onclick="deleteBar({{ $announcementBar->id }})" class="btn btn-danger">
                    Delete Announcement Bar
                </button>
            </div>
        </div>
    </div>

    @if($announcementBar->is_scrolling)
        <style>
            .scrolling-text {
                white-space: nowrap;
                animation: scroll-left linear infinite;
            }
            
            @keyframes scroll-left {
                0% {
                    transform: translateX(100%);
                }
                100% {
                    transform: translateX(-100%);
                }
            }
            
            .scrolling-text[data-scroll-speed="{{ $announcementBar->scroll_speed }}"] { 
                animation-duration: {{ 8 - ($announcementBar->scroll_speed / 25) }}s; 
            }
        </style>
    @endif

    <script>
        function deleteBar(barId) {
            if (confirm('Are you sure you want to delete this announcement bar? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/announcement-bars/${barId}`;
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
