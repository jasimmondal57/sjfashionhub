<x-layouts.mobileadmin>
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">🎨 Theme & Colors</h1>
            <p class="text-gray-600 mt-1">Customize the app's appearance and colors</p>
        </div>

        <form action="{{ route('mobileadmin.theme.update') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Theme Settings -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Color Scheme</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Primary Color -->
                            <div>
                                <label for="primary_color" class="block text-sm font-medium text-gray-700 mb-2">
                                    Primary Color
                                </label>
                                <div class="flex gap-3">
                                    <input type="color" 
                                           id="primary_color" 
                                           name="primary_color" 
                                           value="{{ old('primary_color', $settings['primary_color'] ?? '#7C3AED') }}"
                                           class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer">
                                    <input type="text" 
                                           value="{{ old('primary_color', $settings['primary_color'] ?? '#7C3AED') }}"
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                           readonly>
                                </div>
                            </div>

                            <!-- Secondary Color -->
                            <div>
                                <label for="secondary_color" class="block text-sm font-medium text-gray-700 mb-2">
                                    Secondary Color
                                </label>
                                <div class="flex gap-3">
                                    <input type="color" 
                                           id="secondary_color" 
                                           name="secondary_color" 
                                           value="{{ old('secondary_color', $settings['secondary_color'] ?? '#6366F1') }}"
                                           class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer">
                                    <input type="text" 
                                           value="{{ old('secondary_color', $settings['secondary_color'] ?? '#6366F1') }}"
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                           readonly>
                                </div>
                            </div>

                            <!-- Accent Color -->
                            <div>
                                <label for="accent_color" class="block text-sm font-medium text-gray-700 mb-2">
                                    Accent Color
                                </label>
                                <div class="flex gap-3">
                                    <input type="color" 
                                           id="accent_color" 
                                           name="accent_color" 
                                           value="{{ old('accent_color', $settings['accent_color'] ?? '#EC4899') }}"
                                           class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer">
                                    <input type="text" 
                                           value="{{ old('accent_color', $settings['accent_color'] ?? '#EC4899') }}"
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                           readonly>
                                </div>
                            </div>

                            <!-- Background Color -->
                            <div>
                                <label for="background_color" class="block text-sm font-medium text-gray-700 mb-2">
                                    Background Color
                                </label>
                                <div class="flex gap-3">
                                    <input type="color" 
                                           id="background_color" 
                                           name="background_color" 
                                           value="{{ old('background_color', $settings['background_color'] ?? '#F9FAFB') }}"
                                           class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer">
                                    <input type="text" 
                                           value="{{ old('background_color', $settings['background_color'] ?? '#F9FAFB') }}"
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                           readonly>
                                </div>
                            </div>

                            <!-- Text Color -->
                            <div>
                                <label for="text_color" class="block text-sm font-medium text-gray-700 mb-2">
                                    Text Color
                                </label>
                                <div class="flex gap-3">
                                    <input type="color" 
                                           id="text_color" 
                                           name="text_color" 
                                           value="{{ old('text_color', $settings['text_color'] ?? '#1F2937') }}"
                                           class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer">
                                    <input type="text" 
                                           value="{{ old('text_color', $settings['text_color'] ?? '#1F2937') }}"
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                           readonly>
                                </div>
                            </div>

                            <!-- Success Color -->
                            <div>
                                <label for="success_color" class="block text-sm font-medium text-gray-700 mb-2">
                                    Success Color
                                </label>
                                <div class="flex gap-3">
                                    <input type="color" 
                                           id="success_color" 
                                           name="success_color" 
                                           value="{{ old('success_color', $settings['success_color'] ?? '#10B981') }}"
                                           class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer">
                                    <input type="text" 
                                           value="{{ old('success_color', $settings['success_color'] ?? '#10B981') }}"
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                           readonly>
                                </div>
                            </div>

                            <!-- Error Color -->
                            <div>
                                <label for="error_color" class="block text-sm font-medium text-gray-700 mb-2">
                                    Error Color
                                </label>
                                <div class="flex gap-3">
                                    <input type="color" 
                                           id="error_color" 
                                           name="error_color" 
                                           value="{{ old('error_color', $settings['error_color'] ?? '#EF4444') }}"
                                           class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer">
                                    <input type="text" 
                                           value="{{ old('error_color', $settings['error_color'] ?? '#EF4444') }}"
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                           readonly>
                                </div>
                            </div>

                            <!-- Warning Color -->
                            <div>
                                <label for="warning_color" class="block text-sm font-medium text-gray-700 mb-2">
                                    Warning Color
                                </label>
                                <div class="flex gap-3">
                                    <input type="color" 
                                           id="warning_color" 
                                           name="warning_color" 
                                           value="{{ old('warning_color', $settings['warning_color'] ?? '#F59E0B') }}"
                                           class="h-12 w-20 border border-gray-300 rounded-lg cursor-pointer">
                                    <input type="text" 
                                           value="{{ old('warning_color', $settings['warning_color'] ?? '#F59E0B') }}"
                                           class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                                           readonly>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Typography -->
                    <div class="bg-white rounded-xl shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Typography</h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Font Family -->
                            <div>
                                <label for="font_family" class="block text-sm font-medium text-gray-700 mb-2">
                                    Font Family
                                </label>
                                <select id="font_family" 
                                        name="font_family" 
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                                    <option value="system" {{ old('font_family', $settings['font_family'] ?? 'system') == 'system' ? 'selected' : '' }}>System Default</option>
                                    <option value="roboto" {{ old('font_family', $settings['font_family'] ?? 'system') == 'roboto' ? 'selected' : '' }}>Roboto</option>
                                    <option value="opensans" {{ old('font_family', $settings['font_family'] ?? 'system') == 'opensans' ? 'selected' : '' }}>Open Sans</option>
                                    <option value="lato" {{ old('font_family', $settings['font_family'] ?? 'system') == 'lato' ? 'selected' : '' }}>Lato</option>
                                    <option value="montserrat" {{ old('font_family', $settings['font_family'] ?? 'system') == 'montserrat' ? 'selected' : '' }}>Montserrat</option>
                                </select>
                            </div>

                            <!-- Border Radius -->
                            <div>
                                <label for="border_radius" class="block text-sm font-medium text-gray-700 mb-2">
                                    Border Radius (px)
                                </label>
                                <input type="number" 
                                       id="border_radius" 
                                       name="border_radius" 
                                       value="{{ old('border_radius', $settings['border_radius'] ?? 8) }}"
                                       min="0"
                                       max="50"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Preview</h2>
                        
                        <div class="space-y-4">
                            <!-- Primary Button -->
                            <button type="button" 
                                    id="preview-primary"
                                    class="w-full py-3 rounded-lg font-medium text-white"
                                    style="background-color: {{ $settings['primary_color'] ?? '#7C3AED' }}">
                                Primary Button
                            </button>

                            <!-- Secondary Button -->
                            <button type="button" 
                                    id="preview-secondary"
                                    class="w-full py-3 rounded-lg font-medium text-white"
                                    style="background-color: {{ $settings['secondary_color'] ?? '#6366F1' }}">
                                Secondary Button
                            </button>

                            <!-- Accent Badge -->
                            <div class="flex justify-center">
                                <span id="preview-accent" 
                                      class="px-4 py-2 rounded-full text-white font-medium"
                                      style="background-color: {{ $settings['accent_color'] ?? '#EC4899' }}">
                                    Accent Badge
                                </span>
                            </div>

                            <!-- Success Alert -->
                            <div id="preview-success" 
                                 class="p-4 rounded-lg text-white"
                                 style="background-color: {{ $settings['success_color'] ?? '#10B981' }}">
                                <i class="fas fa-check-circle mr-2"></i>Success Message
                            </div>

                            <!-- Error Alert -->
                            <div id="preview-error" 
                                 class="p-4 rounded-lg text-white"
                                 style="background-color: {{ $settings['error_color'] ?? '#EF4444' }}">
                                <i class="fas fa-exclamation-circle mr-2"></i>Error Message
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3 mt-6">
                <button type="submit" 
                        class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-8 py-3 rounded-lg font-medium transition-all shadow-lg">
                    <i class="fas fa-save mr-2"></i>Save Theme
                </button>
            </div>
        </form>
    </div>

    <script>
        // Live preview updates
        document.querySelectorAll('input[type="color"]').forEach(input => {
            input.addEventListener('input', function() {
                const name = this.name;
                const value = this.value;
                
                // Update text input
                this.nextElementSibling.value = value;
                
                // Update preview
                if (name === 'primary_color') {
                    document.getElementById('preview-primary').style.backgroundColor = value;
                } else if (name === 'secondary_color') {
                    document.getElementById('preview-secondary').style.backgroundColor = value;
                } else if (name === 'accent_color') {
                    document.getElementById('preview-accent').style.backgroundColor = value;
                } else if (name === 'success_color') {
                    document.getElementById('preview-success').style.backgroundColor = value;
                } else if (name === 'error_color') {
                    document.getElementById('preview-error').style.backgroundColor = value;
                }
            });
        });
    </script>
</x-layouts.mobileadmin>

