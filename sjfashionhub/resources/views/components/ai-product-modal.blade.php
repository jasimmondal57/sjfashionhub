<!-- AI Product Details Modal -->
<div id="ai-modal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">🤖 AI Product Details Generator</h3>
                <button onclick="closeAIModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="mt-4">
                <p class="text-sm text-gray-600 mb-4">
                    Provide basic product information and our AI will automatically generate comprehensive, SEO-optimized details including key features, target keywords, descriptions, and all Google Merchant Center fields for top ranking.
                </p>

                <form id="ai-form" class="space-y-4">
                    @csrf
                    
                    <!-- Basic Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="ai_basic_name" class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                            <input type="text" id="ai_basic_name" name="basic_name" required placeholder="e.g., Cotton T-Shirt, Leather Jacket"
                                   value="{{ isset($existingProduct) ? $existingProduct->name : '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="ai_brand" class="block text-sm font-medium text-gray-700 mb-2">Brand *</label>
                            <input type="text" id="ai_brand" name="brand" required placeholder="e.g., Nike, Adidas, Zara"
                                   value="{{ isset($existingProduct) ? $existingProduct->brand : '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="ai_category_id" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                            <select id="ai_category_id" name="category_id" required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}"
                                            {{ isset($existingProduct) && $existingProduct->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="ai_mrp" class="block text-sm font-medium text-gray-700 mb-2">MRP (₹) *</label>
                            <input type="number" id="ai_mrp" name="mrp" required min="0" step="0.01" placeholder="1999"
                                   value="{{ isset($existingProduct) ? $existingProduct->mrp : '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="ai_sale_price" class="block text-sm font-medium text-gray-700 mb-2">Sale Price (₹)</label>
                            <input type="number" id="ai_sale_price" name="sale_price" min="0" step="0.01" placeholder="1599"
                                   value="{{ isset($existingProduct) ? $existingProduct->price : '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <!-- Dynamic Variant Fields -->
                        @if(isset($variantTypes) && $variantTypes->count() > 0)
                            @foreach($variantTypes as $variantType)
                                <div>
                                    <label for="ai_{{ $variantType->slug }}" class="block text-sm font-medium text-gray-700 mb-2">
                                        {{ $variantType->name }}
                                        @if($variantType->slug === 'size' || $variantType->slug === 'color')
                                            <span class="text-red-500">*</span>
                                        @endif
                                        @if($variantType->slug === 'size' || $variantType->slug === 'color')
                                            <span class="text-xs text-gray-500">(Multiple selection allowed)</span>
                                        @endif
                                    </label>

                                    @if($variantType->slug === 'size' || $variantType->slug === 'color')
                                        <!-- Multiple selection for Size and Color -->
                                        <div class="grid grid-cols-3 gap-2 max-h-32 overflow-y-auto border border-gray-300 rounded-md p-2">
                                            @foreach($variantType->activeOptions as $option)
                                                <label class="flex items-center space-x-2 text-sm">
                                                    <input type="checkbox" name="{{ $variantType->slug }}[]" value="{{ $option->value }}"
                                                           {{ isset($existingProduct) && in_array($option->value, explode(',', $existingProduct->{$variantType->slug} ?? '')) ? 'checked' : '' }}
                                                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                                    @if($variantType->slug === 'color' && $option->color_code)
                                                        <span class="w-4 h-4 rounded-full border border-gray-300" style="background-color: {{ $option->color_code }}"></span>
                                                    @endif
                                                    <span>{{ $option->name }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @else
                                        <!-- Single selection for other variants -->
                                        <select id="ai_{{ $variantType->slug }}" name="{{ $variantType->slug }}"
                                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            <option value="">Select {{ $variantType->name }}</option>
                                            @foreach($variantType->activeOptions as $option)
                                                <option value="{{ $option->value }}"
                                                        {{ isset($existingProduct) && $existingProduct->{$variantType->slug} == $option->value ? 'selected' : '' }}>
                                                    {{ $option->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <!-- Fallback for when variant types are not loaded -->
                            <div>
                                <label for="ai_color" class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                                <input type="text" id="ai_color" name="color" placeholder="e.g., Red, Blue, Black"
                                       value="{{ isset($existingProduct) ? $existingProduct->color : '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="ai_size" class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                                <input type="text" id="ai_size" name="size" placeholder="e.g., S, M, L, XL"
                                       value="{{ isset($existingProduct) ? $existingProduct->size : '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>

                            <div>
                                <label for="ai_material" class="block text-sm font-medium text-gray-700 mb-2">Material</label>
                                <input type="text" id="ai_material" name="material" placeholder="e.g., Cotton, Polyester, Silk"
                                       value="{{ isset($existingProduct) ? $existingProduct->material : '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            </div>
                        @endif

                        <div>
                            <label for="ai_pattern" class="block text-sm font-medium text-gray-700 mb-2">Pattern</label>
                            <input type="text" id="ai_pattern" name="pattern" placeholder="e.g., Solid, Striped, Floral"
                                   value="{{ isset($existingProduct) ? $existingProduct->pattern : '' }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div>
                            <label for="ai_gender" class="block text-sm font-medium text-gray-700 mb-2">Gender</label>
                            <select id="ai_gender" name="gender"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Gender</option>
                                <option value="male" {{ isset($existingProduct) && $existingProduct->gender == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ isset($existingProduct) && $existingProduct->gender == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="unisex" {{ isset($existingProduct) && $existingProduct->gender == 'unisex' ? 'selected' : '' }}>Unisex</option>
                            </select>
                        </div>

                        <div>
                            <label for="ai_age_group" class="block text-sm font-medium text-gray-700 mb-2">Age Group</label>
                            <select id="ai_age_group" name="age_group"
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Select Age Group</option>
                                <option value="adult" {{ isset($existingProduct) && $existingProduct->age_group == 'adult' ? 'selected' : '' }}>Adult</option>
                                <option value="kids" {{ isset($existingProduct) && $existingProduct->age_group == 'kids' ? 'selected' : '' }}>Kids</option>
                                <option value="toddler" {{ isset($existingProduct) && $existingProduct->age_group == 'toddler' ? 'selected' : '' }}>Toddler</option>
                                <option value="infant" {{ isset($existingProduct) && $existingProduct->age_group == 'infant' ? 'selected' : '' }}>Infant</option>
                                <option value="newborn" {{ isset($existingProduct) && $existingProduct->age_group == 'newborn' ? 'selected' : '' }}>Newborn</option>
                            </select>
                        </div>
                    </div>

                    <!-- AI Information Notice -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <h4 class="text-sm font-semibold text-blue-800 mb-1">🤖 AI Auto-Generation</h4>
                                <p class="text-sm text-blue-700">
                                    Our AI will automatically generate:
                                </p>
                                <ul class="text-sm text-blue-700 mt-2 space-y-1">
                                    <li>• <strong>Key Features</strong> - Based on material, category, and attributes</li>
                                    <li>• <strong>SEO Keywords</strong> - Optimized for Google ranking and Indian market</li>
                                    <li>• <strong>Product Descriptions</strong> - Comprehensive and engaging content</li>
                                    <li>• <strong>Google Merchant Center Data</strong> - Complete compliance fields</li>
                                    <li>• <strong>Meta Pixel Integration</strong> - Facebook/Instagram ready</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex items-center justify-between pt-4 border-t">
                        <div class="text-sm text-gray-500">
                            <span class="inline-flex items-center">
                                <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                AI will auto-generate all details, features & keywords
                            </span>
                        </div>
                        
                        <div class="space-x-3">
                            <button type="button" onclick="closeAIModal()" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400">
                                Cancel
                            </button>
                            <button type="submit" id="generate-btn" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                <span>Generate AI Details</span>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="ai-loading" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center hidden z-60">
    <div class="bg-white rounded-lg p-6 max-w-sm mx-auto">
        <div class="flex items-center space-x-3">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600"></div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Generating AI Details...</h3>
                <p class="text-sm text-gray-600">Creating SEO-optimized product information</p>
            </div>
        </div>
    </div>
</div>

<script>
function openAIModal() {
    document.getElementById('ai-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeAIModal() {
    document.getElementById('ai-modal').classList.add('hidden');
    document.body.style.overflow = 'auto';
    document.getElementById('ai-form').reset();
}

function showAILoading() {
    document.getElementById('ai-loading').classList.remove('hidden');
}

function hideAILoading() {
    document.getElementById('ai-loading').classList.add('hidden');
}

// Handle AI form submission
document.getElementById('ai-form').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    showAILoading();
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch('{{ route("admin.ai.generate-details") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Fill all form fields with AI-generated data
            fillFormWithAIData(result.data);
            closeAIModal();

            // Show success message
            showNotification('AI details generated successfully! Review and edit as needed.', 'success');
        } else {
            console.error('AI Generation Error:', result);
            let errorMessage = 'Failed to generate AI details. ';
            if (result.message) {
                errorMessage += result.message;
            }
            if (result.errors) {
                errorMessage += ' Errors: ' + Object.values(result.errors).flat().join(', ');
            }
            showNotification(errorMessage, 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showNotification('An error occurred while generating AI details.', 'error');
    } finally {
        hideAILoading();
    }
});

function fillFormWithAIData(data) {
    // Helper function to safely set form field values
    function setFieldValue(fieldId, value) {
        const field = document.getElementById(fieldId);
        if (field && value !== undefined && value !== null) {
            field.value = value;
        }
    }

    function setCheckboxValue(fieldId, value) {
        const field = document.getElementById(fieldId);
        if (field && value !== undefined && value !== null) {
            field.checked = value;
        }
    }

    // Basic Information
    setFieldValue('name', data.name);
    setFieldValue('brand', data.brand);
    setFieldValue('description', data.description);
    setFieldValue('long_description', data.long_description);

    // Category (from AI form data)
    if (data.category_id) {
        setFieldValue('category_id', data.category_id);
    }

    // Handle variant fields with special logic for arrays
    function setVariantValue(fieldName, value) {
        const field = document.getElementById(fieldName);
        if (field) {
            if (field.tagName === 'SELECT') {
                // Single select dropdown
                field.value = value || '';
            } else {
                // For main form, set the first value if it's an array
                if (Array.isArray(value)) {
                    field.value = value[0] || '';
                } else {
                    field.value = value || '';
                }
            }
        }
    }

    // Pricing
    setFieldValue('price', data.price);
    setFieldValue('sale_price', data.sale_price);
    setFieldValue('compare_at_price', data.compare_at_price);

    // Google Merchant Center
    setFieldValue('google_product_category', data.google_product_category);
    setFieldValue('condition', data.condition);
    setFieldValue('age_group', data.age_group);
    setFieldValue('gender', data.gender);

    // Handle variant fields specially
    setVariantValue('size', data.size);
    setVariantValue('color', data.color);
    setVariantValue('material', data.material);
    setVariantValue('pattern', data.pattern);

    // SEO
    setFieldValue('seo_title', data.seo_title);
    setFieldValue('seo_description', data.seo_description);
    setFieldValue('seo_keywords', data.seo_keywords);
    if (data.tags && Array.isArray(data.tags)) {
        setFieldValue('tags', data.tags.join(', '));
    }

    // Shipping & Attributes
    setFieldValue('weight', data.weight);
    setFieldValue('dimensions', data.dimensions);
    setFieldValue('shipping_weight', data.shipping_weight);
    setFieldValue('shipping_cost', data.shipping_cost);

    // Meta Pixel
    setFieldValue('facebook_product_id', data.facebook_product_id);
    setFieldValue('cost_of_goods', data.cost_of_goods);

    // Quality & Trust
    setCheckboxValue('has_warranty', data.has_warranty);
    setFieldValue('warranty_period', data.warranty_period);
    setCheckboxValue('has_return_policy', data.has_return_policy);
    setFieldValue('return_days', data.return_days);

    // Inventory
    setFieldValue('low_stock_threshold', data.low_stock_threshold);
    setCheckboxValue('track_quantity', data.track_quantity);
    setCheckboxValue('price_includes_tax', data.price_includes_tax);
    setFieldValue('tax_rate', data.tax_rate);

    // Additional fields that might be generated
    setFieldValue('key_features', data.key_features);
    setFieldValue('product_type', data.product_type);
    setFieldValue('availability', data.availability);

    console.log('AI data filled successfully:', data);
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-md shadow-lg z-50 ${type === 'success' ? 'bg-green-500' : 'bg-red-500'} text-white`;
    notification.innerHTML = `
        <div class="flex items-center">
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Close modal when clicking outside
document.getElementById('ai-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeAIModal();
    }
});
</script>
