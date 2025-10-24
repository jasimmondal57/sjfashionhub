<x-layouts.admin>
    <x-slot name="pageTitle">WhatsApp Conversations</x-slot>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">WhatsApp Conversations</h1>
        <a href="{{ route('admin.whatsapp.dashboard') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-lg shadow-sm mb-6 p-6">
        <form method="GET" action="{{ route('admin.whatsapp.conversations.index') }}" class="flex flex-wrap items-center gap-3">
            <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                <option value="">All Status</option>
                <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                <option value="archived" {{ request('status') == 'archived' ? 'selected' : '' }}>Archived</option>
            </select>

            <div class="flex items-center">
                <input class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" type="checkbox" name="unread_only" id="unread_only" value="1" {{ request('unread_only') ? 'checked' : '' }}>
                <label class="ml-2 block text-sm text-gray-900" for="unread_only">
                    Unread Only
                </label>
            </div>

            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                <i class="fas fa-filter mr-2"></i> Filter
            </button>
            <a href="{{ route('admin.whatsapp.conversations.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                <i class="fas fa-times mr-2"></i> Clear
            </a>
        </form>
    </div>

    <!-- Conversations List -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @if($conversations->count() > 0)
            @foreach($conversations as $conversation)
                <div class="bg-white rounded-lg shadow-sm {{ $conversation->unread_count > 0 ? 'ring-2 ring-blue-500' : '' }}">
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <h5 class="text-lg font-semibold text-gray-900 mb-1">
                                    {{ $conversation->customer_name ?? $conversation->formatted_phone }}
                                    @if($conversation->unread_count > 0)
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800 ml-2">{{ $conversation->unread_count }} new</span>
                                    @endif
                                </h5>
                                @if($conversation->user)
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-user"></i> {{ $conversation->user->name }}
                                    </p>
                                @else
                                    <p class="text-sm text-gray-500">{{ $conversation->formatted_phone }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                @php
                                    $statusColors = [
                                        'open' => 'bg-green-100 text-green-800',
                                        'closed' => 'bg-gray-100 text-gray-800',
                                        'archived' => 'bg-yellow-100 text-yellow-800'
                                    ];
                                    $statusColor = $statusColors[$conversation->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                    {{ ucfirst($conversation->status) }}
                                </span>
                                @if($conversation->assignedTo)
                                    <p class="text-xs text-gray-500 mt-1">
                                        <i class="fas fa-user-tag"></i> {{ $conversation->assignedTo->name }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        @if($conversation->last_message_preview)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 truncate mb-1">
                                    {{ $conversation->last_message_preview }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    <i class="fas fa-clock"></i> {{ $conversation->last_message_at?->diffForHumans() }}
                                </p>
                            </div>
                        @endif

                        <div class="flex justify-between items-center">
                            <a href="{{ route('admin.whatsapp.conversations.show', $conversation) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                <i class="fas fa-comments mr-2"></i> Open Chat
                            </a>

                            @if($conversation->status === 'open')
                                <form action="{{ route('admin.whatsapp.conversations.close', $conversation) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                        <i class="fas fa-times mr-2"></i> Close
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <div class="col-span-2">
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="text-center py-12">
                        <i class="fas fa-comments text-gray-400 text-5xl mb-4"></i>
                        <p class="text-gray-500">No conversations found</p>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @if($conversations->hasPages())
        <div class="mt-6">
            {{ $conversations->links() }}
        </div>
    @endif
</div>
</x-layouts.admin>
