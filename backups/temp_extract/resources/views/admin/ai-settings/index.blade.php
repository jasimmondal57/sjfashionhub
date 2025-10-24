<x-layouts.admin title="AI Settings" description="Configure Google Gemini AI for automated product content generation">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 mb-6">
            <div class="px-6 py-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">🤖 AI Settings</h1>
                        <p class="text-sm text-gray-600 mt-1">Configure Google Gemini AI for automated product content generation</p>
                    </div>
                    <div class="flex items-center space-x-2">
                        @if($isConfigured)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                AI Configured
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                </svg>
                                AI Not Configured
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <p class="text-green-800 font-medium">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                    </svg>
                    <div>
                        <p class="text-red-800 font-medium">Error:</p>
                        @foreach($errors->all() as $error)
                            <p class="text-red-700 text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- API Configuration -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">🔑 API Configuration</h2>
                    <p class="text-sm text-gray-600 mt-1">Configure your Google Gemini AI API key</p>
                </div>
                
                <div class="p-6">
                    <form action="{{ route('admin.ai-settings.update') }}" method="POST" id="apiForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label for="gemini_api_key" class="block text-sm font-medium text-gray-700 mb-2">
                                Gemini API Key
                            </label>
                            <div class="relative">
                                <input type="password" 
                                       id="gemini_api_key" 
                                       name="gemini_api_key" 
                                       value="{{ $currentApiKey ? str_repeat('*', 20) . substr($currentApiKey, -4) : '' }}"
                                       placeholder="Enter your Gemini API key"
                                       class="w-full px-3 py-2 pr-10 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <button type="button" 
                                        onclick="toggleApiKeyVisibility()" 
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center">
                                    <svg id="eyeIcon" class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </div>
                            @error('gemini_api_key')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex space-x-3">
                            <button type="button" 
                                    onclick="testApiKey()" 
                                    class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                🧪 Test Connection
                            </button>
                            
                            <button type="submit" 
                                    class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                                💾 Save API Key
                            </button>
                        </div>
                    </form>

                    @if($isConfigured)
                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <form action="{{ route('admin.ai-settings.remove') }}" method="POST" onsubmit="return confirm('Are you sure you want to remove the API key? This will disable AI features.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition-colors">
                                    🗑️ Remove API Key
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Connection Status -->
                    @if($connectionStatus)
                        <div class="mt-4 p-3 rounded-md {{ $connectionStatus['success'] ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200' }}">
                            <div class="flex items-start">
                                @if($connectionStatus['success'])
                                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-green-800 font-medium">Connection Successful</p>
                                        <p class="text-green-700 text-sm">{{ $connectionStatus['message'] }}</p>
                                    </div>
                                @else
                                    <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <div>
                                        <p class="text-red-800 font-medium">Connection Failed</p>
                                        <p class="text-red-700 text-sm">{{ $connectionStatus['message'] }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Setup Instructions -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">📋 Setup Instructions</h2>
                    <p class="text-sm text-gray-600 mt-1">How to get your Google Gemini API key</p>
                </div>
                
                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-800 rounded-full flex items-center justify-center text-sm font-medium mr-3">1</span>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Visit Google AI Studio</p>
                                <p class="text-sm text-gray-600">Go to <a href="https://aistudio.google.com/app/apikey" target="_blank" class="text-blue-600 hover:text-blue-800 underline">aistudio.google.com/app/apikey</a></p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-800 rounded-full flex items-center justify-center text-sm font-medium mr-3">2</span>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Sign in with Google Account</p>
                                <p class="text-sm text-gray-600">Use your Google account to access AI Studio</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-800 rounded-full flex items-center justify-center text-sm font-medium mr-3">3</span>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Create API Key</p>
                                <p class="text-sm text-gray-600">Click "Create API Key" and select your project</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 bg-blue-100 text-blue-800 rounded-full flex items-center justify-center text-sm font-medium mr-3">4</span>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Copy API Key</p>
                                <p class="text-sm text-gray-600">Copy the generated API key and paste it above</p>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <span class="flex-shrink-0 w-6 h-6 bg-green-100 text-green-800 rounded-full flex items-center justify-center text-sm font-medium mr-3">✓</span>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Test & Save</p>
                                <p class="text-sm text-gray-600">Test the connection and save your API key</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-yellow-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="text-yellow-800 font-medium text-sm">Important Notes:</p>
                                <ul class="text-yellow-700 text-sm mt-1 space-y-1">
                                    <li>• Gemini API is free with generous quotas</li>
                                    <li>• Keep your API key secure and private</li>
                                    <li>• API key enables automatic content generation</li>
                                    <li>• Without API key, basic rule-based generation is used</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- AI Features Overview -->
        @if($isConfigured)
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 mt-6">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h2 class="text-lg font-semibold text-gray-900">🚀 AI Features</h2>
                    <p class="text-sm text-gray-600 mt-1">What AI can generate for your products</p>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <div class="flex items-start p-3 bg-blue-50 rounded-lg">
                            <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">Product Descriptions</p>
                                <p class="text-gray-600 text-xs">Engaging short & long descriptions</p>
                            </div>
                        </div>

                        <div class="flex items-start p-3 bg-green-50 rounded-lg">
                            <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">SEO Keywords</p>
                                <p class="text-gray-600 text-xs">Optimized for Google ranking</p>
                            </div>
                        </div>

                        <div class="flex items-start p-3 bg-purple-50 rounded-lg">
                            <svg class="w-5 h-5 text-purple-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">Key Features</p>
                                <p class="text-gray-600 text-xs">Highlight product benefits</p>
                            </div>
                        </div>

                        <div class="flex items-start p-3 bg-yellow-50 rounded-lg">
                            <svg class="w-5 h-5 text-yellow-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">Google Merchant</p>
                                <p class="text-gray-600 text-xs">Complete compliance data</p>
                            </div>
                        </div>

                        <div class="flex items-start p-3 bg-red-50 rounded-lg">
                            <svg class="w-5 h-5 text-red-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">Meta Pixel Data</p>
                                <p class="text-gray-600 text-xs">Facebook/Instagram ready</p>
                            </div>
                        </div>

                        <div class="flex items-start p-3 bg-indigo-50 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-500 mr-3 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <p class="font-medium text-gray-900 text-sm">Smart Pricing</p>
                                <p class="text-gray-600 text-xs">Calculated fields & suggestions</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-3">
                        <button onclick="generateSample()" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            🎯 Generate Sample Content
                        </button>
                        
                        <a href="{{ route('admin.products.create') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-colors">
                            ➕ Create Product with AI
                        </a>
                    </div>

                    <!-- Sample Content Display -->
                    <div id="sampleContent" class="hidden mt-4 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                        <h4 class="font-medium text-gray-900 mb-2">Sample AI Generated Content:</h4>
                        <div id="sampleText" class="text-sm text-gray-700 whitespace-pre-wrap"></div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        function toggleApiKeyVisibility() {
            const input = document.getElementById('gemini_api_key');
            const eyeIcon = document.getElementById('eyeIcon');
            
            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.878 9.878L3 3m6.878 6.878L21 21"></path>';
            } else {
                input.type = 'password';
                eyeIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>';
            }
        }

        async function testApiKey() {
            const apiKey = document.getElementById('gemini_api_key').value;
            
            if (!apiKey) {
                alert('Please enter an API key first');
                return;
            }

            const button = event.target;
            const originalText = button.textContent;
            button.textContent = '🔄 Testing...';
            button.disabled = true;

            try {
                const response = await fetch('{{ route("admin.ai-settings.test") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ api_key: apiKey })
                });

                const result = await response.json();
                
                if (result.success) {
                    alert('✅ API Connection Successful!\n\n' + result.message);
                } else {
                    alert('❌ API Connection Failed!\n\n' + result.message);
                }
            } catch (error) {
                alert('❌ Test Failed!\n\nError: ' + error.message);
            } finally {
                button.textContent = originalText;
                button.disabled = false;
            }
        }

        async function generateSample() {
            const button = event.target;
            const originalText = button.textContent;
            button.textContent = '🔄 Generating...';
            button.disabled = true;

            try {
                const response = await fetch('{{ route("admin.ai-settings.sample") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const result = await response.json();
                
                if (result.success) {
                    document.getElementById('sampleText').textContent = result.sample;
                    document.getElementById('sampleContent').classList.remove('hidden');
                } else {
                    alert('❌ Failed to generate sample content!\n\n' + result.message);
                }
            } catch (error) {
                alert('❌ Generation Failed!\n\nError: ' + error.message);
            } finally {
                button.textContent = originalText;
                button.disabled = false;
            }
        }
    </script>
</x-layouts.admin>
