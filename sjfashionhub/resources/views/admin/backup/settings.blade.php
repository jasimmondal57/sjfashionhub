<x-layouts.admin>
    <x-slot name="title">Backup Settings</x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">⚙️ Backup Settings</h1>
                <a href="{{ route('admin.backup.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left"></i> Back to Backups
                </a>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Google Drive Configuration -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">☁️ Google Drive Configuration</h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.backup.settings.update') }}">
                                @csrf
                                
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="google_drive_client_id" class="form-label">
                                                Client ID <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" 
                                                   class="form-control @error('google_drive_client_id') is-invalid @enderror" 
                                                   id="google_drive_client_id" 
                                                   name="google_drive_client_id" 
                                                   value="{{ old('google_drive_client_id', $settings['google_drive_client_id']) }}"
                                                   required>
                                            @error('google_drive_client_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="google_drive_client_secret" class="form-label">
                                                Client Secret <span class="text-danger">*</span>
                                            </label>
                                            <input type="password" 
                                                   class="form-control @error('google_drive_client_secret') is-invalid @enderror" 
                                                   id="google_drive_client_secret" 
                                                   name="google_drive_client_secret" 
                                                   value="{{ old('google_drive_client_secret', $settings['google_drive_client_secret']) }}"
                                                   required>
                                            @error('google_drive_client_secret')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="google_drive_redirect_uri" class="form-label">
                                        Redirect URI <span class="text-danger">*</span>
                                    </label>
                                    <input type="url" 
                                           class="form-control @error('google_drive_redirect_uri') is-invalid @enderror" 
                                           id="google_drive_redirect_uri" 
                                           name="google_drive_redirect_uri" 
                                           value="{{ old('google_drive_redirect_uri', $settings['google_drive_redirect_uri']) }}"
                                           placeholder="{{ route('admin.backup.callback') }}"
                                           required>
                                    <div class="form-text">
                                        Use: <code>{{ route('admin.backup.callback') }}</code>
                                    </div>
                                    @error('google_drive_redirect_uri')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="google_drive_backup_folder" class="form-label">
                                        Backup Folder Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('google_drive_backup_folder') is-invalid @enderror" 
                                           id="google_drive_backup_folder" 
                                           name="google_drive_backup_folder" 
                                           value="{{ old('google_drive_backup_folder', $settings['google_drive_backup_folder']) }}"
                                           required>
                                    <div class="form-text">
                                        Name of the folder in Google Drive where backups will be stored.
                                    </div>
                                    @error('google_drive_backup_folder')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <hr>

                                <h6 class="font-weight-bold text-primary mb-3">🕒 Backup Schedule</h6>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="backup_schedule_enabled" 
                                                       name="backup_schedule_enabled"
                                                       {{ old('backup_schedule_enabled', $settings['backup_schedule_enabled']) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="backup_schedule_enabled">
                                                    Enable Automatic Backups
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="backup_schedule_time" class="form-label">
                                                Backup Time <span class="text-danger">*</span>
                                            </label>
                                            <input type="time" 
                                                   class="form-control @error('backup_schedule_time') is-invalid @enderror" 
                                                   id="backup_schedule_time" 
                                                   name="backup_schedule_time" 
                                                   value="{{ old('backup_schedule_time', $settings['backup_schedule_time']) }}"
                                                   required>
                                            @error('backup_schedule_time')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="backup_retention_days" class="form-label">
                                                Retention Days <span class="text-danger">*</span>
                                            </label>
                                            <input type="number" 
                                                   class="form-control @error('backup_retention_days') is-invalid @enderror" 
                                                   id="backup_retention_days" 
                                                   name="backup_retention_days" 
                                                   value="{{ old('backup_retention_days', $settings['backup_retention_days']) }}"
                                                   min="1" max="30" required>
                                            <div class="form-text">
                                                Number of days to keep backups (1-30)
                                            </div>
                                            @error('backup_retention_days')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Settings
                                    </button>
                                    
                                    @if($isConfigured)
                                        <button type="button" class="btn btn-outline-success" onclick="testConnection()">
                                            <i class="fas fa-check-circle"></i> Test Connection
                                        </button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Status & Actions -->
                <div class="col-lg-4">
                    <!-- Connection Status -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">📊 Connection Status</h6>
                        </div>
                        <div class="card-body">
                            @if($isConfigured)
                                <div class="alert alert-success">
                                    <i class="fas fa-check-circle"></i>
                                    <strong>Connected</strong><br>
                                    Google Drive is properly configured and ready to use.
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="button" class="btn btn-outline-primary" onclick="testConnection()">
                                        <i class="fas fa-sync-alt"></i> Test Connection
                                    </button>
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    <strong>Not Connected</strong><br>
                                    Please configure Google Drive settings and authorize access.
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <a href="{{ route('admin.backup.authorize') }}" class="btn btn-success">
                                        <i class="fas fa-key"></i> Authorize Google Drive
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Setup Instructions -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">📋 Setup Instructions</h6>
                        </div>
                        <div class="card-body">
                            <ol class="small">
                                <li>Go to <a href="https://console.cloud.google.com/" target="_blank">Google Cloud Console</a></li>
                                <li>Create a new project or select existing one</li>
                                <li>Enable the Google Drive API</li>
                                <li>Create OAuth 2.0 credentials</li>
                                <li>Add the redirect URI: <br><code class="small">{{ route('admin.backup.callback') }}</code></li>
                                <li>Copy Client ID and Client Secret here</li>
                                <li>Click "Authorize Google Drive"</li>
                            </ol>
                            
                            <div class="mt-3">
                                <a href="https://console.cloud.google.com/" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-external-link-alt"></i> Google Cloud Console
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Backup Info -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">ℹ️ Backup Information</h6>
                        </div>
                        <div class="card-body">
                            <p class="small text-muted">
                                <strong>What gets backed up:</strong>
                            </p>
                            <ul class="small text-muted">
                                <li>Complete SQLite database</li>
                                <li>All uploaded files and images</li>
                                <li>Configuration files</li>
                                <li>Application dependencies info</li>
                            </ul>
                            
                            <p class="small text-muted mt-3">
                                <strong>Automatic cleanup:</strong><br>
                                Backups older than the retention period are automatically deleted to save space.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function testConnection() {
    const button = event.target;
    const originalText = button.innerHTML;

    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Testing...';
    button.disabled = true;

    fetch('{{ route("admin.backup.test-connection") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        button.innerHTML = originalText;
        button.disabled = false;

        if (data.success) {
            Swal.fire({
                icon: 'success',
                title: 'Connection Successful!',
                text: data.message + (data.backup_count !== undefined ? ` Found ${data.backup_count} existing backups.` : ''),
                confirmButtonText: 'OK'
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Connection Failed',
                text: data.message,
                confirmButtonText: 'OK'
            });
        }
    })
    .catch(error => {
        button.innerHTML = originalText;
        button.disabled = false;
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An unexpected error occurred while testing the connection.',
            confirmButtonText: 'OK'
        });
    });
}

// Auto-fill redirect URI
document.addEventListener('DOMContentLoaded', function() {
    const redirectUriInput = document.getElementById('google_drive_redirect_uri');
    if (!redirectUriInput.value) {
        redirectUriInput.value = '{{ route("admin.backup.callback") }}';
    }
});
</script>

</x-layouts.admin>
