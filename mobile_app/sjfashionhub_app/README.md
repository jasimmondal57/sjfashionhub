# SJ Fashion Hub - Flutter Mobile App

A beautiful e-commerce mobile application for SJ Fashion Hub built with Flutter.

## 🚀 Features

- ✅ Welcome Screen with app branding
- ✅ Home Screen with:
  - Search functionality
  - Category carousel
  - Banner slider
  - Product grid
  - Bottom navigation
- ✅ Product Card with discount badges
- ✅ API Integration with sjfashionhub.com backend
- ✅ Custom theme matching design specifications
- ✅ State management ready
- ✅ Responsive design

## 📱 Screens Implemented

### ✅ Completed
- Welcome Screen
- Home Feed Screen

### 🚧 In Progress
- Authentication Screens (Sign In, Sign Up)
- Product Detail Screen
- Cart Screen
- Profile Screen

### 📋 Planned
- Checkout Flow
- Order Management
- Wishlist
- Search & Filters
- Settings
- And more...

## 🛠️ Tech Stack

- **Framework**: Flutter 3.9+
- **State Management**: Provider
- **HTTP Client**: Dio
- **Image Caching**: cached_network_image
- **UI Components**: 
  - carousel_slider
  - smooth_page_indicator
  - shimmer
- **Navigation**: Named routes (will migrate to go_router)

## 📦 Installation

### Prerequisites
- Flutter SDK 3.9 or higher
- Dart SDK 3.9 or higher
- Android Studio / VS Code with Flutter extensions
- iOS development tools (for iOS builds)

### Setup Steps

1. **Clone the repository** (if not already done)
   ```bash
   cd mobile_app/sjfashionhub_app
   ```

2. **Install dependencies**
   ```bash
   flutter pub get
   ```

3. **Download Plus Jakarta Sans Font**
   - Download the font from [Google Fonts](https://fonts.google.com/specimen/Plus+Jakarta+Sans)
   - Extract and place the following files in `assets/fonts/`:
     - PlusJakartaSans-Regular.ttf (400 weight)
     - PlusJakartaSans-Medium.ttf (500 weight)
     - PlusJakartaSans-Bold.ttf (700 weight)
     - PlusJakartaSans-ExtraBold.ttf (800 weight)

4. **Configure API endpoint** (if needed)
   - Edit `lib/config/app_config.dart`
   - Update `baseUrl` if using a different backend URL

5. **Run the app**
   ```bash
   # For Android
   flutter run

   # For iOS
   flutter run -d ios

   # For web
   flutter run -d chrome
   ```

## 🎨 Design System

### Colors
- **Primary**: #000000 (Black)
- **Background Light**: #FFFFFF (White)
- **Background Dark**: #1A1A1A (Dark)
- **Accent**: #EA2A33 (Red)
- **Text Primary**: #000000
- **Text Secondary**: #666666

### Typography
- **Font Family**: Plus Jakarta Sans
- **Weights**: 400 (Regular), 500 (Medium), 700 (Bold), 800 (Extra Bold)

### Border Radius
- Default: 4px
- Large: 8px
- XL: 12px
- Full: 9999px (rounded-full)

## 📁 Project Structure

```
lib/
├── config/
│   ├── app_config.dart       # App configuration & API endpoints
│   └── app_theme.dart         # Theme configuration
├── models/
│   ├── product.dart           # Product model
│   ├── category.dart          # Category model
│   ├── banner.dart            # Banner model
│   ├── cart_item.dart         # Cart item model
│   └── user.dart              # User model
├── screens/
│   ├── welcome_screen.dart    # Welcome/splash screen
│   └── home_screen.dart       # Home feed screen
├── services/
│   └── api_service.dart       # API service layer
├── widgets/
│   └── product_card.dart      # Reusable product card widget
├── providers/                 # State management (to be added)
├── utils/                     # Utility functions (to be added)
└── main.dart                  # App entry point
```

## 🔌 API Integration

The app connects to the SJ Fashion Hub backend at `https://sjfashionhub.com/api`.

### Available Endpoints
- `POST /login` - User login
- `POST /register` - User registration
- `GET /products` - Get products list
- `GET /categories` - Get categories
- `GET /banners` - Get banners
- `GET /cart` - Get cart items
- `POST /cart` - Add to cart
- `GET /wishlist` - Get wishlist
- `GET /orders` - Get orders
- `GET /profile` - Get user profile

## 🧪 Testing

```bash
# Run all tests
flutter test

# Run with coverage
flutter test --coverage
```

## 📱 Building for Production

### Android
```bash
flutter build apk --release
# or
flutter build appbundle --release
```

### iOS
```bash
flutter build ios --release
```

## 🐛 Known Issues

1. **Fonts not loading**: Make sure to download and place Plus Jakarta Sans fonts in `assets/fonts/`
2. **API connection**: Ensure the backend API is accessible and CORS is configured properly
3. **Image loading**: Some images may not load if the storage symlink is not properly configured on the server

## 📝 TODO

- [ ] Implement authentication screens
- [ ] Add product detail screen
- [ ] Implement cart functionality
- [ ] Add checkout flow
- [ ] Implement order management
- [ ] Add wishlist functionality
- [ ] Implement search and filters
- [ ] Add user profile and settings
- [ ] Implement push notifications
- [ ] Add offline support
- [ ] Write unit and widget tests
- [ ] Add error handling and loading states
- [ ] Implement analytics

## 🤝 Contributing

This is a private project for SJ Fashion Hub. For any issues or suggestions, please contact the development team.

## 📄 License

Copyright © 2025 SJ Fashion Hub. All rights reserved.

## 📞 Support

For support, email: support@sjfashionhub.com
Website: https://sjfashionhub.com

---

**Version**: 1.0.0  
**Last Updated**: 2025-09-30

