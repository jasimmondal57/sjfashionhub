<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIContentGeneratorService
{
    protected $openaiApiKey;
    protected $geminiApiKey;
    protected $maxRetries = 3;

    public function __construct()
    {
        $this->openaiApiKey = config('services.openai.api_key');
        $this->geminiApiKey = config('services.gemini.api_key');
    }

    /**
     * Generate social media post content for a product
     */
    public function generateProductPost(Product $product, string $platform): array
    {
        try {
            $prompt = $this->buildEnhancedPrompt($product, $platform);

            // Try Gemini first, fallback to OpenAI
            $response = $this->callGemini($prompt);

            if (!$response) {
                $response = $this->callOpenAI($prompt);
            }

            if (!$response) {
                return $this->getFallbackContent($product, $platform);
            }

            return $this->parseAIResponse($response, $product, $platform);

        } catch (\Exception $e) {
            Log::error("AI content generation error: " . $e->getMessage());
            return $this->getFallbackContent($product, $platform);
        }
    }

    /**
     * Build enhanced AI prompt with comprehensive product information
     */
    protected function buildEnhancedPrompt(Product $product, string $platform): string
    {
        $platformSpecs = $this->getPlatformSpecifications($platform);
        $productUrl = url("/products/{$product->slug}");

        $prompt = "Create an engaging social media post for {$platform} about this fashion product:\n\n";

        // Basic Product Information
        $prompt .= "=== PRODUCT DETAILS ===\n";
        $prompt .= "Product Name: {$product->name}\n";
        $prompt .= "Brand: {$product->brand}\n";
        $prompt .= "Category: {$product->category->name}\n";
        $prompt .= "Description: {$product->description}\n";

        // Pricing Information
        $prompt .= "\n=== PRICING & OFFERS ===\n";
        $prompt .= "Regular Price: {$product->formatted_price}\n";

        if ($product->sale_price) {
            $prompt .= "Sale Price: {$product->formatted_sale_price}\n";
            $prompt .= "Discount: {$product->discount_percentage}% OFF\n";
            $prompt .= "Savings: ₹" . number_format($product->price - $product->sale_price, 0) . "\n";
        }

        if ($product->compare_at_price && $product->compare_at_price > $product->price) {
            $prompt .= "Compare at: ₹" . number_format($product->compare_at_price, 0) . "\n";
        }

        // Product Attributes
        $prompt .= "\n=== PRODUCT ATTRIBUTES ===\n";
        if ($product->color) $prompt .= "Color: {$product->color}\n";
        if ($product->size) $prompt .= "Size: {$product->size}\n";
        if ($product->material) $prompt .= "Material: {$product->material}\n";
        if ($product->pattern) $prompt .= "Pattern: {$product->pattern}\n";
        if ($product->gender) $prompt .= "Gender: " . ucfirst($product->gender) . "\n";
        if ($product->age_group) $prompt .= "Age Group: {$product->age_group}\n";

        // Stock & Availability
        $prompt .= "\n=== AVAILABILITY ===\n";
        $prompt .= "Stock Status: " . ($product->stock_quantity > 0 ? "In Stock ({$product->stock_quantity} available)" : "Limited Stock") . "\n";
        if ($product->stock_quantity <= 10 && $product->stock_quantity > 0) {
            $prompt .= "⚠️ Only {$product->stock_quantity} left in stock!\n";
        }

        // SEO & Tags
        $prompt .= "\n=== SEO INFORMATION ===\n";
        if ($product->meta_keywords) $prompt .= "SEO Keywords: {$product->meta_keywords}\n";
        if ($product->tags) $prompt .= "Product Tags: " . implode(', ', $product->tags) . "\n";

        // Direct Product Link
        $prompt .= "\n=== PRODUCT LINK ===\n";
        $prompt .= "Direct Product URL: {$productUrl}\n";
        $prompt .= "Website: sjfashionhub.in\n";

        // Platform Specifications
        $prompt .= "\n=== PLATFORM REQUIREMENTS ===\n";
        $prompt .= "Platform: {$platform}\n";
        $prompt .= "Character limit: {$platformSpecs['char_limit']}\n";
        $prompt .= "Hashtag style: {$platformSpecs['hashtag_style']}\n";
        $prompt .= "Tone: {$platformSpecs['tone']}\n";

        $prompt .= "\n=== CONTENT REQUIREMENTS ===\n";
        $prompt .= "- Create engaging, trendy copy that appeals to fashion enthusiasts\n";
        $prompt .= "- MUST include the direct product link: {$productUrl}\n";
        $prompt .= "- Include pricing information prominently\n";
        $prompt .= "- Highlight any discounts or special offers\n";
        $prompt .= "- Include 8-15 relevant fashion hashtags\n";
        $prompt .= "- Add SEO-friendly hashtags based on product attributes\n";
        $prompt .= "- Mention key product features and benefits\n";
        $prompt .= "- Include urgency if low stock\n";
        $prompt .= "- Add a strong call-to-action\n";
        $prompt .= "- Keep within character limits\n";
        $prompt .= "- Use emojis appropriately for the platform\n";
        $prompt .= "- Make it sound natural and authentic\n";
        $prompt .= "- Include brand mention and website\n\n";

        $prompt .= "Return the response in this exact JSON format:\n";
        $prompt .= "{\n";
        $prompt .= '  "text": "The main post content with product link",';
        $prompt .= "\n";
        $prompt .= '  "hashtags": ["hashtag1", "hashtag2", "hashtag3", "seo_tag1", "seo_tag2"],';
        $prompt .= "\n";
        $prompt .= '  "call_to_action": "Shop now at sjfashionhub.in",';
        $prompt .= "\n";
        $prompt .= '  "product_url": "' . $productUrl . '",';
        $prompt .= "\n";
        $prompt .= '  "price_info": "Price and offer details"';
        $prompt .= "\n}";

        return $prompt;
    }

    /**
     * Get platform-specific specifications
     */
    protected function getPlatformSpecifications(string $platform): array
    {
        return match($platform) {
            'instagram' => [
                'char_limit' => 2200,
                'hashtag_style' => 'Popular fashion hashtags, trending tags',
                'tone' => 'Visual, trendy, lifestyle-focused'
            ],
            'facebook' => [
                'char_limit' => 63206,
                'hashtag_style' => 'Moderate use of hashtags',
                'tone' => 'Conversational, community-focused'
            ],
            'twitter' => [
                'char_limit' => 280,
                'hashtag_style' => 'Concise, trending hashtags',
                'tone' => 'Brief, witty, engaging'
            ],
            'linkedin' => [
                'char_limit' => 3000,
                'hashtag_style' => 'Professional, industry-related',
                'tone' => 'Professional, business-focused'
            ],
            'pinterest' => [
                'char_limit' => 500,
                'hashtag_style' => 'Descriptive, searchable tags',
                'tone' => 'Inspirational, descriptive'
            ],
            'tiktok' => [
                'char_limit' => 2200,
                'hashtag_style' => 'Trending, viral hashtags',
                'tone' => 'Fun, energetic, youthful'
            ],
            default => [
                'char_limit' => 1000,
                'hashtag_style' => 'General hashtags',
                'tone' => 'Engaging, friendly'
            ]
        };
    }

    /**
     * Call Gemini API to generate content
     */
    protected function callGemini(string $prompt): ?string
    {
        if (!$this->geminiApiKey) {
            Log::warning("Gemini API key not configured");
            return null;
        }

        try {
            $response = Http::timeout(30)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$this->geminiApiKey}", [
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
                    'maxOutputTokens' => 1024,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();

                if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                    return $data['candidates'][0]['content']['parts'][0]['text'];
                }
            }

            Log::warning('Gemini API call failed', [
                'status' => $response->status(),
                'response' => $response->body()
            ]);

            return null;

        } catch (\Exception $e) {
            Log::error('Gemini API error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Call OpenAI API (fallback)
     */
    protected function callOpenAI(string $prompt): ?string
    {
        if (!$this->openaiApiKey) {
            Log::warning("OpenAI API key not configured");
            return null;
        }

        $retries = 0;
        
        while ($retries < $this->maxRetries) {
            try {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $this->openaiApiKey,
                    'Content-Type' => 'application/json',
                ])->timeout(30)->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            'role' => 'system',
                            'content' => 'You are a professional social media content creator specializing in fashion marketing. Create engaging, authentic posts that drive sales.'
                        ],
                        [
                            'role' => 'user',
                            'content' => $prompt
                        ]
                    ],
                    'max_tokens' => 500,
                    'temperature' => 0.7,
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    return $data['choices'][0]['message']['content'] ?? null;
                }

                Log::warning("OpenAI API error: " . $response->body());
                $retries++;
                
                if ($retries < $this->maxRetries) {
                    sleep(1); // Wait before retry
                }

            } catch (\Exception $e) {
                Log::error("OpenAI API call failed: " . $e->getMessage());
                $retries++;
                
                if ($retries < $this->maxRetries) {
                    sleep(1);
                }
            }
        }

        return null;
    }

    /**
     * Parse AI response and extract content
     */
    protected function parseAIResponse(string $response, Product $product, string $platform): array
    {
        try {
            // Try to extract JSON from the response
            $jsonStart = strpos($response, '{');
            $jsonEnd = strrpos($response, '}');
            
            if ($jsonStart !== false && $jsonEnd !== false) {
                $jsonString = substr($response, $jsonStart, $jsonEnd - $jsonStart + 1);
                $parsed = json_decode($jsonString, true);
                
                if ($parsed && isset($parsed['text'])) {
                    $productUrl = url("/products/{$product->slug}");

                    // Ensure product URL is included in content
                    $content = $parsed['text'];
                    if (!str_contains($content, $productUrl) && !str_contains($content, 'sjfashionhub.in')) {
                        $content .= "\n\n🛒 Shop now: {$productUrl}";
                    }

                    return [
                        'text' => $content,
                        'hashtags' => $parsed['hashtags'] ?? $this->getEnhancedHashtags($product, $platform),
                        'call_to_action' => $parsed['call_to_action'] ?? 'Shop now at sjfashionhub.in',
                        'product_url' => $parsed['product_url'] ?? $productUrl,
                        'price_info' => $parsed['price_info'] ?? $this->formatPriceInfo($product),
                        'prompt' => "AI Generated for {$platform}"
                    ];
                }
            }

            // If JSON parsing fails, treat the whole response as text with enhancements
            $productUrl = url("/products/{$product->slug}");
            $content = $response;

            if (!str_contains($content, $productUrl) && !str_contains($content, 'sjfashionhub.in')) {
                $content .= "\n\n🛒 Shop now: {$productUrl}";
            }

            return [
                'text' => $content,
                'hashtags' => $this->getEnhancedHashtags($product, $platform),
                'call_to_action' => 'Shop now at sjfashionhub.in',
                'product_url' => $productUrl,
                'price_info' => $this->formatPriceInfo($product),
                'prompt' => "AI Generated for {$platform}"
            ];

        } catch (\Exception $e) {
            Log::error("Error parsing AI response: " . $e->getMessage());
            return $this->getFallbackContent($product, $platform);
        }
    }

    /**
     * Get fallback content when AI fails
     */
    protected function getFallbackContent(Product $product, string $platform): array
    {
        $platformEmojis = match($platform) {
            'instagram' => '📸✨',
            'facebook' => '👗💫',
            'twitter' => '🔥',
            'linkedin' => '👔',
            'pinterest' => '📌',
            'tiktok' => '🎵💃',
            default => '✨'
        };

        $text = "{$platformEmojis} Discover {$product->name} from {$product->brand}! ";
        
        if ($product->is_on_sale) {
            $text .= "Special offer: {$product->formatted_sale_price} (was {$product->formatted_price}) ";
        } else {
            $text .= "Starting at {$product->formatted_price} ";
        }
        
        $text .= "Perfect for your wardrobe! Shop now at sjfashionhub.in";

        return [
            'text' => $text,
            'hashtags' => $this->getDefaultHashtags($product, $platform),
            'call_to_action' => 'Shop now at sjfashionhub.in',
            'prompt' => "Fallback content for {$platform}"
        ];
    }

    /**
     * Format price information for social media
     */
    protected function formatPriceInfo(Product $product): string
    {
        $priceInfo = "💰 {$product->formatted_price}";

        if ($product->sale_price) {
            $priceInfo = "💰 {$product->formatted_sale_price} (was {$product->formatted_price})";
            $priceInfo .= " - Save {$product->discount_percentage}%!";
        }

        return $priceInfo;
    }

    /**
     * Get enhanced hashtags with SEO and product attributes
     */
    protected function getEnhancedHashtags(Product $product, string $platform): array
    {
        $hashtags = [];

        // Brand and product hashtags
        if ($product->brand) {
            $hashtags[] = strtolower(str_replace(' ', '', $product->brand));
        }

        // Category hashtags
        $hashtags[] = strtolower(str_replace(' ', '', $product->category->name));

        // Product attribute hashtags
        if ($product->color) {
            $hashtags[] = strtolower($product->color);
        }

        if ($product->material) {
            $hashtags[] = strtolower(str_replace(' ', '', $product->material));
        }

        if ($product->pattern) {
            $hashtags[] = strtolower(str_replace(' ', '', $product->pattern));
        }

        if ($product->gender) {
            $hashtags[] = strtolower($product->gender) . 'fashion';
        }

        // SEO hashtags from meta keywords
        if ($product->meta_keywords) {
            $seoTags = explode(',', $product->meta_keywords);
            foreach (array_slice($seoTags, 0, 3) as $tag) {
                $hashtags[] = strtolower(str_replace(' ', '', trim($tag)));
            }
        }

        // Product tags
        if ($product->tags && is_array($product->tags)) {
            foreach (array_slice($product->tags, 0, 3) as $tag) {
                $hashtags[] = strtolower(str_replace(' ', '', $tag));
            }
        }

        // Fashion-specific hashtags
        $fashionHashtags = [
            'fashion', 'style', 'trendy', 'outfit', 'ootd', 'fashionista',
            'shopping', 'onlineshopping', 'sjfashionhub', 'indianfashion'
        ];

        // Sale/offer hashtags
        if ($product->sale_price) {
            $fashionHashtags = array_merge($fashionHashtags, ['sale', 'discount', 'offer', 'deal']);
        }

        // Add fashion hashtags to fill up to 15 total
        $remainingSlots = 15 - count($hashtags);
        $hashtags = array_merge($hashtags, array_slice($fashionHashtags, 0, $remainingSlots));

        // Remove duplicates and clean up
        $hashtags = array_unique($hashtags);
        $hashtags = array_filter($hashtags, function($tag) {
            return strlen($tag) > 2 && preg_match('/^[a-z0-9]+$/', $tag);
        });

        return array_values($hashtags);
    }

    /**
     * Get default hashtags for a product and platform (fallback)
     */
    protected function getDefaultHashtags(Product $product, string $platform): array
    {
        $hashtags = ['fashion', 'style', 'shopping', 'sjfashionhub'];
        
        // Add category-based hashtags
        if ($product->category) {
            $hashtags[] = strtolower(str_replace(' ', '', $product->category->name));
        }
        
        // Add product-specific hashtags
        if ($product->brand) {
            $hashtags[] = strtolower(str_replace(' ', '', $product->brand));
        }
        
        if ($product->color) {
            $hashtags[] = strtolower($product->color);
        }
        
        // Platform-specific hashtags
        $platformHashtags = match($platform) {
            'instagram' => ['ootd', 'fashionista', 'instafashion', 'trendy'],
            'facebook' => ['onlineshopping', 'fashiondeals'],
            'twitter' => ['fashion', 'style'],
            'linkedin' => ['fashion', 'business'],
            'pinterest' => ['fashioninspiration', 'styleinspo'],
            'tiktok' => ['fashiontok', 'ootd', 'trending'],
            default => ['fashion', 'style']
        };
        
        return array_unique(array_merge($hashtags, $platformHashtags));
    }
}
