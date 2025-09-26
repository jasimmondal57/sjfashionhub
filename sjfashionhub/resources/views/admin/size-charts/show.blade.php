<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $sizeChart->name }}</h1>
                        <p class="text-gray-600 mt-1">Size Chart Details</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.size-charts.edit', $sizeChart) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-edit mr-2"></i>Edit
                        </a>
                        <a href="{{ route('admin.size-charts.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Size Charts
                        </a>
                    </div>
                </div>
            </div>

            <!-- Basic Information -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <p class="text-gray-900">{{ $sizeChart->name }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                        <p class="text-gray-900 font-mono text-sm">{{ $sizeChart->slug }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        @if($sizeChart->is_active)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check-circle mr-1"></i>Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <i class="fas fa-times-circle mr-1"></i>Inactive
                            </span>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Sort Order</label>
                        <p class="text-gray-900">{{ $sizeChart->sort_order }}</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Products Using This Chart</label>
                        <p class="text-gray-900">{{ $sizeChart->products()->count() }} products</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Created</label>
                        <p class="text-gray-900">{{ $sizeChart->created_at->format('M d, Y \a\t g:i A') }}</p>
                    </div>
                    
                    @if($sizeChart->description)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <p class="text-gray-900">{{ $sizeChart->description }}</p>
                        </div>
                    @endif
                    
                    @if($sizeChart->image_url)
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Size Chart Image</label>
                            <div class="max-w-md">
                                <img src="{{ $sizeChart->image_url }}" alt="Size Chart for {{ $sizeChart->name }}" 
                                     class="w-full h-auto rounded-lg border border-gray-300 shadow-sm">
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Size Chart Table -->
            @if(isset($sizeChart->size_data['headers']) && isset($sizeChart->size_data['rows']))
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Size Chart</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    @foreach($sizeChart->size_data['headers'] as $header)
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            {{ $header }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($sizeChart->size_data['rows'] as $row)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $row['size'] ?? '' }}
                                        </td>
                                        @if(isset($row['measurements']))
                                            @foreach($row['measurements'] as $measurement)
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $measurement }}
                                                </td>
                                            @endforeach
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                    <div class="text-center py-8">
                        <i class="fas fa-chart-bar text-gray-400 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">No size data available</h3>
                        <p class="text-gray-600 mb-4">This size chart doesn't have any measurement data yet.</p>
                        <a href="{{ route('admin.size-charts.edit', $sizeChart) }}" 
                           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-edit mr-2"></i>Add Size Data
                        </a>
                    </div>
                </div>
            @endif

            <!-- Products Using This Chart -->
            @if($sizeChart->products()->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Products Using This Size Chart</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($sizeChart->products()->take(6)->get() as $product)
                            <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                                <div class="flex items-center space-x-3">
                                    @if($product->images && count($product->images) > 0)
                                        <img src="{{ $product->images[0] }}" alt="{{ $product->name }}" 
                                             class="w-12 h-12 object-cover rounded-lg">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 truncate">{{ $product->name }}</p>
                                        <p class="text-sm text-gray-500">${{ number_format($product->price, 2) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($sizeChart->products()->count() > 6)
                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-600">
                                And {{ $sizeChart->products()->count() - 6 }} more products...
                            </p>
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-layouts.admin>
