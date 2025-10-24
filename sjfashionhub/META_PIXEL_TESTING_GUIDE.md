# 📊 Meta Pixel Event Tracking - Testing Guide

## ✅ What's Been Fixed

Your website now properly tracks **ALL Meta Pixel events** with complete parameters:

### Events Implemented:
1. **PageView** - Automatic on every page load
2. **ViewContent** - When viewing product details
3. **AddToCart** - When adding products to cart
4. **InitiateCheckout** - When proceeding to checkout
5. **Purchase** - When order is completed

---

## 🧪 Testing Methods

### Method 1: Using Meta Pixel Helper (Browser Extension)

**Step 1: Install Meta Pixel Helper**
- Go to Chrome Web Store: https://chrome.google.com/webstore
- Search for "Meta Pixel Helper"
- Click "Add to Chrome"

**Step 2: Test Each Event**

a) **PageView** (Automatic)
   - Visit any page on sjfashionhub.com
   - Pixel Helper should show: ✅ PageView

b) **ViewContent**
   - Click on any product
   - Pixel Helper should show: ✅ ViewContent
   - Verify parameters: content_name, content_category, value, currency

c) **AddToCart**
   - Click "Add to Cart" button on product page
   - Pixel Helper should show: ✅ AddToCart
   - Verify: content_name, value, currency, contents array

d) **InitiateCheckout**
   - Go to cart and click "Proceed to Checkout"
   - Pixel Helper should show: ✅ InitiateCheckout
   - Verify: cart total, item count, contents

e) **Purchase**
   - Complete an order (use COD for testing)
   - On success page, Pixel Helper should show: ✅ Purchase
   - Verify: order total, items, currency

---

### Method 2: Meta Events Manager (Real-time Testing)

**Step 1: Access Events Manager**
- Go to: https://business.facebook.com/events_manager2
- Select your Pixel (ID: 1364197498404249)

**Step 2: Open Test Events**
- Click "Test Events" in left sidebar
- You'll see a browser session ID

**Step 3: Perform Actions**
- Add products to cart
- Complete a purchase
- Watch events appear in real-time in Events Manager

---

### Method 3: Browser Console Debugging

**Step 1: Open Developer Console**
- Press F12 or right-click → Inspect → Console tab

**Step 2: Look for Console Logs**
When you perform actions, you should see:
```
📊 Meta Pixel - Tracking AddToCart: {object}
📊 Meta Pixel - Tracking Purchase: {object}
📊 Meta Pixel - Tracking ViewContent: {object}
📊 Meta Pixel - Tracking InitiateCheckout: {object}
```

**Step 3: Check for Errors**
- Look for any red error messages
- If fbq is not defined, the pixel script didn't load

---

## 🔍 Troubleshooting

### Issue: Events not appearing in Meta Events Manager

**Solution 1: Check Pixel ID**
- Verify pixel ID is correct in Admin → Analytics Settings
- Current ID: 1364197498404249

**Solution 2: Clear Browser Cache**
- Hard refresh: Ctrl+Shift+R (Windows) or Cmd+Shift+R (Mac)
- Clear cookies for sjfashionhub.com

**Solution 3: Check Console for Errors**
- Open F12 → Console
- Look for any JavaScript errors
- Check if fbq is defined

**Solution 4: Verify Pixel is Active**
- Go to Admin → Analytics Settings
- Ensure "Facebook Pixel" is enabled
- Ensure Pixel ID is filled in

---

## 📝 Event Parameters Reference

### AddToCart
```javascript
{
  content_name: "Product Name",
  content_category: "Fashion",
  content_ids: ["123"],
  content_type: "product",
  value: 999,
  currency: "INR",
  contents: [{
    id: "123",
    quantity: 1,
    item_price: 999
  }]
}
```

### Purchase
```javascript
{
  content_type: "product",
  value: 2999,
  currency: "INR",
  content_ids: ["123", "456"],
  num_items: 2,
  contents: [{
    id: "123",
    quantity: 1,
    item_price: 999
  }, ...]
}
```

---

## ✨ Next Steps

1. **Test all events** using the methods above
2. **Monitor Events Manager** for 24-48 hours
3. **Create campaigns** once events are confirmed
4. **Set up conversions** for Purchase events
5. **Build audiences** based on user actions

---

## 📞 Support

If events are still not appearing:
1. Check browser console for errors (F12)
2. Verify pixel ID in admin settings
3. Ensure pixel is enabled
4. Check Meta Pixel Helper extension
5. Contact support with console error messages

