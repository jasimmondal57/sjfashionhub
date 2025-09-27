<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Services\GeminiAiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Exception;

class BlogAiController extends Controller
{
    protected $geminiService;

    public function __construct(GeminiAiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    /**
     * Show AI blog generation interface
     */
    public function index()
    {
        $products = Product::where('is_active', true)
                          ->with('category')
                          ->latest()
                          ->paginate(12);

        $categories = BlogCategory::active()->ordered()->get();
        $recentAiPosts = BlogPost::where('ai_generated', true)
                                ->with(['product', 'category'])
                                ->latest()
                                ->limit(5)
                                ->get();

        $stats = [
            'total_products' => Product::where('is_active', true)->count(),
            'ai_posts_generated' => BlogPost::where('ai_generated', true)->count(),
            'products_with_blogs' => Product::whereHas('blogPosts')->count(),
        ];

        return view('admin.blog.ai.index', compact('products', 'categories', 'recentAiPosts', 'stats'));
    }

    /**
     * Show product selection and AI generation options
     */
    public function create(Request $request)
    {
        $productId = $request->get('product_id');
        $product = null;

        if ($productId) {
            $product = Product::with(['category'])->findOrFail($productId);
        }

        $categories = BlogCategory::active()->ordered()->get();
        $blogTypes = [
            'product_review' => 'Product Review',
            'buying_guide' => 'Buying Guide',
            'style_guide' => 'Style Guide',
            'trend_analysis' => 'Trend Analysis',
        ];

        return view('admin.blog.ai.create', compact('product', 'categories', 'blogTypes'));
    }

    /**
     * Generate blog content using AI
     */
    public function generate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'auto_generate' => 'nullable|boolean',
            'blog_type' => 'nullable|in:product_review,buying_guide,style_guide,trend_analysis',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'target_keywords' => 'nullable|string',
            'tone' => 'nullable|in:professional,casual,friendly,authoritative',
            'word_count' => 'nullable|integer|min:500|max:3000',
        ]);

        try {
            $product = Product::with(['category'])->findOrFail($request->product_id);

            // Auto-generate settings if requested
            if ($request->auto_generate) {
                $autoSettings = $this->getAutoGenerationSettings($product);
                $request->merge($autoSettings);
            }

            // Prepare options for AI generation
            $options = [
                'blog_type' => $request->blog_type ?? 'product_review',
                'tone' => $request->tone ?? 'professional',
                'word_count' => $request->word_count ?? 1500,
            ];

            if ($request->filled('target_keywords')) {
                $options['target_keywords'] = array_map('trim', explode(',', $request->target_keywords));
            }

            // Generate content using Gemini AI
            $generatedContent = $this->geminiService->generateBlogPost($product, $options);

            // Create suggested tags
            $suggestedTags = [];
            if (!empty($generatedContent['suggested_tags'])) {
                foreach ($generatedContent['suggested_tags'] as $tagName) {
                    $tag = $this->createOrFindTag($tagName);
                    $suggestedTags[] = $tag->id;
                }
            }

            // Prepare blog post data
            $blogData = [
                'title' => $generatedContent['title'],
                'slug' => Str::slug($generatedContent['title']),
                'excerpt' => $generatedContent['excerpt'] ?? '',
                'content' => $generatedContent['content'],
                'seo_title' => $generatedContent['seo_title'],
                'seo_description' => $generatedContent['seo_description'],
                'seo_keywords' => implode(', ', $generatedContent['seo_keywords'] ?? []),
                'product_id' => $product->id,
                'blog_category_id' => $request->blog_category_id,
                'author_id' => Auth::id(),
                'ai_generated' => true,
                'ai_prompt' => json_encode($options),
                'ai_metadata' => $generatedContent['ai_metadata'],
                'status' => 'draft',
                'reading_time' => $generatedContent['reading_time'] ?? null,
                'featured_image' => $product->images->first()?->image_path,
            ];

            return response()->json([
                'success' => true,
                'blog_data' => $blogData,
                'suggested_tags' => $suggestedTags,
                'product' => $product,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate blog content: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Save generated blog post
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'seo_title' => 'nullable|string|max:60',
            'seo_description' => 'nullable|string|max:160',
            'seo_keywords' => 'nullable|string',
            'product_id' => 'required|exists:products,id',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
            'ai_prompt' => 'nullable|string',
            'ai_metadata' => 'nullable|array',
            'featured_image' => 'nullable|string',
            'status' => 'required|in:draft,published',
        ]);

        $data = $request->all();
        $data['author_id'] = Auth::id();
        $data['ai_generated'] = true;

        // Auto-generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Set published_at for published posts
        if ($data['status'] === 'published') {
            $data['published_at'] = now();
        }

        $post = BlogPost::create($data);

        // Attach tags
        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        }

        return response()->json([
            'success' => true,
            'message' => 'AI-generated blog post saved successfully!',
            'post_id' => $post->id,
            'redirect_url' => route('admin.blog.edit', $post),
        ]);
    }

    /**
     * Generate title suggestions for a product
     */
    public function generateTitles(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        try {
            $product = Product::with('category')->findOrFail($request->product_id);
            $titles = $this->geminiService->generateTitleSuggestions($product, 5);

            return response()->json([
                'success' => true,
                'titles' => $titles,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate titles: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Check AI service status
     */
    public function status()
    {
        $isConfigured = $this->geminiService->isConfigured();

        return response()->json([
            'configured' => $isConfigured,
            'message' => $isConfigured
                ? 'Gemini AI is configured and ready to use.'
                : 'Gemini AI is not configured. Please add GEMINI_API_KEY to your environment variables.',
            'csrf_token' => csrf_token(),
            'success' => true
        ]);
    }

    /**
     * Get products that don't have blog posts yet
     */
    public function getProductsWithoutBlogs()
    {
        $products = Product::where('is_active', true)
                          ->whereDoesntHave('blogPosts')
                          ->with('category')
                          ->latest()
                          ->limit(20)
                          ->get();

        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }

    /**
     * Get all active products for selection
     */
    public function getAllProducts()
    {
        $products = Product::where('is_active', true)
                          ->with('category')
                          ->latest()
                          ->get();

        return response()->json([
            'success' => true,
            'products' => $products,
        ]);
    }

    /**
     * Auto-generate blog content via GET request (no CSRF needed)
     */
    public function autoGenerate($productId, Request $request)
    {
        try {
            $product = Product::with(['category'])->findOrFail($productId);

            // Check if specific blog type is requested
            $requestedBlogType = $request->get('blog_type');

            // If specific blog type requested, generate only that type
            if ($requestedBlogType && in_array($requestedBlogType, ['product_review', 'buying_guide', 'style_guide', 'trend_analysis'])) {
                return $this->generateSingleBlogType($product, $requestedBlogType);
            }

            // Auto-generate settings for default type
            $autoSettings = $this->getAutoGenerationSettings($product);

            // Prepare options for AI generation
            $options = [
                'blog_type' => $autoSettings['blog_type'],
                'tone' => $autoSettings['tone'],
                'word_count' => $autoSettings['word_count'],
            ];

            if (!empty($autoSettings['target_keywords'])) {
                $options['target_keywords'] = array_map('trim', explode(',', $autoSettings['target_keywords']));
            }

            // Generate content using Gemini AI
            $generatedContent = $this->geminiService->generateBlogPost($product, $options);

            // Create suggested tags
            $suggestedTags = [];
            if (!empty($generatedContent['suggested_tags'])) {
                foreach ($generatedContent['suggested_tags'] as $tagName) {
                    $tag = $this->createOrFindTag($tagName);
                    $suggestedTags[] = $tag->id;
                }
            }

            // Create the blog post
            $blogPost = BlogPost::create([
                'title' => $generatedContent['title'],
                'slug' => Str::slug($generatedContent['title']),
                'excerpt' => $generatedContent['excerpt'] ?? '',
                'content' => $generatedContent['content'],
                'seo_title' => $generatedContent['seo_title'],
                'seo_description' => $generatedContent['seo_description'],
                'seo_keywords' => implode(', ', $generatedContent['seo_keywords'] ?? []),
                'product_id' => $product->id,
                'blog_category_id' => null, // Will be set by auto-generation
                'author_id' => Auth::id() ?? 1, // Default to admin user if not authenticated
                'ai_generated' => true,
                'ai_prompt' => json_encode($options),
                'ai_metadata' => json_encode($generatedContent['ai_metadata']),
                'status' => 'published', // Auto-publish the generated post
                'reading_time' => $generatedContent['reading_time'] ?? null,
                'featured_image' => $product->images[0]['image_path'] ?? null,
                'published_at' => now(),
            ]);

            // Attach suggested tags
            if (!empty($suggestedTags)) {
                $blogPost->tags()->attach($suggestedTags);
            }

            return response()->json([
                'success' => true,
                'message' => 'Blog post generated and published successfully!',
                'blog_post' => $blogPost,
                'blog_url' => route('admin.blog.show', $blogPost->id),
                'view_url' => route('blog.show', $blogPost->slug),
                'suggested_tags' => $suggestedTags,
                'product' => $product,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate blog content: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate all blog types for a product
     */
    public function generateAllBlogTypes($productId)
    {
        try {
            $product = Product::with(['category'])->findOrFail($productId);

            $blogTypes = ['product_review', 'buying_guide', 'style_guide', 'trend_analysis'];
            $generatedBlogs = [];
            $errors = [];

            foreach ($blogTypes as $blogType) {
                try {
                    $result = $this->generateSingleBlogType($product, $blogType);
                    $generatedBlogs[] = [
                        'blog_type' => $blogType,
                        'status' => 'generated',
                        'blog_post' => $result['blog_post'],
                        'message' => ucfirst(str_replace('_', ' ', $blogType)) . ' generated successfully'
                    ];

                    // Add a small delay between generations to avoid rate limiting
                    sleep(1);

                } catch (Exception $e) {
                    $errors[] = [
                        'blog_type' => $blogType,
                        'error' => $e->getMessage()
                    ];
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Blog generation completed!',
                'generated_blogs' => $generatedBlogs,
                'errors' => $errors,
                'product' => $product,
            ]);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate blogs: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate a single blog type for a product
     */
    private function generateSingleBlogType($product, $blogType)
    {
        // Get settings optimized for this blog type
        $settings = $this->getBlogTypeSettings($product, $blogType);

        // Prepare options for AI generation
        $options = [
            'blog_type' => $blogType,
            'tone' => $settings['tone'],
            'word_count' => $settings['word_count'],
            'target_keywords' => array_map('trim', explode(',', $settings['target_keywords'])),
        ];

        // Generate content using AI
        $generatedContent = $this->geminiService->generateBlogPost($product, $options);

        // Create suggested tags
        $suggestedTags = [];
        if (!empty($generatedContent['suggested_tags'])) {
            foreach ($generatedContent['suggested_tags'] as $tagName) {
                $tag = $this->createOrFindTag($tagName);
                $suggestedTags[] = $tag->id;
            }
        }

        // Create the blog post
        $blogPost = BlogPost::create([
            'title' => $generatedContent['title'],
            'slug' => $this->generateUniqueSlug($generatedContent['title']),
            'excerpt' => $generatedContent['excerpt'] ?? '',
            'content' => $generatedContent['content'],
            'seo_title' => $generatedContent['seo_title'],
            'seo_description' => $generatedContent['seo_description'],
            'seo_keywords' => implode(', ', $generatedContent['seo_keywords'] ?? []),
            'product_id' => $product->id,
            'blog_category_id' => null,
            'author_id' => Auth::id() ?? 1,
            'ai_generated' => true,
            'ai_prompt' => json_encode($options),
            'ai_metadata' => json_encode($generatedContent['ai_metadata']),
            'status' => 'published',
            'reading_time' => $generatedContent['reading_time'] ?? null,
            'featured_image' => $product->images[0]['image_path'] ?? null,
            'published_at' => now(),
        ]);

        // Attach suggested tags
        if (!empty($suggestedTags)) {
            $blogPost->tags()->attach($suggestedTags);
        }

        return [
            'blog_post' => $blogPost,
            'blog_url' => route('admin.blog.show', $blogPost->id),
            'view_url' => route('blog.show', $blogPost->slug),
            'suggested_tags' => $suggestedTags,
        ];
    }

    /**
     * Get blog type specific settings with variation for SEO diversity
     */
    private function getBlogTypeSettings($product, $blogType)
    {
        $baseKeywords = $this->generateAutoKeywords($product);

        // Add random variation to keywords for better SEO coverage
        $variations = [
            'product_review' => [
                ['product review, detailed review, pros and cons, honest review', 1800, 'professional'],
                ['in-depth review, comprehensive review, product analysis, review guide', 1900, 'authoritative'],
                ['unbiased review, expert review, product evaluation, detailed analysis', 1700, 'professional'],
                ['complete review, thorough review, product breakdown, review summary', 1850, 'casual'],
            ],
            'buying_guide' => [
                ['buying guide, how to choose, best price, purchase tips', 1500, 'casual'],
                ['shopping guide, buying advice, purchase guide, smart shopping', 1600, 'friendly'],
                ['buyer guide, shopping tips, how to buy, purchase decisions', 1550, 'casual'],
                ['complete buying guide, shopping advice, purchase recommendations', 1650, 'authoritative'],
            ],
            'style_guide' => [
                ['style guide, fashion tips, how to wear, styling ideas', 1200, 'friendly'],
                ['styling guide, fashion advice, outfit ideas, style tips', 1300, 'casual'],
                ['fashion guide, style inspiration, wardrobe tips, styling secrets', 1250, 'friendly'],
                ['complete style guide, fashion styling, outfit guide, style advice', 1350, 'authoritative'],
            ],
            'trend_analysis' => [
                ['fashion trends, latest trends, trend analysis, style trends', 1600, 'authoritative'],
                ['trend forecast, fashion predictions, style evolution, trend insights', 1700, 'professional'],
                ['current trends, trending styles, fashion movements, style direction', 1650, 'authoritative'],
                ['trend report, fashion outlook, style trends analysis, trend guide', 1750, 'professional'],
            ],
        ];

        // Get random variation for the blog type
        $typeVariations = $variations[$blogType] ?? $variations['product_review'];
        $selectedVariation = $typeVariations[array_rand($typeVariations)];

        return [
            'tone' => $selectedVariation[2],
            'word_count' => $selectedVariation[1],
            'target_keywords' => $baseKeywords . ', ' . $selectedVariation[0],
        ];
    }

    /**
     * Generate unique slug to avoid conflicts with timestamp for better SEO diversity
     */
    private function generateUniqueSlug($title)
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;

        // Add timestamp-based suffix for uniqueness and SEO diversity
        if (BlogPost::where('slug', $slug)->exists()) {
            $timestamp = now()->format('Y-m-d');
            $slug = $baseSlug . '-' . $timestamp;

            // If still exists, add counter
            $counter = 1;
            while (BlogPost::where('slug', $slug)->exists()) {
                $slug = $baseSlug . '-' . $timestamp . '-' . $counter;
                $counter++;
            }
        }

        return $slug;
    }

    /**
     * Get automatic generation settings based on product
     */
    private function getAutoGenerationSettings($product)
    {
        // Determine best blog type based on product category and characteristics
        $blogType = $this->determineBestBlogType($product);

        // Auto-generate keywords based on product
        $keywords = $this->generateAutoKeywords($product);

        // Determine optimal word count
        $wordCount = $this->getOptimalWordCount($product);

        // Choose appropriate tone
        $tone = $this->selectOptimalTone($product);

        return [
            'blog_type' => $blogType,
            'target_keywords' => $keywords,
            'word_count' => $wordCount,
            'tone' => $tone,
        ];
    }

    /**
     * Determine the best blog type for the product
     */
    private function determineBestBlogType($product)
    {
        $categoryName = strtolower($product->category->name ?? '');
        $productName = strtolower($product->name);

        // Logic to determine blog type based on product characteristics
        if (str_contains($categoryName, 'dress') || str_contains($categoryName, 'fashion')) {
            return 'style_guide';
        } elseif (str_contains($productName, 'trend') || str_contains($productName, 'latest')) {
            return 'trend_analysis';
        } elseif ($product->price > 2000) {
            return 'product_review';
        } else {
            return 'buying_guide';
        }
    }

    /**
     * Generate automatic keywords based on product
     */
    private function generateAutoKeywords($product)
    {
        $keywords = [];

        // Add product name variations
        $keywords[] = strtolower($product->name);
        $keywords[] = strtolower($product->category->name ?? 'fashion');

        // Add category-specific keywords
        $categoryKeywords = [
            'shirts' => ['formal shirts', 'casual shirts', 'cotton shirts', 'office wear'],
            'dresses' => ['party dresses', 'formal dresses', 'evening wear', 'casual dresses'],
            'jeans' => ['denim', 'casual pants', 'skinny jeans', 'straight fit'],
            't-shirts' => ['casual tees', 'cotton t-shirts', 'graphic tees', 'basic tees'],
            'tops' => ['women tops', 'casual tops', 'formal tops', 'trendy tops'],
        ];

        $categoryName = strtolower($product->category->name ?? '');
        if (isset($categoryKeywords[$categoryName])) {
            $keywords = array_merge($keywords, $categoryKeywords[$categoryName]);
        }

        // Add general fashion keywords
        $keywords = array_merge($keywords, [
            'fashion', 'style', 'trendy', 'online shopping', 'best price'
        ]);

        return implode(', ', array_slice($keywords, 0, 8));
    }

    /**
     * Get optimal word count based on product
     */
    private function getOptimalWordCount($product)
    {
        // Higher-priced items get longer, more detailed content
        if ($product->price > 2500) {
            return 2000; // Comprehensive
        } elseif ($product->price > 1500) {
            return 1500; // Detailed
        } else {
            return 1200; // Medium
        }
    }

    /**
     * Select optimal tone based on product
     */
    private function selectOptimalTone($product)
    {
        $categoryName = strtolower($product->category->name ?? '');

        if (str_contains($categoryName, 'formal') || $product->price > 2000) {
            return 'professional';
        } elseif (str_contains($categoryName, 'casual') || str_contains($categoryName, 't-shirt')) {
            return 'friendly';
        } else {
            return 'casual';
        }
    }

    /**
     * Create or find existing tag by name, handling duplicates properly
     */
    private function createOrFindTag($tagName)
    {
        $slug = Str::slug($tagName);
        $tag = BlogTag::where('slug', $slug)->first();

        if (!$tag) {
            try {
                $tag = BlogTag::create([
                    'name' => $tagName,
                    'slug' => $slug,
                    'is_active' => true
                ]);
            } catch (\Exception $e) {
                // If creation fails due to race condition, try to find again
                $tag = BlogTag::where('slug', $slug)->first();
                if (!$tag) {
                    throw $e; // Re-throw if still not found
                }
            }
        }

        return $tag;
    }
}
