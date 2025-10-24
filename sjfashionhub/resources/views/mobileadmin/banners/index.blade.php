<x-layouts.mobileadmin>
    <div class="p-6">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">🎨 App Banners</h1>
                <p class="text-gray-600 mt-1">Manage promotional banners for the mobile app</p>
            </div>
            <a href="{{ route('mobileadmin.banners.create') }}" 
               class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-6 py-3 rounded-lg font-medium transition-all shadow-lg">
                <i class="fas fa-plus mr-2"></i>Add Banner
            </a>
        </div>

        <!-- Banners Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($banners as $banner)
                <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                    <!-- Banner Image -->
                    <div class="relative h-48 bg-gray-200">
                        @if($banner->image)
                            <img src="{{ Storage::url($banner->image) }}"
                                 alt="{{ $banner->title }}"
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <i class="fas fa-image text-4xl"></i>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="absolute top-3 right-3">
                            @if($banner->is_active)
                                <span class="px-3 py-1 bg-green-500 text-white text-xs font-semibold rounded-full">
                                    Active
                                </span>
                            @else
                                <span class="px-3 py-1 bg-gray-500 text-white text-xs font-semibold rounded-full">
                                    Inactive
                                </span>
                            @endif
                        </div>

                        <!-- Order Badge -->
                        <div class="absolute top-3 left-3">
                            <span class="px-3 py-1 bg-purple-600 text-white text-xs font-semibold rounded-full">
                                #{{ $banner->order }}
                            </span>
                        </div>
                    </div>

                    <!-- Banner Details -->
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-900 mb-1">{{ $banner->title }}</h3>
                        @if($banner->description)
                            <p class="text-sm text-gray-600 mb-3">{{ Str::limit($banner->description, 60) }}</p>
                        @endif

                        <!-- Link Info -->
                        @if($banner->link_type !== 'none')
                            <div class="mb-3 text-xs text-gray-500">
                                <i class="fas fa-link mr-1"></i>
                                <span class="font-medium">{{ ucfirst($banner->link_type) }}:</span>
                                {{ Str::limit($banner->link_value, 30) }}
                            </div>
                        @endif

                        <!-- Actions -->
                        <div class="flex gap-2">
                            <a href="{{ route('mobileadmin.banners.edit', $banner) }}" 
                               class="flex-1 bg-indigo-50 hover:bg-indigo-100 text-indigo-600 px-4 py-2 rounded-lg text-sm font-medium text-center transition-colors">
                                <i class="fas fa-edit mr-1"></i>Edit
                            </a>
                            <form action="{{ route('mobileadmin.banners.delete', $banner) }}" 
                                  method="POST" 
                                  class="flex-1"
                                  onsubmit="return confirm('Are you sure you want to delete this banner?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                    <i class="fas fa-trash mr-1"></i>Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="bg-white rounded-xl shadow-sm p-12 text-center">
                        <div class="text-gray-400">
                            <i class="fas fa-images text-5xl mb-4"></i>
                            <p class="text-lg font-medium">No banners found</p>
                            <p class="text-sm mt-2">Create your first banner to get started</p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.mobileadmin>

