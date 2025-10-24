<x-layouts.admin title="Create Newsletter Section" description="Create a new newsletter signup section">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">Create Newsletter Section</h1>
                <p class="text-gray-300">Create a customizable newsletter signup section for your website</p>
            </div>
            <a href="{{ route('admin.newsletters.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Newsletter
            </a>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.newsletters.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-white mb-4">Basic Information</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Title *</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" 
                                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Stay Updated with Our Latest News" required>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="subtitle" class="block text-sm font-medium text-gray-300 mb-2">Subtitle</label>
                                <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle') }}" 
                                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Get exclusive offers and updates">
                                @error('subtitle')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-medium text-gray-300 mb-2">Description</label>
                                <textarea name="description" id="description" rows="3" 
                                          class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Subscribe to our newsletter to receive the latest updates, exclusive offers, and fashion trends directly in your inbox.">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Settings -->
                    <div class="bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-white mb-4">Form Settings</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="placeholder_text" class="block text-sm font-medium text-gray-300 mb-2">Email Placeholder Text *</label>
                                <input type="text" name="placeholder_text" id="placeholder_text" value="{{ old('placeholder_text', 'Enter your email address') }}" 
                                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('placeholder_text')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="button_text" class="block text-sm font-medium text-gray-300 mb-2">Button Text *</label>
                                <input type="text" name="button_text" id="button_text" value="{{ old('button_text', 'Subscribe') }}" 
                                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('button_text')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Settings -->
                    <div class="bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-white mb-4">Settings</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="sort_order" class="block text-sm font-medium text-gray-300 mb-2">Sort Order</label>
                                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('sort_order')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-400">Lower numbers appear first</p>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="is_active" class="ml-2 text-sm text-gray-300">Active</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Color Settings -->
                    <div class="bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-white mb-4">Color Settings</h3>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="background_color" class="block text-sm font-medium text-gray-300 mb-2">Background Color</label>
                                <div class="flex items-center space-x-2">
                                    <input type="color" name="background_color" id="background_color" value="{{ old('background_color', '#f9fafb') }}" 
                                           class="h-10 w-16 rounded border border-gray-600 bg-gray-700">
                                    <input type="text" value="{{ old('background_color', '#f9fafb') }}" 
                                           class="flex-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white text-sm"
                                           readonly>
                                </div>
                                @error('background_color')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="text_color" class="block text-sm font-medium text-gray-300 mb-2">Text Color</label>
                                <div class="flex items-center space-x-2">
                                    <input type="color" name="text_color" id="text_color" value="{{ old('text_color', '#000000') }}" 
                                           class="h-10 w-16 rounded border border-gray-600 bg-gray-700">
                                    <input type="text" value="{{ old('text_color', '#000000') }}" 
                                           class="flex-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white text-sm"
                                           readonly>
                                </div>
                                @error('text_color')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="button_color" class="block text-sm font-medium text-gray-300 mb-2">Button Color</label>
                                <div class="flex items-center space-x-2">
                                    <input type="color" name="button_color" id="button_color" value="{{ old('button_color', '#000000') }}" 
                                           class="h-10 w-16 rounded border border-gray-600 bg-gray-700">
                                    <input type="text" value="{{ old('button_color', '#000000') }}" 
                                           class="flex-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white text-sm"
                                           readonly>
                                </div>
                                @error('button_color')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="button_text_color" class="block text-sm font-medium text-gray-300 mb-2">Button Text Color</label>
                                <div class="flex items-center space-x-2">
                                    <input type="color" name="button_text_color" id="button_text_color" value="{{ old('button_text_color', '#ffffff') }}" 
                                           class="h-10 w-16 rounded border border-gray-600 bg-gray-700">
                                    <input type="text" value="{{ old('button_text_color', '#ffffff') }}" 
                                           class="flex-1 px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white text-sm"
                                           readonly>
                                </div>
                                @error('button_text_color')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Social Links -->
                    <div class="bg-gray-800 rounded-lg p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-medium text-white">Social Links</h3>
                            <div class="flex items-center">
                                <input type="checkbox" name="show_social_links" id="show_social_links" value="1" {{ old('show_social_links') ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="show_social_links" class="ml-2 text-sm text-gray-300">Show Social Links</label>
                            </div>
                        </div>
                        
                        <div id="social-links-container" class="space-y-3" style="display: {{ old('show_social_links') ? 'block' : 'none' }};">
                            <div class="social-link-item">
                                <div class="grid grid-cols-3 gap-2">
                                    <select name="social_links[0][platform]" class="px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white text-sm">
                                        <option value="">Select Platform</option>
                                        <option value="facebook" {{ old('social_links.0.platform') == 'facebook' ? 'selected' : '' }}>Facebook</option>
                                        <option value="twitter" {{ old('social_links.0.platform') == 'twitter' ? 'selected' : '' }}>Twitter</option>
                                        <option value="instagram" {{ old('social_links.0.platform') == 'instagram' ? 'selected' : '' }}>Instagram</option>
                                        <option value="linkedin" {{ old('social_links.0.platform') == 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                                        <option value="youtube" {{ old('social_links.0.platform') == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                        <option value="tiktok" {{ old('social_links.0.platform') == 'tiktok' ? 'selected' : '' }}>TikTok</option>
                                    </select>
                                    <input type="url" name="social_links[0][url]" value="{{ old('social_links.0.url') }}" 
                                           placeholder="https://..." 
                                           class="px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white text-sm placeholder-gray-400">
                                    <button type="button" onclick="removeSocialLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">Remove</button>
                                </div>
                            </div>
                        </div>
                        
                        <button type="button" onclick="addSocialLink()" id="add-social-link" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm" style="display: {{ old('show_social_links') ? 'block' : 'none' }};">
                            Add Social Link
                        </button>
                    </div>

                    <!-- Preview -->
                    <div class="bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-white mb-4">Preview</h3>
                        <div id="newsletter-preview" class="border border-gray-600 rounded-lg p-4" style="background-color: #f9fafb;">
                            <div class="text-center">
                                <h4 id="preview-title" class="text-xl font-bold mb-2" style="color: #000000;">Stay Updated with Our Latest News</h4>
                                <p id="preview-subtitle" class="text-sm mb-2" style="color: #000000;">Get exclusive offers and updates</p>
                                <p id="preview-description" class="text-sm mb-4" style="color: #000000;">Subscribe to our newsletter to receive the latest updates, exclusive offers, and fashion trends directly in your inbox.</p>
                                <div class="flex items-center space-x-2 mb-4">
                                    <input type="email" id="preview-placeholder" placeholder="Enter your email address" class="flex-1 px-3 py-2 border rounded-md text-sm" readonly>
                                    <button id="preview-button" class="px-4 py-2 rounded-md text-sm font-medium" style="background-color: #000000; color: #ffffff;">Subscribe</button>
                                </div>
                                <div id="preview-social" class="flex justify-center space-x-3" style="display: none;">
                                    <span class="text-xs" style="color: #000000;">Follow us:</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-700">
                <a href="{{ route('admin.newsletters.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Newsletter Section</button>
            </div>
        </form>
    </div>

    <script>
        let socialLinkIndex = 1;

        // Color picker sync
        document.querySelectorAll('input[type="color"]').forEach(colorInput => {
            const textInput = colorInput.nextElementSibling;
            colorInput.addEventListener('input', function() {
                textInput.value = this.value;
                updatePreview();
            });
        });

        // Show/hide social links
        document.getElementById('show_social_links').addEventListener('change', function() {
            const container = document.getElementById('social-links-container');
            const addButton = document.getElementById('add-social-link');
            if (this.checked) {
                container.style.display = 'block';
                addButton.style.display = 'block';
            } else {
                container.style.display = 'none';
                addButton.style.display = 'none';
            }
            updatePreview();
        });

        // Add social link
        function addSocialLink() {
            const container = document.getElementById('social-links-container');
            const newLink = document.createElement('div');
            newLink.className = 'social-link-item';
            newLink.innerHTML = `
                <div class="grid grid-cols-3 gap-2">
                    <select name="social_links[${socialLinkIndex}][platform]" class="px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white text-sm">
                        <option value="">Select Platform</option>
                        <option value="facebook">Facebook</option>
                        <option value="twitter">Twitter</option>
                        <option value="instagram">Instagram</option>
                        <option value="linkedin">LinkedIn</option>
                        <option value="youtube">YouTube</option>
                        <option value="tiktok">TikTok</option>
                    </select>
                    <input type="url" name="social_links[${socialLinkIndex}][url]" placeholder="https://..." 
                           class="px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white text-sm placeholder-gray-400">
                    <button type="button" onclick="removeSocialLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">Remove</button>
                </div>
            `;
            container.appendChild(newLink);
            socialLinkIndex++;
        }

        // Remove social link
        function removeSocialLink(button) {
            button.closest('.social-link-item').remove();
        }

        // Update preview
        function updatePreview() {
            const preview = document.getElementById('newsletter-preview');
            const title = document.getElementById('title').value || 'Stay Updated with Our Latest News';
            const subtitle = document.getElementById('subtitle').value || 'Get exclusive offers and updates';
            const description = document.getElementById('description').value || 'Subscribe to our newsletter to receive the latest updates, exclusive offers, and fashion trends directly in your inbox.';
            const placeholder = document.getElementById('placeholder_text').value || 'Enter your email address';
            const buttonText = document.getElementById('button_text').value || 'Subscribe';
            const bgColor = document.getElementById('background_color').value;
            const textColor = document.getElementById('text_color').value;
            const buttonColor = document.getElementById('button_color').value;
            const buttonTextColor = document.getElementById('button_text_color').value;
            const showSocial = document.getElementById('show_social_links').checked;

            preview.style.backgroundColor = bgColor;
            document.getElementById('preview-title').textContent = title;
            document.getElementById('preview-title').style.color = textColor;
            document.getElementById('preview-subtitle').textContent = subtitle;
            document.getElementById('preview-subtitle').style.color = textColor;
            document.getElementById('preview-description').textContent = description;
            document.getElementById('preview-description').style.color = textColor;
            document.getElementById('preview-placeholder').placeholder = placeholder;
            document.getElementById('preview-button').textContent = buttonText;
            document.getElementById('preview-button').style.backgroundColor = buttonColor;
            document.getElementById('preview-button').style.color = buttonTextColor;
            document.getElementById('preview-social').style.display = showSocial ? 'flex' : 'none';
            
            if (showSocial) {
                document.querySelector('#preview-social span').style.color = textColor;
            }
        }

        // Add event listeners for real-time preview
        ['title', 'subtitle', 'description', 'placeholder_text', 'button_text'].forEach(id => {
            document.getElementById(id).addEventListener('input', updatePreview);
        });

        // Initial preview update
        updatePreview();
    </script>
</x-layouts.admin>
