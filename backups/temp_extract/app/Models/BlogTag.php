<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogTag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'is_active',
        'posts_count',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'posts_count' => 'integer',
    ];

    /**
     * Boot the model
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tag) {
            if (empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });

        static::updating(function ($tag) {
            if ($tag->isDirty('name') && empty($tag->slug)) {
                $tag->slug = Str::slug($tag->name);
            }
        });
    }

    /**
     * Get the route key for the model
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * Get all blog posts with this tag
     */
    public function posts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tags');
    }

    /**
     * Get published posts with this tag
     */
    public function publishedPosts()
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tags')
                    ->where('status', 'published')
                    ->where('published_at', '<=', now());
    }

    /**
     * Update posts count
     */
    public function updatePostsCount()
    {
        $this->update(['posts_count' => $this->publishedPosts()->count()]);
    }

    /**
     * Scope for active tags
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for popular tags
     */
    public function scopePopular($query, $limit = 10)
    {
        return $query->where('posts_count', '>', 0)
                    ->orderBy('posts_count', 'desc')
                    ->limit($limit);
    }
}
