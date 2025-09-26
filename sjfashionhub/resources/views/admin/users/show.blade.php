<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img class="h-16 w-16 rounded-full object-cover mr-4" 
                             src="{{ $user->avatar_url }}" 
                             alt="{{ $user->name }}">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                            <p class="text-gray-600">{{ $user->email }}</p>
                            <div class="flex items-center space-x-2 mt-1">
                                @php
                                    $roleColors = [
                                        'admin' => 'bg-red-100 text-red-800',
                                        'manager' => 'bg-purple-100 text-purple-800',
                                        'customer' => 'bg-blue-100 text-blue-800'
                                    ];
                                    $statusColors = [
                                        'active' => 'bg-green-100 text-green-800',
                                        'inactive' => 'bg-gray-100 text-gray-800',
                                        'suspended' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $statusColors[$user->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                                @if($user->id === auth()->id())
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        You
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('admin.users.edit', $user) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-edit mr-2"></i>Edit User
                        </a>
                        <a href="{{ route('admin.users.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Users
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Information -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Personal Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">👤 Personal Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <p class="text-gray-900">{{ $user->name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <div class="flex items-center">
                                    <p class="text-gray-900">{{ $user->email }}</p>
                                    @if($user->email_verified_at)
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check mr-1"></i>Verified
                                        </span>
                                    @else
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-exclamation-triangle mr-1"></i>Unverified
                                        </span>
                                    @endif
                                </div>
                            </div>

                            @if($user->phone)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                    <p class="text-gray-900">{{ $user->phone }}</p>
                                </div>
                            @endif

                            @if($user->date_of_birth)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                    <p class="text-gray-900">
                                        {{ $user->date_of_birth->format('M d, Y') }}
                                        @if($user->age)
                                            <span class="text-gray-500">({{ $user->age }} years old)</span>
                                        @endif
                                    </p>
                                </div>
                            @endif

                            @if($user->gender)
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                                    <p class="text-gray-900">{{ ucfirst($user->gender) }}</p>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">User ID</label>
                                <p class="text-gray-900 font-mono">#{{ $user->id }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Address Information -->
                    @if($user->address || $user->city || $user->state || $user->country)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">📍 Address Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if($user->address)
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Street Address</label>
                                        <p class="text-gray-900">{{ $user->address }}</p>
                                    </div>
                                @endif

                                @if($user->city)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                        <p class="text-gray-900">{{ $user->city }}</p>
                                    </div>
                                @endif

                                @if($user->state)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                                        <p class="text-gray-900">{{ $user->state }}</p>
                                    </div>
                                @endif

                                @if($user->postal_code)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Postal Code</label>
                                        <p class="text-gray-900">{{ $user->postal_code }}</p>
                                    </div>
                                @endif

                                @if($user->country)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                        <p class="text-gray-900">{{ $user->country }}</p>
                                    </div>
                                @endif

                                @if($user->full_address)
                                    <div class="md:col-span-2">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Complete Address</label>
                                        <p class="text-gray-900">{{ $user->full_address }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Marketing Preferences -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📧 Marketing Preferences</h3>
                        
                        <div class="space-y-3">
                            <div class="flex items-center">
                                <i class="fas fa-{{ $user->email_marketing_consent ? 'check text-green-600' : 'times text-red-600' }} mr-2"></i>
                                <span class="text-sm text-gray-700">Email Marketing Consent</span>
                            </div>

                            <div class="flex items-center">
                                <i class="fas fa-{{ $user->sms_marketing_consent ? 'check text-green-600' : 'times text-red-600' }} mr-2"></i>
                                <span class="text-sm text-gray-700">SMS Marketing Consent</span>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    @if($user->notes)
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">📝 Internal Notes</h3>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-gray-900 whitespace-pre-wrap">{{ $user->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    
                    <!-- Account Status -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Account Status</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Current Status</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$user->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Login</label>
                                @if($user->last_login_at)
                                    <p class="text-gray-900">{{ $user->last_login_at->diffForHumans() }}</p>
                                    <p class="text-xs text-gray-500">{{ $user->last_login_at->format('M d, Y \a\t g:i A') }}</p>
                                @else
                                    <p class="text-gray-500">Never logged in</p>
                                @endif
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Member Since</label>
                                <p class="text-gray-900">{{ $user->created_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    @if($user->id !== auth()->id())
                        <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">⚡ Quick Actions</h3>
                            
                            <div class="space-y-3">
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="w-full {{ $user->status === 'active' ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-2 rounded-md font-medium transition-colors">
                                        <i class="fas fa-{{ $user->status === 'active' ? 'pause' : 'play' }} mr-2"></i>
                                        {{ $user->status === 'active' ? 'Deactivate' : 'Activate' }} User
                                    </button>
                                </form>

                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors text-center block">
                                    <i class="fas fa-edit mr-2"></i>Edit User
                                </a>

                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                                      onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                        <i class="fas fa-trash mr-2"></i>Delete User
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif

                    <!-- Account Information -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">ℹ️ Account Information</h3>
                        
                        <div class="space-y-3 text-sm">
                            <div>
                                <span class="font-medium text-gray-700">Created:</span>
                                <p class="text-gray-900">{{ $user->created_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>

                            <div>
                                <span class="font-medium text-gray-700">Last Updated:</span>
                                <p class="text-gray-900">{{ $user->updated_at->format('M d, Y \a\t g:i A') }}</p>
                            </div>

                            @if($user->email_verified_at)
                                <div>
                                    <span class="font-medium text-gray-700">Email Verified:</span>
                                    <p class="text-gray-900">{{ $user->email_verified_at->format('M d, Y \a\t g:i A') }}</p>
                                </div>
                            @endif

                            <div>
                                <span class="font-medium text-gray-700">User ID:</span>
                                <p class="text-gray-900 font-mono">#{{ $user->id }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
