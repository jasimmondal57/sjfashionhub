<x-layouts.admin>
    <x-slot name="title">Admin Management</x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">👥 Admin Management</h1>
                <p class="text-gray-600 mt-1">Manage administrators and their permissions</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.super-admin.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg flex items-center font-medium shadow-lg">
                    ➕ Add New Admin
                </a>
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

        <!-- Filters -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
            <form method="GET" action="{{ route('admin.super-admin.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}" 
                           placeholder="Name, email, phone..." 
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                </div>
                
                <div>
                    <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                    <select id="role" name="role" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Roles</option>
                        <option value="super_admin" {{ request('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                        <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="manager" {{ request('role') === 'manager' ? 'selected' : '' }}>Manager</option>
                    </select>
                </div>
                
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="suspended" {{ request('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                    </select>
                </div>
                
                <div class="flex items-end space-x-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        🔍 Filter
                    </button>
                    <a href="{{ route('admin.super-admin.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                        🔄 Reset
                    </a>
                </div>
            </form>
        </div>

        <!-- Admin List -->
        <div class="bg-white rounded-lg border border-gray-200">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Administrators ({{ $admins->total() }})</h3>
            </div>
            
            @if($admins->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($admins as $admin)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <img src="{{ $admin->avatar_url }}" alt="{{ $admin->name }}" 
                                             class="w-10 h-10 rounded-full object-cover mr-4">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ $admin->name }}
                                                @if($admin->id === auth()->id())
                                                    <span class="text-blue-600 text-xs">(You)</span>
                                                @endif
                                            </div>
                                            <div class="text-sm text-gray-500">{{ $admin->email }}</div>
                                            @if($admin->phone)
                                                <div class="text-sm text-gray-500">{{ $admin->phone }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($admin->role === 'super_admin')
                                        <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-sm font-medium">Super Admin</span>
                                    @elseif($admin->role === 'admin')
                                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-sm font-medium">Admin</span>
                                    @elseif($admin->role === 'manager')
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm font-medium">Manager</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($admin->status === 'active')
                                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm font-medium">Active</span>
                                    @elseif($admin->status === 'inactive')
                                        <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm font-medium">Inactive</span>
                                    @else
                                        <span class="bg-red-100 text-red-800 px-2 py-1 rounded text-sm font-medium">Suspended</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $admin->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('admin.super-admin.show', $admin) }}" 
                                           class="text-blue-600 hover:text-blue-900">View</a>
                                        
                                        @if($admin->id !== auth()->id())
                                            <a href="{{ route('admin.super-admin.edit', $admin) }}" 
                                               class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                            
                                            <form action="{{ route('admin.super-admin.toggle-status', $admin) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="{{ $admin->status === 'active' ? 'text-yellow-600 hover:text-yellow-900' : 'text-green-600 hover:text-green-900' }}">
                                                    {{ $admin->status === 'active' ? 'Deactivate' : 'Activate' }}
                                                </button>
                                            </form>
                                            
                                            <form action="{{ route('admin.super-admin.destroy', $admin) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900"
                                                        onclick="return confirm('Are you sure you want to delete this admin? This action cannot be undone.')">
                                                    Delete
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $admins->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No administrators found</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new administrator.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.super-admin.create') }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                            Add New Admin
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
