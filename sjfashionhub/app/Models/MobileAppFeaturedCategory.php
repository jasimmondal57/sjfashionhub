<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MobileAppFeaturedCategory extends Model
{
    protected $fillable = [
        'category_id',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that belongs to this featured category
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get active featured categories in order
     */
    public static function getActive($limit = null)
    {
        $query = self::with('category')
            ->where('is_active', true)
            ->whereHas('category', function ($q) {
                $q->where('is_active', true);
            })
            ->orderBy('order');
            
        if ($limit) {
            $query->limit($limit);
        }
        
        return $query->get();
    }

    /**
     * Get all featured categories for admin management
     */
    public static function getAllForAdmin()
    {
        return self::with('category')
            ->orderBy('order')
            ->get();
    }

    /**
     * Reorder featured categories
     */
    public static function reorder(array $categoryIds)
    {
        foreach ($categoryIds as $index => $categoryId) {
            self::where('id', $categoryId)->update(['order' => $index + 1]);
        }
    }
}
