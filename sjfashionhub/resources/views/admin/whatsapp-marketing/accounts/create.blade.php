<x-layouts.admin>
    <x-slot name="title">Add WhatsApp Account</x-slot>
<div class="px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">
            <i class="fas fa-plus"></i> Add WhatsApp Business Account
        </h1>
        <a href="{{ route('admin.whatsapp-marketing.accounts.index') }}" class="inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
            <i class="fas fa-arrow-left mr-2"></i> Back
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="p-6">
                    <form action="{{ route('admin.whatsapp-marketing.accounts.store') }}" method="POST">
                        @csrf

                        <div class="mb-6">
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Account Name <span class="text-red-600">*</span></label>
                            <input type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-300 @enderror"
                                   id="name" name="name" value="{{ old('name') }}"
                                   placeholder="e.g., Main Account, Backup Account" required>
                            <p class="mt-1 text-sm text-gray-500">A friendly name to identify this account</p>
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="business_account_id" class="block text-sm font-medium text-gray-700 mb-2">Business Account ID <span class="text-red-600">*</span></label>
                            <input type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('business_account_id') border-red-300 @enderror"
                                   id="business_account_id" name="business_account_id"
                                   value="{{ old('business_account_id') }}"
                                   placeholder="e.g., 845234471785648" required>
                            <p class="mt-1 text-sm text-gray-500">Found in Meta Business Manager → WhatsApp Manager</p>
                            @error('business_account_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="phone_number_id" class="block text-sm font-medium text-gray-700 mb-2">Phone Number ID <span class="text-red-600">*</span></label>
                            <input type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('phone_number_id') border-red-300 @enderror"
                                   id="phone_number_id" name="phone_number_id"
                                   value="{{ old('phone_number_id') }}"
                                   placeholder="e.g., 730173600190286" required>
                            <p class="mt-1 text-sm text-gray-500">Found in Meta Business Manager → WhatsApp Manager → API Setup</p>
                            @error('phone_number_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="access_token" class="block text-sm font-medium text-gray-700 mb-2">Access Token <span class="text-red-600">*</span></label>
                            <textarea class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('access_token') border-red-300 @enderror"
                                      id="access_token" name="access_token" rows="3"
                                      placeholder="Paste your WhatsApp Business API access token here" required>{{ old('access_token') }}</textarea>
                            <p class="mt-1 text-sm text-gray-500">Generate from Meta Business Manager → System Users → Generate Token</p>
                            @error('access_token')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="api_version" class="block text-sm font-medium text-gray-700 mb-2">API Version</label>
                            <select class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('api_version') border-red-300 @enderror"
                                    id="api_version" name="api_version">
                                <option value="v18.0" {{ old('api_version', 'v18.0') == 'v18.0' ? 'selected' : '' }}>v18.0</option>
                                <option value="v19.0" {{ old('api_version') == 'v19.0' ? 'selected' : '' }}>v19.0</option>
                                <option value="v20.0" {{ old('api_version') == 'v20.0' ? 'selected' : '' }}>v20.0</option>
                            </select>
                            <p class="mt-1 text-sm text-gray-500">WhatsApp Cloud API version</p>
                            @error('api_version')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <label for="webhook_verify_token" class="block text-sm font-medium text-gray-700 mb-2">Webhook Verify Token</label>
                            <input type="text" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('webhook_verify_token') border-red-300 @enderror"
                                   id="webhook_verify_token" name="webhook_verify_token"
                                   value="{{ old('webhook_verify_token', 'sjfashion_' . bin2hex(random_bytes(16))) }}">
                            <p class="mt-1 text-sm text-gray-500">Used to verify webhook requests from WhatsApp</p>
                            @error('webhook_verify_token')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-6">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <input type="checkbox" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                           id="is_default" name="is_default" value="1"
                                           {{ old('is_default') ? 'checked' : '' }}>
                                </div>
                                <div class="ml-3">
                                    <label for="is_default" class="font-medium text-gray-700">Set as default account</label>
                                    <p class="text-sm text-gray-500">New campaigns will use this account by default</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-between pt-4 border-t border-gray-200">
                            <a href="{{ route('admin.whatsapp-marketing.accounts.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                <i class="fas fa-times mr-2"></i> Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                                <i class="fas fa-save mr-2"></i> Add Account
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-sm">
                <div class="px-6 py-4 bg-blue-600 text-white rounded-t-lg">
                    <i class="fas fa-info-circle mr-2"></i> How to Get Credentials
                </div>
                <div class="p-6">
                    <h6 class="font-semibold text-gray-900 mb-2">Step 1: Meta Business Manager</h6>
                    <p class="text-sm text-gray-600 mb-4">Go to <a href="https://business.facebook.com" target="_blank" class="text-blue-600 hover:underline">business.facebook.com</a></p>

                    <h6 class="font-semibold text-gray-900 mb-2">Step 2: WhatsApp Manager</h6>
                    <p class="text-sm text-gray-600 mb-4">Navigate to WhatsApp → API Setup</p>

                    <h6 class="font-semibold text-gray-900 mb-2">Step 3: Get Phone Number ID</h6>
                    <p class="text-sm text-gray-600 mb-4">Copy the Phone Number ID from the API Setup page</p>

                    <h6 class="font-semibold text-gray-900 mb-2">Step 4: Get Business Account ID</h6>
                    <p class="text-sm text-gray-600 mb-4">Found in WhatsApp Manager settings</p>

                    <h6 class="font-semibold text-gray-900 mb-2">Step 5: Generate Access Token</h6>
                    <p class="text-sm text-gray-600 mb-4">System Users → Create System User → Generate Token with <code class="bg-gray-100 px-1 py-0.5 rounded text-xs">whatsapp_business_messaging</code> permission</p>

                    <div class="rounded-md bg-yellow-50 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <i class="fas fa-exclamation-triangle text-yellow-400"></i>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-yellow-800"><strong>Important:</strong> Keep your access token secure. It will be encrypted when saved.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-layouts.admin>

