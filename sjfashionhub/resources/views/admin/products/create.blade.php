<x-layouts.admin>
    <x-slot name="title">Add New Product - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">Create a new product</x-slot>
    <x-slot name="pageTitle">➕ Add New Product</x-slot>

    <!-- Header Actions -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600">Create a new product for your catalog</p>
        </div>
        <div class="flex space-x-3">
            <button type="button" onclick="openAIModal()" class="btn bg-gradient-to-r from-purple-500 to-blue-600 text-white hover:from-purple-600 hover:to-blue-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
                🤖 AI Details
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Products
            </a>
        </div>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Basic Information -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">Basic Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Use format: Brand + Product Type + Key Feature + Color/Size (max 70 chars)</p>
                            @error('name')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Brand *</label>
                            <input type="text" name="brand" id="brand" value="{{ old('brand') }}" required
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Required for Google Merchant Center</p>
                            @error('brand')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Short Description *</label>
                            <textarea name="description" id="description" rows="3" required
                                      class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="long_description" class="block text-sm font-medium text-gray-700 mb-2">Detailed Description</label>
                            <textarea name="long_description" id="long_description" rows="6"
                                      class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('long_description') }}</textarea>
                            @error('long_description')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Pricing & Inventory -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">Pricing & Inventory</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Regular Price (₹) *</label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0" required
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('price')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-2">Sale Price (₹)</label>
                            <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price') }}" step="0.01" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('sale_price')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                            <input type="text" name="sku" id="sku" value="{{ old('sku') }}"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('sku')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="compare_at_price" class="block text-sm font-medium text-gray-700 mb-2">Compare At Price (₹)</label>
                            <input type="number" name="compare_at_price" id="compare_at_price" value="{{ old('compare_at_price') }}" step="0.01" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('compare_at_price')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cost_price" class="block text-sm font-medium text-gray-700 mb-2">Cost Price (₹)</label>
                            <input type="number" name="cost_price" id="cost_price" value="{{ old('cost_price') }}" step="0.01" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('cost_price')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', 0) }}" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('stock_quantity')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="low_stock_threshold" class="block text-sm font-medium text-gray-700 mb-2">Low Stock Threshold</label>
                            <input type="number" name="low_stock_threshold" id="low_stock_threshold" value="{{ old('low_stock_threshold', 5) }}" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('low_stock_threshold')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 space-y-3">
                        <label class="flex items-center">
                            <input type="checkbox" name="manage_stock" value="1" {{ old('manage_stock') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Track stock quantity for this product</span>
                        </label>

                        <label class="flex items-center">
                            <input type="checkbox" name="track_quantity" value="1" {{ old('track_quantity', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Enable quantity tracking</span>
                        </label>

                        <label class="flex items-center">
                            <input type="checkbox" name="price_includes_tax" value="1" {{ old('price_includes_tax', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Price includes tax</span>
                        </label>
                    </div>

                    <div class="mt-4">
                        <label for="tax_rate" class="block text-sm font-medium text-gray-700 mb-2">Tax Rate (%)</label>
                        <input type="number" name="tax_rate" id="tax_rate" value="{{ old('tax_rate', 18) }}" step="0.01" min="0" max="100"
                               class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        @error('tax_rate')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Additional Inventory Fields -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-md font-semibold text-gray-900 mb-4">📦 Advanced Inventory</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="barcode" class="block text-sm font-medium text-gray-700 mb-2">Barcode</label>
                                <input type="text" name="barcode" id="barcode" value="{{ old('barcode') }}"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Enter barcode number">
                            </div>

                            <div>
                                <label for="supplier_name" class="block text-sm font-medium text-gray-700 mb-2">Supplier Name</label>
                                <input type="text" name="supplier_name" id="supplier_name" value="{{ old('supplier_name') }}"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Supplier or vendor name">
                            </div>

                            <div>
                                <label for="reorder_point" class="block text-sm font-medium text-gray-700 mb-2">Reorder Point</label>
                                <input type="number" name="reorder_point" id="reorder_point" value="{{ old('reorder_point', 0) }}" min="0"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="When to restock">
                                <p class="mt-1 text-xs text-gray-500">Alert when stock reaches this level</p>
                            </div>

                            <div>
                                <label for="reorder_quantity" class="block text-sm font-medium text-gray-700 mb-2">Reorder Quantity</label>
                                <input type="number" name="reorder_quantity" id="reorder_quantity" value="{{ old('reorder_quantity', 0) }}" min="0"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="How much to restock">
                            </div>
                        </div>
                    </div>

                    <!-- Pricing Promotions -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-md font-semibold text-gray-900 mb-4">💰 Pricing & Promotions</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="sale_start_date" class="block text-sm font-medium text-gray-700 mb-2">Sale Start Date</label>
                                <input type="datetime-local" name="sale_start_date" id="sale_start_date" value="{{ old('sale_start_date') }}"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="sale_end_date" class="block text-sm font-medium text-gray-700 mb-2">Sale End Date</label>
                                <input type="datetime-local" name="sale_end_date" id="sale_end_date" value="{{ old('sale_end_date') }}"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="min_order_quantity" class="block text-sm font-medium text-gray-700 mb-2">Min Order Quantity</label>
                                <input type="number" name="min_order_quantity" id="min_order_quantity" value="{{ old('min_order_quantity', 1) }}" min="1"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="max_order_quantity" class="block text-sm font-medium text-gray-700 mb-2">Max Order Quantity</label>
                                <input type="number" name="max_order_quantity" id="max_order_quantity" value="{{ old('max_order_quantity') }}" min="1"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Leave empty for no limit">
                            </div>

                            <div>
                                <label for="member_price" class="block text-sm font-medium text-gray-700 mb-2">Member Price (₹)</label>
                                <input type="number" name="member_price" id="member_price" value="{{ old('member_price') }}" step="0.01" min="0"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="Special price for members">
                            </div>

                            <div>
                                <label for="wholesale_price" class="block text-sm font-medium text-gray-700 mb-2">Wholesale Price (₹)</label>
                                <input type="number" name="wholesale_price" id="wholesale_price" value="{{ old('wholesale_price') }}" step="0.01" min="0"
                                       class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                       placeholder="B2B wholesale price">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Images -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">Product Images</h3>

                    <!-- Upload Method Tabs -->
                    <div class="mb-6">
                        <div class="border-b border-gray-200">
                            <nav class="-mb-px flex space-x-8">
                                <button type="button" onclick="switchImageMethod('upload')" id="upload-tab"
                                        class="image-method-tab active py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                                    📁 Upload Files
                                </button>
                                <button type="button" onclick="switchImageMethod('url')" id="url-tab"
                                        class="image-method-tab py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    🔗 Image URLs
                                </button>
                            </nav>
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div id="upload-section" class="image-method-content">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Product Images (Max 8 images)</label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="flex text-sm text-gray-600">
                                        <label for="image-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                            <span>Upload images</span>
                                            <input id="image-upload" name="uploaded_images[]" type="file" class="sr-only" multiple accept="image/*" onchange="simpleHandleFileUpload(this)">
                                        </label>
                                        <p class="pl-1">or click to browse</p>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 10MB each (Max 8 images)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Preview uploaded images -->
                        <div id="upload-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4" style="display: none;">
                            <!-- Uploaded image previews will appear here -->
                        </div>
                    </div>

                    <!-- URL Input Section -->
                    <div id="url-section" class="image-method-content" style="display: none;">
                        <div id="images-container">
                            <div class="image-input-group mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Image URL</label>
                                <div class="flex gap-2">
                                    <input type="url" name="images[]" placeholder="https://example.com/image.jpg"
                                           class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <button type="button" onclick="removeImageInput(this)" class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Remove</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" onclick="addImageInput()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Another Image URL
                        </button>
                    </div>
                </div>

                <!-- Size Chart -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">📏 Size Chart</h3>

                    <div>
                        <label for="size_chart_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Size Chart (Optional)
                        </label>
                        <select name="size_chart_id" id="size_chart_id"
                                class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <option value="">Select a size chart...</option>
                            @if(isset($sizeCharts))
                                @foreach($sizeCharts as $sizeChart)
                                    <option value="{{ $sizeChart->id }}" {{ old('size_chart_id') == $sizeChart->id ? 'selected' : '' }}>
                                        {{ $sizeChart->name }}
                                        @if($sizeChart->description)
                                            - {{ Str::limit($sizeChart->description, 50) }}
                                        @endif
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>No size charts available</option>
                            @endif
                        </select>
                        <p class="mt-1 text-xs text-gray-500">
                            Select a size chart to help customers choose the right size.
                            <a href="{{ route('admin.size-charts.create') }}" target="_blank" class="text-blue-600 hover:text-blue-700">Create new size chart</a>
                        </p>
                        @error('size_chart_id')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Fashion Attributes -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">👗 Fashion Attributes</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                            <input type="text" name="color" id="color" value="{{ old('color') }}"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="e.g., Black, Red, Blue">
                            <p class="mt-1 text-xs text-gray-500">Primary color of the product</p>
                        </div>

                        <div>
                            <label for="material" class="block text-sm font-medium text-gray-700 mb-2">Material</label>
                            <input type="text" name="material" id="material" value="{{ old('material') }}"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="e.g., Cotton, Polyester, Silk">
                            <p class="mt-1 text-xs text-gray-500">Primary material of the product</p>
                        </div>

                        <div>
                            <label for="fabric_composition" class="block text-sm font-medium text-gray-700 mb-2">Fabric Composition</label>
                            <input type="text" name="fabric_composition" id="fabric_composition" value="{{ old('fabric_composition') }}"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="e.g., 100% Cotton or 65% Polyester, 35% Cotton">
                            <p class="mt-1 text-xs text-gray-500">Specify the fabric materials and percentages</p>
                        </div>

                        <div>
                            <label for="fit_type" class="block text-sm font-medium text-gray-700 mb-2">Fit Type</label>
                            <select name="fit_type" id="fit_type" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select fit type...</option>
                                <option value="Regular" {{ old('fit_type') == 'Regular' ? 'selected' : '' }}>Regular</option>
                                <option value="Slim" {{ old('fit_type') == 'Slim' ? 'selected' : '' }}>Slim</option>
                                <option value="Loose" {{ old('fit_type') == 'Loose' ? 'selected' : '' }}>Loose</option>
                                <option value="Oversized" {{ old('fit_type') == 'Oversized' ? 'selected' : '' }}>Oversized</option>
                                <option value="Relaxed" {{ old('fit_type') == 'Relaxed' ? 'selected' : '' }}>Relaxed</option>
                            </select>
                        </div>

                        <div>
                            <label for="occasion" class="block text-sm font-medium text-gray-700 mb-2">Occasion</label>
                            <select name="occasion" id="occasion" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select occasion...</option>
                                <option value="Casual" {{ old('occasion') == 'Casual' ? 'selected' : '' }}>Casual</option>
                                <option value="Formal" {{ old('occasion') == 'Formal' ? 'selected' : '' }}>Formal</option>
                                <option value="Party" {{ old('occasion') == 'Party' ? 'selected' : '' }}>Party</option>
                                <option value="Wedding" {{ old('occasion') == 'Wedding' ? 'selected' : '' }}>Wedding</option>
                                <option value="Festive" {{ old('occasion') == 'Festive' ? 'selected' : '' }}>Festive</option>
                                <option value="Sports" {{ old('occasion') == 'Sports' ? 'selected' : '' }}>Sports</option>
                            </select>
                        </div>

                        <div>
                            <label for="sleeve_type" class="block text-sm font-medium text-gray-700 mb-2">Sleeve Type</label>
                            <select name="sleeve_type" id="sleeve_type" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select sleeve type...</option>
                                <option value="Full Sleeve" {{ old('sleeve_type') == 'Full Sleeve' ? 'selected' : '' }}>Full Sleeve</option>
                                <option value="Half Sleeve" {{ old('sleeve_type') == 'Half Sleeve' ? 'selected' : '' }}>Half Sleeve</option>
                                <option value="Sleeveless" {{ old('sleeve_type') == 'Sleeveless' ? 'selected' : '' }}>Sleeveless</option>
                                <option value="3/4 Sleeve" {{ old('sleeve_type') == '3/4 Sleeve' ? 'selected' : '' }}>3/4 Sleeve</option>
                                <option value="Cap Sleeve" {{ old('sleeve_type') == 'Cap Sleeve' ? 'selected' : '' }}>Cap Sleeve</option>
                            </select>
                        </div>

                        <div>
                            <label for="neck_type" class="block text-sm font-medium text-gray-700 mb-2">Neck Type</label>
                            <select name="neck_type" id="neck_type" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select neck type...</option>
                                <option value="Round Neck" {{ old('neck_type') == 'Round Neck' ? 'selected' : '' }}>Round Neck</option>
                                <option value="V-Neck" {{ old('neck_type') == 'V-Neck' ? 'selected' : '' }}>V-Neck</option>
                                <option value="Collar" {{ old('neck_type') == 'Collar' ? 'selected' : '' }}>Collar</option>
                                <option value="Boat Neck" {{ old('neck_type') == 'Boat Neck' ? 'selected' : '' }}>Boat Neck</option>
                                <option value="High Neck" {{ old('neck_type') == 'High Neck' ? 'selected' : '' }}>High Neck</option>
                                <option value="Square Neck" {{ old('neck_type') == 'Square Neck' ? 'selected' : '' }}>Square Neck</option>
                            </select>
                        </div>

                        <div>
                            <label for="season" class="block text-sm font-medium text-gray-700 mb-2">Season</label>
                            <select name="season" id="season" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select season...</option>
                                <option value="Summer" {{ old('season') == 'Summer' ? 'selected' : '' }}>Summer</option>
                                <option value="Winter" {{ old('season') == 'Winter' ? 'selected' : '' }}>Winter</option>
                                <option value="Monsoon" {{ old('season') == 'Monsoon' ? 'selected' : '' }}>Monsoon</option>
                                <option value="All Season" {{ old('season') == 'All Season' ? 'selected' : '' }}>All Season</option>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label for="care_instructions" class="block text-sm font-medium text-gray-700 mb-2">Care Instructions</label>
                            <textarea name="care_instructions" id="care_instructions" rows="3"
                                      class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="e.g., Machine wash cold, Do not bleach, Tumble dry low, Iron on low heat">{{ old('care_instructions') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Provide washing and care instructions for the product</p>
                        </div>
                    </div>
                </div>

                <!-- Variant Manager -->
                @include('admin.products.partials.variant-manager')

                <!-- Google Merchant Center -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">🛒 Google Merchant Center</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="gtin" class="block text-sm font-medium text-gray-700 mb-2">GTIN (UPC/EAN/ISBN)</label>
                            <input type="text" name="gtin" id="gtin" value="{{ old('gtin') }}"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Highly recommended for Google visibility</p>
                            @error('gtin')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mpn" class="block text-sm font-medium text-gray-700 mb-2">MPN (Manufacturer Part Number)</label>
                            <input type="text" name="mpn" id="mpn" value="{{ old('mpn') }}"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('mpn')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="google_product_category" class="block text-sm font-medium text-gray-700 mb-2">Google Product Category</label>
                            <input type="text" name="google_product_category" id="google_product_category" value="{{ old('google_product_category') }}" placeholder="e.g., Apparel & Accessories > Clothing > Dresses"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Use Google's official taxonomy</p>
                            @error('google_product_category')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">Condition</label>
                            <select name="condition" id="condition"
                                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="new" {{ old('condition') == 'new' ? 'selected' : '' }}>New</option>
                                <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Used</option>
                                <option value="refurbished" {{ old('condition') == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
                            </select>
                            @error('condition')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="age_group" class="block text-sm font-medium text-gray-700 mb-2">Age Group</label>
                            <select name="age_group" id="age_group"
                                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select Age Group</option>
                                <option value="adult" {{ old('age_group') == 'adult' ? 'selected' : '' }}>Adult</option>
                                <option value="kids" {{ old('age_group') == 'kids' ? 'selected' : '' }}>Kids</option>
                                <option value="toddler" {{ old('age_group') == 'toddler' ? 'selected' : '' }}>Toddler</option>
                                <option value="infant" {{ old('age_group') == 'infant' ? 'selected' : '' }}>Infant</option>
                                <option value="newborn" {{ old('age_group') == 'newborn' ? 'selected' : '' }}>Newborn</option>
                            </select>
                            @error('age_group')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                            <select name="gender" id="gender"
                                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="unisex" {{ old('gender') == 'unisex' ? 'selected' : '' }}>Unisex</option>
                            </select>
                            @error('gender')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        @if(isset($variantTypes) && $variantTypes->count() > 0)
                            @foreach($variantTypes as $variantType)
                            <div>
                                <label for="{{ $variantType->slug }}" class="block text-sm font-medium text-gray-700 mb-2">
                                    {{ $variantType->name }}
                                    @if($variantType->slug === 'size' || $variantType->slug === 'color')
                                        <span class="text-red-500">*</span>
                                    @endif
                                </label>
                                <select name="{{ $variantType->slug }}" id="{{ $variantType->slug }}"
                                        @if($variantType->slug === 'size' || $variantType->slug === 'color') required @endif
                                        class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Select {{ $variantType->name }}</option>
                                    @foreach($variantType->activeOptions as $option)
                                        <option value="{{ $option->value }}" {{ old($variantType->slug) == $option->value ? 'selected' : '' }}>
                                            {{ $option->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error($variantType->slug)
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                                @if($variantType->description)
                                    <p class="mt-1 text-xs text-gray-500">{{ $variantType->description }}</p>
                                @endif
                            </div>
                            @endforeach
                        @else
                            <!-- Fallback if no variant types loaded -->
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-4">
                                <p class="text-yellow-800 text-sm">
                                    <strong>Note:</strong> Variant types not loaded. Please check the variant management system.
                                    <a href="{{ route('admin.variants.index') }}" class="text-blue-600 underline">Manage Variants</a>
                                </p>
                            </div>
                        @endif

                        <div>
                            <label for="pattern" class="block text-sm font-medium text-gray-700 mb-2">Pattern</label>
                            <input type="text" name="pattern" id="pattern" value="{{ old('pattern') }}" placeholder="e.g., Solid, Striped, Floral"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('pattern')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="identifier_exists" value="1" {{ old('identifier_exists', true) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Product has valid GTIN/MPN identifiers</span>
                        </label>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">🔍 SEO Settings</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="seo_title" class="block text-sm font-medium text-gray-700 mb-2">SEO Title</label>
                            <input type="text" name="seo_title" id="seo_title" value="{{ old('seo_title') }}" maxlength="255"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('seo_title')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="seo_description" class="block text-sm font-medium text-gray-700 mb-2">SEO Description</label>
                            <textarea name="seo_description" id="seo_description" rows="3" maxlength="500"
                                      class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('seo_description') }}</textarea>
                            @error('seo_description')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="seo_keywords" class="block text-sm font-medium text-gray-700 mb-2">SEO Keywords</label>
                            <input type="text" name="seo_keywords" id="seo_keywords" value="{{ old('seo_keywords') }}" placeholder="keyword1, keyword2, keyword3"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('seo_keywords')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                
                <!-- Publish Settings -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">Publish Settings</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                            <select name="category_id" id="category_id" required
                                    class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="tags" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                            <input type="text" name="tags" id="tags" value="{{ old('tags') }}" placeholder="tag1, tag2, tag3"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Separate tags with commas</p>
                            @error('tags')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Featured Product</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Active (Visible on website)</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" name="auto_share_social_media" value="1" {{ old('auto_share_social_media') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">📱 Auto-share to Social Media (Facebook, Instagram, etc.)</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">🚚 Shipping Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div>
                            <label for="length_cm" class="block text-sm font-medium text-gray-700 mb-2">Length (cm)</label>
                            <input type="number" name="length_cm" id="length_cm" value="{{ old('length_cm') }}" step="0.01" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="0.00">
                        </div>

                        <div>
                            <label for="width_cm" class="block text-sm font-medium text-gray-700 mb-2">Width (cm)</label>
                            <input type="number" name="width_cm" id="width_cm" value="{{ old('width_cm') }}" step="0.01" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="0.00">
                        </div>

                        <div>
                            <label for="height_cm" class="block text-sm font-medium text-gray-700 mb-2">Height (cm)</label>
                            <input type="number" name="height_cm" id="height_cm" value="{{ old('height_cm') }}" step="0.01" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="0.00">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Product Weight (kg)</label>
                            <input type="number" name="weight" id="weight" value="{{ old('weight') }}" step="0.01" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="shipping_weight" class="block text-sm font-medium text-gray-700 mb-2">Shipping Weight (kg)</label>
                            <input type="number" name="shipping_weight" id="shipping_weight" value="{{ old('shipping_weight') }}" step="0.01" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="mt-1 text-xs text-gray-500">Including packaging</p>
                        </div>

                        <div>
                            <label for="package_type" class="block text-sm font-medium text-gray-700 mb-2">Package Type</label>
                            <select name="package_type" id="package_type" class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select package type...</option>
                                <option value="Box" {{ old('package_type') == 'Box' ? 'selected' : '' }}>Box</option>
                                <option value="Poly Bag" {{ old('package_type') == 'Poly Bag' ? 'selected' : '' }}>Poly Bag</option>
                                <option value="Envelope" {{ old('package_type') == 'Envelope' ? 'selected' : '' }}>Envelope</option>
                                <option value="Custom" {{ old('package_type') == 'Custom' ? 'selected' : '' }}>Custom</option>
                            </select>
                        </div>

                        <div>
                            <label for="shipping_cost" class="block text-sm font-medium text-gray-700 mb-2">Shipping Cost (₹)</label>
                            <input type="number" name="shipping_cost" id="shipping_cost" value="{{ old('shipping_cost') }}" step="0.01" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                    </div>

                    <div class="mt-4 space-y-2">
                        <label class="flex items-center">
                            <input type="checkbox" name="is_fragile" value="1" {{ old('is_fragile') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Fragile Item (Handle with care)</span>
                        </label>

                        <label class="flex items-center">
                            <input type="checkbox" name="requires_signature" value="1" {{ old('requires_signature') ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Requires Signature on Delivery</span>
                        </label>
                    </div>

                    <!-- Keep old dimensions field for backward compatibility -->
                    <input type="hidden" name="dimensions" id="dimensions" value="{{ old('dimensions') }}">
                </div>

                <!-- Media & Content -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">🎥 Media & Content</h3>

                    <div class="space-y-4">
                        <div>
                            <label for="video_url" class="block text-sm font-medium text-gray-700 mb-2">Product Video URL</label>
                            <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="https://youtube.com/watch?v=... or https://vimeo.com/...">
                            <p class="mt-1 text-xs text-gray-500">YouTube or Vimeo video URL</p>
                        </div>

                        <div>
                            <label for="model_info" class="block text-sm font-medium text-gray-700 mb-2">Model Information</label>
                            <textarea name="model_info" id="model_info" rows="2"
                                      class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder='e.g., Model is 5\'6" wearing size M'>{{ old('model_info') }}</textarea>
                            <p class="mt-1 text-xs text-gray-500">Help customers visualize the fit</p>
                        </div>
                    </div>
                </div>

                <!-- Meta Pixel & Facebook -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">📱 Meta Pixel & Facebook</h3>

                    <div class="space-y-4">
                        <div>
                            <label for="facebook_product_id" class="block text-sm font-medium text-gray-700 mb-2">Facebook Product ID</label>
                            <input type="text" name="facebook_product_id" id="facebook_product_id" value="{{ old('facebook_product_id') }}"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Must match Meta Catalog ID</p>
                            @error('facebook_product_id')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cost_of_goods" class="block text-sm font-medium text-gray-700 mb-2">Cost of Goods (₹)</label>
                            <input type="number" name="cost_of_goods" id="cost_of_goods" value="{{ old('cost_of_goods') }}" step="0.01" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">For profit tracking</p>
                            @error('cost_of_goods')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Product Quality -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">⭐ Product Quality & Trust</h3>

                    <div class="space-y-4">
                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="has_warranty" value="1" {{ old('has_warranty') ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Product has warranty</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" name="has_return_policy" value="1" {{ old('has_return_policy', true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-gray-700">Return policy available</span>
                            </label>
                        </div>

                        <div>
                            <label for="warranty_period" class="block text-sm font-medium text-gray-700 mb-2">Warranty Period</label>
                            <input type="text" name="warranty_period" id="warranty_period" value="{{ old('warranty_period') }}" placeholder="e.g., 1 year, 6 months"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('warranty_period')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="return_days" class="block text-sm font-medium text-gray-700 mb-2">Return Days</label>
                            <input type="number" name="return_days" id="return_days" value="{{ old('return_days', 30) }}" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('return_days')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <div class="space-y-3">
                        <button type="submit" class="w-full btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Create Product
                        </button>
                        
                        <a href="{{ route('admin.products.index') }}" class="w-full btn btn-outline">
                            Cancel
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Include AI Modal -->
    <x-ai-product-modal :categories="$categories" :variantTypes="$variantTypes" />

    <style>
        .image-method-tab {
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .image-method-tab:hover {
            border-color: #d1d5db !important;
            color: #374151 !important;
        }
        .image-method-tab.active {
            border-color: #3b82f6 !important;
            color: #3b82f6 !important;
        }
    </style>

    <script>
        // Global variables for file management
        let selectedFiles = [];
        let fileDataTransfer = new DataTransfer();
        const maxFiles = 8;

        // Improved file upload with remove functionality
        window.simpleHandleFileUpload = function(input) {
            console.log('Image upload handler triggered');
            const files = Array.from(input.files);
            const preview = document.getElementById('upload-preview');

            if (files.length > maxFiles) {
                alert(`You can only upload up to ${maxFiles} images.`);
                input.value = '';
                return;
            }

            if (files.length === 0) {
                preview.style.display = 'none';
                preview.innerHTML = '';
                return;
            }

            // Store files
            selectedFiles = files;

            // Clear and show preview
            preview.innerHTML = '';
            preview.style.display = 'grid';

            files.forEach((file, index) => {
                if (!file.type.startsWith('image/')) {
                    alert(`"${file.name}" is not an image file.`);
                    return;
                }

                if (file.size > 10 * 1024 * 1024) {
                    alert(`"${file.name}" is too large. Maximum size is 10MB.`);
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group border-2 border-gray-300 rounded-lg overflow-hidden hover:border-blue-500 transition-colors';
                    div.setAttribute('data-index', index);
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview ${index + 1}"
                             class="w-full h-32 object-cover">
                        <div class="absolute top-2 left-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded shadow">
                            #${index + 1}
                        </div>
                        <button type="button" onclick="removeImagePreview(${index})"
                                class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-75 text-white p-2">
                            <p class="text-xs truncate" title="${file.name}">${file.name}</p>
                            <p class="text-xs text-gray-300">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                        </div>
                    `;
                    preview.appendChild(div);
                };
                reader.onerror = function() {
                    alert(`Error reading file: ${file.name}`);
                };
                reader.readAsDataURL(file);
            });

            // Add summary info
            setTimeout(() => {
                const infoDiv = document.createElement('div');
                infoDiv.className = 'col-span-full text-center py-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-2 border-dashed border-blue-300';
                infoDiv.innerHTML = `
                    <svg class="w-10 h-10 mx-auto mb-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-sm font-semibold text-gray-700"><strong class="text-blue-600">${files.length}</strong> of <strong class="text-blue-600">${maxFiles}</strong> images ready</p>
                    <p class="text-xs text-gray-600 mt-1">Images will be uploaded when you save the product</p>
                    <p class="text-xs text-gray-500 mt-1">Hover over images to remove them</p>
                `;
                preview.appendChild(infoDiv);
            }, 100);
        }

        // Remove image from preview
        window.removeImagePreview = function(indexToRemove) {
            const input = document.getElementById('image-upload');
            const preview = document.getElementById('upload-preview');

            // Create new file list without the removed file
            const dt = new DataTransfer();
            selectedFiles.forEach((file, index) => {
                if (index !== indexToRemove) {
                    dt.items.add(file);
                }
            });

            // Update input files
            input.files = dt.files;
            selectedFiles = Array.from(dt.files);

            // Re-render preview
            if (selectedFiles.length > 0) {
                simpleHandleFileUpload(input);
            } else {
                preview.style.display = 'none';
                preview.innerHTML = '';
            }
        }

        // Image method switching - make it global and fix event.target issue
        window.switchImageMethod = function(method) {
            console.log('Switching to method:', method);

            // Update tabs
            document.querySelectorAll('.image-method-tab').forEach(tab => {
                tab.classList.remove('active', 'border-blue-500', 'text-blue-600');
                tab.classList.add('border-transparent', 'text-gray-500');
            });

            // Activate the clicked tab by ID (more reliable than event.target)
            if (method === 'upload') {
                const uploadTab = document.getElementById('upload-tab');
                uploadTab.classList.add('active', 'border-blue-500', 'text-blue-600');
                uploadTab.classList.remove('border-transparent', 'text-gray-500');
            } else {
                const urlTab = document.getElementById('url-tab');
                urlTab.classList.add('active', 'border-blue-500', 'text-blue-600');
                urlTab.classList.remove('border-transparent', 'text-gray-500');
            }

            // Show/hide sections
            const uploadSection = document.getElementById('upload-section');
            const urlSection = document.getElementById('url-section');

            if (method === 'upload') {
                uploadSection.style.display = 'block';
                urlSection.style.display = 'none';
                console.log('Upload section shown');
            } else {
                uploadSection.style.display = 'none';
                urlSection.style.display = 'block';
                console.log('URL section shown');
            }
        }

        // Drag and drop handlers - make global
        window.handleDragOver = function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.currentTarget.classList.add('border-blue-500', 'bg-blue-50');
        }

        window.handleDragLeave = function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.currentTarget.classList.remove('border-blue-500', 'bg-blue-50');
        }

        window.handleDrop = function(e) {
            e.preventDefault();
            e.stopPropagation();
            e.currentTarget.classList.remove('border-blue-500', 'bg-blue-50');

            const files = Array.from(e.dataTransfer.files);
            const input = document.getElementById('image-upload');

            // Create a new FileList-like object
            const dt = new DataTransfer();
            files.forEach(file => dt.items.add(file));
            input.files = dt.files;

            // Trigger the simple handler
            simpleHandleFileUpload(input);
        }

        // Legacy functions - keeping for compatibility
        function handleFileUpload(input) {
            simpleHandleFileUpload(input);
        }

        function showImagePreview(input) {
            simpleHandleFileUpload(input);
        }

        // URL input functions - make global
        window.addImageInput = function() {
            const container = document.getElementById('images-container');
            const div = document.createElement('div');
            div.className = 'image-input-group mb-3';
            div.innerHTML = `
                <label class="block text-sm font-medium text-gray-700 mb-2">Image URL</label>
                <div class="flex gap-2">
                    <input type="url" name="images[]" placeholder="https://example.com/image.jpg"
                           class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <button type="button" onclick="removeImageInput(this)" class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Remove</button>
                </div>
            `;
            container.appendChild(div);
        }

        window.removeImageInput = function(button) {
            const container = document.getElementById('images-container');
            if (container.children.length > 1) {
                button.closest('.image-input-group').remove();
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Page loaded, image upload system ready');
        });
    </script>
</x-layouts.admin>
