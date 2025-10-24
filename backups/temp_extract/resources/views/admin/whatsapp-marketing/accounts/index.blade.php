<x-layouts.admin>
    <x-slot name="title">WhatsApp Accounts</x-slot>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-mobile-alt"></i> WhatsApp Business Accounts
        </h1>
        <a href="{{ route('admin.whatsapp-marketing.accounts.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Account
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        @forelse($accounts as $account)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 shadow-sm {{ $account->is_default ? 'border-primary' : '' }}">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            {{ $account->status_icon }} {{ $account->name }}
                            @if($account->is_default)
                                <span class="badge bg-primary ms-2">Default</span>
                            @endif
                        </h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-ellipsis-v"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.whatsapp-marketing.accounts.show', $account) }}">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('admin.whatsapp-marketing.accounts.edit', $account) }}">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </li>
                                @if(!$account->is_default)
                                    <li>
                                        <form action="{{ route('admin.whatsapp-marketing.accounts.set-default', $account) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-star"></i> Set as Default
                                            </button>
                                        </form>
                                    </li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.whatsapp-marketing.accounts.sync-info', $account) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sync"></i> Sync Account Info
                                        </button>
                                    </form>
                                </li>
                                <li>
                                    <form action="{{ route('admin.whatsapp-marketing.accounts.sync-templates', $account) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-download"></i> Sync Templates
                                        </button>
                                    </form>
                                </li>
                                @if(!$account->is_default)
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.whatsapp-marketing.accounts.destroy', $account) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this account?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <small class="text-muted">Phone Number</small>
                            <div class="fw-bold">{{ $account->display_phone_number ?? 'Not synced' }}</div>
                        </div>
                        
                        <div class="mb-3">
                            <small class="text-muted">Verified Name</small>
                            <div class="fw-bold">{{ $account->verified_name ?? 'Not synced' }}</div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">Quality Rating</small>
                            <div>
                                @if($account->quality_rating)
                                    <span class="badge bg-{{ $account->status_color }}">
                                        {{ $account->quality_rating }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">Not synced</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3">
                            <small class="text-muted">Status</small>
                            <div>
                                @if($account->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </div>
                        </div>

                        <div class="row text-center mt-3 pt-3 border-top">
                            <div class="col-6">
                                <div class="h4 mb-0 text-primary">{{ $account->templates_count }}</div>
                                <small class="text-muted">Templates</small>
                            </div>
                            <div class="col-6">
                                <div class="h4 mb-0 text-success">{{ $account->campaigns_count }}</div>
                                <small class="text-muted">Campaigns</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-white">
                        <small class="text-muted">
                            <i class="fas fa-clock"></i> Added {{ $account->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-mobile-alt fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No WhatsApp Accounts</h5>
                        <p class="text-muted">Add your first WhatsApp Business account to start sending campaigns.</p>
                        <a href="{{ route('admin.whatsapp-marketing.accounts.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Account
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>
</x-layouts.admin>

