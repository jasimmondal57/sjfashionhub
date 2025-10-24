<x-layouts.admin title="Announcement Bars" description="Manage announcement bars">
    <div class="space-y-6">
        <!-- Header -->
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-black">Announcement Bars</h1>
        </div>

        <!-- Header Actions -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <p class="text-gray-600">Manage announcement bars displayed at the top of your website</p>
            </div>
            <div class="flex space-x-3">
                <button onclick="toggleSortMode()" id="sortToggle" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                    </svg>
                    <span class="sort-btn-text">Sort Bars</span>
                </button>
                <a href="{{ route('admin.announcement-bars.create') }}" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Bar
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <!-- Total -->
            <div class="bg-white rounded-lg border border-gray-100 p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-black rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600">Total</p>
                        <p class="text-xl font-bold text-black">{{ $stats['total'] }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Active -->
            <div class="bg-white rounded-lg border border-gray-100 p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600">Active</p>
                        <p class="text-xl font-bold text-black">{{ $stats['active'] }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Inactive -->
            <div class="bg-white rounded-lg border border-gray-100 p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-gray-500 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728L5.636 5.636m12.728 12.728L18.364 5.636M5.636 18.364l12.728-12.728"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600">Inactive</p>
                        <p class="text-xl font-bold text-black">{{ $stats['inactive'] }}</p>
                    </div>
                </div>
            </div>
            
            <!-- Scrolling -->
            <div class="bg-white rounded-lg border border-gray-100 p-4">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-600">Scrolling</p>
                        <p class="text-xl font-bold text-black">{{ $stats['scrolling'] }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sort Mode Notification -->
        <div id="sortNotification" class="hidden bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div class="flex-1">
                    <h4 class="text-sm font-medium text-blue-800">Sort Mode Active</h4>
                    <p class="text-sm text-blue-700">Drag and drop announcement bars to reorder them. Changes are saved automatically.</p>
                </div>
                <button onclick="toggleSortMode()" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Exit Sort Mode
                </button>
            </div>
        </div>

        <!-- Announcement Bars Table -->
        <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <span class="sort-handle-header hidden">⋮⋮</span>
                                <span class="normal-header">Message</span>
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Colors</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Links</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Settings</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="sortableTable" class="bg-white divide-y divide-gray-200">
                        @forelse($announcementBars as $bar)
                            <tr class="hover:bg-gray-50 sortable-row" data-bar-id="{{ $bar->id }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <!-- Drag Handle -->
                                        <div class="drag-handle hidden mr-3 cursor-move text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-black">{{ Str::limit($bar->message, 60) }}</div>
                                            <div class="text-xs text-gray-400">Sort Order: #{{ $bar->sort_order }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <div class="w-6 h-6 rounded border border-gray-200" style="background-color: {{ $bar->background_color }}"></div>
                                        <div class="w-6 h-6 rounded border border-gray-200" style="background-color: {{ $bar->text_color }}"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">BG / Text</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($bar->links && count($bar->links) > 0)
                                        <div class="text-sm text-gray-900">{{ count($bar->links) }} link(s)</div>
                                        <div class="text-xs text-gray-500">
                                            @foreach(array_slice($bar->links, 0, 2) as $link)
                                                {{ $link['text'] }}@if(!$loop->last), @endif
                                            @endforeach
                                            @if(count($bar->links) > 2)
                                                ...
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-400">No links</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        @if($bar->is_scrolling)
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Scrolling ({{ $bar->scroll_speed }}px/s)
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Static
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="{{ route('admin.announcement-bars.toggle', $bar) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded {{ $bar->is_active ? 'text-green-700 bg-green-100 hover:bg-green-200' : 'text-red-700 bg-red-100 hover:bg-red-200' }}">
                                            {{ $bar->is_active ? 'Active' : 'Inactive' }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                    <a href="{{ route('admin.announcement-bars.show', $bar) }}" class="text-black hover:text-gray-700">View</a>
                                    <a href="{{ route('admin.announcement-bars.edit', $bar) }}" class="text-black hover:text-gray-700">Edit</a>
                                    <button onclick="deleteBar({{ $bar->id }})" class="text-red-600 hover:text-red-900">Delete</button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center">
                                    <div class="text-gray-500">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                                        </svg>
                                        <h3 class="mt-2 text-sm font-medium text-gray-900">No announcement bars</h3>
                                        <p class="mt-1 text-sm text-gray-500">Get started by creating a new announcement bar.</p>
                                        <div class="mt-6">
                                            <a href="{{ route('admin.announcement-bars.create') }}" class="btn btn-primary">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                                </svg>
                                                Add New Bar
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Include SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>

    <script>
        let sortMode = false;
        let sortable = null;

        function toggleSortMode() {
            sortMode = !sortMode;
            const notification = document.getElementById('sortNotification');
            const toggleBtn = document.getElementById('sortToggle');
            const dragHandles = document.querySelectorAll('.drag-handle');
            const sortHandleHeader = document.querySelector('.sort-handle-header');
            const normalHeader = document.querySelector('.normal-header');

            if (sortMode) {
                // Enable sort mode
                notification.classList.remove('hidden');
                document.querySelector('.sort-btn-text').textContent = 'Exit Sort Mode';
                toggleBtn.classList.remove('btn-secondary');
                toggleBtn.classList.add('btn-danger');
                
                // Show drag handles
                dragHandles.forEach(handle => handle.classList.remove('hidden'));
                sortHandleHeader.classList.remove('hidden');
                normalHeader.classList.add('hidden');

                // Initialize sortable
                const table = document.getElementById('sortableTable');
                sortable = Sortable.create(table, {
                    handle: '.drag-handle',
                    animation: 150,
                    ghostClass: 'sortable-ghost',
                    chosenClass: 'sortable-chosen',
                    dragClass: 'sortable-drag',
                    onEnd: function(evt) {
                        updateSortOrder();
                    }
                });
            } else {
                // Disable sort mode
                notification.classList.add('hidden');
                document.querySelector('.sort-btn-text').textContent = 'Sort Bars';
                toggleBtn.classList.remove('btn-danger');
                toggleBtn.classList.add('btn-secondary');
                
                // Hide drag handles
                dragHandles.forEach(handle => handle.classList.add('hidden'));
                sortHandleHeader.classList.add('hidden');
                normalHeader.classList.remove('hidden');

                // Destroy sortable
                if (sortable) {
                    sortable.destroy();
                    sortable = null;
                }
            }
        }

        function updateSortOrder() {
            const rows = document.querySelectorAll('.sortable-row');
            const barIds = Array.from(rows).map(row => row.dataset.barId);
            
            fetch('/admin/announcement-bars/sort', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    announcement_bar_ids: barIds
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update sort order numbers in the table
                    rows.forEach((row, index) => {
                        const sortOrderCell = row.querySelector('.text-xs.text-gray-400');
                        if (sortOrderCell) {
                            sortOrderCell.textContent = `Sort Order: #${index + 1}`;
                        }
                    });
                } else {
                    alert('Failed to update sort order. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to update sort order. Please try again.');
            });
        }

        function deleteBar(barId) {
            if (confirm('Are you sure you want to delete this announcement bar? This action cannot be undone.')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/announcement-bars/${barId}`;
                form.innerHTML = `
                    @csrf
                    @method('DELETE')
                `;
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>

    <style>
        .sortable-ghost {
            opacity: 0.4;
            background: #f3f4f6;
        }
        
        .sortable-chosen {
            background: #e5e7eb;
        }
        
        .sortable-drag {
            background: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .drag-handle {
            transition: all 0.2s ease;
        }
        
        .drag-handle:hover {
            transform: scale(1.1);
        }
    </style>
</x-layouts.admin>
