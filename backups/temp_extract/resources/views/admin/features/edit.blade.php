<x-layouts.admin>
    <x-slot name="title">Edit Feature - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">Edit feature details</x-slot>
    <x-slot name="pageTitle">⭐ Edit Feature</x-slot>

    <!-- Header Actions -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600">Edit feature: {{ $feature->title }}</p>
        </div>
        <a href="{{ route('admin.features.index') }}" class="btn btn-secondary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Back to Features
        </a>
    </div>

    <!-- Current Feature Preview -->
    <div class="bg-white rounded-lg border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-black mb-4">Current Feature Preview</h3>
        <div class="bg-gray-50 p-6 rounded-lg">
            <div class="text-center max-w-xs mx-auto">
                <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: {{ $feature->background_color }}">
                    @if($feature->icon_type === 'svg' && $feature->icon_svg)
                        <div style="color: {{ $feature->icon_color }}">
                            {!! $feature->icon_svg !!}
                        </div>
                    @elseif($feature->icon_type === 'image' && $feature->icon_image)
                        <img src="{{ Storage::url($feature->icon_image) }}" alt="{{ $feature->title }}" class="w-8 h-8">
                    @elseif($feature->icon_type === 'icon_class' && $feature->icon_class)
                        <i class="{{ $feature->icon_class }}" style="color: {{ $feature->icon_color }}"></i>
                    @endif
                </div>
                <h3 class="font-semibold text-lg mb-2">{{ $feature->title }}</h3>
                <p class="text-gray-600 text-sm">{{ $feature->description }}</p>
            </div>
        </div>
    </div>

    <!-- Feature Form -->
    <div class="bg-white rounded-lg border border-gray-100 p-6">
        <form action="{{ route('admin.features.update', $feature) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Title -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Feature Title *</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $feature->title) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                           placeholder="Free Shipping" required>
                    @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">Sort Order</label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $feature->sort_order) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                           placeholder="0" min="0">
                    @error('sort_order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea id="description" name="description" rows="3" 
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                          placeholder="On orders above ₹999" required>{{ old('description', $feature->description) }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Icon Configuration -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Icon Configuration</h3>
                
                <!-- Icon Type -->
                <div class="mb-4">
                    <label for="icon_type" class="block text-sm font-medium text-gray-700 mb-2">Icon Type *</label>
                    <select id="icon_type" name="icon_type" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                            onchange="toggleIconOptions()" required>
                        <option value="svg" {{ old('icon_type', $feature->icon_type) === 'svg' ? 'selected' : '' }}>SVG Code</option>
                        <option value="image" {{ old('icon_type', $feature->icon_type) === 'image' ? 'selected' : '' }}>Upload Image</option>
                        <option value="icon_class" {{ old('icon_type', $feature->icon_type) === 'icon_class' ? 'selected' : '' }}>Icon Class (Font Icons)</option>
                    </select>
                    @error('icon_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- SVG Code -->
                <div id="svg_option" class="mb-4">
                    <label for="icon_svg" class="block text-sm font-medium text-gray-700 mb-2">SVG Code</label>
                    <textarea id="icon_svg" name="icon_svg" rows="4" 
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent font-mono text-sm"
                              placeholder='<svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">...</svg>'>{{ old('icon_svg', $feature->icon_svg) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Paste your SVG code here. Make sure to include proper classes for styling.</p>
                    @error('icon_svg')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div id="image_option" class="mb-4 hidden">
                    <label for="icon_image" class="block text-sm font-medium text-gray-700 mb-2">Icon Image</label>
                    @if($feature->icon_image)
                        <div class="mb-3 p-3 bg-gray-50 border border-gray-200 rounded-md">
                            <p class="text-sm text-gray-600 mb-2">Current image:</p>
                            <img src="{{ Storage::url($feature->icon_image) }}" alt="{{ $feature->title }}" class="w-16 h-16 object-cover rounded">
                        </div>
                    @endif
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600">
                                <label for="icon_image" class="relative cursor-pointer bg-white rounded-md font-medium text-black hover:text-gray-800 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-black">
                                    <span>Upload new icon</span>
                                    <input id="icon_image" name="icon_image" type="file" class="sr-only" accept="image/*">
                                </label>
                                <p class="pl-1">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500">PNG, JPG, SVG up to 1MB (leave empty to keep current)</p>
                        </div>
                    </div>
                    @error('icon_image')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Icon Class -->
                <div id="class_option" class="mb-4 hidden">
                    <label for="icon_class" class="block text-sm font-medium text-gray-700 mb-2">Icon Class</label>
                    <input type="text" id="icon_class" name="icon_class" value="{{ old('icon_class', $feature->icon_class) }}" 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent"
                           placeholder="fas fa-shipping-fast">
                    <p class="mt-1 text-xs text-gray-500">Enter Font Awesome, Bootstrap Icons, or other icon font classes.</p>
                    @error('icon_class')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Styling Options -->
            <div class="border-t border-gray-200 pt-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Styling Options</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Background Color -->
                    <div>
                        <label for="background_color" class="block text-sm font-medium text-gray-700 mb-2">Background Color</label>
                        <input type="color" id="background_color" name="background_color" value="{{ old('background_color', $feature->background_color) }}" 
                               class="w-full h-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                        @error('background_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Icon Color -->
                    <div>
                        <label for="icon_color" class="block text-sm font-medium text-gray-700 mb-2">Icon Color</label>
                        <input type="color" id="icon_color" name="icon_color" value="{{ old('icon_color', $feature->icon_color) }}" 
                               class="w-full h-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black focus:border-transparent">
                        @error('icon_color')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="border-t border-gray-200 pt-6">
                <div class="flex items-center">
                    <input type="checkbox" id="is_active" name="is_active" value="1" 
                           {{ old('is_active', $feature->is_active) ? 'checked' : '' }}
                           class="h-4 w-4 text-black focus:ring-black border-gray-300 rounded">
                    <label for="is_active" class="ml-2 block text-sm text-gray-900">
                        Active (feature will be displayed on the website)
                    </label>
                </div>
                @error('is_active')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.features.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Update Feature</button>
            </div>
        </form>
    </div>

    <script>
        function toggleIconOptions() {
            const iconType = document.getElementById('icon_type').value;
            const svgOption = document.getElementById('svg_option');
            const imageOption = document.getElementById('image_option');
            const classOption = document.getElementById('class_option');

            // Hide all options first
            svgOption.classList.add('hidden');
            imageOption.classList.add('hidden');
            classOption.classList.add('hidden');

            // Show relevant option
            if (iconType === 'svg') {
                svgOption.classList.remove('hidden');
            } else if (iconType === 'image') {
                imageOption.classList.remove('hidden');
            } else if (iconType === 'icon_class') {
                classOption.classList.remove('hidden');
            }
        }

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            toggleIconOptions();
        });
    </script>
</x-layouts.admin>
