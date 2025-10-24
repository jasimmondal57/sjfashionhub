<x-layouts.mobileadmin>
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">🧭 Navigation Menu</h1>
                <p class="text-gray-600 mt-1">Manage bottom navigation menu items</p>
            </div>
            <a href="{{ route('mobileadmin.menu.create') }}" 
               class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-medium transition-all shadow-lg">
                <i class="fas fa-plus mr-2"></i>Add Menu Item
            </a>
        </div>

        <!-- Menu Items Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @forelse($menuItems as $item)
                <div class="bg-white rounded-xl shadow-sm p-6 text-center">
                    <!-- Icon -->
                    <div class="mb-4">
                        <div class="w-16 h-16 mx-auto bg-gradient-to-br from-purple-100 to-indigo-100 rounded-full flex items-center justify-center">
                            <i class="{{ $item->icon }} text-2xl text-purple-600"></i>
                        </div>
                    </div>

                    <!-- Title -->
                    <h3 class="font-semibold text-gray-900 mb-1">{{ $item->title }}</h3>
                    
                    <!-- Type Badge -->
                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 mb-3">
                        {{ ucfirst(str_replace('_', ' ', $item->type)) }}
                    </span>

                    <!-- Order -->
                    <div class="text-sm text-gray-500 mb-4">
                        Order: {{ $item->order }}
                    </div>

                    <!-- Status -->
                    <div class="mb-4">
                        @if($item->is_active)
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                Active
                            </span>
                        @else
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Inactive
                            </span>
                        @endif
                    </div>

                    <!-- Actions -->
                    <div class="flex gap-2">
                        <a href="{{ route('mobileadmin.menu.edit', $item) }}" 
                           class="flex-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('mobileadmin.menu.delete', $item) }}" 
                              method="POST" 
                              class="flex-1"
                              onsubmit="return confirm('Are you sure you want to delete this menu item?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                        <div class="text-gray-400">
                            <i class="fas fa-bars text-5xl mb-4"></i>
                            <p class="text-lg font-medium">No menu items found</p>
                            <p class="text-sm mt-2">Create your first menu item to get started</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.mobileadmin>

