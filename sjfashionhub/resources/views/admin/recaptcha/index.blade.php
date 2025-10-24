<x-layouts.admin>
    <x-slot name="title">reCAPTCHA Settings</x-slot>

    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">🤖 reCAPTCHA Settings</h1>
            <p class="text-gray-600">Configure Google reCAPTCHA v3 to protect your contact form from spam</p>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-4 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Settings Card -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <!-- Status Badge -->
                    <div class="mb-8 flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-2">Current Status</h2>
                            <p class="text-gray-600">reCAPTCHA is currently</p>
                        </div>
                        <div class="text-right">
                            @if($settings->enabled && $settings->site_key)
                                <span class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded-full font-semibold">
                                    ✅ ENABLED
                                </span>
                            @else
                                <span class="inline-block bg-gray-100 text-gray-800 px-4 py-2 rounded-full font-semibold">
                                    ⚪ DISABLED
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr class="mb-8">

                    <!-- Settings Form -->
                    <form action="{{ route('admin.recaptcha.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Enable/Disable Toggle -->
                        <div class="flex items-center space-x-4">
                            <input type="checkbox" id="enabled" name="enabled" value="1" 
                                   @if($settings->enabled) checked @endif
                                   class="w-5 h-5 text-blue-600 rounded focus:ring-2 focus:ring-blue-500">
                            <label for="enabled" class="text-lg font-medium text-gray-700">
                                Enable reCAPTCHA v3 Protection
                            </label>
                        </div>

                        <!-- Site Key -->
                        <div>
                            <label for="site_key" class="block text-sm font-medium text-gray-700 mb-2">
                                Site Key <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="site_key" name="site_key" 
                                   value="{{ old('site_key', $settings->site_key) }}"
                                   placeholder="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   @error('site_key') border-red-500 @enderror>
                            @error('site_key')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">
                                Get your keys from <a href="https://www.google.com/recaptcha/admin" target="_blank" class="text-blue-600 hover:underline">Google reCAPTCHA Console</a>
                            </p>
                        </div>

                        <!-- Secret Key -->
                        <div>
                            <label for="secret_key" class="block text-sm font-medium text-gray-700 mb-2">
                                Secret Key <span class="text-red-500">*</span>
                            </label>
                            <input type="password" id="secret_key" name="secret_key" 
                                   value="{{ old('secret_key', $settings->secret_key) }}"
                                   placeholder="6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   @error('secret_key') border-red-500 @enderror>
                            @error('secret_key')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">Keep this secret key private and never share it</p>
                        </div>

                        <!-- Threshold -->
                        <div>
                            <label for="threshold" class="block text-sm font-medium text-gray-700 mb-2">
                                Score Threshold (0.0 - 1.0)
                            </label>
                            <input type="number" id="threshold" name="threshold" 
                                   value="{{ old('threshold', $settings->threshold) }}"
                                   min="0" max="1" step="0.1"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   @error('threshold') border-red-500 @enderror>
                            @error('threshold')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500">
                                Higher values = stricter (0.9 = very strict, 0.5 = moderate, 0.0 = lenient)
                            </p>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex gap-4 pt-6">
                            <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition">
                                💾 Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Info Card -->
            <div class="lg:col-span-1">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                    <h3 class="text-lg font-bold text-blue-900 mb-4">📚 About reCAPTCHA v3</h3>
                    
                    <div class="space-y-4 text-sm text-blue-800">
                        <div>
                            <p class="font-semibold mb-1">✅ No User Interaction</p>
                            <p>Users don't need to solve puzzles or click checkboxes</p>
                        </div>

                        <div>
                            <p class="font-semibold mb-1">🤖 AI-Powered</p>
                            <p>Google analyzes user behavior to detect bots</p>
                        </div>

                        <div>
                            <p class="font-semibold mb-1">📊 Score-Based</p>
                            <p>Returns a score (0.0-1.0) indicating likelihood of being human</p>
                        </div>

                        <div>
                            <p class="font-semibold mb-1">🛡️ Spam Protection</p>
                            <p>Blocks automated spam and bot submissions</p>
                        </div>

                        <div class="bg-white p-3 rounded border border-blue-200 mt-4">
                            <p class="font-semibold text-blue-900 mb-2">Recommended Threshold:</p>
                            <ul class="space-y-1 text-xs">
                                <li>• <strong>0.9:</strong> Very strict (blocks most bots)</li>
                                <li>• <strong>0.5:</strong> Moderate (balanced)</li>
                                <li>• <strong>0.3:</strong> Lenient (allows most users)</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>

