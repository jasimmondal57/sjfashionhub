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

                        <!-- Auto-Generate Button -->
                        <button type="button" id="auto-generate-btn" onclick="autoGenerateBlogContent()"
                                style="width: 100%; background: linear-gradient(135deg, #1f2937 0%, #111827 100%); color: white; padding: 16px 32px; border-radius: 12px; font-weight: 600; font-size: 18px; display: flex; align-items: center; justify-content: center; border: none; cursor: pointer; box-shadow: 0 10px 25px rgba(0,0,0,0.2); transition: all 0.3s ease; min-height: 64px;"
                                onmouseover="this.style.background='linear-gradient(135deg, #374151 0%, #1f2937 100%)'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.3)'"
                                onmouseout="this.style.background='linear-gradient(135deg, #1f2937 0%, #111827 100%)'; this.style.transform='translateY(0)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.2)'">
                            <svg style="width: 24px; height: 24px; margin-right: 12px; fill: none; stroke: currentColor; stroke-width: 2;" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span id="generate-text">🚀 Generate Complete Blog Post</span>
                        </button>

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

            // Get CSRF token from meta tag or fallback
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

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

            // Create automated form data
            const formData = new FormData();
            formData.append('product_id', '{{ $product->id ?? "" }}');
            formData.append('auto_generate', 'true');
            formData.append('_token', csrfToken);

            fetch('{{ route("admin.blog.ai.generate") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData
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
                    if (data.success) {
                        populateGeneratedContent(data.blog_data, data.suggested_tags);
                        document.getElementById('generated-content-form').classList.remove('hidden');

                        // Show success message
                        showSuccessMessage('✨ Your SEO-optimized blog post has been generated automatically!');
                    } else {
                        alert('Error: ' + (data.message || 'Unknown error occurred'));
                        console.error('Generation error:', data);
                    }
                }, 1000);
            })
            .catch(error => {
                clearInterval(progressInterval);
                console.error('Error:', error);
                alert('An error occurred while generating content.');
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
            document.getElementById('generated-title').value = blogData.title || '';
            document.getElementById('generated-excerpt').value = blogData.excerpt || '';
            document.getElementById('generated-content').value = blogData.content || '';
            document.getElementById('generated-seo-title').value = blogData.seo_title || '';
            document.getElementById('generated-seo-description').value = blogData.seo_description || '';
            document.getElementById('generated-seo-keywords').value = blogData.seo_keywords || '';
            
            // Set hidden fields
            document.getElementById('ai-prompt').value = JSON.stringify(blogData.ai_prompt || {});
            document.getElementById('ai-metadata').value = JSON.stringify(blogData.ai_metadata || {});
            document.getElementById('featured-image').value = blogData.featured_image || '';
            document.getElementById('blog-category-id').value = blogData.blog_category_id || '';

            // Populate suggested tags
            const tagsContainer = document.getElementById('suggested-tags');
            tagsContainer.innerHTML = '';
            selectedTags = suggestedTags || [];
            
            selectedTags.forEach(tagId => {
                const tagElement = document.createElement('span');
                tagElement.className = 'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800';
                tagElement.innerHTML = `Tag ${tagId} <button type="button" onclick="removeTag(${tagId})" class="ml-1 text-blue-600 hover:text-blue-800">×</button>`;
                tagsContainer.appendChild(tagElement);
            });

            document.getElementById('selected-tags').value = JSON.stringify(selectedTags);
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
    </script>
</x-layouts.admin>
