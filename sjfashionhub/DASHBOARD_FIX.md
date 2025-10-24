# User Dashboard Fixes ✅

## Problems Fixed

### 1. Dashboard Showing 0 Orders
**Problem:** The user dashboard was displaying hardcoded `0` for all statistics (Total Orders, Cart Items, Wishlist) even though the user had actual orders.

**Root Cause:** The dashboard controller was not fetching any statistics from the database. The view had hardcoded values.

**Solution:** 
- Updated `DashboardController::index()` to fetch real statistics from the database
- Modified the view to display dynamic data instead of hardcoded values

### 2. Broken Profile Image
**Problem:** Profile images were showing as broken/not loading, displaying only initials instead.

**Root Cause:** The view was using `Storage::url($user->avatar)` which doesn't work correctly. The User model already has an `avatar_url` accessor that properly generates the full URL.

**Solution:** Changed all avatar image sources from `Storage::url($user->avatar)` to `$user->avatar_url`

---

## Files Modified

### 1. `app/Http/Controllers/User/DashboardController.php`
**Changes:**
- Added statistics calculation in the `index()` method
- Fetches real data: total orders, cart items, wishlist items, total spent

**Before:**
```php
public function index()
{
    $user = Auth::user();
    return view('user.dashboard.index', compact('user'));
}
```

**After:**
```php
public function index()
{
    $user = Auth::user();
    
    // Get dashboard statistics
    $stats = [
        'total_orders' => $user->orders()->count(),
        'cart_items' => $user->cartItems()->count(),
        'wishlist_items' => $user->wishlists()->count(),
        'total_spent' => $user->orders()->where('payment_status', 'completed')->sum('total_amount'),
    ];
    
    return view('user.dashboard.index', compact('user', 'stats'));
}
```

### 2. `resources/views/user/dashboard/index.blade.php`
**Changes:**
- Updated profile image to use `$user->avatar_url` instead of `Storage::url($user->avatar)`
- Changed hardcoded `0` values to dynamic `{{ $stats['total_orders'] }}`, `{{ $stats['cart_items'] }}`, `{{ $stats['wishlist_items'] }}`
- Updated Account Status to show actual user status: `{{ ucfirst($user->status) }}`

**Before:**
```blade
<img src="{{ Storage::url($user->avatar) }}" ...>
<p class="text-2xl font-semibold text-gray-900">0</p>
```

**After:**
```blade
<img src="{{ $user->avatar_url }}" ...>
<p class="text-2xl font-semibold text-gray-900">{{ $stats['total_orders'] }}</p>
```

### 3. `resources/views/user/dashboard/profile.blade.php`
**Changes:**
- Updated profile image to use `$user->avatar_url` instead of `Storage::url($user->avatar)`

---

## How It Works Now

### Dashboard Statistics
The dashboard now displays real-time data:
- **Total Orders**: Counts all orders placed by the user
- **Cart Items**: Counts items currently in the user's shopping cart
- **Wishlist Items**: Counts products in the user's wishlist
- **Account Status**: Shows the actual user account status (Active, Inactive, etc.)

### Profile Image Display
The profile image now uses the `avatar_url` accessor from the User model which:
1. If user has uploaded an avatar: Returns `asset('storage/' . $user->avatar)`
2. If no avatar: Returns a Gravatar URL as fallback
3. If Gravatar not available: The view shows initials in a colored circle

---

## Testing

To verify the fixes:

1. **Dashboard Statistics:**
   - Log in to your account
   - Go to `/account` (User Dashboard)
   - You should see your actual order count, cart items, and wishlist count
   - The numbers should match your actual data

2. **Profile Image:**
   - Go to `/account/profile`
   - If you have uploaded a profile picture, it should display correctly
   - If not, you should see your initials in a circle (not a broken image)

---

## Related Code

### User Model Accessor
The `avatar_url` accessor in `app/Models/User.php`:
```php
public function getAvatarUrlAttribute()
{
    if ($this->avatar) {
        return asset('storage/' . $this->avatar);
    }

    // Generate Gravatar URL as fallback
    $hash = md5(strtolower(trim($this->email)));
    return "https://www.gravatar.com/avatar/{$hash}?d=identicon&s=200";
}
```

### User Relationships
The User model has these relationships used for statistics:
- `orders()` - HasMany relationship with Order model
- `cartItems()` - HasMany relationship with Cart model
- `wishlists()` - HasMany relationship with Wishlist model

---

## Deployment

Files deployed to production:
```bash
scp app/Http/Controllers/User/DashboardController.php root@72.60.102.152:/var/www/sjfashionhub.com/app/Http/Controllers/User/
scp resources/views/user/dashboard/index.blade.php root@72.60.102.152:/var/www/sjfashionhub.com/resources/views/user/dashboard/
scp resources/views/user/dashboard/profile.blade.php root@72.60.102.152:/var/www/sjfashionhub.com/resources/views/user/dashboard/
ssh root@72.60.102.152 "cd /var/www/sjfashionhub.com && php artisan view:clear && php artisan cache:clear"
```

---

## Additional Fix 1: Missing Cart Relationship

### Problem
After deploying the initial fix, the dashboard returned a 500 error:
```
Call to undefined method App\Models\User::cartItems()
```

### Root Cause
The User model was missing the `carts()` relationship method. The controller was calling `$user->cartItems()` but the relationship didn't exist.

### Solution
1. Added `carts()` relationship to the User model
2. Updated the controller to use `carts()` instead of `cartItems()`

### Files Modified
- `app/Models/User.php` - Added `carts()` relationship
- `app/Http/Controllers/User/DashboardController.php` - Changed `cartItems()` to `carts()`

---

## Additional Fix 2: Google Avatar URL Not Displaying

### Problem
Users who logged in with Google had broken profile images showing 404 errors. The error was:
```
ACg8ocIAsfGK2UyNlrdUF-AM3Ak1IxuAq9g0bqj9CGFhRBro3cvaHWbr=s96-c:1 Failed to load resource: the server responded with a status of 404 ()
```

### Root Cause
When users log in with Google, their Google profile picture URL (e.g., `https://lh3.googleusercontent.com/...`) is saved directly in the `avatar` field. However, the `avatar_url` accessor was treating ALL avatar values as local file paths and prepending `asset('storage/')` to them, which broke external URLs.

### Solution
Updated the `avatar_url` accessor to detect if the avatar is already a full URL (from social login) or a local file path:

**Before:**
```php
public function getAvatarUrlAttribute()
{
    if ($this->avatar) {
        return asset('storage/' . $this->avatar);
    }

    // Generate Gravatar URL as fallback
    $hash = md5(strtolower(trim($this->email)));
    return "https://www.gravatar.com/avatar/{$hash}?d=identicon&s=200";
}
```

**After:**
```php
public function getAvatarUrlAttribute()
{
    if ($this->avatar) {
        // Check if avatar is already a full URL (from social login)
        if (filter_var($this->avatar, FILTER_VALIDATE_URL)) {
            return $this->avatar;
        }

        // Otherwise, it's a local file path
        return asset('storage/' . $this->avatar);
    }

    // Generate Gravatar URL as fallback
    $hash = md5(strtolower(trim($this->email)));
    return "https://www.gravatar.com/avatar/{$hash}?d=identicon&s=200";
}
```

### How It Works Now
The `avatar_url` accessor now handles three scenarios:
1. **External URL** (from Google/Facebook login): Returns the URL as-is
2. **Local file path** (uploaded by user): Prepends `asset('storage/')` to create the full URL
3. **No avatar**: Returns a Gravatar URL as fallback

### Files Modified
- `app/Models/User.php` - Updated `getAvatarUrlAttribute()` method

---

## Status: ✅ FIXED

All issues have been resolved:
- ✅ Dashboard now shows real order counts and statistics
- ✅ Profile images display correctly using the avatar_url accessor
- ✅ Cart relationship added to User model
- ✅ 500 error fixed
- ✅ Google/Facebook profile pictures now display correctly
- ✅ Avatar URL accessor handles both external URLs and local file paths

