# Website Matching Requirements for Flutter App

## Current Status
✅ **Backend API is working** - Registration and login endpoints are functional  
❌ **UI doesn't match website** - App uses purple theme, website uses black/white/gray  
❌ **Missing features** - Social login, OTP login, country code selector, etc.

---

## Website Analysis

### **Color Scheme**
- **Primary**: Black (#000000)
- **Secondary**: White (#FFFFFF)
- **Text**: Gray shades
- **Accent**: Minimal color usage
- **Buttons**: Black background with white text

### **Login Page Features** (https://sjfashionhub.com/login)
1. ✅ Email field
2. ✅ Password field
3. ❌ Remember me checkbox
4. ❌ Forgot password link
5. ❌ Social login (Google, Facebook)
6. ❌ Mobile OTP login option
7. ❌ Link to admin login
8. ✅ Link to register page

### **Register Page Features** (https://sjfashionhub.com/register)
1. ✅ Full Name (required)
2. ✅ Email (required)
3. ❌ Phone Number with country code dropdown (required)
   - Countries: India (+91), USA (+1), UK (+44), UAE (+971), Saudi Arabia (+966), Singapore (+65), Malaysia (+60), Australia (+61), Germany (+49), France (+33)
4. ✅ Password (min 8 characters, required)
5. ✅ Confirm Password (required)
6. ❌ Verification method selector (Phone/Email)
7. ❌ Social registration (Google, Facebook)
8. ✅ Link to login page

### **Validation Rules from Website**

#### **Name Validation:**
- Minimum 2 characters
- Maximum 255 characters

#### **Email Validation:**
- Valid email format
- Unique (not already registered)

#### **Phone Validation:**
- Numbers only
- Length based on country code:
  - India (+91): 10 digits
  - USA (+1): 10 digits
  - UK (+44): 10-11 digits
  - Others: Up to 15 digits

#### **Password Validation:**
- Minimum 8 characters
- Must match confirmation

---

## Required Changes

### **1. Update Color Scheme**
Replace all purple (`Color(0xFF7C3AED)`) with black/white theme:
- Primary button: Black background, white text
- Secondary button: White background, black text with border
- Text: Black for headings, gray for body
- Background: White

### **2. Login Screen Updates**
**Add:**
- Remember me checkbox
- Forgot password link
- Social login buttons (Google, Facebook)
- Mobile OTP login button
- Admin login link

**Update:**
- Button colors to black
- Logo/branding to match website
- Input field styling

### **3. Register Screen Updates**
**Add:**
- Country code dropdown for phone number
- Phone number validation based on country
- Verification method selector (Phone/Email radio buttons)
- Social registration buttons (Google, Facebook)
- Password strength indicator
- Terms and conditions checkbox (if needed)

**Update:**
- Button colors to black
- Input field styling
- Validation messages

### **4. API Integration Updates**
**Register API should send:**
```json
{
  "name": "Full Name",
  "email": "email@example.com",
  "phone": "+919876543210",  // Country code + number
  "password": "password123",
  "password_confirmation": "password123",
  "verification_method": "phone"  // or "email"
}
```

**Login API should send:**
```json
{
  "email": "email@example.com",
  "password": "password123",
  "remember": true  // if remember me is checked
}
```

### **5. Additional Features to Implement**

#### **Social Login (Google & Facebook)**
- Integrate Firebase Auth or use OAuth
- Send social login token to backend
- Backend should create/login user with social credentials

#### **Mobile OTP Login**
- Add phone number input screen
- Request OTP from backend
- Verify OTP and login

#### **Forgot Password**
- Add forgot password screen
- Send reset link to email
- Password reset flow

#### **Admin Login**
- Separate admin login screen or redirect to web admin panel

---

## Implementation Priority

### **Phase 1: Critical (Do First)**
1. ✅ Fix backend API (HasApiTokens) - **DONE**
2. ✅ Fix error handling - **DONE**
3. Update color scheme to black/white
4. Add country code selector to register
5. Update phone validation

### **Phase 2: Important**
1. Add remember me checkbox
2. Add forgot password link
3. Add verification method selector
4. Improve form validation messages

### **Phase 3: Nice to Have**
1. Social login (Google, Facebook)
2. Mobile OTP login
3. Admin login link
4. Password strength indicator

---

## Files to Update

### **Colors/Theme**
- `lib/main.dart` - Update theme colors
- `lib/screens/auth/login_screen.dart` - Update button and text colors
- `lib/screens/auth/register_screen.dart` - Update button and text colors
- `lib/screens/home/home_screen.dart` - Update app bar and UI colors

### **Login Screen**
- `lib/screens/auth/login_screen.dart`
  - Add remember me checkbox
  - Add forgot password link
  - Add social login buttons
  - Add OTP login button
  - Update colors

### **Register Screen**
- `lib/screens/auth/register_screen.dart`
  - Add country code dropdown
  - Add verification method selector
  - Add social registration buttons
  - Update phone validation
  - Update colors

### **New Screens to Create**
- `lib/screens/auth/forgot_password_screen.dart`
- `lib/screens/auth/otp_login_screen.dart`
- `lib/screens/auth/otp_verify_screen.dart`

---

## Next Steps

**Would you like me to:**

1. **Update colors only** - Quick fix to match website theme
2. **Add country code selector** - Important for phone validation
3. **Complete redesign** - Match website exactly with all features
4. **Prioritize specific features** - Tell me which features are most important

**Please let me know which approach you prefer, and I'll implement it!**

---

## Current App Status

✅ **Working:**
- User registration (creates account, sends welcome email)
- User login (returns auth token)
- API integration
- Error handling
- Token storage

❌ **Not Matching Website:**
- Color scheme (purple vs black/white)
- Missing social login
- Missing OTP login
- Missing country code selector
- Missing verification method selector
- Missing remember me
- Missing forgot password

---

## Testing Credentials

**Test Account:**
- Email: testuser2@example.com
- Password: password123

**API Endpoints:**
- Register: POST https://sjfashionhub.com/api/mobile/auth/register
- Login: POST https://sjfashionhub.com/api/mobile/auth/login

