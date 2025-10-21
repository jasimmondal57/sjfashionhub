<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $settings->title ?? 'Site Maintenance' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        @keyframes pulse-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(59, 130, 246, 0.5); }
            50% { box-shadow: 0 0 40px rgba(59, 130, 246, 0.8); }
        }
        .float { animation: float 3s ease-in-out infinite; }
        .pulse-glow { animation: pulse-glow 2s ease-in-out infinite; }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .maintenance-card {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Main Card -->
        <div class="maintenance-card rounded-2xl shadow-2xl p-8 md:p-12">
            <!-- Logo/Icon -->
            <div class="text-center mb-8">
                <div class="inline-block float">
                    <svg class="w-20 h-20 text-blue-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-4">
                {{ $settings->title ?? 'Site Maintenance' }}
            </h1>

            <!-- Description -->
            <p class="text-center text-gray-600 mb-8 leading-relaxed">
                {{ $settings->description ?? 'We are currently performing maintenance. We will be back online shortly.' }}
            </p>

            <!-- Expected End Time (if set) -->
            @if($settings->expected_end_at)
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-8 rounded">
                    <p class="text-sm text-gray-700">
                        <span class="font-semibold text-blue-600">Expected to be back:</span><br>
                        {{ $settings->expected_end_at->format('M d, Y \a\t h:i A') }}
                    </p>
                </div>
            @endif

            <!-- Password Form (if password is required) -->
            @if($requiresPassword)
                <form action="{{ route('maintenance.verify') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    @if($errors->has('password'))
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm">
                            {{ $errors->first('password') }}
                        </div>
                    @endif

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                            Enter Password to Continue
                        </label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Enter maintenance password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none transition"
                            required
                        >
                    </div>

                    <button 
                        type="submit" 
                        class="w-full bg-gradient-to-r from-blue-500 to-purple-600 hover:from-blue-600 hover:to-purple-700 text-white font-semibold py-3 rounded-lg transition transform hover:scale-105 active:scale-95"
                    >
                        Access Site
                    </button>
                </form>
            @else
                <!-- No Password Required Message -->
                <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-center">
                    <p class="text-sm">
                        <span class="font-semibold">✓</span> You have access to the site during maintenance.
                    </p>
                </div>
            @endif

            <!-- Footer Message -->
            <div class="mt-8 pt-8 border-t border-gray-200">
                <p class="text-center text-sm text-gray-500">
                    Thank you for your patience. We're working hard to improve your experience.
                </p>
                <p class="text-center text-xs text-gray-400 mt-2">
                    © {{ date('Y') }} {{ config('app.name', 'SJ Fashion Hub') }}
                </p>
            </div>
        </div>

        <!-- Floating Elements (Decorative) -->
        <div class="mt-12 text-center">
            <div class="inline-flex gap-2">
                <div class="w-2 h-2 bg-white rounded-full opacity-50"></div>
                <div class="w-2 h-2 bg-white rounded-full opacity-75"></div>
                <div class="w-2 h-2 bg-white rounded-full opacity-50"></div>
            </div>
        </div>
    </div>
</body>
</html>

