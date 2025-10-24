<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Edit Size Chart</h1>
                        <p class="text-gray-600 mt-1">Update size chart: {{ $sizeChart->name }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.size-charts.show', $sizeChart) }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-eye mr-2"></i>View
                        </a>
                        <a href="{{ route('admin.size-charts.index') }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-arrow-left mr-2"></i>Back to Size Charts
                        </a>
                    </div>
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.size-charts.update', $sizeChart) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <!-- Basic Information -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                Size Chart Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" id="name" value="{{ old('name', $sizeChart->name) }}" required
                                   placeholder="e.g., Blouse, Kurti, Top, Dress"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Sort Order -->
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                                Sort Order
                            </label>
                            <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $sizeChart->sort_order) }}" min="0"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Lower numbers appear first</p>
                            @error('sort_order')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                Description
                            </label>
                            <textarea name="description" id="description" rows="3"
                                      placeholder="Optional description for this size chart"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $sizeChart->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Image URL -->
                        <div class="md:col-span-2">
                            <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">
                                Size Chart Image URL (Optional)
                            </label>
                            <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $sizeChart->image_url) }}"
                                   placeholder="https://example.com/size-chart-image.jpg"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Optional image to display with the size chart</p>
                            @error('image_url')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Status -->
                        <div class="md:col-span-2">
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" 
                                       {{ old('is_active', $sizeChart->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                <label for="is_active" class="ml-2 text-sm text-gray-700">
                                    Active (size chart will be available for products)
                                </label>
                            </div>
                            @error('is_active')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Size Chart Data -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Size Chart Data</h3>
                    
                    <!-- Headers -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Measurement Headers <span class="text-red-500">*</span>
                        </label>
                        <div id="headers-container">
                            <div class="flex gap-2 mb-2">
                                @if(isset($sizeChart->size_data['headers']))
                                    @foreach($sizeChart->size_data['headers'] as $header)
                                        <input type="text" name="size_data[headers][]" value="{{ $header }}" required
                                               placeholder="e.g., Size"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    @endforeach
                                @else
                                    <input type="text" name="size_data[headers][]" value="Size" required
                                           placeholder="e.g., Size"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <input type="text" name="size_data[headers][]" value="Bust (inches)" required
                                           placeholder="e.g., Bust (inches)"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <input type="text" name="size_data[headers][]" value="Waist (inches)" required
                                           placeholder="e.g., Waist (inches)"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @endif
                                <button type="button" onclick="addHeader()" class="px-3 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <p class="text-xs text-gray-500">First column should be "Size", followed by measurement columns</p>
                    </div>

                    <!-- Size Rows -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Size Data <span class="text-red-500">*</span>
                        </label>
                        <div id="rows-container">
                            @if(isset($sizeChart->size_data['rows']))
                                @foreach($sizeChart->size_data['rows'] as $index => $row)
                                    <div class="flex gap-2 mb-2 size-row">
                                        <input type="text" name="size_data[rows][{{ $index }}][size]" value="{{ $row['size'] ?? '' }}" required
                                               placeholder="e.g., S, M, L"
                                               class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        @if(isset($row['measurements']))
                                            @foreach($row['measurements'] as $measurement)
                                                <input type="text" name="size_data[rows][{{ $index }}][measurements][]" value="{{ $measurement }}" required
                                                       placeholder="e.g., 32-34"
                                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            @endforeach
                                        @endif
                                        <button type="button" onclick="removeSizeRow(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" onclick="addSizeRow()" class="mt-2 px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                            <i class="fas fa-plus mr-2"></i>Add Size Row
                        </button>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex items-center justify-end space-x-4 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <a href="{{ route('admin.size-charts.index') }}" 
                       class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Update Size Chart
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        let headerCount = {{ isset($sizeChart->size_data['headers']) ? count($sizeChart->size_data['headers']) : 3 }};
        let rowCount = {{ isset($sizeChart->size_data['rows']) ? count($sizeChart->size_data['rows']) : 0 }};

        function addHeader() {
            const container = document.getElementById('headers-container');
            const lastRow = container.lastElementChild;
            
            const input = document.createElement('input');
            input.type = 'text';
            input.name = 'size_data[headers][]';
            input.placeholder = 'e.g., Hip (inches)';
            input.required = true;
            input.className = 'flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500';
            
            const addButton = lastRow.lastElementChild;
            lastRow.insertBefore(input, addButton);
            
            headerCount++;
        }

        function addSizeRow() {
            const container = document.getElementById('rows-container');
            const div = document.createElement('div');
            div.className = 'flex gap-2 mb-2 size-row';
            
            let inputs = '';
            for (let i = 0; i < headerCount; i++) {
                if (i === 0) {
                    inputs += `<input type="text" name="size_data[rows][${rowCount}][size]" placeholder="e.g., S, M, L" required class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">`;
                } else {
                    inputs += `<input type="text" name="size_data[rows][${rowCount}][measurements][]" placeholder="e.g., 32-34" required class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">`;
                }
            }
            
            div.innerHTML = inputs + `
                <button type="button" onclick="removeSizeRow(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                    <i class="fas fa-trash"></i>
                </button>
            `;
            
            container.appendChild(div);
            rowCount++;
        }

        function removeSizeRow(button) {
            button.closest('.size-row').remove();
        }
    </script>
    @endpush
</x-layouts.admin>
