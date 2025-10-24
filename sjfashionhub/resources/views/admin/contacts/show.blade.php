<x-layouts.admin>
    <x-slot name="pageTitle">Contact Message - {{ $contact->full_name }}</x-slot>

    <div class="px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-2xl font-semibold text-gray-900">Contact Message</h1>
                    <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-lg font-bold">
                        Ticket #{{ $contact->id }}
                    </span>
                </div>
                <p class="text-gray-600">From {{ $contact->full_name }}</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.contacts.index') }}" 
                   class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    Back to List
                </a>
                @if($contact->status !== 'resolved')
                    <form action="{{ route('admin.contacts.mark-resolved', $contact) }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                            Mark as Resolved
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Contact Message -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <div class="border-b border-gray-200 pb-4 mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">{{ $contact->subject }}</h2>
                        <div class="mt-2 flex items-center space-x-4 text-sm text-gray-500">
                            <span>{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</span>
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                @if($contact->status === 'new') bg-red-100 text-red-800
                                @elseif($contact->status === 'in_progress') bg-yellow-100 text-yellow-800
                                @elseif($contact->status === 'resolved') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst(str_replace('_', ' ', $contact->status)) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="prose max-w-none">
                        <p class="text-gray-700 whitespace-pre-wrap">{{ $contact->message }}</p>
                    </div>
                </div>

                <!-- Update Status Form -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Update Status & Notes</h3>
                    
                    <form action="{{ route('admin.contacts.update', $contact) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="status" id="status" 
                                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="new" {{ $contact->status === 'new' ? 'selected' : '' }}>New</option>
                                <option value="in_progress" {{ $contact->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ $contact->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="closed" {{ $contact->status === 'closed' ? 'selected' : '' }}>Closed</option>
                            </select>
                        </div>

                        <div>
                            <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes</label>
                            <textarea name="admin_notes" id="admin_notes" rows="4" 
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Add internal notes about this contact...">{{ $contact->admin_notes }}</textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Update
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Reply Section -->
                <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">💬 Conversation History</h3>

                    <!-- Replies List -->
                    <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                        @forelse($contact->replies as $reply)
                            <div class="border rounded-lg p-4 {{ $reply->sender_type === 'admin' ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' }}">
                                <div class="flex justify-between items-start mb-2">
                                    <div class="flex items-center space-x-2">
                                        @if($reply->sender_type === 'admin')
                                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">Admin</span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs font-semibold">Customer</span>
                                        @endif
                                        <span class="text-sm font-medium text-gray-900">{{ $reply->sender_display_name }}</span>
                                        @if($reply->is_internal_note)
                                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded-full text-xs font-semibold">Internal Note</span>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-500">{{ $reply->created_at->format('M j, Y g:i A') }}</span>
                                </div>
                                <div class="text-sm text-gray-700 whitespace-pre-wrap">{{ $reply->message }}</div>
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                                </svg>
                                <p>No replies yet. Be the first to respond!</p>
                            </div>
                        @endforelse
                    </div>

                    <!-- Reply Form -->
                    <form action="{{ route('admin.contacts.reply', $contact) }}" method="POST" class="border-t pt-6">
                        @csrf
                        <div class="mb-4">
                            <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Your Reply</label>
                            <textarea id="message" name="message" rows="4" required
                                      class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                      placeholder="Type your reply to the customer..."></textarea>
                            @error('message')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_internal_note" value="1" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-600">Internal note (not sent to customer)</span>
                                </label>
                            </div>
                            <div class="flex space-x-3">
                                <button type="submit" name="action" value="reply"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Send Reply
                                </button>
                                <button type="submit" name="action" value="reply_and_resolve"
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                    Reply & Mark Resolved
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Contact Information</h3>
                    
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Name</label>
                            <p class="text-sm text-gray-900">{{ $contact->full_name }}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">Email</label>
                            <p class="text-sm text-gray-900">
                                <a href="mailto:{{ $contact->email }}" class="text-blue-600 hover:text-blue-800">
                                    {{ $contact->email }}
                                </a>
                            </p>
                        </div>
                        
                        @if($contact->phone)
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Phone</label>
                                <p class="text-sm text-gray-900">
                                    <a href="tel:{{ $contact->phone }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $contact->phone }}
                                    </a>
                                </p>
                            </div>
                        @endif
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-500">IP Address</label>
                            <p class="text-sm text-gray-900">{{ $contact->ip_address ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Resolution Information -->
                @if($contact->status === 'resolved' && $contact->resolved_at)
                    <div class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Resolution Details</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Resolved At</label>
                                <p class="text-sm text-gray-900">{{ $contact->resolved_at->format('F j, Y \a\t g:i A') }}</p>
                            </div>
                            
                            @if($contact->resolvedBy)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Resolved By</label>
                                    <p class="text-sm text-gray-900">{{ $contact->resolvedBy->name }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-sm p-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                    
                    <div class="space-y-3">
                        <a href="mailto:{{ $contact->email }}?subject=Re: {{ $contact->subject }}" 
                           class="w-full inline-flex justify-center items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            Reply via Email
                        </a>
                        
                        @if($contact->phone)
                            <a href="tel:{{ $contact->phone }}" 
                               class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                </svg>
                                Call
                            </a>
                        @endif
                        
                        <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this contact message?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
