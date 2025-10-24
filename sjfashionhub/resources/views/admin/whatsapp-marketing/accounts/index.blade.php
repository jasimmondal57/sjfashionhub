<x-layouts.admin>
    <x-slot name="title">WhatsApp Accounts</x-slot>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">
            <i class="fas fa-mobile-alt"></i> WhatsApp Business Accounts
        </h1>
        <a href="{{ route('admin.whatsapp-marketing.accounts.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
            <i class="fas fa-plus mr-2"></i> Add New Account
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

    @if(session('error'))
        <div class="mb-4 rounded-md bg-red-50 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle text-red-400"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($accounts as $account)
            <div class="bg-white rounded-lg shadow-sm {{ $account->is_default ? 'ring-2 ring-blue-500' : '' }}">
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                    <h5 class="text-lg font-semibold text-gray-900">
                        {{ $account->status_icon }} {{ $account->name }}
                        @if($account->is_default)
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800 ml-2">Default</span>
                        @endif
                    </h5>
                    <div class="relative inline-block text-left">
                        <button type="button" class="inline-flex items-center p-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-md" onclick="toggleDropdown(event, 'dropdown-{{ $account->id }}')">
                            <i class="fas fa-ellipsis-v"></i>
                        </button>
                        <div id="dropdown-{{ $account->id }}" class="hidden absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="{{ route('admin.whatsapp-marketing.accounts.show', $account) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-eye mr-2"></i> View Details
                                </a>
                                <a href="{{ route('admin.whatsapp-marketing.accounts.edit', $account) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    <i class="fas fa-edit mr-2"></i> Edit
                                </a>
                                @if(!$account->is_default)
                                    <form action="{{ route('admin.whatsapp-marketing.accounts.set-default', $account) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                            <i class="fas fa-star mr-2"></i> Set as Default
                                        </button>
                                    </form>
                                @endif
                                <div class="border-t border-gray-100"></div>
                                <form action="{{ route('admin.whatsapp-marketing.accounts.sync-info', $account) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-sync mr-2"></i> Sync Account Info
                                    </button>
                                </form>
                                <form action="{{ route('admin.whatsapp-marketing.accounts.sync-templates', $account) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                        <i class="fas fa-download mr-2"></i> Sync Templates
                                    </button>
                                </form>
                                @if(!$account->is_default)
                                    <div class="border-t border-gray-100"></div>
                                    <form action="{{ route('admin.whatsapp-marketing.accounts.destroy', $account) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this account?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            <i class="fas fa-trash mr-2"></i> Delete
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="p-6">
                    <div class="mb-4">
                        <div class="text-xs text-gray-500 mb-1">Phone Number</div>
                        <div class="font-semibold text-gray-900">{{ $account->display_phone_number ?? 'Not synced' }}</div>
                    </div>

                    <div class="mb-4">
                        <div class="text-xs text-gray-500 mb-1">Verified Name</div>
                        <div class="font-semibold text-gray-900">{{ $account->verified_name ?? 'Not synced' }}</div>
                    </div>

                    <div class="mb-4">
                        <div class="text-xs text-gray-500 mb-1">Quality Rating</div>
                        <div>
                            @if($account->quality_rating)
                                @php
                                    $ratingColors = [
                                        'GREEN' => 'bg-green-100 text-green-800',
                                        'YELLOW' => 'bg-yellow-100 text-yellow-800',
                                        'RED' => 'bg-red-100 text-red-800'
                                    ];
                                    $ratingColor = $ratingColors[$account->quality_rating] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $ratingColor }}">
                                    {{ $account->quality_rating }}
                                </span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Not synced</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="text-xs text-gray-500 mb-1">Status</div>
                        <div>
                            @if($account->is_active)
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            @else
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">Inactive</span>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-gray-200">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-blue-600">{{ $account->templates_count }}</div>
                            <div class="text-xs text-gray-500">Templates</div>
                        </div>
                        <div class="text-center">
                            <div class="text-2xl font-bold text-green-600">{{ $account->campaigns_count }}</div>
                            <div class="text-xs text-gray-500">Campaigns</div>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-3 bg-gray-50 border-t border-gray-200 rounded-b-lg">
                    <div class="text-xs text-gray-500">
                        <i class="fas fa-clock"></i> Added {{ $account->created_at->diffForHumans() }}
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-lg shadow-sm">
                    <div class="text-center py-12">
                        <i class="fas fa-mobile-alt text-gray-400 text-5xl mb-4"></i>
                        <h5 class="text-lg font-semibold text-gray-900 mb-2">No WhatsApp Accounts</h5>
                        <p class="text-gray-500 mb-4">Add your first WhatsApp Business account to start sending campaigns.</p>
                        <a href="{{ route('admin.whatsapp-marketing.accounts.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                            <i class="fas fa-plus mr-2"></i> Add Account
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>

<script>
function toggleDropdown(event, id) {
    event.stopPropagation();
    const dropdown = document.getElementById(id);
    const allDropdowns = document.querySelectorAll('[id^="dropdown-"]');
    allDropdowns.forEach(d => {
        if (d.id !== id) d.classList.add('hidden');
    });
    dropdown.classList.toggle('hidden');
}
document.addEventListener('click', () => {
    document.querySelectorAll('[id^="dropdown-"]').forEach(d => d.classList.add('hidden'));
});
</script>
</x-layouts.admin>

