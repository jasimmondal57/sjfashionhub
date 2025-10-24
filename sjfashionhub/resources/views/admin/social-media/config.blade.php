<x-layouts.admin>
    <x-slot name="title">Social Media Configuration</x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">⚙️ Social Media Configuration</h1>
                <p class="text-gray-600 mt-1">Configure your social media platform connections and API settings</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.social-media.index') }}" class="bg-gray-800 hover:bg-gray-900 text-white px-6 py-3 rounded-lg flex items-center font-medium shadow-lg border border-gray-600">
                    ← Back to Dashboard
                </a>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <!-- Platform Configuration Cards -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($availablePlatforms as $platformKey => $platform)
                @php
                    $config = $configs->get($platformKey);
                @endphp
                
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <span class="text-3xl mr-3">{{ $platform['icon'] }}</span>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900">{{ $platform['name'] }}</h3>
                                <p class="text-sm text-gray-500">
                                    @if($config && $config->is_active)
                                        <span class="text-green-600">✅ Active</span>
                                    @else
                                        <span class="text-gray-400">⚪ Inactive</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <form action="{{ route('admin.social-media.config.update', $platformKey) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="is_active" value="{{ $config && $config->is_active ? '0' : '1' }}">
                            <button type="submit"
                                    class="px-4 py-2 rounded-lg text-sm font-medium shadow-lg border {{ $config && $config->is_active ? 'bg-red-600 text-white hover:bg-red-700 border-red-500' : 'bg-green-600 text-white hover:bg-green-700 border-green-500' }}">
                                {{ $config && $config->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </div>

                    <form action="{{ route('admin.social-media.config.update', $platformKey) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="is_active" value="{{ $config ? $config->is_active : 0 }}">
                        
                        @if($platformKey === 'instagram')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Access Token</label>
                                    <input type="password" name="credentials[access_token]" 
                                           value="{{ $config ? $config->getCredential('access_token') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Instagram Access Token">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">User ID</label>
                                    <input type="text" name="credentials[user_id]" 
                                           value="{{ $config ? $config->getCredential('user_id') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Instagram User ID">
                                </div>
                                <div class="text-sm text-gray-600">
                                    <p><strong>Setup Instructions:</strong></p>
                                    <ol class="list-decimal list-inside mt-2 space-y-1">
                                        <li>Create a Facebook App and add Instagram Basic Display</li>
                                        <li>Get your User Access Token from Facebook Developer Console</li>
                                        <li>Find your Instagram User ID using the Graph API</li>
                                    </ol>
                                </div>
                            </div>
                        @endif

                        @if($platformKey === 'facebook')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Page Access Token</label>
                                    <input type="password" name="credentials[access_token]" 
                                           value="{{ $config ? $config->getCredential('access_token') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Facebook Page Access Token">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Page ID</label>
                                    <input type="text" name="credentials[page_id]" 
                                           value="{{ $config ? $config->getCredential('page_id') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Facebook Page ID">
                                </div>
                                <div class="text-sm text-gray-600">
                                    <p><strong>Setup Instructions:</strong></p>
                                    <ol class="list-decimal list-inside mt-2 space-y-1">
                                        <li>Create a Facebook App</li>
                                        <li>Add Pages API permissions</li>
                                        <li>Generate a Page Access Token</li>
                                        <li>Get your Page ID from Facebook Page settings</li>
                                    </ol>
                                </div>
                            </div>
                        @endif

                        @if($platformKey === 'twitter')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Bearer Token</label>
                                    <input type="password" name="credentials[bearer_token]" 
                                           value="{{ $config ? $config->getCredential('bearer_token') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Twitter Bearer Token">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Consumer Key</label>
                                        <input type="password" name="credentials[consumer_key]" 
                                               value="{{ $config ? $config->getCredential('consumer_key') : '' }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="Consumer Key">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Consumer Secret</label>
                                        <input type="password" name="credentials[consumer_secret]" 
                                               value="{{ $config ? $config->getCredential('consumer_secret') : '' }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                               placeholder="Consumer Secret">
                                    </div>
                                </div>
                                <div class="text-sm text-gray-600">
                                    <p><strong>Setup Instructions:</strong></p>
                                    <ol class="list-decimal list-inside mt-2 space-y-1">
                                        <li>Apply for Twitter Developer Account</li>
                                        <li>Create a Twitter App</li>
                                        <li>Generate Bearer Token and API Keys</li>
                                        <li>Enable OAuth 2.0 for posting</li>
                                    </ol>
                                </div>
                            </div>
                        @endif

                        @if($platformKey === 'linkedin')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Access Token</label>
                                    <input type="password" name="credentials[access_token]" 
                                           value="{{ $config ? $config->getCredential('access_token') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="LinkedIn Access Token">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Person ID</label>
                                    <input type="text" name="credentials[person_id]" 
                                           value="{{ $config ? $config->getCredential('person_id') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="LinkedIn Person ID">
                                </div>
                                <div class="text-sm text-gray-600">
                                    <p><strong>Setup Instructions:</strong></p>
                                    <ol class="list-decimal list-inside mt-2 space-y-1">
                                        <li>Create a LinkedIn App</li>
                                        <li>Request Share on LinkedIn permission</li>
                                        <li>Generate Access Token via OAuth</li>
                                        <li>Get Person ID from LinkedIn API</li>
                                    </ol>
                                </div>
                            </div>
                        @endif

                        @if($platformKey === 'pinterest')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Access Token</label>
                                    <input type="password" name="credentials[access_token]"
                                           value="{{ $config ? $config->getCredential('access_token') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Pinterest Access Token">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Board ID</label>
                                    <input type="text" name="credentials[board_id]"
                                           value="{{ $config ? $config->getCredential('board_id') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Pinterest Board ID">
                                </div>
                                <div class="text-sm text-gray-600">
                                    <p><strong>Setup Instructions:</strong></p>
                                    <ol class="list-decimal list-inside mt-2 space-y-1">
                                        <li>Create a Pinterest Developer Account</li>
                                        <li>Create a Pinterest App</li>
                                        <li>Generate Access Token with pins:write scope</li>
                                        <li>Get your Board ID from Pinterest</li>
                                    </ol>
                                </div>
                            </div>
                        @endif

                        @if($platformKey === 'tiktok')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Access Token</label>
                                    <input type="password" name="credentials[access_token]"
                                           value="{{ $config ? $config->getCredential('access_token') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="TikTok Access Token">
                                </div>
                                <div class="text-sm text-gray-600">
                                    <p><strong>Setup Instructions:</strong></p>
                                    <ol class="list-decimal list-inside mt-2 space-y-1">
                                        <li>Apply for TikTok Developer Account</li>
                                        <li>Create a TikTok App</li>
                                        <li>Get approval for Content Posting API</li>
                                        <li>Generate Access Token</li>
                                    </ol>
                                    <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded">
                                        <p class="text-xs text-yellow-800">
                                            <strong>Note:</strong> TikTok requires video content. Text-only posts are not supported.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($platformKey === 'threads')
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Access Token</label>
                                    <input type="password" name="credentials[access_token]"
                                           value="{{ $config ? $config->getCredential('access_token') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Threads Access Token">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">User ID</label>
                                    <input type="text" name="credentials[user_id]"
                                           value="{{ $config ? $config->getCredential('user_id') : '' }}"
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Threads User ID">
                                </div>
                                <div class="text-sm text-gray-600">
                                    <p><strong>Setup Instructions:</strong></p>
                                    <ol class="list-decimal list-inside mt-2 space-y-1">
                                        <li>Create a Meta Developer Account</li>
                                        <li>Create a Threads App</li>
                                        <li>Get approval for Threads API access</li>
                                        <li>Generate User Access Token</li>
                                        <li>Get your Threads User ID</li>
                                    </ol>
                                </div>
                            </div>
                        @endif

                        <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200">
                            <button type="button" onclick="testConnection('{{ $platformKey }}')"
                                    class="bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-lg border border-gray-600">
                                🔍 Test Connection
                            </button>

                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-medium shadow-lg border border-blue-500">
                                💾 Save Configuration
                            </button>
                        </div>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- AI Content Generation Configuration -->
        <div class="mt-8 bg-white rounded-lg border border-gray-200 p-6">
            <div class="flex items-center mb-6">
                <span class="text-3xl mr-3">🤖</span>
                <div>
                    <h3 class="text-lg font-medium text-gray-900">AI Content Generation</h3>
                    <p class="text-sm text-gray-500">Configure AI models for automatic social media content generation</p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Gemini AI (Primary) -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-4">
                        <span class="text-2xl mr-3">🧠</span>
                        <div>
                            <h4 class="text-md font-medium text-gray-900">Google Gemini Pro</h4>
                            <p class="text-sm text-gray-500">Primary AI Model</p>
                        </div>
                        <div class="ml-auto">
                            @if(config('services.gemini.api_key'))
                                <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">✅ Active</span>
                            @else
                                <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded-full">❌ Not Configured</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Gemini API Key</label>
                        <input type="password"
                               value="{{ config('services.gemini.api_key') ? '••••••••••••••••' : '' }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="AIza..." readonly>
                        <p class="text-sm text-gray-500 mt-1">Configure in your .env file: GEMINI_API_KEY=your_key_here</p>
                    </div>
                </div>

                <!-- OpenAI (Fallback) -->
                <div class="border border-gray-200 rounded-lg p-4">
                    <div class="flex items-center mb-4">
                        <span class="text-2xl mr-3">🔄</span>
                        <div>
                            <h4 class="text-md font-medium text-gray-900">OpenAI GPT</h4>
                            <p class="text-sm text-gray-500">Fallback AI Model</p>
                        </div>
                        <div class="ml-auto">
                            @if(config('services.openai.api_key'))
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">🔄 Fallback</span>
                            @else
                                <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">⚪ Optional</span>
                            @endif
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">OpenAI API Key</label>
                        <input type="password"
                               value="{{ config('services.openai.api_key') ? '••••••••••••••••' : '' }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500"
                               placeholder="sk-..." readonly>
                        <p class="text-sm text-gray-500 mt-1">Configure in your .env file: OPENAI_API_KEY=your_key_here</p>
                    </div>
                </div>
            </div>

            <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="text-sm text-gray-700">
                    <p class="font-medium text-blue-900 mb-2">🚀 Enhanced AI Features:</p>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Automatic content generation for each platform</li>
                            <li>Platform-specific hashtag suggestions (8-15 tags)</li>
                            <li>SEO-optimized content with product keywords</li>
                            <li>Engaging product descriptions with pricing</li>
                        </ul>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Direct product link inclusion</li>
                            <li>Discount and offer highlighting</li>
                            <li>Stock urgency messaging</li>
                            <li>Call-to-action optimization</li>
                        </ul>
                    </div>
                    <div class="mt-3 p-3 bg-white rounded border border-blue-200">
                        <p class="text-xs text-blue-800">
                            <strong>AI Model Priority:</strong> Gemini Pro (Primary) → OpenAI GPT (Fallback) → Manual Content (Last Resort)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
function testConnection(platform) {
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '⏳ Testing...';
    button.disabled = true;

    fetch(`{{ route('admin.social-media.test-connection', '') }}/${platform}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('✅ Connection successful!\n\n' + (data.message || 'Platform is properly configured'));
        } else {
            alert('❌ Connection failed:\n\n' + (data.message || data.error || 'Unknown error'));
        }
    })
    .catch(error => {
        alert('❌ Error testing connection:\n\n' + error.message);
        console.error('Error:', error);
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}
</script>

</x-layouts.admin>
