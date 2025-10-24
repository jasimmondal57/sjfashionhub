<x-layouts.mobileadmin>
    <div class="p-6">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">⚙️ App Settings</h1>
            <p class="text-gray-600 mt-1">Configure your mobile app settings</p>
        </div>

        <form action="{{ route('mobileadmin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @foreach($settings as $group => $groupSettings)
                <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6 capitalize flex items-center">
                        @if($group === 'api')
                            <i class="fas fa-code text-blue-600 mr-2"></i>
                        @elseif($group === 'general')
                            <i class="fas fa-cog text-gray-600 mr-2"></i>
                        @elseif($group === 'theme')
                            <i class="fas fa-palette text-purple-600 mr-2"></i>
                        @elseif($group === 'notification')
                            <i class="fas fa-bell text-red-600 mr-2"></i>
                        @elseif($group === 'features')
                            <i class="fas fa-star text-yellow-600 mr-2"></i>
                        @endif
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
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" 
                                                   id="{{ $setting->key }}" 
                                                   name="{{ $setting->key }}" 
                                                   value="true"
                                                   {{ $setting->value === 'true' || $setting->value === '1' ? 'checked' : '' }}
                                                   class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                            <span class="ml-3 text-sm font-medium text-gray-900">Enable</span>
                                        </label>
                                    </div>

                                @elseif($setting->type === 'color')
                                    <div class="flex items-center gap-3">
                                        <input type="color" 
                                               id="{{ $setting->key }}" 
                                               name="{{ $setting->key }}" 
                                               value="{{ $setting->value }}"
                                               class="h-12 w-24 border-2 border-gray-300 rounded-lg cursor-pointer">
                                        <input type="text" 
                                               value="{{ $setting->value }}"
                                               readonly
                                               class="flex-1 px-4 py-2 border border-gray-300 rounded-lg bg-gray-50 font-mono text-sm">
                                    </div>

                                @elseif($setting->type === 'image')
                                    <div>
                                        @if($setting->value)
                                            <img src="{{ asset('storage/' . $setting->value) }}" 
                                                 alt="{{ $setting->label }}" 
                                                 class="w-32 h-32 object-cover rounded-lg mb-3 border-2 border-gray-200">
                                        @endif
                                        <input type="file" 
                                               id="{{ $setting->key }}" 
                                               name="{{ $setting->key }}" 
                                               accept="image/*"
                                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 cursor-pointer">
                                    </div>

                                @elseif($setting->type === 'json')
                                    <textarea id="{{ $setting->key }}" 
                                              name="{{ $setting->key }}" 
                                              rows="6"
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-mono text-sm bg-gray-50">{{ $setting->value }}</textarea>

                                @elseif($setting->type === 'number')
                                    <input type="number" 
                                           id="{{ $setting->key }}" 
                                           name="{{ $setting->key }}" 
                                           value="{{ $setting->value }}"
                                           step="any"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                                @else
                                    <input type="text" 
                                           id="{{ $setting->key }}" 
                                           name="{{ $setting->key }}" 
                                           value="{{ $setting->value }}"
                                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endforeach

            <!-- Save Button -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('mobileadmin.dashboard') }}" 
                   class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-3 rounded-lg font-medium transition-colors">
                    <i class="fas fa-times mr-2"></i>Cancel
                </a>
                <button type="submit" 
                        class="bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white px-8 py-3 rounded-lg font-medium transition-all shadow-lg">
                    <i class="fas fa-save mr-2"></i>Save Settings
                </button>
            </div>
        </form>
    </div>
</x-layouts.mobileadmin>

