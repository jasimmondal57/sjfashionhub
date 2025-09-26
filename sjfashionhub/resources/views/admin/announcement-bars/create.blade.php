<x-layouts.admin title="Create Announcement Bar" description="Create a new announcement bar">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-black">Create Announcement Bar</h1>
                <p class="text-gray-600">Add a new announcement bar to display at the top of your website</p>
            </div>
            <a href="{{ route('admin.announcement-bars.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>

        <!-- Form -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <form action="{{ route('admin.announcement-bars.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                        Message <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="message" 
                           name="message" 
                           value="{{ old('message') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                           placeholder="Free Shipping Sitewide on Every Order, Don't Miss Out!!"
                           required>
                    @error('message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Colors -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="background_color" class="block text-sm font-medium text-gray-700 mb-2">
                            Background Color <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center space-x-3">
                            <input type="color" 
                                   id="background_color" 
                                   name="background_color" 
                                   value="{{ old('background_color', '#000000') }}"
                                   class="w-12 h-10 border border-gray-300 rounded cursor-pointer">
                            <input type="text" 
                                   id="background_color_text" 
                                   value="{{ old('background_color', '#000000') }}"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                   placeholder="#000000">
                        </div>
                        @error('background_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="text_color" class="block text-sm font-medium text-gray-700 mb-2">
                            Text Color <span class="text-red-500">*</span>
                        </label>
                        <div class="flex items-center space-x-3">
                            <input type="color" 
                                   id="text_color" 
                                   name="text_color" 
                                   value="{{ old('text_color', '#ffffff') }}"
                                   class="w-12 h-10 border border-gray-300 rounded cursor-pointer">
                            <input type="text" 
                                   id="text_color_text" 
                                   value="{{ old('text_color', '#ffffff') }}"
                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                                   placeholder="#ffffff">
                        </div>
                        @error('text_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Links Section -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Links (Optional)
                        </label>
                        <button type="button" onclick="addLink()" class="btn btn-secondary btn-sm">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Link
                        </button>
                    </div>
                    
                    <div id="links-container" class="space-y-3">
                        @if(old('links'))
                            @foreach(old('links') as $index => $link)
                                <div class="link-item flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                    <input type="text" 
                                           name="links[{{ $index }}][text]" 
                                           value="{{ $link['text'] ?? '' }}"
                                           placeholder="Link Text (e.g., About Us)"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                                    <input type="text" 
                                           name="links[{{ $index }}][url]" 
                                           value="{{ $link['url'] ?? '' }}"
                                           placeholder="URL (e.g., /about)"
                                           class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                                    <button type="button" onclick="removeLink(this)" class="text-red-600 hover:text-red-800">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <!-- Default links -->
                            <div class="link-item flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <input type="text" 
                                       name="links[0][text]" 
                                       value="About Us"
                                       placeholder="Link Text (e.g., About Us)"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                                <input type="text" 
                                       name="links[0][url]" 
                                       value="/about"
                                       placeholder="URL (e.g., /about)"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                                <button type="button" onclick="removeLink(this)" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="link-item flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <input type="text" 
                                       name="links[1][text]" 
                                       value="Contact Us"
                                       placeholder="Link Text (e.g., Contact Us)"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                                <input type="text" 
                                       name="links[1][url]" 
                                       value="/contact"
                                       placeholder="URL (e.g., /contact)"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                                <button type="button" onclick="removeLink(this)" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="link-item flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                <input type="text" 
                                       name="links[2][text]" 
                                       value="Orders Tracking"
                                       placeholder="Link Text (e.g., Orders Tracking)"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                                <input type="text" 
                                       name="links[2][url]" 
                                       value="/track-order"
                                       placeholder="URL (e.g., /track-order)"
                                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                                <button type="button" onclick="removeLink(this)" class="text-red-600 hover:text-red-800">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                        @endif
                    </div>
                    <p class="mt-2 text-sm text-gray-500">Add links that will appear alongside the announcement message</p>
                </div>

                <!-- Settings -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div>
                        <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                            Sort Order
                        </label>
                        <input type="number" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', 0) }}"
                               min="0"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                        @error('sort_order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Scrolling
                        </label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center">
                                <input type="checkbox" 
                                       name="is_scrolling" 
                                       value="1"
                                       {{ old('is_scrolling') ? 'checked' : '' }}
                                       onchange="toggleScrollSpeed()"
                                       class="rounded border-gray-300 text-black focus:ring-black">
                                <span class="ml-2 text-sm text-gray-700">Enable scrolling text</span>
                            </label>
                        </div>
                    </div>

                    <div id="scroll-speed-container" class="{{ old('is_scrolling') ? '' : 'hidden' }}">
                        <label for="scroll_speed" class="block text-sm font-medium text-gray-700 mb-2">
                            Scroll Speed (px/s)
                        </label>
                        <input type="number" 
                               id="scroll_speed" 
                               name="scroll_speed" 
                               value="{{ old('scroll_speed', 50) }}"
                               min="10"
                               max="200"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                        @error('scroll_speed')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Status -->
                <div>
                    <label class="flex items-center">
                        <input type="checkbox" 
                               name="is_active" 
                               value="1"
                               {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-black focus:ring-black">
                        <span class="ml-2 text-sm font-medium text-gray-700">Active (display on website)</span>
                    </label>
                </div>

                <!-- Preview -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Preview</label>
                    <div id="preview" class="border border-gray-300 rounded-md p-4 text-center text-white" style="background-color: #000000; color: #ffffff;">
                        <span id="preview-message">Free Shipping Sitewide on Every Order, Don't Miss Out!!</span>
                        <span id="preview-links" class="ml-4">
                            <a href="#" class="hover:underline">About Us</a>
                            <a href="#" class="ml-4 hover:underline">Contact Us</a>
                            <a href="#" class="ml-4 hover:underline">Orders Tracking</a>
                        </span>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex justify-end space-x-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('admin.announcement-bars.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Create Announcement Bar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let linkIndex = 3; // Start from 3 since we have 3 default links

        // Color picker sync
        document.getElementById('background_color').addEventListener('change', function() {
            document.getElementById('background_color_text').value = this.value;
            updatePreview();
        });

        document.getElementById('background_color_text').addEventListener('input', function() {
            document.getElementById('background_color').value = this.value;
            updatePreview();
        });

        document.getElementById('text_color').addEventListener('change', function() {
            document.getElementById('text_color_text').value = this.value;
            updatePreview();
        });

        document.getElementById('text_color_text').addEventListener('input', function() {
            document.getElementById('text_color').value = this.value;
            updatePreview();
        });

        // Message preview
        document.getElementById('message').addEventListener('input', updatePreview);

        function addLink() {
            const container = document.getElementById('links-container');
            const linkItem = document.createElement('div');
            linkItem.className = 'link-item flex items-center space-x-3 p-3 bg-gray-50 rounded-lg';
            linkItem.innerHTML = `
                <input type="text" 
                       name="links[${linkIndex}][text]" 
                       placeholder="Link Text"
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                <input type="text" 
                       name="links[${linkIndex}][url]" 
                       placeholder="URL"
                       class="flex-1 px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                <button type="button" onclick="removeLink(this)" class="text-red-600 hover:text-red-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            `;
            container.appendChild(linkItem);
            linkIndex++;
        }

        function removeLink(button) {
            button.closest('.link-item').remove();
            updatePreview();
        }

        function toggleScrollSpeed() {
            const checkbox = document.querySelector('input[name="is_scrolling"]');
            const container = document.getElementById('scroll-speed-container');
            
            if (checkbox.checked) {
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }
        }

        function updatePreview() {
            const message = document.getElementById('message').value || 'Free Shipping Sitewide on Every Order, Don\'t Miss Out!!';
            const bgColor = document.getElementById('background_color').value;
            const textColor = document.getElementById('text_color').value;
            
            const preview = document.getElementById('preview');
            const previewMessage = document.getElementById('preview-message');
            const previewLinks = document.getElementById('preview-links');
            
            preview.style.backgroundColor = bgColor;
            preview.style.color = textColor;
            previewMessage.textContent = message;
            
            // Update links preview
            const linkInputs = document.querySelectorAll('input[name*="[text]"]');
            let linksHtml = '';
            linkInputs.forEach(input => {
                if (input.value.trim()) {
                    linksHtml += `<a href="#" class="ml-4 hover:underline">${input.value}</a>`;
                }
            });
            previewLinks.innerHTML = linksHtml;
        }

        // Initialize preview
        updatePreview();
    </script>
</x-layouts.admin>
