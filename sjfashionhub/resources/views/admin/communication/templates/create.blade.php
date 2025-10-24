<x-layouts.admin>
    <x-slot name="title">Create Communication Template</x-slot>

    <div class="container mx-auto px-4 py-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">➕ Create Communication Template</h1>
                <p class="text-gray-600 mt-1">Create a new email, SMS, or WhatsApp template</p>
            </div>
            <a href="{{ route('admin.communication-templates.index') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
                ← Back to Templates
            </a>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.communication-templates.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Main Form -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Basic Information -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4">📋 Basic Information</h2>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <!-- Template Name -->
                            <div class="col-span-2">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                    Template Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="e.g., Order Confirmation Email">
                            </div>

                            <!-- Type -->
                            <div>
                                <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                    Type <span class="text-red-500">*</span>
                                </label>
                                <select name="type" id="type" required onchange="toggleSubjectField()"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Select Type</option>
                                    @foreach($types as $type)
                                        <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>
                                            {{ strtoupper($type) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Category -->
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">
                                    Category <span class="text-red-500">*</span>
                                </label>
                                <select name="category" id="category" required onchange="updateEventOptions()"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>
                                            {{ ucfirst($category) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Event -->
                            <div class="col-span-2">
                                <label for="event" class="block text-sm font-medium text-gray-700 mb-2">
                                    Event <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="event" id="event" value="{{ old('event') }}" required
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       placeholder="e.g., order_placed, user_registered">
                                <p class="text-xs text-gray-500 mt-1">Unique identifier for this event (lowercase, underscores only)</p>
                            </div>

                            <!-- Language -->
                            <div>
                                <label for="language" class="block text-sm font-medium text-gray-700 mb-2">
                                    Language <span class="text-red-500">*</span>
                                </label>
                                <select name="language" id="language" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    @foreach($languages as $code => $name)
                                        <option value="{{ $code }}" {{ old('language', 'en') === $code ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Priority -->
                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                                    Priority
                                </label>
                                <input type="number" name="priority" id="priority" value="{{ old('priority', 0) }}" min="0" max="100"
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <p class="text-xs text-gray-500 mt-1">Higher priority templates are used first (0-100)</p>
                            </div>

                            <!-- Description -->
                            <div class="col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                                    Description
                                </label>
                                <textarea name="description" id="description" rows="2"
                                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                          placeholder="Brief description of this template">{{ old('description') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Subject (for email) -->
                    <div id="subjectSection" class="bg-white rounded-lg shadow-md p-6" style="display: none">
                        <h2 class="text-xl font-semibold mb-4">📬 Subject</h2>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                               placeholder="Email subject line">
                        <p class="text-xs text-gray-500 mt-1">Use variables like @{{'{{'}}customer_name@{{'}}'}}, @{{'{{'}}order_number@{{'}}'}}, etc.</p>
                    </div>

                    <!-- Content -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4">📝 Content</h2>
                        <textarea name="content" id="content" rows="10" required
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm"
                                  placeholder="Template content...">{{ old('content') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">Plain text content. Use variables like @{{'{{'}}customer_name@{{'}}'}}, @{{'{{'}}order_number@{{'}}'}}, etc.</p>
                    </div>

                    <!-- HTML Content (for email) -->
                    <div id="htmlSection" class="bg-white rounded-lg shadow-md p-6" style="display: none">
                        <h2 class="text-xl font-semibold mb-4">🎨 HTML Content (Optional)</h2>
                        <textarea name="html_content" id="html_content" rows="15"
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent font-mono text-sm"
                                  placeholder="<html>...">{{ old('html_content') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">HTML version of the email. Leave empty to use plain text only.</p>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Status -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4">⚙️ Settings</h2>
                        
                        <div class="space-y-4">
                            <!-- Active -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_active" id="is_active" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="is_active" class="ml-2 text-sm font-medium text-gray-700">
                                    Active
                                </label>
                            </div>

                            <!-- Default -->
                            <div class="flex items-center">
                                <input type="checkbox" name="is_default" id="is_default" value="1"
                                       {{ old('is_default') ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="is_default" class="ml-2 text-sm font-medium text-gray-700">
                                    Default Template
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Common Variables -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold mb-4">🔤 Common Variables</h2>
                        <div class="space-y-2 max-h-96 overflow-y-auto">
                            <div class="bg-gray-50 px-3 py-2 rounded font-mono text-sm cursor-pointer hover:bg-gray-100"
                                 onclick="copyVariable('customer_name')">@{{'{{'}}customer_name@{{'}}'}}</div>
                            <div class="bg-gray-50 px-3 py-2 rounded font-mono text-sm cursor-pointer hover:bg-gray-100"
                                 onclick="copyVariable('customer_email')">@{{'{{'}}customer_email@{{'}}'}}</div>
                            <div class="bg-gray-50 px-3 py-2 rounded font-mono text-sm cursor-pointer hover:bg-gray-100"
                                 onclick="copyVariable('customer_phone')">@{{'{{'}}customer_phone@{{'}}'}}</div>
                            <div class="bg-gray-50 px-3 py-2 rounded font-mono text-sm cursor-pointer hover:bg-gray-100"
                                 onclick="copyVariable('order_number')">@{{'{{'}}order_number@{{'}}'}}</div>
                            <div class="bg-gray-50 px-3 py-2 rounded font-mono text-sm cursor-pointer hover:bg-gray-100"
                                 onclick="copyVariable('order_total')">@{{'{{'}}order_total@{{'}}'}}</div>
                            <div class="bg-gray-50 px-3 py-2 rounded font-mono text-sm cursor-pointer hover:bg-gray-100"
                                 onclick="copyVariable('order_status')">@{{'{{'}}order_status@{{'}}'}}</div>
                            <div class="bg-gray-50 px-3 py-2 rounded font-mono text-sm cursor-pointer hover:bg-gray-100"
                                 onclick="copyVariable('tracking_id')">@{{'{{'}}tracking_id@{{'}}'}}</div>
                            <div class="bg-gray-50 px-3 py-2 rounded font-mono text-sm cursor-pointer hover:bg-gray-100"
                                 onclick="copyVariable('site_name')">@{{'{{'}}site_name@{{'}}'}}</div>
                            <div class="bg-gray-50 px-3 py-2 rounded font-mono text-sm cursor-pointer hover:bg-gray-100"
                                 onclick="copyVariable('site_url')">@{{'{{'}}site_url@{{'}}'}}</div>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Click to copy variable</p>
                    </div>

                    <!-- Actions -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <div class="space-y-3">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-lg transition-colors font-medium">
                                💾 Create Template
                            </button>
                            <a href="{{ route('admin.communication-templates.index') }}"
                               class="block w-full text-center bg-gray-600 hover:bg-gray-700 text-white px-4 py-3 rounded-lg transition-colors">
                                Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        function toggleSubjectField() {
            const type = document.getElementById('type').value;
            const subjectSection = document.getElementById('subjectSection');
            const htmlSection = document.getElementById('htmlSection');
            
            if (type === 'email') {
                subjectSection.style.display = 'block';
                htmlSection.style.display = 'block';
            } else {
                subjectSection.style.display = 'none';
                htmlSection.style.display = 'none';
            }
        }

        function copyVariable(variable) {
            const text = '{{' + variable + '}}';
            navigator.clipboard.writeText(text).then(() => {
                // Show a brief success message
                const el = event.target;
                const originalBg = el.className;
                el.className = el.className.replace('bg-gray-50', 'bg-green-100');
                setTimeout(() => {
                    el.className = originalBg;
                }, 300);
            });
        }
    </script>
</x-layouts.admin>

