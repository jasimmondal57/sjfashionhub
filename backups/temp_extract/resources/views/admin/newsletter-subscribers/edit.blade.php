<x-layouts.admin title="Edit Subscriber" description="Edit newsletter subscriber details">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Edit Subscriber</h1>
                <p class="text-gray-100">Update newsletter subscriber information and preferences</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.newsletter-subscribers.show', $newsletterSubscriber) }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View
                </a>
                <a href="{{ route('admin.newsletter-subscribers.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Subscribers
                </a>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.newsletter-subscribers.update', $newsletterSubscriber) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                                <input type="email" name="email" id="email" value="{{ old('email', $newsletterSubscriber->email) }}"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name', $newsletterSubscriber->name) }}"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Subscriber's name">
                                @error('name')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                                <select name="status" id="status" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    <option value="active" {{ old('status', $newsletterSubscriber->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="unsubscribed" {{ old('status', $newsletterSubscriber->status) == 'unsubscribed' ? 'selected' : '' }}>Unsubscribed</option>
                                    <option value="bounced" {{ old('status', $newsletterSubscriber->status) == 'bounced' ? 'selected' : '' }}>Bounced</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="source" class="block text-sm font-medium text-gray-700 mb-2">Subscription Source</label>
                                <select name="source" id="source" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Select Source</option>
                                    <option value="homepage" {{ old('source', $newsletterSubscriber->source) == 'homepage' ? 'selected' : '' }}>Homepage</option>
                                    <option value="popup" {{ old('source', $newsletterSubscriber->source) == 'popup' ? 'selected' : '' }}>Popup</option>
                                    <option value="footer" {{ old('source', $newsletterSubscriber->source) == 'footer' ? 'selected' : '' }}>Footer</option>
                                    <option value="checkout" {{ old('source', $newsletterSubscriber->source) == 'checkout' ? 'selected' : '' }}>Checkout</option>
                                    <option value="manual" {{ old('source', $newsletterSubscriber->source) == 'manual' ? 'selected' : '' }}>Manual</option>
                                    <option value="import" {{ old('source', $newsletterSubscriber->source) == 'import' ? 'selected' : '' }}>Import</option>
                                </select>
                                @error('source')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Subscription Timeline -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Subscription Timeline</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Subscribed At</label>
                                <p class="text-gray-900">{{ $newsletterSubscriber->subscribed_at->format('M d, Y \a\t g:i A') }}</p>
                                <p class="text-gray-600 text-sm">{{ $newsletterSubscriber->subscribed_at->diffForHumans() }}</p>
                            </div>

                            @if($newsletterSubscriber->unsubscribed_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Unsubscribed At</label>
                                <p class="text-gray-900">{{ $newsletterSubscriber->unsubscribed_at->format('M d, Y \a\t g:i A') }}</p>
                                <p class="text-gray-600 text-sm">{{ $newsletterSubscriber->unsubscribed_at->diffForHumans() }}</p>
                            </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Updated</label>
                                <p class="text-gray-900">{{ $newsletterSubscriber->updated_at->format('M d, Y \a\t g:i A') }}</p>
                                <p class="text-gray-600 text-sm">{{ $newsletterSubscriber->updated_at->diffForHumans() }}</p>
                            </div>
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
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Preferences -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Email Preferences</h3>
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 gap-4">
                                <div class="flex items-center">
                                    <input type="checkbox" name="preferences[newsletter]" id="pref_newsletter" value="1"
                                           {{ (old('preferences.newsletter', $newsletterSubscriber->preferences['newsletter'] ?? true)) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                    <label for="pref_newsletter" class="ml-2 text-sm text-gray-700">Newsletter Updates</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="preferences[promotions]" id="pref_promotions" value="1"
                                           {{ (old('preferences.promotions', $newsletterSubscriber->preferences['promotions'] ?? true)) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                    <label for="pref_promotions" class="ml-2 text-sm text-gray-700">Promotional Offers</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="preferences[new_products]" id="pref_new_products" value="1"
                                           {{ (old('preferences.new_products', $newsletterSubscriber->preferences['new_products'] ?? true)) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                    <label for="pref_new_products" class="ml-2 text-sm text-gray-700">New Product Announcements</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="preferences[sales]" id="pref_sales" value="1"
                                           {{ (old('preferences.sales', $newsletterSubscriber->preferences['sales'] ?? true)) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                    <label for="pref_sales" class="ml-2 text-sm text-gray-700">Sales & Discounts</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="preferences[events]" id="pref_events" value="1"
                                           {{ (old('preferences.events', $newsletterSubscriber->preferences['events'] ?? false)) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                    <label for="pref_events" class="ml-2 text-sm text-gray-700">Events & Workshops</label>
                                </div>

                                <div class="flex items-center">
                                    <input type="checkbox" name="preferences[fashion_tips]" id="pref_fashion_tips" value="1"
                                           {{ (old('preferences.fashion_tips', $newsletterSubscriber->preferences['fashion_tips'] ?? false)) ? 'checked' : '' }}
                                           class="h-4 w-4 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                                    <label for="pref_fashion_tips" class="ml-2 text-sm text-gray-700">Fashion Tips & Trends</label>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-200">
                                <label for="frequency" class="block text-sm font-medium text-gray-700 mb-2">Email Frequency</label>
                                <select name="preferences[frequency]" id="frequency" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="daily" {{ (old('preferences.frequency', $newsletterSubscriber->preferences['frequency'] ?? 'weekly')) == 'daily' ? 'selected' : '' }}>Daily</option>
                                    <option value="weekly" {{ (old('preferences.frequency', $newsletterSubscriber->preferences['frequency'] ?? 'weekly')) == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                    <option value="monthly" {{ (old('preferences.frequency', $newsletterSubscriber->preferences['frequency'] ?? 'weekly')) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Current Status Preview -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Current Status</h3>
                        
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700">Email</span>
                                <span class="text-gray-900">{{ $newsletterSubscriber->email }}</span>
                            </div>

                            <div class="flex items-center justify-between">
                                <span class="text-gray-700">Status</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $newsletterSubscriber->status === 'active' ? 'bg-green-600 text-white' :
                                       ($newsletterSubscriber->status === 'unsubscribed' ? 'bg-red-600 text-white' : 'bg-yellow-600 text-white') }}">
                                    {{ ucfirst($newsletterSubscriber->status) }}
                                </span>
                            </div>

                            @if($newsletterSubscriber->source)
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700">Source</span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-600 text-white">
                                    {{ ucfirst($newsletterSubscriber->source) }}
                                </span>
                            </div>
                            @endif

                            <div class="flex items-center justify-between">
                                <span class="text-gray-700">Subscribed</span>
                                <span class="text-gray-900 text-sm">{{ $newsletterSubscriber->subscribed_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg p-6 shadow-sm border border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Quick Actions</h3>
                        
                        <div class="space-y-3">
                            @if($newsletterSubscriber->status === 'active')
                                <button type="button" onclick="unsubscribeUser({{ $newsletterSubscriber->id }})" class="w-full btn btn-danger">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                                    </svg>
                                    Unsubscribe User
                                </button>
                            @elseif($newsletterSubscriber->status === 'unsubscribed')
                                <button type="button" onclick="resubscribeUser({{ $newsletterSubscriber->id }})" class="w-full btn btn-success">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Resubscribe User
                                </button>
                            @endif

                            <a href="{{ route('admin.newsletter-subscribers.export', ['search' => $newsletterSubscriber->email]) }}" class="w-full btn btn-secondary">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Export Data
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
                                <h3 class="text-lg font-medium text-blue-100 mb-2">Edit Subscriber</h3>
                                <div class="text-blue-200 space-y-1 text-sm">
                                    <p>• Update subscriber email and personal information</p>
                                    <p>• Change subscription status and source</p>
                                    <p>• Manage email preferences and frequency</p>
                                    <p>• View subscription timeline and technical details</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-700">
                <a href="{{ route('admin.newsletter-subscribers.show', $newsletterSubscriber) }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Subscriber</button>
            </div>
        </form>
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
