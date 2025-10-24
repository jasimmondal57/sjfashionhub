class ApiConfig {
  // Base API URL - Change this to your server URL
  static const String baseUrl = 'https://sjfashionhub.com';
  static const String apiUrl = '$baseUrl/api/mobile';

  // API Endpoints
  static const String configEndpoint = '$apiUrl/config';
  static const String homeEndpoint = '$apiUrl/home';
  static const String productsEndpoint = '$apiUrl/products';
  static const String categoriesEndpoint = '$apiUrl/categories';
  static const String loginEndpoint = '$apiUrl/auth/login';
  static const String registerEndpoint = '$apiUrl/auth/register';
  static const String logoutEndpoint = '$apiUrl/auth/logout';
  static const String profileEndpoint = '$apiUrl/profile';
  static const String cartEndpoint = '$apiUrl/cart';
  static const String ordersEndpoint = '$apiUrl/orders';
  static const String wishlistEndpoint = '$apiUrl/wishlist';
  static const String devicesEndpoint = '$apiUrl/devices';

  // Headers
  static Map<String, String> getHeaders({String? token}) {
    final headers = {
      'Content-Type': 'application/json',
      'Accept': 'application/json',
    };

    if (token != null) {
      headers['Authorization'] = 'Bearer $token';
    }

    return headers;
  }
}
