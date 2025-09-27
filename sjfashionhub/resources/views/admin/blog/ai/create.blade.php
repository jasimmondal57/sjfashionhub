<x-layouts.admin>
    <x-slot name="title">AI Blog Generator - Create</x-slot>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">AI Blog Generator</h1>
                <p class="text-gray-600 mt-1">Generate SEO-optimized blog content using AI</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.blog.ai.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Product Selection & Settings -->
            <div class="lg:col-span-1">
                <!-- Product Selection -->
                <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Select Product</h2>
                    
                    @if($product)
                        <!-- Selected Product -->
                        <div class="border border-gray-200 rounded-lg p-4 mb-4">
                            @if($product->images && count($product->images) > 0)
                                <img src="{{ asset('storage/' . $product->images[0]['image_path']) }}" alt="{{ $product->name }}"
                                     class="w-full h-32 object-cover rounded-lg mb-3"
                                     onerror="this.style.display='none'">
                            @endif
                            <h3 class="font-medium text-gray-900">{{ $product->name }}</h3>
                            <p class="text-sm text-gray-600">{{ $product->category->name }}</p>
                            <p class="text-lg font-semibold text-gray-900 mt-2">{{ $product->formatted_price }}</p>
                            
                            @if($product->blogPosts->count() > 0)
                                <div class="mt-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        {{ $product->blogPosts->count() }} existing blog{{ $product->blogPosts->count() > 1 ? 's' : '' }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        
                        <a href="{{ route('admin.blog.ai.create') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                            Choose Different Product
                        </a>
                    @else
                        <!-- Product Search -->
                        <div class="mb-4">
                            <input type="text" id="product-search" placeholder="Search products..." 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                        </div>
                        
                        <div id="product-results" class="space-y-2 max-h-64 overflow-y-auto">
                            <!-- Product search results will be loaded here -->
                            <div class="text-center py-4">
                                <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-purple-600 mx-auto"></div>
                                <p class="text-sm text-gray-500 mt-2">Loading products...</p>
                            </div>
                        </div>
                    @endif
                </div>

                @if($product)
                <!-- AI Auto-Generation -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">AI Blog Generator</h2>

                    <div class="text-center">
                        <div class="mb-6">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-100 to-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Ready to Generate</h3>
                            <p class="text-gray-600 text-sm">AI will automatically create a complete SEO-optimized blog post for this product</p>
                        </div>

                        <!-- Blog Generation Options -->
                        <div class="space-y-6">
                            <!-- Single Blog Type Generation -->
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                <h3 class="text-lg font-semibold mb-4 text-center text-gray-800">Generate Single Blog Post</h3>
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <button type="button" onclick="generateSpecificBlogType('product_review')"
                                            style="background-color: #2563eb !important; color: white !important; padding: 12px 16px; border-radius: 8px; font-weight: 500; font-size: 14px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border: none; cursor: pointer; transition: all 0.3s ease;"
                                            onmouseover="this.style.backgroundColor='#1d4ed8'"
                                            onmouseout="this.style.backgroundColor='#2563eb'">
                                        📝 Product Review
                                    </button>
                                    <button type="button" onclick="generateSpecificBlogType('buying_guide')"
                                            style="background-color: #16a34a !important; color: white !important; padding: 12px 16px; border-radius: 8px; font-weight: 500; font-size: 14px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border: none; cursor: pointer; transition: all 0.3s ease;"
                                            onmouseover="this.style.backgroundColor='#15803d'"
                                            onmouseout="this.style.backgroundColor='#16a34a'">
                                        🛒 Buying Guide
                                    </button>
                                    <button type="button" onclick="generateSpecificBlogType('style_guide')"
                                            style="background-color: #9333ea !important; color: white !important; padding: 12px 16px; border-radius: 8px; font-weight: 500; font-size: 14px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border: none; cursor: pointer; transition: all 0.3s ease;"
                                            onmouseover="this.style.backgroundColor='#7c3aed'"
                                            onmouseout="this.style.backgroundColor='#9333ea'">
                                        👗 Style Guide
                                    </button>
                                    <button type="button" onclick="generateSpecificBlogType('trend_analysis')"
                                            style="background-color: #ea580c !important; color: white !important; padding: 12px 16px; border-radius: 8px; font-weight: 500; font-size: 14px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); border: none; cursor: pointer; transition: all 0.3s ease;"
                                            onmouseover="this.style.backgroundColor='#dc2626'"
                                            onmouseout="this.style.backgroundColor='#ea580c'">
                                        📈 Trend Analysis
                                    </button>
                                </div>
                                <div class="text-center">
                                    <button type="button" id="auto-generate-btn" onclick="autoGenerateBlogContent()"
                                            style="width: 100%; background: linear-gradient(135deg, #374151 0%, #1f2937 100%) !important; color: white !important; padding: 12px 24px; border-radius: 8px; font-weight: 600; font-size: 16px; display: flex; align-items: center; justify-content: center; border: 2px solid #4b5563; cursor: pointer; box-shadow: 0 8px 20px rgba(0,0,0,0.2); transition: all 0.3s ease;"
                                            onmouseover="this.style.background='linear-gradient(135deg, #4b5563 0%, #374151 100%)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 12px 25px rgba(0,0,0,0.3)'"
                                            onmouseout="this.style.background='linear-gradient(135deg, #374151 0%, #1f2937 100%)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.2)'">
                                        <svg style="width: 20px; height: 20px; margin-right: 8px; fill: none; stroke: currentColor; stroke-width: 2;" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        <span id="generate-text">🚀 Auto-Generate (Best Type)</span>
                                    </button>
                                </div>
                            </div>

                            <!-- Divider -->
                            <div class="flex items-center my-6">
                                <div class="flex-1 border-t border-gray-400"></div>
                                <span class="px-4 text-gray-700 font-medium bg-white">OR</span>
                                <div class="flex-1 border-t border-gray-400"></div>
                            </div>

                            <!-- Generate All Types -->
                            <div class="bg-gradient-to-br from-green-50 to-teal-50 p-6 rounded-lg border-2 border-green-300 shadow-md">
                                <h3 class="text-xl font-bold mb-3 text-center text-green-800">Generate All Blog Types</h3>
                                <p class="text-green-700 text-center mb-4 text-sm font-medium">Create comprehensive blog coverage with all 4 blog types for this product</p>
                                <button type="button" onclick="generateAllBlogTypes()"
                                        style="width: 100%; background: linear-gradient(135deg, #059669 0%, #0d9488 100%) !important; color: white !important; padding: 16px 24px; border-radius: 8px; font-weight: 700; font-size: 18px; display: flex; align-items: center; justify-content: center; border: 2px solid #10b981; cursor: pointer; box-shadow: 0 10px 25px rgba(0,0,0,0.2); transition: all 0.3s ease;"
                                        onmouseover="this.style.background='linear-gradient(135deg, #047857 0%, #0f766e 100%)'; this.style.transform='scale(1.05)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.3)'"
                                        onmouseout="this.style.background='linear-gradient(135deg, #059669 0%, #0d9488 100%)'; this.style.transform='scale(1)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.2)'">
                                    <svg style="width: 24px; height: 24px; margin-right: 8px; fill: none; stroke: currentColor; stroke-width: 2;" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    🎯 Generate All 4 Blog Types
                                </button>
                                <p class="text-sm text-green-800 text-center mt-3 font-medium">Creates: Product Review, Buying Guide, Style Guide, and Trend Analysis</p>
                            </div>
                        </div>

                        <div id="generation-progress" class="hidden mt-6">
                            <div class="flex items-center justify-center space-x-2 text-purple-600 mb-3">
                                <div class="animate-spin rounded-full h-5 w-5 border-b-2 border-purple-600"></div>
                                <span id="progress-text">Analyzing product and generating content...</span>
                            </div>
                            <div class="bg-gray-200 rounded-full h-2">
                                <div id="progress-bar" class="bg-gradient-to-r from-purple-600 to-blue-600 h-2 rounded-full transition-all duration-500" style="width: 0%"></div>
                            </div>
                        </div>

                        <div class="mt-6 p-4 bg-gradient-to-r from-purple-50 to-blue-50 rounded-lg">
                            <p class="text-sm font-medium text-gray-700 mb-2">✨ AI will automatically handle:</p>
                            <div class="grid grid-cols-2 gap-2 text-xs text-gray-600">
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Blog type selection
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    SEO optimization
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Keyword research
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Content creation
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Category assignment
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Meta descriptions
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Tag suggestions
                                </div>
                                <div class="flex items-center">
                                    <svg class="w-3 h-3 text-green-500 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Ready to publish
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                    <!-- Title Suggestions -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <button onclick="generateTitles()" class="text-purple-600 hover:text-purple-800 text-sm font-medium">
                            Generate Title Suggestions
                        </button>
                        <div id="title-suggestions" class="mt-3 space-y-2"></div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Generated Content Preview -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-semibold text-gray-900">Generated Content</h2>
                        <div id="generation-status" class="hidden">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Generating...
                            </span>
                        </div>
                    </div>

                    <div id="content-preview" class="min-h-96">
                        @if(!$product)
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Select a Product</h3>
                                <p class="mt-1 text-sm text-gray-500">Choose a product to start generating AI-powered blog content.</p>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Ready to Generate</h3>
                                <p class="mt-1 text-sm text-gray-500">Configure your settings and click "Generate Blog Post" to create AI-powered content.</p>
                            </div>
                        @endif
                    </div>

                    <!-- Generated Content Form -->
                    <div id="generated-content-form" class="hidden">
                        <form id="save-blog-form">
                            <div class="space-y-6">
                                <!-- Title -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                                    <input type="text" name="title" id="generated-title" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                </div>

                                <!-- Excerpt -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Excerpt</label>
                                    <textarea name="excerpt" id="generated-excerpt" rows="3" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>

                                <!-- Content -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                                    <textarea name="content" id="generated-content" rows="20" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>

                                <!-- SEO Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">SEO Title</label>
                                        <input type="text" name="seo_title" id="generated-seo-title" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">SEO Keywords</label>
                                        <input type="text" name="seo_keywords" id="generated-seo-keywords" 
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">SEO Description</label>
                                    <textarea name="seo_description" id="generated-seo-description" rows="2" 
                                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                                </div>

                                <!-- Tags -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                                    <div id="suggested-tags" class="flex flex-wrap gap-2 mb-2"></div>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="draft">Save as Draft</option>
                                        <option value="published">Publish Immediately</option>
                                    </select>
                                </div>

                                <!-- Hidden Fields -->
                                <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">
                                <input type="hidden" name="ai_generated" value="1">
                                <input type="hidden" name="ai_prompt" id="ai-prompt">
                                <input type="hidden" name="ai_metadata" id="ai-metadata">
                                <input type="hidden" name="featured_image" id="featured-image">
                                <input type="hidden" name="blog_category_id" id="blog-category-id">
                                <input type="hidden" name="tags" id="selected-tags">

                                <!-- Save Buttons -->
                                <div class="flex space-x-4">
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium">
                                        Save Blog Post
                                    </button>
                                    <button type="button" onclick="regenerateContent()" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded-lg font-medium">
                                        Regenerate Content
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedTags = [];
        let allProducts = [];

        // Load products when page loads (only if no product is selected)
        @if(!$product)
        document.addEventListener('DOMContentLoaded', function() {
            loadProducts();
            setupProductSearch();
        });

        function loadProducts() {
            fetch('{{ route("admin.blog.ai.all-products") }}')
                .then(response => response.json())
                .then(data => {
                    allProducts = data.products || [];
                    displayProducts(allProducts);
                })
                .catch(error => {
                    console.error('Error loading products:', error);
                    document.getElementById('product-results').innerHTML =
                        '<div class="text-center py-4 text-red-500">Error loading products</div>';
                });
        }

        function setupProductSearch() {
            const searchInput = document.getElementById('product-search');
            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const query = this.value.toLowerCase();
                    const filteredProducts = allProducts.filter(product =>
                        product.name.toLowerCase().includes(query) ||
                        (product.category && product.category.name.toLowerCase().includes(query))
                    );
                    displayProducts(filteredProducts);
                });
            }
        }

        function displayProducts(products) {
            const container = document.getElementById('product-results');
            if (!container) return;

            if (products.length === 0) {
                container.innerHTML = '<div class="text-center py-4 text-gray-500">No products found</div>';
                return;
            }

            container.innerHTML = products.map(product => `
                <div class="border border-gray-200 rounded-lg p-3 hover:bg-gray-50 cursor-pointer product-item"
                     onclick="selectProduct(${product.id})">
                    <div class="flex items-center space-x-3">
                        ${product.images && product.images.length > 0 ?
                            `<img src="{{ asset('storage/') }}/${product.images[0].image_path}" alt="${product.name}"
                                  class="w-12 h-12 object-cover rounded"
                                  onerror="this.parentElement.innerHTML='<div class=\\'w-12 h-12 bg-gray-200 rounded flex items-center justify-center\\'><svg class=\\'w-6 h-6 text-gray-400\\' fill=\\'none\\' stroke=\\'currentColor\\' viewBox=\\'0 0 24 24\\'><path stroke-linecap=\\'round\\' stroke-linejoin=\\'round\\' stroke-width=\\'2\\' d=\\'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z\\'></path></svg></div>'">` :
                            `<div class="w-12 h-12 bg-gray-200 rounded flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>`
                        }
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900">${product.name}</h4>
                            <p class="text-sm text-gray-600">${product.category ? product.category.name : 'No category'}</p>
                            <p class="text-sm font-semibold text-gray-900">₹${product.price}</p>
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function selectProduct(productId) {
            window.location.href = `{{ route('admin.blog.ai.create') }}?product_id=${productId}`;
        }
        @endif

        // Auto-Generate Button Handler
        document.getElementById('auto-generate-btn')?.addEventListener('click', function(e) {
            e.preventDefault();
            autoGenerateBlogContent();
        });

        // Save Blog Form Handler
        document.getElementById('save-blog-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            saveBlogPost();
        });

        function autoGenerateBlogContent() {
            const generateBtn = document.getElementById('auto-generate-btn');
            const generateText = document.getElementById('generate-text');
            const progressDiv = document.getElementById('generation-progress');
            const progressBar = document.getElementById('progress-bar');
            const progressText = document.getElementById('progress-text');

            // Show loading state
            generateBtn.disabled = true;
            generateText.textContent = 'Generating...';
            progressDiv.classList.remove('hidden');

            // Progress simulation
            let progress = 0;
            const progressSteps = [
                { percent: 20, text: 'Analyzing product details...' },
                { percent: 40, text: 'Researching SEO keywords...' },
                { percent: 60, text: 'Generating content structure...' },
                { percent: 80, text: 'Creating engaging content...' },
                { percent: 95, text: 'Optimizing for search engines...' },
                { percent: 100, text: 'Finalizing blog post...' }
            ];

            let stepIndex = 0;
            const progressInterval = setInterval(() => {
                if (stepIndex < progressSteps.length) {
                    const step = progressSteps[stepIndex];
                    progressBar.style.width = step.percent + '%';
                    progressText.textContent = step.text;
                    stepIndex++;
                } else {
                    clearInterval(progressInterval);
                }
            }, 1000);

            // Use simple GET request (no CSRF needed)
            fetch('{{ route("admin.blog.ai.auto-generate", $product->id ?? 0) }}', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                clearInterval(progressInterval);
                progressBar.style.width = '100%';
                progressText.textContent = 'Blog post generated successfully!';

                setTimeout(() => {
                    if (data && data.success) {
                        // Show success message with links
                        const successMessage = `
                            <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                                <div class="flex items-center mb-4">
                                    <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <h3 class="text-lg font-semibold text-green-800">Blog Post Generated Successfully! 🎉</h3>
                                </div>
                                <p class="text-green-700 mb-4">Your SEO-optimized blog post has been automatically generated and published!</p>
                                <div class="flex space-x-4">
                                    <a href="${data.blog_url || '#'}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit Blog Post
                                    </a>
                                    <a href="${data.view_url || '#'}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        View Live Post
                                    </a>
                                    <a href="{{ route('admin.blog.ai.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                        </svg>
                                        Generate Another
                                    </a>
                                </div>
                            </div>
                        `;

                        // Insert success message at the top of the page
                        const container = document.querySelector('.container');
                        const firstChild = container.firstElementChild;
                        const successDiv = document.createElement('div');
                        successDiv.innerHTML = successMessage;
                        container.insertBefore(successDiv, firstChild);

                        // Scroll to top to show the success message
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    } else {
                        alert('Error: ' + (data && data.message ? data.message : 'Unknown error occurred'));
                        console.error('Generation error:', data);
                    }
                }, 1000);
            })
            .catch(error => {
                clearInterval(progressInterval);
                console.error('Error:', error);
                alert('An error occurred while generating content: ' + error.message);
            })
            .finally(() => {
                setTimeout(() => {
                    // Reset button state
                    generateBtn.disabled = false;
                    generateText.textContent = 'Generate Complete Blog Post';
                    progressDiv.classList.add('hidden');
                    progressBar.style.width = '0%';
                }, 2000);
            });
        }

        function showSuccessMessage(message) {
            const successDiv = document.createElement('div');
            successDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50 transform transition-all duration-300';
            successDiv.textContent = message;
            document.body.appendChild(successDiv);

            setTimeout(() => {
                successDiv.style.transform = 'translateX(100%)';
                setTimeout(() => successDiv.remove(), 300);
            }, 3000);
        }

        function populateGeneratedContent(blogData, suggestedTags) {
            if (!blogData) {
                console.error('No blog data provided to populateGeneratedContent');
                return;
            }

            // Safely populate form fields with null checks
            const setFieldValue = (id, value) => {
                const element = document.getElementById(id);
                if (element) {
                    element.value = value || '';
                }
            };

            setFieldValue('generated-title', blogData.title);
            setFieldValue('generated-excerpt', blogData.excerpt);
            setFieldValue('generated-content', blogData.content);
            setFieldValue('generated-seo-title', blogData.seo_title);
            setFieldValue('generated-seo-description', blogData.seo_description);
            setFieldValue('generated-seo-keywords', blogData.seo_keywords);
            setFieldValue('ai-prompt', JSON.stringify(blogData.ai_prompt || {}));
            setFieldValue('ai-metadata', JSON.stringify(blogData.ai_metadata || {}));
            setFieldValue('featured-image', blogData.featured_image);
            setFieldValue('blog-category-id', blogData.blog_category_id);

            // Populate suggested tags
            const tagsContainer = document.getElementById('suggested-tags');
            if (tagsContainer) {
                tagsContainer.innerHTML = '';
                selectedTags = Array.isArray(suggestedTags) ? suggestedTags : [];

                selectedTags.forEach(tagId => {
                    if (tagId) {
                        const tagElement = document.createElement('span');
                        tagElement.className = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
                        tagElement.innerHTML = `Tag ${tagId} <button type="button" onclick="removeTag(${tagId})" class="ml-1 text-blue-600 hover:text-blue-800">×</button>`;
                        tagsContainer.appendChild(tagElement);
                    }
                });
            }

            const selectedTagsElement = document.getElementById('selected-tags');
            if (selectedTagsElement) {
                selectedTagsElement.value = JSON.stringify(selectedTags);
            }
        }

        function removeTag(tagId) {
            selectedTags = selectedTags.filter(id => id !== tagId);
            document.getElementById('selected-tags').value = JSON.stringify(selectedTags);
            // Refresh tags display
            populateGeneratedContent({}, selectedTags);
        }

        function saveBlogPost() {
            const form = document.getElementById('save-blog-form');
            const formData = new FormData(form);

            fetch('{{ route("admin.blog.ai.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    if (data.redirect_url) {
                        window.location.href = data.redirect_url;
                    }
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while saving the blog post.');
            });
        }

        function regenerateContent() {
            if (confirm('Are you sure you want to regenerate the content? This will replace the current content.')) {
                generateBlogContent();
            }
        }

        function generateTitles() {
            const productId = '{{ $product->id ?? "" }}';
            if (!productId) return;

            fetch('{{ route("admin.blog.ai.generate-titles") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.titles.length > 0) {
                    const container = document.getElementById('title-suggestions');
                    container.innerHTML = '';
                    
                    data.titles.forEach(title => {
                        const titleElement = document.createElement('div');
                        titleElement.className = 'p-2 bg-gray-50 rounded cursor-pointer hover:bg-gray-100';
                        titleElement.textContent = title;
                        titleElement.onclick = () => {
                            document.getElementById('generated-title').value = title;
                        };
                        container.appendChild(titleElement);
                    });
                } else {
                    alert('No title suggestions generated.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error generating title suggestions.');
            });
        }

        // Generate specific blog type
        function generateSpecificBlogType(blogType) {
            if (!confirm(`Generate a ${blogType.replace('_', ' ')} blog post for this product?`)) {
                return;
            }

            const productId = {{ $product->id ?? 0 }};
            const url = `{{ route('admin.blog.ai.auto-generate', ':product') }}?blog_type=${blogType}`.replace(':product', productId);

            // Show loading state
            const button = event.target;
            const originalText = button.textContent;
            button.disabled = true;
            button.textContent = 'Generating...';

            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data && data.success) {
                    showSuccessMessage(
                        data.message || 'Blog generated successfully!',
                        data.blog_url || '#',
                        data.view_url || '#'
                    );
                } else {
                    alert('Error: ' + (data && data.message ? data.message : 'Unknown error occurred'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error: ' + error.message);
            })
            .finally(() => {
                button.disabled = false;
                button.textContent = originalText;
            });
        }

        // Generate all blog types
        function generateAllBlogTypes() {
            if (!confirm('Generate all 4 blog types for this product? This will create: Product Review, Buying Guide, Style Guide, and Trend Analysis.')) {
                return;
            }

            const productId = {{ $product->id ?? 0 }};
            const url = `{{ route('admin.blog.ai.generate-all-types', ':product') }}`.replace(':product', productId);

            // Show loading state
            const button = event.target;
            const originalText = button.innerHTML;
            button.disabled = true;
            button.innerHTML = '<div class="animate-spin rounded-full h-5 w-5 border-b-2 border-white inline-block mr-2"></div>Generating All Types...';

            // Show initial message
            alert('Starting bulk blog generation! This may take 2-3 minutes. Please wait...');

            // Use a longer timeout for bulk generation
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 300000); // 5 minutes timeout

            fetch(url, {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: controller.signal
            })
            .then(response => {
                clearTimeout(timeoutId);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.text().then(text => {
                    try {
                        return JSON.parse(text);
                    } catch (e) {
                        console.error('Response is not valid JSON:', text);
                        throw new Error('Server returned invalid response. This usually means the generation is taking longer than expected. Please check your blog list in a few minutes.');
                    }
                });
            })
            .then(data => {
                if (data && data.success) {
                    let message = 'Blog generation completed!\n\n';
                    if (data.generated_blogs && Array.isArray(data.generated_blogs) && data.generated_blogs.length > 0) {
                        data.generated_blogs.forEach(blog => {
                            if (blog && blog.message) {
                                message += `✅ ${blog.message}\n`;
                            }
                        });
                    }
                    if (data.errors && Array.isArray(data.errors) && data.errors.length > 0) {
                        message += '\nErrors:\n';
                        data.errors.forEach(error => {
                            if (error && error.blog_type && error.error) {
                                message += `❌ ${error.blog_type}: ${error.error}\n`;
                            }
                        });
                    }
                    alert(message);

                    // Refresh the page to show updated blog list
                    window.location.reload();
                } else {
                    alert('Error: ' + (data && data.message ? data.message : 'Unknown error occurred'));
                }
            })
            .catch(error => {
                clearTimeout(timeoutId);
                console.error('Error:', error);
                if (error.name === 'AbortError') {
                    alert('Blog generation is taking longer than expected. The process may still be running in the background. Please check your blog list in a few minutes.');
                } else {
                    alert('Error: ' + error.message);
                }
            })
            .finally(() => {
                button.disabled = false;
                button.innerHTML = originalText;
            });
        }
    </script>
</x-layouts.admin>
