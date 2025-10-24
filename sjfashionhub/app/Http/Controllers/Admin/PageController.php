<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::ordered()->paginate(20);
        return view('admin.pages.index', compact('pages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug',
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'page_type' => 'required|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->all();

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Ensure slug is unique
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Page::where('slug', $data['slug'])->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        Page::create($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Page $page)
    {
        return view('admin.pages.show', compact('page'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:pages,slug,' . $page->id,
            'content' => 'required|string',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
            'seo_title' => 'nullable|string|max:255',
            'page_type' => 'required|string|max:50',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        $data = $request->all();

        // Generate slug if not provided
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // Ensure slug is unique (excluding current page)
        $originalSlug = $data['slug'];
        $counter = 1;
        while (Page::where('slug', $data['slug'])->where('id', '!=', $page->id)->exists()) {
            $data['slug'] = $originalSlug . '-' . $counter;
            $counter++;
        }

        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $page->update($data);

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Page $page)
    {
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Page deleted successfully.');
    }

    /**
     * Create default pages
     */
    public function createDefaults()
    {
        $defaultPages = [
            [
                'title' => 'About Us',
                'slug' => 'about',
                'page_type' => 'about',
                'content' => $this->getDefaultAboutContent(),
                'meta_description' => 'Learn more about SJ Fashion Hub - your premier destination for trendy, affordable fashion.',
                'seo_title' => 'About Us - SJ Fashion Hub',
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'page_type' => 'contact',
                'content' => $this->getDefaultContactContent(),
                'meta_description' => 'Get in touch with SJ Fashion Hub. Contact us for any questions or support.',
                'seo_title' => 'Contact Us - SJ Fashion Hub',
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'page_type' => 'privacy',
                'content' => $this->getDefaultPrivacyContent(),
                'meta_description' => 'Read our privacy policy to understand how we collect, use, and protect your information.',
                'seo_title' => 'Privacy Policy - SJ Fashion Hub',
            ],
            [
                'title' => 'Terms of Service',
                'slug' => 'terms-of-service',
                'page_type' => 'terms',
                'content' => $this->getDefaultTermsContent(),
                'meta_description' => 'Read our terms of service for using SJ Fashion Hub website and services.',
                'seo_title' => 'Terms of Service - SJ Fashion Hub',
            ],
            [
                'title' => 'Shipping Policy',
                'slug' => 'shipping-policy',
                'page_type' => 'shipping',
                'content' => $this->getDefaultShippingContent(),
                'meta_description' => 'Learn about our shipping policies, delivery times, and shipping costs.',
                'seo_title' => 'Shipping Policy - SJ Fashion Hub',
            ],
            [
                'title' => 'Return & Exchange Policy',
                'slug' => 'return-policy',
                'page_type' => 'returns',
                'content' => $this->getDefaultReturnContent(),
                'meta_description' => 'Read our return and exchange policy for hassle-free returns.',
                'seo_title' => 'Return & Exchange Policy - SJ Fashion Hub',
            ],
        ];

        foreach ($defaultPages as $pageData) {
            if (!Page::where('slug', $pageData['slug'])->exists()) {
                Page::create($pageData);
            }
        }

        return redirect()->route('admin.pages.index')
            ->with('success', 'Default pages created successfully.');
    }

    private function getDefaultAboutContent()
    {
        return '<h1>About SJ Fashion Hub</h1>
<p>Welcome to SJ Fashion Hub, your premier destination for trendy, affordable fashion that celebrates your unique style.</p>

<h2>Our Story</h2>
<p>SJ Fashion Hub was born from a simple belief: everyone deserves to look and feel their best without breaking the bank. We started as a small team of fashion enthusiasts who noticed a gap in the market for trendy, high-quality clothing at accessible prices.</p>

<h2>Our Mission</h2>
<p>To democratize fashion by making trendy, high-quality clothing accessible to everyone, while providing an exceptional shopping experience that exceeds expectations.</p>

<h2>Why Choose Us?</h2>
<ul>
<li>Quality Guarantee - 100% satisfaction guaranteed</li>
<li>Free Shipping on orders above ₹999</li>
<li>Easy Returns within 7 days</li>
<li>24/7 Customer Support</li>
</ul>';
    }

    private function getDefaultContactContent()
    {
        return '<h1>Contact Us</h1>
<p>We\'d love to hear from you. Get in touch with our friendly team at SJ Fashion Hub.</p>

<h2>Contact Information</h2>
<div style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin: 20px 0;">
<p><strong>SJ FASHION</strong></p>
<p><strong>Email:</strong> <a href="mailto:contact@sjfashionhub.com">contact@sjfashionhub.com</a></p>
<p><strong>Mobile:</strong> <a href="tel:+917063474409">+91 7063474409</a></p>
<p><strong>Address:</strong><br>
Near Masjid, Nazrulpally<br>
Bhubandanga, Bolpur<br>
Pin: 731204<br>
West Bengal, India</p>
<p><strong>GSTIN:</strong> 19DFEPM6450N1ZU</p>
</div>

<h2>Business Hours</h2>
<p>Monday - Saturday: 10:00 AM - 7:00 PM IST<br>
Sunday: 11:00 AM - 5:00 PM IST</p>

<h2>Response Time</h2>
<p>We typically respond to all inquiries within 24 business hours. For urgent matters, please call us directly.</p>';
    }

    private function getDefaultPrivacyContent()
    {
        return '<h1>Privacy Policy</h1>
<p><strong>Last updated:</strong> ' . date('F d, Y') . '</p>
<p>SJ Fashion Hub ("we," "us," "our," or "Company") is committed to protecting your privacy. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website and use our services.</p>

<h2>1. Information We Collect</h2>

<h3>Personal Information You Provide</h3>
<p>We collect information you voluntarily provide to us, including:</p>
<ul>
<li><strong>Account Information:</strong> Name, email address, phone number, password</li>
<li><strong>Billing & Shipping Information:</strong> Address, postal code, payment details</li>
<li><strong>Purchase History:</strong> Products purchased, order details, transaction history</li>
<li><strong>Communication:</strong> Messages, inquiries, feedback, and support requests</li>
<li><strong>Profile Information:</strong> Preferences, wishlist, reviews, and ratings</li>
</ul>

<h3>Automatically Collected Information</h3>
<p>When you visit our website, we automatically collect:</p>
<ul>
<li><strong>Device Information:</strong> IP address, browser type, operating system</li>
<li><strong>Usage Data:</strong> Pages visited, time spent, links clicked, search queries</li>
<li><strong>Cookies & Tracking:</strong> Session data, preferences, analytics</li>
<li><strong>Location Data:</strong> General location based on IP address (not precise)</li>
</ul>

<h2>2. How We Use Your Information</h2>
<p>We use the information we collect for the following purposes:</p>
<ul>
<li>✓ Process and fulfill your orders</li>
<li>✓ Send order confirmations and shipping updates</li>
<li>✓ Provide customer support and respond to inquiries</li>
<li>✓ Improve our website and services</li>
<li>✓ Personalize your shopping experience</li>
<li>✓ Send promotional emails and offers (with your consent)</li>
<li>✓ Detect and prevent fraud</li>
<li>✓ Comply with legal obligations</li>
<li>✓ Analyze trends and user behavior</li>
</ul>

<h2>3. Information Sharing & Disclosure</h2>

<h3>We Do NOT Sell Your Data</h3>
<p>We do not sell, trade, or rent your personal information to third parties.</p>

<h3>We Share Information With</h3>
<ul>
<li><strong>Payment Processors:</strong> To process your payments securely</li>
<li><strong>Shipping Partners:</strong> To deliver your orders (Shiprocket, etc.)</li>
<li><strong>Email Service Providers:</strong> To send you communications</li>
<li><strong>Analytics Providers:</strong> To understand user behavior</li>
<li><strong>Legal Authorities:</strong> When required by law</li>
</ul>

<h3>Third-Party Links</h3>
<p>Our website may contain links to third-party websites. We are not responsible for their privacy practices. Please review their privacy policies before providing information.</p>

<h2>4. Data Security</h2>
<p>We implement industry-standard security measures to protect your information:</p>
<ul>
<li>✓ SSL/TLS encryption for data transmission</li>
<li>✓ Secure payment gateway integration</li>
<li>✓ Regular security audits</li>
<li>✓ Restricted access to personal information</li>
<li>✓ Secure password storage</li>
</ul>

<p><strong>Note:</strong> While we strive to protect your information, no method of transmission over the internet is 100% secure. We cannot guarantee absolute security.</p>

<h2>5. Cookies & Tracking Technologies</h2>
<p>We use cookies and similar technologies to:</p>
<ul>
<li>Remember your preferences</li>
<li>Track website usage and analytics</li>
<li>Improve user experience</li>
<li>Personalize content</li>
</ul>

<p>You can control cookies through your browser settings. Disabling cookies may affect website functionality.</p>

<h2>6. Your Rights & Choices</h2>
<p>You have the right to:</p>
<ul>
<li>✓ Access your personal information</li>
<li>✓ Correct inaccurate information</li>
<li>✓ Request deletion of your data</li>
<li>✓ Opt-out of marketing communications</li>
<li>✓ Withdraw consent at any time</li>
</ul>

<p>To exercise these rights, contact us at <a href="mailto:contact@sjfashionhub.com">contact@sjfashionhub.com</a></p>

<h2>7. Children\'s Privacy</h2>
<p>Our website is not intended for children under 13 years old. We do not knowingly collect information from children. If we become aware that a child has provided us with personal information, we will delete such information immediately.</p>

<h2>8. Data Retention</h2>
<p>We retain your personal information for as long as necessary to:</p>
<ul>
<li>Provide our services</li>
<li>Comply with legal obligations</li>
<li>Resolve disputes</li>
<li>Enforce our agreements</li>
</ul>

<p>You can request deletion of your account and associated data at any time.</p>

<h2>9. International Data Transfers</h2>
<p>Your information may be transferred to, stored in, and processed in countries other than your country of residence. These countries may have data protection laws different from your home country.</p>

<h2>10. Policy Updates</h2>
<p>We may update this Privacy Policy from time to time. We will notify you of significant changes via email or by posting the updated policy on our website. Your continued use of our services constitutes acceptance of the updated policy.</p>

<h2>11. Contact Us</h2>
<p>If you have questions about this Privacy Policy or our privacy practices, please contact us:</p>
<p><strong>SJ FASHION</strong><br>
<strong>Email:</strong> <a href="mailto:contact@sjfashionhub.com">contact@sjfashionhub.com</a><br>
<strong>Phone:</strong> <a href="tel:+917063474409">+91 7063474409</a><br>
<strong>Address:</strong> Near Masjid, Nazrulpally, Bhubandanga, Bolpur, Pin: 731204, WB, India<br>
<strong>GSTIN:</strong> 19DFEPM6450N1ZU</p>';
    }

    private function getDefaultTermsContent()
    {
        return '<h1>Terms of Service</h1>
<p><strong>Last updated:</strong> ' . date('F d, Y') . '</p>
<p>Welcome to SJ Fashion Hub. These Terms of Service ("Terms") govern your access to and use of our website, mobile application, and services. By accessing or using our platform, you agree to be bound by these Terms. If you do not agree to any part of these Terms, please do not use our services.</p>

<h2>1. Acceptance of Terms</h2>
<p>By accessing and using SJ Fashion Hub\'s website and services, you:</p>
<ul>
<li>Accept and agree to be bound by these Terms of Service</li>
<li>Represent that you are at least 18 years old or have parental consent</li>
<li>Agree to comply with all applicable laws and regulations</li>
<li>Accept our Privacy Policy and other policies</li>
</ul>

<h2>2. Use License</h2>
<p>We grant you a limited, non-exclusive, non-transferable license to:</p>
<ul>
<li>Access and view our website for personal, non-commercial purposes</li>
<li>Place orders and make purchases</li>
<li>Create an account and manage your profile</li>
</ul>

<p>You may NOT:</p>
<ul>
<li>Reproduce, duplicate, or copy content without permission</li>
<li>Modify or alter any materials</li>
<li>Use automated tools or bots to access our website</li>
<li>Attempt to gain unauthorized access</li>
<li>Engage in any illegal activities</li>
<li>Resell or redistribute our products without authorization</li>
</ul>

<h2>3. Product Information & Availability</h2>
<ul>
<li>We strive to provide accurate product descriptions and pricing</li>
<li>Product images are for illustrative purposes only</li>
<li>Colors may vary slightly due to screen display differences</li>
<li>We reserve the right to correct pricing errors</li>
<li>Products are subject to availability</li>
<li>We reserve the right to limit quantities per customer</li>
</ul>

<h2>4. Ordering & Payment</h2>

<h3>Order Placement</h3>
<ul>
<li>All orders are subject to acceptance and confirmation</li>
<li>We reserve the right to refuse or cancel any order</li>
<li>Order confirmation will be sent via email</li>
</ul>

<h3>Payment</h3>
<ul>
<li>Payment must be made before order processing</li>
<li>We accept various payment methods (credit card, debit card, UPI, etc.)</li>
<li>All payments are processed securely</li>
<li>You are responsible for providing accurate payment information</li>
<li>Prices are in Indian Rupees (₹)</li>
</ul>

<h3>Pricing</h3>
<ul>
<li>Prices are subject to change without notice</li>
<li>We reserve the right to adjust prices at any time</li>
<li>Applicable taxes will be added to your order</li>
</ul>

<h2>5. Shipping & Delivery</h2>
<ul>
<li>We offer FREE delivery on all orders across India</li>
<li>Delivery times are estimates and not guaranteed</li>
<li>We are not responsible for delays caused by courier services</li>
<li>Risk of loss transfers to you upon delivery</li>
<li>You are responsible for providing accurate delivery address</li>
</ul>

<h2>6. Returns & Refunds</h2>
<p>Please refer to our Return & Exchange Policy for detailed information about:</p>
<ul>
<li>3-day return window</li>
<li>Return eligibility and conditions</li>
<li>Refund processing</li>
<li>Exchange procedures</li>
</ul>

<h2>7. User Accounts</h2>

<h3>Account Creation</h3>
<ul>
<li>You are responsible for maintaining confidentiality of your password</li>
<li>You agree to provide accurate and complete information</li>
<li>You are responsible for all activities under your account</li>
<li>You must notify us immediately of unauthorized access</li>
</ul>

<h3>Account Termination</h3>
<p>We reserve the right to suspend or terminate your account if you:</p>
<ul>
<li>Violate these Terms of Service</li>
<li>Engage in fraudulent or illegal activities</li>
<li>Abuse our services or other users</li>
<li>Provide false information</li>
</ul>

<h2>8. User Content & Conduct</h2>

<h3>Prohibited Activities</h3>
<p>You agree NOT to:</p>
<ul>
<li>Post offensive, abusive, or defamatory content</li>
<li>Harass or threaten other users</li>
<li>Spam or send unsolicited messages</li>
<li>Engage in fraudulent activities</li>
<li>Violate intellectual property rights</li>
<li>Attempt to hack or compromise security</li>
<li>Engage in any illegal activities</li>
</ul>

<h3>User Reviews & Ratings</h3>
<ul>
<li>Reviews must be honest and based on personal experience</li>
<li>We reserve the right to remove false or inappropriate reviews</li>
<li>You grant us the right to use your reviews in marketing</li>
<li>You are responsible for the content you post</li>
</ul>

<h2>9. Intellectual Property Rights</h2>
<ul>
<li>All content on our website is owned by SJ Fashion Hub or licensed to us</li>
<li>This includes text, images, logos, graphics, and software</li>
<li>You may not reproduce, distribute, or transmit any content without permission</li>
<li>Unauthorized use may violate copyright, trademark, and other laws</li>
</ul>

<h2>10. Disclaimer of Warranties</h2>
<p>Our website and services are provided on an "AS IS" and "AS AVAILABLE" basis. We make no warranties, expressed or implied, regarding:</p>
<ul>
<li>Merchantability or fitness for a particular purpose</li>
<li>Accuracy or completeness of information</li>
<li>Uninterrupted or error-free service</li>
<li>Security or freedom from viruses</li>
</ul>

<h2>11. Limitation of Liability</h2>
<p>To the maximum extent permitted by law, SJ Fashion Hub shall not be liable for:</p>
<ul>
<li>Indirect, incidental, or consequential damages</li>
<li>Loss of profits, data, or business opportunities</li>
<li>Damages arising from use or inability to use our services</li>
<li>Third-party actions or content</li>
</ul>

<h2>12. Indemnification</h2>
<p>You agree to indemnify and hold harmless SJ Fashion Hub from any claims, damages, or expenses arising from:</p>
<ul>
<li>Your violation of these Terms</li>
<li>Your use of our services</li>
<li>Your violation of any law or third-party rights</li>
<li>Your user content or conduct</li>
</ul>

<h2>13. Third-Party Links</h2>
<ul>
<li>Our website may contain links to third-party websites</li>
<li>We are not responsible for third-party content or practices</li>
<li>Your use of third-party sites is at your own risk</li>
<li>Please review their terms and privacy policies</li>
</ul>

<h2>14. Governing Law & Jurisdiction</h2>
<p>These Terms of Service are governed by the laws of India. Any disputes shall be subject to the exclusive jurisdiction of courts in West Bengal, India.</p>

<h2>15. Dispute Resolution</h2>
<p>Before initiating legal proceedings, we encourage you to contact us to resolve disputes amicably. We will attempt to resolve issues within 30 days.</p>

<h2>16. Modifications to Terms</h2>
<p>We reserve the right to modify these Terms at any time. Changes will be effective immediately upon posting. Your continued use of our services constitutes acceptance of the updated Terms.</p>

<h2>17. Severability</h2>
<p>If any provision of these Terms is found to be invalid or unenforceable, the remaining provisions shall continue in full force and effect.</p>

<h2>18. Entire Agreement</h2>
<p>These Terms of Service, along with our Privacy Policy and other policies, constitute the entire agreement between you and SJ Fashion Hub regarding your use of our services.</p>

<h2>19. Contact Information</h2>
<p>For questions about these Terms of Service, please contact us:</p>
<p><strong>SJ FASHION</strong><br>
<strong>Email:</strong> <a href="mailto:contact@sjfashionhub.com">contact@sjfashionhub.com</a><br>
<strong>Phone:</strong> <a href="tel:+917063474409">+91 7063474409</a><br>
<strong>Address:</strong> Near Masjid, Nazrulpally, Bhubandanga, Bolpur, Pin: 731204, WB, India<br>
<strong>GSTIN:</strong> 19DFEPM6450N1ZU</p>';
    }

    private function getDefaultShippingContent()
    {
        return '<h1>Shipping & Delivery Policy</h1>
<p><strong>Last updated:</strong> ' . date('F d, Y') . '</p>
<p>At SJ Fashion Hub, we are committed to delivering your orders quickly and safely. We offer <strong>FREE DELIVERY</strong> on all orders across India!</p>

<h2>🚚 Free Delivery</h2>
<p>We provide <strong>completely FREE shipping</strong> on all orders, regardless of order value. No minimum purchase required!</p>
<ul>
<li>✓ Free delivery on all orders</li>
<li>✓ No hidden charges</li>
<li>✓ Nationwide coverage</li>
<li>✓ Secure packaging</li>
</ul>

<h2>📦 Delivery Timeline</h2>
<p>Delivery times vary based on your location:</p>
<ul>
<li><strong>Metro Cities (Delhi, Mumbai, Bangalore, etc.):</strong> 3-5 business days</li>
<li><strong>Tier 1 Cities:</strong> 4-6 business days</li>
<li><strong>Tier 2 & 3 Cities:</strong> 5-7 business days</li>
<li><strong>Remote Areas:</strong> 7-10 business days</li>
</ul>

<h2>⏱️ Order Processing</h2>
<p>Orders are processed within 1-2 business days after confirmation. Processing does not include weekends and public holidays.</p>

<h2>📍 Delivery Coverage</h2>
<p>We deliver across all of India including:</p>
<ul>
<li>All metro cities</li>
<li>Tier 1, 2, and 3 cities</li>
<li>Remote and rural areas</li>
</ul>
<p><strong>Note:</strong> International shipping is not available at this time.</p>

<h2>📬 Tracking Your Order</h2>
<p>Once your order ships, you will receive:</p>
<ul>
<li>Shipping confirmation email with tracking number</li>
<li>Real-time tracking updates</li>
<li>Estimated delivery date</li>
<li>Carrier contact information</li>
</ul>

<h2>🎁 Packaging</h2>
<p>We take great care in packaging your items:</p>
<ul>
<li>Secure, eco-friendly packaging</li>
<li>Protective padding to prevent damage</li>
<li>Discreet packaging for privacy</li>
<li>Branded packaging for a premium experience</li>
</ul>

<h2>❌ Delivery Issues</h2>
<p>If your order is delayed or damaged:</p>
<ol>
<li>Contact us immediately at <a href="mailto:contact@sjfashionhub.com">contact@sjfashionhub.com</a></li>
<li>Provide order number and tracking details</li>
<li>We will investigate and resolve the issue</li>
<li>Replacement or refund will be processed promptly</li>
</ol>

<h2>📞 Contact Us</h2>
<p>For shipping inquiries, contact:</p>
<p><strong>Email:</strong> <a href="mailto:contact@sjfashionhub.com">contact@sjfashionhub.com</a><br>
<strong>Phone:</strong> <a href="tel:+917063474409">+91 7063474409</a></p>';
    }

    private function getDefaultReturnContent()
    {
        return '<h1>Return & Exchange Policy</h1>
<p><strong>Last updated:</strong> ' . date('F d, Y') . '</p>
<p>At SJ Fashion Hub, we want you to be completely satisfied with your purchase. We offer a <strong>hassle-free 3-day return policy</strong> to ensure your complete satisfaction.</p>

<h2>✅ 3-Day Return Window</h2>
<p>You have <strong>3 days from the date of delivery</strong> to return items for a full refund or exchange. This is our commitment to your satisfaction!</p>
<ul>
<li>✓ 3 days to initiate return</li>
<li>✓ Full refund or exchange</li>
<li>✓ No questions asked</li>
<li>✓ Free return shipping</li>
</ul>

<h2>📋 Return Eligibility</h2>
<p>Items are eligible for return if they meet the following conditions:</p>
<ul>
<li>✓ Purchased from SJ Fashion Hub</li>
<li>✓ Within 3 days of delivery</li>
<li>✓ In original, unused condition</li>
<li>✓ With all original tags attached</li>
<li>✓ In original packaging</li>
<li>✓ Not washed, worn, or altered</li>
<li>✓ No signs of use or damage</li>
</ul>

<h2>❌ Non-Returnable Items</h2>
<p>The following items cannot be returned:</p>
<ul>
<li>Intimate apparel and undergarments (for hygiene reasons)</li>
<li>Items marked as "Final Sale"</li>
<li>Customized or personalized items</li>
<li>Items damaged due to customer misuse</li>
<li>Items without original tags</li>
<li>Items purchased from third-party sellers</li>
<li>Clearance or discounted items (unless defective)</li>
</ul>

<h2>🔄 Return Process</h2>
<p>Returning an item is easy! Follow these simple steps:</p>
<ol>
<li><strong>Contact Us:</strong> Email <a href="mailto:contact@sjfashionhub.com">contact@sjfashionhub.com</a> or call <a href="tel:+917063474409">+91 7063474409</a> with your order number</li>
<li><strong>Get Authorization:</strong> We will provide you with a return authorization number and return shipping label</li>
<li><strong>Pack Securely:</strong> Pack the item in original packaging with all tags and accessories</li>
<li><strong>Ship Back:</strong> Use the provided shipping label to send the item back to us (FREE)</li>
<li><strong>Inspection:</strong> We inspect the returned item upon receipt</li>
<li><strong>Refund/Exchange:</strong> Once approved, refund is processed or replacement is shipped</li>
</ol>

<h2>💰 Refund Details</h2>
<ul>
<li><strong>Refund Amount:</strong> Full purchase price (excluding original shipping if applicable)</li>
<li><strong>Refund Method:</strong> Original payment method</li>
<li><strong>Processing Time:</strong> 5-7 business days after inspection and approval</li>
<li><strong>Return Shipping:</strong> Completely FREE</li>
</ul>

<h2>🔁 Exchange Process</h2>
<p>If you prefer an exchange instead of a refund:</p>
<ol>
<li>Contact us with your order number and desired size/color</li>
<li>Send back the original item using the provided shipping label</li>
<li>Once received and inspected, we ship the replacement item</li>
<li>No additional charges for exchange</li>
</ol>

<h2>⚠️ Damaged or Defective Items</h2>
<p>If you receive a damaged or defective item:</p>
<ul>
<li>Contact us within 24 hours of delivery with photos</li>
<li>We will arrange immediate replacement or refund</li>
<li>No need to return the damaged item</li>
<li>Replacement shipped at no cost</li>
</ul>

<h2>📸 Return Shipping Address</h2>
<p>You will receive the return shipping label via email. Please use the provided label for all returns.</p>

<h2>❓ Frequently Asked Questions</h2>
<p><strong>Q: Can I return items after 3 days?</strong><br>
A: No, returns must be initiated within 3 days of delivery. However, if the item is defective, we will accept returns beyond this period.</p>

<p><strong>Q: Do I have to pay for return shipping?</strong><br>
A: No! Return shipping is completely FREE. We provide a prepaid shipping label.</p>

<p><strong>Q: How long does refund take?</strong><br>
A: Refunds are processed within 5-7 business days after we receive and inspect your return.</p>

<p><strong>Q: Can I exchange for a different size?</strong><br>
A: Yes! You can exchange for a different size or color at no additional cost.</p>

<p><strong>Q: What if the item is damaged during return shipping?</strong><br>
A: We recommend using the provided shipping label and packaging. If damage occurs during return shipping, contact us immediately with photos.</p>

<h2>📞 Need Help?</h2>
<p>For any questions about returns or exchanges, please contact us:</p>
<p><strong>Email:</strong> <a href="mailto:contact@sjfashionhub.com">contact@sjfashionhub.com</a><br>
<strong>Phone:</strong> <a href="tel:+917063474409">+91 7063474409</a><br>
<strong>Hours:</strong> Monday - Saturday, 10:00 AM - 7:00 PM IST</p>';
    }
}
