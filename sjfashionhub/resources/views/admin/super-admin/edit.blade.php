<x-layouts.admin>
    <x-slot name="title">Edit Admin - {{ $admin->name }}</x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">✏️ Edit Admin</h1>
                <p class="text-gray-600 mt-1">Update administrator information and settings</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.super-admin.show', $admin) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg flex items-center font-medium shadow-lg">
                    ← Back to Details
                </a>
            </div>
        </div>

        <!-- Error Messages -->
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Edit Form -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <form action="{{ route('admin.super-admin.update', $admin) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Basic Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Basic Information</h3>
                        
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone', $admin->phone) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 mb-2">Date of Birth</label>
                            <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $admin->date_of_birth?->format('Y-m-d')) }}" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                            <select id="gender" name="gender" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $admin->gender) === 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $admin->gender) === 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $admin->gender) === 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="avatar" class="block text-sm font-medium text-gray-700 mb-2">Profile Picture</label>
                            <input type="file" id="avatar" name="avatar" accept="image/*" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            <p class="text-sm text-gray-500 mt-1">Leave empty to keep current picture. Max size: 2MB</p>
                            @if($admin->avatar)
                                <div class="mt-2">
                                    <img src="{{ $admin->avatar_url }}" alt="Current avatar" class="w-16 h-16 rounded-full object-cover">
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Account Settings & Address -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Account Settings</h3>
                        
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
                            <select id="role" name="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="">Select Role</option>
                                <option value="super_admin" {{ old('role', $admin->role) === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                <option value="admin" {{ old('role', $admin->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="manager" {{ old('role', $admin->role) === 'manager' ? 'selected' : '' }}>Manager</option>
                            </select>
                            <div class="mt-2 text-sm text-gray-600">
                                <p><strong>Super Admin:</strong> Full system access, can manage other admins</p>
                                <p><strong>Admin:</strong> Full access to manage content and orders</p>
                                <p><strong>Manager:</strong> Limited access to specific sections</p>
                            </div>
                        </div>
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                            <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500" required>
                                <option value="active" {{ old('status', $admin->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $admin->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ old('status', $admin->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>
                        
                        <h3 class="text-lg font-medium text-gray-900 mt-8">Address Information</h3>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Street Address</label>
                            <textarea id="address" name="address" rows="3" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('address', $admin->address) }}</textarea>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700 mb-2">City</label>
                                <input type="text" id="city" name="city" value="{{ old('city', $admin->city) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="state" class="block text-sm font-medium text-gray-700 mb-2">State</label>
                                <input type="text" id="state" name="state" value="{{ old('state', $admin->state) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="postal_code" class="block text-sm font-medium text-gray-700 mb-2">Postal Code</label>
                                <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $admin->postal_code) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            
                            <div>
                                <label for="country" class="block text-sm font-medium text-gray-700 mb-2">Country</label>
                                <input type="text" id="country" name="country" value="{{ old('country', $admin->country) }}" 
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                            </div>
                        </div>
                        
                        <div>
                            <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                            <textarea id="notes" name="notes" rows="3" 
                                      placeholder="Internal notes about this administrator..."
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">{{ old('notes', $admin->notes) }}</textarea>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Buttons -->
                <div class="mt-8 flex justify-end space-x-4">
                    <a href="{{ route('admin.super-admin.show', $admin) }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-3 rounded-lg font-medium">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium shadow-lg">
                        💾 Update Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
