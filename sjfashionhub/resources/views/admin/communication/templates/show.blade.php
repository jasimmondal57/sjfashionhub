<x-layouts.admin>
    <x-slot name="title">Template Details - {{ $template->name }}</x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">📧 Template Details</h1>
                <p class="text-gray-600 mt-1">{{ $template->name }}</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('admin.communication-templates.index') }}"
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                    ← Back to Templates
                </a>
                <a href="{{ route('admin.communication-templates.edit', $template) }}"
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                    ✏️ Edit Template
                </a>
                <form method="POST" action="{{ route('admin.communication-templates.duplicate', $template) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                        📋 Duplicate
                    </button>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Template Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Basic Info Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">📋 Basic Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm font-medium text-gray-600">Template Name</label>
                            <p class="text-gray-900 mt-1">{{ $template->name }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Type</label>
                            <p class="mt-1">
                                <span class="px-3 py-1 rounded-full text-sm font-medium
                                    {{ $template->type === 'email' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $template->type === 'sms' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $template->type === 'whatsapp' ? 'bg-purple-100 text-purple-800' : '' }}">
                                    {{ strtoupper($template->type) }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Category</label>
                            <p class="text-gray-900 mt-1">{{ ucfirst($template->category) }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Event</label>
                            <p class="text-gray-900 mt-1">{{ $template->event }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Language</label>
                            <p class="text-gray-900 mt-1">{{ strtoupper($template->language) }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-600">Priority</label>
                            <p class="text-gray-900 mt-1">{{ $template->priority }}</p>
                        </div>
                    </div>

                    @if($template->description)
                        <div class="mt-4">
                            <label class="text-sm font-medium text-gray-600">Description</label>
                            <p class="text-gray-900 mt-1">{{ $template->description }}</p>
                        </div>
                    @endif
                </div>

                <!-- Subject (for email) -->
                @if($template->type === 'email' && $template->subject)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4">📬 Subject</h2>
                        <p class="text-gray-900 font-mono bg-gray-50 p-3 rounded">{{ $template->subject }}</p>
                    </div>
                @endif

                <!-- Content -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">📝 Content</h2>
                    <div class="bg-gray-50 p-4 rounded font-mono text-sm whitespace-pre-wrap">{{ $template->content }}</div>
                </div>

                <!-- HTML Content (for email) -->
                @if($template->type === 'email' && $template->html_content)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4">🎨 HTML Content</h2>
                        <div class="bg-gray-50 p-4 rounded">
                            <details>
                                <summary class="cursor-pointer text-blue-600 hover:text-blue-800 font-medium">View HTML Code</summary>
                                <pre class="mt-3 text-xs overflow-x-auto"><code>{{ $template->html_content }}</code></pre>
                            </details>
                            <div class="mt-4">
                                <p class="text-sm font-medium text-gray-600 mb-2">Preview:</p>
                                <div class="border rounded p-4 bg-white">
                                    {!! $template->html_content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">⚙️ Status</h2>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Active</span>
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $template->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $template->is_active ? 'Yes' : 'No' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Default</span>
                            <span class="px-3 py-1 rounded-full text-sm font-medium {{ $template->is_default ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                {{ $template->is_default ? 'Yes' : 'No' }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Variables Card -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">🔤 Available Variables</h2>
                    @if(count($availableVariables) > 0)
                        <div class="space-y-2">
                            @foreach($availableVariables as $variable)
                                <div class="bg-gray-50 px-3 py-2 rounded font-mono text-sm">
                                    @{{ '{{'.$variable.'}}' }}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">No variables defined</p>
                    @endif
                </div>

                <!-- Metadata -->
                @if($template->created_at)
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4">📅 Metadata</h2>
                        <div class="space-y-2 text-sm">
                            <div>
                                <span class="text-gray-600">Created:</span>
                                <p class="text-gray-900">{{ $template->created_at->format('M d, Y H:i') }}</p>
                            </div>
                            <div>
                                <span class="text-gray-600">Updated:</span>
                                <p class="text-gray-900">{{ $template->updated_at->format('M d, Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold mb-4">🎯 Actions</h2>
                    <div class="space-y-3">
                        <button onclick="previewTemplate()" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors">
                            👁️ Preview Template
                        </button>
                        <form method="POST" action="{{ route('admin.communication-templates.destroy', $template) }}" 
                              onsubmit="return confirm('Are you sure you want to delete this template?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                                🗑️ Delete Template
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="p-6 border-b flex justify-between items-center">
                <h3 class="text-2xl font-bold">Template Preview</h3>
                <button onclick="closePreview()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>
            <div id="previewContent" class="p-6">
                <div class="text-center py-8">
                    <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto"></div>
                    <p class="mt-4 text-gray-600">Loading preview...</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewTemplate() {
            document.getElementById('previewModal').classList.remove('hidden');
            
            fetch('{{ route('admin.communication-templates.preview', $template) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    let html = '';
                    
                    if (data.preview.subject) {
                        html += '<div class="mb-4"><strong class="text-gray-700">Subject:</strong><p class="mt-1 p-3 bg-gray-50 rounded">' + data.preview.subject + '</p></div>';
                    }
                    
                    if (data.preview.html_content) {
                        html += '<div class="mb-4"><strong class="text-gray-700">HTML Preview:</strong><div class="mt-1 p-4 border rounded bg-white">' + data.preview.html_content + '</div></div>';
                    }
                    
                    html += '<div><strong class="text-gray-700">Text Content:</strong><pre class="mt-1 p-3 bg-gray-50 rounded whitespace-pre-wrap">' + data.preview.content + '</pre></div>';
                    
                    document.getElementById('previewContent').innerHTML = html;
                } else {
                    document.getElementById('previewContent').innerHTML = '<div class="text-red-600">Failed to load preview</div>';
                }
            })
            .catch(error => {
                document.getElementById('previewContent').innerHTML = '<div class="text-red-600">Error loading preview</div>';
            });
        }

        function closePreview() {
            document.getElementById('previewModal').classList.add('hidden');
        }
    </script>
</x-layouts.admin>

