<?php

require 'vendor/autoload.php';
require 'bootstrap/app.php';

$app = require 'bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Page;

// Refund Policy Content
$refundContent = <<<'HTML'
<h1>💰 Refund Policy</h1>
<p><strong>Last updated:</strong> October 24, 2025</p>
<p>At SJ Fashion Hub, we are committed to ensuring complete customer satisfaction. Our comprehensive refund policy is designed to protect your interests and provide a hassle-free experience.</p>

<h2>🎯 Refund Eligibility</h2>
<p>Your purchase is eligible for a refund if:</p>
<ul>
<li>✓ The item is returned within <strong>3 days of delivery</strong></li>
<li>✓ The item is in <strong>original, unused condition</strong></li>
<li>✓ All <strong>original tags are attached</strong></li>
<li>✓ The item is in <strong>original packaging</strong></li>
<li>✓ The item has <strong>not been washed, worn, or altered</strong></li>
<li>✓ There are <strong>no signs of use or damage</strong></li>
<li>✓ The item was purchased from SJ Fashion Hub</li>
</ul>

<h2>❌ Non-Refundable Items</h2>
<p>The following items are <strong>NOT eligible for refund</strong>:</p>
<ul>
<li>✗ Innerwear, swimwear, or intimate apparel (for hygiene reasons)</li>
<li>✗ Items marked as "Final Sale" or "Non-Returnable"</li>
<li>✗ Clearance or heavily discounted items (unless defective)</li>
<li>✗ Items purchased during special promotions (unless stated otherwise)</li>
<li>✗ Custom-made or personalized items</li>
<li>✗ Items returned after 3 days of delivery</li>
<li>✗ Items with missing tags or damaged packaging</li>
<li>✗ Items showing signs of wear, washing, or alteration</li>
</ul>

<h2>💵 Refund Amount</h2>
<p>Your refund will include:</p>
<ul>
<li>✓ Full product price</li>
<li>✓ Applicable taxes (GST)</li>
<li>✓ Shipping charges (if applicable)</li>
</ul>

<p><strong>Refund will NOT include:</strong></p>
<ul>
<li>✗ Discount coupons or promotional codes used</li>
<li>✗ Gift wrapping charges</li>
<li>✗ Any deductions for damage caused by customer</li>
</ul>

<h2>⏱️ Refund Timeline</h2>
<p>Our refund process follows these timelines:</p>
<ul>
<li><strong>Days 1-3:</strong> Return window - Initiate return request</li>
<li><strong>Days 4-5:</strong> Pickup arranged by our logistics partner</li>
<li><strong>Days 6-8:</strong> Item in transit to our warehouse</li>
<li><strong>Days 9-10:</strong> Quality check and inspection</li>
<li><strong>Days 11-15:</strong> Refund processed to original payment method</li>
<li><strong>Days 16-20:</strong> Refund appears in your bank account</li>
</ul>

<p><strong>Total time: 15-20 business days from return initiation</strong></p>

<h2>🔄 How to Initiate a Refund</h2>
<p><strong>Step 1: Log into Your Account</strong></p>
<ul>
<li>Visit sjfashionhub.com and log into your account</li>
<li>Navigate to "My Orders" section</li>
</ul>

<p><strong>Step 2: Select the Order</strong></p>
<ul>
<li>Find the order containing the item you want to return</li>
<li>Click on the order to view details</li>
</ul>

<p><strong>Step 3: Initiate Return</strong></p>
<ul>
<li>Click "Return Items" button</li>
<li>Select the specific items you want to return</li>
<li>Choose the reason for return from the dropdown</li>
</ul>

<p><strong>Step 4: Submit Return Request</strong></p>
<ul>
<li>Add any additional comments or photos (optional)</li>
<li>Click "Submit Return Request"</li>
<li>You will receive a confirmation email immediately</li>
</ul>

<p><strong>Step 5: Arrange Pickup</strong></p>
<ul>
<li>Our team will contact you within 2-3 business days</li>
<li>We will arrange a free pickup from your address</li>
<li>You will receive a prepaid shipping label via email</li>
</ul>

<p><strong>Step 6: Ship the Item</strong></p>
<ul>
<li>Pack the item securely in original packaging</li>
<li>Use the provided prepaid shipping label</li>
<li>Drop off at the nearest courier center</li>
<li>Keep the tracking number for reference</li>
</ul>

<p><strong>Step 7: Refund Processing</strong></p>
<ul>
<li>Once we receive and inspect your item, refund is processed</li>
<li>You will receive a confirmation email</li>
<li>Refund will be credited to your original payment method</li>
</ul>

<h2>💳 Refund Methods</h2>
<p>Refunds are processed to the original payment method used for purchase:</p>

<p><strong>Credit/Debit Card:</strong></p>
<ul>
<li>Refund appears within 5-7 business days</li>
<li>May take up to 10 business days depending on your bank</li>
<li>Check with your bank if refund doesn't appear</li>
</ul>

<p><strong>Digital Wallets (PayPal, Google Pay, Apple Pay):</strong></p>
<ul>
<li>Refund appears within 2-3 business days</li>
<li>Check your wallet account for confirmation</li>
</ul>

<p><strong>Bank Transfer:</strong></p>
<ul>
<li>Refund appears within 5-7 business days</li>
<li>Depends on your bank's processing time</li>
</ul>

<p><strong>Store Credit:</strong></p>
<ul>
<li>Instant credit to your SJ Fashion Hub account</li>
<li>Use for future purchases</li>
<li>Valid for 1 year from issue date</li>
</ul>

<h2>🔍 Quality Check Process</h2>
<p>When we receive your return, we perform a thorough quality check:</p>
<ul>
<li>✓ Verify item condition matches return request</li>
<li>✓ Check for tags, packaging, and original condition</li>
<li>✓ Inspect for any damage or wear</li>
<li>✓ Verify item matches order details</li>
<li>✓ Document findings with photos</li>
</ul>

<p><strong>If item fails quality check:</strong></p>
<ul>
<li>We will contact you with photos and details</li>
<li>You can accept partial refund or reject</li>
<li>Item will be returned to you if rejected</li>
</ul>

<h2>⚠️ Damaged or Defective Items</h2>
<p>If you receive a damaged or defective item:</p>
<ul>
<li>✓ Report within 24 hours of delivery</li>
<li>✓ Provide photos of damage/defect</li>
<li>✓ We will arrange immediate replacement or refund</li>
<li>✓ No need to return the item</li>
<li>✓ Full refund or replacement at no cost</li>
</ul>

<h2>🎁 Exchange vs. Refund</h2>
<p><strong>Exchange:</strong></p>
<ul>
<li>✓ Exchange for different size or color</li>
<li>✓ No additional charges</li>
<li>✓ Faster than refund (5-7 days)</li>
<li>✓ Free return and shipping</li>
</ul>

<p><strong>Refund:</strong></p>
<ul>
<li>✓ Full money back to original payment method</li>
<li>✓ Takes 15-20 business days</li>
<li>✓ Free return shipping</li>
</ul>

<h2>❓ Frequently Asked Questions</h2>

<p><strong>Q: Can I return items after 3 days?</strong><br>
A: No, returns must be initiated within 3 days of delivery. However, if the item is defective or damaged, we will accept returns beyond this period.</p>

<p><strong>Q: Do I have to pay for return shipping?</strong><br>
A: No! Return shipping is completely FREE. We provide a prepaid shipping label for all returns.</p>

<p><strong>Q: How long does refund take?</strong><br>
A: Refunds are processed within 5-7 business days after we receive and inspect your return. It may take an additional 5-10 business days to appear in your account depending on your bank.</p>

<p><strong>Q: Can I get a refund without returning the item?</strong><br>
A: No, we require the item to be returned for inspection before processing refund. However, for defective items, we may waive the return requirement.</p>

<p><strong>Q: What if the item is damaged during return shipping?</strong><br>
A: We recommend using the provided shipping label and packaging. If damage occurs during return shipping, contact us immediately with photos and tracking number. We will investigate with the courier.</p>

<p><strong>Q: Can I exchange for a different size?</strong><br>
A: Yes! You can exchange for a different size or color at no additional cost. Exchange is faster than refund (5-7 days).</p>

<p><strong>Q: What if I change my mind after initiating return?</strong><br>
A: You can cancel the return request before pickup is arranged. Contact us immediately to cancel.</p>

<p><strong>Q: Can I get a refund for items purchased during sale?</strong><br>
A: Yes, sale items are eligible for refund if they meet all other conditions. However, some items marked "Final Sale" are non-returnable.</p>

<p><strong>Q: How do I track my refund?</strong><br>
A: You can track your return status in "My Orders" section. We also send email updates at each stage of the process.</p>

<h2>📞 Need Help?</h2>
<p>For any questions about refunds or returns, please contact us:</p>
<p><strong>Email:</strong> <a href="mailto:contact@sjfashionhub.com">contact@sjfashionhub.com</a><br>
<strong>Phone:</strong> <a href="tel:+917063474409">+91 7063474409</a><br>
<strong>WhatsApp:</strong> <a href="https://wa.me/917063474409">+91 7063474409</a><br>
<strong>Hours:</strong> Monday - Saturday, 10:00 AM - 7:00 PM IST</p>

<h2>📋 Important Notes</h2>
<ul>
<li>✓ This policy is subject to change without notice</li>
<li>✓ We reserve the right to refuse refunds for items not meeting eligibility criteria</li>
<li>✓ In case of disputes, SJ Fashion Hub's decision is final</li>
<li>✓ This policy complies with Indian Consumer Protection Act, 2019</li>
<li>✓ For international orders, additional terms may apply</li>
</ul>
HTML;

// Check if refund policy already exists
$existingPage = Page::where('slug', 'refund-policy')->first();

if ($existingPage) {
    $existingPage->update([
        'title' => 'Refund Policy',
        'content' => $refundContent,
        'meta_description' => 'Learn about SJ Fashion Hub refund policy. Get full refunds within 3 days of delivery with free return shipping.',
        'meta_keywords' => 'refund policy, money back, return refund, refund process',
        'seo_title' => 'Refund Policy - SJ Fashion Hub',
        'page_type' => 'policy',
        'is_active' => true,
        'sort_order' => 3,
    ]);
    echo "✓ Refund Policy updated successfully\n";
} else {
    Page::create([
        'title' => 'Refund Policy',
        'slug' => 'refund-policy',
        'content' => $refundContent,
        'meta_description' => 'Learn about SJ Fashion Hub refund policy. Get full refunds within 3 days of delivery with free return shipping.',
        'meta_keywords' => 'refund policy, money back, return refund, refund process',
        'seo_title' => 'Refund Policy - SJ Fashion Hub',
        'page_type' => 'policy',
        'is_active' => true,
        'sort_order' => 3,
    ]);
    echo "✓ Refund Policy created successfully\n";
}

echo "✓ Refund Policy page is now available at: /refund-policy\n";

