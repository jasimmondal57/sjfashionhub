{{-- Variant Management System --}}
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6" id="variant-manager">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-lg font-semibold text-gray-900">Product Variants</h3>
            <p class="text-sm text-gray-600 mt-1">Create and manage product variations (size, color, material, etc.)</p>
        </div>
        <button type="button" onclick="toggleVariantGenerator()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Generate Variants
        </button>
    </div>

    {{-- Variant Generator (Hidden by default) --}}
    <div id="variant-generator" class="hidden mb-6 p-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border-2 border-blue-200">
        <h4 class="text-md font-semibold text-gray-900 mb-4">Variant Generator</h4>
        <p class="text-sm text-gray-600 mb-4">Select up to 3 options to automatically generate all variant combinations</p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            {{-- Option 1 --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Option 1</label>
                <select id="option1_name" onchange="updateVariantValueInput(1)" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-2">
                    <option value="">Select option type...</option>
                    <option value="Size">Size</option>
                    <option value="Color">Color</option>
                    <option value="Material">Material</option>
                    <option value="Pattern">Pattern</option>
                    <option value="Style">Style</option>
                    <option value="Length">Length</option>
                </select>
                <div id="option1_values_container">
                    <input type="text" id="option1_values" placeholder="Enter values separated by commas (e.g., S, M, L, XL)"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
            </div>

            {{-- Option 2 --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Option 2 (Optional)</label>
                <select id="option2_name" onchange="updateVariantValueInput(2)" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-2">
                    <option value="">Select option type...</option>
                    <option value="Size">Size</option>
                    <option value="Color">Color</option>
                    <option value="Material">Material</option>
                    <option value="Pattern">Pattern</option>
                    <option value="Style">Style</option>
                    <option value="Length">Length</option>
                </select>
                <div id="option2_values_container">
                    <input type="text" id="option2_values" placeholder="Enter values separated by commas"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
            </div>

            {{-- Option 3 --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Option 3 (Optional)</label>
                <select id="option3_name" onchange="updateVariantValueInput(3)" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 mb-2">
                    <option value="">Select option type...</option>
                    <option value="Size">Size</option>
                    <option value="Color">Color</option>
                    <option value="Material">Material</option>
                    <option value="Pattern">Pattern</option>
                    <option value="Style">Style</option>
                    <option value="Length">Length</option>
                </select>
                <div id="option3_values_container">
                    <input type="text" id="option3_values" placeholder="Enter values separated by commas"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
                </div>
            </div>
        </div>

        <div class="flex items-center justify-between">
            <div id="variant-preview" class="text-sm text-gray-600">
                <span class="font-medium">Variants to be created:</span> <span id="variant-count" class="text-blue-600 font-bold">0</span>
            </div>
            <div class="flex gap-2">
                <button type="button" onclick="previewVariants()" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Preview
                </button>
                <button type="button" onclick="generateVariants()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Generate Variants
                </button>
            </div>
        </div>
    </div>

    {{-- Variants Table --}}
    <div id="variants-table-container">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200" id="variants-table">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <input type="checkbox" id="select-all-variants" onclick="toggleAllVariants(this)" class="rounded border-gray-300">
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Variant</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">SKU</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price (₹)</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200" id="variants-tbody">
                    <tr id="no-variants-row">
                        <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            <p class="text-sm font-medium">No variants created yet</p>
                            <p class="text-xs text-gray-400 mt-1">Click "Generate Variants" to create product variations</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Bulk Actions --}}
        <div id="bulk-actions" class="hidden mt-4 p-4 bg-gray-50 rounded-lg border border-gray-200">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-700">
                    <span id="selected-count" class="font-semibold">0</span> variants selected
                </span>
                <div class="flex gap-2">
                    <button type="button" onclick="bulkUpdatePrice()" class="px-3 py-1.5 text-sm bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50">
                        Update Price
                    </button>
                    <button type="button" onclick="bulkUpdateStock()" class="px-3 py-1.5 text-sm bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50">
                        Update Stock
                    </button>
                    <button type="button" onclick="bulkToggleStatus()" class="px-3 py-1.5 text-sm bg-white border border-gray-300 text-gray-700 rounded hover:bg-gray-50">
                        Toggle Status
                    </button>
                    <button type="button" onclick="bulkDeleteVariants()" class="px-3 py-1.5 text-sm bg-red-600 text-white rounded hover:bg-red-700">
                        Delete Selected
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Hidden input to store variants data --}}
    <input type="hidden" name="variants_data" id="variants_data" value="">
</div>

<script>
    // Global variants array
    let variants = [];
    let variantIdCounter = 1;

    // Predefined options for Size and Color
    const predefinedOptions = {
        'Size': ['26', '28', '30', '32', '34', '36', '38', '40', '42', '44', 'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'Free Size'],
        'Color': ['Black', 'White', 'Red', 'Blue', 'Green', 'Yellow', 'Pink', 'Purple', 'Orange', 'Brown', 'Grey', 'Navy', 'Maroon', 'Beige', 'Cream', 'Gold', 'Silver', 'Multi Color']
    };

    // Update variant value input based on selected option type
    function updateVariantValueInput(optionNumber) {
        const optionName = document.getElementById(`option${optionNumber}_name`).value;
        const container = document.getElementById(`option${optionNumber}_values_container`);

        if (optionName === 'Size' || optionName === 'Color') {
            // Create multi-select dropdown
            const options = predefinedOptions[optionName];
            let html = `
                <select id="option${optionNumber}_values" multiple
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                        style="min-height: 120px;">
            `;
            options.forEach(option => {
                html += `<option value="${option}">${option}</option>`;
            });
            html += `</select>
                <p class="text-xs text-gray-500 mt-1">Hold Ctrl/Cmd to select multiple options</p>
            `;
            container.innerHTML = html;
        } else {
            // Show text input for other types
            container.innerHTML = `
                <input type="text" id="option${optionNumber}_values"
                       placeholder="Enter values separated by commas"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm">
            `;
        }
    }

    // Toggle variant generator
    function toggleVariantGenerator() {
        const generator = document.getElementById('variant-generator');
        generator.classList.toggle('hidden');
    }

    // Preview how many variants will be created
    function previewVariants() {
        const option1Values = getOptionValues('option1_values');
        const option2Values = getOptionValues('option2_values');
        const option3Values = getOptionValues('option3_values');

        let count = 1;
        if (option1Values.length > 0) count *= option1Values.length;
        if (option2Values.length > 0) count *= option2Values.length;
        if (option3Values.length > 0) count *= option3Values.length;

        document.getElementById('variant-count').textContent = option1Values.length > 0 ? count : 0;
    }

    // Get option values from input (handles both text input and multi-select)
    function getOptionValues(inputId) {
        const input = document.getElementById(inputId);
        if (!input) return [];

        // Check if it's a multi-select
        if (input.tagName === 'SELECT' && input.multiple) {
            const selectedOptions = Array.from(input.selectedOptions);
            return selectedOptions.map(option => option.value);
        }

        // Handle text input
        if (!input.value.trim()) return [];
        return input.value.split(',').map(v => v.trim()).filter(v => v);
    }

    // Generate variants
    function generateVariants() {
        const option1Name = document.getElementById('option1_name').value;
        const option1Values = getOptionValues('option1_values');
        const option2Name = document.getElementById('option2_name').value;
        const option2Values = getOptionValues('option2_values');
        const option3Name = document.getElementById('option3_name').value;
        const option3Values = getOptionValues('option3_values');

        if (!option1Name || option1Values.length === 0) {
            alert('Please select at least Option 1 with values');
            return;
        }

        // Generate all combinations
        const combinations = [];
        
        if (option1Values.length > 0 && option2Values.length === 0 && option3Values.length === 0) {
            // Only option 1
            option1Values.forEach(v1 => {
                combinations.push({ option1: v1, option2: null, option3: null });
            });
        } else if (option1Values.length > 0 && option2Values.length > 0 && option3Values.length === 0) {
            // Options 1 and 2
            option1Values.forEach(v1 => {
                option2Values.forEach(v2 => {
                    combinations.push({ option1: v1, option2: v2, option3: null });
                });
            });
        } else if (option1Values.length > 0 && option2Values.length > 0 && option3Values.length > 0) {
            // All 3 options
            option1Values.forEach(v1 => {
                option2Values.forEach(v2 => {
                    option3Values.forEach(v3 => {
                        combinations.push({ option1: v1, option2: v2, option3: v3 });
                    });
                });
            });
        }

        // Create variant objects
        combinations.forEach(combo => {
            const variant = {
                id: variantIdCounter++,
                option1_name: option1Name,
                option1_value: combo.option1,
                option2_name: option2Name || null,
                option2_value: combo.option2,
                option3_name: option3Name || null,
                option3_value: combo.option3,
                sku: '',
                price: '',
                stock_quantity: 0,
                image_url: '',
                is_active: true
            };
            variants.push(variant);
        });

        renderVariantsTable();
        toggleVariantGenerator();
        
        alert(`${combinations.length} variants created successfully!`);
    }

    // Render variants table
    function renderVariantsTable() {
        const tbody = document.getElementById('variants-tbody');
        const noVariantsRow = document.getElementById('no-variants-row');

        if (variants.length === 0) {
            noVariantsRow.classList.remove('hidden');
            return;
        }

        noVariantsRow.classList.add('hidden');
        tbody.innerHTML = '';

        variants.forEach((variant, index) => {
            const variantTitle = [variant.option1_value, variant.option2_value, variant.option3_value]
                .filter(v => v).join(' / ');

            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50';
            row.innerHTML = `
                <td class="px-4 py-3">
                    <input type="checkbox" class="variant-checkbox rounded border-gray-300" data-index="${index}" onchange="updateBulkActions()">
                </td>
                <td class="px-4 py-3 text-sm text-gray-900">${index + 1}</td>
                <td class="px-4 py-3 text-sm font-medium text-gray-900">${variantTitle}</td>
                <td class="px-4 py-3">
                    <input type="text" value="${variant.sku}" onchange="updateVariant(${index}, 'sku', this.value)"
                           class="w-full px-2 py-1 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-blue-500"
                           placeholder="SKU-${index + 1}">
                </td>
                <td class="px-4 py-3">
                    <input type="number" value="${variant.price}" onchange="updateVariant(${index}, 'price', this.value)"
                           class="w-24 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-blue-500"
                           placeholder="0.00" step="0.01">
                </td>
                <td class="px-4 py-3">
                    <input type="number" value="${variant.stock_quantity}" onchange="updateVariant(${index}, 'stock_quantity', this.value)"
                           class="w-20 px-2 py-1 text-sm border border-gray-300 rounded focus:ring-1 focus:ring-blue-500"
                           placeholder="0">
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        ${variant.image_url ? `
                            <img src="${variant.image_url}" alt="Variant" class="w-10 h-10 object-cover rounded border border-gray-300" id="variant-img-${index}">
                            <button type="button" onclick="removeVariantImage(${index})" class="text-red-600 hover:text-red-800 text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        ` : `
                            <label class="cursor-pointer inline-flex items-center px-2 py-1 bg-blue-50 text-blue-600 rounded hover:bg-blue-100 text-xs">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                Upload
                                <input type="file" accept="image/*" onchange="handleVariantImageUpload(${index}, this)" class="hidden">
                            </label>
                        `}
                    </div>
                </td>
                <td class="px-4 py-3">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" ${variant.is_active ? 'checked' : ''} onchange="updateVariant(${index}, 'is_active', this.checked)" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                    </label>
                </td>
                <td class="px-4 py-3">
                    <button type="button" onclick="deleteVariant(${index})" class="text-red-600 hover:text-red-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </button>
                </td>
            `;
            tbody.appendChild(row);
        });

        // Update hidden input
        document.getElementById('variants_data').value = JSON.stringify(variants);
    }

    // Update variant field
    function updateVariant(index, field, value) {
        variants[index][field] = value;
        document.getElementById('variants_data').value = JSON.stringify(variants);
    }

    // Delete variant
    function deleteVariant(index) {
        if (confirm('Are you sure you want to delete this variant?')) {
            variants.splice(index, 1);
            renderVariantsTable();
        }
    }

    // Handle variant image upload
    function handleVariantImageUpload(index, input) {
        const file = input.files[0];
        if (!file) return;

        // Validate file type
        if (!file.type.startsWith('image/')) {
            alert('Please select an image file');
            return;
        }

        // Validate file size (max 5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Image size should be less than 5MB');
            return;
        }

        // Read file and convert to base64
        const reader = new FileReader();
        reader.onload = function(e) {
            // Update variant with image data
            variants[index].image_url = e.target.result;
            variants[index].image_file = file;
            renderVariantsTable();
        };
        reader.readAsDataURL(file);
    }

    // Remove variant image
    function removeVariantImage(index) {
        if (confirm('Remove this image?')) {
            variants[index].image_url = '';
            variants[index].image_file = null;
            renderVariantsTable();
        }
    }

    // Toggle all variants
    function toggleAllVariants(checkbox) {
        const checkboxes = document.querySelectorAll('.variant-checkbox');
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
        updateBulkActions();
    }

    // Update bulk actions visibility
    function updateBulkActions() {
        const checkboxes = document.querySelectorAll('.variant-checkbox:checked');
        const bulkActions = document.getElementById('bulk-actions');
        const selectedCount = document.getElementById('selected-count');
        
        if (checkboxes.length > 0) {
            bulkActions.classList.remove('hidden');
            selectedCount.textContent = checkboxes.length;
        } else {
            bulkActions.classList.add('hidden');
        }
    }

    // Bulk update price
    function bulkUpdatePrice() {
        const price = prompt('Enter price for selected variants:');
        if (price !== null && price !== '') {
            const checkboxes = document.querySelectorAll('.variant-checkbox:checked');
            checkboxes.forEach(cb => {
                const index = parseInt(cb.dataset.index);
                variants[index].price = parseFloat(price);
            });
            renderVariantsTable();
        }
    }

    // Bulk update stock
    function bulkUpdateStock() {
        const stock = prompt('Enter stock quantity for selected variants:');
        if (stock !== null && stock !== '') {
            const checkboxes = document.querySelectorAll('.variant-checkbox:checked');
            checkboxes.forEach(cb => {
                const index = parseInt(cb.dataset.index);
                variants[index].stock_quantity = parseInt(stock);
            });
            renderVariantsTable();
        }
    }

    // Bulk toggle status
    function bulkToggleStatus() {
        const checkboxes = document.querySelectorAll('.variant-checkbox:checked');
        checkboxes.forEach(cb => {
            const index = parseInt(cb.dataset.index);
            variants[index].is_active = !variants[index].is_active;
        });
        renderVariantsTable();
    }

    // Bulk delete variants
    function bulkDeleteVariants() {
        if (confirm('Are you sure you want to delete selected variants?')) {
            const checkboxes = document.querySelectorAll('.variant-checkbox:checked');
            const indicesToDelete = Array.from(checkboxes).map(cb => parseInt(cb.dataset.index)).sort((a, b) => b - a);
            indicesToDelete.forEach(index => variants.splice(index, 1));
            renderVariantsTable();
            updateBulkActions();
        }
    }

    // Auto-preview on input change
    document.addEventListener('DOMContentLoaded', function() {
        ['option1_values', 'option2_values', 'option3_values'].forEach(id => {
            const input = document.getElementById(id);
            if (input) {
                input.addEventListener('input', previewVariants);
            }
        });
    });
</script>

