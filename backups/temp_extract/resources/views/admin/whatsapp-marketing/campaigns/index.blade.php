<x-layouts.admin>
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">WhatsApp Campaigns</h1>
                    <p class="text-gray-600 mt-1">Manage your WhatsApp marketing campaigns</p>
                </div>
                <a href="{{ route('admin.whatsapp-marketing.campaigns.create') }}" 
                   class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    + Create Campaign
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="text-sm text-gray-600">Total Campaigns</div>
                <div class="text-2xl font-bold text-gray-900 mt-1">{{ $campaigns->total() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="text-sm text-gray-600">Sent</div>
                <div class="text-2xl font-bold text-green-600 mt-1">{{ $campaigns->where('status', 'sent')->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="text-sm text-gray-600">Scheduled</div>
                <div class="text-2xl font-bold text-blue-600 mt-1">{{ $campaigns->where('status', 'scheduled')->count() }}</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
                <div class="text-sm text-gray-600">Draft</div>
                <div class="text-2xl font-bold text-gray-600 mt-1">{{ $campaigns->where('status', 'draft')->count() }}</div>
            </div>
        </div>

        <!-- Campaigns List -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200">
            @if($campaigns->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No campaigns</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new campaign.</p>
                    <div class="mt-6">
                        <a href="{{ route('admin.whatsapp-marketing.campaigns.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                            + Create Campaign
                        </a>
                    </div>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Campaign
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Template
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Recipients
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Sent/Total
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created
                                </th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($campaigns as $campaign)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900">{{ $campaign->name }}</div>
                                        @if($campaign->scheduled_at)
                                            <div class="text-sm text-gray-500">
                                                Scheduled: {{ $campaign->scheduled_at->format('M d, Y H:i') }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $campaign->template->display_name ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">{{ $campaign->template->category ?? '' }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $campaign->total_recipients ?? 0 }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($campaign->status === 'sent')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Sent
                                            </span>
                                        @elseif($campaign->status === 'sending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                Sending
                                            </span>
                                        @elseif($campaign->status === 'scheduled')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Scheduled
                                            </span>
                                        @elseif($campaign->status === 'failed')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Failed
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ ucfirst($campaign->status) }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        {{ $campaign->sent_count ?? 0 }} / {{ $campaign->total_recipients ?? 0 }}
                                        @if($campaign->total_recipients > 0)
                                            <div class="text-xs text-gray-500">
                                                {{ round(($campaign->sent_count / $campaign->total_recipients) * 100) }}%
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ $campaign->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm font-medium">
                                        <a href="{{ route('admin.whatsapp-marketing.campaigns.show', $campaign) }}" 
                                           class="text-blue-600 hover:text-blue-900 mr-3">
                                            View
                                        </a>
                                        @if($campaign->status === 'draft')
                                            <form action="{{ route('admin.whatsapp-marketing.campaigns.delete', $campaign) }}"
                                                  method="POST" class="inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this campaign?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    Delete
                                                </button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($campaigns->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $campaigns->links() }}
                    </div>
                @endif
            @endif
        </div>
    </div>
</x-layouts.admin>

