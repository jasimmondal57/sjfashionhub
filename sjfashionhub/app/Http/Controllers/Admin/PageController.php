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
<p>We\'d love to hear from you. Get in touch with our friendly team.</p>

<h2>Contact Information</h2>
<p><strong>Address:</strong><br>
123 Fashion Street<br>
Style City, SC 12345<br>
India</p>

<p><strong>Phone:</strong> +91 98765 43210</p>
<p><strong>Email:</strong> info@sjfashionhub.com</p>

<h2>Business Hours</h2>
<p>Monday - Saturday: 9:00 AM - 6:00 PM<br>
Sunday: 10:00 AM - 4:00 PM</p>';
    }

    private function getDefaultPrivacyContent()
    {
        return '<h1>Privacy Policy</h1>
<p><strong>Last updated:</strong> ' . date('F d, Y') . '</p>

<h2>Information We Collect</h2>
<p>We collect information you provide directly to us, such as when you create an account, make a purchase, or contact us.</p>

<h2>How We Use Your Information</h2>
<p>We use the information we collect to provide, maintain, and improve our services, process transactions, and communicate with you.</p>

<h2>Information Sharing</h2>
<p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy.</p>

<h2>Data Security</h2>
<p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>

<h2>Contact Us</h2>
<p>If you have any questions about this Privacy Policy, please contact us at privacy@sjfashionhub.com</p>';
    }

    private function getDefaultTermsContent()
    {
        return '<h1>Terms of Service</h1>
<p><strong>Last updated:</strong> ' . date('F d, Y') . '</p>

<h2>Acceptance of Terms</h2>
<p>By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement.</p>

<h2>Use License</h2>
<p>Permission is granted to temporarily download one copy of the materials on SJ Fashion Hub\'s website for personal, non-commercial transitory viewing only.</p>

<h2>Disclaimer</h2>
<p>The materials on SJ Fashion Hub\'s website are provided on an \'as is\' basis. SJ Fashion Hub makes no warranties, expressed or implied.</p>

<h2>Limitations</h2>
<p>In no event shall SJ Fashion Hub or its suppliers be liable for any damages arising out of the use or inability to use the materials on this website.</p>

<h2>Contact Information</h2>
<p>If you have any questions about these Terms of Service, please contact us at legal@sjfashionhub.com</p>';
    }

    private function getDefaultShippingContent()
    {
        return '<h1>Shipping Policy</h1>
<p><strong>Last updated:</strong> ' . date('F d, Y') . '</p>

<h2>Shipping Methods</h2>
<p>We offer the following shipping options:</p>
<ul>
<li><strong>Standard Shipping:</strong> 5-7 business days - ₹99</li>
<li><strong>Express Shipping:</strong> 2-3 business days - ₹199</li>
<li><strong>Free Shipping:</strong> On orders above ₹999 (5-7 business days)</li>
</ul>

<h2>Processing Time</h2>
<p>Orders are typically processed within 1-2 business days. You will receive a confirmation email with tracking information once your order ships.</p>

<h2>Delivery Areas</h2>
<p>We currently deliver across India. International shipping is not available at this time.</p>

<h2>Shipping Charges</h2>
<p>Shipping charges are calculated based on the delivery location and weight of the package.</p>';
    }

    private function getDefaultReturnContent()
    {
        return '<h1>Return & Exchange Policy</h1>
<p><strong>Last updated:</strong> ' . date('F d, Y') . '</p>

<h2>Return Window</h2>
<p>You have 7 days from the date of delivery to return items for a full refund or exchange.</p>

<h2>Return Conditions</h2>
<p>Items must be:</p>
<ul>
<li>In original condition with tags attached</li>
<li>Unworn and unwashed</li>
<li>In original packaging</li>
</ul>

<h2>Return Process</h2>
<ol>
<li>Contact our customer service team</li>
<li>Receive return authorization and shipping label</li>
<li>Pack items securely and ship back</li>
<li>Refund processed within 5-7 business days</li>
</ol>

<h2>Non-Returnable Items</h2>
<p>The following items cannot be returned:</p>
<ul>
<li>Intimate apparel and undergarments</li>
<li>Items marked as final sale</li>
<li>Damaged or altered items</li>
</ul>';
    }
}
