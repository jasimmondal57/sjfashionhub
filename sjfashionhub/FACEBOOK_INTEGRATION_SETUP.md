# 📘 Facebook Integration Setup Guide

## ✅ What's Been Installed

Your SJ Fashion Hub now has complete Facebook integration with:

1. **Facebook Pixel** - Track user behavior and conversions
2. **Product Catalog Sync** - Automatically sync products to Facebook
3. **Auto Inventory Updates** - Real-time stock updates to Facebook
4. **Auto Price Updates** - Automatic price sync when changed
5. **Product Feed XML** - Generate feed for Facebook catalog

---

## 🚀 Quick Setup

### Step 1: Access Facebook Integration
Go to: **https://sjfashionhub.com/admin/facebook**

You'll see the Facebook Integration dashboard with:
- Facebook Pixel Settings
- Facebook Catalog Settings
- Sync statistics
- Recent sync logs

---

## 📊 Facebook Pixel Setup

### 1. Get Your Pixel ID

1. Go to [Meta Events Manager](https://business.facebook.com/events_manager2)
2. Select your Pixel or create a new one
3. Copy the **Pixel ID** (15-digit number)

### 2. Configure in Admin Panel

1. Go to **Admin → Facebook Integration**
2. In "Facebook Pixel Settings" section:
   - Enter your **Pixel ID**
   - Check **"Enable Facebook Pixel Tracking"**
   - Select events to track:
     - ✅ PageView
     - ✅ ViewContent (product pages)
     - ✅ AddToCart
     - ✅ InitiateCheckout
     - ✅ Purchase
     - ✅ Search
     - ✅ AddToWishlist
3. Click **"Save Pixel Settings"**

### 3. Verify Installation

1. Install [Facebook Pixel Helper](https://chrome.google.com/webstore/detail/facebook-pixel-helper/) Chrome extension
2. Visit your website
3. Click the extension icon - you should see your Pixel firing

---

## 🛍️ Facebook Catalog Setup

### 1. Create Facebook Catalog

1. Go to [Meta Commerce Manager](https://business.facebook.com/commerce/)
2. Click **"Create Catalog"**
3. Select **"E-commerce"**
4. Name it (e.g., "SJ Fashion Hub Products")
5. **IMPORTANT**: Set currency to **INR (Indian Rupee)**
6. Copy the **Catalog ID** (from URL or settings)

### 2. Get Access Token

**Option A: Using Meta Business Suite**
1. Go to [Meta Business Settings](https://business.facebook.com/settings/)
2. Click **"System Users"** → Create system user
3. Assign catalog permissions
4. Generate **Long-Lived Access Token**

**Option B: Using Graph API Explorer**
1. Go to [Graph API Explorer](https://developers.facebook.com/tools/explorer/)
2. Select your app
3. Get Token → Get User Access Token
4. Select permissions: `catalog_management`, `business_management`
5. Generate token
6. Extend to long-lived token using [Access Token Tool](https://developers.facebook.com/tools/accesstoken/)

### 3. Configure in Admin Panel

1. Go to **Admin → Facebook Integration**
2. In "Facebook Catalog Settings" section:
   - **Access Token**: Paste your long-lived token
   - **Catalog ID**: Enter your catalog ID
   - **Business ID**: (Optional) Your Meta Business ID
   - **App ID**: (Optional) Your Facebook App ID
   - **App Secret**: (Optional) Your App Secret
   
3. Enable features:
   - ✅ **Enable Catalog Sync**
   - ✅ **Auto-sync Inventory Updates**
   - ✅ **Auto-sync Price Updates**
   
4. Set **Sync Frequency**: 6 hours (recommended)

5. Click **"Save Catalog Settings"**

### 4. Test Connection

1. Click **"Test Connection"** button
2. You should see: ✅ Connection successful!
3. It will show your catalog name and product count

---

## 🔄 Syncing Products

### Initial Sync (First Time)

1. Go to **Admin → Facebook Integration**
2. Click **"Sync All Products Now"**
3. Wait for sync to complete
4. Check stats to see synced products

### Automatic Sync

Products are automatically synced when:
- ✅ New product is created
- ✅ Product is updated (name, description, image, etc.)
- ✅ Stock quantity changes (if auto-sync enabled)
- ✅ Price changes (if auto-sync enabled)
- ✅ Product is deleted (removed from Facebook too)

### Manual Sync

From **Admin → Products**:
- Each product will have a "Sync to Facebook" button
- Click to manually sync individual products

---

## 📥 Product Feed XML

### Generate Feed

1. Go to **Admin → Facebook Integration**
2. Click **"Download Feed XML"**
3. Save the file

### Use Feed in Facebook

1. Go to your Facebook Catalog
2. Click **"Add Items"** → **"Use Data Feed"**
3. Upload the XML file OR
4. Use scheduled fetch with URL: `https://sjfashionhub.com/admin/facebook/download-feed`

---

## 🎯 What Gets Synced

For each product, Facebook receives:
- **ID**: Product ID
- **Name**: Product name
- **Description**: Product description (HTML stripped)
- **Price**: Current price (sale price if available)
- **Image**: Main product image
- **Link**: Direct link to product page
- **Availability**: In stock / Out of stock
- **Inventory**: Stock quantity
- **Brand**: SJ Fashion Hub (or product brand)
- **Category**: Product category
- **Condition**: New

---

## 📊 Monitoring & Logs

### View Sync Logs

1. Go to **Admin → Facebook Integration**
2. Scroll to "Recent Sync Activity"
3. Or click **"View Sync Logs"** for full history

### Check Product Status

1. Go to **Admin → Facebook Integration**
2. Scroll to bottom to see all products
3. Status indicators:
   - 🟢 **Synced**: Successfully synced to Facebook
   - 🟡 **Pending**: Waiting to be synced
   - 🔴 **Failed**: Sync failed (check error message)

---

## 🔧 Troubleshooting

### Pixel Not Firing

1. Check if Pixel ID is correct
2. Ensure "Enable Facebook Pixel Tracking" is checked
3. Clear browser cache
4. Use Facebook Pixel Helper to debug

### Catalog Sync Failing

1. Click "Test Connection" to verify credentials
2. Check if Access Token is valid (they expire!)
3. Verify Catalog ID is correct
4. Check sync logs for error messages

### Products Not Syncing

1. Ensure product status is "Active"
2. Check if auto-sync is enabled
3. Manually click "Sync All Products Now"
4. Check individual product sync status

### Access Token Expired

1. Generate new long-lived access token
2. Update in **Admin → Facebook Integration**
3. Click "Save Catalog Settings"
4. Test connection

---

## 🎨 Advanced Features

### Custom Sync Frequency

Change how often full catalog syncs run:
- Minimum: 1 hour
- Maximum: 168 hours (1 week)
- Recommended: 6 hours

### Selective Sync

- Only **active** products are synced
- Inactive/draft products are automatically excluded
- Deleted products are removed from Facebook

### Inventory Management

When auto-sync inventory is enabled:
- Stock changes trigger immediate Facebook update
- "Out of stock" products marked as unavailable
- Stock restored → automatically marked as "in stock"

---

## 📱 WhatsApp Commerce Integration

Once catalog is synced to Facebook, you can enable WhatsApp Commerce:

1. Products appear in WhatsApp Business catalog
2. Customers can browse products in WhatsApp
3. Place orders directly via WhatsApp
4. Orders sync back to your system

*(This requires WhatsApp Business API setup)*

---

## 🔐 Security Best Practices

1. **Never share** your Access Token publicly
2. Use **System User tokens** (not personal tokens)
3. Set token to **never expire** or set calendar reminder to renew
4. Limit token permissions to only what's needed
5. Rotate tokens periodically

---

## 📞 Support

If you need help:
1. Check sync logs for error messages
2. Test connection to verify credentials
3. Ensure Facebook Business account is active
4. Check Meta Business Suite for catalog status

---

## ✨ Benefits

✅ **Automatic Product Sync** - No manual updates needed  
✅ **Real-time Inventory** - Always accurate stock levels  
✅ **Dynamic Pricing** - Prices update automatically  
✅ **Conversion Tracking** - See what's working  
✅ **Retargeting** - Show ads to visitors  
✅ **WhatsApp Commerce** - Sell via WhatsApp  
✅ **Facebook Shop** - Sell on Facebook/Instagram  

---

**Your Facebook integration is now complete! 🎉**

Visit: https://sjfashionhub.com/admin/facebook to get started!

