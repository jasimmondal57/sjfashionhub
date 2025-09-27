<x-layouts.user title="My Profile" subtitle="Manage your personal information and account settings">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Picture -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Profile Picture</h3>
                
                <div class="text-center">
                    @if($user->avatar)
                        <img class="mx-auto h-32 w-32 rounded-full object-cover" src="{{ Storage::url($user->avatar) }}" alt="{{ $user->name }}">
                    @else
                        <div class="mx-auto h-32 w-32 rounded-full bg-indigo-500 flex items-center justify-center">
                            <span class="text-4xl font-bold text-white">{{ substr($user->name, 0, 1) }}</span>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('user.profile.update') }}" enctype="multipart/form-data" class="mt-4">
                        @csrf
                        @method('PUT')
                        
                        <!-- Hidden fields for other data -->
                        <input type="hidden" name="name" value="{{ $user->name }}">
                        <input type="hidden" name="email" value="{{ $user->email }}">
                        <input type="hidden" name="phone" value="{{ $user->phone }}">
                        
                        <div class="mt-4">
                            <label for="avatar" class="block text-sm font-medium text-gray-700">
                                Choose new picture
                            </label>
                            <input type="file" name="avatar" id="avatar" accept="image/*" 
                                   class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                            @error('avatar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button type="submit" class="mt-4 w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Update Picture
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Profile Information -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Personal Information</h3>
                
                <form method="POST" action="{{ route('user.profile.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('email')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @if($user->email_verified_at)
                                <p class="mt-1 text-sm text-green-600">✓ Email verified</p>
                            @else
                                <p class="mt-1 text-sm text-red-600">✗ Email not verified</p>
                            @endif
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                            <input type="tel" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                                   placeholder="+1234567890">
                            @error('phone')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            @if($user->phone_verified_at)
                                <p class="mt-1 text-sm text-green-600">✓ Phone verified</p>
                            @else
                                <p class="mt-1 text-sm text-red-600">✗ Phone not verified</p>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Update Profile
                        </button>
                    </div>
                </form>
            </div>

            <!-- Change Password -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Change Password</h3>
                
                <form method="POST" action="{{ route('user.password.update') }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 gap-6">
                        <!-- Current Password -->
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Current Password</label>
                            <input type="password" name="current_password" id="current_password" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('current_password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- New Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                            <input type="password" name="password" id="password" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Password must be at least 8 characters long</p>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" required
                                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="bg-red-600 text-white py-2 px-4 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Change Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account Information -->
            <div class="bg-white rounded-lg shadow p-6 mt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-6">Account Information</h3>
                
                <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Member Since</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->created_at->format('F j, Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $user->updated_at->format('F j, Y g:i A') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Login Method</dt>
                        <dd class="mt-1 text-sm text-gray-900">
                            @if($user->login_type === 'google')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Google
                                </span>
                            @elseif($user->login_type === 'facebook')
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Facebook
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    Email
                                </span>
                            @endif
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Account Status</dt>
                        <dd class="mt-1 text-sm">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                Active
                            </span>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-layouts.user>
