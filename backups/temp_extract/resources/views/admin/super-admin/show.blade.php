<x-layouts.admin>
    <x-slot name="title">Admin Details - {{ $admin->name }}</x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">👤 Admin Details</h1>
                <p class="text-gray-600 mt-1">View administrator information and account details</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.super-admin.index') }}" class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-lg flex items-center font-medium shadow-lg border border-gray-600">
                    ← Back to Admin List
                </a>
                @if($admin->id !== auth()->id())
                <a href="{{ route('admin.super-admin.edit', $admin) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center font-medium shadow-lg border border-blue-500">
                    ✏️ Edit Admin
                </a>
                @endif
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Profile Information -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Profile Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                            <p class="text-gray-900 font-medium">{{ $admin->name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                            <p class="text-gray-900">{{ $admin->email }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <p class="text-gray-900">{{ $admin->phone ?: 'Not provided' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                            <p class="text-gray-900">{{ $admin->date_of_birth ? $admin->date_of_birth->format('M d, Y') : 'Not provided' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                            <p class="text-gray-900">{{ $admin->gender ? ucfirst($admin->gender) : 'Not specified' }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                            <p class="text-gray-900">{{ $admin->country ?: 'Not provided' }}</p>
                        </div>
                    </div>
                    
                    @if($admin->address)
                    <div class="mt-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <p class="text-gray-900">{{ $admin->full_address }}</p>
                    </div>
                    @endif
                </div>

                @if($admin->id !== auth()->id())
                <!-- Admin Actions -->
                <div class="bg-white rounded-lg border border-gray-200 p-6 mt-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-6">Admin Actions</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Toggle Status -->
                        <form action="{{ route('admin.super-admin.toggle-status', $admin) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" 
                                    class="w-full {{ $admin->status === 'active' ? 'bg-yellow-600 hover:bg-yellow-700' : 'bg-green-600 hover:bg-green-700' }} text-white px-4 py-3 rounded-lg font-medium shadow-lg"
                                    onclick="return confirm('Are you sure you want to {{ $admin->status === 'active' ? 'deactivate' : 'activate' }} this admin?')">
                                {{ $admin->status === 'active' ? '⏸️ Deactivate Admin' : '▶️ Activate Admin' }}
                            </button>
                        </form>

                        <!-- Reset Password -->
                        <button onclick="showResetPasswordModal()" 
                                class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-3 rounded-lg font-medium shadow-lg">
                            🔑 Reset Password
                        </button>
                    </div>

                    <!-- Delete Admin -->
                    <div class="mt-4">
                        <form action="{{ route('admin.super-admin.destroy', $admin) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-3 rounded-lg font-medium shadow-lg"
                                    onclick="return confirm('Are you sure you want to delete this admin? This action cannot be undone.')">
                                🗑️ Delete Admin
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>

            <!-- Profile Picture & Account Info -->
            <div class="space-y-6">
                <!-- Avatar -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Profile Picture</h3>
                    
                    <div class="text-center">
                        <img src="{{ $admin->avatar_url }}" alt="{{ $admin->name }}" 
                             class="w-32 h-32 rounded-full mx-auto object-cover border-4 border-gray-200">
                    </div>
                </div>

                <!-- Account Info -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Account Information</h3>
                    
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Role:</span>
                            <span class="font-medium">
                                @if($admin->role === 'super_admin')
                                    <span class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm font-medium">Super Admin</span>
                                @elseif($admin->role === 'admin')
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">Admin</span>
                                @elseif($admin->role === 'manager')
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">Manager</span>
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Status:</span>
                            <span class="font-medium">
                                @if($admin->status === 'active')
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-medium">Active</span>
                                @elseif($admin->status === 'inactive')
                                    <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm font-medium">Inactive</span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-medium">Suspended</span>
                                @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Member Since:</span>
                            <span class="font-medium">{{ $admin->created_at->format('M d, Y') }}</span>
                        </div>
                        
                        @if($admin->last_login_at)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Last Login:</span>
                            <span class="font-medium">{{ $admin->last_login_at->diffForHumans() }}</span>
                        </div>
                        @endif

                        @if($admin->email_verified_at)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Email Verified:</span>
                            <span class="font-medium text-green-600">✅ Verified</span>
                        </div>
                        @else
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Email Verified:</span>
                            <span class="font-medium text-red-600">❌ Not Verified</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($admin->id !== auth()->id())
    <!-- Reset Password Modal -->
    <div id="resetPasswordModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
                <form action="{{ route('admin.super-admin.reset-password', $admin) }}" method="POST">
                    @csrf
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Reset Password for {{ $admin->name }}</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-2">New Password</label>
                                <input type="password" id="password" name="password" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                            
                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3 rounded-b-lg">
                        <button type="button" onclick="hideResetPasswordModal()" 
                                class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-lg">
                            Reset Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

<script>
function showResetPasswordModal() {
    document.getElementById('resetPasswordModal').classList.remove('hidden');
}

function hideResetPasswordModal() {
    document.getElementById('resetPasswordModal').classList.add('hidden');
}
</script>

</x-layouts.admin>
