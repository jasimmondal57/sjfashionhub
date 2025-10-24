import 'package:flutter/material.dart';

class AppConfig {
  // API Configuration
  static const String baseUrl = "https://sjfashionhub.com";
  static const String apiUrl = "$baseUrl/api/mobile";
  
  // App Information
  static const String appName = 'SJ Fashion Hub';
  static const String appVersion = '1.0.0';
  
  // Theme Colors
  static const Color primaryColor = Color(0xFFFF3364);
  static const Color secondaryColor = Color(0xFFD7365C);
  static const Color accentColor = Color(0xFFFF3566);
  
  // Gradient Colors
  static const List<Color> primaryGradient = [
    Color(0xFFFF3566),
    Color(0xFFD7365C),
  ];
  
  // Text Colors
  static const Color textPrimary = Color(0xFF2D3748);
  static const Color textSecondary = Color(0xFF718096);
  static const Color textLight = Color(0xFFA0AEC0);
  
  // Background Colors
  static const Color backgroundColor = Color(0xFFF7FAFC);
  static const Color cardBackground = Colors.white;
  static const Color surfaceColor = Color(0xFFF1F5F9);
  
  // Status Colors
  static const Color successColor = Color(0xFF48BB78);
  static const Color errorColor = Color(0xFFE53E3E);
  static const Color warningColor = Color(0xFFED8936);
  static const Color infoColor = Color(0xFF3182CE);
  
  // Border & Shadow
  static const Color borderColor = Color(0xFFE2E8F0);
  static const Color shadowColor = Color(0x1A000000);
  
  // App Settings
  static const bool enableDarkMode = false;
  static const bool enableNotifications = true;
  static const bool enableAnalytics = true;
  
  // API Endpoints
  static const String homeEndpoint = "/home";
  static const String categoriesEndpoint = "/categories";
  static const String productsEndpoint = "/products";
  static const String cartEndpoint = "/cart";
  static const String authEndpoint = "/auth";
  static const String ordersEndpoint = "/orders";
  
  // Pagination
  static const int defaultPageSize = 20;
  static const int maxPageSize = 50;
  
  // Cache Settings
  static const Duration cacheExpiry = Duration(hours: 1);
  static const int maxCacheSize = 100; // MB
  
  // Image Settings
  static const String placeholderImage = 'assets/images/placeholder.png';
  static const String logoImage = 'assets/images/app_logo.png';
  static const String splashImage = 'assets/images/splash_logo.png';
  
  // Animation Durations
  static const Duration shortAnimation = Duration(milliseconds: 200);
  static const Duration mediumAnimation = Duration(milliseconds: 300);
  static const Duration longAnimation = Duration(milliseconds: 500);
  
  // Spacing & Sizing
  static const double defaultPadding = 16.0;
  static const double smallPadding = 8.0;
  static const double largePadding = 24.0;
  
  static const double defaultRadius = 8.0;
  static const double smallRadius = 4.0;
  static const double largeRadius = 16.0;
  
  // Typography
  static const double headingFontSize = 24.0;
  static const double titleFontSize = 18.0;
  static const double bodyFontSize = 14.0;
  static const double captionFontSize = 12.0;
  
  // Grid Settings
  static const int gridCrossAxisCount = 2;
  static const double gridChildAspectRatio = 0.75;
  static const double gridSpacing = 12.0;
}
