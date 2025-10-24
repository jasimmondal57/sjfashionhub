# 📊 Facebook Pixel Event Tracking - Testing Guide

## ✅ What's Been Implemented

Your website now tracks **ALL standard Meta Pixel events** with complete parameters as required by Meta:

### 1. **PageView** (Automatic)
- Fires on every page load
- No additional parameters needed

### 2. **ViewContent** (Product Pages)
- Fires when viewing product details
- **Parameters:**
  - `content_name` - Product name
  - `content_category` - Product category
  - `content_ids` - Array with product ID
  - `content_type` - "product"
  - `value` - Product price
  - `currency` - "INR"
  - `contents` - Array with product details (id, quantity, item_price)

### 3. **AddToCart** (Add to Cart Button)
- Fires when adding product to cart
- **Parameters:**
  - `content_name` - Product name
  - `content_category` - Product category
  - `content_ids` - Array with product ID
  - `content_type` - "product"
  - `value` - Total value (price × quantity)
  - `currency` - "INR"
  - `contents` - Array with product details (id, quantity, item_price)

### 4. **InitiateCheckout** (Checkout Page)
- Fires when user lands on checkout page
- **Parameters:**
  - `content_type` - "product"
  - `value` - Total cart value
  - `currency` - "INR"
  - `num_items` - Number of items in cart
  - `content_ids` - Array of all product IDs in cart
  - `contents` - Array of all cart items with details

### 5. **Purchase** (Order Success Page)
- Fires when order is completed
- **Parameters:**
  - `content_type` - "product"
  - `value` - Order total
  - `currency` - "INR"
  - `content_ids` - Array of purchased product IDs
  - `num_items` - Number of items purchased
  - `contents` - Array of purchased items with details

### 6. **Search** (Search Functionality)
- Ready to implement when search is used
- **Parameters:**
  - `search_string` - Search query

### 7. **AddToWishlist** (Wishlist Feature)
- Ready to implement when wishlist is used
- **Parameters:**
  - `content_name` - Product name
  - `content_category` - Product category
  - `content_ids` - Array with product ID
  - `content_type` - "product"
  - `value` - Product price
  - `currency` - "INR"
  - `contents` - Array with product details

---

## 🧪 How to Test Events

### Method 1: Facebook Pixel Helper (Chrome Extension)

1. **Install Extension:**
   - Go to [Chrome Web Store](https://chrome.google.com/webstore/detail/facebook-pixel-helper/fdgfkebogiimcoedlicjlajpkdmockpc)
   - Click "Add to Chrome"

2. **Test Each Event:**

   **a) PageView:**
   - Visit https://sjfashionhub.com
   - Click the Pixel Helper icon
   - Should show: ✅ PageView event detected

   **b) ViewContent:**
   - Click on any product
   - Pixel Helper should show: ✅ ViewContent
   - Click on the event to see parameters:
     ```
     content_name: "Product Name"
     content_category: "Category Name"
     content_ids: ["123"]
     content_type: "product"
     value: 999
     currency: "INR"
     contents: [{id: "123", quantity: 1, item_price: 999}]
     ```

   **c) AddToCart:**
   - Click "Add to Cart" button
   - Pixel Helper should show: ✅ AddToCart
   - Verify all parameters are present

   **d) InitiateCheckout:**
   - Go to cart and click "Proceed to Checkout"
   - Pixel Helper should show: ✅ InitiateCheckout
   - Verify cart total and items are tracked

   **e) Purchase:**
   - Complete an order (use COD for testing)
   - On success page, Pixel Helper should show: ✅ Purchase
   - Verify order total and items are tracked

### Method 2: Meta Events Manager (Real-time Testing)

1. **Go to Events Manager:**
   - Visit https://business.facebook.com/events_manager2
   - Select your Pixel (ID: 1364197498404249)

2. **Open Test Events:**
   - Click "Test Events" in the left sidebar
   - You'll see a browser session ID

3. **Perform Actions:**
   - Open your website in a new tab
   - Perform actions (view product, add to cart, checkout, etc.)
   - Events will appear in real-time in Events Manager

4. **Verify Parameters:**
   - Click on each event to expand details
   - Check that all parameters are present and correct

### Method 3: Browser Console

1. **Open Developer Tools:**
   - Press F12 or Right-click → Inspect
   - Go to "Console" tab

2. **Check for fbq:**
   - Type: `fbq`
   - Should show the Facebook Pixel function

3. **Monitor Events:**
   - Type: `fbq.queue`
   - Shows all queued events

---

## 📋 Event Checklist

Use this checklist to verify all events are working:

- [ ] **PageView** - Fires on homepage
- [ ] **PageView** - Fires on product listing page
- [ ] **ViewContent** - Fires on product detail page
- [ ] **ViewContent** - Shows correct product name
- [ ] **ViewContent** - Shows correct price
- [ ] **ViewContent** - Shows correct category
- [ ] **AddToCart** - Fires when clicking "Add to Cart"
- [ ] **AddToCart** - Shows correct product details
- [ ] **AddToCart** - Shows correct quantity
- [ ] **InitiateCheckout** - Fires on checkout page load
- [ ] **InitiateCheckout** - Shows correct cart total
- [ ] **InitiateCheckout** - Shows all cart items
- [ ] **Purchase** - Fires on order success page
- [ ] **Purchase** - Shows correct order total
- [ ] **Purchase** - Shows all purchased items

---

## 🔍 Troubleshooting

### Events Not Showing in Pixel Helper

1. **Check if Pixel is installed:**
   - View page source (Ctrl+U)
   - Search for: `1364197498404249`
   - Should find the pixel code in `<head>` section

2. **Check if Pixel is enabled:**
   - Go to https://sjfashionhub.com/admin/facebook
   - Verify "Enable Facebook Pixel Tracking" is checked
   - Pixel ID should be: `1364197498404249`

3. **Clear cache:**
   - Hard refresh: Ctrl+Shift+R
   - Or clear browser cache

### Events Not Showing in Events Manager

1. **Wait a few minutes:**
   - Events can take 1-5 minutes to appear in the main dashboard
   - Use "Test Events" for real-time monitoring

2. **Check browser console for errors:**
   - Press F12 → Console tab
   - Look for any JavaScript errors

3. **Verify ad blockers are disabled:**
   - Ad blockers can prevent pixel from loading
   - Disable for testing

### Missing Parameters

1. **Check browser console:**
   - Look for the `fbq('track', ...)` calls
   - Verify parameters are being passed

2. **Check product data:**
   - Ensure products have categories assigned
   - Ensure products have prices set

---

## 📊 Expected Results in Meta

After events are firing correctly, you should see in Meta Events Manager:

1. **Dashboard Overview:**
   - Total events count increasing
   - Breakdown by event type
   - Event trends over time

2. **Event Details:**
   - Each event with full parameter data
   - Correct currency (INR)
   - Correct values and quantities

3. **Catalog Integration:**
   - Products matched to catalog items
   - Dynamic ads can use this data
   - Retargeting audiences can be created

---

## 🎯 Next Steps After Testing

Once all events are verified:

1. **Create Custom Audiences:**
   - People who viewed products
   - People who added to cart but didn't purchase
   - People who purchased

2. **Set Up Conversions:**
   - Mark "Purchase" as your primary conversion
   - Set up conversion tracking in Ads Manager

3. **Enable Dynamic Ads:**
   - Use catalog + pixel events for dynamic product ads
   - Retarget cart abandoners

4. **Monitor Performance:**
   - Check Events Manager daily
   - Look for any errors or warnings
   - Ensure event quality score is high

---

## 📞 Support

If you encounter any issues:

1. Check this guide first
2. Verify all steps in the checklist
3. Check Meta's official documentation: https://developers.facebook.com/docs/meta-pixel
4. Contact Meta Business Support if needed

---

**Last Updated:** 2025-10-12
**Pixel ID:** 1364197498404249
**Status:** ✅ All events implemented and ready for testing

