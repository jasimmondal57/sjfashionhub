<x-layouts.admin>
    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex items-center mb-6">
            <a href="{{ route('admin.pages.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create New Page</h1>
                <p class="text-gray-600">Add a new static page to your website</p>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.pages.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid lg:grid-cols-3 gap-6">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Basic Information</h2>
                        
                        <div class="space-y-4">
                            <!-- Title -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Page Title *</label>
                                <input type="text" id="title" name="title" value="{{ old('title') }}" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror" 
                                       required>
                                @error('title')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Slug -->
                            <div>
                                <label for="slug" class="block text-sm font-medium text-gray-700 mb-2">URL Slug</label>
                                <div class="flex">
                                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                                        {{ url('/') }}/
                                    </span>
                                    <input type="text" id="slug" name="slug" value="{{ old('slug') }}" 
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-r-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('slug') border-red-500 @enderror"
                                           placeholder="auto-generated-from-title">
                                </div>
                                <p class="text-gray-500 text-sm mt-1">Leave empty to auto-generate from title</p>
                                @error('slug')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Page Type -->
                            <div>
                                <label for="page_type" class="block text-sm font-medium text-gray-700 mb-2">Page Type *</label>
                                <select id="page_type" name="page_type" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('page_type') border-red-500 @enderror" 
                                        required>
                                    <option value="">Select page type</option>
                                    <option value="custom" {{ old('page_type') === 'custom' ? 'selected' : '' }}>Custom Page</option>
                                    <option value="about" {{ old('page_type') === 'about' ? 'selected' : '' }}>About Us</option>
                                    <option value="contact" {{ old('page_type') === 'contact' ? 'selected' : '' }}>Contact Us</option>
                                    <option value="privacy" {{ old('page_type') === 'privacy' ? 'selected' : '' }}>Privacy Policy</option>
                                    <option value="terms" {{ old('page_type') === 'terms' ? 'selected' : '' }}>Terms of Service</option>
                                    <option value="shipping" {{ old('page_type') === 'shipping' ? 'selected' : '' }}>Shipping Policy</option>
                                    <option value="returns" {{ old('page_type') === 'returns' ? 'selected' : '' }}>Return Policy</option>
                                    <option value="faq" {{ old('page_type') === 'faq' ? 'selected' : '' }}>FAQ</option>
                                </select>
                                @error('page_type')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Page Content</h2>
                        
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                            <textarea id="content" name="content" rows="15" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content') border-red-500 @enderror" 
                                      required>{{ old('content') }}</textarea>
                            <p class="text-gray-500 text-sm mt-1">You can use HTML tags for formatting</p>
                            @error('content')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Publish Settings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Publish Settings</h2>
                        
                        <div class="space-y-4">
                            <!-- Status -->
                            <div>
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }}
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700">Publish page (make it live)</span>
                                </label>
                            </div>

                            <!-- Sort Order -->
                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" 
                                       min="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <p class="text-gray-500 text-sm mt-1">Lower numbers appear first</p>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Settings -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">SEO Settings</h2>
                        
                        <div class="space-y-4">
                            <!-- SEO Title -->
                            <div>
                                <label for="seo_title" class="block text-sm font-medium text-gray-700 mb-2">SEO Title</label>
                                <input type="text" id="seo_title" name="seo_title" value="{{ old('seo_title') }}" 
                                       maxlength="60" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <p class="text-gray-500 text-sm mt-1">Recommended: 50-60 characters</p>
                            </div>

                            <!-- Meta Description -->
                            <div>
                                <label for="meta_description" class="block text-sm font-medium text-gray-700 mb-2">Meta Description</label>
                                <textarea id="meta_description" name="meta_description" rows="3" 
                                          maxlength="160" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">{{ old('meta_description') }}</textarea>
                                <p class="text-gray-500 text-sm mt-1">Recommended: 150-160 characters</p>
                            </div>

                            <!-- Meta Keywords -->
                            <div>
                                <label for="meta_keywords" class="block text-sm font-medium text-gray-700 mb-2">Meta Keywords</label>
                                <input type="text" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords') }}" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <p class="text-gray-500 text-sm mt-1">Separate keywords with commas</p>
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex flex-col space-y-3">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg transition-colors">
                                <i class="fas fa-save mr-2"></i>Create Page
                            </button>
                            <a href="{{ route('admin.pages.index') }}" class="w-full bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded-lg text-center transition-colors">
                                <i class="fas fa-times mr-2"></i>Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        // Auto-generate slug from title
        document.getElementById('title').addEventListener('input', function() {
            const title = this.value;
            const slug = title.toLowerCase()
                .replace(/[^a-z0-9 -]/g, '') // Remove invalid chars
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(/-+/g, '-') // Replace multiple - with single -
                .trim('-'); // Trim - from start and end
            
            document.getElementById('slug').value = slug;
        });
    </script>
</x-layouts.admin>
