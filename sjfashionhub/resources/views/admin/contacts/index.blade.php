<x-layouts.admin>
    <x-slot name="pageTitle">Contact Messages</x-slot>

    <div class="px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Contact Messages</h1>
                <p class="text-gray-600">Manage customer inquiries and support requests</p>
            </div>
        </div>

        <!-- Status Filter Tabs -->
        <div class="mb-6">
            <div class="border-b border-gray-200">
                <nav class="-mb-px flex space-x-8">
                    <a href="{{ route('admin.contacts.index') }}" 
                       class="py-2 px-1 border-b-2 font-medium text-sm {{ !request('status') ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        All ({{ $statusCounts['all'] }})
                    </a>
                    <a href="{{ route('admin.contacts.index', ['status' => 'new']) }}" 
                       class="py-2 px-1 border-b-2 font-medium text-sm {{ request('status') === 'new' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        New ({{ $statusCounts['new'] }})
                    </a>
                    <a href="{{ route('admin.contacts.index', ['status' => 'in_progress']) }}" 
                       class="py-2 px-1 border-b-2 font-medium text-sm {{ request('status') === 'in_progress' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        In Progress ({{ $statusCounts['in_progress'] }})
                    </a>
                    <a href="{{ route('admin.contacts.index', ['status' => 'resolved']) }}" 
                       class="py-2 px-1 border-b-2 font-medium text-sm {{ request('status') === 'resolved' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Resolved ({{ $statusCounts['resolved'] }})
                    </a>
                    <a href="{{ route('admin.contacts.index', ['status' => 'closed']) }}" 
                       class="py-2 px-1 border-b-2 font-medium text-sm {{ request('status') === 'closed' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                        Closed ({{ $statusCounts['closed'] }})
                    </a>
                </nav>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <form method="GET" action="{{ route('admin.contacts.index') }}" class="flex gap-4">
                <input type="hidden" name="status" value="{{ request('status') }}">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by ticket ID, name, email, subject, or message..."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div class="flex-shrink-0">
                    <input type="text" name="ticket_id" value="{{ request('ticket_id') }}"
                           placeholder="Ticket #"
                           class="w-24 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('admin.contacts.index', ['status' => request('status')]) }}"
                       class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Bulk Actions -->
        @if($contacts->count() > 0)
            <div class="mb-6 flex gap-3 items-center">
                <button type="button" onclick="toggleSelectAll()"
                        class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                    Select All
                </button>
                <button type="button" onclick="deleteSelected()" id="deleteSelectedBtn"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 disabled:opacity-50 disabled:cursor-not-allowed"
                        disabled>
                    Delete Selected
                </button>
                <form action="{{ route('admin.contacts.delete-page-messages') }}" method="POST" class="inline"
                      onsubmit="return confirm('Are you sure you want to delete all messages on this page?');">
                    @csrf
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <button type="submit" class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700">
                        Delete Page Messages
                    </button>
                </form>
                <form action="{{ route('admin.contacts.delete-all-messages') }}" method="POST" class="inline"
                      onsubmit="return confirm('⚠️ WARNING: This will delete ALL contact messages permanently. Are you absolutely sure?');">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-800 text-white rounded-lg hover:bg-red-900">
                        Delete All Messages
                    </button>
                </form>
            </div>
        @endif

        <!-- Contacts Table -->
        <div class="bg-white rounded-lg shadow-sm">
            @if($contacts->count() > 0)
                <div class="overflow-x-auto">
                    <form id="bulkDeleteForm" action="{{ route('admin.contacts.bulk-delete') }}" method="POST">
                        @csrf
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()" class="rounded">
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ticket ID</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($contacts as $contact)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <input type="checkbox" name="ids[]" value="{{ $contact->id }}"
                                                   class="contact-checkbox rounded" onchange="updateDeleteButton()">
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">
                                                    #{{ $contact->id }}
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $contact->full_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $contact->email }}</div>
                                                @if($contact->phone)
                                                    <div class="text-sm text-gray-500">{{ $contact->phone }}</div>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">{{ $contact->subject }}</div>
                                            <div class="text-sm text-gray-500">{{ Str::limit($contact->message, 100) }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                                @if($contact->status === 'new') bg-red-100 text-red-800
                                                @elseif($contact->status === 'in_progress') bg-yellow-100 text-yellow-800
                                                @elseif($contact->status === 'resolved') bg-green-100 text-green-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ ucfirst(str_replace('_', ' ', $contact->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $contact->created_at->format('M j, Y') }}
                                            <div class="text-xs text-gray-400">{{ $contact->created_at->format('g:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <div class="flex space-x-2">
                                                <a href="{{ route('admin.contacts.show', $contact) }}"
                                                   class="text-blue-600 hover:text-blue-900">View</a>
                                                @if($contact->status !== 'resolved')
                                                    <form action="{{ route('admin.contacts.mark-resolved', $contact) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="text-green-600 hover:text-green-900">Resolve</button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline"
                                                      onsubmit="return confirm('Are you sure you want to delete this contact message?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </form>
                </div>
                
                @if($contacts->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $contacts->appends(request()->query())->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No contact messages</h3>
                    <p class="mt-1 text-sm text-gray-500">No contact messages found matching your criteria.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const contactCheckboxes = document.querySelectorAll('.contact-checkbox');

            contactCheckboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });

            updateDeleteButton();
        }

        function updateDeleteButton() {
            const contactCheckboxes = document.querySelectorAll('.contact-checkbox:checked');
            const deleteBtn = document.getElementById('deleteSelectedBtn');

            if (contactCheckboxes.length > 0) {
                deleteBtn.disabled = false;
            } else {
                deleteBtn.disabled = true;
            }
        }

        function deleteSelected() {
            const contactCheckboxes = document.querySelectorAll('.contact-checkbox:checked');

            if (contactCheckboxes.length === 0) {
                alert('Please select at least one contact message to delete.');
                return;
            }

            if (confirm(`Are you sure you want to delete ${contactCheckboxes.length} contact message(s)?`)) {
                document.getElementById('bulkDeleteForm').submit();
            }
        }
    </script>
</x-layouts.admin>
