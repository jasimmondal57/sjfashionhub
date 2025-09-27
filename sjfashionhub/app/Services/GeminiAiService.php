<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Exception;

class GeminiAiService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent';
    }

    /**
     * Generate SEO blog post content based on product data
     */
    public function generateBlogPost(Product $product, array $options = [])
    {
        try {
            $prompt = $this->buildBlogPrompt($product, $options);
            
            $response = Http::timeout(60)->post($this->baseUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ],
                'generationConfig' => [
                    'temperature' => 0.7,
                    'topK' => 40,
                    'topP' => 0.95,
                    'maxOutputTokens' => 8192,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

                // Log successful generation (without full content for performance)
                Log::info('Gemini AI blog generated successfully', [
                    'product_id' => $product->id,
                    'content_length' => strlen($content)
                ]);

                return $this->parseBlogContent($content, $product);
            }

            throw new Exception('Gemini API request failed: ' . $response->body());

        } catch (Exception $e) {
            Log::error('Gemini AI blog generation failed', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
            
            throw $e;
        }
    }

    /**
     * Build the prompt for blog post generation
     */
    protected function buildBlogPrompt(Product $product, array $options = [])
    {
        $blogType = $options['blog_type'] ?? 'product_review';
        $targetKeywords = $options['target_keywords'] ?? [];
        $tone = $options['tone'] ?? 'professional';
        $wordCount = $options['word_count'] ?? 1500;

        $basePrompt = "Create a comprehensive, SEO-optimized blog post about the following product:\n\n";
        $basePrompt .= "Product Name: {$product->name}\n";
        $basePrompt .= "Category: {$product->category->name}\n";
        $basePrompt .= "Price: ₹{$product->price}\n";
        $basePrompt .= "Description: {$product->description}\n";
        
        if ($product->features) {
            $basePrompt .= "Features: " . implode(', ', $product->features) . "\n";
        }

        $basePrompt .= "\nBlog Requirements:\n";
        $basePrompt .= "- Write approximately {$wordCount} words\n";
        $basePrompt .= "- Use a {$tone} tone\n";
        $basePrompt .= "- Focus on SEO optimization\n";
        $basePrompt .= "- Include relevant headings (H2, H3)\n";
        $basePrompt .= "- Make it engaging and informative\n";
        
        if (!empty($targetKeywords)) {
            $basePrompt .= "- Target keywords: " . implode(', ', $targetKeywords) . "\n";
        }

        switch ($blogType) {
            case 'product_review':
                $basePrompt .= "\nWrite a detailed product review that covers:\n";
                $basePrompt .= "- Product overview and first impressions\n";
                $basePrompt .= "- Key features and benefits\n";
                $basePrompt .= "- Pros and cons\n";
                $basePrompt .= "- Who should buy this product\n";
                $basePrompt .= "- Comparison with similar products\n";
                $basePrompt .= "- Final verdict and recommendation\n";
                break;
                
            case 'buying_guide':
                $basePrompt .= "\nWrite a comprehensive buying guide that includes:\n";
                $basePrompt .= "- What to look for when buying this type of product\n";
                $basePrompt .= "- Key factors to consider\n";
                $basePrompt .= "- Different price ranges and what to expect\n";
                $basePrompt .= "- How this product fits into the market\n";
                $basePrompt .= "- Tips for making the best purchase decision\n";
                break;
                
            case 'style_guide':
                $basePrompt .= "\nWrite a fashion/style guide that covers:\n";
                $basePrompt .= "- How to style this product\n";
                $basePrompt .= "- Different occasions to wear it\n";
                $basePrompt .= "- Matching accessories and complementary items\n";
                $basePrompt .= "- Seasonal styling tips\n";
                $basePrompt .= "- Care and maintenance advice\n";
                break;
                
            case 'trend_analysis':
                $basePrompt .= "\nWrite a trend analysis that discusses:\n";
                $basePrompt .= "- Current fashion trends related to this product\n";
                $basePrompt .= "- How this product fits into current trends\n";
                $basePrompt .= "- Historical context and evolution\n";
                $basePrompt .= "- Future predictions for this product category\n";
                $basePrompt .= "- Celebrity and influencer endorsements\n";
                break;
        }

        $basePrompt .= "\nFormat the response as JSON with the following structure:\n";
        $basePrompt .= "{\n";
        $basePrompt .= '  "title": "SEO-optimized blog post title",';
        $basePrompt .= '  "excerpt": "Compelling 160-character excerpt",';
        $basePrompt .= '  "content": "Full blog post content in HTML format",';
        $basePrompt .= '  "seo_title": "SEO title (50-60 characters)",';
        $basePrompt .= '  "seo_description": "Meta description (150-160 characters)",';
        $basePrompt .= '  "seo_keywords": ["keyword1", "keyword2", "keyword3"],';
        $basePrompt .= '  "suggested_tags": ["tag1", "tag2", "tag3"],';
        $basePrompt .= '  "reading_time": 8';
        $basePrompt .= "\n}\n";

        return $basePrompt;
    }

    /**
     * Parse the generated content from Gemini
     */
    protected function parseBlogContent($content, Product $product)
    {
        // Log parsing attempt
        Log::debug('Parsing blog content', [
            'product_id' => $product->id,
            'content_length' => strlen($content)
        ]);

        // Try to find JSON in the response - look for ```json blocks first
        if (preg_match('/```json\s*(\{.*?\})\s*```/s', $content, $matches)) {
            $jsonContent = $matches[1];
        } else {
            // Fallback to finding first { to last }
            $jsonStart = strpos($content, '{');
            $jsonEnd = strrpos($content, '}');

            if ($jsonStart === false || $jsonEnd === false) {
                Log::error('No JSON found in response', ['content' => $content]);
                throw new Exception('Invalid response format from Gemini AI - no JSON found');
            }

            $jsonContent = substr($content, $jsonStart, $jsonEnd - $jsonStart + 1);
        }

        Log::debug('Extracted JSON content', ['json_length' => strlen($jsonContent)]);

        $data = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            Log::error('JSON parsing failed', [
                'error' => json_last_error_msg(),
                'json_content' => $jsonContent
            ]);
            throw new Exception('Failed to parse JSON response from Gemini AI: ' . json_last_error_msg());
        }

        // Validate required fields
        $requiredFields = ['title', 'content', 'seo_title', 'seo_description'];
        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                throw new Exception("Missing required field: {$field}");
            }
        }

        // Add product-specific metadata
        $data['product_id'] = $product->id;
        $data['ai_generated'] = true;
        $data['ai_metadata'] = [
            'model' => 'gemini-2.0-flash',
            'generated_at' => now()->toISOString(),
            'product_name' => $product->name,
            'product_category' => $product->category->name,
        ];

        return $data;
    }

    /**
     * Generate blog title suggestions
     */
    public function generateTitleSuggestions(Product $product, $count = 5)
    {
        $prompt = "Generate {$count} SEO-optimized blog post titles for the product: {$product->name} in the {$product->category->name} category. ";
        $prompt .= "Each title should be 50-60 characters, engaging, and include relevant keywords. ";
        $prompt .= "Return as a JSON array of strings.";

        try {
            $response = Http::timeout(30)->post($this->baseUrl . '?key=' . $this->apiKey, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';
                
                // Extract JSON array
                $jsonStart = strpos($content, '[');
                $jsonEnd = strrpos($content, ']');
                
                if ($jsonStart !== false && $jsonEnd !== false) {
                    $jsonContent = substr($content, $jsonStart, $jsonEnd - $jsonStart + 1);
                    return json_decode($jsonContent, true) ?? [];
                }
            }
        } catch (Exception $e) {
            Log::error('Title generation failed', ['error' => $e->getMessage()]);
        }

        return [];
    }

    /**
     * Check if Gemini AI is configured
     */
    public function isConfigured()
    {
        return !empty($this->apiKey);
    }
}
