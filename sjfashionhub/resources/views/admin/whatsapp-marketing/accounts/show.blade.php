<x-layouts.admin>
    <x-slot name="title">{{ $account->name }} - WhatsApp Account</x-slot>

<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $account->status_icon }} {{ $account->name }}</h1>
            <p class="text-gray-600 mt-1">WhatsApp Business Account Details</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.whatsapp-marketing.accounts.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-arrow-left"></i> Back
            </a>
            <a href="{{ route('admin.whatsapp-marketing.accounts.edit', $account) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fas fa-edit"></i> Edit
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Account Info -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-xl font-bold mb-4">Account Information</h2>
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Account Name</label>
                        <p class="font-semibold">{{ $account->name }}</p>
                    </div>
                    
                    <div>
                        <label class="text-sm text-gray-600">Status</label>
                        <p>
                            @if($account->is_active)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i> Active
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <i class="fas fa-pause-circle mr-1"></i> Inactive
                                </span>
                            @endif
                            @if($account->is_default)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 ml-2">
                                    <i class="fas fa-star mr-1"></i> Default
                                </span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Phone Number</label>
                        <p class="font-semibold">{{ $account->display_phone_number ?? 'Not synced' }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Verified Name</label>
                        <p class="font-semibold">{{ $account->verified_name ?? 'Not synced' }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Business Account ID</label>
                        <p class="font-mono text-sm">{{ $account->business_account_id }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Phone Number ID</label>
                        <p class="font-mono text-sm">{{ $account->phone_number_id }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">API Version</label>
                        <p class="font-semibold">{{ $account->api_version }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Quality Rating</label>
                        <p>
                            @if($account->quality_rating)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $account->status_color }}-100 text-{{ $account->status_color }}-800">
                                    {{ $account->quality_rating }}
                                </span>
                            @else
                                <span class="text-gray-500">Not synced</span>
                            @endif
                        </p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Messaging Limit</label>
                        <p class="font-semibold">{{ $account->messaging_limit_tier ?? 'Not synced' }}</p>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Created</label>
                        <p class="text-sm">{{ $account->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
            </div>

            <!-- Templates -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold">Templates ({{ $account->templates->count() }})</h2>
                    <a href="{{ route('admin.whatsapp-marketing.templates.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">
                        <i class="fas fa-plus"></i> New Template
                    </a>
                </div>

                @if($account->templates->count() > 0)
                    <div class="space-y-3">
                        @foreach($account->templates as $template)
                            <div class="border rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="font-semibold">{{ $template->display_name }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($template->body_text, 100) }}</p>
                                        <div class="flex gap-2 mt-2">
                                            <span class="text-xs px-2 py-1 rounded bg-gray-100">{{ $template->category }}</span>
                                            <span class="text-xs px-2 py-1 rounded bg-gray-100">{{ $template->language }}</span>
                                        </div>
                                    </div>
                                    <div class="ml-4">
                                        @if($template->status === 'approved')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                                <i class="fas fa-check-circle mr-1"></i> Approved
                                            </span>
                                        @elseif($template->status === 'pending')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                                <i class="fas fa-clock mr-1"></i> Pending
                                            </span>
                                        @elseif($template->status === 'rejected')
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                                <i class="fas fa-times-circle mr-1"></i> Rejected
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                                {{ ucfirst($template->status) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 text-gray-500">
                        <i class="fas fa-file-alt text-4xl mb-3"></i>
                        <p>No templates yet</p>
                        <a href="{{ route('admin.whatsapp-marketing.templates.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                            Create your first template
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Actions Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
                <h2 class="text-lg font-bold mb-4">Quick Actions</h2>
                
                <div class="space-y-3">
                    <form action="{{ route('admin.whatsapp-marketing.accounts.sync-info', $account) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                            <i class="fas fa-sync mr-2"></i> Sync Account Info
                        </button>
                    </form>

                    <form action="{{ route('admin.whatsapp-marketing.accounts.sync-templates', $account) }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                            <i class="fas fa-download mr-2"></i> Sync Templates
                        </button>
                    </form>

                    @if(!$account->is_default)
                        <form action="{{ route('admin.whatsapp-marketing.accounts.set-default', $account) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-star mr-2"></i> Set as Default
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.whatsapp-marketing.accounts.edit', $account) }}" class="block w-full bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors text-sm text-center">
                        <i class="fas fa-edit mr-2"></i> Edit Account
                    </a>

                    @if(!$account->is_default)
                        <form action="{{ route('admin.whatsapp-marketing.accounts.destroy', $account) }}" method="POST" 
                              onsubmit="return confirm('Are you sure you want to delete this account? This will also delete all associated templates and campaigns.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors text-sm">
                                <i class="fas fa-trash mr-2"></i> Delete Account
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Stats -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-bold mb-4">Statistics</h2>
                
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm text-gray-600">Templates</span>
                            <span class="font-bold text-lg">{{ $account->templates->count() }}</span>
                        </div>
                        <div class="text-xs text-gray-500">
                            {{ $account->templates->where('status', 'approved')->count() }} approved
                        </div>
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-sm text-gray-600">Campaigns</span>
                            <span class="font-bold text-lg">{{ $account->campaigns->count() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.admin>

