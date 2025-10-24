<x-layouts.user title="Support Ticket #{{ $contact->id }}" subtitle="View ticket details and conversation history">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('user.support.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Support Tickets
            </a>
        </div>

        <!-- Ticket Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <h1 class="text-2xl font-bold text-gray-900">Support Ticket</h1>
                    <span class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-lg font-bold">
                        #{{ $contact->id }}
                    </span>
                </div>
                @php
                    $statusColors = [
                        'new' => 'bg-green-100 text-green-800',
                        'in_progress' => 'bg-yellow-100 text-yellow-800',
                        'resolved' => 'bg-blue-100 text-blue-800',
                        'closed' => 'bg-gray-100 text-gray-800'
                    ];
                @endphp
                <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusColors[$contact->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst(str_replace('_', ' ', $contact->status)) }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">📋 Ticket Information</h3>
                    <dl class="space-y-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Subject</dt>
                            <dd class="text-sm text-gray-900">{{ ucfirst(str_replace('_', ' ', $contact->subject)) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Created</dt>
                            <dd class="text-sm text-gray-900">{{ $contact->created_at->format('F j, Y \a\t g:i A') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="text-sm text-gray-900">{{ $contact->updated_at->format('F j, Y \a\t g:i A') }}</dd>
                        </div>
                        @if($contact->resolved_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Resolved</dt>
                            <dd class="text-sm text-gray-900">{{ $contact->resolved_at->format('F j, Y \a\t g:i A') }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-3">📊 Statistics</h3>
                    <dl class="space-y-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Replies</dt>
                            <dd class="text-sm text-gray-900">{{ $contact->replies()->count() }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Your Replies</dt>
                            <dd class="text-sm text-gray-900">{{ $contact->replies()->userReplies()->count() }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Admin Replies</dt>
                            <dd class="text-sm text-gray-900">{{ $contact->replies()->adminReplies()->publicReplies()->count() }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>

        <!-- Original Message -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">📝 Original Message</h3>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="whitespace-pre-wrap text-gray-700">{{ $contact->message }}</div>
            </div>
        </div>

        <!-- Conversation History -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">💬 Conversation History</h3>
            
            <div class="space-y-4 max-h-96 overflow-y-auto">
                @forelse($contact->replies()->publicReplies()->with('user')->orderBy('created_at', 'asc')->get() as $reply)
                    <div class="border rounded-lg p-4 {{ $reply->sender_type === 'admin' ? 'bg-blue-50 border-blue-200 ml-4' : 'bg-green-50 border-green-200 mr-4' }}">
                        <div class="flex justify-between items-start mb-2">
                            <div class="flex items-center space-x-2">
                                @if($reply->sender_type === 'admin')
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded-full text-xs font-semibold">Support Team</span>
                                @else
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs font-semibold">You</span>
                                @endif
                                <span class="text-sm font-medium text-gray-900">{{ $reply->sender_display_name }}</span>
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
                        <p>No replies yet. Our support team will respond soon!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Reply Form -->
        @if($contact->status !== 'closed')
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">✍️ Add Your Reply</h3>
                
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                <form action="{{ route('user.support.reply', $contact) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">Your Message</label>
                        <textarea id="message" name="message" rows="4" required
                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-black focus:border-transparent"
                                  placeholder="Type your reply here..."></textarea>
                        @error('message')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            <p>💡 <strong>Tip:</strong> Be specific about your issue for faster resolution.</p>
                        </div>
                        <button type="submit" class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition-colors">
                            Send Reply
                        </button>
                    </div>
                </form>
            </div>
        @else
            <div class="bg-gray-50 rounded-lg border border-gray-200 p-6 text-center">
                <svg class="w-12 h-12 mx-auto mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Ticket Closed</h3>
                <p class="text-gray-600">This ticket has been closed and no longer accepts replies.</p>
                <p class="text-gray-600 mt-2">If you need further assistance, please <a href="{{ route('contact') }}" class="text-black hover:text-gray-700 font-medium">create a new support request</a>.</p>
            </div>
        @endif

        <!-- Help Section -->
        <div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg p-6 border border-blue-200">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">🆘 Need Additional Help?</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">📞 Direct Contact</h4>
                    <p class="text-sm text-gray-600 mb-1">Email: {{ config('mail.admin_email', 'admin@sjfashionhub.com') }}</p>
                    <p class="text-sm text-gray-600">Include your ticket number (#{{ $contact->id }}) for faster service</p>
                </div>
                <div>
                    <h4 class="font-medium text-gray-900 mb-2">🔄 What's Next?</h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Our team typically responds within 24 hours</li>
                        <li>• You'll receive email notifications for replies</li>
                        <li>• Check this page for real-time updates</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.user>
