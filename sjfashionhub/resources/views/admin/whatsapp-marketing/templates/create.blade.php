<x-layouts.admin>
    <x-slot name="title">Create WhatsApp Template</x-slot>

<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">📝 Create WhatsApp Template</h1>
            <p class="text-gray-600 mt-1">Design your message template for WhatsApp marketing</p>
        </div>
        <a href="{{ route('admin.whatsapp-marketing.templates') }}" 
           class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
            ← Back to Templates
        </a>
    </div>

    <!-- AI Generator Card -->
    <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg shadow-lg p-6 mb-6">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <h3 class="text-xl font-bold text-white mb-2">🤖 Generate Template with AI</h3>
                <p class="text-purple-100 text-sm mb-4">Let Gemini AI create a professional WhatsApp template for you in seconds!</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    <input type="text" id="ai_purpose" placeholder="e.g., Flash sale announcement"
                           class="px-3 py-2 rounded-lg border-0 text-gray-900 placeholder-gray-500">
                    <select id="ai_category" class="px-3 py-2 rounded-lg border-0 text-gray-900">
                        <option value="MARKETING">Marketing</option>
                        <option value="UTILITY">Utility</option>
                        <option value="AUTHENTICATION">Authentication</option>
                    </select>
                    <select id="ai_tone" class="px-3 py-2 rounded-lg border-0 text-gray-900">
                        <option value="professional">Professional</option>
                        <option value="friendly">Friendly</option>
                        <option value="casual">Casual</option>
                        <option value="urgent">Urgent</option>
                    </select>
                    <div class="flex gap-2">
                        <label class="flex items-center text-white text-sm">
                            <input type="checkbox" id="ai_discount" class="mr-2">
                            Include Discount
                        </label>
                        <label class="flex items-center text-white text-sm">
                            <input type="checkbox" id="ai_cta" checked class="mr-2">
                            Include CTA
                        </label>
                    </div>
                </div>

                <button type="button" onclick="generateWithAI()" id="ai_generate_btn"
                        class="bg-white hover:bg-gray-100 text-purple-600 font-semibold px-6 py-2 rounded-lg transition-colors">
                    ✨ Generate Template with AI
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Form -->
        <div class="lg:col-span-2">
            <form method="POST" action="{{ route('admin.whatsapp-marketing.templates.store') }}" class="bg-white rounded-lg shadow-md p-6">
                @csrf

                <!-- Template Name -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Template Name *
                        <span class="text-xs text-gray-500 font-normal">(Display name for admin panel)</span>
                    </label>
                    <input type="text" name="display_name" required
                           class="w-full border border-gray-300 rounded-lg px-3 py-2"
                           placeholder="e.g., Summer Sale 2025">
                    @error('display_name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Category *
                    </label>
                    <select name="category" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="">Select category</option>
                        <option value="MARKETING">Marketing - Promotional messages</option>
                        <option value="UTILITY">Utility - Account updates, order status</option>
                        <option value="AUTHENTICATION">Authentication - OTP, verification codes</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Language -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Language *
                    </label>
                    <select name="language" required class="w-full border border-gray-300 rounded-lg px-3 py-2">
                        <option value="en">English</option>
                        <option value="hi">Hindi</option>
                        <option value="en_US">English (US)</option>
                        <option value="en_GB">English (UK)</option>
                    </select>
                    @error('language')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Header (Optional) -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Header (Optional)
                        <span class="text-xs text-gray-500 font-normal">(Max 60 characters)</span>
                    </label>
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-3">
                        <p class="text-xs text-yellow-800">
                            ⚠️ <strong>Important:</strong> Headers cannot contain emojis, asterisks (*), underscores (_), or new lines. Use plain text only.
                        </p>
                    </div>
                    <div class="grid grid-cols-3 gap-3 mb-2">
                        <select name="header_type" class="border border-gray-300 rounded-lg px-3 py-2">
                            <option value="">No Header</option>
                            <option value="TEXT">Text</option>
                            <option value="IMAGE">Image</option>
                            <option value="VIDEO">Video</option>
                            <option value="DOCUMENT">Document</option>
                        </select>
                    </div>

                    <!-- Variable Buttons for Header -->
                    <div class="mb-2 flex flex-wrap gap-2">
                        <span class="text-xs text-gray-600 font-medium">Insert Variable:</span>
                        <button type="button" onclick="insertVariable('header_text', '{{1}}')"
                                class="px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs rounded-md transition-colors">
                            + {{1}}
                        </button>
                        <button type="button" onclick="insertVariable('header_text', '{{2}}')"
                                class="px-2 py-1 bg-green-100 hover:bg-green-200 text-green-700 text-xs rounded-md transition-colors">
                            + {{2}}
                        </button>
                        <button type="button" onclick="insertVariable('header_text', '{{3}}')"
                                class="px-2 py-1 bg-purple-100 hover:bg-purple-200 text-purple-700 text-xs rounded-md transition-colors">
                            + {{3}}
                        </button>
                    </div>

                    <input type="text" name="header_text" id="header_text" maxlength="60"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2"
                           placeholder="e.g., 🎉 Special Offer!">
                    @error('header_text')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Body Text -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Message Body *
                        <span class="text-xs text-gray-500 font-normal">(Max 1024 characters)</span>
                    </label>

                    <!-- Variable Buttons -->
                    <div class="mb-2 flex flex-wrap gap-2">
                        <span class="text-xs text-gray-600 font-medium">Insert Variable:</span>
                        <button type="button" onclick="insertVariable('body_text', '{{1}}')"
                                class="px-3 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs rounded-md transition-colors">
                            + {{1}} Customer Name
                        </button>
                        <button type="button" onclick="insertVariable('body_text', '{{2}}')"
                                class="px-3 py-1 bg-green-100 hover:bg-green-200 text-green-700 text-xs rounded-md transition-colors">
                            + {{2}} Value/Amount
                        </button>
                        <button type="button" onclick="insertVariable('body_text', '{{3}}')"
                                class="px-3 py-1 bg-purple-100 hover:bg-purple-200 text-purple-700 text-xs rounded-md transition-colors">
                            + {{3}} Code/Product
                        </button>
                        <button type="button" onclick="insertVariable('body_text', '{{4}}')"
                                class="px-3 py-1 bg-yellow-100 hover:bg-yellow-200 text-yellow-700 text-xs rounded-md transition-colors">
                            + {{4}} Date/Time
                        </button>
                        <button type="button" onclick="insertVariable('body_text', '{{5}}')"
                                class="px-3 py-1 bg-pink-100 hover:bg-pink-200 text-pink-700 text-xs rounded-md transition-colors">
                            + {{5}} Custom
                        </button>
                    </div>

                    <textarea name="body_text" id="body_text" required rows="6" maxlength="1024"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2"
                              placeholder="Hi {{1}}, Get {{2}}% off on your next purchase! Use code: {{3}}"></textarea>
                    <p class="text-xs text-gray-500 mt-1">
                        💡 Use {{1}}, {{2}}, {{3}} for variables (e.g., customer name, discount, code)
                    </p>
                    @error('body_text')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Footer (Optional) -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Footer (Optional)
                        <span class="text-xs text-gray-500 font-normal">(Max 60 characters)</span>
                    </label>

                    <!-- Variable Buttons for Footer -->
                    <div class="mb-2 flex flex-wrap gap-2">
                        <span class="text-xs text-gray-600 font-medium">Insert Variable:</span>
                        <button type="button" onclick="insertVariable('footer_text', '{{1}}')"
                                class="px-2 py-1 bg-blue-100 hover:bg-blue-200 text-blue-700 text-xs rounded-md transition-colors">
                            + {{1}}
                        </button>
                        <button type="button" onclick="insertVariable('footer_text', '{{2}}')"
                                class="px-2 py-1 bg-green-100 hover:bg-green-200 text-green-700 text-xs rounded-md transition-colors">
                            + {{2}}
                        </button>
                    </div>

                    <input type="text" name="footer_text" id="footer_text" maxlength="60"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2"
                           placeholder="e.g., SJ Fashion Hub - Your Style Partner">
                    @error('footer_text')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Variable Samples (REQUIRED for WhatsApp Approval) -->
                <div class="mb-6" id="variable-samples-section" style="display: none;">
                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-yellow-800">
                                    ⚠️ Variable Samples Required for WhatsApp Approval
                                </h3>
                                <div class="mt-2 text-sm text-yellow-700">
                                    <p>WhatsApp requires example values for all variables ({{1}}, {{2}}, etc.) to review your template.</p>
                                    <p class="mt-1"><strong>Important:</strong> Use realistic examples, NOT real customer data.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <label class="block text-sm font-medium text-gray-700 mb-3">
                        Variable Sample Values *
                        <span class="text-xs text-gray-500 font-normal">(Example values for Meta to review)</span>
                    </label>

                    <div id="variable-samples-container" class="space-y-3">
                        <!-- Variable sample inputs will be added here dynamically -->
                    </div>
                </div>

                <!-- Buttons (Optional) -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Call-to-Action Buttons (Optional)
                    </label>
                    <div id="buttons-container" class="space-y-3">
                        <!-- Buttons will be added here dynamically -->
                    </div>
                    <button type="button" onclick="addButton()" 
                            class="mt-3 text-blue-600 hover:text-blue-700 text-sm font-medium">
                        + Add Button
                    </button>
                </div>

                <!-- Submit -->
                <div class="flex justify-end gap-3">
                    <a href="{{ route('admin.whatsapp-marketing.templates') }}" 
                       class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                        💾 Save Template
                    </button>
                </div>
            </form>
        </div>

        <!-- Preview -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-6">
                <h3 class="font-bold text-gray-900 mb-4">📱 Preview</h3>
                
                <!-- WhatsApp Message Preview -->
                <div class="bg-gray-100 rounded-lg p-4">
                    <div class="bg-white rounded-lg shadow-sm p-4 max-w-xs">
                        <!-- Header Preview -->
                        <div id="preview-header" class="font-bold text-gray-900 mb-2 hidden"></div>
                        
                        <!-- Body Preview -->
                        <div id="preview-body" class="text-gray-800 text-sm whitespace-pre-wrap">
                            Your message will appear here...
                        </div>
                        
                        <!-- Footer Preview -->
                        <div id="preview-footer" class="text-gray-500 text-xs mt-2 hidden"></div>
                        
                        <!-- Buttons Preview -->
                        <div id="preview-buttons" class="mt-3 space-y-2 hidden"></div>
                        
                        <!-- Timestamp -->
                        <div class="text-right text-xs text-gray-400 mt-2">
                            {{ now()->format('H:i') }}
                        </div>
                    </div>
                </div>

                <!-- Tips -->
                <div class="mt-6 bg-blue-50 rounded-lg p-4">
                    <h4 class="font-bold text-blue-900 text-sm mb-2">💡 Tips</h4>
                    <ul class="text-xs text-blue-800 space-y-1">
                        <li>• Keep messages clear and concise</li>
                        <li>• Use variables for personalization</li>
                        <li>• Add call-to-action buttons</li>
                        <li>• Templates need WhatsApp approval</li>
                        <li>• Approval usually takes 24-48 hours</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let buttonCount = 0;

// Insert variable at cursor position
function insertVariable(fieldId, variable) {
    const field = document.getElementById(fieldId);
    const startPos = field.selectionStart;
    const endPos = field.selectionEnd;
    const textBefore = field.value.substring(0, startPos);
    const textAfter = field.value.substring(endPos, field.value.length);

    // Insert variable at cursor position
    field.value = textBefore + variable + textAfter;

    // Set cursor position after inserted variable
    const newPos = startPos + variable.length;
    field.setSelectionRange(newPos, newPos);
    field.focus();

    // Update preview
    updatePreview();

    // Visual feedback
    const button = event.target;
    const originalBg = button.className;
    button.className = button.className.replace(/bg-\w+-100/, 'bg-green-300');
    setTimeout(() => {
        button.className = originalBg;
    }, 200);
}

// Add button
function addButton() {
    if (buttonCount >= 3) {
        alert('Maximum 3 buttons allowed');
        return;
    }

    buttonCount++;
    const container = document.getElementById('buttons-container');
    const buttonHtml = `
        <div class="border border-gray-200 rounded-lg p-3" id="button-${buttonCount}">
            <div class="flex gap-2 items-start mb-2">
                <select name="buttons[${buttonCount}][type]" onchange="toggleButtonFields(${buttonCount})"
                        class="border border-gray-300 rounded-lg px-3 py-2 button-type-select">
                    <option value="QUICK_REPLY">Quick Reply</option>
                    <option value="URL">Visit Website</option>
                    <option value="PHONE_NUMBER">Call</option>
                </select>
                <input type="text" name="buttons[${buttonCount}][text]"
                       class="flex-1 border border-gray-300 rounded-lg px-3 py-2"
                       placeholder="Button text" maxlength="20">
                <button type="button" onclick="removeButton(${buttonCount})"
                        class="text-red-600 hover:text-red-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="button-url-field-${buttonCount} hidden mt-2">
                <label class="block text-xs font-medium text-gray-700 mb-1">
                    🔗 Website URL (Required for Visit Website button)
                </label>
                <input type="text" name="buttons[${buttonCount}][url]"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                       placeholder="https://sjfashionhub.com"
                       required>
                <p class="text-xs text-gray-500 mt-1">Enter full URL starting with https://</p>
            </div>
            <div class="button-phone-field-${buttonCount} hidden mt-2">
                <label class="block text-xs font-medium text-gray-700 mb-1">
                    📞 Phone Number (Required for Call button)
                </label>
                <input type="text" name="buttons[${buttonCount}][phone_number]"
                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                       placeholder="+919876543210"
                       required>
                <p class="text-xs text-gray-500 mt-1">Include country code (e.g., +91 for India)</p>
            </div>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', buttonHtml);
    updatePreview();
}

// Toggle button fields based on type
function toggleButtonFields(buttonId) {
    const select = document.querySelector(`#button-${buttonId} .button-type-select`);
    const urlField = document.querySelector(`.button-url-field-${buttonId}`);
    const phoneField = document.querySelector(`.button-phone-field-${buttonId}`);
    const urlInput = urlField.querySelector('input');
    const phoneInput = phoneField.querySelector('input');

    if (select.value === 'URL') {
        urlField.classList.remove('hidden');
        phoneField.classList.add('hidden');
        urlInput.required = true;
        phoneInput.required = false;
    } else if (select.value === 'PHONE_NUMBER') {
        phoneField.classList.remove('hidden');
        urlField.classList.add('hidden');
        phoneInput.required = true;
        urlInput.required = false;
    } else {
        urlField.classList.add('hidden');
        phoneField.classList.add('hidden');
        urlInput.required = false;
        phoneInput.required = false;
    }
    updatePreview();
}

// Remove button
function removeButton(id) {
    document.getElementById(`button-${id}`).remove();
    buttonCount--;
    updatePreview();
}

// Update preview
function updatePreview() {
    // Header
    const headerText = document.querySelector('[name="header_text"]').value;
    const headerPreview = document.getElementById('preview-header');
    if (headerText) {
        headerPreview.textContent = headerText;
        headerPreview.classList.remove('hidden');
    } else {
        headerPreview.classList.add('hidden');
    }
    
    // Body
    const bodyText = document.querySelector('[name="body_text"]').value;
    const bodyPreview = document.getElementById('preview-body');
    bodyPreview.textContent = bodyText || 'Your message will appear here...';
    
    // Footer
    const footerText = document.querySelector('[name="footer_text"]').value;
    const footerPreview = document.getElementById('preview-footer');
    if (footerText) {
        footerPreview.textContent = footerText;
        footerPreview.classList.remove('hidden');
    } else {
        footerPreview.classList.add('hidden');
    }
    
    // Buttons
    const buttonsPreview = document.getElementById('preview-buttons');
    const buttonInputs = document.querySelectorAll('[name^="buttons"][name$="[text]"]');
    if (buttonInputs.length > 0) {
        buttonsPreview.innerHTML = '';
        buttonInputs.forEach(input => {
            if (input.value) {
                const btn = document.createElement('button');
                btn.className = 'w-full bg-white border border-blue-500 text-blue-600 py-2 rounded text-sm font-medium';
                btn.textContent = input.value;
                buttonsPreview.appendChild(btn);
            }
        });
        buttonsPreview.classList.remove('hidden');
    } else {
        buttonsPreview.classList.add('hidden');
    }

    // Update variable samples section
    updateVariableSamples();
}

// Detect variables and create sample input fields
function updateVariableSamples() {
    const headerText = document.querySelector('[name="header_text"]').value;
    const bodyText = document.querySelector('[name="body_text"]').value;
    const allText = headerText + ' ' + bodyText;

    // Find all variables like {{1}}, {{2}}, {{3}}, etc.
    const variableMatches = allText.match(/\{\{(\d+)\}\}/g);

    if (!variableMatches || variableMatches.length === 0) {
        // No variables found, hide the section
        document.getElementById('variable-samples-section').style.display = 'none';
        return;
    }

    // Extract unique variable numbers
    const variableNumbers = [...new Set(variableMatches.map(v => parseInt(v.match(/\d+/)[0])))].sort((a, b) => a - b);

    // Show the section
    document.getElementById('variable-samples-section').style.display = 'block';

    // Create input fields for each variable
    const container = document.getElementById('variable-samples-container');
    container.innerHTML = '';

    const exampleLabels = {
        1: 'Customer Name',
        2: 'Discount/Amount',
        3: 'Code/Order Number',
        4: 'Date/Time',
        5: 'Custom Value'
    };

    variableNumbers.forEach((num, index) => {
        const label = exampleLabels[num] || `Variable ${num}`;
        const inputHtml = `
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0 w-20 pt-2">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        ` + '{{' + `${num}` + '}}' + `
                    </span>
                </div>
                <div class="flex-1">
                    <label class="block text-xs font-medium text-gray-700 mb-1">
                        Sample for ` + '{{' + `${num}` + '}}' + ` (${label})
                    </label>
                    <input type="text"
                           name="variable_samples[${index}]"
                           class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"
                           placeholder="e.g., ${getSamplePlaceholder(num)}"
                           required>
                    <p class="text-xs text-gray-500 mt-1">Use realistic example, NOT real customer data</p>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', inputHtml);
    });
}

// Get sample placeholder based on variable number
function getSamplePlaceholder(num) {
    const placeholders = {
        1: 'John Doe',
        2: '10% or ₹500',
        3: 'WELCOME10 or #12345',
        4: 'March 15, 2025',
        5: 'Example value'
    };
    return placeholders[num] || 'Example value';
}

// Add event listeners
document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('[name="header_text"]').addEventListener('input', updatePreview);
    document.querySelector('[name="body_text"]').addEventListener('input', updatePreview);
    document.querySelector('[name="footer_text"]').addEventListener('input', updatePreview);
});

// Generate template with AI
async function generateWithAI() {
    const purpose = document.getElementById('ai_purpose').value;
    const category = document.getElementById('ai_category').value;
    const tone = document.getElementById('ai_tone').value;
    const includeDiscount = document.getElementById('ai_discount').checked;
    const includeCta = document.getElementById('ai_cta').checked;

    if (!purpose) {
        alert('Please enter the purpose of your template');
        return;
    }

    const button = document.getElementById('ai_generate_btn');
    const originalText = button.innerHTML;
    button.innerHTML = '⏳ Generating with AI...';
    button.disabled = true;

    try {
        const response = await fetch('{{ route("admin.whatsapp-marketing.templates.generate-ai") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                purpose: purpose,
                category: category,
                tone: tone,
                include_discount: includeDiscount,
                include_cta: includeCta
            })
        });

        const data = await response.json();

        if (data.success) {
            // Fill in the form with AI-generated data
            if (data.data.display_name) {
                document.querySelector('[name="display_name"]').value = data.data.display_name;
            }
            if (data.data.header_text) {
                document.querySelector('[name="header_text"]').value = data.data.header_text;
                document.querySelector('[name="header_type"]').value = 'TEXT';
            }
            if (data.data.body_text) {
                document.querySelector('[name="body_text"]').value = data.data.body_text;
            }
            if (data.data.footer_text) {
                document.querySelector('[name="footer_text"]').value = data.data.footer_text;
            }

            // Set category
            document.querySelector('[name="category"]').value = category;

            // Add buttons if provided
            if (data.data.buttons && data.data.buttons.length > 0) {
                // Clear existing buttons
                document.getElementById('buttons-container').innerHTML = '';
                buttonCount = 0;

                // Add AI-generated buttons
                data.data.buttons.forEach((btn, index) => {
                    if (index < 3) { // Max 3 buttons
                        addButton();
                        const lastButton = document.getElementById(`button-${buttonCount}`);
                        if (lastButton) {
                            const typeSelect = lastButton.querySelector('select');
                            const textInput = lastButton.querySelector('input[name*="[text]"]');
                            const urlInput = lastButton.querySelector('input[name*="[url]"]');
                            const phoneInput = lastButton.querySelector('input[name*="[phone_number]"]');

                            typeSelect.value = btn.type || 'QUICK_REPLY';
                            textInput.value = btn.text || '';

                            // Set URL or phone if provided
                            if (btn.url && urlInput) {
                                urlInput.value = btn.url;
                            }
                            if (btn.phone_number && phoneInput) {
                                phoneInput.value = btn.phone_number;
                            }

                            // Toggle fields to show URL/phone if needed
                            toggleButtonFields(buttonCount);
                        }
                    }
                });
            }

            // Update preview
            updatePreview();

            // Show success message
            alert('✅ Template generated successfully! Review and customize as needed.');

            // Scroll to form
            document.querySelector('form').scrollIntoView({ behavior: 'smooth', block: 'start' });
        } else {
            alert('❌ ' + (data.message || 'Failed to generate template'));
        }
    } catch (error) {
        console.error('Error:', error);
        alert('❌ Error generating template: ' + error.message);
    } finally {
        button.innerHTML = originalText;
        button.disabled = false;
    }
}
</script>
</x-layouts.admin>

