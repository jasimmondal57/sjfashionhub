<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">📦 Bulk Product Upload</h1>
                        <p class="text-gray-600 mt-1">Import products from Excel, Shopify, or WooCommerce</p>
                    </div>
                    <a href="{{ route('admin.products.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Products
                    </a>
                </div>
            </div>

            <!-- Results Display -->
            @if(session('upload_results') || session('import_results'))
                @php
                    $results = session('upload_results') ?: session('import_results');
                @endphp
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">📊 Import Results</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-list text-blue-600 text-xl mr-3"></i>
                                <div>
                                    <p class="text-sm text-blue-600 font-medium">Total Processed</p>
                                    <p class="text-2xl font-bold text-blue-900">{{ $results['total'] }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle text-green-600 text-xl mr-3"></i>
                                <div>
                                    <p class="text-sm text-green-600 font-medium">Successfully Imported</p>
                                    <p class="text-2xl font-bold text-green-900">{{ $results['success'] }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-circle text-red-600 text-xl mr-3"></i>
                                <div>
                                    <p class="text-sm text-red-600 font-medium">Failed</p>
                                    <p class="text-2xl font-bold text-red-900">{{ $results['failed'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if(!empty($results['errors']))
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                            <h4 class="text-sm font-medium text-red-800 mb-2">Errors:</h4>
                            <ul class="text-sm text-red-700 space-y-1">
                                @foreach(array_slice($results['errors'], 0, 10) as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                                @if(count($results['errors']) > 10)
                                    <li class="text-red-600 font-medium">... and {{ count($results['errors']) - 10 }} more errors</li>
                                @endif
                            </ul>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle text-red-400 mr-3 mt-0.5"></i>
                        <div>
                            <h3 class="text-sm font-medium text-red-800">There were some errors:</h3>
                            <ul class="mt-2 text-sm text-red-700">
                                @foreach($errors->all() as $error)
                                    <li>• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Upload Methods -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Excel Upload -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="text-center mb-6">
                        <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-file-excel text-green-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">📊 Excel Upload</h3>
                        <p class="text-gray-600 text-sm mt-1">Upload products using Excel/CSV file</p>
                    </div>

                    <form action="{{ route('admin.bulk-upload.excel') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="excel_file" class="block text-sm font-medium text-gray-700 mb-2">
                                Choose Excel File
                            </label>
                            <input type="file" name="excel_file" id="excel_file" accept=".xlsx,.xls,.csv" required
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                            <p class="mt-1 text-xs text-gray-500">Supports .xlsx, .xls, .csv files (max 10MB)</p>
                        </div>

                        <div class="space-y-3">
                            <a href="{{ route('admin.bulk-upload.sample') }}" 
                               class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-md font-medium transition-colors text-center block">
                                <i class="fas fa-download mr-2"></i>Download Sample Excel
                            </a>
                            
                            <button type="submit" 
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                                <i class="fas fa-upload mr-2"></i>Upload Excel File
                            </button>
                        </div>
                    </form>

                    <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">Excel Features:</h4>
                        <ul class="text-xs text-blue-700 space-y-1">
                            <li>• Supports Google Drive image links</li>
                            <li>• Auto-converts share links to direct links</li>
                            <li>• Multiple images per product (comma-separated)</li>
                            <li>• Auto-creates categories if not exist</li>
                            <li>• Complete product data import</li>
                        </ul>
                    </div>
                </div>

                <!-- Shopify Import -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="text-center mb-6">
                        <div class="mx-auto w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fab fa-shopify text-purple-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">🛍️ Shopify Import</h3>
                        <p class="text-gray-600 text-sm mt-1">Import products from Shopify store</p>
                    </div>

                    <form action="{{ route('admin.bulk-upload.shopify') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="shopify_store_url" class="block text-sm font-medium text-gray-700 mb-2">
                                Store URL
                            </label>
                            <input type="url" name="shopify_store_url" id="shopify_store_url" required
                                   placeholder="https://your-store.myshopify.com"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="shopify_access_token" class="block text-sm font-medium text-gray-700 mb-2">
                                Private App Access Token
                            </label>
                            <input type="password" name="shopify_access_token" id="shopify_access_token" required
                                   placeholder="shpat_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>

                        <button type="submit" 
                                class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-download mr-2"></i>Import from Shopify
                        </button>
                    </form>

                    <div class="mt-4 p-3 bg-purple-50 border border-purple-200 rounded-lg">
                        <h4 class="text-sm font-medium text-purple-800 mb-2">Setup Instructions:</h4>
                        <ol class="text-xs text-purple-700 space-y-1">
                            <li>1. Go to Shopify Admin → Apps → Private apps</li>
                            <li>2. Create private app with Products read permission</li>
                            <li>3. Copy the Private app access token</li>
                            <li>4. Enter your store URL and token above</li>
                        </ol>
                    </div>
                </div>

                <!-- WooCommerce Import -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                    <div class="text-center mb-6">
                        <div class="mx-auto w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fab fa-wordpress text-blue-600 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900">🛒 WooCommerce Import</h3>
                        <p class="text-gray-600 text-sm mt-1">Import products from WooCommerce store</p>
                    </div>

                    <form action="{{ route('admin.bulk-upload.woocommerce') }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div>
                            <label for="woo_store_url" class="block text-sm font-medium text-gray-700 mb-2">
                                Store URL
                            </label>
                            <input type="url" name="woo_store_url" id="woo_store_url" required
                                   placeholder="https://your-store.com"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="woo_consumer_key" class="block text-sm font-medium text-gray-700 mb-2">
                                Consumer Key
                            </label>
                            <input type="text" name="woo_consumer_key" id="woo_consumer_key" required
                                   placeholder="ck_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="woo_consumer_secret" class="block text-sm font-medium text-gray-700 mb-2">
                                Consumer Secret
                            </label>
                            <input type="password" name="woo_consumer_secret" id="woo_consumer_secret" required
                                   placeholder="cs_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <button type="submit" 
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                            <i class="fas fa-download mr-2"></i>Import from WooCommerce
                        </button>
                    </form>

                    <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="text-sm font-medium text-blue-800 mb-2">Setup Instructions:</h4>
                        <ol class="text-xs text-blue-700 space-y-1">
                            <li>1. Go to WooCommerce → Settings → Advanced → REST API</li>
                            <li>2. Create new API key with Read permissions</li>
                            <li>3. Copy Consumer Key and Consumer Secret</li>
                            <li>4. Enter your store URL and credentials above</li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Bulk Edit Section -->
            <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <div class="text-center mb-6">
                    <div class="mx-auto w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center mb-4">
                        <i class="fas fa-edit text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">✏️ Bulk Edit Products</h3>
                    <p class="text-gray-600 text-sm mt-1">Download current products, edit in Excel, and upload back to update</p>
                </div>

                <!-- Bulk Update Results -->
                @if(session('bulk_update_results'))
                    @php
                        $results = session('bulk_update_results');
                    @endphp
                    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <h4 class="text-lg font-semibold text-blue-900 mb-3">📊 Bulk Update Results</h4>

                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                            <div class="bg-white border border-blue-200 rounded-lg p-3 text-center">
                                <p class="text-sm text-blue-600 font-medium">Total Processed</p>
                                <p class="text-xl font-bold text-blue-900">{{ $results['total'] }}</p>
                            </div>
                            <div class="bg-white border border-green-200 rounded-lg p-3 text-center">
                                <p class="text-sm text-green-600 font-medium">Updated</p>
                                <p class="text-xl font-bold text-green-900">{{ $results['updated'] }}</p>
                            </div>
                            <div class="bg-white border border-blue-200 rounded-lg p-3 text-center">
                                <p class="text-sm text-blue-600 font-medium">Created</p>
                                <p class="text-xl font-bold text-blue-900">{{ $results['created'] }}</p>
                            </div>
                            <div class="bg-white border border-red-200 rounded-lg p-3 text-center">
                                <p class="text-sm text-red-600 font-medium">Failed</p>
                                <p class="text-xl font-bold text-red-900">{{ $results['failed'] }}</p>
                            </div>
                        </div>

                        @if(!empty($results['errors']))
                            <div class="bg-red-50 border border-red-200 rounded-lg p-3">
                                <h5 class="text-sm font-medium text-red-800 mb-2">Errors:</h5>
                                <ul class="text-sm text-red-700 space-y-1">
                                    @foreach(array_slice($results['errors'], 0, 10) as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                    @if(count($results['errors']) > 10)
                                        <li class="text-red-600 font-medium">... and {{ count($results['errors']) - 10 }} more errors</li>
                                    @endif
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Step 1: Download Current Products -->
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 border border-orange-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-orange-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">1</div>
                            <h4 class="text-lg font-semibold text-orange-900">Download Current Products</h4>
                        </div>
                        <p class="text-orange-700 text-sm mb-4">Download all your current products as an Excel file with all their details.</p>

                        <a href="{{ route('admin.bulk-upload.current-products') }}"
                           class="w-full bg-orange-600 hover:bg-orange-700 text-white px-4 py-3 rounded-md font-medium transition-colors text-center block"
                           style="background-color: #ea580c !important; color: white !important; text-decoration: none !important;">
                            <i class="fas fa-download mr-2"></i>Download Current Products Excel
                        </a>

                        <div class="mt-3 p-3 bg-orange-100 border border-orange-300 rounded-lg">
                            <p class="text-xs text-orange-800">
                                <i class="fas fa-info-circle mr-1"></i>
                                This will download an Excel file with all your products including IDs, which are required for updates.
                            </p>
                        </div>
                    </div>

                    <!-- Step 2: Upload Updated Products -->
                    <div class="bg-gradient-to-br from-green-50 to-green-100 border border-green-200 rounded-lg p-6">
                        <div class="flex items-center mb-4">
                            <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold mr-3">2</div>
                            <h4 class="text-lg font-semibold text-green-900">Upload Updated Products</h4>
                        </div>
                        <p class="text-green-700 text-sm mb-4">After editing the Excel file, upload it back to update your products.</p>

                        <form action="{{ route('admin.bulk-upload.update') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                            @csrf

                            <div>
                                <label for="bulk_update_file" class="block text-sm font-medium text-green-700 mb-2">
                                    Choose Updated Excel File
                                </label>
                                <input type="file" name="excel_file" id="bulk_update_file" accept=".xlsx,.xls,.csv" required
                                       class="w-full px-3 py-2 border border-green-300 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                <p class="mt-1 text-xs text-green-600">Must include product IDs for updates</p>
                            </div>

                            <button type="submit"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-3 rounded-md font-medium transition-colors"
                                    style="background-color: #16a34a !important; color: white !important;">
                                <i class="fas fa-upload mr-2"></i>Update Products
                            </button>
                        </form>

                        <div class="mt-3 p-3 bg-green-100 border border-green-300 rounded-lg">
                            <p class="text-xs text-green-800">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                Keep the ID column unchanged. Only edit the data you want to update.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bulk Edit Instructions -->
                <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
                    <h4 class="font-medium text-gray-900 mb-3">📋 Bulk Edit Instructions:</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h5 class="text-sm font-semibold text-gray-800 mb-2">✅ Do's:</h5>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Keep the ID column unchanged</li>
                                <li>• Edit only the fields you want to update</li>
                                <li>• Use the same format as downloaded</li>
                                <li>• Save as Excel (.xlsx) format</li>
                                <li>• Test with a few products first</li>
                            </ul>
                        </div>
                        <div>
                            <h5 class="text-sm font-semibold text-gray-800 mb-2">❌ Don'ts:</h5>
                            <ul class="text-sm text-gray-600 space-y-1">
                                <li>• Don't change or remove the ID column</li>
                                <li>• Don't add new rows (use regular upload for new products)</li>
                                <li>• Don't change the header row</li>
                                <li>• Don't leave required fields empty</li>
                                <li>• Don't use special characters in file names</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Section -->
            <div class="mt-8 bg-white rounded-lg shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">💡 Import Guidelines</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">Excel Upload Tips:</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Use the sample Excel template for best results</li>
                            <li>• Required fields: name, brand, category, price</li>
                            <li>• For Google Drive images, use share links</li>
                            <li>• Multiple values: separate with commas (sizes, colors, tags)</li>
                            <li>• Categories will be auto-created if they don't exist</li>
                        </ul>
                    </div>
                    
                    <div>
                        <h4 class="font-medium text-gray-900 mb-2">API Import Notes:</h4>
                        <ul class="text-sm text-gray-600 space-y-1">
                            <li>• Ensure your API credentials have proper permissions</li>
                            <li>• Large stores may take several minutes to import</li>
                            <li>• Products will be imported with their current status</li>
                            <li>• Images and variants will be preserved</li>
                            <li>• Duplicate products will be skipped</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
