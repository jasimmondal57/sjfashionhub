<x-layouts.admin>
    <x-slot name="title">Template Details</x-slot>

<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">📝 Template Details</h1>
            <p class="text-gray-600 mt-1">{{ $template->display_name }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.whatsapp-marketing.templates') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                ← Back to Templates
            </a>
            @if($template->status === 'draft')
                <form method="POST" action="{{ route('admin.whatsapp-marketing.templates.submit', $template) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                        📤 Submit to WhatsApp
                    </button>
                </form>
            @endif
            @if($template->status === 'pending')
                <form method="POST" action="{{ route('admin.whatsapp-marketing.templates.check-status', $template) }}" class="inline">
                    @csrf
                    <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                        🔄 Check Status
                    </button>
                </form>
            @endif
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Template Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Status Card -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Status</h3>
                <div class="flex items-center gap-4">
                    @php
                        $statusColor = 'gray';
                        $statusIcon = '📄';
                        if($template->status === 'draft') {
                            $statusColor = 'gray';
                            $statusIcon = '📝';
                        } elseif($template->status === 'pending') {
                            $statusColor = 'yellow';
                            $statusIcon = '⏳';
                        } elseif($template->status === 'approved') {
                            $statusColor = 'green';
                            $statusIcon = '✅';
                        } elseif($template->status === 'rejected') {
                            $statusColor = 'red';
                            $statusIcon = '❌';
                        }
                    @endphp
                    <span class="px-4 py-2 inline-flex text-sm leading-5 font-semibold rounded-full bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                        {{ $statusIcon }} {{ ucfirst($template->status) }}
                    </span>
                </div>
            </div>

            <!-- Template Info -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Template Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Template Name</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $template->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Display Name</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $template->display_name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Category</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $template->category }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Language</label>
                        <p class="mt-1 text-sm text-gray-900">{{ strtoupper($template->language) }}</p>
                    </div>
                    @if($template->whatsapp_template_id)
                    <div class="col-span-2">
                        <label class="block text-sm font-medium text-gray-700">WhatsApp Template ID</label>
                        <p class="mt-1 text-sm text-gray-900 font-mono">{{ $template->whatsapp_template_id }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Template Content -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Template Content</h3>
                
                @if($template->header_text)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Header ({{ $template->header_type }})</label>
                    <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-900">
                        {{ $template->header_text }}
                    </div>
                </div>
                @endif

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Body</label>
                    <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-900 whitespace-pre-wrap">{{ $template->body_text }}</div>
                </div>

                @if($template->footer_text)
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Footer</label>
                    <div class="bg-gray-50 rounded-lg p-3 text-sm text-gray-900">
                        {{ $template->footer_text }}
                    </div>
                </div>
                @endif

                @if($template->buttons)
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Buttons</label>
                    <div class="space-y-2">
                        @php
                            $buttons = is_string($template->buttons) ? json_decode($template->buttons, true) : $template->buttons;
                            if(!is_array($buttons)) {
                                $buttons = [];
                            }
                        @endphp
                        @foreach($buttons as $button)
                            <div class="bg-gray-50 rounded-lg p-3 text-sm">
                                @if(isset($button['type']) && isset($button['text']))
                                    <span class="font-medium">{{ $button['type'] }}:</span> {{ $button['text'] }}
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>


        </div>

        <!-- Preview -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">WhatsApp Preview</h3>
                
                <!-- WhatsApp Message Preview -->
                <div class="bg-gradient-to-b from-green-50 to-green-100 rounded-lg p-4">
                    <div class="bg-white rounded-lg shadow-sm p-4 max-w-xs">
                        @if($template->header_text)
                        <div class="font-semibold text-gray-900 mb-2">
                            {{ $template->header_text }}
                        </div>
                        @endif
                        
                        <div class="text-sm text-gray-800 whitespace-pre-wrap mb-3">
                            {{ $template->body_text }}
                        </div>
                        
                        @if($template->footer_text)
                        <div class="text-xs text-gray-500 mb-3">
                            {{ $template->footer_text }}
                        </div>
                        @endif
                        
                        @if($template->buttons)
                        <div class="space-y-2">
                            @php
                                $previewButtons = is_string($template->buttons) ? json_decode($template->buttons, true) : $template->buttons;
                                if(!is_array($previewButtons)) {
                                    $previewButtons = [];
                                }
                            @endphp
                            @foreach($previewButtons as $button)
                                <button class="w-full text-center py-2 text-sm text-blue-600 border border-blue-600 rounded-lg hover:bg-blue-50">
                                    @if(isset($button['text']))
                                        {{ $button['text'] }}
                                    @endif
                                </button>
                            @endforeach
                        </div>
                        @endif
                        
                        <div class="text-xs text-gray-400 mt-3 text-right">
                            {{ now()->format('H:i') }}
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 space-y-3">
                    @if($template->status === 'approved')
                        <a href="{{ route('admin.whatsapp-marketing.campaigns.create') }}?template={{ $template->id }}" 
                           class="block w-full text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            🚀 Create Campaign
                        </a>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.whatsapp-marketing.templates.delete', $template) }}" 
                          onsubmit="return confirm('Are you sure you want to delete this template?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="block w-full text-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                            🗑️ Delete Template
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.admin>

