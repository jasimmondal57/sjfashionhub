<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;

class SeoService
{
    /**
     * Generate SEO-friendly content for a product
     */
    public function generateProductSeo(Product $product): array
    {
        $category = $product->category;
        $brandName = 'SJ Fashion Hub';
        
        // Generate SEO title (50-60 characters optimal)
        $seoTitle = $this->generateProductTitle($product, $category, $brandName);
        
        // Generate meta description (150-160 characters optimal)
        $metaDescription = $this->generateProductMetaDescription($product, $category, $brandName);
        
        // Generate enhanced short description
        $shortDescription = $this->generateProductShortDescription($product, $category);
        
        // Generate detailed product description
        $longDescription = $this->generateProductLongDescription($product, $category);
        
        // Generate meta keywords
        $metaKeywords = $this->generateProductKeywords($product, $category);
        
        // Generate structured data
        $structuredData = $this->generateProductStructuredData($product);
        
        return [
            'seo_title' => $seoTitle,
            'meta_description' => $metaDescription,
            'short_description' => $shortDescription,
            'long_description' => $longDescription,
            'meta_keywords' => $metaKeywords,
            'structured_data' => $structuredData,
        ];
    }

    /**
     * Generate SEO-friendly content for a category
     */
    public function generateCategorySeo(Category $category): array
    {
        $brandName = 'SJ Fashion Hub';
        
        // Generate SEO title
        $seoTitle = $this->generateCategoryTitle($category, $brandName);
        
        // Generate meta description
        $metaDescription = $this->generateCategoryMetaDescription($category, $brandName);
        
        // Generate category description
        $description = $this->generateCategoryDescription($category);
        
        // Generate meta keywords
        $metaKeywords = $this->generateCategoryKeywords($category);
        
        return [
            'seo_title' => $seoTitle,
            'meta_description' => $metaDescription,
            'description' => $description,
            'meta_keywords' => $metaKeywords,
        ];
    }

    /**
     * Generate product SEO title
     */
    private function generateProductTitle(Product $product, Category $category, string $brandName): string
    {
        $templates = [
            "{product} - Premium {category} | {brand}",
            "Buy {product} Online - {category} Collection | {brand}",
            "{product} - Stylish {category} at Best Price | {brand}",
            "Shop {product} - Latest {category} Fashion | {brand}",
            "{product} - Quality {category} for Every Occasion | {brand}",
        ];
        
        $template = $templates[array_rand($templates)];
        
        $title = str_replace(['{product}', '{category}', '{brand}'], [
            $product->name,
            $category->name,
            $brandName
        ], $template);
        
        // Ensure title is within SEO limits (50-60 characters)
        return Str::limit($title, 58, '');
    }

    /**
     * Generate product meta description
     */
    private function generateProductMetaDescription(Product $product, Category $category, string $brandName): string
    {
        $price = $product->sale_price ?? $product->price;
        $discount = $product->discount_percentage;
        
        $templates = [
            "Shop {product} at {brand}. Premium quality {category} starting from ₹{price}. {discount}Free shipping on orders above ₹999. Buy now!",
            "Discover {product} in our {category} collection. High-quality fashion at ₹{price}. {discount}Easy returns & fast delivery. Order today!",
            "Buy {product} online at {brand}. Stylish {category} with premium quality. Price: ₹{price}. {discount}Free shipping available.",
            "Get {product} from {brand}'s {category} range. Quality assured at ₹{price}. {discount}Shop now with easy returns & secure payment.",
        ];
        
        $template = $templates[array_rand($templates)];
        
        $discountText = $discount > 0 ? "{$discount}% OFF! " : "";
        
        $description = str_replace(['{product}', '{category}', '{brand}', '{price}', '{discount}'], [
            $product->name,
            $category->name,
            $brandName,
            number_format($price),
            $discountText
        ], $template);
        
        // Ensure description is within SEO limits (150-160 characters)
        return Str::limit($description, 158, '');
    }

    /**
     * Generate enhanced short description
     */
    private function generateProductShortDescription(Product $product, Category $category): string
    {
        $templates = [
            "Premium {category} crafted with attention to detail. {product} combines style and comfort for the modern fashion enthusiast.",
            "Elevate your wardrobe with this stylish {product}. Perfect {category} piece that offers both comfort and contemporary design.",
            "Discover the perfect blend of style and quality in this {product}. A must-have {category} item for fashion-forward individuals.",
            "Experience luxury and comfort with this {product}. Expertly designed {category} that complements any modern wardrobe.",
        ];
        
        $template = $templates[array_rand($templates)];
        
        return str_replace(['{product}', '{category}'], [
            $product->name,
            strtolower($category->name)
        ], $template);
    }

    /**
     * Generate detailed product description
     */
    private function generateProductLongDescription(Product $product, Category $category): string
    {
        $features = $this->getProductFeatures($product, $category);
        $materials = $this->getProductMaterials($category);
        $care = $this->getCareInstructions($category);
        
        $description = "**About This Product**\n\n";
        $description .= "The {$product->name} represents the perfect fusion of contemporary style and exceptional quality. ";
        $description .= "Designed for the modern individual who values both fashion and functionality, this {$category->name} piece ";
        $description .= "is crafted to elevate your everyday wardrobe.\n\n";
        
        $description .= "**Key Features:**\n";
        foreach ($features as $feature) {
            $description .= "• {$feature}\n";
        }
        
        $description .= "\n**Materials & Quality:**\n";
        $description .= "Crafted from {$materials}, this product ensures durability and comfort. ";
        $description .= "Our commitment to quality means every piece undergoes rigorous quality checks.\n\n";
        
        $description .= "**Care Instructions:**\n{$care}\n\n";
        
        $description .= "**Why Choose SJ Fashion Hub?**\n";
        $description .= "• Premium quality materials\n";
        $description .= "• Contemporary designs\n";
        $description .= "• Comfortable fit\n";
        $description .= "• Easy returns & exchanges\n";
        $description .= "• Fast & secure delivery\n\n";
        
        $description .= "Perfect for both casual and formal occasions, this {$category->name} piece is a versatile addition to any wardrobe.";
        
        return $description;
    }

    /**
     * Generate product keywords
     */
    private function generateProductKeywords(Product $product, Category $category): string
    {
        $keywords = [
            strtolower($product->name),
            strtolower($category->name),
            'fashion',
            'clothing',
            'style',
            'trendy',
            'premium',
            'quality',
            'comfortable',
            'modern',
            'online shopping',
            'sj fashion hub',
            'buy online',
            'best price',
        ];
        
        // Add category-specific keywords
        $categoryKeywords = $this->getCategorySpecificKeywords($category);
        $keywords = array_merge($keywords, $categoryKeywords);
        
        // Remove duplicates and return as comma-separated string
        return implode(', ', array_unique($keywords));
    }

    /**
     * Generate category SEO title
     */
    private function generateCategoryTitle(Category $category, string $brandName): string
    {
        $templates = [
            "{category} Collection - Premium Fashion | {brand}",
            "Shop {category} Online - Latest Trends | {brand}",
            "Buy {category} - Quality Fashion at Best Prices | {brand}",
            "{category} - Stylish & Comfortable Clothing | {brand}",
        ];
        
        $template = $templates[array_rand($templates)];
        
        $title = str_replace(['{category}', '{brand}'], [
            $category->name,
            $brandName
        ], $template);
        
        return Str::limit($title, 58, '');
    }

    /**
     * Generate category meta description
     */
    private function generateCategoryMetaDescription(Category $category, string $brandName): string
    {
        $productCount = $category->products()->active()->count();
        
        $templates = [
            "Explore our {category} collection at {brand}. {count}+ premium quality products with free shipping on orders above ₹999. Shop now!",
            "Discover stylish {category} at {brand}. Browse {count}+ trendy items with easy returns and fast delivery. Quality guaranteed!",
            "Shop {category} online at {brand}. {count}+ fashionable products at best prices. Free shipping, easy returns, secure payment.",
        ];
        
        $template = $templates[array_rand($templates)];
        
        $description = str_replace(['{category}', '{brand}', '{count}'], [
            $category->name,
            $brandName,
            $productCount
        ], $template);
        
        return Str::limit($description, 158, '');
    }

    /**
     * Generate category description
     */
    private function generateCategoryDescription(Category $category): string
    {
        return "Discover our premium {$category->name} collection featuring the latest trends and timeless classics. " .
               "Each piece is carefully selected to offer the perfect blend of style, comfort, and quality. " .
               "From everyday essentials to statement pieces, find everything you need to elevate your wardrobe.";
    }

    /**
     * Generate category keywords
     */
    private function generateCategoryKeywords(Category $category): string
    {
        $keywords = [
            strtolower($category->name),
            'fashion',
            'clothing',
            'online shopping',
            'trendy',
            'stylish',
            'premium',
            'quality',
            'sj fashion hub',
            'buy online',
            'best price',
            'free shipping',
        ];
        
        $categoryKeywords = $this->getCategorySpecificKeywords($category);
        $keywords = array_merge($keywords, $categoryKeywords);
        
        return implode(', ', array_unique($keywords));
    }

    /**
     * Get product features based on category
     */
    private function getProductFeatures(Product $product, Category $category): array
    {
        $baseFeatures = [
            'Premium quality materials',
            'Comfortable fit',
            'Durable construction',
            'Easy care instructions',
            'Versatile styling options',
        ];
        
        // Add category-specific features
        $categoryFeatures = match(strtolower($category->name)) {
            'shirts', 'mens shirts', 'womens shirts' => [
                'Wrinkle-resistant fabric',
                'Breathable material',
                'Classic collar design',
                'Perfect for formal and casual wear',
            ],
            't-shirts', 'mens t-shirts', 'womens t-shirts' => [
                'Soft cotton blend',
                'Pre-shrunk fabric',
                'Reinforced seams',
                'Fade-resistant colors',
            ],
            'jeans', 'mens jeans', 'womens jeans' => [
                'Stretch denim for comfort',
                'Reinforced stress points',
                'Classic five-pocket design',
                'Available in multiple washes',
            ],
            'dresses', 'womens dresses' => [
                'Flattering silhouette',
                'Lined for comfort',
                'Easy-care fabric',
                'Perfect for special occasions',
            ],
            default => []
        };
        
        return array_merge($baseFeatures, $categoryFeatures);
    }

    /**
     * Get materials based on category
     */
    private function getProductMaterials(Category $category): string
    {
        return match(strtolower($category->name)) {
            'shirts', 'mens shirts', 'womens shirts' => 'premium cotton blend with wrinkle-resistant finish',
            't-shirts', 'mens t-shirts', 'womens t-shirts' => 'soft cotton blend for maximum comfort',
            'jeans', 'mens jeans', 'womens jeans' => 'high-quality denim with stretch for comfort',
            'dresses', 'womens dresses' => 'carefully selected fabrics for comfort and style',
            default => 'premium quality materials'
        };
    }

    /**
     * Get care instructions based on category
     */
    private function getCareInstructions(Category $category): string
    {
        return match(strtolower($category->name)) {
            'shirts', 'mens shirts', 'womens shirts' => 'Machine wash cold, tumble dry low, iron if needed',
            't-shirts', 'mens t-shirts', 'womens t-shirts' => 'Machine wash cold, tumble dry low, do not bleach',
            'jeans', 'mens jeans', 'womens jeans' => 'Machine wash cold inside out, tumble dry low, iron if needed',
            'dresses', 'womens dresses' => 'Follow care label instructions, dry clean recommended for best results',
            default => 'Follow care label instructions for best results'
        };
    }

    /**
     * Get category-specific keywords
     */
    private function getCategorySpecificKeywords(Category $category): array
    {
        return match(strtolower($category->name)) {
            'mens fashion', 'mens shirts', 'mens t-shirts', 'mens jeans' => [
                'mens clothing', 'mens fashion', 'mens wear', 'men style', 'casual wear', 'formal wear'
            ],
            'womens fashion', 'womens shirts', 'womens t-shirts', 'womens jeans', 'womens dresses' => [
                'womens clothing', 'womens fashion', 'womens wear', 'ladies fashion', 'women style'
            ],
            'shirts' => ['formal shirts', 'casual shirts', 'cotton shirts', 'office wear'],
            't-shirts' => ['casual tees', 'cotton t-shirts', 'graphic tees', 'basic tees'],
            'jeans' => ['denim', 'casual pants', 'skinny jeans', 'straight fit'],
            'dresses' => ['party dresses', 'casual dresses', 'formal dresses', 'evening wear'],
            default => []
        };
    }

    /**
     * Generate structured data for product
     */
    private function generateProductStructuredData(Product $product): array
    {
        return [
            '@context' => 'https://schema.org/',
            '@type' => 'Product',
            'name' => $product->name,
            'description' => $product->short_description ?? $product->description,
            'sku' => $product->sku,
            'brand' => [
                '@type' => 'Brand',
                'name' => 'SJ Fashion Hub'
            ],
            'offers' => [
                '@type' => 'Offer',
                'price' => $product->sale_price ?? $product->price,
                'priceCurrency' => 'INR',
                'availability' => $product->stock_quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
                'seller' => [
                    '@type' => 'Organization',
                    'name' => 'SJ Fashion Hub'
                ]
            ],
            'category' => $product->category->name,
        ];
    }
}
