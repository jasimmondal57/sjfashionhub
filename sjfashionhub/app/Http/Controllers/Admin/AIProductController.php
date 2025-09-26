<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class AIProductController extends Controller
{
    public function generateDetails(Request $request)
    {
        try {
            $validated = $request->validate([
                'basic_name' => 'required|string|max:255',
                'brand' => 'required|string|max:255',
                'category_id' => 'required|exists:categories,id',
                'size' => 'nullable|string|max:50',
                'color' => 'nullable|string|max:50',
                'material' => 'nullable|string|max:100',
                'pattern' => 'nullable|string|max:100',
                'gender' => 'nullable|in:male,female,unisex',
                'age_group' => 'nullable|in:adult,kids,toddler,infant,newborn',
                'mrp' => 'required|numeric|min:0',
                'sale_price' => 'nullable|numeric|min:0',
            ]);

            // Get category information
            $category = Category::find($validated['category_id']);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            // Generate AI-powered product details
            $aiDetails = $this->generateAIDetails($validated, $category);

            return response()->json([
                'success' => true,
                'data' => $aiDetails
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    private function generateAIDetails($input, $category)
    {
        // Extract input data
        $basicName = $input['basic_name'];
        $brand = $input['brand'];
        $size = $input['size'] ?? '';
        $color = $input['color'] ?? '';
        $material = $input['material'] ?? '';
        $pattern = $input['pattern'] ?? '';
        $gender = $input['gender'] ?? '';
        $ageGroup = $input['age_group'] ?? '';
        $mrp = $input['mrp'];
        $salePrice = $input['sale_price'] ?? $mrp;
        // Auto-generate key features based on product attributes
        $keyFeatures = $this->generateKeyFeatures($basicName, $material, $color, $size, $pattern, $category->name);

        // Auto-generate target keywords for SEO
        $targetKeywords = $this->generateTargetKeywords($basicName, $brand, $category->name, $material, $color, $gender, $ageGroup);

        // Generate optimized product name (Brand + Product Type + Key Feature + Color/Size)
        $optimizedName = $this->generateOptimizedName($brand, $basicName, $color, $size, $material, $category->name);

        // Generate comprehensive descriptions
        $descriptions = $this->generateDescriptions($optimizedName, $brand, $category, $material, $color, $size, $pattern, $keyFeatures, $gender, $ageGroup);

        // Generate SEO content
        $seoContent = $this->generateSEOContent($optimizedName, $brand, $category, $targetKeywords, $descriptions['short']);
        
        // Generate Google Merchant Center details
        $googleMerchantDetails = $this->generateGoogleMerchantDetails($category, $material, $color, $size, $pattern, $gender, $ageGroup);
        
        // Generate additional product details
        $additionalDetails = $this->generateAdditionalDetails($category, $material, $mrp, $salePrice);

        return [
            // Basic Information
            'name' => $optimizedName,
            'brand' => $brand,
            'description' => $descriptions['short'],
            'long_description' => $descriptions['long'],
            'price' => $mrp,
            'sale_price' => $salePrice != $mrp ? $salePrice : null,
            'compare_at_price' => $salePrice != $mrp ? $mrp : null,
            
            // Google Merchant Center
            'google_product_category' => $googleMerchantDetails['category'],
            'condition' => 'new',
            'availability' => 'in_stock',
            'age_group' => $ageGroup ?: $googleMerchantDetails['age_group'],
            'gender' => $gender ?: $googleMerchantDetails['gender'],
            'size' => $size,
            'color' => $color,
            'material' => $material,
            'pattern' => $pattern,
            'product_type' => $googleMerchantDetails['product_type'],
            
            // SEO Content
            'seo_title' => $seoContent['title'],
            'seo_description' => $seoContent['description'],
            'seo_keywords' => $seoContent['keywords'],
            'tags' => $seoContent['tags'],
            
            // Additional Details
            'weight' => $additionalDetails['weight'],
            'dimensions' => $additionalDetails['dimensions'],
            'shipping_weight' => $additionalDetails['shipping_weight'],
            'shipping_cost' => $additionalDetails['shipping_cost'],
            'has_warranty' => $additionalDetails['has_warranty'],
            'warranty_period' => $additionalDetails['warranty_period'],
            'has_return_policy' => true,
            'return_days' => 30,
            'low_stock_threshold' => 5,
            'track_quantity' => true,
            'stock_status' => 'in_stock',
            'price_includes_tax' => true,
            'tax_rate' => 18.0, // GST rate for India
            
            // Meta Pixel
            'facebook_product_id' => Str::slug($optimizedName) . '-' . time(),
            'cost_of_goods' => round($salePrice * 0.6, 2), // Estimated 40% margin
        ];
    }

    private function generateOptimizedName($brand, $basicName, $color, $size, $material, $categoryName)
    {
        $parts = [$brand];
        
        // Add product type
        $parts[] = $basicName;
        
        // Add key features
        if ($material) {
            $parts[] = $material;
        }
        
        // Add color and size
        $attributes = [];
        if ($color) $attributes[] = $color;
        if ($size) $attributes[] = $size;
        
        if (!empty($attributes)) {
            $parts[] = implode(' ', $attributes);
        }
        
        $name = implode(' ', $parts);
        
        // Ensure it's under 70 characters for Google
        if (strlen($name) > 70) {
            $name = substr($name, 0, 67) . '...';
        }
        
        return $name;
    }

    private function generateDescriptions($name, $brand, $category, $material, $color, $size, $pattern, $keyFeatures, $gender, $ageGroup)
    {
        // Short description (for product listing)
        $shortDesc = "Premium {$name} from {$brand}. ";
        
        if ($material) {
            $shortDesc .= "Made with high-quality {$material}. ";
        }
        
        if ($color) {
            $shortDesc .= "Available in beautiful {$color} color. ";
        }
        
        if ($keyFeatures) {
            $shortDesc .= $keyFeatures . ". ";
        }
        
        $shortDesc .= "Perfect for {$category->name} enthusiasts. Fast shipping and easy returns.";
        
        // Long description (detailed)
        $longDesc = "**{$name}** - The Perfect Choice for Style and Comfort\n\n";
        $longDesc .= "Discover the exceptional quality of {$brand}'s latest {$category->name} collection. ";
        $longDesc .= "This {$name} is designed to meet the highest standards of fashion and functionality.\n\n";
        
        $longDesc .= "**Key Features:**\n";
        if ($material) {
            $longDesc .= "• Premium {$material} construction for durability and comfort\n";
        }
        if ($color) {
            $longDesc .= "• Stunning {$color} color that complements any style\n";
        }
        if ($size) {
            $longDesc .= "• Available in {$size} size for the perfect fit\n";
        }
        if ($pattern) {
            $longDesc .= "• Elegant {$pattern} pattern for a sophisticated look\n";
        }
        
        $longDesc .= "• High-quality craftsmanship and attention to detail\n";
        $longDesc .= "• Easy care and maintenance\n";
        $longDesc .= "• Suitable for both casual and formal occasions\n\n";
        
        if ($gender) {
            $longDesc .= "**Perfect For:** {$gender} ";
            if ($ageGroup) {
                $longDesc .= "({$ageGroup}) ";
            }
            $longDesc .= "who appreciate quality and style.\n\n";
        }
        
        $longDesc .= "**Why Choose {$brand}?**\n";
        $longDesc .= "• Trusted brand with years of experience\n";
        $longDesc .= "• Commitment to quality and customer satisfaction\n";
        $longDesc .= "• Sustainable and ethical manufacturing practices\n";
        $longDesc .= "• 30-day return policy and warranty coverage\n\n";
        
        $longDesc .= "**Care Instructions:**\n";
        if ($material) {
            if (stripos($material, 'cotton') !== false) {
                $longDesc .= "• Machine wash cold with like colors\n• Tumble dry low heat\n• Iron on medium heat if needed\n";
            } elseif (stripos($material, 'silk') !== false) {
                $longDesc .= "• Dry clean only\n• Store in cool, dry place\n• Avoid direct sunlight\n";
            } else {
                $longDesc .= "• Follow care label instructions\n• Gentle wash recommended\n• Air dry for best results\n";
            }
        }
        
        $longDesc .= "\nOrder now and experience the perfect blend of style, comfort, and quality!";
        
        return [
            'short' => $shortDesc,
            'long' => $longDesc
        ];
    }

    private function generateSEOContent($name, $brand, $category, $targetKeywords, $shortDescription)
    {
        // SEO Title (under 60 characters)
        $seoTitle = "{$name} | {$brand} | Best {$category->name}";
        if (strlen($seoTitle) > 60) {
            $seoTitle = substr($seoTitle, 0, 57) . '...';
        }
        
        // SEO Description (under 160 characters)
        $seoDescription = substr($shortDescription, 0, 157) . '...';
        
        // Generate keywords
        $keywords = [];
        $keywords[] = strtolower($name);
        $keywords[] = strtolower($brand);
        $keywords[] = strtolower($category->name);
        $keywords[] = "buy {$category->name} online";
        $keywords[] = "{$brand} {$category->name}";
        $keywords[] = "premium {$category->name}";
        $keywords[] = "best {$category->name}";
        
        if ($targetKeywords) {
            $additionalKeywords = explode(',', $targetKeywords);
            foreach ($additionalKeywords as $keyword) {
                $keywords[] = trim(strtolower($keyword));
            }
        }
        
        // Generate tags for internal use
        $tags = [];
        $tags[] = $brand;
        $tags[] = $category->name;
        $tags[] = 'premium';
        $tags[] = 'quality';
        $tags[] = 'fashion';
        $tags[] = 'style';
        
        return [
            'title' => $seoTitle,
            'description' => $seoDescription,
            'keywords' => implode(', ', array_unique($keywords)),
            'tags' => array_unique($tags)
        ];
    }

    private function generateGoogleMerchantDetails($category, $material, $color, $size, $pattern, $gender, $ageGroup)
    {
        // Map category to Google Product Category
        $googleCategories = [
            'clothing' => 'Apparel & Accessories > Clothing',
            'shoes' => 'Apparel & Accessories > Shoes',
            'accessories' => 'Apparel & Accessories > Clothing Accessories',
            'bags' => 'Apparel & Accessories > Handbags, Wallets & Cases',
            'jewelry' => 'Apparel & Accessories > Jewelry',
            'watches' => 'Apparel & Accessories > Jewelry > Watches',
        ];
        
        $categoryName = strtolower($category->name);
        $googleCategory = $googleCategories[$categoryName] ?? 'Apparel & Accessories';
        
        // Determine age group if not provided
        if (!$ageGroup) {
            $ageGroup = 'adult'; // Default
        }
        
        // Determine gender if not provided
        if (!$gender) {
            $gender = 'unisex'; // Default
        }
        
        return [
            'category' => $googleCategory,
            'product_type' => $category->name,
            'age_group' => $ageGroup,
            'gender' => $gender
        ];
    }

    private function generateAdditionalDetails($category, $material, $mrp, $salePrice)
    {
        // Estimate weight based on category and material
        $weight = 0.5; // Default 500g
        
        if (stripos($category->name, 'shoe') !== false) {
            $weight = 1.2;
        } elseif (stripos($category->name, 'bag') !== false) {
            $weight = 0.8;
        } elseif (stripos($category->name, 'jewelry') !== false) {
            $weight = 0.1;
        }
        
        // Estimate dimensions
        $dimensions = '30 x 25 x 5 cm'; // Default
        
        if (stripos($category->name, 'shoe') !== false) {
            $dimensions = '35 x 25 x 15 cm';
        } elseif (stripos($category->name, 'bag') !== false) {
            $dimensions = '40 x 30 x 20 cm';
        }
        
        // Shipping weight (including packaging)
        $shippingWeight = $weight + 0.2;
        
        // Shipping cost based on weight
        $shippingCost = 0; // Free shipping
        if ($salePrice < 500) {
            $shippingCost = 50;
        }
        
        // Warranty based on price
        $hasWarranty = $salePrice > 1000;
        $warrantyPeriod = $hasWarranty ? '1 year' : null;
        
        return [
            'weight' => $weight,
            'dimensions' => $dimensions,
            'shipping_weight' => $shippingWeight,
            'shipping_cost' => $shippingCost,
            'has_warranty' => $hasWarranty,
            'warranty_period' => $warrantyPeriod
        ];
    }

    private function generateKeyFeatures($productName, $material, $color, $size, $pattern, $categoryName)
    {
        $features = [];

        // Material-based features
        if ($material) {
            $materialFeatures = [
                'cotton' => ['Breathable and comfortable', 'Soft texture', 'Easy to wash', 'Durable fabric'],
                'silk' => ['Luxurious feel', 'Natural shine', 'Temperature regulating', 'Elegant drape'],
                'polyester' => ['Wrinkle resistant', 'Quick dry', 'Color retention', 'Durable'],
                'wool' => ['Warm and cozy', 'Natural insulation', 'Moisture wicking', 'Premium quality'],
                'leather' => ['Premium leather construction', 'Long-lasting durability', 'Classic style', 'Ages beautifully'],
                'denim' => ['Classic denim fabric', 'Versatile styling', 'Durable construction', 'Timeless appeal'],
                'linen' => ['Lightweight and airy', 'Natural fiber', 'Perfect for summer', 'Relaxed fit']
            ];

            $materialLower = strtolower($material);
            foreach ($materialFeatures as $mat => $matFeatures) {
                if (stripos($materialLower, $mat) !== false) {
                    $features = array_merge($features, $matFeatures);
                    break;
                }
            }
        }

        // Category-based features
        $categoryFeatures = [
            'clothing' => ['Comfortable fit', 'Stylish design', 'Versatile wear', 'Quality stitching'],
            'shoes' => ['Comfortable sole', 'Non-slip grip', 'Breathable design', 'Durable construction'],
            'accessories' => ['Elegant design', 'Perfect finishing', 'Versatile styling', 'Premium quality'],
            'bags' => ['Spacious compartments', 'Secure closures', 'Comfortable handles', 'Stylish design'],
            'jewelry' => ['Elegant craftsmanship', 'Tarnish resistant', 'Comfortable wear', 'Timeless design'],
            'watches' => ['Precise movement', 'Water resistant', 'Scratch resistant', 'Elegant design']
        ];

        $categoryLower = strtolower($categoryName);
        foreach ($categoryFeatures as $cat => $catFeatures) {
            if (stripos($categoryLower, $cat) !== false) {
                $features = array_merge($features, $catFeatures);
                break;
            }
        }

        // Color-based features
        if ($color) {
            $features[] = "Beautiful {$color} color";
            $features[] = "Fade-resistant color";
        }

        // Size-based features
        if ($size) {
            $features[] = "Perfect {$size} size fit";
            $features[] = "True to size";
        }

        // Pattern-based features
        if ($pattern && strtolower($pattern) !== 'solid') {
            $features[] = "Attractive {$pattern} pattern";
            $features[] = "Eye-catching design";
        }

        // General quality features
        $generalFeatures = [
            'Premium quality construction',
            'Attention to detail',
            'Modern styling',
            'Easy care and maintenance',
            'Perfect for daily wear',
            'Great value for money',
            'Suitable for all occasions',
            'Comfortable all-day wear'
        ];

        $features = array_merge($features, $generalFeatures);

        // Remove duplicates and limit to 8 features
        $features = array_unique($features);
        $features = array_slice($features, 0, 8);

        return implode(', ', $features);
    }

    private function generateTargetKeywords($productName, $brand, $categoryName, $material, $color, $gender, $ageGroup)
    {
        $keywords = [];

        // Primary keywords
        $keywords[] = strtolower($productName);
        $keywords[] = strtolower($brand . ' ' . $productName);
        $keywords[] = strtolower($categoryName);
        $keywords[] = strtolower($brand . ' ' . $categoryName);

        // Material keywords
        if ($material) {
            $keywords[] = strtolower($material . ' ' . $productName);
            $keywords[] = strtolower($material . ' ' . $categoryName);
            $keywords[] = "best " . strtolower($material . ' ' . $categoryName);
        }

        // Color keywords
        if ($color) {
            $keywords[] = strtolower($color . ' ' . $productName);
            $keywords[] = strtolower($color . ' ' . $categoryName);
        }

        // Gender keywords
        if ($gender) {
            $keywords[] = strtolower($gender . ' ' . $categoryName);
            $keywords[] = strtolower($gender . ' ' . $productName);
            if ($gender === 'female') {
                $keywords[] = "women " . strtolower($categoryName);
                $keywords[] = "ladies " . strtolower($categoryName);
            } elseif ($gender === 'male') {
                $keywords[] = "men " . strtolower($categoryName);
                $keywords[] = "mens " . strtolower($categoryName);
            }
        }

        // Age group keywords
        if ($ageGroup) {
            $keywords[] = strtolower($ageGroup . ' ' . $categoryName);
            if ($ageGroup === 'kids') {
                $keywords[] = "children " . strtolower($categoryName);
                $keywords[] = "kids " . strtolower($productName);
            }
        }

        // Commercial keywords
        $keywords[] = "buy " . strtolower($categoryName) . " online";
        $keywords[] = "best " . strtolower($categoryName);
        $keywords[] = "premium " . strtolower($categoryName);
        $keywords[] = "quality " . strtolower($categoryName);
        $keywords[] = "affordable " . strtolower($categoryName);
        $keywords[] = strtolower($categoryName) . " for sale";
        $keywords[] = "cheap " . strtolower($categoryName);
        $keywords[] = "discount " . strtolower($categoryName);
        $keywords[] = strtolower($categoryName) . " online shopping";
        $keywords[] = "latest " . strtolower($categoryName);
        $keywords[] = "trendy " . strtolower($categoryName);
        $keywords[] = "stylish " . strtolower($categoryName);

        // Brand specific keywords
        $keywords[] = strtolower($brand) . " collection";
        $keywords[] = strtolower($brand) . " official";
        $keywords[] = strtolower($brand) . " original";
        $keywords[] = "authentic " . strtolower($brand);

        // Location-based keywords (for India)
        $keywords[] = strtolower($categoryName) . " india";
        $keywords[] = strtolower($categoryName) . " online india";
        $keywords[] = "buy " . strtolower($categoryName) . " india";

        // Seasonal keywords
        $currentMonth = date('n');
        if ($currentMonth >= 3 && $currentMonth <= 6) { // Summer
            $keywords[] = "summer " . strtolower($categoryName);
        } elseif ($currentMonth >= 10 && $currentMonth <= 2) { // Winter
            $keywords[] = "winter " . strtolower($categoryName);
        }

        // Festival keywords (for India)
        $keywords[] = strtolower($categoryName) . " diwali";
        $keywords[] = strtolower($categoryName) . " festival";
        $keywords[] = "ethnic " . strtolower($categoryName);

        // Remove duplicates and clean up
        $keywords = array_unique($keywords);
        $keywords = array_filter($keywords, function($keyword) {
            return strlen(trim($keyword)) > 2;
        });

        // Limit to 25 keywords for optimal SEO
        $keywords = array_slice($keywords, 0, 25);

        return implode(', ', $keywords);
    }
}
