<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'business_name',
        'company_name',
        'company_description',
        'contact_info',
        'social_links',
        'quick_links',
        'customer_service_links',
        'categories_links',
        'additional_links',
        'copyright_text',
        'payment_methods',
        'payment_icons',
        'show_payment_icons',
        'app_download_links',
        'show_app_downloads',
        'newsletter_text',
        'show_newsletter',
        'show_payment_methods',
        'quick_links_title',
        'customer_service_title',
        'categories_title',
        'additional_title',
        'made_in_text',
        'designed_by_text',
        'company_name',
        'company_url',
        'background_color',
        'text_color',
        'is_active',
    ];

    protected $casts = [
        'contact_info' => 'array',
        'social_links' => 'array',
        'quick_links' => 'array',
        'customer_service_links' => 'array',
        'categories_links' => 'array',
        'additional_links' => 'array',
        'payment_methods' => 'array',
        'payment_icons' => 'array',
        'app_download_links' => 'array',
        'show_newsletter' => 'boolean',
        'show_social_links' => 'boolean',
        'show_payment_methods' => 'boolean',
        'show_payment_icons' => 'boolean',
        'show_app_downloads' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the active footer settings
     */
    public static function getActiveSettings()
    {
        return static::where('is_active', true)->first() ?? static::getDefaultSettings();
    }

    /**
     * Get default footer settings
     */
    public static function getDefaultSettings()
    {
        return (object) [
            'business_name' => 'SJ Fashion Hub',
            'company_name' => 'JM Software',
            'company_description' => 'At SJ Fashion Hub, we believe that style is more than just clothing—it\'s a statement. Our collection is designed for the modern person who values quality, comfort, and timeless fashion.',
            'contact_info' => [
                'phone' => '+1 (555) 123-4567',
                'email' => 'info@sjfashionhub.com',
                'address' => '123 Fashion Street, Style City, SC 12345'
            ],
            'social_links' => [
                ['platform' => 'Facebook', 'url' => '#', 'icon' => 'facebook'],
                ['platform' => 'Instagram', 'url' => '#', 'icon' => 'instagram'],
                ['platform' => 'Twitter', 'url' => '#', 'icon' => 'twitter'],
                ['platform' => 'YouTube', 'url' => '#', 'icon' => 'youtube'],
            ],
            'quick_links' => [
                ['text' => 'About Us', 'url' => '/about'],
                ['text' => 'Contact', 'url' => '/contact'],
                ['text' => 'Privacy Policy', 'url' => '/privacy'],
                ['text' => 'Terms of Service', 'url' => '/terms'],
            ],
            'customer_service_links' => [
                ['text' => 'FAQ', 'url' => '/faq'],
                ['text' => 'Shipping Info', 'url' => '/shipping'],
                ['text' => 'Returns', 'url' => '/returns'],
                ['text' => 'Size Guide', 'url' => '/size-guide'],
            ],
            'categories_links' => [
                ['text' => 'Men\'s Fashion', 'url' => '/categories/mens-fashion'],
                ['text' => 'Women\'s Fashion', 'url' => '/categories/womens-fashion'],
                ['text' => 'Accessories', 'url' => '/categories/accessories'],
                ['text' => 'Footwear', 'url' => '/categories/footwear'],
            ],
            'additional_links' => [
                ['text' => 'Blog', 'url' => '/blog'],
                ['text' => 'News', 'url' => '/news'],
                ['text' => 'Careers', 'url' => '/careers'],
                ['text' => 'Press', 'url' => '/press'],
            ],
            'copyright_text' => '© ' . date('Y') . ' SJ Fashion Hub | All rights reserved',
            'payment_methods' => [
                ['name' => 'Visa', 'icon' => 'visa'],
                ['name' => 'Mastercard', 'icon' => 'mastercard'],
                ['name' => 'PayPal', 'icon' => 'paypal'],
                ['name' => 'Apple Pay', 'icon' => 'apple-pay'],
            ],
            'payment_icons' => [
                ['name' => 'UPI', 'icon' => 'upi', 'url' => '/payment/upi', 'image_type' => 'auto', 'custom_image' => null],
                ['name' => 'Visa', 'icon' => 'visa', 'url' => '/payment/visa', 'image_type' => 'auto', 'custom_image' => null],
                ['name' => 'Mastercard', 'icon' => 'mastercard', 'url' => '/payment/mastercard', 'image_type' => 'auto', 'custom_image' => null],
                ['name' => 'RuPay', 'icon' => 'rupay', 'url' => '/payment/rupay', 'image_type' => 'auto', 'custom_image' => null],
                ['name' => 'Paytm', 'icon' => 'paytm', 'url' => '/payment/paytm', 'image_type' => 'auto', 'custom_image' => null],
                ['name' => 'PhonePe', 'icon' => 'phonepe', 'url' => '/payment/phonepe', 'image_type' => 'auto', 'custom_image' => null],
                ['name' => 'Google Pay', 'icon' => 'googlepay', 'url' => '/payment/googlepay', 'image_type' => 'auto', 'custom_image' => null],
                ['name' => 'BHIM', 'icon' => 'bhim', 'url' => '/payment/bhim', 'image_type' => 'auto', 'custom_image' => null],
            ],
            'show_payment_icons' => true,
            'app_download_links' => [
                ['platform' => 'Android', 'url' => 'https://play.google.com/store/apps/details?id=com.sjfashionhub', 'icon' => 'playstore'],
                ['platform' => 'iOS', 'url' => 'https://apps.apple.com/app/sjfashionhub/id123456789', 'icon' => 'appstore'],
            ],
            'show_app_downloads' => true,
            'newsletter_text' => 'Subscribe to our newsletter for the latest fashion trends and exclusive offers.',
            'show_newsletter' => true,
            'show_social_links' => true,
            'show_payment_methods' => true,
            'made_in_text' => 'Made with ❤️ in India',
            'designed_by_text' => 'Designed By',
            'company_name' => 'JM Software',
            'company_url' => 'https://jmsoftware.shop/',
            'background_color' => '#ffffff',
            'text_color' => '#374151',
            'is_active' => true,
        ];
    }

    /**
     * Scope for active settings
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get all available pages and categories for dropdown
     */
    public static function getAvailablePages()
    {
        $pages = [
            'Static Pages' => [
                '/' => 'Home',
                '/about' => 'About Us',
                '/contact' => 'Contact Us',
                '/privacy' => 'Privacy Policy',
                '/terms' => 'Terms of Service',
                '/faq' => 'FAQ',
                '/shipping' => 'Shipping Info',
                '/returns' => 'Returns Policy',
                '/size-guide' => 'Size Guide',
                '/blog' => 'Blog',
                '/news' => 'News',
                '/careers' => 'Careers',
                '/press' => 'Press',
            ],
            'Shop Pages' => [
                '/products' => 'All Products',
                '/categories' => 'All Categories',
                '/brands' => 'All Brands',
                '/sale' => 'Sale Items',
                '/new-arrivals' => 'New Arrivals',
                '/featured' => 'Featured Products',
            ]
        ];

        // Add categories if they exist
        try {
            $categories = \App\Models\Category::active()->ordered()->get();
            if ($categories->count() > 0) {
                $pages['Categories'] = [];
                foreach ($categories as $category) {
                    $pages['Categories']['/categories/' . $category->slug] = $category->name;
                }
            }
        } catch (\Exception $e) {
            // Categories table might not exist yet or no data
            $pages['Categories'] = [
                '/categories/mens-fashion' => 'Men\'s Fashion',
                '/categories/womens-fashion' => 'Women\'s Fashion',
                '/categories/accessories' => 'Accessories',
                '/categories/footwear' => 'Footwear',
            ];
        }

        // Add products if they exist
        try {
            $products = \App\Models\Product::active()->limit(10)->get();
            if ($products->count() > 0) {
                $pages['Popular Products'] = [];
                foreach ($products as $product) {
                    $pages['Popular Products']['/products/' . $product->slug] = $product->name;
                }
            }
        } catch (\Exception $e) {
            // Products table might not exist yet or no data
            $pages['Popular Products'] = [
                '/products/sample-product-1' => 'Sample Product 1',
                '/products/sample-product-2' => 'Sample Product 2',
                '/products/sample-product-3' => 'Sample Product 3',
            ];
        }

        return $pages;
    }

    /**
     * Get payment method related pages for dropdown
     */
    public static function getPaymentPages()
    {
        return [
            'Payment Methods' => [
                '/payment/upi' => 'UPI Payment',
                '/payment/visa' => 'Visa Cards',
                '/payment/mastercard' => 'Mastercard',
                '/payment/rupay' => 'RuPay Cards',
                '/payment/paytm' => 'Paytm Wallet',
                '/payment/phonepe' => 'PhonePe',
                '/payment/googlepay' => 'Google Pay',
                '/payment/bhim' => 'BHIM UPI',
                '/payment/netbanking' => 'Net Banking',
                '/payment/debitcard' => 'Debit Cards',
                '/payment/creditcard' => 'Credit Cards',
                '/payment/wallet' => 'Digital Wallets',
            ],
            'Payment Info' => [
                '/payment/security' => 'Payment Security',
                '/payment/terms' => 'Payment Terms',
                '/payment/refund' => 'Refund Policy',
                '/payment/emi' => 'EMI Options',
                '/payment/offers' => 'Payment Offers',
                '/payment/help' => 'Payment Help',
            ]
        ];
    }
}
