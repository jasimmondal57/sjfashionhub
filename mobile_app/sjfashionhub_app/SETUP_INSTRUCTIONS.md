# Setup Instructions for SJ Fashion Hub Flutter App

## Step 1: Install Flutter Dependencies

Open a terminal in the `mobile_app/sjfashionhub_app` directory and run:

```bash
flutter pub get
```

## Step 2: Download and Install Fonts

The app uses **Plus Jakarta Sans** font family. You need to download and install it:

### Option A: Download from Google Fonts (Recommended)

1. Visit: https://fonts.google.com/specimen/Plus+Jakarta+Sans
2. Click "Download family" button
3. Extract the ZIP file
4. Copy these files to `assets/fonts/` directory:
   - `PlusJakartaSans-Regular.ttf` (400 weight)
   - `PlusJakartaSans-Medium.ttf` (500 weight)
   - `PlusJakartaSans-Bold.ttf` (700 weight)
   - `PlusJakartaSans-ExtraBold.ttf` (800 weight)

### Option B: Use Google Fonts Package (Alternative)

If you prefer not to download fonts manually, you can use the `google_fonts` package:

1. Add to `pubspec.yaml`:
   ```yaml
   dependencies:
     google_fonts: ^6.1.0
   ```

2. Update `lib/config/app_theme.dart` to use Google Fonts:
   ```dart
   import 'package:google_fonts/google_fonts.dart';
   
   // In theme configuration, replace fontFamily with:
   textTheme: GoogleFonts.plusJakartaSansTextTheme(
     Theme.of(context).textTheme,
   ),
   ```

## Step 3: Verify Font Installation

After placing fonts in `assets/fonts/`, your directory structure should look like:

```
sjfashionhub_app/
├── assets/
│   ├── fonts/
│   │   ├── PlusJakartaSans-Regular.ttf
│   │   ├── PlusJakartaSans-Medium.ttf
│   │   ├── PlusJakartaSans-Bold.ttf
│   │   └── PlusJakartaSans-ExtraBold.ttf
│   └── images/
├── lib/
└── pubspec.yaml
```

## Step 4: Configure Backend API (Optional)

If your backend API is running on a different URL:

1. Open `lib/config/app_config.dart`
2. Update the `baseUrl` constant:
   ```dart
   static const String baseUrl = 'https://your-domain.com';
   ```

For local development:
```dart
// For Android Emulator
static const String baseUrl = 'http://10.0.2.2:8000';

// For iOS Simulator
static const String baseUrl = 'http://localhost:8000';

// For Physical Device (use your computer's IP)
static const String baseUrl = 'http://192.168.1.XXX:8000';
```

## Step 5: Run the App

### For Android:
```bash
flutter run
```

### For iOS:
```bash
flutter run -d ios
```

### For Web:
```bash
flutter run -d chrome
```

### For specific device:
```bash
# List available devices
flutter devices

# Run on specific device
flutter run -d <device-id>
```

## Step 6: Build for Production

### Android APK:
```bash
flutter build apk --release
```

### Android App Bundle (for Play Store):
```bash
flutter build appbundle --release
```

### iOS:
```bash
flutter build ios --release
```

## Troubleshooting

### Issue: Fonts not loading

**Solution**: 
- Verify fonts are in `assets/fonts/` directory
- Check `pubspec.yaml` has correct font paths
- Run `flutter clean` and `flutter pub get`
- Restart the app

### Issue: API connection failed

**Solution**:
- Check if backend server is running
- Verify API URL in `app_config.dart`
- For local development, use correct IP address
- Check CORS configuration on backend
- For HTTPS, ensure SSL certificate is valid

### Issue: Images not loading

**Solution**:
- Verify backend storage symlink is configured
- Check image URLs in API responses
- Ensure `storageUrl` in `app_config.dart` is correct
- Check network permissions in AndroidManifest.xml

### Issue: Build errors

**Solution**:
```bash
# Clean build cache
flutter clean

# Get dependencies
flutter pub get

# Rebuild
flutter run
```

### Issue: Hot reload not working

**Solution**:
- Use hot restart instead: Press `R` in terminal or click restart button
- Some changes require full restart (like adding new assets)

## Development Tips

1. **Enable Hot Reload**: Save files to see changes instantly
2. **Use Flutter DevTools**: Run `flutter pub global activate devtools` then `flutter pub global run devtools`
3. **Check Logs**: Use `flutter logs` to see detailed logs
4. **Format Code**: Run `flutter format .` to format all Dart files
5. **Analyze Code**: Run `flutter analyze` to check for issues

## Next Steps

After successful setup:

1. Test the welcome screen
2. Navigate to home screen
3. Verify API integration (categories, banners, products)
4. Test navigation between screens
5. Check responsive design on different screen sizes

## Need Help?

- Check Flutter documentation: https://docs.flutter.dev
- SJ Fashion Hub support: support@sjfashionhub.com
- Backend API documentation: https://sjfashionhub.com/api/docs

---

**Happy Coding! 🚀**

