class AppConfig {
  // Base URLs
  static const String baseUrl = 'https://sjfashionhub.com';
  static const String storageUrl = '$baseUrl/storage';
  
  // App Information
  static const String appName = 'SJ Fashion Hub';
  static const String appVersion = '1.0.0';
  
  // API Configuration
  static const String apiVersion = 'v1';
  static const String apiTimeout = '30'; // seconds
  
  // Image Configuration
  static const String defaultImageUrl = 'https://via.placeholder.com/300x300?text=No+Image';
  static const String logoUrl = '$storageUrl/logo.png';
  
  // Cache Configuration
  static const int imageCacheDuration = 7; // days
  static const int apiCacheDuration = 5; // minutes
  
  // Pagination
  static const int defaultPageSize = 20;
  static const int maxPageSize = 100;
  
  // Currency
  static const String currency = '₹';
  static const String currencyCode = 'INR';
  
  // Social Media Links
  static const String facebookUrl = 'https://facebook.com/sjfashionhub';
  static const String instagramUrl = 'https://instagram.com/sjfashionhub';
  static const String twitterUrl = 'https://twitter.com/sjfashionhub';
  
  // Support
  static const String supportEmail = 'support@sjfashionhub.com';
  static const String supportPhone = '+91-9876543210';
  
  // Features
  static const bool enablePushNotifications = true;
  static const bool enableAnalytics = true;
  static const bool enableCrashReporting = true;
  
  // Debug
  static const bool isDebugMode = true;
  static const bool enableLogging = true;
}
