<x-layouts.admin>
    <x-slot name="title">Add WhatsApp Account</x-slot>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus"></i> Add WhatsApp Business Account
        </h1>
        <a href="{{ route('admin.whatsapp-marketing.accounts.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Accounts
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('admin.whatsapp-marketing.accounts.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="name" class="form-label">Account Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   placeholder="e.g., Main Account, Backup Account" required>
                            <small class="text-muted">A friendly name to identify this account</small>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="business_account_id" class="form-label">Business Account ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('business_account_id') is-invalid @enderror" 
                                   id="business_account_id" name="business_account_id" 
                                   value="{{ old('business_account_id') }}" 
                                   placeholder="e.g., 845234471785648" required>
                            <small class="text-muted">Found in Meta Business Manager → WhatsApp Manager</small>
                            @error('business_account_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number_id" class="form-label">Phone Number ID <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone_number_id') is-invalid @enderror" 
                                   id="phone_number_id" name="phone_number_id" 
                                   value="{{ old('phone_number_id') }}" 
                                   placeholder="e.g., 730173600190286" required>
                            <small class="text-muted">Found in Meta Business Manager → WhatsApp Manager → API Setup</small>
                            @error('phone_number_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="access_token" class="form-label">Access Token <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('access_token') is-invalid @enderror" 
                                      id="access_token" name="access_token" rows="3" 
                                      placeholder="Paste your WhatsApp Business API access token here" required>{{ old('access_token') }}</textarea>
                            <small class="text-muted">Generate from Meta Business Manager → System Users → Generate Token</small>
                            @error('access_token')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="api_version" class="form-label">API Version</label>
                            <select class="form-select @error('api_version') is-invalid @enderror" 
                                    id="api_version" name="api_version">
                                <option value="v18.0" {{ old('api_version', 'v18.0') == 'v18.0' ? 'selected' : '' }}>v18.0</option>
                                <option value="v19.0" {{ old('api_version') == 'v19.0' ? 'selected' : '' }}>v19.0</option>
                                <option value="v20.0" {{ old('api_version') == 'v20.0' ? 'selected' : '' }}>v20.0</option>
                            </select>
                            <small class="text-muted">WhatsApp Cloud API version</small>
                            @error('api_version')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="webhook_verify_token" class="form-label">Webhook Verify Token</label>
                            <input type="text" class="form-control @error('webhook_verify_token') is-invalid @enderror" 
                                   id="webhook_verify_token" name="webhook_verify_token" 
                                   value="{{ old('webhook_verify_token', 'sjfashion_' . bin2hex(random_bytes(16))) }}">
                            <small class="text-muted">Used to verify webhook requests from WhatsApp</small>
                            @error('webhook_verify_token')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="is_default" name="is_default" value="1" 
                                   {{ old('is_default') ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_default">
                                Set as default account
                            </label>
                            <small class="d-block text-muted">New campaigns will use this account by default</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.whatsapp-marketing.accounts.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Add Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm bg-light">
                <div class="card-header bg-primary text-white">
                    <i class="fas fa-info-circle"></i> How to Get Credentials
                </div>
                <div class="card-body">
                    <h6 class="fw-bold">Step 1: Meta Business Manager</h6>
                    <p class="small">Go to <a href="https://business.facebook.com" target="_blank">business.facebook.com</a></p>

                    <h6 class="fw-bold mt-3">Step 2: WhatsApp Manager</h6>
                    <p class="small">Navigate to WhatsApp → API Setup</p>

                    <h6 class="fw-bold mt-3">Step 3: Get Phone Number ID</h6>
                    <p class="small">Copy the Phone Number ID from the API Setup page</p>

                    <h6 class="fw-bold mt-3">Step 4: Get Business Account ID</h6>
                    <p class="small">Found in WhatsApp Manager settings</p>

                    <h6 class="fw-bold mt-3">Step 5: Generate Access Token</h6>
                    <p class="small">System Users → Create System User → Generate Token with <code>whatsapp_business_messaging</code> permission</p>

                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle"></i>
                        <strong>Important:</strong> Keep your access token secure. It will be encrypted when saved.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.admin>

