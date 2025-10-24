# 🚀 Quick Start Guide - SJ Fashion Hub Flutter App

## ⚡ Get Started in 5 Minutes

### Step 1: Install Dependencies (1 minute)

```bash
cd mobile_app/sjfashionhub_app
flutter pub get
```

### Step 2: Download Fonts (2 minutes)

**Option A: Download Manually**
1. Go to: https://fonts.google.com/specimen/Plus+Jakarta+Sans
2. Click "Download family"
3. Extract and copy these 4 files to `assets/fonts/`:
   - `PlusJakartaSans-Regular.ttf`
   - `PlusJakartaSans-Medium.ttf`
   - `PlusJakartaSans-Bold.ttf`
   - `PlusJakartaSans-ExtraBold.ttf`

**Option B: Use Google Fonts Package (Easier)**
1. Add to `pubspec.yaml`:
   ```yaml
   dependencies:
     google_fonts: ^6.1.0
   ```
2. Run: `flutter pub get`
3. The fonts will be downloaded automatically!

### Step 3: Run the App (1 minute)

```bash
flutter run
```

That's it! The app should launch on your connected device or emulator.

## 🎯 What You'll See

1. **Welcome Screen**: 
   - SJ Fashion Hub branding
   - "Get Started" button
   - "Sign In" link

2. **Home Screen** (after tapping "Get Started"):
   - Search bar
   - Category carousel
   - Banner slider
   - Product grid
   - Bottom navigation

## ⚠️ Important Notes

### Backend API
The app tries to connect to `https://sjfashionhub.com/api`. If the API is not ready:
- You'll see loading spinners
- Some features won't work yet
- This is expected during development

To use a different API:
1. Open `lib/config/app_config.dart`
2. Change `baseUrl` to your API URL

### For Local Development
If running backend locally:

```dart
// In lib/config/app_config.dart

// For Android Emulator:
static const String baseUrl = 'http://10.0.2.2:8000';

// For iOS Simulator:
static const String baseUrl = 'http://localhost:8000';

// For Physical Device (replace with your IP):
static const String baseUrl = 'http://192.168.1.XXX:8000';
```

## 🐛 Troubleshooting

### Problem: "Font not found"
**Solution**: Download and place fonts in `assets/fonts/` or use google_fonts package

### Problem: "API connection failed"
**Solution**: Check if backend is running and URL is correct in `app_config.dart`

### Problem: "No devices found"
**Solution**: 
```bash
# Check connected devices
flutter devices

# Start Android emulator
flutter emulators --launch <emulator_id>

# Or use Chrome for web
flutter run -d chrome
```

### Problem: Build errors
**Solution**:
```bash
flutter clean
flutter pub get
flutter run
```

## 📱 Testing on Different Platforms

### Android
```bash
flutter run
```

### iOS (Mac only)
```bash
flutter run -d ios
```

### Web
```bash
flutter run -d chrome
```

### Specific Device
```bash
flutter devices  # List all devices
flutter run -d <device-id>
```

## 🎨 Customization

### Change App Name
Edit `lib/config/app_config.dart`:
```dart
static const String appName = 'Your App Name';
```

### Change Colors
Edit `lib/config/app_theme.dart`:
```dart
static const Color primaryColor = Color(0xFF000000);
static const Color accentColor = Color(0xFFEA2A33);
```

### Change API URL
Edit `lib/config/app_config.dart`:
```dart
static const String baseUrl = 'https://your-api.com';
```

## 📚 Next Steps

After the app is running:

1. **Explore the Code**
   - Check `lib/screens/` for UI screens
   - Look at `lib/models/` for data structures
   - Review `lib/services/api_service.dart` for API calls

2. **Add More Screens**
   - Reference designs in `mobile_app/all_screens/`
   - Follow the pattern from existing screens
   - Use the theme from `app_theme.dart`

3. **Connect to Backend**
   - Ensure backend API matches expected structure
   - Test API endpoints with Postman first
   - Update models if API structure differs

4. **Read Documentation**
   - `README.md` - Full project documentation
   - `SETUP_INSTRUCTIONS.md` - Detailed setup guide
   - `PROJECT_SUMMARY.md` - Project status and roadmap

## 🆘 Need Help?

- **Flutter Issues**: https://docs.flutter.dev
- **Project Issues**: Check `PROJECT_SUMMARY.md`
- **Backend Issues**: Contact backend team
- **Design Questions**: Reference `mobile_app/all_screens/`

## ✅ Checklist

Before starting development, make sure:

- [ ] Flutter SDK installed (3.9+)
- [ ] Dependencies installed (`flutter pub get`)
- [ ] Fonts downloaded and placed in `assets/fonts/`
- [ ] App runs without errors
- [ ] Welcome screen displays correctly
- [ ] Can navigate to home screen
- [ ] Backend API URL configured (if needed)

## 🎉 You're Ready!

The foundation is set. Now you can:
- Add more screens
- Implement features
- Connect to real API
- Test and refine

**Happy Coding! 🚀**

---

**Need more details?** Check out:
- `README.md` for full documentation
- `SETUP_INSTRUCTIONS.md` for detailed setup
- `PROJECT_SUMMARY.md` for project overview

