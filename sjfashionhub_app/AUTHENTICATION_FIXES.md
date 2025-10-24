# Authentication & Cart/Wishlist Fixes

## Issues Fixed

1. ✅ **Buy Now button error** - Fixed routing issue
2. ✅ **Add to cart not working** - Added authentication check
3. ✅ **Wishlist not working** - Added authentication check
4. ✅ **Inventory tracking** - Requires backend API (cart/wishlist need authentication)

---

## Root Cause

The cart and wishlist APIs require authentication (`auth:sanctum` middleware in Laravel). When users click "Continue as Guest", they don't have authentication tokens, so cart and wishlist operations fail.

**Backend API Routes (routes/api.php):**
```php
Route::middleware('auth:sanctum')->group(function () {
    // Cart - REQUIRES AUTHENTICATION
    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    
    // Wishlist - REQUIRES AUTHENTICATION
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist', [WishlistController::class, 'store']);
});
```

---

## Solutions Implemented

### 1. Fixed Buy Now Button Error

**Problem:** App crashed with routing error when clicking "Buy Now"

**Error Message:**
```
Failed to proceed: Could not find a generator for route RouteSettings('/checkout', null) in the _WidgetsAppState.
```

**Solution:** 
1. Added routes to `main.dart`
2. Changed buy now to navigate to cart tab instead of checkout
3. Added MainScreen import to product detail screen

**Files Modified:**
- `lib/main.dart` - Added routes configuration
- `lib/screens/main_screen.dart` - Added `initialIndex` parameter
- `lib/screens/products/product_detail_screen.dart` - Fixed navigation

**Code Changes:**

**main.dart:**
```dart
routes: {
  '/main': (context) => const MainScreen(),
  '/login': (context) => const LoginScreenNew(),
  '/checkout': (context) => const CheckoutScreen(),
  '/orders': (context) => const OrdersScreen(),
  '/addresses': (context) => const AddressesScreen(),
},
```

**main_screen.dart:**
```dart
class MainScreen extends StatefulWidget {
  final int initialIndex;
  
  const MainScreen({super.key, this.initialIndex = 0});
  
  @override
  State<MainScreen> createState() => _MainScreenState();
}

class _MainScreenState extends State<MainScreen> {
  late int _currentIndex;
  
  @override
  void initState() {
    super.initState();
    _currentIndex = widget.initialIndex;
  }
  // ...
}
```

**product_detail_screen.dart - Buy Now:**
```dart
Future<void> _buyNow() async {
  // Check if user is authenticated
  if (!_apiService.isAuthenticated) {
    if (mounted) {
      _showLoginPrompt('proceed to checkout');
    }
    return;
  }

  try {
    final success = await _cartService.addToCart(widget.productId, _quantity);
    
    if (mounted) {
      if (success) {
        // Navigate to main screen with cart tab selected (index 2)
        Navigator.pushAndRemoveUntil(
          context,
          MaterialPageRoute(builder: (_) => MainScreen(initialIndex: 2)),
          (route) => false,
        );
      } else {
        // Show error
      }
    }
  } catch (e) {
    // Handle error
  }
}
```

---

### 2. Fixed Add to Cart - Authentication Required

**Problem:** Add to cart showed success but didn't actually add items because guest users don't have authentication tokens.

**Solution:** Added authentication check before attempting to add to cart. Shows login prompt if user is not authenticated.

**Files Modified:**
- `lib/screens/products/product_detail_screen.dart`

**Code:**
```dart
Future<void> _addToCart() async {
  // Check if user is authenticated
  if (!_apiService.isAuthenticated) {
    if (mounted) {
      _showLoginPrompt('add items to cart');
    }
    return;
  }

  try {
    final success = await _cartService.addToCart(widget.productId, _quantity);
    if (mounted) {
      if (success) {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text('✓ Added to cart successfully'),
            backgroundColor: Colors.green,
            duration: Duration(seconds: 2),
          ),
        );
      } else {
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text('Failed to add to cart. Please try again.'),
            backgroundColor: Colors.red,
            duration: Duration(seconds: 2),
          ),
        );
      }
    }
  } catch (e) {
    // Error handling
  }
}
```

---

### 3. Fixed Wishlist - Authentication Required

**Problem:** Wishlist buttons didn't work because guest users don't have authentication tokens.

**Solution:** Added authentication checks to all wishlist buttons throughout the app.

**Files Modified:**
- `lib/screens/products/product_detail_screen.dart` - Wishlist button in AppBar
- `lib/screens/home/home_screen.dart` - Wishlist buttons on product cards
- `lib/screens/products/products_screen.dart` - Wishlist buttons in grid and list views

**Code:**
```dart
Future<void> _toggleWishlist() async {
  // Check if user is authenticated
  if (!_apiService.isAuthenticated) {
    if (mounted) {
      _showLoginPrompt('add items to wishlist');
    }
    return;
  }

  try {
    if (_isInWishlist) {
      await _wishlistService.removeFromWishlist(widget.productId);
    } else {
      await _wishlistService.addToWishlist(widget.productId);
    }
    setState(() => _isInWishlist = !_isInWishlist);
    
    if (mounted) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(_isInWishlist ? 'Added to wishlist' : 'Removed from wishlist'),
          backgroundColor: Colors.green,
          duration: const Duration(seconds: 1),
        ),
      );
    }
  } catch (e) {
    // Error handling
  }
}
```

---

### 4. Login Prompt Dialog

**Solution:** Created a reusable login prompt dialog that appears when guest users try to use authenticated features.

**Code:**
```dart
void _showLoginPrompt(String action) {
  showDialog(
    context: context,
    builder: (context) => AlertDialog(
      title: const Text('Login Required'),
      content: Text('Please login to $action'),
      actions: [
        TextButton(
          onPressed: () => Navigator.pop(context),
          child: const Text('Cancel'),
        ),
        ElevatedButton(
          onPressed: () {
            Navigator.pop(context);
            Navigator.pushNamed(context, '/login');
          },
          child: const Text('Login'),
        ),
      ],
    ),
  );
}
```

**Features:**
- Clear message explaining why login is required
- Cancel
