<x-layouts.admin>
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Create WhatsApp Campaign</h1>
                    <p class="text-gray-600 mt-1">Send marketing messages to your customers</p>
                </div>
                <a href="{{ route('admin.whatsapp-marketing.campaigns') }}" 
                   class="text-blue-600 hover:text-blue-700">
                    ← Back to Campaigns
                </a>
            </div>
        </div>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-red-800">There were errors with your submission:</h3>
                        <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 rounded-lg p-4 mb-6">
                <p class="text-red-800">{{ session('error') }}</p>
            </div>
        @endif

        <!-- Campaign Form -->
        <form action="{{ route('admin.whatsapp-marketing.campaigns.store') }}" method="POST"
              class="bg-white rounded-lg shadow-sm border border-gray-200 p-6"
              onsubmit="return prepareFormSubmit()">
            @csrf

            <!-- Campaign Name -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Campaign Name <span class="text-red-500">*</span>
                </label>
                <input type="text" name="name" required
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       placeholder="e.g., Flash Sale - March 2025">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Select Template -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Select Template <span class="text-red-500">*</span>
                </label>
                <select name="template_id" id="template-select" required onchange="loadTemplatePreview()"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">-- Select a template --</option>
                    @foreach($templates as $template)
                        <option value="{{ $template->id }}"
                                data-variables="{{ json_encode($template->variables ?? []) }}"
                                data-variable-samples="{{ json_encode($template->variable_samples ?? []) }}"
                                data-header="{{ $template->header_text }}"
                                data-body="{{ $template->body_text }}"
                                data-footer="{{ $template->footer_text }}"
                                data-buttons="{{ json_encode($template->buttons ?? []) }}">
                            {{ $template->display_name }} ({{ $template->category }})
                        </option>
                    @endforeach
                </select>
                @error('template_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Template Preview -->
            <div id="template-preview" class="mb-6 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Template Preview
                </label>
                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                    <div class="max-w-sm mx-auto bg-white rounded-lg shadow-md p-4">
                        <div id="preview-header" class="font-semibold text-gray-900 mb-2"></div>
                        <div id="preview-body" class="text-gray-700 text-sm whitespace-pre-wrap mb-2"></div>
                        <div id="preview-footer" class="text-gray-500 text-xs"></div>
                        <div id="preview-buttons" class="mt-3 space-y-2"></div>
                    </div>
                </div>
            </div>

            <!-- Variable Mapping -->
            <div id="variable-values-section" class="mb-6 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    📋 Variable Mapping
                </label>
                <p class="text-sm text-gray-600 mb-3">
                    Map each variable to user data or custom value. Each user will receive personalized content.
                </p>
                <div id="variable-values-container" class="space-y-4">
                    <!-- Variable mapping will be added here -->
                </div>
            </div>

            <!-- Recipient Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Select Recipients <span class="text-red-500">*</span>
                </label>
                
                <div class="space-y-3">
                    <!-- All Users -->
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="recipient_type" value="all" checked onchange="toggleRecipientOptions()"
                               class="mr-3">
                        <div>
                            <div class="font-medium text-gray-900">All Users</div>
                            <div class="text-sm text-gray-600">Send to all registered users ({{ $totalUsers }} users)</div>
                        </div>
                    </label>

                    <!-- Specific Users -->
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="recipient_type" value="specific" onchange="toggleRecipientOptions()"
                               class="mr-3">
                        <div>
                            <div class="font-medium text-gray-900">Specific Users</div>
                            <div class="text-sm text-gray-600">Select individual users</div>
                        </div>
                    </label>

                    <!-- CSV Upload -->
                    <label class="flex items-center p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50">
                        <input type="radio" name="recipient_type" value="csv" onchange="toggleRecipientOptions()"
                               class="mr-3">
                        <div>
                            <div class="font-medium text-gray-900">Upload CSV</div>
                            <div class="text-sm text-gray-600">Upload a CSV file with phone numbers</div>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Specific Users Selection -->
            <div id="specific-users-section" class="mb-6 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Select Users
                </label>
                <div class="border border-gray-200 rounded-lg p-4 max-h-64 overflow-y-auto">
                    @foreach($users as $user)
                        <label class="flex items-center p-2 hover:bg-gray-50 rounded">
                            <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"
                                   class="mr-3">
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">{{ $user->name }}</div>
                                <div class="text-sm text-gray-600">{{ $user->phone ?? 'No phone' }}</div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- CSV Upload Section -->
            <div id="csv-upload-section" class="mb-6 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Upload CSV File
                </label>
                <input type="file" name="csv_file" accept=".csv"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <p class="text-sm text-gray-600 mt-2">
                    CSV should have columns: phone, name (optional), var1, var2, etc.
                </p>
            </div>

            <!-- Schedule -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Schedule
                </label>
                
                <div class="space-y-3">
                    <label class="flex items-center">
                        <input type="radio" name="schedule_type" value="now" checked onchange="toggleSchedule()"
                               class="mr-3">
                        <span>Send Now</span>
                    </label>
                    
                    <label class="flex items-center">
                        <input type="radio" name="schedule_type" value="later" onchange="toggleSchedule()"
                               class="mr-3">
                        <span>Schedule for Later</span>
                    </label>
                </div>
            </div>

            <!-- Schedule DateTime -->
            <div id="schedule-datetime-section" class="mb-6 hidden">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Schedule Date & Time
                </label>
                <input type="datetime-local" name="scheduled_at"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.whatsapp-marketing.campaigns') }}" 
                   class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit" 
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Create Campaign
                </button>
            </div>
        </form>
    </div>

    <script>
    function prepareFormSubmit() {
        console.log('Form submitting...');

        // Remove disabled inputs from hidden sections to avoid null values
        document.querySelectorAll('.variable-input.hidden').forEach(section => {
            section.querySelectorAll('input, select').forEach(el => {
                el.remove();
            });
        });

        // Enable remaining disabled inputs (like coupon selects that are visible)
        document.querySelectorAll('input[disabled], select[disabled]').forEach(el => {
            if (!el.closest('.hidden')) {
                console.log('Enabling:', el.name, el.value);
                el.disabled = false;
            }
        });

        // Log form data
        const formData = new FormData(document.querySelector('form'));
        console.log('Form data:');
        for (let [key, value] of formData.entries()) {
            console.log(key, '=', value);
        }

        return true;
    }

    function toggleRecipientOptions() {
        const recipientType = document.querySelector('input[name="recipient_type"]:checked').value;
        const specificSection = document.getElementById('specific-users-section');
        const csvSection = document.getElementById('csv-upload-section');
        
        specificSection.classList.add('hidden');
        csvSection.classList.add('hidden');
        
        if (recipientType === 'specific') {
            specificSection.classList.remove('hidden');
        } else if (recipientType === 'csv') {
            csvSection.classList.remove('hidden');
        }
    }

    function toggleSchedule() {
        const scheduleType = document.querySelector('input[name="schedule_type"]:checked').value;
        const datetimeSection = document.getElementById('schedule-datetime-section');
        
        if (scheduleType === 'later') {
            datetimeSection.classList.remove('hidden');
        } else {
            datetimeSection.classList.add('hidden');
        }
    }

    function loadTemplatePreview() {
        const select = document.getElementById('template-select');
        const option = select.options[select.selectedIndex];
        
        if (!option.value) {
            document.getElementById('template-preview').classList.add('hidden');
            document.getElementById('variable-values-section').classList.add('hidden');
            return;
        }
        
        const variables = JSON.parse(option.dataset.variables || '[]');
        const variableSamples = JSON.parse(option.dataset.variableSamples || '[]');
        const header = option.dataset.header;
        const body = option.dataset.body;
        const footer = option.dataset.footer;
        let buttons = [];
        try {
            buttons = JSON.parse(option.dataset.buttons || '[]');
            if (!Array.isArray(buttons)) {
                buttons = [];
            }
        } catch (e) {
            buttons = [];
        }

        // Show preview
        document.getElementById('template-preview').classList.remove('hidden');
        document.getElementById('preview-header').textContent = header || '';
        document.getElementById('preview-body').textContent = body || '';
        document.getElementById('preview-footer').textContent = footer || '';

        // Show buttons
        const buttonsContainer = document.getElementById('preview-buttons');
        buttonsContainer.innerHTML = '';
        if (buttons && buttons.length > 0) {
            buttons.forEach(btn => {
                const btnHtml = `<div class="text-center py-2 border border-blue-500 text-blue-600 rounded-lg text-sm">${btn.text || ''}</div>`;
                buttonsContainer.insertAdjacentHTML('beforeend', btnHtml);
            });
        }
        
        // Show variable mapping
        if (variables.length > 0) {
            document.getElementById('variable-values-section').classList.remove('hidden');
            const container = document.getElementById('variable-values-container');
            container.innerHTML = '';

            // Smart labels for common variable patterns
            const smartLabels = {
                1: 'Customer Name',
                2: 'Discount/Amount/Order Number',
                3: 'Coupon Code/Product',
                4: 'Date/Time/Expiry',
                5: 'Additional Info'
            };

            variables.forEach((varNum, index) => {
                const label = smartLabels[varNum] || 'Variable ' + varNum;
                const sampleValue = (variableSamples && variableSamples[index]) ? variableSamples[index] : '';

                const inputHtml = `
                    <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                        <label class="block text-sm font-semibold text-gray-900 mb-2">
                            ` + '{{' + `${varNum}` + '}}' + ` - ${label}
                        </label>

                        <div class="mb-3">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Data Source</label>
                            <select name="variable_types[${index}]"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm variable-type-select"
                                    onchange="toggleVariableInput(${index}, ${varNum})"
                                    data-index="${index}">
                                <option value="user_field">👤 User Data</option>
                                <option value="coupon">🎟️ Coupon Code</option>
                                <option value="custom">✏️ Custom Value (Same for all)</option>
                            </select>
                        </div>

                        <!-- User Field Selection -->
                        <div id="user-field-${index}" class="variable-input">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Select User Field</label>
                            <select name="variable_values[${index}]"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
                                <option value="name">Name</option>
                                <option value="email">Email</option>
                                <option value="phone">Phone Number</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Each user gets their own ${label.toLowerCase()}</p>
                        </div>

                        <!-- Coupon Selection -->
                        <div id="coupon-${index}" class="variable-input hidden">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Select Coupon</label>
                            <select name="variable_values[${index}]"
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                                    disabled>
                                <option value="">Loading coupons...</option>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Same coupon for all users</p>
                        </div>

                        <!-- Custom Value -->
                        <div id="custom-${index}" class="variable-input hidden">
                            <label class="block text-xs font-medium text-gray-700 mb-1">Enter Custom Value</label>
                            <input type="text"
                                   name="variable_values[${index}]"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                                   placeholder="${sampleValue || 'Enter value'}"
                                   disabled>
                            <p class="text-xs text-gray-500 mt-1">Same value for all users</p>
                        </div>
                    </div>
                `;
                container.insertAdjacentHTML('beforeend', inputHtml);
            });

            // Load coupons
            loadCoupons();
        } else {
            document.getElementById('variable-values-section').classList.add('hidden');
        }
    }

    function toggleVariableInput(index, varNum) {
        const select = document.querySelector(`select[data-index="${index}"]`);
        const type = select.value;

        // Hide all inputs for this variable
        document.getElementById(`user-field-${index}`).classList.add('hidden');
        document.getElementById(`coupon-${index}`).classList.add('hidden');
        document.getElementById(`custom-${index}`).classList.add('hidden');

        // Disable all inputs
        document.querySelectorAll(`#user-field-${index} select, #user-field-${index} input`).forEach(el => el.disabled = true);
        document.querySelectorAll(`#coupon-${index} select, #coupon-${index} input`).forEach(el => el.disabled = true);
        document.querySelectorAll(`#custom-${index} select, #custom-${index} input`).forEach(el => el.disabled = true);

        // Show and enable selected input
        if (type === 'user_field') {
            document.getElementById(`user-field-${index}`).classList.remove('hidden');
            document.querySelectorAll(`#user-field-${index} select, #user-field-${index} input`).forEach(el => el.disabled = false);
        } else if (type === 'coupon') {
            document.getElementById(`coupon-${index}`).classList.remove('hidden');
            document.querySelectorAll(`#coupon-${index} select, #coupon-${index} input`).forEach(el => el.disabled = false);
        } else if (type === 'custom') {
            document.getElementById(`custom-${index}`).classList.remove('hidden');
            document.querySelectorAll(`#custom-${index} select, #custom-${index} input`).forEach(el => el.disabled = false);
        }
    }

    function loadCoupons() {
        // Fetch coupons from API
        fetch('/admin/api/coupons')
            .then(response => response.json())
            .then(data => {
                console.log('Coupons loaded:', data);
                document.querySelectorAll('select[name^="variable_values"]').forEach(select => {
                    if (select.closest('[id^="coupon-"]')) {
                        select.innerHTML = '<option value="">-- Select Coupon --</option>';
                        if (data.coupons && data.coupons.length > 0) {
                            data.coupons.forEach(coupon => {
                                select.innerHTML += `<option value="${coupon.code}">${coupon.code} - ${coupon.discount}</option>`;
                            });
                        } else {
                            select.innerHTML += '<option value="">No coupons available</option>';
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error loading coupons:', error);
            });
    }
    </script>
</x-layouts.admin>

