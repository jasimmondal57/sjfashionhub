<x-layouts.admin>
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">⚙️ Mobile App Settings</h1>
                        <p class="text-gray-600 mt-1">Configure your mobile app settings</p>
                    </div>
                    <a href="{{ route('admin.mobile.index') }}" 
                       class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md font-medium transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>

            <form action="{{ route('admin.mobile.settings.update') }}" method="POST" enctype="multipart/form-data">
                @csrf

                @foreach($settings as $group => $groupSettings)
                    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-6 mb-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4 capitalize">
                            {{ str_replace('_', ' ', $group) }} Settings
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($groupSettings as $setting)
                                <div class="@if($setting->type === 'json') md:col-span-2 @endif">
                                    <label for="{{ $setting->key }}" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $setting->label }}
                                        @if($setting->description)
                                            <span class="text-gray-500 text-xs block mt-1">{{ $setting->description }}</span>
                                        @endif
                                    </label>

                                    @if($setting->type === 'boolean')
                                        <div class="flex items-center">
                                            <input type="checkbox" 
                                                   id="{{ $setting->key }}" 
                                                   name="{{ $setting->key }}" 
                                                   value="true"
                                                   {{ $setting->value === 'true' || $setting->value === '1' ? 'checked' : '' }}
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="{{ $setting->key }}" class="ml-2 block text-sm text-gray-900">
                                                Enable
                                            </label>
                                        </div>

                                    @elseif($setting->type === 'color')
                                        <div class="flex items-center gap-2">
                                            <input type="color" 
                                                   id="{{ $setting->key }}" 
                                                   name="{{ $setting->key }}" 
                                                   value="{{ $setting->value }}"
                                                   class="h-10 w-20 border border-gray-300 rounded cursor-pointer">
                                            <input type="text" 
                                                   value="{{ $setting->value }}"
                                                   readonly
                                                   class="flex-1 px-3 py-2 border border-gray-300 rounded-md bg-gray-50">
                                        </div>

                                    @elseif($setting->type === 'image')
                                        <div>
                                            @if($setting->value)
                                                <img src="{{ asset('storage/' . $setting->value) }}" 
                                                     alt="{{ $setting->label }}" 
                                                     class="w-32 h-32 object-cover rounded mb-2">
                                            @endif
                                            <input type="file" 
                                                   id="{{ $setting->key }}" 
                                                   name="{{ $setting->key }}" 
                                                   accept="image/*"
                                                   class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        </div>

                                    @elseif($setting->type === 'json')
                                        <textarea id="{{ $setting->key }}" 
                                                  name="{{ $setting->key }}" 
                                                  rows="4"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500 font-mono text-sm">{{ $setting->value }}</textarea>

                                    @elseif($setting->type === 'number')
                                        <input type="number" 
                                               id="{{ $setting->key }}" 
                                               name="{{ $setting->key }}" 
                                               value="{{ $setting->value }}"
                                               step="any"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">

                                    @else
                                        <input type="text" 
                                               id="{{ $setting->key }}" 
                                               name="{{ $setting->key }}" 
                                               value="{{ $setting->value }}"
                                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <!-- Save Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-md font-medium transition-colors">
                        <i class="fas fa-save mr-2"></i>Save Settings
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <script>
            alert('{{ session('success') }}');
        </script>
    @endif
</x-layouts.admin>

