<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display blog listing page
     */
    public function index(Request $request)
    {
        $query = BlogPost::with(['category', 'author', 'tags'])
                         ->published()
                         ->latest('published_at');

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Tag filter
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        $posts = $query->paginate(12);
        $categories = BlogCategory::active()->withCount('publishedPosts')->get();
        $popularTags = BlogTag::active()->popular(10)->get();
        $featuredPosts = BlogPost::published()->featured()->limit(3)->get();

        return view('blog.index', compact('posts', 'categories', 'popularTags', 'featuredPosts'));
    }

    /**
     * Display posts by category
     */
    public function category(BlogCategory $category)
    {
        $posts = BlogPost::with(['author', 'tags'])
                         ->published()
                         ->where('blog_category_id', $category->id)
                         ->latest('published_at')
                         ->paginate(12);

        $categories = BlogCategory::active()->withCount('publishedPosts')->get();
        $popularTags = BlogTag::active()->popular(10)->get();

        return view('blog.category', compact('posts', 'category', 'categories', 'popularTags'));
    }

    /**
     * Display posts by tag
     */
    public function tag(BlogTag $tag)
    {
        $posts = $tag->publishedPosts()
                     ->with(['category', 'author'])
                     ->latest('published_at')
                     ->paginate(12);

        $categories = BlogCategory::active()->withCount('publishedPosts')->get();
        $popularTags = BlogTag::active()->popular(10)->get();

        return view('blog.tag', compact('posts', 'tag', 'categories', 'popularTags'));
    }

    /**
     * Display single blog post
     */
    public function show(BlogPost $post)
    {
        // Check if post is published
        if (!$post->is_published) {
            abort(404);
        }

        // Increment views
        $post->incrementViews();

        // Load relationships
        $post->load(['category', 'author', 'tags', 'product']);

        // Get related posts
        $relatedPosts = BlogPost::published()
                               ->where('id', '!=', $post->id)
                               ->where(function ($query) use ($post) {
                                   if ($post->category) {
                                       $query->where('blog_category_id', $post->category->id);
                                   }
                                   if ($post->tags->count() > 0) {
                                       $query->orWhereHas('tags', function ($q) use ($post) {
                                           $q->whereIn('blog_tags.id', $post->tags->pluck('id'));
                                       });
                                   }
                               })
                               ->limit(4)
                               ->get();

        $categories = BlogCategory::active()->withCount('publishedPosts')->get();
        $popularTags = BlogTag::active()->popular(10)->get();

        return view('blog.show', compact('post', 'relatedPosts', 'categories', 'popularTags'));
    }
}
