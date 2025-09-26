<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">🎫 Coupon Details</h1>
                        <p class="text-gray-600 mt-1">View coupon information and usage statistics</p>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-edit mr-2"></i>Edit Coupon
                        </a>
                        <a href="{{ route('admin.coupons.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Coupons
                        </a>
                    </div>
                </div>
            </div>

            <!-- Coupon Status Banner -->
            <div class="mb-6">
                @php
                    $status = $coupon->status;
                    $statusConfig = [
                        'active' => ['bg' => 'bg-green-50 border-green-200', 'text' => 'text-green-800', 'icon' => 'check-circle', 'message' => 'This coupon is currently active and available for use.'],
                        'inactive' => ['bg' => 'bg-gray-50 border-gray-200', 'text' => 'text-gray-800', 'icon' => 'pause-circle', 'message' => 'This coupon is currently inactive.'],
                        'expired' => ['bg' => 'bg-red-50 border-red-200', 'text' => 'text-red-800', 'icon' => 'x-circle', 'message' => 'This coupon has expired and is no longer valid.'],
                        'scheduled' => ['bg' => 'bg-blue-50 border-blue-200', 'text' => 'text-blue-800', 'icon' => 'clock', 'message' => 'This coupon is scheduled to start later.'],
                        'exhausted' => ['bg' => 'bg-yellow-50 border-yellow-200', 'text' => 'text-yellow-800', 'icon' => 'exclamation-triangle', 'message' => 'This coupon has reached its usage limit.']
                    ];
                    $config = $statusConfig[$status] ?? $statusConfig['inactive'];
                @endphp
                
                <div class="rounded-lg border p-4 {{ $config['bg'] }}">
                    <div class="flex">
                        <i class="fas fa-{{ $config['icon'] }} {{ $config['text'] }} mr-3 mt-0.5"></i>
                        <div>
                            <h3 class="text-sm font-medium {{ $config['text'] }}">
                                Coupon Status: {{ ucfirst($status) }}
                            </h3>
                            <p class="mt-1 text-sm {{ $config['text'] }}">{{ $config['message'] }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Information -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Basic Details -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📝 Basic Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Coupon Code</label>
                                <div class="flex items-center">
                                    <span class="text-lg font-mono bg-gray-100 px-3 py-2 rounded border font-bold">{{ $coupon->code }}</span>
                                    <button onclick="copyToClipboard('{{ $coupon->code }}')" 
                                            class="ml-2 text-gray-500 hover:text-gray-700" title="Copy code">
                                        <i class="fas fa-copy"></i>
                                    </button>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Coupon Name</label>
                                <p class="text-gray-900">{{ $coupon->name }}</p>
                            </div>

                            @if($coupon->description)
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                                    <p class="text-gray-900">{{ $coupon->description }}</p>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Visibility</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $coupon->is_public ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                    {{ $coupon->is_public ? 'Public' : 'Private' }}
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Created By</label>
                                <p class="text-gray-900">{{ $coupon->created_by ?? 'System' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Discount Configuration -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">💰 Discount Configuration</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Discount Type</label>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    {{ ucfirst(str_replace('_', ' ', $coupon->type)) }}
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Discount Value</label>
                                <p class="text-lg font-semibold text-gray-900">{{ $coupon->formatted_value }}</p>
                            </div>

                            @if($coupon->minimum_amount)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Minimum Order Amount</label>
                                    <p class="text-gray-900">₹{{ number_format($coupon->minimum_amount, 2) }}</p>
                                </div>
                            @endif

                            @if($coupon->maximum_discount && $coupon->type === 'percentage')
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Maximum Discount Cap</label>
                                    <p class="text-gray-900">₹{{ number_format($coupon->maximum_discount, 2) }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Date Restrictions -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📅 Date Restrictions</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Start Date</label>
                                <p class="text-gray-900">
                                    @if($coupon->starts_at)
                                        {{ $coupon->starts_at->format('M d, Y \a\t g:i A') }}
                                    @else
                                        <span class="text-gray-500">No start date (Active immediately)</span>
                                    @endif
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                                <p class="text-gray-900">
                                    @if($coupon->expires_at)
                                        {{ $coupon->expires_at->format('M d, Y \a\t g:i A') }}
                                        @if($coupon->expires_at->isPast())
                                            <span class="text-red-600 text-sm">(Expired)</span>
                                        @elseif($coupon->expires_at->diffInDays() <= 7)
                                            <span class="text-yellow-600 text-sm">(Expires soon)</span>
                                        @endif
                                    @else
                                        <span class="text-gray-500">No expiry date</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">⚙️ Settings</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-3">
                                <div class="flex items-center">
                                    <i class="fas fa-{{ $coupon->stackable ? 'check text-green-600' : 'times text-red-600' }} mr-2"></i>
                                    <span class="text-sm text-gray-700">Can be stacked with other coupons</span>
                                </div>

                                <div class="flex items-center">
                                    <i class="fas fa-{{ $coupon->first_order_only ? 'check text-green-600' : 'times text-red-600' }} mr-2"></i>
                                    <span class="text-sm text-gray-700">First-time customers only</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                                <p class="text-gray-900">{{ $coupon->priority }}</p>
                                <p class="text-xs text-gray-500">Higher priority coupons are applied first</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    
                    <!-- Usage Statistics -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Usage Statistics</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm font-medium text-gray-700">Total Usage</span>
                                    <span class="text-sm text-gray-900">
                                        {{ $coupon->used_count }}
                                        @if($coupon->usage_limit)
                                            / {{ $coupon->usage_limit }}
                                        @else
                                            / ∞
                                        @endif
                                    </span>
                                </div>
                                @if($coupon->usage_limit)
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" 
                                             style="width: {{ $coupon->usage_percentage }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">{{ $coupon->usage_percentage }}% used</p>
                                @endif
                            </div>

                            @if($coupon->usage_limit_per_customer)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Per Customer Limit</label>
                                    <p class="text-gray-900">{{ $coupon->usage_limit_per_customer }} uses</p>
                                </div>
                            @endif

                            @if($coupon->last_used_at)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Last Used</label>
                                    <p class="text-gray-900">{{ $coupon->last_used_at->diffForHumans() }}</p>
                                    <p class="text-xs text-gray-500">{{ $coupon->last_used_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">⚡ Quick Actions</h3>
                        
                        <div class="space-y-3">
                            <form action="{{ route('admin.coupons.toggle', $coupon) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full {{ $coupon->is_active ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-md font-medium transition-colors">
                                    <i class="fas fa-{{ $coupon->is_active ? 'pause' : 'play' }} mr-2"></i>
                                    {{ $coupon->is_active ? 'Deactivate' : 'Activate' }} Coupon
                                </button>
                            </form>

                            <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                               class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors text-center block">
                                <i class="fas fa-edit mr-2"></i>Edit Coupon
                            </a>

                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this coupon? This action cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                    <i class="fas fa-trash mr-2"></i>Delete Coupon
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Coupon Info -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">ℹ️ Information</h3>
                        
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Created:</span>
                                <p class="text-gray-900">{{ $coupon->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>

                            <div>
                                <span class="font-medium text-gray-700">Last Updated:</span>
                                <p class="text-gray-900">{{ $coupon->updated_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>

                            <div>
                                <span class="font-medium text-gray-700">Coupon ID:</span>
                                <p class="text-gray-900 font-mono">#{{ $coupon->id }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function() {
                // Show a temporary success message
                const button = event.target.closest('button');
                const originalIcon = button.innerHTML;
                button.innerHTML = '<i class="fas fa-check text-green-600"></i>';
                setTimeout(() => {
                    button.innerHTML = originalIcon;
                }, 2000);
            });
        }
    </script>
</x-layouts.admin>
