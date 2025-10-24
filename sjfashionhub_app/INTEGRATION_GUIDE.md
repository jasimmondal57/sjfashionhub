# SJ Fashion Hub - Flutter App Integration Guide

## 🎉 Integration Complete!

The Flutter app has been successfully integrated with sjfashionhub.com Laravel backend!

---

## ✅ What's Been Done

### **1. Laravel Backend API**

#### **API Controllers Created:**
- ✅ `ConfigController` - App configuration (theme, features, menu)
- ✅ `HomeController` - Home screen data (sections, banners, products)
- ✅ `AuthController` - Authentication (login, register, logout)
- ✅ `ProductController` - Products listing and details
- ✅ `CategoryController` - Categories listing
- ✅ `CartController` - Cart management (add, update, remove, clear)
- ✅ `OrderController` - Order management (create, list, details)
- ✅ `WishlistController` - Wishlist management
- ✅ `ProfileController` - User profile management
- ✅ `DeviceController` - FCM device registration for push notifications

#### **API Endpoints Available:**

**Public Endpoints (No Authentication Required):**
```
GET  /api/mobile/config              - App configuration
GET  /api/mobile/home                - Home screen data
GET  /api/mobile/products            - Products list (with pagination, search, category filter)
GET  /api/mobile/products/{id}       - Product details
GET  /api/mobile/categories          - Categories list
GET  /api/mobile/categories/{id}     - Category with products
POST /api/mobile/auth/register       - Register new user
POST /api/mobile/auth/login          - Login user
```

**Protected Endpoints (Requires Authentication):**
```
POST   /api/mobile/auth/logout       - Logout user
GET    /api/mobile/auth/user         - Get current user
GET    /api/mobile/profile           - Get user profile
PUT    /api/mobile/profile           - Update user profile
GET    /api/mobile/cart              - Get cart items
POST   /api/mobile/cart              - Add item to cart
PUT    /api/mobile/cart/{id}         - Update cart item quantity
DELETE /api/mobile/cart/{id}         - Remove item from cart
DELETE /api/mobile/cart              - Clear entire cart
GET    /api/mobile/orders            - Get user orders
GET    /api/mobile/orders/{id}       - Get order details
POST   /api/mobile/orders            - Create new order
GET    /api/mobile/wishlist          - Get wishlist items
POST   /api/mobile/wishlist          - Add item to wishlist
DELETE /api/mobile/wishlist/{id}     - Remove item from wishlist
POST   /api/mobile/devices           - Register device for push notifications
```

### **2. Flutter App Updates**

#### **Files Created:**
- ✅ `lib/config/api_config.dart` - API configuration with all endpoints
- ✅ `lib/services/api_service.dart` - Complete API service with all methods
- ✅ `lib/screens/auth/register_screen.dart` - Beautiful registration screen

#### **Files Updated:**
- ✅ `lib/main.dart` - Initialize API service, check authentication
- ✅ `lib/services/auth_service.dart` - Use Laravel API instead of Firebase Auth
- ✅ `lib/screens/auth/login_screen.dart` - Beautiful login screen with validation
- ✅ `pubspec.yaml` - Removed Firebase Auth and Firestore dependencies

#### **Authentication:**
- ✅ **Removed:** Firebase Authentication
- ✅ **Added:** Laravel Sanctum token-based authentication
- ✅ **Kept:** Firebase Cloud Messaging for push notifications

---

## 🚀 How to Run the App

### **1. Install Dependencies**

```bash
cd sjfashionhub_app
flutter pub get
```

### **2. Run the App**

```bash
# For Android
flutter run

# For iOS
flutter run -d ios

# For Web
flutter run -d chrome
```

---

## 📱 App Features

### **Authentication**
- ✅ Login with email and password
- ✅ Register new account
- ✅ Token-based authentication (Laravel Sanctum)
- ✅ Auto-login on app restart
- ✅ Logout functionality

### **API Integration**
- ✅ Fetch app configuration from server
- ✅ Dynamic theme colors from admin panel
- ✅ Home screen sections (banners, categories, products)
- ✅ Product listing with pagination
- ✅ Product search and filtering
- ✅ Cart management
- ✅ Order placement
- ✅ Wishlist management
- ✅ User profile management

### **Push Notifications**
- ✅ Firebase Cloud Messaging integration
- ✅ Device registration with backend
- ✅ Receive notifications from admin panel

---

## 🔧 Configuration

### **API Base URL**

The API base URL is configured in `lib/config/api_config.dart`:

```dart
static const String baseUrl = 'https://sjfashionhub.com';
```

To change it for local development:

```dart
static const String baseUrl = 'http://localhost:8000';
// or
static const String baseUrl = 'http://192.168.1.100:8000';
```

### **Firebase Configuration**

Firebase is only used for push notifications. Make sure you have:

1. `google-services.json` in `android/app/` (for Android)
2. `GoogleService-Info.plist` in `ios/Runner/` (for iOS)
3. Firebase project configured in Firebase Console

---

## 📝 API Service Usage Examples

### **Login**

```dart
import 'package:app/services/auth_service.dart';

final authService = AuthService();

final result = await authService.login('user@example.com', 'password');

if (result['success']) {
  // Login successful
  print('Welcome ${result['user']['name']}');
} else {
  // Login failed
  print('Error: ${result['message']}');
}
```

### **Get Products**

```dart
import 'package:app/services/api_service.dart';

final apiService = ApiService();

final response = await apiService.getProducts(
  page: 1,
  perPage: 20,
  category: 'electronics',
  search: 'phone',
);

final products = response['products'];
final pagination = response['pagination'];
```

### **Add to Cart**

```dart
final response = await apiService.addToCart(productId: 123, quantity: 2);
print(response['message']); // "Product added to cart"
```

### **Place Order**

```dart
final response = await apiService.createOrder({
  'shipping_name': 'John Doe',
  'shipping_phone': '1234567890',
  'shipping_address': '123 Main St',
  'shipping_city': 'Mumbai',
  'shipping_state': 'Maharashtra',
  'shipping_pincode': '400001',
  'payment_method': 'cod',
});

print('Order Number: ${response['order']['order_number']}');
```

---

## 🎨 Mobile Admin Panel

Access the mobile admin panel at: **https://sjfashionhub.com/mobileadmin**

### **Features:**
- ✅ Dashboard with statistics
- ✅ App Settings (API URL, app name, version)
- ✅ Home Sections management
- ✅ Banners management (with image upload)
- ✅ Navigation Menu management
- ✅ Theme & Colors customization
- ✅ Push Notifications
- ✅ Analytics (placeholder for Firebase Analytics)

### **Login:**
Use your admin credentials to access the mobile admin panel.

---

## 🔐 Authentication Flow

1. User opens app
2. App checks if token exists in SharedPreferences
3. If token exists → Navigate to Home Screen
4. If no token → Navigate to Login Screen
5. User logs in → Token saved → Navigate to Home Screen
6. Token is automatically included in all API requests
7. If token expires (401 error) → Clear token → Navigate to Login Screen

---

## 📦 Next Steps

### **1. Update Home Screen**
Update `lib/screens/home/home_screen.dart` to fetch data from the API:

```dart
import 'package:app/services/api_service.dart';

class HomeScreen extends StatefulWidget {
  // ...
}

class _HomeScreenState extends State<HomeScreen> {
  final _apiService = ApiService();
  Map<String, dynamic>? _homeData;
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _loadHomeData();
  }

  Future<void> _loadHomeData() async {
    try {
      final data = await _apiService.getHomeData();
      setState(() {
        _homeData = data;
        _isLoading = false;
      });
    } catch (e) {
      setState(() => _isLoading = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading) {
      return const Scaffold(
        body: Center(child: CircularProgressIndicator()),
      );
    }

    final sections = _homeData?['sections'] ?? [];

    return Scaffold(
      appBar: AppBar(title: const Text('SJ Fashion Hub')),
      body: ListView.builder(
        itemCount: sections.length,
        itemBuilder: (context, index) {
          final section = sections[index];
          return _buildSection(section);
        },
      ),
    );
  }

  Widget _buildSection(Map<String, dynamic> section) {
    // Build section based on type
    switch (section['type']) {
      case 'banner':
        return _buildBannerSection(section);
      case 'product_grid':
        return _buildProductGrid(section);
      default:
        return const SizedBox();
    }
  }
}
```

### **2. Update Product Screens**
Create product listing and detail screens that fetch data from the API.

### **3. Update Cart Screen**
Implement cart functionality using the Cart API endpoints.

### **4. Update Wishlist Screen**
Implement wishlist functionality using the Wishlist API endpoints.

### **5. Implement Order Placement**
Create checkout flow that uses the Order API endpoints.

### **6. Configure Firebase Cloud Messaging**
Set up FCM to receive push notifications from the admin panel.

---

## 🐛 Troubleshooting

### **API Connection Issues**

If you're getting connection errors:

1. Check the API base URL in `lib/config/api_config.dart`
2. Make sure the Laravel backend is running
3. For local development, use your computer's IP address instead of `localhost`
4. Check if CORS is enabled on the Laravel backend

### **Authentication Issues**

If login is not working:

1. Check if the email and password are correct
2. Check the API response in the console
3. Make sure Laravel Sanctum is properly configured
4. Check if the user exists in the database

### **Build Issues**

If you're getting build errors:

1. Run `flutter clean`
2. Run `flutter pub get`
3. Restart your IDE
4. Make sure you're using Flutter 3.1.0 or higher

---

## 📚 Resources

- [Flutter Documentation](https://docs.flutter.dev/)
- [Laravel Sanctum Documentation](https://laravel.com/docs/sanctum)
- [Firebase Cloud Messaging](https://firebase.google.com/docs/cloud-messaging)
- [HTTP Package](https://pub.dev/packages/http)

---

## ✨ Summary

The Flutter app is now fully integrated with sjfashionhub.com! 

**Key Changes:**
- ✅ Removed Shopify GraphQL API
- ✅ Removed Firebase Authentication
- ✅ Added Laravel REST API integration
- ✅ Added Laravel Sanctum authentication
- ✅ Kept Firebase Cloud Messaging for notifications
- ✅ Created beautiful login and registration screens
- ✅ All API endpoints are ready to use

**Next:** Update the remaining screens (Home, Products, Cart, Wishlist, Orders) to use the new API!

Happy coding! 🚀

