<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class GeminiAIController extends Controller
{
    private $geminiApiKey;
    private $geminiApiUrl;

    public function __construct()
    {
        // You'll need to add your Gemini API key to .env file
        $this->geminiApiKey = env('GEMINI_API_KEY');
        $this->geminiApiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
    }

    public function generateDetails(Request $request)
    {
        try {
            $validated = $request->validate([
                'basic_name' => 'required|string|max:255',
                'brand' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'size' => 'nullable|array',
                'size.*' => 'string|max:50',
                'color' => 'nullable|array',
                'color.*' => 'string|max:50',
                'material' => 'nullable|string|max:100',
                'pattern' => 'nullable|string|max:100',
                'gender' => 'nullable|in:male,female,unisex',
                'age_group' => 'nullable|in:adult,kids,toddler,infant,newborn',
                'mrp' => 'required|numeric|min:0',
                'sale_price' => 'nullable|numeric|min:0',
            ]);

            // Convert arrays to strings for processing
            if (isset($validated['size']) && is_array($validated['size'])) {
                $validated['size'] = implode(', ', $validated['size']);
            }
            if (isset($validated['color']) && is_array($validated['color'])) {
                $validated['color'] = implode(', ', $validated['color']);
            }

            // Get category information
            $category = Category::find($validated['category_id']);
            
            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            // Check if Gemini API key is configured
            if (!$this->geminiApiKey) {
                // Fallback to rule-based generation if no API key
                return $this->generateWithRules($validated, $category);
            }
            
            // Generate AI-powered product details using Gemini
            $aiDetails = $this->generateWithGemini($validated, $category);
            
            return response()->json([
                'success' => true,
                'data' => $aiDetails
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateWithGemini($input, $category)
    {
        $prompt = $this->buildGeminiPrompt($input, $category);
        
        try {
            $response = Http::withOptions([
                'verify' => false, // Disable SSL verification for localhost
                'timeout' => 30,
            ])->withHeaders([
                'Content-Type' => 'application/json',
            ])->post($this->geminiApiUrl . '?key=' . $this->geminiApiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $result = $response->json();
                $generatedText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
                
                // Parse the JSON response from Gemini
                $aiData = json_decode($generatedText, true);
                
                if ($aiData) {
                    // Add calculated fields
                    $aiData = array_merge($aiData, $this->generateCalculatedFields($input, $category));
                    return $aiData;
                }
            }
        } catch (\Exception $e) {
            // Log error and fallback to rule-based generation
            \Log::error('Gemini AI Error: ' . $e->getMessage());
        }

        // Fallback to rule-based generation
        return $this->generateWithRules($input, $category);
    }

    private function buildGeminiPrompt($input, $category)
    {
        $basicName = $input['basic_name'];
        $brand = $input['brand'];
        $size = $input['size'] ?? '';
        $color = $input['color'] ?? '';
        $material = $input['material'] ?? '';
        $pattern = $input['pattern'] ?? '';
        $gender = $input['gender'] ?? '';
        $ageGroup = $input['age_group'] ?? '';
        $mrp = $input['mrp'];
        $salePrice = $input['sale_price'] ?? $mrp;

        return "You are an expert e-commerce product content writer and SEO specialist. Generate comprehensive product details for an Indian fashion e-commerce website.

Product Information:
- Product Name: {$basicName}
- Brand: {$brand}
- Category: {$category->name}
- Size: {$size}
- Color: {$color}
- Material: {$material}
- Pattern: {$pattern}
- Gender: {$gender}
- Age Group: {$ageGroup}
- MRP: ₹{$mrp}
- Sale Price: ₹{$salePrice}

Generate a JSON response with the following structure (return ONLY valid JSON, no additional text):

{
    \"name\": \"Optimized product title (Brand + Product + Features + Color/Size, max 70 chars)\",
    \"description\": \"Short description for product listing (150-200 chars)\",
    \"long_description\": \"Detailed product description with features, benefits, care instructions (500-1000 words)\",
    \"key_features\": \"Comma-separated list of 6-8 key product features\",
    \"seo_title\": \"SEO optimized title (max 60 chars)\",
    \"seo_description\": \"SEO meta description (max 160 chars)\",
    \"seo_keywords\": \"Comma-separated SEO keywords (25-30 keywords)\",
    \"tags\": [\"tag1\", \"tag2\", \"tag3\", \"tag4\", \"tag5\"],
    \"google_product_category\": \"Google Shopping category (e.g., Apparel & Accessories > Clothing)\",
    \"product_type\": \"Custom product type\",
    \"condition\": \"new\",
    \"availability\": \"in_stock\",
    \"age_group\": \"{$ageGroup}\",
    \"gender\": \"{$gender}\",
    \"size\": \"{$size}\",
    \"color\": \"{$color}\",
    \"material\": \"{$material}\",
    \"pattern\": \"{$pattern}\"
}

Requirements:
1. Content must be SEO-optimized for Google ranking
2. Include Indian market-specific keywords
3. Professional, engaging, and sales-focused content
4. Highlight quality, comfort, and style
5. Include care instructions and warranty info
6. Target keywords should include commercial intent
7. Descriptions should be compelling and detailed
8. All content should be original and unique";
    }

    private function generateCalculatedFields($input, $category)
    {
        $mrp = $input['mrp'];
        $salePrice = $input['sale_price'] ?? $mrp;
        
        // Estimate weight based on category
        $weight = 0.5; // Default 500g
        if (stripos($category->name, 'shoe') !== false) {
            $weight = 1.2;
        } elseif (stripos($category->name, 'bag') !== false) {
            $weight = 0.8;
        } elseif (stripos($category->name, 'jewelry') !== false) {
            $weight = 0.1;
        }
        
        return [
            'price' => $mrp,
            'sale_price' => $salePrice != $mrp ? $salePrice : null,
            'compare_at_price' => $salePrice != $mrp ? $mrp : null,
            'weight' => $weight,
            'dimensions' => '30 x 25 x 5 cm',
            'shipping_weight' => $weight + 0.2,
            'shipping_cost' => $salePrice < 500 ? 50 : 0,
            'has_warranty' => $salePrice > 1000,
            'warranty_period' => $salePrice > 1000 ? '1 year' : null,
            'has_return_policy' => true,
            'return_days' => 30,
            'low_stock_threshold' => 5,
            'track_quantity' => true,
            'stock_status' => 'in_stock',
            'price_includes_tax' => true,
            'tax_rate' => 18.0,
            'facebook_product_id' => Str::slug($input['basic_name']) . '-' . time(),
            'cost_of_goods' => round($salePrice * 0.6, 2),
            'identifier_exists' => true,
        ];
    }

    private function generateWithRules($input, $category)
    {
        // Fallback rule-based generation (simplified version)
        $basicName = $input['basic_name'];
        $brand = $input['brand'];
        $color = $input['color'] ?? '';
        $size = $input['size'] ?? '';
        $material = $input['material'] ?? '';
        
        $optimizedName = trim("{$brand} {$basicName} {$color} {$size}");
        if (strlen($optimizedName) > 70) {
            $optimizedName = substr($optimizedName, 0, 67) . '...';
        }
        
        $description = "Premium {$basicName} from {$brand}. " . 
                      ($material ? "Made with high-quality {$material}. " : '') .
                      ($color ? "Available in beautiful {$color} color. " : '') .
                      "Perfect for {$category->name} enthusiasts.";
        
        $longDescription = "**{$optimizedName}** - The Perfect Choice for Style and Comfort\n\n" .
                          "Discover the exceptional quality of {$brand}'s latest {$category->name} collection. " .
                          "This {$basicName} is designed to meet the highest standards of fashion and functionality.\n\n" .
                          "**Key Features:**\n" .
                          ($material ? "• Premium {$material} construction\n" : '') .
                          ($color ? "• Beautiful {$color} color\n" : '') .
                          "• High-quality craftsmanship\n" .
                          "• Comfortable fit\n" .
                          "• Easy care and maintenance\n\n" .
                          "Order now and experience the perfect blend of style, comfort, and quality!";
        
        $keyFeatures = "Premium quality, Comfortable fit, Stylish design, Durable construction, Easy care, Perfect finishing";
        
        $seoKeywords = strtolower("{$basicName}, {$brand}, {$category->name}, buy {$category->name} online, premium {$category->name}, best {$category->name}, {$category->name} india");
        
        return array_merge([
            'name' => $optimizedName,
            'description' => $description,
            'long_description' => $longDescription,
            'key_features' => $keyFeatures,
            'seo_title' => substr("{$optimizedName} | {$brand}", 0, 60),
            'seo_description' => substr($description, 0, 160),
            'seo_keywords' => $seoKeywords,
            'tags' => [$brand, $category->name, 'premium', 'quality', 'fashion'],
            'google_product_category' => 'Apparel & Accessories',
            'product_type' => $category->name,
            'condition' => 'new',
            'availability' => 'in_stock',
            'age_group' => $input['age_group'] ?? 'adult',
            'gender' => $input['gender'] ?? 'unisex',
            'size' => $input['size'] ?? '',
            'color' => $input['color'] ?? '',
            'material' => $input['material'] ?? '',
            'pattern' => $input['pattern'] ?? '',
        ], $this->generateCalculatedFields($input, $category));
    }
}
