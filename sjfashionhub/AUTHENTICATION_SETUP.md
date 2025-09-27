# 🔐 Multi-Authentication System Setup Guide

## 🚀 Features Implemented

### ✅ Social Login Integration
- **Google OAuth** - Login/Register with Google account
- **Facebook OAuth** - Login/Register with Facebook account
- **Automatic Account Linking** - Links social accounts to existing emails
- **Profile Data Sync** - Imports name, email, avatar from social providers

### ✅ Mobile OTP Authentication
- **SMS OTP** - Login with mobile number via SMS
- **WhatsApp OTP** - Login with mobile number via WhatsApp
- **10-minute OTP Expiry** - Secure time-limited verification
- **Rate Limiting** - Max 3 OTPs per hour per number
- **Auto User Creation** - Creates accounts for new mobile users

## 🔧 Environment Configuration

Add these variables to your `.env` file:

### Google OAuth Setup
```env
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=https://sjfashionhub.in/auth/google/callback
```

### Facebook OAuth Setup
```env
FACEBOOK_CLIENT_ID=your_facebook_app_id
FACEBOOK_CLIENT_SECRET=your_facebook_app_secret
FACEBOOK_REDIRECT_URI=https://sjfashionhub.in/auth/facebook/callback
```

### SMS Configuration (Textlocal)
```env
SMS_API_KEY=your_textlocal_api_key
SMS_SENDER_ID=SJFASHION
SMS_BASE_URL=https://api.textlocal.in/send/
```

### WhatsApp Business API Configuration
```env
WHATSAPP_ACCESS_TOKEN=your_whatsapp_access_token
WHATSAPP_PHONE_NUMBER_ID=your_phone_number_id
WHATSAPP_BASE_URL=https://graph.facebook.com/v18.0
```

## 📱 How to Get API Credentials

### Google OAuth Setup:
1. Go to [Google Cloud Console](https://console.cloud.google.com/)
2. Create a new project or select existing
3. Enable Google+ API
4. Create OAuth 2.0 credentials
5. Add authorized redirect URI: `https://sjfashionhub.in/auth/google/callback`

### Facebook OAuth Setup:
1. Go to [Facebook Developers](https://developers.facebook.com/)
2. Create a new app
3. Add Facebook Login product
4. Add redirect URI: `https://sjfashionhub.in/auth/facebook/callback`
5. Get App ID and App Secret

### SMS Provider (Textlocal):
1. Sign up at [Textlocal](https://www.textlocal.in/)
2. Get API key from dashboard
3. Verify your sender ID

### WhatsApp Business API:
1. Set up WhatsApp Business API through Meta
2. Get access token and phone number ID
3. Configure webhook for message delivery

## 🎯 Available Authentication Methods

### 1. Email & Password (Default)
- Traditional login with email and password
- Available at: `https://sjfashionhub.in/login`

### 2. Google Social Login
- One-click login with Google account
- Redirects to: `https://sjfashionhub.in/auth/google/redirect`

### 3. Facebook Social Login
- One-click login with Facebook account
- Redirects to: `https://sjfashionhub.in/auth/facebook/redirect`

### 4. Mobile OTP Login
- Login with mobile number and OTP
- Available at: `https://sjfashionhub.in/mobile/login`
- Supports both SMS and WhatsApp delivery

## 🛡️ Security Features

- **Rate Limiting**: Max 3 OTP requests per hour per phone number
- **OTP Expiry**: All OTPs expire after 10 minutes
- **Secure Storage**: Social provider tokens are encrypted
- **Phone Verification**: Track verified phone numbers
- **Login Type Tracking**: Monitor how users authenticate

## 🔄 User Experience Flow

### Social Login:
1. User clicks "Continue with Google/Facebook"
2. Redirected to provider for authentication
3. Returns with profile data
4. Account created or linked automatically
5. User logged in immediately

### Mobile OTP Login:
1. User enters mobile number
2. Selects SMS or WhatsApp delivery
3. Receives 6-digit OTP
4. Enters OTP for verification
5. Account created or logged in automatically

## 📊 Database Changes

### Users Table - New Columns:
- `provider` - Social login provider (google, facebook)
- `provider_id` - Provider's user ID
- `phone_verified_at` - Phone verification timestamp
- `login_type` - How user logged in (email, google, facebook, phone)

### New Table: otp_verifications
- Stores OTP codes with expiry and attempt tracking
- Automatic cleanup of expired OTPs

## 🚀 Testing

### Local Testing (Development):
- SMS and WhatsApp messages are logged instead of sent
- Check Laravel logs for OTP codes during testing
- Social login works with proper OAuth setup

### Production Testing:
- Ensure all API credentials are configured
- Test each authentication method
- Verify OTP delivery via SMS and WhatsApp
- Check social login redirects work correctly

## 📞 Support

If you need help setting up any of these authentication methods:
1. Check Laravel logs for detailed error messages
2. Verify all environment variables are set correctly
3. Ensure OAuth redirect URIs match exactly
4. Test API credentials with provider documentation

## 🎉 Ready to Use!

Your multi-authentication system is now live at:
- **Main Login**: https://sjfashionhub.in/login
- **Mobile Login**: https://sjfashionhub.in/mobile/login
- **Register**: https://sjfashionhub.in/register

All authentication methods are fully integrated and ready for production use!
