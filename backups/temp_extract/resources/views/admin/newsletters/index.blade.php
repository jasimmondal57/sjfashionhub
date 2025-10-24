<x-layouts.admin title="Newsletter Management" description="Manage newsletter sections and settings">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Newsletter Management</h1>
                <p class="text-gray-100">Manage newsletter sections and subscription settings</p>
            </div>
            <a href="{{ route('admin.newsletters.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create Newsletter Section
            </a>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <a href="{{ route('admin.newsletters.create') }}" class="bg-gray-800 rounded-lg p-4 hover:bg-gray-700 transition-colors">
                <div class="flex items-center">
                    <div class="p-2 bg-blue-600 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-white">Newsletter Section</h3>
                        <p class="text-xs text-gray-400">Create newsletter signup</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('admin.newsletter-subscribers.index') }}" class="bg-gray-800 rounded-lg p-4 hover:bg-gray-700 transition-colors">
                <div class="flex items-center">
                    <div class="p-2 bg-green-600 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-white">View Subscribers</h3>
                        <p class="text-xs text-gray-400">Manage subscribers</p>
                    </div>
                </div>
            </a>

            <div class="bg-gray-800 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-purple-600 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v4a2 2 0 01-2 2h-2a2 2 0 00-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-white">Analytics</h3>
                        <p class="text-xs text-gray-400">Coming soon</p>
                    </div>
                </div>
            </div>

            <div class="bg-gray-800 rounded-lg p-4">
                <div class="flex items-center">
                    <div class="p-2 bg-orange-600 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-sm font-medium text-white">Settings</h3>
                        <p class="text-xs text-gray-400">Email configuration</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Newsletter Sections List -->
        <div class="bg-gray-800 rounded-lg">
            <div class="px-6 py-4 border-b border-gray-700">
                <h3 class="text-lg font-medium text-white">Newsletter Sections</h3>
                <p class="text-sm text-gray-400">Manage newsletter signup sections for your website</p>
            </div>

            @if($newsletters->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Section</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Colors</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Social Links</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Order</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            @foreach($newsletters as $newsletter)
                            <tr class="hover:bg-gray-700">
                                <td class="px-6 py-4">
                                    <div>
                                        <div class="text-sm font-medium text-white">{{ $newsletter->title }}</div>
                                        @if($newsletter->subtitle)
                                            <div class="text-sm text-gray-400">{{ $newsletter->subtitle }}</div>
                                        @endif
                                        <div class="text-xs text-gray-500 mt-1">
                                            Button: "{{ $newsletter->button_text }}" | Placeholder: "{{ $newsletter->placeholder_text }}"
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <button onclick="toggleStatus({{ $newsletter->id }})" 
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium transition-colors {{ $newsletter->is_active ? 'bg-green-100 text-green-800 hover:bg-green-200' : 'bg-red-100 text-red-800 hover:bg-red-200' }}">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            @if($newsletter->is_active)
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                            @else
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                            @endif
                                        </svg>
                                        {{ $newsletter->is_active ? 'Active' : 'Inactive' }}
                                    </button>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <div class="flex items-center space-x-1">
                                            <div class="w-4 h-4 rounded border border-gray-600" style="background-color: {{ $newsletter->background_color }};"></div>
                                            <span class="text-xs text-gray-400">BG</span>
                                        </div>
                                        <div class="flex items-center space-x-1">
                                            <div class="w-4 h-4 rounded border border-gray-600" style="background-color: {{ $newsletter->button_color }};"></div>
                                            <span class="text-xs text-gray-400">BTN</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($newsletter->show_social_links && $newsletter->social_links)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ count($newsletter->social_links) }} links
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-500">No social links</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-sm text-gray-300">{{ $newsletter->sort_order }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.newsletters.show', $newsletter) }}" class="text-blue-400 hover:text-blue-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.newsletters.edit', $newsletter) }}" class="text-yellow-400 hover:text-yellow-300">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.newsletters.destroy', $newsletter) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this newsletter section?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="px-6 py-12 text-center">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-lg font-medium text-white mb-2">No Newsletter Sections</h3>
                    <p class="text-gray-400 mb-4">Get started by creating your first newsletter signup section.</p>
                    <a href="{{ route('admin.newsletters.create') }}" class="btn btn-primary">
                        Create Newsletter Section
                    </a>
                </div>
            @endif
        </div>

        <!-- Information -->
        <div class="bg-blue-900 rounded-lg p-6">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-blue-300 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h3 class="text-lg font-medium text-blue-100 mb-2">Newsletter Management</h3>
                    <div class="text-blue-200 space-y-1 text-sm">
                        <p>• Create customizable newsletter signup sections for your website</p>
                        <p>• Manage subscriber data and export lists for email campaigns</p>
                        <p>• Customize colors, text, and social media links</p>
                        <p>• Track subscription analytics and manage unsubscribes</p>
                        <p>• Only one newsletter section can be active at a time</p>
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
