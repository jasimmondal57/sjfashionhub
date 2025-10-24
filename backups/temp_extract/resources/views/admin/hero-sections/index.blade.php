<x-layouts.admin title="Hero Sections" description="Manage website hero sections">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-black">Hero Sections</h1>
                <p class="text-gray-600">Manage your website hero sections and main banners</p>
            </div>
            <a href="{{ route('admin.hero-sections.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Hero Section
            </a>
        </div>

        <!-- Current Active Hero Preview -->
        @if($activeHero)
            <div class="bg-white rounded-lg border border-gray-100 p-6">
                <h3 class="text-lg font-medium text-black mb-4">🎯 Currently Active Hero Section</h3>
                <div class="border border-gray-300 rounded-md overflow-hidden">
                    <div class="relative overflow-hidden" style="background-color: {{ $activeHero->background_color }};">
                        <div class="container mx-auto px-4">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center min-h-[300px] py-8">
                                <div class="space-y-4">
                                    <h1 class="text-3xl lg:text-4xl font-bold leading-tight" style="color: {{ $activeHero->text_color }};">
                                        {{ $activeHero->title }}<br>
                                        <span style="color: {{ $activeHero->accent_color }};">{{ $activeHero->subtitle }}</span>
                                    </h1>
                                    <p class="text-lg max-w-md" style="color: {{ $activeHero->text_color }}; opacity: 0.8;">
                                        {{ $activeHero->description }}
                                    </p>
                                    @if($activeHero->show_buttons)
                                        <div class="flex flex-col sm:flex-row gap-3">
                                            <a href="{{ $activeHero->primary_button_url }}" class="btn btn-primary">
                                                {{ $activeHero->primary_button_text }}
                                            </a>
                                            @if($activeHero->secondary_button_text)
                                                <a href="{{ $activeHero->secondary_button_url }}" class="btn btn-secondary">
                                                    {{ $activeHero->secondary_button_text }}
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                                <div class="relative">
                                    @if($activeHero->hero_image_url)
                                        <img src="{{ $activeHero->hero_image_url }}" alt="Hero Image" class="w-full h-auto rounded-lg">
                                    @else
                                        <div class="w-full h-64 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="mt-2 text-sm text-gray-500">This is how your hero section currently appears on the website</p>
            </div>
        @endif

        <!-- Hero Sections List -->
        @if($heroSections->count() > 0)
            <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-black">All Hero Sections ({{ $heroSections->count() }})</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hero Content</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Layout</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($heroSections as $hero)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-start space-x-4">
                                            @if($hero->hero_image_url)
                                                <img src="{{ $hero->hero_image_url }}" alt="Hero Image" class="w-16 h-16 object-cover rounded-lg">
                                            @else
                                                <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                            <div class="flex-1 min-w-0">
                                                <h4 class="text-sm font-medium text-gray-900 truncate">
                                                    {{ $hero->title }} {{ $hero->subtitle }}
                                                </h4>
                                                <p class="text-sm text-gray-500 truncate">{{ Str::limit($hero->description, 60) }}</p>
                                                <div class="flex items-center space-x-2 mt-1">
                                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                        {{ $hero->primary_button_text }}
                                                    </span>
                                                    @if($hero->secondary_button_text)
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                            {{ $hero->secondary_button_text }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <div class="flex items-center space-x-2">
                                                <div class="w-4 h-4 rounded" style="background-color: {{ $hero->background_color }}"></div>
                                                <span class="capitalize">{{ $hero->layout_style }}</span>
                                            </div>
                                            <div class="text-xs text-gray-500 mt-1">
                                                Order: {{ $hero->sort_order }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $hero->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $hero->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('admin.hero-sections.show', $hero) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                        <a href="{{ route('admin.hero-sections.edit', $hero) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        
                                        <form action="{{ route('admin.hero-sections.toggle', $hero) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-{{ $hero->is_active ? 'yellow' : 'green' }}-600 hover:text-{{ $hero->is_active ? 'yellow' : 'green' }}-900">
                                                {{ $hero->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.hero-sections.destroy', $hero) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this hero section?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg border border-gray-100 p-12">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4V2a1 1 0 011-1h8a1 1 0 011 1v2h4a1 1 0 011 1v1a1 1 0 01-1 1h-1v12a2 2 0 01-2 2H6a2 2 0 01-2-2V7H3a1 1 0 01-1-1V5a1 1 0 011-1h4zM9 3v1h6V3H9zm0 4v10h6V7H9z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No hero sections</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first hero section.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.hero-sections.create') }}" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Hero Section
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Help Section -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h4 class="text-sm font-medium text-blue-800 mb-2">💡 Hero Section Tips:</h4>
            <ul class="text-sm text-blue-700 space-y-1">
                <li>• <strong>Only one hero section can be active at a time</strong> - activating one will deactivate others</li>
                <li>• <strong>Layout styles:</strong> Split (text + image), Centered (text only), Full-width (background image)</li>
                <li>• <strong>Image recommendations:</strong> Use high-quality images (1200x800px or larger) for best results</li>
                <li>• <strong>Color contrast:</strong> Ensure text colors have good contrast against background colors</li>
                <li>• <strong>Button URLs:</strong> Use relative URLs (/products) or full URLs (https://example.com)</li>
            </ul>
        </div>
    </div>
</x-layouts.admin>
