<x-layouts.admin>
    <x-slot name="title">Backup Management</x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">💾 Backup Management</h1>
                <p class="text-gray-600 mt-1">Manage your site backups and Google Drive integration</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.backup.settings') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Settings
                </a>
                @if($isConfigured)
                <button onclick="createBackup()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M9 19l3 3m0 0l3-3m-3 3V10"></path>
                    </svg>
                    Create Backup
                </button>
                @endif
            </div>
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error') || isset($error))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') ?? $error }}
            </div>
        @endif

        @if(!$isConfigured)
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded mb-6">
                <h4 class="font-bold text-lg mb-2">⚠️ Google Drive Not Configured</h4>
                <p class="mb-4">To use the backup system, you need to configure Google Drive integration first.</p>
                <a href="{{ route('admin.backup.settings') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Configure Google Drive
                </a>
            </div>
            @else
                <!-- Backup Statistics -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                    <div class="bg-white rounded-lg border border-gray-200 p-6">
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 uppercase tracking-wide">Total Backups</p>
                                <p class="text-3xl font-bold text-gray-900">{{ count($backups) }}</p>
                            </div>
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path>
                                </svg>
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
