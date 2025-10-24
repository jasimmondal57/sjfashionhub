<x-layouts.admin title="Hero Section Details" description="View hero section details">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-black">Hero Section Details</h1>
                <p class="text-gray-600">View hero section information and preview</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.hero-sections.edit', $heroSection) }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.hero-sections.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to List
                </a>
            </div>
        </div>

        <!-- Live Preview -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-medium text-black mb-4">🎯 Live Preview</h3>
            <div class="border border-gray-300 rounded-md overflow-hidden">
                <div class="relative overflow-hidden" style="background-color: {{ $heroSection->background_color }};">
                    <div class="container mx-auto px-4">
                        @if($heroSection->layout_style === 'split')
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center min-h-[400px] py-8">
                                <div class="space-y-4">
                                    <h1 class="text-3xl lg:text-4xl font-bold leading-tight" style="color: {{ $heroSection->text_color }};">
                                        {{ $heroSection->title }}<br>
                                        <span style="color: {{ $heroSection->accent_color }};">{{ $heroSection->subtitle }}</span>
                                    </h1>
                                    <p class="text-lg max-w-md" style="color: {{ $heroSection->text_color }}; opacity: 0.8;">
                                        {{ $heroSection->description }}
                                    </p>
                                    @if($heroSection->show_buttons)
                                        <div class="flex flex-col sm:flex-row gap-3">
                                            <a href="{{ $heroSection->primary_button_url }}" class="btn btn-primary">
                                                {{ $heroSection->primary_button_text }}
                                            </a>
                                            @if($heroSection->secondary_button_text)
                                                <a href="{{ $heroSection->secondary_button_url }}" class="btn btn-secondary">
                                                    {{ $heroSection->secondary_button_text }}
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="relative">
                                    @if($heroSection->hero_image_url)
                                        <img src="{{ $heroSection->hero_image_url }}" alt="Hero Image" class="w-full h-64 object-cover rounded-lg">
                                    @else
                                        <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @elseif($heroSection->layout_style === 'centered')
                            <div class="text-center py-16">
                                <div class="max-w-4xl mx-auto space-y-6">
                                    <h1 class="text-4xl lg:text-6xl font-bold leading-tight" style="color: {{ $heroSection->text_color }};">
                                        {{ $heroSection->title }} <span style="color: {{ $heroSection->accent_color }};">{{ $heroSection->subtitle }}</span>
                                    </h1>
                                    <p class="text-xl max-w-2xl mx-auto" style="color: {{ $heroSection->text_color }}; opacity: 0.8;">
                                        {{ $heroSection->description }}
                                    </p>
                                    @if($heroSection->show_buttons)
                                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                            <a href="{{ $heroSection->primary_button_url }}" class="btn btn-primary">
                                                {{ $heroSection->primary_button_text }}
                                            </a>
                                            @if($heroSection->secondary_button_text)
                                                <a href="{{ $heroSection->secondary_button_url }}" class="btn btn-secondary">
                                                    {{ $heroSection->secondary_button_text }}
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @elseif($heroSection->layout_style === 'full-width')
                            <div class="relative min-h-[500px] flex items-center justify-center"
                                 @if($heroSection->hero_image_url)
                                 style="background-image: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('{{ $heroSection->hero_image_url }}'); background-size: cover; background-position: center;"
                                 @endif>
                                <div class="text-center space-y-6 z-10">
                                    <h1 class="text-4xl lg:text-6xl font-bold leading-tight text-white">
                                        {{ $heroSection->title }}<br>
                                        <span style="color: {{ $heroSection->accent_color }};">{{ $heroSection->subtitle }}</span>
                                    </h1>
                                    <p class="text-xl max-w-2xl mx-auto text-white opacity-90">
                                        {{ $heroSection->description }}
                                    </p>
                                    @if($heroSection->show_buttons)
                                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                                            <a href="{{ $heroSection->primary_button_url }}" class="btn btn-primary">
                                                {{ $heroSection->primary_button_text }}
                                            </a>
                                            @if($heroSection->secondary_button_text)
                                                <a href="{{ $heroSection->secondary_button_url }}" class="btn btn-secondary">
                                                    {{ $heroSection->secondary_button_text }}
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <p class="mt-2 text-sm text-gray-500">This is how your hero section appears on the website</p>
        </div>

        <!-- Hero Section Details -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Content Information -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Content Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $heroSection->title }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Subtitle</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $heroSection->subtitle }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $heroSection->description }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Show Buttons</label>
                        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $heroSection->show_buttons ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $heroSection->show_buttons ? 'Yes' : 'No' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Button Information -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Button Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Primary Button</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $heroSection->primary_button_text }}</p>
                        <p class="text-xs text-gray-500">{{ $heroSection->primary_button_url }}</p>
                    </div>
                    @if($heroSection->secondary_button_text)
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Secondary Button</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $heroSection->secondary_button_text }}</p>
                            <p class="text-xs text-gray-500">{{ $heroSection->secondary_button_url }}</p>
                        </div>
                    @else
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Secondary Button</label>
                            <p class="mt-1 text-sm text-gray-500">Not configured</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Design Information -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Design Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Layout Style</label>
                        <p class="mt-1 text-sm text-gray-900 capitalize">{{ str_replace('-', ' ', $heroSection->layout_style) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Background Color</label>
                        <div class="mt-1 flex items-center space-x-2">
                            <div class="w-6 h-6 rounded border border-gray-300" style="background-color: {{ $heroSection->background_color }}"></div>
                            <span class="text-sm text-gray-900">{{ $heroSection->background_color }}</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Text Color</label>
                        <div class="mt-1 flex items-center space-x-2">
                            <div class="w-6 h-6 rounded border border-gray-300" style="background-color: {{ $heroSection->text_color }}"></div>
                            <span class="text-sm text-gray-900">{{ $heroSection->text_color }}</span>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Accent Color</label>
                        <div class="mt-1 flex items-center space-x-2">
                            <div class="w-6 h-6 rounded border border-gray-300" style="background-color: {{ $heroSection->accent_color }}"></div>
                            <span class="text-sm text-gray-900">{{ $heroSection->accent_color }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status Information -->
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">Status Information</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $heroSection->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $heroSection->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Sort Order</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $heroSection->sort_order }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Hero Image</label>
                        @if($heroSection->hero_image_url)
                            <div class="mt-1">
                                <img src="{{ $heroSection->hero_image_url }}" alt="Hero Image" class="h-20 w-auto border border-gray-200 rounded">
                            </div>
                        @else
                            <p class="mt-1 text-sm text-gray-500">No image uploaded</p>
                        @endif
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Created</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $heroSection->created_at->format('M j, Y g:i A') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $heroSection->updated_at->format('M j, Y g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-medium text-black mb-4">Actions</h3>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.hero-sections.edit', $heroSection) }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit Hero Section
                </a>
                
                <form action="{{ route('admin.hero-sections.toggle', $heroSection) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn {{ $heroSection->is_active ? 'btn-warning' : 'btn-success' }}">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        {{ $heroSection->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                </form>
                
                <form action="{{ route('admin.hero-sections.destroy', $heroSection) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this hero section? This action cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete Hero Section
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>
