<x-layouts.admin title="Body Feature Sections" description="Manage homepage content sections">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-black">Body Feature Sections</h1>
                <p class="text-gray-600">Manage homepage content sections like "Trending Now", "New Collections", etc.</p>
            </div>
            <a href="{{ route('admin.body-feature-sections.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Section
            </a>
        </div>

        <!-- Sections List -->
        @if($sections->count() > 0)
            <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-black">All Sections ({{ $sections->count() }})</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Section</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type & Style</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Content</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($sections as $section)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">{{ $section->title }}</h4>
                                            @if($section->subtitle)
                                                <p class="text-sm text-gray-500">{{ $section->subtitle }}</p>
                                            @endif
                                            <div class="flex items-center space-x-2 mt-1">
                                                <div class="w-4 h-4 rounded" style="background-color: {{ $section->background_color }}"></div>
                                                <span class="text-xs text-gray-500">{{ $section->items_limit }} items</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                                                {{ $section->section_type }}
                                            </span>
                                            <div class="text-xs text-gray-500 mt-1 capitalize">{{ $section->display_style }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            @php
                                                $contentCount = $section->getContentItems()->count();
                                            @endphp
                                            <span class="font-medium">{{ $contentCount }}</span> 
                                            <span class="text-gray-500">
                                                @if($section->section_type === 'products')
                                                    {{ $contentCount === 1 ? 'product' : 'products' }}
                                                @elseif($section->section_type === 'categories')
                                                    {{ $contentCount === 1 ? 'category' : 'categories' }}
                                                @else
                                                    items
                                                @endif
                                            </span>
                                            @if($section->show_button && $section->button_text)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    Button: {{ $section->button_text }}
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $section->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $section->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                        <div class="text-xs text-gray-500 mt-1">
                                            Order: {{ $section->sort_order }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <a href="{{ route('admin.body-feature-sections.show', $section) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                        <a href="{{ route('admin.body-feature-sections.edit', $section) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        
                                        <form action="{{ route('admin.body-feature-sections.toggle', $section) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-{{ $section->is_active ? 'yellow' : 'green' }}-600 hover:text-{{ $section->is_active ? 'yellow' : 'green' }}-900">
                                                {{ $section->is_active ? 'Deactivate' : 'Activate' }}
                                            </button>
                                        </form>
                                        
                                        <form action="{{ route('admin.body-feature-sections.destroy', $section) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this section?')">
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No sections</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating your first body feature section.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.body-feature-sections.create') }}" class="btn btn-primary">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Add Section
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Section Types Info -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h4 class="text-sm font-medium text-blue-800 mb-2">💡 Section Types:</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-blue-700">
                <div>
                    <strong>Products:</strong> Display specific products, featured items, or products from certain categories
                </div>
                <div>
                    <strong>Categories:</strong> Showcase product categories with images and descriptions
                </div>
                <div>
                    <strong>Mixed:</strong> Combine both products and categories in a single section
                </div>
            </div>
            <div class="mt-3 text-sm text-blue-700">
                <strong>Display Styles:</strong> Grid (standard layout), Carousel (scrollable), List (vertical layout)
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h4 class="text-sm font-medium text-gray-800 mb-3">🚀 Quick Actions:</h4>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.body-feature-sections.create') }}?preset=trending" class="btn btn-outline btn-sm">
                    ⭐ Create "Trending Now" Section
                </a>
                <a href="{{ route('admin.body-feature-sections.create') }}?preset=new-collections" class="btn btn-outline btn-sm">
                    🆕 Create "New Collections" Section
                </a>
                <a href="{{ route('admin.body-feature-sections.create') }}?preset=categories" class="btn btn-outline btn-sm">
                    📂 Create Categories Section
                </a>
                <a href="{{ route('admin.body-feature-sections.create') }}?preset=sale" class="btn btn-outline btn-sm">
                    🏷️ Create Sale Section
                </a>
            </div>
        </div>
    </div>
</x-layouts.admin>
