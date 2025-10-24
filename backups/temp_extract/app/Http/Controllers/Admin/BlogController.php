<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of blog posts
     */
    public function index(Request $request)
    {
        $query = BlogPost::with(['category', 'author', 'tags', 'product']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->where('blog_category_id', $request->category);
        }

        // Filter by AI generated
        if ($request->filled('ai_generated')) {
            $query->where('ai_generated', $request->boolean('ai_generated'));
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $posts = $query->latest()->paginate(15);
        $categories = BlogCategory::active()->ordered()->get();

        $stats = [
            'total_posts' => BlogPost::count(),
            'published_posts' => BlogPost::published()->count(),
            'draft_posts' => BlogPost::where('status', 'draft')->count(),
            'ai_generated_posts' => BlogPost::where('ai_generated', true)->count(),
        ];

        return view('admin.blog.index', compact('posts', 'categories', 'stats'));
    }

    /**
     * Show the form for creating a new blog post
     */
    public function create()
    {
        $categories = BlogCategory::active()->ordered()->get();
        $tags = BlogTag::active()->get();
        $products = Product::where('is_active', true)->with('category')->get();

        return view('admin.blog.create', compact('categories', 'tags', 'products'));
    }

    /**
     * Store a newly created blog post
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'product_id' => 'nullable|exists:products,id',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'scheduled_at' => 'nullable|date|after:now',
            'seo_title' => 'nullable|string|max:60',
            'seo_description' => 'nullable|string|max:160',
            'seo_keywords' => 'nullable|string',
            'is_featured' => 'boolean',
            'allow_comments' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
        ]);

        $data = $request->all();
        $data['author_id'] = Auth::id();

        // Auto-generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Set published_at for published posts
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $post = BlogPost::create($data);

        // Attach tags
        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('admin.blog.index')
                        ->with('success', 'Blog post created successfully!');
    }

    /**
     * Display the specified blog post
     */
    public function show(BlogPost $post)
    {
        $post->load(['category', 'author', 'tags', 'product']);
        return view('admin.blog.show', compact('post'));
    }

    /**
     * Show the form for editing the specified blog post
     */
    public function edit(BlogPost $post)
    {
        $categories = BlogCategory::active()->ordered()->get();
        $tags = BlogTag::active()->get();
        $products = Product::where('is_active', true)->with('category')->get();
        $selectedTags = $post->tags->pluck('id')->toArray();

        return view('admin.blog.edit', compact('post', 'categories', 'tags', 'products', 'selectedTags'));
    }

    /**
     * Update the specified blog post
     */
    public function update(Request $request, BlogPost $post)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_posts,slug,' . $post->id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'featured_image' => 'nullable|string',
            'blog_category_id' => 'nullable|exists:blog_categories,id',
            'product_id' => 'nullable|exists:products,id',
            'status' => 'required|in:draft,published,scheduled',
            'published_at' => 'nullable|date',
            'scheduled_at' => 'nullable|date|after:now',
            'seo_title' => 'nullable|string|max:60',
            'seo_description' => 'nullable|string|max:160',
            'seo_keywords' => 'nullable|string',
            'is_featured' => 'boolean',
            'allow_comments' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:blog_tags,id',
        ]);

        $data = $request->all();

        // Auto-generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Set published_at for newly published posts
        if ($data['status'] === 'published' && $post->status !== 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $post->update($data);

        // Sync tags
        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

        return redirect()->route('admin.blog.index')
                        ->with('success', 'Blog post updated successfully!');
    }

    /**
     * Remove the specified blog post
     */
    public function destroy(BlogPost $post)
    {
        $post->tags()->detach();
        $post->delete();

        return redirect()->route('admin.blog.index')
                        ->with('success', 'Blog post deleted successfully!');
    }

    /**
     * Bulk actions for blog posts
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:publish,unpublish,delete,feature,unfeature',
            'posts' => 'required|array',
            'posts.*' => 'exists:blog_posts,id',
        ]);

        $posts = BlogPost::whereIn('id', $request->posts);

        switch ($request->action) {
            case 'publish':
                $posts->update([
                    'status' => 'published',
                    'published_at' => now()
                ]);
                $message = 'Posts published successfully!';
                break;

            case 'unpublish':
                $posts->update(['status' => 'draft']);
                $message = 'Posts unpublished successfully!';
                break;

            case 'delete':
                $posts->delete();
                $message = 'Posts deleted successfully!';
                break;

            case 'feature':
                $posts->update(['is_featured' => true]);
                $message = 'Posts featured successfully!';
                break;

            case 'unfeature':
                $posts->update(['is_featured' => false]);
                $message = 'Posts unfeatured successfully!';
                break;
        }

        return redirect()->route('admin.blog.index')->with('success', $message);
    }
}
