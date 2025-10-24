<x-layouts.admin>
    <x-slot name="pageTitle">Chat with {{ $conversation->customer_name ?? $conversation->formatted_phone }}</x-slot>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Chat with {{ $conversation->customer_name ?? $conversation->formatted_phone }}
        </h1>
        <a href="{{ route('admin.whatsapp.conversations.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back to Conversations
        </a>
    </div>

    <div class="row">
        <!-- Chat Area -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="m-0 font-weight-bold">
                                {{ $conversation->customer_name ?? 'Customer' }}
                            </h6>
                            <small>{{ $conversation->formatted_phone }}</small>
                        </div>
                        <span class="badge badge-light">
                            {{ ucfirst($conversation->status) }}
                        </span>
                    </div>
                </div>
                
                <!-- Messages -->
                <div class="card-body" style="height: 500px; overflow-y: auto;" id="chatMessages">
                    @if($messages->count() > 0)
                        @foreach($messages as $message)
                            <div class="mb-3 {{ $message->direction === 'outbound' ? 'text-right' : 'text-left' }}">
                                <div class="d-inline-block" style="max-width: 70%;">
                                    <div class="p-3 rounded {{ $message->direction === 'outbound' ? 'bg-primary text-white' : 'bg-light' }}">
                                        <p class="mb-1">{{ $message->content }}</p>
                                        @if($message->media && count($message->media) > 0)
                                            <div class="mt-2">
                                                @foreach($message->media as $mediaUrl)
                                                    <img src="{{ $mediaUrl }}" class="img-fluid rounded" style="max-width: 200px;">
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <small class="text-muted d-block mt-1">
                                        {{ $message->created_at->format('M d, Y h:i A') }}
                                        @if($message->direction === 'outbound')
                                            <span class="badge badge-sm {{ $message->status_badge }}">{{ $message->status }}</span>
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-comments fa-3x mb-3"></i>
                            <p>No messages yet. Start the conversation!</p>
                        </div>
                    @endif
                </div>

                <!-- Send Message Form -->
                <div class="card-footer">
                    <form action="{{ route('admin.whatsapp.conversations.send', $conversation) }}" method="POST">
                        @csrf
                        <div class="input-group">
                            <textarea name="message" class="form-control" rows="2" placeholder="Type your message..." required></textarea>
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Send
                                </button>
                            </div>
                        </div>
                        <small class="text-muted">
                            <i class="fas fa-info-circle"></i> Note: You can only send messages within 24 hours of customer's last message, or use approved templates.
                        </small>
                    </form>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Customer Info -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Customer Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>Phone:</strong><br>
                        {{ $conversation->formatted_phone }}
                    </div>
                    
                    @if($conversation->user)
                        <div class="mb-3">
                            <strong>Name:</strong><br>
                            {{ $conversation->user->name }}
                        </div>
                        <div class="mb-3">
                            <strong>Email:</strong><br>
                            {{ $conversation->user->email }}
                        </div>
                        <div class="mb-3">
                            <a href="{{ route('admin.users.show', $conversation->user) }}" class="btn btn-sm btn-outline-primary btn-block">
                                <i class="fas fa-user"></i> View Customer Profile
                            </a>
                        </div>
                    @else
                        <p class="text-muted">No registered user found</p>
                    @endif
                </div>
            </div>

            <!-- Assign Conversation -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Assignment</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.whatsapp.conversations.assign', $conversation) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label>Assigned To:</label>
                            <select name="assigned_to" class="form-control form-control-sm">
                                <option value="">Unassigned</option>
                                @foreach(\App\Models\User::where('role', 'admin')->get() as $admin)
                                    <option value="{{ $admin->id }}" {{ $conversation->assigned_to == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm btn-block">
                            <i class="fas fa-user-tag"></i> Update Assignment
                        </button>
                    </form>
                </div>
            </div>

            <!-- Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Actions</h6>
                </div>
                <div class="card-body">
                    @if($conversation->status === 'open')
                        <form action="{{ route('admin.whatsapp.conversations.close', $conversation) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning btn-sm btn-block">
                                <i class="fas fa-times"></i> Close Conversation
                            </button>
                        </form>
                    @else
                        <p class="text-muted text-center">Conversation is {{ $conversation->status }}</p>
                    @endif
                </div>
            </div>

            <!-- Conversation Stats -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <strong>Total Messages:</strong> {{ $messages->count() }}
                    </div>
                    <div class="mb-2">
                        <strong>Last Message:</strong><br>
                        <small class="text-muted">{{ $conversation->last_message_at?->diffForHumans() }}</small>
                    </div>
                    <div class="mb-2">
                        <strong>Created:</strong><br>
                        <small class="text-muted">{{ $conversation->created_at->format('M d, Y h:i A') }}</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-scroll to bottom of chat
document.addEventListener('DOMContentLoaded', function() {
    var chatMessages = document.getElementById('chatMessages');
    if (chatMessages) {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }
});
</script>

<style>
#chatMessages::-webkit-scrollbar {
    width: 8px;
}
#chatMessages::-webkit-scrollbar-track {
    background: #f1f1f1;
}
#chatMessages::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 4px;
}
#chatMessages::-webkit-scrollbar-thumb:hover {
    background: #555;
}
</style>
</x-layouts.admin>
