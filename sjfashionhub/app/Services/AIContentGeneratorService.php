<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIContentGeneratorService
{
    protected $openaiApiKey;
    protected $maxRetries = 3;

    public function __construct()
    {
        $this->openaiApiKey = config('services.openai.api_key');
    }

    /**
     * Generate social media post content for a product
     */
    public function generateProductPost(Product $product, string $platform): array
    {
        try {
            $prompt = $this->buildPrompt($product, $platform);
            
            $response = $this->callOpenAI($prompt);
            
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
     * Build the AI prompt based on product and platform
     */
    protected function buildPrompt(Product $product, string $platform): string
    {
        $platformSpecs = $this->getPlatformSpecifications($platform);
        
        $prompt = "Create an engaging social media post for {$platform} about this fashion product:\n\n";
        $prompt .= "Product Name: {$product->name}\n";
        $prompt .= "Brand: {$product->brand}\n";
        $prompt .= "Description: {$product->description}\n";
        $prompt .= "Price: {$product->formatted_price}";
        
        if ($product->sale_price) {
            $prompt .= " (Sale: {$product->formatted_sale_price})";
        }
        
        $prompt .= "\nCategory: {$product->category->name}\n";
        
        if ($product->color) {
            $prompt .= "Color: {$product->color}\n";
        }
        
        if ($product->size) {
            $prompt .= "Size: {$product->size}\n";
        }
        
        if ($product->material) {
            $prompt .= "Material: {$product->material}\n";
        }

        $prompt .= "\nPlatform: {$platform}\n";
        $prompt .= "Character limit: {$platformSpecs['char_limit']}\n";
        $prompt .= "Hashtag style: {$platformSpecs['hashtag_style']}\n";
        $prompt .= "Tone: {$platformSpecs['tone']}\n\n";

        $prompt .= "Requirements:\n";
        $prompt .= "- Create engaging, trendy copy that appeals to fashion enthusiasts\n";
        $prompt .= "- Include relevant fashion hashtags (5-10 hashtags)\n";
        $prompt .= "- Mention key product features and benefits\n";
        $prompt .= "- Include a call-to-action\n";
        $prompt .= "- Keep within character limits\n";
        $prompt .= "- Use emojis appropriately for the platform\n";
        $prompt .= "- Make it sound natural and authentic\n\n";

        $prompt .= "Return the response in this exact JSON format:\n";
        $prompt .= "{\n";
        $prompt .= '  "text": "The main post content",';
        $prompt .= "\n";
        $prompt .= '  "hashtags": ["hashtag1", "hashtag2", "hashtag3"],';
        $prompt .= "\n";
        $prompt .= '  "call_to_action": "Shop now at sjfashionhub.in"';
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
     * Call OpenAI API
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
                    return [
                        'text' => $parsed['text'],
                        'hashtags' => $parsed['hashtags'] ?? $this->getDefaultHashtags($product, $platform),
                        'call_to_action' => $parsed['call_to_action'] ?? 'Shop now at sjfashionhub.in',
                        'prompt' => "AI Generated for {$platform}"
                    ];
                }
            }

            // If JSON parsing fails, treat the whole response as text
            return [
                'text' => $response,
                'hashtags' => $this->getDefaultHashtags($product, $platform),
                'call_to_action' => 'Shop now at sjfashionhub.in',
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
     * Get default hashtags for a product and platform
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
