<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Product Variants</h1>
                        <p class="text-gray-600 mt-1">Manage sizes, colors, materials and other product variants</p>
                    </div>
                    <a href="{{ route('admin.variants.create') }}" 
                       class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Variant Type
                    </a>
                </div>
            </div>

            <!-- Variant Types Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($variantTypes as $variantType)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                        <!-- Header -->
                        <div class="p-6 border-b border-gray-100">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $variantType->name }}</h3>
                                    @if($variantType->description)
                                        <p class="text-sm text-gray-600 mt-1">{{ $variantType->description }}</p>
                                    @endif
                                </div>
                                <div class="flex items-center space-x-2">
                                    @if($variantType->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Options Preview -->
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-3">
                                <span class="text-sm font-medium text-gray-700">Options ({{ $variantType->options->count() }})</span>
                                <a href="{{ route('admin.variants.show', $variantType) }}" 
                                   class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                    View All
                                </a>
                            </div>
                            
                            @if($variantType->options->count() > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($variantType->options->take(6) as $option)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                            @if($option->color_code)
                                                <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $option->color_code }}"></span>
                                            @endif
                                            {{ $option->value }}
                                        </span>
                                    @endforeach
                                    @if($variantType->options->count() > 6)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-blue-100 text-blue-800">
                                            +{{ $variantType->options->count() - 6 }} more
                                        </span>
                                    @endif
                                </div>
                            @else
                                <p class="text-sm text-gray-500 italic">No options added yet</p>
                            @endif
                        </div>

                        <!-- Actions -->
                        <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">Sort: {{ $variantType->sort_order }}</span>
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.variants.show', $variantType) }}" 
                                       class="text-blue-600 hover:text-blue-700 text-sm font-medium">
                                        <i class="fas fa-eye mr-1"></i>View
                                    </a>
                                    <a href="{{ route('admin.variants.edit', $variantType) }}" 
                                       class="text-green-600 hover:text-green-700 text-sm font-medium">
                                        <i class="fas fa-edit mr-1"></i>Edit
                                    </a>
                                    <form action="{{ route('admin.variants.destroy', $variantType) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Are you sure? This will delete all options too.')"
                                                class="text-red-600 hover:text-red-700 text-sm font-medium">
                                            <i class="fas fa-trash mr-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <i class="fas fa-tags text-gray-400 text-4xl mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No variant types found</h3>
                            <p class="text-gray-600 mb-6">Get started by creating your first variant type like Size, Color, or Material.</p>
                            <a href="{{ route('admin.variants.create') }}" 
                               class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium transition-colors">
                                <i class="fas fa-plus mr-2"></i>Create Variant Type
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Quick Stats -->
            @if($variantTypes->count() > 0)
                <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Stats</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $variantTypes->count() }}</div>
                            <div class="text-sm text-gray-600">Variant Types</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $variantTypes->where('is_active', true)->count() }}</div>
                            <div class="text-sm text-gray-600">Active Types</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-purple-600">{{ $variantTypes->sum(function($type) { return $type->options->count(); }) }}</div>
                            <div class="text-sm text-gray-600">Total Options</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-orange-600">{{ $variantTypes->sum(function($type) { return $type->options->where('is_active', true)->count(); }) }}</div>
                            <div class="text-sm text-gray-600">Active Options</div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
