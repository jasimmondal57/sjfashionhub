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
            'blog_type' => 'required|in:product_review,buying_guide,style_guide,trend_analysis',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'target_keywords' => 'nullable|string',
            'tone' => 'required|in:professional,casual,friendly,authoritative',
            'word_count' => 'required|integer|min:500|max:3000',
        ]);

        try {
            $product = Product::with(['category', 'images'])->findOrFail($request->product_id);

            // Prepare options for AI generation
            $options = [
                'blog_type' => $request->blog_type,
                'tone' => $request->tone,
                'word_count' => $request->word_count,
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
                    $tag = BlogTag::firstOrCreate(
                        ['slug' => Str::slug($tagName)],
                        ['name' => $tagName, 'is_active' => true]
                    );
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
}
