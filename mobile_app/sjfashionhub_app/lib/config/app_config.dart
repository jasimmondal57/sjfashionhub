/// Application configuration constants
class AppConfig {
  // API Configuration
  static const String baseUrl = 'https://sjfashionhub.com';
  static const String apiUrl = '$baseUrl/api/mobile';
  static const String storageUrl = '$baseUrl/storage';

  // App Information
  static const String appName = 'SJ Fashion Hub';
  static const String appVersion = '1.0.0';

  // API Endpoints
  static const String loginEndpoint = '/login';
  static const String registerEndpoint = '/register';
  static const String logoutEndpoint = '/logout';
  static const String productsEndpoint = '/products';
  static const String categoriesEndpoint = '/categories';
  static const String bannersEndpoint = '/banners';
  static const String cartEndpoint = '/cart';
  static const String ordersEndpoint = '/orders';
  static const String wishlistEndpoint = '/wishlist';
  static const String profileEndpoint = '/profile';

  // Timeouts
  static const Duration connectionTimeout = Duration(seconds: 30);
  static const Duration receiveTimeout = Duration(seconds: 30);

  // Pagination
  static const int defaultPageSize = 20;

  // Image Configuration
  static const int maxImageSize = 10 * 1024 * 1024; // 10MB
  static const List<String> allowedImageTypes = ['jpg', 'jpeg', 'png', 'webp'];
}
