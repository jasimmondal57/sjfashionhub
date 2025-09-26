<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $variant->name }} Variants</h1>
                        <p class="text-gray-600 mt-1">Manage options for {{ $variant->name }} variant type</p>
                    </div>
                    <div class="flex space-x-3">
                        <a href="{{ route('admin.variants.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Variants
                        </a>
                        <a href="{{ route('admin.variants.edit', $variant) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-edit mr-2"></i>Edit Type
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Variant Type Info -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Variant Type Details</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Name</label>
                                <p class="text-gray-900">{{ $variant->name }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Slug</label>
                                <p class="text-gray-900 font-mono text-sm">{{ $variant->slug }}</p>
                            </div>
                            
                            @if($variant->description)
                                <div>
                                    <label class="text-sm font-medium text-gray-500">Description</label>
                                    <p class="text-gray-900">{{ $variant->description }}</p>
                                </div>
                            @endif
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Status</label>
                                <div class="mt-1">
                                    @if($variant->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>Active
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <i class="fas fa-times-circle mr-1"></i>Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Sort Order</label>
                                <p class="text-gray-900">{{ $variant->sort_order }}</p>
                            </div>
                            
                            <div>
                                <label class="text-sm font-medium text-gray-500">Total Options</label>
                                <p class="text-gray-900">{{ $variant->options->count() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Add New Option Form -->
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mt-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Add New Option</h3>
                        
                        <form action="{{ route('admin.variants.options.store', $variant) }}" method="POST">
                            @csrf
                            
                            <div class="space-y-4">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                        Option Name <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="name" id="name" required
                                           placeholder="e.g., Extra Large, Navy Blue"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div>
                                    <label for="value" class="block text-sm font-medium text-gray-700 mb-1">
                                        Option Value <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="value" id="value" required
                                           placeholder="e.g., XL, Navy Blue"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                @if($variant->slug === 'color')
                                    <div>
                                        <label for="color_code" class="block text-sm font-medium text-gray-700 mb-1">
                                            Color Code
                                        </label>
                                        <input type="color" name="color_code" id="color_code"
                                               class="w-full h-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    </div>
                                @endif
                                
                                <div>
                                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-1">
                                        Sort Order
                                    </label>
                                    <input type="number" name="sort_order" id="sort_order" value="0" min="0"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                </div>
                                
                                <div class="flex items-center">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" checked
                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <label for="is_active" class="ml-2 text-sm text-gray-700">Active</label>
                                </div>
                            </div>
                            
                            <button type="submit" 
                                    class="w-full mt-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                <i class="fas fa-plus mr-2"></i>Add Option
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Options List -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Options ({{ $variant->options->count() }})
                            </h3>
                        </div>
                        
                        @if($variant->options->count() > 0)
                            <div class="divide-y divide-gray-200">
                                @foreach($variant->options as $option)
                                    <div class="p-6 flex items-center justify-between">
                                        <div class="flex items-center space-x-4">
                                            @if($option->color_code)
                                                <div class="w-8 h-8 rounded-full border-2 border-gray-300" 
                                                     style="background-color: {{ $option->color_code }}"></div>
                                            @endif
                                            
                                            <div>
                                                <h4 class="text-sm font-medium text-gray-900">{{ $option->name }}</h4>
                                                <p class="text-sm text-gray-500">Value: {{ $option->value }}</p>
                                                @if($option->description)
                                                    <p class="text-xs text-gray-400 mt-1">{{ $option->description }}</p>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center space-x-4">
                                            <span class="text-xs text-gray-500">Sort: {{ $option->sort_order }}</span>
                                            
                                            @if($option->is_active)
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Active
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Inactive
                                                </span>
                                            @endif
                                            
                                            <div class="flex space-x-2">
                                                <button onclick="editOption({{ $option->id }})" 
                                                        class="text-blue-600 hover:text-blue-700 text-sm">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                
                                                <form action="{{ route('admin.variants.options.destroy', [$variant, $option]) }}" 
                                                      method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" 
                                                            onclick="return confirm('Are you sure you want to delete this option?')"
                                                            class="text-red-600 hover:text-red-700 text-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="p-12 text-center">
                                <i class="fas fa-list text-gray-400 text-4xl mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-900 mb-2">No options yet</h3>
                                <p class="text-gray-600 mb-6">Add your first option using the form on the left.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
