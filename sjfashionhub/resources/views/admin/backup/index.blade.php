<x-layouts.admin>
    <x-slot name="title">Backup Management</x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">💾 Backup Management</h1>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.backup.settings') }}" class="btn btn-outline-primary">
                        <i class="fas fa-cog"></i> Settings
                    </a>
                    @if($isConfigured)
                        <button type="button" class="btn btn-success" onclick="createBackup()">
                            <i class="fas fa-plus"></i> Create Backup
                        </button>
                    @endif
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error') || isset($error))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') ?? $error }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(!$isConfigured)
                <div class="alert alert-warning" role="alert">
                    <h4 class="alert-heading">⚠️ Google Drive Not Configured</h4>
                    <p>To use the backup system, you need to configure Google Drive integration first.</p>
                    <hr>
                    <p class="mb-0">
                        <a href="{{ route('admin.backup.settings') }}" class="btn btn-warning">
                            <i class="fas fa-cog"></i> Configure Google Drive
                        </a>
                    </p>
                </div>
            @else
                <!-- Backup Statistics -->
                <div class="row mb-4">
                    <div class="col-md-3">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                            Total Backups
                                        </div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ count($backups) }}</div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-archive fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                            Last Backup
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                            @if(count($backups) > 0)
                                                {{ $backups[0]['created_at']->diffForHumans() }}
                                            @else
                                                Never
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-clock fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                            Total Size
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                            {{ array_sum(array_column($backups, 'size_bytes')) > 0 ? 
                                               $this->formatFileSize(array_sum(array_column($backups, 'size_bytes'))) : '0 B' }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-hdd fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                            Auto Backup
                                        </div>
                                        <div class="h6 mb-0 font-weight-bold text-gray-800">
                                            {{ setting('backup_schedule_enabled') ? 'Enabled' : 'Disabled' }}
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-robot fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Backups List -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">📁 Available Backups</h6>
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="refreshBackups()">
                            <i class="fas fa-sync-alt"></i> Refresh
                        </button>
                    </div>
                    <div class="card-body">
                        @if(count($backups) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" id="backupsTable">
                                    <thead>
                                        <tr>
                                            <th>📁 Name</th>
                                            <th>📅 Created</th>
                                            <th>💾 Size</th>
                                            <th>📝 Description</th>
                                            <th>⚡ Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($backups as $backup)
                                            <tr>
                                                <td>
                                                    <strong>{{ $backup['name'] }}</strong>
                                                </td>
                                                <td>
                                                    <span class="text-muted">{{ $backup['created_at']->format('M d, Y H:i') }}</span>
                                                    <br>
                                                    <small class="text-success">{{ $backup['created_at']->diffForHumans() }}</small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info">{{ $backup['size'] }}</span>
                                                </td>
                                                <td>
                                                    <small class="text-muted">{{ $backup['description'] ?: 'No description' }}</small>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.backup.download', $backup['id']) }}" 
                                                           class="btn btn-sm btn-outline-success" 
                                                           title="Download Backup">
                                                            <i class="fas fa-download"></i>
                                                        </a>
                                                        <button type="button" 
                                                                class="btn btn-sm btn-outline-danger" 
                                                                onclick="deleteBackup('{{ $backup['id'] }}', '{{ $backup['name'] }}')"
                                                                title="Delete Backup">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-archive fa-3x text-gray-300 mb-3"></i>
                                <h5 class="text-gray-600">No backups found</h5>
                                <p class="text-muted">Create your first backup to get started.</p>
                                <button type="button" class="btn btn-primary" onclick="createBackup()">
                                    <i class="fas fa-plus"></i> Create First Backup
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Backup Modal -->
<div class="modal fade" id="createBackupModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">🔄 Create New Backup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="createBackupForm">
                    <div class="mb-3">
                        <label for="backupDescription" class="form-label">Description (Optional)</label>
                        <input type="text" class="form-control" id="backupDescription" 
                               placeholder="e.g., Before major update">
                        <div class="form-text">Add a description to help identify this backup later.</div>
                    </div>
                    <div class="alert alert-info">
                        <strong>📋 What will be backed up:</strong>
                        <ul class="mb-0 mt-2">
                            <li>🗄️ Complete database</li>
                            <li>📁 All uploaded files and images</li>
                            <li>⚙️ Configuration files</li>
                            <li>📦 Application dependencies info</li>
                        </ul>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-success" onclick="submitBackup()">
                    <i class="fas fa-play"></i> Start Backup
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" data-bs-backdrop="static">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h6 id="loadingText">Creating backup...</h6>
                <p class="text-muted mb-0">This may take a few minutes</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function createBackup() {
    $('#createBackupModal').modal('show');
}

function submitBackup() {
    const description = document.getElementById('backupDescription').value;

    // Hide create modal and show loading modal
    $('#createBackupModal').modal('hide');
    $('#loadingModal').modal('show');

    fetch('{{ route("admin.backup.create") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            description: description
        })
    })
    .then(response => response.json())
    .then(data => {
        $('#loadingModal').modal('hide');

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Backup Created!',
                text: data.message,
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Backup Failed',
                text: data.message,
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        $('#loadingModal').modal('hide');
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An unexpected error occurred while creating the backup.',
            confirmButtonText: 'OK'
        });
    });
}

function deleteBackup(fileId, fileName) {
    Swal.fire({
        title: 'Delete Backup?',
        text: `Are you sure you want to delete "${fileName}"? This action cannot be undone.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`{{ route("admin.backup.delete", ":id") }}`.replace(':id', fileId), {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    window.location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        confirmButtonText: 'OK'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An unexpected error occurred while deleting the backup.',
                    confirmButtonText: 'OK'
                });
            });
        }
    });
}

function refreshBackups() {
    window.location.reload();
}

// Initialize DataTable if backups exist
@if(count($backups) > 0)
$(document).ready(function() {
    $('#backupsTable').DataTable({
        order: [[1, 'desc']], // Sort by created date descending
        pageLength: 10,
        responsive: true,
        language: {
            search: "🔍 Search backups:",
            lengthMenu: "Show _MENU_ backups per page",
            info: "Showing _START_ to _END_ of _TOTAL_ backups",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        }
    });
});
@endif
</script>

</x-layouts.admin>
