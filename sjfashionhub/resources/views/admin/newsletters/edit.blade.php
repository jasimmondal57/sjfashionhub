<x-layouts.admin title="Edit Newsletter Section" description="Edit newsletter signup section">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-white">Edit Newsletter Section</h1>
                <p class="text-gray-300">Update newsletter signup section settings</p>
            </div>
            <div class="flex items-center space-x-3">
                <a href="{{ route('admin.newsletters.show', $newsletter) }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View
                </a>
                <a href="{{ route('admin.newsletters.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Newsletter
                </a>
            </div>
        </div>

        <!-- Form -->
        <form action="{{ route('admin.newsletters.update', $newsletter) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-white mb-4">Basic Information</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-300 mb-2">Title *</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $newsletter->title) }}" 
                                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="Stay Updated with Our Latest News" required>
                                @error('title')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="subtitle" class="block text-sm font-medium text-gray-300 mb-2">Subtitle</label>
                                <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $newsletter->subtitle) }}" 
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
                                          placeholder="Subscribe to our newsletter to receive the latest updates, exclusive offers, and fashion trends directly in your inbox.">{{ old('description', $newsletter->description) }}</textarea>
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
                                <input type="text" name="placeholder_text" id="placeholder_text" value="{{ old('placeholder_text', $newsletter->placeholder_text) }}" 
                                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('placeholder_text')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="button_text" class="block text-sm font-medium text-gray-300 mb-2">Button Text *</label>
                                <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $newsletter->button_text) }}" 
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
                                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $newsletter->sort_order) }}" min="0"
                                       class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                @error('sort_order')
                                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-400">Lower numbers appear first</p>
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $newsletter->is_active) ? 'checked' : '' }}
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
                                    <input type="color" name="background_color" id="background_color" value="{{ old('background_color', $newsletter->background_color) }}" 
                                           class="h-10 w-16 rounded border border-gray-600 bg-gray-700">
                                    <input type="text" value="{{ old('background_color', $newsletter->background_color) }}" 
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
                                    <input type="color" name="text_color" id="text_color" value="{{ old('text_color', $newsletter->text_color) }}" 
                                           class="h-10 w-16 rounded border border-gray-600 bg-gray-700">
                                    <input type="text" value="{{ old('text_color', $newsletter->text_color) }}" 
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
                                    <input type="color" name="button_color" id="button_color" value="{{ old('button_color', $newsletter->button_color) }}" 
                                           class="h-10 w-16 rounded border border-gray-600 bg-gray-700">
                                    <input type="text" value="{{ old('button_color', $newsletter->button_color) }}" 
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
                                    <input type="color" name="button_text_color" id="button_text_color" value="{{ old('button_text_color', $newsletter->button_text_color) }}" 
                                           class="h-10 w-16 rounded border border-gray-600 bg-gray-700">
                                    <input type="text" value="{{ old('button_text_color', $newsletter->button_text_color) }}" 
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
                                <input type="checkbox" name="show_social_links" id="show_social_links" value="1" {{ old('show_social_links', $newsletter->show_social_links) ? 'checked' : '' }}
                                       class="h-4 w-4 text-blue-600 bg-gray-700 border-gray-600 rounded focus:ring-blue-500 focus:ring-2">
                                <label for="show_social_links" class="ml-2 text-sm text-gray-300">Show Social Links</label>
                            </div>
                        </div>
                        
                        <div id="social-links-container" class="space-y-3" style="display: {{ old('show_social_links', $newsletter->show_social_links) ? 'block' : 'none' }};">
                            @if(old('social_links', $newsletter->social_links))
                                @foreach(old('social_links', $newsletter->social_links) as $index => $link)
                                <div class="social-link-item">
                                    <div class="grid grid-cols-3 gap-2">
                                        <select name="social_links[{{ $index }}][platform]" class="px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white text-sm">
                                            <option value="">Select Platform</option>
                                            <option value="facebook" {{ ($link['platform'] ?? '') == 'facebook' ? 'selected' : '' }}>Facebook</option>
                                            <option value="twitter" {{ ($link['platform'] ?? '') == 'twitter' ? 'selected' : '' }}>Twitter</option>
                                            <option value="instagram" {{ ($link['platform'] ?? '') == 'instagram' ? 'selected' : '' }}>Instagram</option>
                                            <option value="linkedin" {{ ($link['platform'] ?? '') == 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                                            <option value="youtube" {{ ($link['platform'] ?? '') == 'youtube' ? 'selected' : '' }}>YouTube</option>
                                            <option value="tiktok" {{ ($link['platform'] ?? '') == 'tiktok' ? 'selected' : '' }}>TikTok</option>
                                        </select>
                                        <input type="url" name="social_links[{{ $index }}][url]" value="{{ $link['url'] ?? '' }}" 
                                               placeholder="https://..." 
                                               class="px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white text-sm placeholder-gray-400">
                                        <button type="button" onclick="removeSocialLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">Remove</button>
                                    </div>
                                </div>
                                @endforeach
                            @else
                                <div class="social-link-item">
                                    <div class="grid grid-cols-3 gap-2">
                                        <select name="social_links[0][platform]" class="px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white text-sm">
                                            <option value="">Select Platform</option>
                                            <option value="facebook">Facebook</option>
                                            <option value="twitter">Twitter</option>
                                            <option value="instagram">Instagram</option>
                                            <option value="linkedin">LinkedIn</option>
                                            <option value="youtube">YouTube</option>
                                            <option value="tiktok">TikTok</option>
                                        </select>
                                        <input type="url" name="social_links[0][url]" placeholder="https://..." 
                                               class="px-3 py-2 bg-gray-700 border border-gray-600 rounded-md text-white text-sm placeholder-gray-400">
                                        <button type="button" onclick="removeSocialLink(this)" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">Remove</button>
                                    </div>
                                </div>
                            @endif
                        </div>
                        
                        <button type="button" onclick="addSocialLink()" id="add-social-link" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm" style="display: {{ old('show_social_links', $newsletter->show_social_links) ? 'block' : 'none' }};">
                            Add Social Link
                        </button>
                    </div>

                    <!-- Preview -->
                    <div class="bg-gray-800 rounded-lg p-6">
                        <h3 class="text-lg font-medium text-white mb-4">Preview</h3>
                        <div id="newsletter-preview" class="border border-gray-600 rounded-lg p-4" style="background-color: {{ $newsletter->background_color }};">
                            <div class="text-center">
                                <h4 id="preview-title" class="text-xl font-bold mb-2" style="color: {{ $newsletter->text_color }};">{{ $newsletter->title }}</h4>
                                <p id="preview-subtitle" class="text-sm mb-2" style="color: {{ $newsletter->text_color }};">{{ $newsletter->subtitle }}</p>
                                <p id="preview-description" class="text-sm mb-4" style="color: {{ $newsletter->text_color }};">{{ $newsletter->description }}</p>
                                <div class="flex items-center space-x-2 mb-4">
                                    <input type="email" id="preview-placeholder" placeholder="{{ $newsletter->placeholder_text }}" class="flex-1 px-3 py-2 border rounded-md text-sm" readonly>
                                    <button id="preview-button" class="px-4 py-2 rounded-md text-sm font-medium" style="background-color: {{ $newsletter->button_color }}; color: {{ $newsletter->button_text_color }};">{{ $newsletter->button_text }}</button>
                                </div>
                                <div id="preview-social" class="flex justify-center space-x-3" style="display: {{ $newsletter->show_social_links ? 'flex' : 'none' }};">
                                    <span class="text-xs" style="color: {{ $newsletter->text_color }};">Follow us:</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-700">
                <a href="{{ route('admin.newsletters.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Newsletter Section</button>
            </div>
        </form>
    </div>

    <script>
        let socialLinkIndex = {{ count(old('social_links', $newsletter->social_links ?? [])) }};

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
            const title = document.getElementById('title').value || '{{ $newsletter->title }}';
            const subtitle = document.getElementById('subtitle').value || '{{ $newsletter->subtitle }}';
            const description = document.getElementById('description').value || '{{ $newsletter->description }}';
            const placeholder = document.getElementById('placeholder_text').value || '{{ $newsletter->placeholder_text }}';
            const buttonText = document.getElementById('button_text').value || '{{ $newsletter->button_text }}';
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
