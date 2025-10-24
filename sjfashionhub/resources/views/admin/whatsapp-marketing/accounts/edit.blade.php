<x-layouts.admin>
    <x-slot name="title">Edit {{ $account->name }}</x-slot>

<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">
                <i class="fas fa-edit"></i> Edit WhatsApp Account
            </h1>
            <p class="text-gray-600 mt-1">Update account settings and credentials</p>
        </div>
        <a href="{{ route('admin.whatsapp-marketing.accounts.show', $account) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-sm p-6">
                <form action="{{ route('admin.whatsapp-marketing.accounts.update', $account) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Account Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $account->name) }}" 
                               required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="business_account_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Business Account ID <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('business_account_id') border-red-500 @enderror" 
                               id="business_account_id" 
                               name="business_account_id" 
                               value="{{ old('business_account_id', $account->business_account_id) }}" 
                               required>
                        @error('business_account_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="phone_number_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Phone Number ID <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('phone_number_id') border-red-500 @enderror" 
                               id="phone_number_id" 
                               name="phone_number_id" 
                               value="{{ old('phone_number_id', $account->phone_number_id) }}" 
                               required>
                        @error('phone_number_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="access_token" class="block text-sm font-medium text-gray-700 mb-2">
                            Access Token
                        </label>
                        <textarea class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('access_token') border-red-500 @enderror" 
                                  id="access_token" 
                                  name="access_token" 
                                  rows="3" 
                                  placeholder="Leave blank to keep current token">{{ old('access_token') }}</textarea>
                        <p class="text-sm text-gray-500 mt-1">Leave blank to keep the current access token</p>
                        @error('access_token')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="api_version" class="block text-sm font-medium text-gray-700 mb-2">
                            API Version
                        </label>
                        <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('api_version') border-red-500 @enderror" 
                                id="api_version" 
                                name="api_version">
                            <option value="v18.0" {{ old('api_version', $account->api_version) == 'v18.0' ? 'selected' : '' }}>v18.0</option>
                            <option value="v19.0" {{ old('api_version', $account->api_version) == 'v19.0' ? 'selected' : '' }}>v19.0</option>
                            <option value="v20.0" {{ old('api_version', $account->api_version) == 'v20.0' ? 'selected' : '' }}>v20.0</option>
                        </select>
                        @error('api_version')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="webhook_verify_token" class="block text-sm font-medium text-gray-700 mb-2">
                            Webhook Verify Token
                        </label>
                        <input type="text" 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('webhook_verify_token') border-red-500 @enderror" 
                               id="webhook_verify_token" 
                               name="webhook_verify_token" 
                               value="{{ old('webhook_verify_token', $account->webhook_verify_token) }}">
                        @error('webhook_verify_token')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                   name="is_active" 
                                   value="1" 
                                   {{ old('is_active', $account->is_active) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Account is active</span>
                        </label>
                    </div>

                    <div class="mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" 
                                   class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" 
                                   name="is_default" 
                                   value="1" 
                                   {{ old('is_default', $account->is_default) ? 'checked' : '' }}>
                            <span class="ml-2 text-sm text-gray-700">Set as default account</span>
                        </label>
                        <p class="text-sm text-gray-500 mt-1 ml-6">New campaigns will use this account by default</p>
                    </div>

                    <div class="flex justify-between">
                        <a href="{{ route('admin.whatsapp-marketing.accounts.show', $account) }}" 
                           class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors">
                            <i class="fas fa-times"></i> Cancel
                        </a>
                        <button type="submit" 
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                            <i class="fas fa-save"></i> Update Account
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                <h3 class="font-bold text-blue-900 mb-3">
                    <i class="fas fa-info-circle"></i> Update Tips
                </h3>
                <ul class="space-y-2 text-sm text-blue-800">
                    <li class="flex items-start">
                        <i class="fas fa-check text-blue-600 mt-1 mr-2"></i>
                        <span>Leave the access token field blank to keep the current token</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-blue-600 mt-1 mr-2"></i>
                        <span>Setting as default will remove default status from other accounts</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-blue-600 mt-1 mr-2"></i>
                        <span>Inactive accounts cannot be used for campaigns</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check text-blue-600 mt-1 mr-2"></i>
                        <span>Sync account info after updating to refresh details</span>
                    </li>
                </ul>
            </div>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-6 mt-6">
                <h3 class="font-bold text-yellow-900 mb-3">
                    <i class="fas fa-exclamation-triangle"></i> Warning
                </h3>
                <p class="text-sm text-yellow-800">
                    Changing the Business Account ID or Phone Number ID will affect all existing templates and campaigns associated with this account.
                </p>
            </div>
        </div>
    </div>
</div>
</x-layouts.admin>

