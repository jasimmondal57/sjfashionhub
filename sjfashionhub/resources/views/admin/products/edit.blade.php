<x-layouts.admin>
    <x-slot name="title">Edit Product - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">Edit product details</x-slot>
    <x-slot name="pageTitle">✏️ Edit Product: {{ $product->name }}</x-slot>

    <!-- Header Actions -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600">Update product information</p>
        </div>
        <div class="flex space-x-3">
            <button type="button" onclick="openAIModal()" class="bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white px-4 py-2 rounded-md font-medium transition-all duration-200 shadow-lg hover:shadow-xl">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path>
                </svg>
                🤖 AI Enhance Details
            </button>
            <a href="{{ route('products.show', $product->slug) }}" target="_blank" class="btn btn-outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                View Product
            </a>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Products
            </a>
        </div>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- Basic Information -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">Basic Information</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Use format: Brand + Product Type + Key Feature + Color/Size (max 70 chars)</p>
                            @error('name')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="brand" class="block text-sm font-medium text-gray-700 mb-2">Brand *</label>
                            <input type="text" name="brand" id="brand" value="{{ old('brand', $product->brand) }}" required
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Required for Google Merchant Center</p>
                            @error('brand')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Short Description *</label>
                            <textarea name="description" id="description" rows="3" required
                                      class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="long_description" class="block text-sm font-medium text-gray-700 mb-2">Detailed Description</label>
                            <textarea name="long_description" id="long_description" rows="6"
                                      class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('long_description', $product->long_description) }}</textarea>
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
                            <input type="number" name="price" id="price" value="{{ old('price', $product->price) }}" step="0.01" min="0" required
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('price')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="sale_price" class="block text-sm font-medium text-gray-700 mb-2">Sale Price (₹)</label>
                            <input type="number" name="sale_price" id="sale_price" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('sale_price')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tax Settings -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">🏷️ Tax Settings</label>

                            <label class="flex items-center">
                                <input type="checkbox" name="price_includes_tax" value="1" {{ old('price_includes_tax', $product->price_includes_tax ?? true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Price includes tax</span>
                            </label>
                        </div>

                        <div>
                            <label for="tax_rate" class="block text-sm font-medium text-gray-700 mb-2">Tax Rate (%)</label>
                            <input type="number" name="tax_rate" id="tax_rate" value="{{ old('tax_rate', $product->tax_rate ?? 18) }}" step="0.01" min="0" max="100"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('tax_rate')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- SKU and Stock -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="sku" class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                            <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('sku')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity</label>
                            <input type="number" name="stock_quantity" id="stock_quantity" value="{{ old('stock_quantity', $product->stock_quantity) }}" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('stock_quantity')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="manage_stock" value="1" {{ old('manage_stock', $product->manage_stock) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Track stock quantity for this product</span>
                        </label>
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
                                        class="image-method-tab py-2 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300">
                                    📁 Upload Files
                                </button>
                                <button type="button" onclick="switchImageMethod('url')" id="url-tab"
                                        class="image-method-tab active py-2 px-1 border-b-2 border-blue-500 font-medium text-sm text-blue-600">
                                    🔗 Image URLs
                                </button>
                            </nav>
                        </div>
                        <!-- Debug info -->
                        <div class="mt-2 text-xs text-gray-500">
                            <span>Current tab: <span id="current-tab-debug">Image URLs</span></span>
                            <button type="button" onclick="window.testTabSwitch()" class="ml-4 text-blue-600 underline">Test Tab Switch</button>
                        </div>
                    </div>

                    <!-- File Upload Section -->
                    <div id="upload-section" class="image-method-content" style="display: none;">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Upload Product Images (Max 8 images)</label>

                            <!-- File Input (Hidden) -->
                            <input id="image-upload" name="uploaded_images[]" type="file" class="hidden" multiple accept="image/*" onchange="simpleHandleFileUpload(this)">

                            <!-- Upload Area -->
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-gray-400 transition-colors cursor-pointer"
                                 onclick="document.getElementById('image-upload').click()"
                                 ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)" ondrop="handleDrop(event)">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <div class="text-sm text-gray-600">
                                        <span class="font-medium text-blue-600 hover:text-blue-500">Click to upload images</span>
                                        <span class="pl-1">or drag and drop</span>
                                    </div>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG up to 10MB each (Max 8 images)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Manual Upload Button -->
                        <div class="mt-4">
                            <button type="button" onclick="document.getElementById('image-upload').click()"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                </svg>
                                Choose Files
                            </button>
                            <span class="ml-2 text-sm text-gray-500">or use the upload area above</span>
                        </div>

                        <!-- Upload Preview -->
                        <div id="upload-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4" style="display: none;"></div>
                    </div>

                    <!-- URL Input Section -->
                    <div id="url-section" class="image-method-content">

                    <!-- Existing Images Preview -->
                    @if($product->image_urls && count($product->image_urls) > 0)
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">Current Product Images</label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($product->image_urls as $index => $imageUrl)
                                    <div class="relative group border-2 border-gray-300 rounded-lg overflow-hidden hover:border-blue-500 transition-colors">
                                        <img src="{{ $imageUrl }}" alt="Product Image {{ $index + 1 }}" class="w-full h-32 object-cover">
                                        <div class="absolute top-0 left-0 bg-blue-600 text-white px-2 py-1 text-xs font-semibold">
                                            #{{ $index + 1 }}
                                        </div>
                                        <button type="button" onclick="removeExistingImage({{ $index }})"
                                                class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1.5 opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-2 text-xs truncate opacity-0 group-hover:opacity-100 transition-opacity">
                                            {{ basename($imageUrl) }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div id="images-container">
                        @if($product->images && count($product->images) > 0)
                            @foreach($product->images as $index => $image)
                                <input type="hidden" name="images[]" value="{{ $image }}" data-image-index="{{ $index }}">
                            @endforeach
                        @else
                            <div class="image-input-group mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Image URL</label>
                                <div class="flex gap-2">
                                    <input type="url" name="images[]" placeholder="https://example.com/image.jpg"
                                           class="flex-1 px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <button type="button" onclick="removeImageInput(this)" class="px-3 py-2 bg-red-500 text-white rounded-md hover:bg-red-600">Remove</button>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <button type="button" onclick="addImageInput()" class="btn btn-outline">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Another Image
                    </button>
                    </div>
                </div>

                <!-- SEO Settings -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">SEO Settings</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="seo_title" class="block text-sm font-medium text-gray-700 mb-2">SEO Title</label>
                            <input type="text" name="seo_title" id="seo_title" value="{{ old('seo_title', $product->seo_title) }}" maxlength="255"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('seo_title')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="seo_description" class="block text-sm font-medium text-gray-700 mb-2">SEO Description</label>
                            <textarea name="seo_description" id="seo_description" rows="3" maxlength="500"
                                      class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('seo_description', $product->seo_description) }}</textarea>
                            @error('seo_description')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="seo_keywords" class="block text-sm font-medium text-gray-700 mb-2">SEO Keywords</label>
                            <input type="text" name="seo_keywords" id="seo_keywords" value="{{ old('seo_keywords', $product->seo_keywords) }}" placeholder="keyword1, keyword2, keyword3"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('seo_keywords')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
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
                                    <option value="{{ $sizeChart->id }}" {{ old('size_chart_id', $product->size_chart_id) == $sizeChart->id ? 'selected' : '' }}>
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
                            <input type="text" name="color" id="color" value="{{ old('color', $product->color) }}"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="e.g., Black, Red, Blue">
                            <p class="mt-1 text-xs text-gray-500">Primary color of the product</p>
                        </div>

                        <div>
                            <label for="material" class="block text-sm font-medium text-gray-700 mb-2">Material</label>
                            <input type="text" name="material" id="material" value="{{ old('material', $product->material) }}"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="e.g., Cotton, Polyester, Silk">
                            <p class="mt-1 text-xs text-gray-500">Primary material of the product</p>
                        </div>
                    </div>
                </div>

                <!-- Google Merchant Center -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">🛒 Google Merchant Center</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="gtin" class="block text-sm font-medium text-gray-700 mb-2">GTIN (UPC/EAN/ISBN)</label>
                            <input type="text" name="gtin" id="gtin" value="{{ old('gtin', $product->gtin) }}"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Highly recommended for Google visibility</p>
                            @error('gtin')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="mpn" class="block text-sm font-medium text-gray-700 mb-2">MPN (Manufacturer Part Number)</label>
                            <input type="text" name="mpn" id="mpn" value="{{ old('mpn', $product->mpn) }}"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('mpn')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="google_product_category" class="block text-sm font-medium text-gray-700 mb-2">Google Product Category</label>
                            <input type="text" name="google_product_category" id="google_product_category" value="{{ old('google_product_category', $product->google_product_category) }}" placeholder="e.g., Apparel & Accessories > Clothing > Dresses"
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
                                <option value="new" {{ old('condition', $product->condition) == 'new' ? 'selected' : '' }}>New</option>
                                <option value="used" {{ old('condition', $product->condition) == 'used' ? 'selected' : '' }}>Used</option>
                                <option value="refurbished" {{ old('condition', $product->condition) == 'refurbished' ? 'selected' : '' }}>Refurbished</option>
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
                                <option value="adult" {{ old('age_group', $product->age_group) == 'adult' ? 'selected' : '' }}>Adult</option>
                                <option value="kids" {{ old('age_group', $product->age_group) == 'kids' ? 'selected' : '' }}>Kids</option>
                                <option value="toddler" {{ old('age_group', $product->age_group) == 'toddler' ? 'selected' : '' }}>Toddler</option>
                                <option value="infant" {{ old('age_group', $product->age_group) == 'infant' ? 'selected' : '' }}>Infant</option>
                                <option value="newborn" {{ old('age_group', $product->age_group) == 'newborn' ? 'selected' : '' }}>Newborn</option>
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
                                <option value="male" {{ old('gender', $product->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $product->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="unisex" {{ old('gender', $product->gender) == 'unisex' ? 'selected' : '' }}>Unisex</option>
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
                                        <option value="{{ $option->value }}" {{ old($variantType->slug, $product->{$variantType->slug}) == $option->value ? 'selected' : '' }}>
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
                        @endif

                        <div>
                            <label for="pattern" class="block text-sm font-medium text-gray-700 mb-2">Pattern</label>
                            <input type="text" name="pattern" id="pattern" value="{{ old('pattern', $product->pattern) }}" placeholder="e.g., Solid, Striped, Floral"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('pattern')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="flex items-center">
                            <input type="checkbox" name="identifier_exists" value="1" {{ old('identifier_exists', $product->identifier_exists) ? 'checked' : '' }}
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <span class="ml-2 text-sm text-gray-700">Product has valid GTIN/MPN identifiers</span>
                        </label>
                    </div>
                </div>

                <!-- Meta Pixel & Facebook -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">📱 Meta Pixel & Facebook</h3>

                    <div class="space-y-4">
                        <div>
                            <label for="facebook_product_id" class="block text-sm font-medium text-gray-700 mb-2">Facebook Product ID</label>
                            <input type="text" name="facebook_product_id" id="facebook_product_id" value="{{ old('facebook_product_id', $product->facebook_product_id) }}"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Must match Meta Catalog ID</p>
                            @error('facebook_product_id')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="cost_of_goods" class="block text-sm font-medium text-gray-700 mb-2">Cost of Goods (₹)</label>
                            <input type="number" name="cost_of_goods" id="cost_of_goods" value="{{ old('cost_of_goods', $product->cost_of_goods) }}" step="0.01" min="0"
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
                                <input type="checkbox" name="has_warranty" value="1" {{ old('has_warranty', $product->has_warranty) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Product has warranty</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" name="has_return_policy" value="1" {{ old('has_return_policy', $product->has_return_policy ?? true) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-gray-700">Return policy available</span>
                            </label>
                        </div>

                        <div>
                            <label for="warranty_period" class="block text-sm font-medium text-gray-700 mb-2">Warranty Period</label>
                            <input type="text" name="warranty_period" id="warranty_period" value="{{ old('warranty_period', $product->warranty_period) }}" placeholder="e.g., 1 year, 6 months"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('warranty_period')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="return_days" class="block text-sm font-medium text-gray-700 mb-2">Return Days</label>
                            <input type="number" name="return_days" id="return_days" value="{{ old('return_days', $product->return_days ?? 30) }}" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('return_days')
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
                                    <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                            <input type="text" name="tags" id="tags" value="{{ old('tags', is_array($product->tags) ? implode(', ', $product->tags) : $product->tags) }}" placeholder="tag1, tag2, tag3"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            <p class="mt-1 text-xs text-gray-500">Separate tags with commas</p>
                            @error('tags')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-3">
                            <label class="flex items-center">
                                <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Featured Product</span>
                            </label>

                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <span class="ml-2 text-sm text-gray-700">Active (Visible on website)</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Product Attributes -->
                <div class="bg-white rounded-lg border border-gray-100 p-6">
                    <h3 class="text-lg font-semibold text-black mb-4">Product Attributes</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700 mb-2">Weight (kg)</label>
                            <input type="number" name="weight" id="weight" value="{{ old('weight', $product->weight) }}" step="0.01" min="0"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('weight')
                                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="dimensions" class="block text-sm font-medium text-gray-700 mb-2">Dimensions</label>
                            <input type="text" name="dimensions" id="dimensions" value="{{ old('dimensions', $product->dimensions) }}" placeholder="L x W x H"
                                   class="w-full px-3 py-2 bg-white border border-gray-300 rounded-md text-gray-900 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                            @error('dimensions')
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
                            Update Product
                        </button>
                        
                        <a href="{{ route('admin.products.index') }}" class="w-full btn btn-outline">
                            Cancel
                        </a>
                        
                        <button type="button" onclick="deleteProduct({{ $product->id }})" class="w-full btn bg-red-500 hover:bg-red-600 text-white">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Product
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    @push('styles')
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
    @endpush

    <script>
        // Global variables for file management
        let selectedFiles = [];
        const maxFiles = 8;

        // Simple file upload approach
        function simpleHandleFileUpload(input) {
            console.log('Simple file upload handler triggered');
            console.log('Files selected:', input.files.length);
            const files = Array.from(input.files);
            const preview = document.getElementById('upload-preview');

            if (files.length > maxFiles) {
                alert(`You can only upload up to ${maxFiles} images.`);
                input.value = ''; // Clear the input
                return;
            }

            if (files.length > 0) {
                preview.style.display = 'grid';
                preview.innerHTML = '';

                files.forEach((file, index) => {
                    if (file.type.startsWith('image/')) {
                        if (file.size <= 10 * 1024 * 1024) { // 10MB limit
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const div = document.createElement('div');
                                div.className = 'relative group';
                                div.innerHTML = `
                                    <img src="${e.target.result}" alt="Preview ${index + 1}"
                                         class="w-full h-32 object-cover rounded-lg border border-gray-300">
                                    <div class="absolute top-2 left-2 bg-black bg-opacity-75 text-white text-xs px-2 py-1 rounded">
                                        ${index + 1}
                                    </div>
                                    <p class="text-xs text-gray-600 mt-1 truncate" title="${file.name}">${file.name}</p>
                                    <p class="text-xs text-gray-400">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
                                `;
                                preview.appendChild(div);
                            };
                            reader.readAsDataURL(file);
                        } else {
                            alert(`File ${file.name} is too large. Maximum size is 10MB.`);
                        }
                    } else {
                        alert(`File ${file.name} is not a valid image.`);
                    }
                });
            } else {
                preview.style.display = 'none';
            }
        }

        // Test function for tab switching - make it global
        window.testTabSwitch = function() {
            console.log('Testing tab switch...');
            const currentTab = document.getElementById('current-tab-debug').textContent;
            if (currentTab === 'Image URLs') {
                switchImageMethod('upload');
            } else {
                switchImageMethod('url');
            }
        }

        // Image method switching - make it global
        window.switchImageMethod = function(method) {
            console.log('Switching to method:', method);

            // Update debug info
            document.getElementById('current-tab-debug').textContent = method === 'upload' ? 'Upload Files' : 'Image URLs';

            // Update tabs
            document.querySelectorAll('.image-method-tab').forEach(tab => {
                tab.classList.remove('active', 'border-blue-500', 'text-blue-600');
                tab.classList.add('border-transparent', 'text-gray-500');
            });

            // Activate the clicked tab
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

        // Drag and drop handlers
        function handleDragOver(e) {
            e.preventDefault();
            e.stopPropagation();
            e.currentTarget.classList.add('border-blue-500', 'bg-blue-50');
        }

        function handleDragLeave(e) {
            e.preventDefault();
            e.stopPropagation();
            e.currentTarget.classList.remove('border-blue-500', 'bg-blue-50');
        }

        function handleDrop(e) {
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

        function addImageInput() {
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

        function removeImageInput(button) {
            const container = document.getElementById('images-container');
            if (container.children.length > 1) {
                button.closest('.image-input-group').remove();
            }
        }

        // Remove existing image from preview and hidden inputs
        function removeExistingImage(index) {
            if (confirm('Are you sure you want to remove this image?')) {
                // Remove the hidden input with this index
                const hiddenInput = document.querySelector(`input[data-image-index="${index}"]`);
                if (hiddenInput) {
                    hiddenInput.remove();
                }

                // Remove the preview element
                const previewContainer = document.querySelector('.grid.grid-cols-2.md\\:grid-cols-4');
                if (previewContainer && previewContainer.children[index]) {
                    previewContainer.children[index].remove();
                }
            }
        }

        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/products/${productId}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }

        // AI Modal functionality for edit page
        function openAIModal() {
            // Pre-populate AI modal with existing product data
            const modal = document.getElementById('ai-modal');

            // Get current form values
            const currentName = document.getElementById('name').value;
            const currentDescription = document.getElementById('description').value;
            const currentShortDescription = document.getElementById('short_description').value;
            const currentBrand = document.getElementById('brand').value;
            const currentCategory = document.getElementById('category_id').value;

            // Get current variant selections
            const currentSize = getSelectedVariantValues('size');
            const currentColor = getSelectedVariantValues('color');
            const currentMaterial = getSelectedVariantValues('material');

            // Pre-fill AI modal fields
            if (currentName) {
                const aiNameField = document.getElementById('ai-name');
                if (aiNameField) aiNameField.value = currentName;
            }

            if (currentDescription) {
                const aiDescField = document.getElementById('ai-description');
                if (aiDescField) aiDescField.value = currentDescription;
            }

            if (currentShortDescription) {
                const aiShortDescField = document.getElementById('ai-short-description');
                if (aiShortDescField) aiShortDescField.value = currentShortDescription;
            }

            if (currentBrand) {
                const aiBrandField = document.getElementById('ai-brand');
                if (aiBrandField) aiBrandField.value = currentBrand;
            }

            if (currentCategory) {
                const aiCategoryField = document.getElementById('ai-category');
                if (aiCategoryField) aiCategoryField.value = currentCategory;
            }

            // Pre-select variants in AI modal
            preselectAIVariants('ai-size', currentSize);
            preselectAIVariants('ai-color', currentColor);
            preselectAIVariants('ai-material', currentMaterial);

            // Show the modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function getSelectedVariantValues(variantType) {
            const select = document.getElementById(variantType);
            if (!select) return [];

            const selectedOptions = Array.from(select.selectedOptions);
            return selectedOptions.map(option => option.value);
        }

        function preselectAIVariants(containerId, selectedValues) {
            const container = document.getElementById(containerId);
            if (!container || !selectedValues.length) return;

            const checkboxes = container.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(checkbox => {
                if (selectedValues.includes(checkbox.value)) {
                    checkbox.checked = true;
                }
            });
        }
    </script>

    <!-- Include AI Modal with existing product data -->
    <x-ai-product-modal
        :categories="$categories ?? []"
        :variantTypes="$variantTypes ?? []"
        :existingProduct="$product" />
</x-layouts.admin>
