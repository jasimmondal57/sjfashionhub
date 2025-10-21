@extends('layouts.admin')

@section('title', 'Maintenance Mode')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Maintenance Mode</h1>
        <p class="text-gray-600">Control your site's maintenance mode and set access restrictions</p>
    </div>

    <!-- Status Alert -->
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
                        <p class="text-gray-600">Maintenance mode is currently</p>
                    </div>
                    <div class="text-right">
                        @if($settings->is_enabled)
                            <span class="inline-block bg-red-100 text-red-800 px-4 py-2 rounded-full font-semibold">
                                🔴 ACTIVE
                            </span>
                        @else
                            <span class="inline-block bg-green-100 text-green-800 px-4 py-2 rounded-full font-semibold">
                                🟢 INACTIVE
                            </span>
                        @endif
                    </div>
                </div>

                <hr class="mb-8">

                <!-- Toggle Button -->
                <form action="{{ route('admin.maintenance.toggle') }}" method="POST" class="mb-8">
                    @csrf
                    
                    @if(!$settings->is_enabled)
                        <div class="mb-6">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Maintenance Password (Optional)
                            </label>
                            <input 
                                type="password" 
                                id="password" 
                                name="password" 
                                placeholder="Leave empty for no password protection"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                            >
                            <p class="text-xs text-gray-500 mt-2">
                                Set a password to allow specific users to access the site during maintenance
                            </p>
                        </div>
                    @endif

                    <button 
                        type="submit" 
                        class="w-full px-6 py-3 rounded-lg font-semibold transition transform hover:scale-105 active:scale-95
                        @if($settings->is_enabled)
                            bg-green-500 hover:bg-green-600 text-white
                        @else
                            bg-red-500 hover:bg-red-600 text-white
                        @endif"
                    >
                        @if($settings->is_enabled)
                            ✓ Disable Maintenance Mode
                        @else
                            ⚠ Enable Maintenance Mode
                        @endif
                    </button>
                </form>

                @if($settings->is_enabled && $settings->started_at)
                    <div class="bg-blue-50 border border-blue-200 p-4 rounded-lg text-sm text-blue-700">
                        <p><strong>Started:</strong> {{ $settings->started_at->format('M d, Y \a\t h:i A') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Info Card -->
        <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-lg shadow-lg p-8 text-white">
            <h3 class="text-xl font-bold mb-4">ℹ️ Quick Info</h3>
            <ul class="space-y-3 text-sm">
                <li class="flex items-start gap-2">
                    <span class="text-lg">✓</span>
                    <span>Admin panel always accessible</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-lg">✓</span>
                    <span>Set optional password for access</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-lg">✓</span>
                    <span>Beautiful maintenance page shown</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-lg">✓</span>
                    <span>Customize message and timing</span>
                </li>
            </ul>
        </div>
    </div>

    <!-- Settings Form -->
    <div class="mt-8 bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Maintenance Settings</h2>

        <form action="{{ route('admin.maintenance.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Maintenance Title
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ $settings->title }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                    required
                >
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Maintenance Message
                </label>
                <textarea 
                    id="description" 
                    name="description" 
                    rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                    required
                >{{ $settings->description }}</textarea>
                <p class="text-xs text-gray-500 mt-2">This message will be displayed on the maintenance page</p>
            </div>

            <!-- Expected End Time -->
            <div>
                <label for="expected_end_at" class="block text-sm font-medium text-gray-700 mb-2">
                    Expected End Time (Optional)
                </label>
                <input 
                    type="datetime-local" 
                    id="expected_end_at" 
                    name="expected_end_at" 
                    value="{{ $settings->expected_end_at ? $settings->expected_end_at->format('Y-m-d\TH:i') : '' }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent outline-none"
                >
                <p class="text-xs text-gray-500 mt-2">When do you expect the site to be back online?</p>
            </div>

            <!-- Password Management -->
            @if($settings->is_enabled && $settings->password)
                <div class="bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                    <p class="text-sm text-yellow-800 mb-4">
                        <strong>⚠️ Password Protected:</strong> Your maintenance page is currently password protected.
                    </p>
                    <form action="{{ route('admin.maintenance.clear-password') }}" method="POST" class="inline">
                        @csrf
                        <button 
                            type="submit" 
                            class="px-4 py-2 bg-yellow-600 hover:bg-yellow-700 text-white rounded-lg text-sm font-semibold transition"
                            onclick="return confirm('Remove password protection?')"
                        >
                            Remove Password
                        </button>
                    </form>
                </div>
            @endif

            <!-- Submit Button -->
            <div class="flex gap-4">
                <button 
                    type="submit" 
                    class="px-6 py-3 bg-blue-500 hover:bg-blue-600 text-white rounded-lg font-semibold transition transform hover:scale-105 active:scale-95"
                >
                    Save Settings
                </button>
                <a 
                    href="{{ route('admin.index') }}" 
                    class="px-6 py-3 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold transition"
                >
                    Cancel
                </a>
            </div>
        </form>
    </div>

    <!-- Preview Section -->
    <div class="mt-8 bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Preview</h2>
        <p class="text-gray-600 mb-4">This is how your maintenance page will look:</p>
        
        <div class="border-2 border-gray-300 rounded-lg overflow-hidden" style="max-height: 500px;">
            <iframe 
                src="{{ route('maintenance.show') }}" 
                class="w-full h-96 border-0"
                title="Maintenance Page Preview"
            ></iframe>
        </div>
    </div>
</div>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }
    .float { animation: float 3s ease-in-out infinite; }
</style>
@endsection

