<x-layouts.admin>
    <x-slot name="title">Feature Details - SJ Fashion Hub Admin</x-slot>
    <x-slot name="description">View feature details</x-slot>
    <x-slot name="pageTitle">⭐ Feature Details</x-slot>

    <!-- Header Actions -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-600">Feature: {{ $feature->title }}</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.features.edit', $feature) }}" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit Feature
            </a>
            <a href="{{ route('admin.features.index') }}" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Features
            </a>
        </div>
    </div>

    <!-- Feature Preview -->
    <div class="bg-white rounded-lg border border-gray-100 p-6 mb-6">
        <h3 class="text-lg font-semibold text-black mb-4">Feature Preview</h3>
        <div class="bg-gray-50 p-8 rounded-lg">
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
                    @else
                        <svg class="w-8 h-8" style="color: {{ $feature->icon_color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    @endif
                </div>
                <h3 class="font-semibold text-lg mb-2">{{ $feature->title }}</h3>
                <p class="text-gray-600 text-sm">{{ $feature->description }}</p>
            </div>
        </div>
    </div>

    <!-- Feature Details -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Basic Information -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-black mb-4">Basic Information</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Title</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $feature->title }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $feature->description }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sort Order</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $feature->sort_order }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $feature->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $feature->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Created</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $feature->created_at->format('M j, Y \a\t g:i A') }}</p>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                    <p class="mt-1 text-sm text-gray-900">{{ $feature->updated_at->format('M j, Y \a\t g:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Icon Configuration -->
        <div class="bg-white rounded-lg border border-gray-100 p-6">
            <h3 class="text-lg font-semibold text-black mb-4">Icon Configuration</h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Icon Type</label>
                    <span class="mt-1 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($feature->icon_type === 'svg') bg-blue-100 text-blue-800
                        @elseif($feature->icon_type === 'image') bg-green-100 text-green-800
                        @elseif($feature->icon_type === 'icon_class') bg-purple-100 text-purple-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst(str_replace('_', ' ', $feature->icon_type)) }}
                    </span>
                </div>
                
                @if($feature->icon_type === 'svg' && $feature->icon_svg)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">SVG Code</label>
                        <div class="mt-1 p-3 bg-gray-50 border border-gray-200 rounded-md">
                            <code class="text-xs text-gray-800 font-mono break-all">{{ $feature->icon_svg }}</code>
                        </div>
                    </div>
                @endif
                
                @if($feature->icon_type === 'image' && $feature->icon_image)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Icon Image</label>
                        <div class="mt-1">
                            <img src="{{ Storage::url($feature->icon_image) }}" alt="{{ $feature->title }}" class="w-16 h-16 object-cover rounded border border-gray-200">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">{{ $feature->icon_image }}</p>
                    </div>
                @endif
                
                @if($feature->icon_type === 'icon_class' && $feature->icon_class)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Icon Class</label>
                        <p class="mt-1 text-sm text-gray-900 font-mono">{{ $feature->icon_class }}</p>
                    </div>
                @endif
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Background Color</label>
                    <div class="mt-1 flex items-center">
                        <div class="w-6 h-6 rounded border border-gray-300 mr-2" style="background-color: {{ $feature->background_color }}"></div>
                        <span class="text-sm text-gray-900">{{ $feature->background_color }}</span>
                    </div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Icon Color</label>
                    <div class="mt-1 flex items-center">
                        <div class="w-6 h-6 rounded border border-gray-300 mr-2" style="background-color: {{ $feature->icon_color }}"></div>
                        <span class="text-sm text-gray-900">{{ $feature->icon_color }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Website Preview -->
    <div class="mt-6 bg-white rounded-lg border border-gray-100 p-6">
        <h3 class="text-lg font-semibold text-black mb-4">How it appears on website</h3>
        <div class="bg-gray-50 p-8 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Show this feature in context with others -->
                @php
                    $allFeatures = \App\Models\Feature::active()->ordered()->get();
                @endphp
                @foreach($allFeatures as $contextFeature)
                <div class="text-center {{ $contextFeature->id === $feature->id ? 'ring-2 ring-blue-500 rounded-lg p-2' : '' }}">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4" style="background-color: {{ $contextFeature->background_color }}">
                        @if($contextFeature->icon_type === 'svg' && $contextFeature->icon_svg)
                            <div style="color: {{ $contextFeature->icon_color }}">
                                {!! $contextFeature->icon_svg !!}
                            </div>
                        @elseif($contextFeature->icon_type === 'image' && $contextFeature->icon_image)
                            <img src="{{ Storage::url($contextFeature->icon_image) }}" alt="{{ $contextFeature->title }}" class="w-8 h-8">
                        @elseif($contextFeature->icon_type === 'icon_class' && $contextFeature->icon_class)
                            <i class="{{ $contextFeature->icon_class }}" style="color: {{ $contextFeature->icon_color }}"></i>
                        @endif
                    </div>
                    <h3 class="font-semibold text-lg mb-2">{{ $contextFeature->title }}</h3>
                    <p class="text-gray-600 text-sm">{{ $contextFeature->description }}</p>
                    @if($contextFeature->id === $feature->id)
                        <p class="text-xs text-blue-600 mt-2 font-medium">← Current Feature</p>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-6 flex justify-end space-x-3">
        <form action="{{ route('admin.features.toggle', $feature) }}" method="POST" class="inline">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn {{ $feature->is_active ? 'btn-secondary' : 'btn-primary' }}">
                {{ $feature->is_active ? 'Disable Feature' : 'Enable Feature' }}
            </button>
        </form>
        
        <button onclick="deleteFeature({{ $feature->id }})" class="btn btn-danger">
            Delete Feature
        </button>
    </div>

    <script>
        function deleteFeature(featureId) {
            if (confirm('Are you sure you want to delete this feature? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/features/${featureId}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
</x-layouts.admin>
