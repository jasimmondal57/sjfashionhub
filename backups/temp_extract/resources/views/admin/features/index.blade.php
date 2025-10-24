<x-layouts.admin>
    <x-slot name="title">Features Management - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">Manage homepage features and highlights</x-slot>
    <x-slot name="pageTitle">⭐ Features Management</x-slot>

    <!-- Header Actions -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600">Create and manage feature highlights for your homepage</p>
        </div>
        <a href="{{ route('admin.features.create') }}" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add New Feature
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-black rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Total Features</p>
                    <p class="text-lg font-bold text-black">{{ $features->total() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Active</p>
                    <p class="text-lg font-bold text-black">{{ $features->where('is_active', true)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-gray-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Inactive</p>
                    <p class="text-lg font-bold text-black">{{ $features->where('is_active', false)->count() }}</p>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center">
                <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-600">With Icons</p>
                    <p class="text-lg font-bold text-black">{{ $features->whereNotNull('icon_svg')->count() + $features->whereNotNull('icon_image')->count() + $features->whereNotNull('icon_class')->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Table -->
    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-black">All Features</h3>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Feature</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($features as $feature)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-12 h-12 rounded-full flex items-center justify-center mr-3" style="background-color: {{ $feature->background_color }}">
                                        @if($feature->icon_type === 'svg' && $feature->icon_svg)
                                            <div class="w-6 h-6" style="color: {{ $feature->icon_color }}">
                                                {!! $feature->icon_svg !!}
                                            </div>
                                        @elseif($feature->icon_type === 'image' && $feature->icon_image)
                                            <img src="{{ Storage::url($feature->icon_image) }}" alt="{{ $feature->title }}" class="w-6 h-6">
                                        @elseif($feature->icon_type === 'icon_class' && $feature->icon_class)
                                            <i class="{{ $feature->icon_class }}" style="color: {{ $feature->icon_color }}"></i>
                                        @else
                                            <svg class="w-6 h-6" style="color: {{ $feature->icon_color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="text-sm font-medium text-black">{{ $feature->title }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($feature->description, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($feature->icon_type === 'svg') bg-blue-100 text-blue-800
                                    @elseif($feature->icon_type === 'image') bg-green-100 text-green-800
                                    @elseif($feature->icon_type === 'icon_class') bg-purple-100 text-purple-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst(str_replace('_', ' ', $feature->icon_type)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($feature->is_active)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        Inactive
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $feature->sort_order }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $feature->created_at->format('M j, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.features.show', $feature) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    <a href="{{ route('admin.features.edit', $feature) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    <form action="{{ route('admin.features.toggle', $feature) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-yellow-600 hover:text-yellow-900">
                                            {{ $feature->is_active ? 'Disable' : 'Enable' }}
                                        </button>
                                    </form>
                                    <button onclick="deleteFeature({{ $feature->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center">
                                <div class="text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">No features</h3>
                                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first feature.</p>
                                    <div class="mt-6">
                                        <a href="{{ route('admin.features.create') }}" class="btn btn-primary">
                                            Add New Feature
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($features->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $features->links() }}
            </div>
        @endif
    </div>

    <script>
        function deleteFeature(featureId) {
            if (confirm('Are you sure you want to delete this feature? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/features/${featureId}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-layouts.admin>
