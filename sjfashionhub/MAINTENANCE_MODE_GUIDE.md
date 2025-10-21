# Maintenance Mode System - Complete Guide

## 🎯 Overview

Your site now has a professional maintenance mode system that allows you to:
- ✅ Put your site in maintenance mode with one click
- ✅ Set an optional password for authorized access
- ✅ Customize maintenance message and title
- ✅ Set expected end time
- ✅ Admin panel always remains accessible
- ✅ Beautiful, responsive maintenance page

## 🚀 Quick Start

### Enable Maintenance Mode

1. Go to **Admin Panel** → **Maintenance Mode**
2. Click **"⚠ Enable Maintenance Mode"** button
3. (Optional) Enter a password to restrict access
4. Click the button to enable

### Disable Maintenance Mode

1. Go to **Admin Panel** → **Maintenance Mode**
2. Click **"✓ Disable Maintenance Mode"** button
3. Site is immediately back online

## 📋 Features

### 1. **Toggle Maintenance Mode**
- One-click enable/disable
- Status indicator (🔴 ACTIVE / 🟢 INACTIVE)
- Shows when maintenance was started

### 2. **Password Protection (Optional)**
- Set optional password when enabling
- Users must enter password to access site
- Password is hashed and secure
- Can be cleared anytime

### 3. **Customize Message**
- Set custom maintenance title
- Write custom maintenance message
- Set expected end time
- All displayed on maintenance page

### 4. **Beautiful Maintenance Page**
- Responsive design (mobile-friendly)
- Animated icons and effects
- Shows expected end time if set
- Password form if protected
- Professional appearance

### 5. **Admin Access**
- Admin panel always accessible
- Bypass maintenance mode completely
- Can manage settings during maintenance

## 🔧 Admin Panel Usage

### Access Maintenance Settings

```
URL: https://sjfashionhub.com/admin/maintenance
```

### Settings Available

| Setting | Description |
|---------|-------------|
| **Status** | Current maintenance mode status |
| **Password** | Optional password for access |
| **Title** | Maintenance page title |
| **Message** | Maintenance page description |
| **Expected End** | When site will be back online |

## 🔐 Password Protection

### Setting a Password

1. Go to Maintenance Mode admin panel
2. Enter password in "Maintenance Password" field
3. Click "Enable Maintenance Mode"
4. Users must enter this password to access site

### Removing Password

1. Go to Maintenance Mode admin panel
2. Click "Remove Password" button
3. Site becomes accessible without password

### Password Requirements

- Minimum 4 characters
- Hashed with bcrypt (secure)
- Session-based verification
- Expires when browser closes

## 📱 User Experience

### Without Password

Users see:
- Beautiful maintenance page
- Maintenance message
- Expected end time (if set)
- No password form

### With Password

Users see:
- Beautiful maintenance page
- Maintenance message
- Password input field
- "Access Site" button

### After Password Entry

- User is granted access
- Session is created
- Can browse site normally
- Access persists until browser closes

## 🎨 Customization

### Change Maintenance Title

1. Go to Maintenance Mode admin panel
2. Edit "Maintenance Title" field
3. Click "Save Settings"

### Change Maintenance Message

1. Go to Maintenance Mode admin panel
2. Edit "Maintenance Message" textarea
3. Click "Save Settings"

### Set Expected End Time

1. Go to Maintenance Mode admin panel
2. Select date/time in "Expected End Time" field
3. Click "Save Settings"
4. Time displays on maintenance page

## 📊 Database

### Maintenance Settings Table

```sql
CREATE TABLE maintenance_settings (
    id BIGINT PRIMARY KEY,
    is_enabled BOOLEAN DEFAULT false,
    password VARCHAR(255) NULLABLE,
    message TEXT NULLABLE,
    title VARCHAR(255),
    description TEXT,
    started_at TIMESTAMP NULLABLE,
    expected_end_at TIMESTAMP NULLABLE,
    enabled_by BIGINT NULLABLE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);
```

## 🔄 How It Works

### Request Flow

```
User Request
    ↓
MaintenanceMode Middleware
    ↓
Is maintenance enabled?
    ├─ NO → Continue normally
    └─ YES → Check password
        ├─ No password set → Show maintenance page
        ├─ Password set & verified → Continue
        └─ Password set & not verified → Show password form
```

### Admin Bypass

- Admin panel routes bypass maintenance mode
- Admins can always access `/admin/*`
- Maintenance page itself is accessible

## 🛠️ Technical Details

### Files Involved

- `app/Models/MaintenanceSetting.php` - Database model
- `app/Http/Controllers/Admin/MaintenanceController.php` - Admin settings
- `app/Http/Controllers/MaintenanceController.php` - Public password verification
- `app/Http/Middleware/MaintenanceMode.php` - Request interception
- `resources/views/maintenance.blade.php` - Maintenance page
- `resources/views/admin/maintenance/index.blade.php` - Admin panel
- `database/migrations/2025_10_21_create_maintenance_settings_table.php` - Database

### Routes

```php
// Admin routes
GET  /admin/maintenance              - Show settings
POST /admin/maintenance/toggle       - Enable/disable
PUT  /admin/maintenance/update       - Update settings
POST /admin/maintenance/clear-password - Remove password

// Public routes
GET  /maintenance                    - Show maintenance page
POST /maintenance/verify             - Verify password
```

## 📝 Logging

All maintenance actions are logged:

```
[INFO] Maintenance mode enabled
[INFO] Maintenance mode disabled
[INFO] Maintenance settings updated
[INFO] Maintenance password cleared
```

Check logs at: `/storage/logs/laravel.log`

## ⚠️ Important Notes

1. **Admin Panel Always Works** - Admins can always access admin panel
2. **Session-Based** - Password verification uses sessions
3. **Hashed Passwords** - Passwords are bcrypt hashed
4. **Middleware Order** - Maintenance middleware runs after auth
5. **Cache Clear** - Caches are cleared when deployed

## 🧪 Testing

### Test Without Password

1. Enable maintenance mode (no password)
2. Visit site in incognito window
3. Should see maintenance page
4. No password form shown

### Test With Password

1. Enable maintenance mode with password "test123"
2. Visit site in incognito window
3. Should see maintenance page with password form
4. Enter wrong password → Error message
5. Enter correct password → Access granted

### Test Admin Access

1. Enable maintenance mode
2. Login to admin panel
3. Admin panel should work normally
4. Can access `/admin/maintenance` to disable

## 🚀 Best Practices

1. **Notify Users** - Set expected end time
2. **Clear Message** - Explain why maintenance is happening
3. **Test First** - Test in incognito window before enabling
4. **Set Password** - Use password for sensitive maintenance
5. **Monitor** - Check logs for any issues
6. **Disable Promptly** - Disable as soon as maintenance is done

## 📞 Support

For issues or questions:
1. Check admin maintenance panel
2. Review logs at `/storage/logs/laravel.log`
3. Verify middleware is registered in `bootstrap/app.php`
4. Check database table exists: `maintenance_settings`

