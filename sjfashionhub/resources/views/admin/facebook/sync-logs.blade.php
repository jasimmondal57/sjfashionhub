<x-layouts.admin>
    <x-slot name="pageTitle">Facebook Sync Logs</x-slot>

<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">📋 Facebook Sync Logs</h1>
        <a href="{{ route('admin.facebook.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 rounded-md bg-green-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h6 class="text-base font-semibold text-gray-900">Sync History</h6>
        </div>
        <div class="overflow-x-auto">
            @if($logs->count() > 0)
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sync Type</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Synced</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Failed</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Started</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completed</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Error</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($logs as $log)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $log->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">
                                        {{ ucfirst(str_replace('_', ' ', $log->sync_type)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'completed' => 'bg-green-100 text-green-800',
                                            'failed' => 'bg-red-100 text-red-800',
                                            'running' => 'bg-blue-100 text-blue-800',
                                            'partial' => 'bg-yellow-100 text-yellow-800'
                                        ];
                                        $statusColor = $statusColors[$log->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusColor }}">
                                        {{ ucfirst($log->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($log->products_synced > 0)
                                        <span class="font-semibold text-green-600">{{ $log->products_synced }}</span>
                                    @else
                                        <span class="text-gray-900">{{ $log->products_synced }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($log->products_failed > 0)
                                        <span class="font-semibold text-red-600">{{ $log->products_failed }}</span>
                                    @else
                                        <span class="text-gray-900">{{ $log->products_failed }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    @if($log->duration)
                                        {{ $log->duration }}s
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ $log->started_at ? $log->started_at->format('M d, Y H:i:s') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-500">
                                    {{ $log->completed_at ? $log->completed_at->format('M d, Y H:i:s') : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    @if($log->error_message)
                                        <button type="button" class="inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-red-600 hover:bg-red-700" onclick="document.getElementById('errorModal{{ $log->id }}').classList.remove('hidden')">
                                            <i class="fas fa-exclamation-circle mr-1"></i> View Error
                                        </button>

                                        <!-- Error Modal -->
                                        <div id="errorModal{{ $log->id }}" class="hidden fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50">
                                            <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4">
                                                <div class="px-6 py-4 bg-red-600 text-white rounded-t-lg flex justify-between items-center">
                                                    <h3 class="text-lg font-semibold">Sync Error Details</h3>
                                                    <button type="button" onclick="document.getElementById('errorModal{{ $log->id }}').classList.add('hidden')" class="text-white hover:text-gray-200">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                <div class="px-6 py-4">
                                                    <p class="mb-2"><strong class="text-gray-700">Sync Type:</strong> <span class="text-gray-900">{{ ucfirst(str_replace('_', ' ', $log->sync_type)) }}</span></p>
                                                    <p class="mb-4"><strong class="text-gray-700">Time:</strong> <span class="text-gray-900">{{ $log->started_at->format('M d, Y H:i:s') }}</span></p>
                                                    <hr class="my-4">
                                                    <p class="mb-2"><strong class="text-gray-700">Error Message:</strong></p>
                                                    <pre class="bg-gray-100 p-3 rounded text-sm text-gray-900 overflow-auto">{{ $log->error_message }}</pre>

                                                    @if($log->details)
                                                        <p class="mt-4 mb-2"><strong class="text-gray-700">Additional Details:</strong></p>
                                                        <pre class="bg-gray-100 p-3 rounded text-sm text-gray-900 overflow-auto">{{ json_encode($log->details, JSON_PRETTY_PRINT) }}</pre>
                                                    @endif
                                                </div>
                                                <div class="px-6 py-4 border-t border-gray-200 flex justify-end">
                                                    <button type="button" onclick="document.getElementById('errorModal{{ $log->id }}').classList.add('hidden')" class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                                        Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-gray-500">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                @if($logs->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $logs->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-12">
                    <i class="fas fa-history text-gray-400 text-5xl mb-4"></i>
                    <p class="text-gray-500 mb-4">No sync logs found</p>
                    <a href="{{ route('admin.facebook.index') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-sync mr-2"></i> Start Your First Sync
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Summary Stats -->
    @if($logs->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 mt-6">
            <div class="bg-white rounded-lg shadow-sm border-l-4 border-green-500 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-green-600 uppercase mb-1">Total Syncs</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $logs->total() }}</div>
                    </div>
                    <div>
                        <i class="fas fa-sync text-3xl text-gray-300"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border-l-4 border-green-500 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-green-600 uppercase mb-1">Completed</div>
                        <div class="text-2xl font-bold text-gray-800">
                            {{ $logs->where('status', 'completed')->count() }}
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-check-circle text-3xl text-gray-300"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border-l-4 border-red-500 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-red-600 uppercase mb-1">Failed</div>
                        <div class="text-2xl font-bold text-gray-800">
                            {{ $logs->where('status', 'failed')->count() }}
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-exclamation-triangle text-3xl text-gray-300"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm border-l-4 border-blue-500 p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-blue-600 uppercase mb-1">Products Synced</div>
                        <div class="text-2xl font-bold text-gray-800">
                            {{ $logs->sum('products_synced') }}
                        </div>
                    </div>
                    <div>
                        <i class="fas fa-box text-3xl text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
</x-layouts.admin>

