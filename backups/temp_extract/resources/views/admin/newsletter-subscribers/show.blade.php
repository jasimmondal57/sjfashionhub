<x-layouts.admin title="Subscriber Details" description="View newsletter subscriber details">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Subscriber Details</h1>
                <p class="text-gray-100">View newsletter subscriber information and activity</p>
            </div>
            <div class="flex items-center space-x-3">
                @if($newsletterSubscriber->status === 'active')
                    <button onclick="unsubscribeUser({{ $newsletterSubscriber->id }})" class="btn btn-danger">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                        </svg>
                        Unsubscribe
                    </button>
                @elseif($newsletterSubscriber->status === 'unsubscribed')
                    <button onclick="resubscribeUser({{ $newsletterSubscriber->id }})" class="btn btn-success">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Resubscribe
                    </button>
                @endif
                <a href="{{ route('admin.newsletter-subscribers.edit', $newsletterSubscriber) }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.newsletter-subscribers.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Subscribers
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column - Subscriber Information -->
            <div class="space-y-6">
                <!-- Basic Information -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Subscriber Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <p class="text-gray-900 text-lg">{{ $newsletterSubscriber->email }}</p>
                        </div>

                        @if($newsletterSubscriber->name)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                            <p class="text-gray-900">{{ $newsletterSubscriber->name }}</p>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                {{ $newsletterSubscriber->status === 'active' ? 'bg-green-600 text-white' :
                                   ($newsletterSubscriber->status === 'unsubscribed' ? 'bg-red-600 text-white' : 'bg-yellow-600 text-white') }}">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    @if($newsletterSubscriber->status === 'active')
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    @elseif($newsletterSubscriber->status === 'unsubscribed')
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    @else
                                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    @endif
                                </svg>
                                {{ ucfirst($newsletterSubscriber->status) }}
                            </span>
                        </div>

                        @if($newsletterSubscriber->source)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Subscription Source</label>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-600 text-white">
                                {{ ucfirst($newsletterSubscriber->source) }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Subscription Timeline -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Subscription Timeline</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-600 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="text-gray-900 font-medium">Subscribed</div>
                                <div class="text-gray-600 text-sm">{{ $newsletterSubscriber->subscribed_at->format('M d, Y \a\t g:i A') }}</div>
                                <div class="text-gray-500 text-xs">{{ $newsletterSubscriber->subscribed_at->diffForHumans() }}</div>
                            </div>
                        </div>

                        @if($newsletterSubscriber->unsubscribed_at)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="flex-1">
                                <div class="text-gray-900 font-medium">Unsubscribed</div>
                                <div class="text-gray-600 text-sm">{{ $newsletterSubscriber->unsubscribed_at->format('M d, Y \a\t g:i A') }}</div>
                                <div class="text-gray-500 text-xs">{{ $newsletterSubscriber->unsubscribed_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Technical Information -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Technical Information</h3>
                    
                    <div class="space-y-4">
                        @if($newsletterSubscriber->ip_address)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">IP Address</label>
                            <p class="text-gray-900 font-mono text-sm">{{ $newsletterSubscriber->ip_address }}</p>
                        </div>
                        @endif

                        @if($newsletterSubscriber->user_agent)
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">User Agent</label>
                            <p class="text-gray-900 text-sm break-all">{{ $newsletterSubscriber->user_agent }}</p>
                        </div>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Record ID</label>
                            <p class="text-gray-900 font-mono text-sm">{{ $newsletterSubscriber->id }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Created</label>
                            <p class="text-gray-900 text-sm">{{ $newsletterSubscriber->created_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                            <p class="text-gray-900 text-sm">{{ $newsletterSubscriber->updated_at->format('M d, Y \a\t g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Actions and Preferences -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.newsletter-subscribers.edit', $newsletterSubscriber) }}" class="w-full btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Subscriber
                        </a>

                        @if($newsletterSubscriber->status === 'active')
                            <button onclick="unsubscribeUser({{ $newsletterSubscriber->id }})" class="w-full btn btn-danger">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                </svg>
                                Unsubscribe User
                            </button>
                        @elseif($newsletterSubscriber->status === 'unsubscribed')
                            <button onclick="resubscribeUser({{ $newsletterSubscriber->id }})" class="w-full btn btn-success">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Resubscribe User
                            </button>
                        @endif

                        <form action="{{ route('admin.newsletter-subscribers.destroy', $newsletterSubscriber) }}" method="POST" class="w-full" onsubmit="return confirm('Are you sure you want to delete this subscriber? This action cannot be undone.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full btn btn-danger">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete Subscriber
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Preferences -->
                @if($newsletterSubscriber->preferences)
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Preferences</h3>
                    
                    <div class="space-y-3">
                        @foreach($newsletterSubscriber->preferences as $key => $value)
                        <div class="flex items-center justify-between">
                            <span class="text-gray-700 capitalize">{{ str_replace('_', ' ', $key) }}</span>
                            <span class="text-gray-900">{{ is_bool($value) ? ($value ? 'Yes' : 'No') : $value }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Export Options -->
                <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Export Options</h3>
                    
                    <div class="space-y-3">
                        <a href="{{ route('admin.newsletter-subscribers.export', ['search' => $newsletterSubscriber->email]) }}" class="w-full btn btn-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export This Subscriber
                        </a>

                        <a href="{{ route('admin.newsletter-subscribers.export') }}" class="w-full btn btn-secondary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Export All Subscribers
                        </a>
                    </div>
                </div>

                <!-- Information -->
                <div class="bg-blue-900 rounded-lg p-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-blue-300 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="text-lg font-medium text-blue-100 mb-2">Subscriber Management</h3>
                            <div class="text-blue-200 space-y-1 text-sm">
                                <p>• Edit subscriber information and preferences</p>
                                <p>• Manage subscription status (active/unsubscribed)</p>
                                <p>• View subscription history and technical details</p>
                                <p>• Export subscriber data for external use</p>
                                <p>• Delete subscribers permanently if needed</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function unsubscribeUser(subscriberId) {
            if (confirm('Are you sure you want to unsubscribe this user?')) {
                fetch(`/admin/newsletter-subscribers/${subscriberId}/unsubscribe`, {
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
                    alert('An error occurred while updating the subscriber.');
                });
            }
        }

        function resubscribeUser(subscriberId) {
            if (confirm('Are you sure you want to resubscribe this user?')) {
                fetch(`/admin/newsletter-subscribers/${subscriberId}/resubscribe`, {
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
                    alert('An error occurred while updating the subscriber.');
                });
            }
        }
    </script>
</x-layouts.admin>
