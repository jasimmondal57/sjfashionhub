<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FooterSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FooterSettingController extends Controller
{
    /**
     * Display footer settings
     */
    public function index()
    {
        $footerSetting = FooterSetting::active()->first();

        if (!$footerSetting) {
            // Create default footer setting if none exists
            $footerSetting = FooterSetting::create([
                'company_name' => 'SJ Fashion Hub',
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
                    ['text' => 'Men\'s Fashion', 'url' => '/categories/men'],
                    ['text' => 'Women\'s Fashion', 'url' => '/categories/women'],
                    ['text' => 'Kids Fashion', 'url' => '/categories/kids'],
                    ['text' => 'Accessories', 'url' => '/categories/accessories'],
                ],
                'copyright_text' => '© ' . date('Y') . ' SJ Fashion Hub | All rights reserved',
                'payment_methods' => [
                    ['name' => 'Visa', 'icon' => 'visa'],
                    ['name' => 'Mastercard', 'icon' => 'mastercard'],
                    ['name' => 'PayPal', 'icon' => 'paypal'],
                    ['name' => 'Apple Pay', 'icon' => 'apple-pay'],
                ],
                'newsletter_text' => 'Subscribe to our newsletter for the latest fashion trends and exclusive offers.',
                'show_newsletter' => true,
                'show_social_links' => true,
                'show_payment_methods' => true,
                'background_color' => '#ffffff',
                'text_color' => '#374151',
                'is_active' => true,
            ]);
        }

        return view('admin.footer-settings.index', compact('footerSetting'));
    }

    /**
     * Show the form for editing footer settings
     */
    public function edit()
    {
        $footerSetting = FooterSetting::active()->first();

        if (!$footerSetting) {
            return redirect()->route('admin.footer-settings.index');
        }

        $availablePages = FooterSetting::getAvailablePages();
        $paymentPages = FooterSetting::getPaymentPages();

        return view('admin.footer-settings.edit', compact('footerSetting', 'availablePages', 'paymentPages'));
    }

    /**
     * Update footer settings
     */
    public function update(Request $request)
    {
        $footerSetting = FooterSetting::active()->first();

        if (!$footerSetting) {
            return redirect()->route('admin.footer-settings.index')
                ->with('error', 'Footer settings not found.');
        }



        $validator = Validator::make($request->all(), [
            'business_name' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'company_description' => 'nullable|string',
            'contact_info.phone' => 'nullable|string|max:255',
            'contact_info.email' => 'nullable|email|max:255',
            'contact_info.address' => 'nullable|string',
            'copyright_text' => 'nullable|string|max:255',
            'newsletter_text' => 'nullable|string',
            'background_color' => 'nullable|string|max:7',
            'text_color' => 'nullable|string|max:7',
            'show_payment_methods' => 'boolean',

            'quick_links_title' => 'nullable|string|max:255',
            'customer_service_title' => 'nullable|string|max:255',
            'categories_title' => 'nullable|string|max:255',
            'additional_title' => 'nullable|string|max:255',
            'made_in_text' => 'nullable|string|max:255',
            'designed_by_text' => 'nullable|string|max:255',
            'company_url' => 'nullable|url|max:255',

            'quick_links' => 'nullable|array',
            'quick_links.*.text' => 'nullable|string|max:255',
            'quick_links.*.url' => 'nullable|string|max:255',

            'customer_service_links' => 'nullable|array',
            'customer_service_links.*.text' => 'nullable|string|max:255',
            'customer_service_links.*.url' => 'nullable|string|max:255',

            'categories_links' => 'nullable|array',
            'categories_links.*.text' => 'nullable|string|max:255',
            'categories_links.*.url' => 'nullable|string|max:255',

            'payment_icons' => 'nullable|array',
            'payment_icons.*.name' => 'nullable|string|max:255',
            'payment_icons.*.icon' => 'nullable|string|max:255',
            'payment_icons.*.url' => 'nullable|string|max:255',
            'payment_icons.*.image_type' => 'nullable|string|in:auto,custom',
            'payment_icons.*.custom_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'show_payment_icons' => 'boolean',

            'app_download_links' => 'nullable|array',
            'app_download_links.*.platform' => 'nullable|string|max:255',
            'app_download_links.*.url' => 'nullable|url|max:255',
            'app_download_links.*.icon' => 'nullable|string|max:255',
            'show_app_downloads' => 'boolean',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }



        // Process quick links
        $quickLinks = [];
        if ($request->has('quick_links')) {
            foreach ($request->quick_links as $link) {
                if (!empty($link['text']) && !empty($link['url'])) {
                    $quickLinks[] = [
                        'text' => $link['text'],
                        'url' => $link['url']
                    ];
                }
            }
        }

        // Process customer service links
        $customerServiceLinks = [];
        if ($request->has('customer_service_links')) {
            foreach ($request->customer_service_links as $link) {
                if (!empty($link['text']) && !empty($link['url'])) {
                    $customerServiceLinks[] = [
                        'text' => $link['text'],
                        'url' => $link['url']
                    ];
                }
            }
        }

        // Process categories links
        $categoriesLinks = [];
        if ($request->has('categories_links')) {
            foreach ($request->categories_links as $link) {
                if (!empty($link['text']) && !empty($link['url'])) {
                    $categoriesLinks[] = [
                        'text' => $link['text'],
                        'url' => $link['url']
                    ];
                }
            }
        }



        // Process payment methods
        $paymentMethods = [];
        if ($request->has('payment_methods')) {
            foreach ($request->payment_methods as $method) {
                if (!empty($method['name'])) {
                    $paymentMethods[] = [
                        'name' => $method['name'],
                        'icon' => strtolower(str_replace(' ', '-', $method['name']))
                    ];
                }
            }
        }

        // Process payment icons
        $paymentIcons = [];
        if ($request->has('payment_icons')) {
            foreach ($request->payment_icons as $index => $icon) {
                if (!empty($icon['name']) && !empty($icon['icon'])) {
                    $customImagePath = null;

                    // Handle custom image upload
                    if (isset($icon['image_type']) && $icon['image_type'] === 'custom') {
                        if ($request->hasFile("payment_icons.{$index}.custom_image")) {
                            $file = $request->file("payment_icons.{$index}.custom_image");
                            $filename = time() . '_' . $index . '_' . $file->getClientOriginalName();
                            $customImagePath = $file->storeAs('payment-icons', $filename, 'public');
                        } else {
                            // Keep existing image if no new file uploaded
                            $existingSettings = FooterSetting::first();
                            if ($existingSettings && isset($existingSettings->payment_icons[$index]['custom_image'])) {
                                $customImagePath = $existingSettings->payment_icons[$index]['custom_image'];
                            }
                        }
                    }

                    $paymentIcons[] = [
                        'name' => $icon['name'],
                        'icon' => $icon['icon'],
                        'url' => $icon['url'] ?? '',
                        'image_type' => $icon['image_type'] ?? 'auto',
                        'custom_image' => $customImagePath
                    ];
                }
            }
        }

        // Process app download links
        $appDownloadLinks = [];
        if ($request->has('app_download_links')) {
            foreach ($request->app_download_links as $app) {
                if (!empty($app['platform']) && !empty($app['url']) && !empty($app['icon'])) {
                    $appDownloadLinks[] = [
                        'platform' => $app['platform'],
                        'url' => $app['url'],
                        'icon' => $app['icon']
                    ];
                }
            }
        }

        $footerSetting->update([
            'business_name' => $request->business_name,
            'company_name' => $request->company_name,
            'company_description' => $request->company_description,
            'contact_info' => $request->contact_info,

            'quick_links' => $quickLinks,
            'customer_service_links' => $customerServiceLinks,
            'categories_links' => $categoriesLinks,
            'copyright_text' => $request->copyright_text,
            'payment_methods' => $paymentMethods,
            'payment_icons' => $paymentIcons,
            'show_payment_icons' => $request->boolean('show_payment_icons'),
            'app_download_links' => $appDownloadLinks,
            'show_app_downloads' => $request->boolean('show_app_downloads'),
            'newsletter_text' => $request->newsletter_text,
            'show_payment_methods' => $request->boolean('show_payment_methods'),
            'background_color' => $request->background_color ?? '#ffffff',
            'text_color' => $request->text_color ?? '#374151',
            'quick_links_title' => $request->quick_links_title ?? 'Quick Links',
            'customer_service_title' => $request->customer_service_title ?? 'Customer Service',
            'categories_title' => $request->categories_title ?? 'Categories',
            'made_in_text' => $request->made_in_text ?? 'Made with ❤️ in India',
            'designed_by_text' => $request->designed_by_text ?? 'Designed By',
            'company_url' => $request->company_url ?? 'https://jmsoftware.shop/',
        ]);

        return redirect()->route('admin.footer-settings.index')
            ->with('success', 'Footer settings updated successfully!');
    }
}
