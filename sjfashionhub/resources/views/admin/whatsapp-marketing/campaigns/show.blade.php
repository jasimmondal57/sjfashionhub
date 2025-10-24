<x-layouts.admin>
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $campaign->name }}</h1>
                    <p class="text-gray-600 mt-1">Campaign Details</p>
                </div>
                <a href="{{ route('admin.whatsapp-marketing.campaigns') }}" 
                   class="text-blue-600 hover:text-blue-700">
                    ← Back to Campaigns
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Campaign Info -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Campaign Information</h2>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Status:</span>
                            <span>
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
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Template:</span>
                            <span class="font-medium">{{ $campaign->template->display_name ?? 'N/A' }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Total Recipients:</span>
                            <span class="font-medium">{{ $campaign->total_recipients ?? 0 }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Messages Sent:</span>
                            <span class="font-medium">{{ $campaign->sent_count ?? 0 }}</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Failed:</span>
                            <span class="font-medium text-red-600">{{ $campaign->failed_count ?? 0 }}</span>
                        </div>

                        @if($campaign->scheduled_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Scheduled For:</span>
                                <span class="font-medium">{{ $campaign->scheduled_at->format('M d, Y H:i') }}</span>
                            </div>
                        @endif

                        @if($campaign->sent_at)
                            <div class="flex justify-between">
                                <span class="text-gray-600">Sent At:</span>
                                <span class="font-medium">{{ $campaign->sent_at->format('M d, Y H:i') }}</span>
                            </div>
                        @endif

                        <div class="flex justify-between">
                            <span class="text-gray-600">Created:</span>
                            <span class="font-medium">{{ $campaign->created_at->format('M d, Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Template Preview -->
                @if($campaign->template)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Template Preview</h2>
                        
                        <div class="max-w-sm mx-auto bg-gray-50 rounded-lg p-4">
                            @if($campaign->template->header_text)
                                <div class="font-semibold text-gray-900 mb-2">
                                    {{ $campaign->template->header_text }}
                                </div>
                            @endif

                            <div class="text-gray-700 text-sm whitespace-pre-wrap mb-2">
                                {{ $campaign->template->body_text }}
                            </div>

                            @if($campaign->template->footer_text)
                                <div class="text-gray-500 text-xs">
                                    {{ $campaign->template->footer_text }}
                                </div>
                            @endif

                            @if($campaign->template->buttons && count($campaign->template->buttons) > 0)
                                <div class="mt-3 space-y-2">
                                    @foreach($campaign->template->buttons as $button)
                                        <div class="text-center py-2 border border-blue-500 text-blue-600 rounded-lg text-sm">
                                            {{ $button['text'] ?? '' }}
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Recipients List -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Recipients</h2>
                    
                    @if($campaign->recipients && count($campaign->recipients) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Sent At</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($campaign->recipients as $recipient)
                                        <tr>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $recipient->phone_number ?? 'N/A' }}</td>
                                            <td class="px-4 py-2 text-sm text-gray-900">{{ $recipient->user->name ?? 'N/A' }}</td>
                                            <td class="px-4 py-2 text-sm">
                                                @if($recipient->status === 'sent')
                                                    <span class="text-green-600">✓ Sent</span>
                                                @elseif($recipient->status === 'failed')
                                                    <span class="text-red-600">✗ Failed</span>
                                                @else
                                                    <span class="text-gray-600">Pending</span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-2 text-sm text-gray-500">
                                                {{ $recipient->sent_at ? $recipient->sent_at->format('M d, H:i') : '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-500 text-sm">No recipients data available.</p>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Stats Card -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Delivery Rate</span>
                                <span class="font-medium">
                                    {{ $campaign->total_recipients > 0 ? round(($campaign->sent_count / $campaign->total_recipients) * 100) : 0 }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-green-600 h-2 rounded-full" 
                                     style="width: {{ $campaign->total_recipients > 0 ? round(($campaign->sent_count / $campaign->total_recipients) * 100) : 0 }}%"></div>
                            </div>
                        </div>

                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-gray-600">Failed Rate</span>
                                <span class="font-medium text-red-600">
                                    {{ $campaign->total_recipients > 0 ? round(($campaign->failed_count / $campaign->total_recipients) * 100) : 0 }}%
                                </span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-red-600 h-2 rounded-full" 
                                     style="width: {{ $campaign->total_recipients > 0 ? round(($campaign->failed_count / $campaign->total_recipients) * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                    
                    <div class="space-y-3">
                        @if($campaign->status === 'draft')
                            <form action="{{ route('admin.whatsapp-marketing.campaigns.start', $campaign) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                                        onclick="return confirm('Are you sure you want to send this campaign?')">
                                    Send Now
                                </button>
                            </form>
                        @endif

                        @if($campaign->status === 'scheduled')
                            <form action="{{ route('admin.whatsapp-marketing.campaigns.pause', $campaign) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors"
                                        onclick="return confirm('Are you sure you want to cancel this scheduled campaign?')">
                                    Cancel Schedule
                                </button>
                            </form>
                        @endif

                        @if($campaign->status === 'draft')
                            <form action="{{ route('admin.whatsapp-marketing.campaigns.delete', $campaign) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this campaign?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                                    Delete Campaign
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>

