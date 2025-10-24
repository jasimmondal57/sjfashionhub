<?php

// Bootstrap Laravel
require_once __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Page;

// FAQ Page Content
$faqContent = <<<'HTML'
<div class="max-w-4xl mx-auto">
    <h1 class="text-4xl font-bold text-gray-900 mb-8">Frequently Asked Questions</h1>
    
    <div class="space-y-6">
        <!-- Ordering & Payment -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Ordering & Payment</h2>
            
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">How do I place an order?</h3>
                    <p class="text-gray-600">Browse our products, select your desired items, choose size and quantity, add to cart, and proceed to checkout. Fill in your shipping details and select your preferred payment method to complete your order.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">What payment methods do you accept?</h3>
                    <p class="text-gray-600">We accept Cash on Delivery (COD), Credit/Debit Cards, UPI, Net Banking, and Digital Wallets. All online payments are processed securely through our payment gateway.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Is it safe to use my credit card on your website?</h3>
                    <p class="text-gray-600">Yes, absolutely! We use industry-standard SSL encryption to protect your payment information. We never store your complete card details on our servers.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Can I modify or cancel my order?</h3>
                    <p class="text-gray-600">You can modify or cancel your order within 1 hour of placing it. Please contact our customer support immediately. Once the order is processed, modifications may not be possible.</p>
                </div>
            </div>
        </div>
        
        <!-- Shipping & Delivery -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Shipping & Delivery</h2>
            
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">How long does delivery take?</h3>
                    <p class="text-gray-600">Standard delivery takes 3-7 business days depending on your location. Metro cities typically receive orders within 3-4 days, while remote areas may take up to 7 days.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Do you ship internationally?</h3>
                    <p class="text-gray-600">Currently, we only ship within India. We're working on expanding our services internationally soon.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">How can I track my order?</h3>
                    <p class="text-gray-600">Once your order is shipped, you'll receive a tracking number via email and SMS. You can also track your order by logging into your account and visiting the "My Orders" section.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">What are the shipping charges?</h3>
                    <p class="text-gray-600">Shipping charges vary based on your location and order value. Orders above ₹999 qualify for free shipping. Standard shipping charges range from ₹50-₹100.</p>
                </div>
            </div>
        </div>
        
        <!-- Returns & Exchanges -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Returns & Exchanges</h2>
            
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">What is your return policy?</h3>
                    <p class="text-gray-600">We offer a 7-day return policy from the date of delivery. Products must be unused, unwashed, with original tags attached. Certain items like innerwear and sale items are non-returnable.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">How do I initiate a return?</h3>
                    <p class="text-gray-600">Log into your account, go to "My Orders", select the order you want to return, click "Return Items", choose the reason, and submit. Our team will arrange a pickup within 2-3 business days.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">When will I receive my refund?</h3>
                    <p class="text-gray-600">Refunds are processed within 5-7 business days after we receive and inspect the returned item. The amount will be credited to your original payment method or store credit, as per your preference.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Can I exchange a product?</h3>
                    <p class="text-gray-600">Yes, you can exchange products for a different size or color within 7 days of delivery, subject to availability. Exchange requests are processed similarly to returns.</p>
                </div>
            </div>
        </div>
        
        <!-- Product & Sizing -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Product & Sizing</h2>
            
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">How do I choose the right size?</h3>
                    <p class="text-gray-600">Please refer to our <a href="/size-guide" class="text-blue-600 hover:underline">Size Guide</a> for detailed measurements. Each product page also has a size chart specific to that item.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Are the product colors accurate?</h3>
                    <p class="text-gray-600">We strive to display accurate colors, but slight variations may occur due to screen settings and lighting. Product descriptions include detailed color information.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">How do I care for my garments?</h3>
                    <p class="text-gray-600">Care instructions are provided on the product tag. Generally, we recommend gentle machine wash or hand wash in cold water, and avoiding harsh detergents to maintain fabric quality.</p>
                </div>
            </div>
        </div>
        
        <!-- Account & Support -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-4">Account & Support</h2>
            
            <div class="space-y-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Do I need an account to place an order?</h3>
                    <p class="text-gray-600">No, you can checkout as a guest. However, creating an account allows you to track orders, save addresses, manage wishlists, and enjoy faster checkout.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">How do I reset my password?</h3>
                    <p class="text-gray-600">Click on "Forgot Password" on the login page, enter your registered email, and follow the instructions sent to your email to reset your password.</p>
                </div>
                
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">How can I contact customer support?</h3>
                    <p class="text-gray-600">You can reach us via email, phone, or WhatsApp. Visit our <a href="/contact" class="text-blue-600 hover:underline">Contact Page</a> for all contact details. Our support team is available Monday-Saturday, 10 AM - 7 PM.</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="mt-12 p-6 bg-blue-50 rounded-lg">
        <h3 class="text-xl font-semibold text-gray-900 mb-2">Still have questions?</h3>
        <p class="text-gray-600 mb-4">Can't find the answer you're looking for? Our customer support team is here to help!</p>
        <a href="/contact" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition-colors">
            Contact Support
        </a>
    </div>
</div>
HTML;

// Size Guide Page Content
$sizeGuideContent = <<<'HTML'
<div class="max-w-6xl mx-auto">
    <h1 class="text-4xl font-bold text-gray-900 mb-4">Size Guide</h1>
    <p class="text-lg text-gray-600 mb-8">Find your perfect fit with our comprehensive size guide</p>
    
    <!-- How to Measure -->
    <div class="bg-blue-50 rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">📏 How to Measure</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="font-medium text-gray-900 mb-2">Bust/Chest</h3>
                <p class="text-gray-600 text-sm">Measure around the fullest part of your bust/chest, keeping the tape parallel to the floor.</p>
            </div>
            <div>
                <h3 class="font-medium text-gray-900 mb-2">Waist</h3>
                <p class="text-gray-600 text-sm">Measure around your natural waistline, keeping the tape comfortably loose.</p>
            </div>
            <div>
                <h3 class="font-medium text-gray-900 mb-2">Hips</h3>
                <p class="text-gray-600 text-sm">Measure around the fullest part of your hips, approximately 8 inches below your waist.</p>
            </div>
            <div>
                <h3 class="font-medium text-gray-900 mb-2">Length</h3>
                <p class="text-gray-600 text-sm">Measure from the shoulder seam to the desired length (hem for tops, ankle for bottoms).</p>
            </div>
        </div>
    </div>
    
    <!-- Women's Blouse Size Chart -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">👚 Women's Blouse Size Chart</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Bust (inches)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waist (inches)</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Length (inches)</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <tr><td class="px-6 py-4 whitespace-nowrap font-medium">26</td><td class="px-6 py-4 whitespace-nowrap">26-28</td><td class="px-6 py-4 whitespace-nowrap">22-24</td><td class="px-6 py-4 whitespace-nowrap">14-15</td></tr>
                    <tr><td class="px-6 py-4 whitespace-nowrap font-medium">30</td><td class="px-6 py-4 whitespace-nowrap">30-32</td><td class="px-6 py-4 whitespace-nowrap">26-28</td><td class="px-6 py-4 whitespace-nowrap">15-16</td></tr>
                    <tr><td class="px-6 py-4 whitespace-nowrap font-medium">32</td><td class="px-6 py-4 whitespace-nowrap">32-34</td><td class="px-6 py-4 whitespace-nowrap">28-30</td><td class="px-6 py-4 whitespace-nowrap">15-16</td></tr>
                    <tr><td class="px-6 py-4 whitespace-nowrap font-medium">34</td><td class="px-6 py-4 whitespace-nowrap">34-36</td><td class="px-6 py-4 whitespace-nowrap">30-32</td><td class="px-6 py-4 whitespace-nowrap">16-17</td></tr>
                    <tr><td class="px-6 py-4 whitespace-nowrap font-medium">36</td><td class="px-6 py-4 whitespace-nowrap">36-38</td><td class="px-6 py-4 whitespace-nowrap">32-34</td><td class="px-6 py-4 whitespace-nowrap">16-17</td></tr>
                    <tr><td class="px-6 py-4 whitespace-nowrap font-medium">38</td><td class="px-6 py-4 whitespace-nowrap">38-40</td><td class="px-6 py-4 whitespace-nowrap">34-36</td><td class="px-6 py-4 whitespace-nowrap">17-18</td></tr>
                    <tr><td class="px-6 py-4 whitespace-nowrap font-medium">40</td><td class="px-6 py-4 whitespace-nowrap">40-42</td><td class="px-6 py-4 whitespace-nowrap">36-38</td><td class="px-6 py-4 whitespace-nowrap">17-18</td></tr>
                    <tr><td class="px-6 py-4 whitespace-nowrap font-medium">42</td><td class="px-6 py-4 whitespace-nowrap">42-44</td><td class="px-6 py-4 whitespace-nowrap">38-40</td><td class="px-6 py-4 whitespace-nowrap">18-19</td></tr>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- General Sizing Tips -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <h2 class="text-2xl font-semibold text-gray-900 mb-4">💡 Sizing Tips</h2>
        <ul class="space-y-3 text-gray-600">
            <li class="flex items-start">
                <span class="text-blue-600 mr-2">✓</span>
                <span>If you're between sizes, we recommend sizing up for a more comfortable fit.</span>
            </li>
            <li class="flex items-start">
                <span class="text-blue-600 mr-2">✓</span>
                <span>All measurements are approximate and may vary by ±1 inch due to the nature of the fabric.</span>
            </li>
            <li class="flex items-start">
                <span class="text-blue-600 mr-2">✓</span>
                <span>For blouses, size 38 is our standard size for most products except blouses which come in sizes 26-42.</span>
            </li>
            <li class="flex items-start">
                <span class="text-blue-600 mr-2">✓</span>
                <span>Check the product description for specific sizing information as some items may have different fits.</span>
            </li>
            <li class="flex items-start">
                <span class="text-blue-600 mr-2">✓</span>
                <span>Stretchable fabrics may fit differently than non-stretch materials.</span>
            </li>
        </ul>
    </div>
    
    <!-- Need Help -->
    <div class="bg-gradient-to-r from-purple-600 to-pink-600 text-white rounded-lg p-6">
        <h3 class="text-2xl font-semibold mb-2">Need Help Finding Your Size?</h3>
        <p class="mb-4">Our customer support team is here to assist you with sizing questions.</p>
        <a href="/contact" class="inline-block bg-white text-purple-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-colors">
            Contact Us
        </a>
    </div>
</div>
HTML;

// Create FAQ Page
if (!Page::where('slug', 'faq')->exists()) {
    Page::create([
        'title' => 'Frequently Asked Questions',
        'slug' => 'faq',
        'page_type' => 'faq',
        'content' => $faqContent,
        'meta_description' => 'Find answers to frequently asked questions about ordering, shipping, returns, sizing, and more at SJ Fashion Hub.',
        'seo_title' => 'FAQ - Frequently Asked Questions | SJ Fashion Hub',
        'meta_keywords' => 'faq, questions, help, support, shipping, returns, sizing',
        'is_active' => true,
        'sort_order' => 5,
    ]);
    echo "✅ FAQ page created successfully!\n";
} else {
    echo "ℹ️  FAQ page already exists.\n";
}

// Create Size Guide Page
if (!Page::where('slug', 'size-guide')->exists()) {
    Page::create([
        'title' => 'Size Guide',
        'slug' => 'size-guide',
        'page_type' => 'size-guide',
        'content' => $sizeGuideContent,
        'meta_description' => 'Find your perfect fit with our comprehensive size guide for women\'s clothing including blouses, tops, and more.',
        'seo_title' => 'Size Guide - Find Your Perfect Fit | SJ Fashion Hub',
        'meta_keywords' => 'size guide, sizing chart, measurements, blouse sizes, clothing sizes',
        'is_active' => true,
        'sort_order' => 6,
    ]);
    echo "✅ Size Guide page created successfully!\n";
} else {
    echo "ℹ️  Size Guide page already exists.\n";
}

echo "\n✅ All pages processed successfully!\n";

