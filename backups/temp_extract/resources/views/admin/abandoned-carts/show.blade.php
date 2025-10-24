<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">🛒 Abandoned Cart Details</h1>
                        <p class="text-gray-600 mt-1">Cart ID: #{{ $abandonedCart->id }}</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.abandoned-carts.index') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Back to List
                        </a>
                        @if($abandonedCart->status === 'abandoned')
                            <button onclick="showEmailModal()" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                <i class="fas fa-envelope mr-2"></i>Send Recovery Email
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Cart Items -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">🛍️ Cart Items</h3>
                        <div class="space-y-4">
                            @foreach($abandonedCart->cart_items_with_details as $item)
                                <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                                    <div class="flex-shrink-0">
                                        @if($item['image'])
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" 
                                                 class="h-16 w-16 object-cover rounded-lg">
                                        @else
                                            <div class="h-16 w-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-sm font-medium text-gray-900">{{ $item['name'] }}</h4>
                                        @if($item['sku'])
                                            <p class="text-sm text-gray-500">SKU: {{ $item['sku'] }}</p>
                                        @endif
                                        @if($item['variant'])
                                            <p class="text-sm text-gray-500">Variant: {{ $item['variant'] }}</p>
                                        @endif
                                        <div class="flex items-center justify-between mt-2">
                                            <span class="text-sm text-gray-600">Qty: {{ $item['quantity'] }}</span>
                                            <span class="text-sm font-medium text-gray-900">₹{{ number_format($item['total'], 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Cart Summary -->
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <div class="space-y-2">
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-600">Subtotal:</span>
                                    <span class="text-gray-900">₹{{ number_format($abandonedCart->cart_subtotal, 2) }}</span>
                                </div>
                                @if($abandonedCart->cart_tax > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Tax:</span>
                                        <span class="text-gray-900">₹{{ number_format($abandonedCart->cart_tax, 2) }}</span>
                                    </div>
                                @endif
                                @if($abandonedCart->cart_shipping > 0)
                                    <div class="flex justify-between text-sm">
                                        <span class="text-gray-600">Shipping:</span>
                                        <span class="text-gray-900">₹{{ number_format($abandonedCart->cart_shipping, 2) }}</span>
                                    </div>
                                @endif
                                <div class="flex justify-between text-lg font-medium pt-2 border-t border-gray-200">
                                    <span class="text-gray-900">Total:</span>
                                    <span class="text-gray-900">{{ $abandonedCart->formatted_total }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email History -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">📧 Email History</h3>
                        @if($abandonedCart->emails->count() > 0)
                            <div class="space-y-4">
                                @foreach($abandonedCart->emails->sortByDesc('created_at') as $email)
                                    <div class="border border-gray-200 rounded-lg p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-sm font-medium text-gray-900">{{ $email->email_type_label }}</span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                    {{ $email->status === 'sent' ? 'bg-blue-100 text-blue-800' : '' }}
                                                    {{ $email->status === 'opened' ? 'bg-green-100 text-green-800' : '' }}
                                                    {{ $email->status === 'clicked' ? 'bg-purple-100 text-purple-800' : '' }}
                                                    {{ $email->status === 'failed' ? 'bg-red-100 text-red-800' : '' }}
                                                    {{ $email->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                                    {{ ucfirst($email->status) }}
                                                </span>
                                            </div>
                                            <span class="text-sm text-gray-500">{{ $email->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm font-medium text-gray-900 mb-1">{{ $email->subject }}</p>
                                        <p class="text-sm text-gray-600 mb-2">{{ Str::limit($email->content, 100) }}</p>
                                        @if($email->coupon_code)
                                            <div class="flex items-center space-x-2 text-sm">
                                                <span class="text-gray-600">Coupon:</span>
                                                <span class="font-medium text-green-600">{{ $email->coupon_code }}</span>
                                                <span class="text-gray-600">({{ $email->formatted_discount }} off)</span>
                                            </div>
                                        @endif
                                        @if($email->sent_at)
                                            <div class="text-sm text-gray-500 mt-2">
                                                Sent: {{ $email->sent_at->format('M j, Y g:i A') }}
                                            </div>
                                        @endif
                                        @if($email->error_message)
                                            <div class="text-sm text-red-600 mt-2">
                                                Error: {{ $email->error_message }}
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <i class="fas fa-envelope text-gray-400 text-4xl mb-4"></i>
                                <p class="text-gray-500">No recovery emails sent yet</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Customer Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">👤 Customer Information</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Name:</label>
                                <p class="text-sm text-gray-900">{{ $abandonedCart->customer_name }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Email:</label>
                                <p class="text-sm text-gray-900">{{ $abandonedCart->customer_email }}</p>
                            </div>
                            @if($abandonedCart->phone)
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Phone:</label>
                                    <p class="text-sm text-gray-900">{{ $abandonedCart->phone }}</p>
                                </div>
                            @endif
                            <div>
                                <label class="text-sm font-medium text-gray-600">Customer Type:</label>
                                <p class="text-sm text-gray-900">{{ $abandonedCart->is_guest ? 'Guest' : 'Registered User' }}</p>
                            </div>
                            @if($abandonedCart->country)
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Location:</label>
                                    <p class="text-sm text-gray-900">{{ $abandonedCart->city }}, {{ $abandonedCart->country }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Cart Status -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">📊 Cart Status</h3>
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-600">Status:</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $abandonedCart->status === 'abandoned' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $abandonedCart->status === 'recovered' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $abandonedCart->status === 'expired' ? 'bg-gray-100 text-gray-800' : '' }}">
                                    {{ ucfirst($abandonedCart->status) }}
                                </span>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Abandoned:</label>
                                <p class="text-sm text-gray-900">{{ $abandonedCart->abandoned_at->format('M j, Y g:i A') }}</p>
                                <p class="text-sm text-gray-500">{{ $abandonedCart->time_since_abandoned }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-600">Last Activity:</label>
                                <p class="text-sm text-gray-900">{{ $abandonedCart->last_activity_at->format('M j, Y g:i A') }}</p>
                            </div>
                            @if($abandonedCart->recovered_at)
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Recovered:</label>
                                    <p class="text-sm text-gray-900">{{ $abandonedCart->recovered_at->format('M j, Y g:i A') }}</p>
                                </div>
                            @endif
                            @if($abandonedCart->expires_at)
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Expires:</label>
                                    <p class="text-sm text-gray-900">{{ $abandonedCart->expires_at->format('M j, Y g:i A') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Technical Details -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">🔧 Technical Details</h3>
                        <div class="space-y-3">
                            @if($abandonedCart->session_id)
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Session ID:</label>
                                    <p class="text-sm text-gray-900 font-mono">{{ Str::limit($abandonedCart->session_id, 20) }}</p>
                                </div>
                            @endif
                            @if($abandonedCart->ip_address)
                                <div>
                                    <label class="text-sm font-medium text-gray-600">IP Address:</label>
                                    <p class="text-sm text-gray-900">{{ $abandonedCart->ip_address }}</p>
                                </div>
                            @endif
                            @if($abandonedCart->browser_info)
                                <div>
                                    <label class="text-sm font-medium text-gray-600">Browser Info:</label>
                                    <p class="text-sm text-gray-900">{{ json_encode($abandonedCart->browser_info) }}</p>
                                </div>
                            @endif
                            @if($abandonedCart->utm_source || $abandonedCart->utm_medium || $abandonedCart->utm_campaign)
                                <div>
                                    <label class="text-sm font-medium text-gray-600">UTM Parameters:</label>
                                    <div class="text-sm text-gray-900">
                                        @if($abandonedCart->utm_source)
                                            <p>Source: {{ $abandonedCart->utm_source }}</p>
                                        @endif
                                        @if($abandonedCart->utm_medium)
                                            <p>Medium: {{ $abandonedCart->utm_medium }}</p>
                                        @endif
                                        @if($abandonedCart->utm_campaign)
                                            <p>Campaign: {{ $abandonedCart->utm_campaign }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    @if($abandonedCart->status === 'abandoned')
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">⚡ Quick Actions</h3>
                            <div class="space-y-3">
                                <button onclick="markAsRecovered()" 
                                        class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                    <i class="fas fa-check mr-2"></i>Mark as Recovered
                                </button>
                                <button onclick="markAsExpired()" 
                                        class="w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                    <i class="fas fa-clock mr-2"></i>Mark as Expired
                                </button>
                                <a href="{{ $abandonedCart->recovery_url }}" target="_blank"
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors text-center block">
                                    <i class="fas fa-external-link-alt mr-2"></i>View Recovery Link
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
