<x-layouts.admin>
    <x-slot name="title">AI Blog Generator - Create</x-slot>

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
                                <img src="{{ $product->images[0]['image_path'] }}" alt="{{ $product->name }}" 
                                     class="w-full h-32 object-cover rounded-lg mb-3">
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
                        </div>
                    @endif
                </div>

                @if($product)
                <!-- AI Generation Settings -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Generation Settings</h2>
                    
                    <form id="ai-generation-form">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <!-- Blog Type -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Blog Type</label>
                            <select name="blog_type" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                @foreach($blogTypes as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Category -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Blog Category</label>
                            <select name="blog_category_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Target Keywords -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Target Keywords</label>
                            <input type="text" name="target_keywords" placeholder="keyword1, keyword2, keyword3" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            <p class="text-xs text-gray-500 mt-1">Separate keywords with commas</p>
                        </div>

                        <!-- Tone -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Writing Tone</label>
                            <select name="tone" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option value="professional">Professional</option>
                                <option value="casual">Casual</option>
                                <option value="friendly">Friendly</option>
                                <option value="authoritative">Authoritative</option>
                            </select>
                        </div>

                        <!-- Word Count -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Word Count</label>
                            <select name="word_count" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                <option value="800">800 words (Short)</option>
                                <option value="1200">1200 words (Medium)</option>
                                <option value="1500" selected>1500 words (Long)</option>
                                <option value="2000">2000 words (Detailed)</option>
                            </select>
                        </div>

                        <!-- Generate Button -->
                        <button type="submit" id="generate-btn" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-lg font-medium flex items-center justify-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Generate Blog Post
                        </button>
                    </form>

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

        // AI Generation Form Handler
        document.getElementById('ai-generation-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            generateBlogContent();
        });

        // Save Blog Form Handler
        document.getElementById('save-blog-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            saveBlogPost();
        });

        function generateBlogContent() {
            const form = document.getElementById('ai-generation-form');
            const formData = new FormData(form);
            const generateBtn = document.getElementById('generate-btn');
            const statusDiv = document.getElementById('generation-status');
            const previewDiv = document.getElementById('content-preview');

            // Show loading state
            generateBtn.disabled = true;
            generateBtn.innerHTML = `
                <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Generating...
            `;
            statusDiv.classList.remove('hidden');

            fetch('{{ route("admin.blog.ai.generate") }}', {
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
                    populateGeneratedContent(data.blog_data, data.suggested_tags);
                    document.getElementById('generated-content-form').classList.remove('hidden');
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while generating content.');
            })
            .finally(() => {
                // Reset button state
                generateBtn.disabled = false;
                generateBtn.innerHTML = `
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Generate Blog Post
                `;
                statusDiv.classList.add('hidden');
            });
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
