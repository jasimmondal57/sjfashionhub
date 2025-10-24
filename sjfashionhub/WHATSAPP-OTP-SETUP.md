# WhatsApp OTP Authentication Setup Guide

## Overview
This guide explains how to set up WhatsApp OTP authentication for mobile login using Meta-approved message templates.

## Features
✅ **AI-Powered Template Generation** - Use Gemini AI to create professional OTP templates  
✅ **Meta Template Approval** - Submit templates to Meta for official approval  
✅ **Automatic Template Usage** - Once approved, OTP messages automatically use the template  
✅ **Fallback Support** - Falls back to regular messages if no approved template exists  
✅ **Status Tracking** - Monitor template approval status in real-time  

---

## Setup Steps

### 1. Access OTP Template Setup Page
Navigate to: **Admin Panel → WhatsApp Marketing → OTP Setup**

Direct URL: `https://sjfashionhub.com/admin/whatsapp-marketing/otp-setup`

### 2. Create OTP Template

#### Option A: Use AI Generator (Recommended)
1. Click on the **AI Template Generator** section
2. Select your preferred:
   - **Tone**: Professional, Friendly, or Urgent
   - **Language**: English, Hindi, or English (US)
3. Click **"✨ Generate with AI"**
4. Review the generated template
5. Make any necessary adjustments
6. Click **"💾 Create Template"**

#### Option B: Create Manually
1. Fill in the template form:
   - **Display Name**: Internal name (e.g., "OTP Login Verification")
   - **Language**: Select template language
   - **Header Text** (Optional): Short header, max 60 chars, **NO EMOJIS**
   - **Body Text** (Required): Main message with `{{1}}` for OTP code
   - **Footer Text** (Optional): Brand name (e.g., "SJ Fashion Hub")
   - **Sample OTP**: Example code for Meta approval (e.g., "123456")
2. Click **"💾 Create Template"**

### 3. Submit Template to Meta
1. After creating the template, click **"📤 Submit to Meta for Approval"**
2. The template will be sent to Meta's WhatsApp Business API
3. Status will change to **"⏳ Pending"**

### 4. Wait for Approval
- **Approval Time**: Usually 1-24 hours
- **Check Status**: Click **"🔄 Check Status"** button periodically
- **Notification**: Status will update automatically when approved

### 5. Test OTP Login
Once approved (status shows **"✅ Approved"**):
1. Visit: `https://sjfashionhub.com/mobile/login`
2. Enter your mobile number
3. Select **"💬 WhatsApp"** as OTP method
4. Click **"Send OTP"**
5. You should receive OTP via WhatsApp using the approved template

---

## Template Requirements (Meta Guidelines)

### ✅ DO's
- Use `{{1}}` for OTP code variable
- Keep header under 60 characters
- Keep body under 1024 characters
- Keep footer under 60 characters
- Use clear, professional language
- Include validity period (e.g., "Valid for 10 minutes")
- Add security warning (e.g., "Do not share this code")

### ❌ DON'Ts
- **NO emojis in header** (Meta will reject)
- No promotional content in AUTHENTICATION category
- No external links
- No misleading information
- No special characters in template name

---

## Template Example

### Good Template ✅
```
Header: Your Login OTP
Body: Your SJ Fashion Hub login OTP is {{1}}

⏰ Valid for 10 minutes
🚫 Do not share this code with anyone

Happy Shopping!
Footer: SJ Fashion Hub
```

### Bad Template ❌
```
Header: 🔐 Your OTP  ← Emoji in header (REJECTED)
Body: Click here to login: https://example.com  ← External link (REJECTED)
Footer: Buy now and get 50% off!  ← Promotional content (REJECTED)
```

---

## Troubleshooting

### Template Rejected by Meta
1. Check the **Rejection Reason** displayed on the OTP Setup page
2. Common reasons:
   - Emojis in header
   - Promotional content in AUTHENTICATION template
   - External links
   - Misleading information
3. Create a new template addressing the issues
4. Submit again

### OTP Not Received
1. **Check Template Status**: Must be "✅ Approved"
2. **Check WhatsApp Settings**: Admin → Communication → WhatsApp Settings
3. **Verify Credentials**:
   - Access Token
   - Phone Number ID
   - Business Account ID
4. **Check Logs**: Admin → Communication → Logs

### Template Status Stuck on "Pending"
1. Wait at least 24 hours
2. Click **"🔄 Check Status"** to refresh
3. If still pending after 48 hours, contact Meta support

---

## Technical Details

### How It Works
1. **Template Creation**: Template is created in database with status "draft"
2. **Submission**: Template is submitted to Meta via WhatsApp Business API
3. **Approval**: Meta reviews and approves/rejects the template
4. **Usage**: `WhatsAppService::sendOtp()` automatically uses approved template
5. **Fallback**: If no approved template, uses regular text message

### Files Modified
- `app/Services/WhatsAppService.php` - Updated to use templates
- `app/Http/Controllers/Admin/WhatsAppMarketingController.php` - Added OTP setup methods
- `resources/views/admin/whatsapp-marketing/otp-setup.blade.php` - New setup page
- `routes/web.php` - Added OTP setup routes

### Database Tables
- `whatsapp_templates` - Stores all WhatsApp templates
- `communication_settings` - Stores WhatsApp API credentials

---

## API Integration

### WhatsApp Business API Endpoints Used

#### Submit Template
```
POST https://graph.facebook.com/v18.0/{business_account_id}/message_templates
```

#### Check Template Status
```
GET https://graph.facebook.com/v18.0/{template_id}
```

#### Send Template Message
```
POST https://graph.facebook.com/v18.0/{phone_number_id}/messages
```

---

## Security Best Practices

1. **Rate Limiting**: Max 3 OTP requests per hour per phone number
2. **OTP Expiry**: OTPs expire after 10 minutes
3. **Secure Storage**: OTPs are hashed in database
4. **Verification Attempts**: Max 3 verification attempts per OTP
5. **Template Security**: Only approved templates can be used

---

## Support

### Need Help?
1. **Check Logs**: Admin → Communication → Logs
2. **Test Connection**: Admin → Communication → WhatsApp Settings → Test Connection
3. **View Template**: Admin → WhatsApp Marketing → Templates
4. **Contact Support**: If issues persist, contact technical support

### Useful Links
- [Meta WhatsApp Business API Docs](https://developers.facebook.com/docs/whatsapp/business-management-api)
- [Template Guidelines](https://developers.facebook.com/docs/whatsapp/business-management-api/message-templates)
- [Authentication Templates](https://developers.facebook.com/docs/whatsapp/business-management-api/message-templates/authentication-templates)

---

## Changelog

### Version 1.0 (2025-10-11)
- ✅ Initial OTP template setup page
- ✅ AI-powered template generation
- ✅ Meta template submission
- ✅ Status tracking
- ✅ Automatic template usage in OTP service
- ✅ Fallback to regular messages

---

**Last Updated**: October 11, 2025  
**Status**: Production Ready ✅

