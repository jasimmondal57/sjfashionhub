<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class BodyFeatureSection extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'section_type',
        'display_style',
        'items_limit',
        'background_color',
        'text_color',
        'button_text',
        'button_url',
        'show_button',
        'content_settings',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'content_settings' => 'array',
        'show_button' => 'boolean',
        'is_active' => 'boolean',
    ];

    // Scopes
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    // Get content based on section type and settings
    public function getContentItems()
    {
        $settings = $this->content_settings ?? [];

        switch ($this->section_type) {
            case 'products':
                return $this->getProducts($settings);
            case 'categories':
                return $this->getCategories($settings);
            case 'mixed':
                return $this->getMixedContent($settings);
            default:
                return collect();
        }
    }

    private function getProducts($settings)
    {
        $query = Product::with(['category', 'activeVariants']);

        // Apply filters based on settings
        if (isset($settings['specific_products']) && !empty($settings['specific_products'])) {
            $query->whereIn('id', $settings['specific_products']);
        }

        if (isset($settings['categories']) && !empty($settings['categories'])) {
            $query->whereIn('category_id', $settings['categories']);
        }

        if (isset($settings['featured_only']) && $settings['featured_only']) {
            $query->where('is_featured', true);
        }

        if (isset($settings['on_sale_only']) && $settings['on_sale_only']) {
            $query->whereNotNull('sale_price');
        }

        if (isset($settings['sort_by'])) {
            switch ($settings['sort_by']) {
                case 'newest':
                    $query->latest();
                    break;
                case 'price_low':
                    $query->orderBy('price');
                    break;
                case 'price_high':
                    $query->orderByDesc('price');
                    break;
                case 'featured':
                    $query->orderByDesc('is_featured');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        return $query->take($this->items_limit)->get();
    }

    private function getCategories($settings)
    {
        // When section type is "categories", we want to show products FROM those categories
        // not the category names themselves
        $query = Product::with(['category', 'activeVariants'])->where('is_active', true);

        if (isset($settings['specific_categories']) && !empty($settings['specific_categories'])) {
            $query->whereIn('category_id', $settings['specific_categories']);
        }

        if (isset($settings['parent_only']) && $settings['parent_only']) {
            // If parent_only is true, get products from parent categories only
            $query->whereHas('category', function($q) {
                $q->whereNull('parent_id');
            });
        }

        // Apply sorting
        $sortBy = $settings['sort_by'] ?? 'newest';
        switch ($sortBy) {
            case 'featured':
                $query->orderBy('is_featured', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'price_low':
                $query->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'name':
                $query->orderBy('name');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query->take($this->items_limit)->get();
    }

    private function getMixedContent($settings)
    {
        $content = collect();

        if (isset($settings['products']) && !empty($settings['products'])) {
            $products = Product::whereIn('id', $settings['products'])->get();
            $content = $content->merge($products->map(function ($item) {
                $item->content_type = 'product';
                return $item;
            }));
        }

        if (isset($settings['categories']) && !empty($settings['categories'])) {
            $categories = Category::whereIn('id', $settings['categories'])->get();
            $content = $content->merge($categories->map(function ($item) {
                $item->content_type = 'category';
                return $item;
            }));
        }

        return $content->take($this->items_limit);
    }

    // Get all active sections for homepage
    public static function getActiveSections()
    {
        return static::active()->ordered()->get();
    }
}
