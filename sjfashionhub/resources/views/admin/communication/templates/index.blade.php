<x-layouts.admin>
    <x-slot name="title">Communication Templates</x-slot>
<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">📝 Communication Templates</h1>
            <p class="text-gray-600 mt-1">Manage email, SMS, and WhatsApp message templates</p>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.communication.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                ← Back to Dashboard
            </a>
            <a href="{{ route('admin.communication-templates.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                ➕ Create Template
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            {{ session('error') }}
        </div>
    @endif

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('admin.communication-templates.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Type</label>
                <select name="type" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">All Types</option>
                    @foreach($types as $type)
                        <option value="{{ $type }}" {{ request('type') === $type ? 'selected' : '' }}>
                            {{ ucfirst($type) }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>
                            {{ ucfirst($category) }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Language</label>
                <select name="language" class="w-full border border-gray-300 rounded-lg px-3 py-2">
                    <option value="">All Languages</option>
                    @foreach($languages as $lang)
                        <option value="{{ $lang }}" {{ request('language') === $lang ? 'selected' : '' }}>
                            {{ $lang === 'en' ? 'English' : 'Hindi' }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="w-full border border-gray-300 rounded-lg px-3 py-2" 
                       placeholder="Search templates...">
            </div>
            
            <div class="flex items-end space-x-2">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    🔍 Filter
                </button>
                <a href="{{ route('admin.communication-templates.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                    🔄 Reset
                </a>
            </div>
        </form>
    </div>

    <!-- Templates List -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Template</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Event</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Language</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($templates as $template)
                    <tr>
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $template->name }}</div>
                                    @if($template->subject)
                                        <div class="text-sm text-gray-500">{{ Str::limit($template->subject, 50) }}</div>
                                    @endif
                                    <div class="text-xs text-gray-400">{{ Str::limit($template->content, 80) }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $template->type === 'email' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $template->type === 'sms' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $template->type === 'whatsapp' ? 'bg-purple-100 text-purple-800' : '' }}">
                                {{ ucfirst($template->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ ucfirst($template->category) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ str_replace('_', ' ', ucfirst($template->event)) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $template->language === 'en' ? 'English' : 'Hindi' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $template->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $template->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                @if($template->is_default)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Default
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center space-x-2">
                                <button onclick="previewTemplate({{ $template->id }})" 
                                        class="text-blue-600 hover:text-blue-900" title="Preview">
                                    👁️
                                </button>
                                <a href="{{ route('admin.communication-templates.show', $template) }}" 
                                   class="text-green-600 hover:text-green-900" title="View">
                                    📄
                                </a>
                                <a href="{{ route('admin.communication-templates.edit', $template) }}" 
                                   class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                    ✏️
                                </a>
                                <form method="POST" action="{{ route('admin.communication-templates.duplicate', $template) }}" 
                                      class="inline">
                                    @csrf
                                    <button type="submit" class="text-purple-600 hover:text-purple-900" title="Duplicate">
                                        📋
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('admin.communication-templates.destroy', $template) }}" 
                                      class="inline" onsubmit="return confirm('Are you sure you want to delete this template?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" title="Delete">
                                        🗑️
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                            <div class="py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">No templates found</h3>
                                <p class="mt-1 text-sm text-gray-500">Get started by creating a new template.</p>
                                <div class="mt-6">
                                    <a href="{{ route('admin.communication-templates.create') }}" 
                                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                        ➕ Create Template
                                    </a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($templates->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $templates->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Preview Modal -->
<div id="previewModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-96 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold text-gray-900">Template Preview</h3>
                <button onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div id="previewContent" class="p-6 overflow-y-auto max-h-80">
                <!-- Preview content will be loaded here -->
            </div>
        </div>
    </div>
</div>

<script>
function previewTemplate(templateId) {
    document.getElementById('previewModal').classList.remove('hidden');
    document.getElementById('previewContent').innerHTML = '<div class="text-center">Loading...</div>';
    
    fetch(`/admin/communication-templates/${templateId}/preview`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            let content = '';
            if (data.preview.subject) {
                content += `<div class="mb-4"><strong>Subject:</strong> ${data.preview.subject}</div>`;
            }
            content += `<div class="mb-4"><strong>Content:</strong><br><div class="bg-gray-50 p-4 rounded">${data.preview.content.replace(/\n/g, '<br>')}</div></div>`;
            if (data.preview.html_content) {
                content += `<div><strong>HTML Content:</strong><br><div class="bg-gray-50 p-4 rounded border">${data.preview.html_content}</div></div>`;
            }
            document.getElementById('previewContent').innerHTML = content;
        } else {
            document.getElementById('previewContent').innerHTML = '<div class="text-red-600">Failed to load preview</div>';
        }
    })
    .catch(error => {
        document.getElementById('previewContent').innerHTML = '<div class="text-red-600">Error loading preview</div>';
        console.error('Error:', error);
    });
}

function closePreviewModal() {
    document.getElementById('previewModal').classList.add('hidden');
}
</script>
</x-layouts.admin>
