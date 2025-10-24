import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import '../config/api_config.dart';

class ApiService {
  static final ApiService _instance = ApiService._internal();
  factory ApiService() => _instance;
  ApiService._internal();

  String? _token;

  // Initialize and load token from storage
  Future<void> init() async {
    final prefs = await SharedPreferences.getInstance();
    _token = prefs.getString('auth_token');
  }

  // Save token to storage
  Future<void> saveToken(String token) async {
    _token = token;
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('auth_token', token);
  }

  // Clear token from storage
  Future<void> clearToken() async {
    _token = null;
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
  }

  // Get current token
  String? get token => _token;

  // Check if user is authenticated
  bool get isAuthenticated => _token != null && _token!.isNotEmpty;

  // Generic GET request
  Future<Map<String, dynamic>> get(String endpoint) async {
    try {
      final response = await http.get(
        Uri.parse(endpoint),
        headers: ApiConfig.getHeaders(token: _token),
      );

      return _handleResponse(response);
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  // Generic POST request
  Future<Map<String, dynamic>> post(
    String endpoint,
    Map<String, dynamic> data,
  ) async {
    try {
      final response = await http.post(
        Uri.parse(endpoint),
        headers: ApiConfig.getHeaders(token: _token),
        body: jsonEncode(data),
      );

      return _handleResponse(response);
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  // Generic PUT request
  Future<Map<String, dynamic>> put(
    String endpoint,
    Map<String, dynamic> data,
  ) async {
    try {
      final response = await http.put(
        Uri.parse(endpoint),
        headers: ApiConfig.getHeaders(token: _token),
        body: jsonEncode(data),
      );

      return _handleResponse(response);
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  // Generic DELETE request
  Future<Map<String, dynamic>> delete(String endpoint) async {
    try {
      final response = await http.delete(
        Uri.parse(endpoint),
        headers: ApiConfig.getHeaders(token: _token),
      );

      return _handleResponse(response);
    } catch (e) {
      throw Exception('Network error: $e');
    }
  }

  // Handle API response
  Map<String, dynamic> _handleResponse(http.Response response) {
    if (response.statusCode >= 200 && response.statusCode < 300) {
      return jsonDecode(response.body);
    } else if (response.statusCode == 401) {
      // Unauthorized - clear token
      clearToken();
      throw Exception('Unauthorized. Please login again.');
    } else {
      try {
        final error = jsonDecode(response.body);
        // Check for validation errors
        if (error['errors'] != null && error['errors'] is Map) {
          final errors = error['errors'] as Map;
          final firstError = errors.values.first;
          if (firstError is List && firstError.isNotEmpty) {
            throw Exception(firstError[0]);
          }
        }
        throw Exception(error['message'] ?? 'Request failed');
      } catch (e) {
        if (e is Exception) rethrow;
        throw Exception('Server error: ${response.statusCode}');
      }
    }
  }

  // ==================== AUTH ENDPOINTS ====================

  Future<Map<String, dynamic>> login(String email, String password) async {
    final response = await post(ApiConfig.loginEndpoint, {
      'email': email,
      'password': password,
    });

    if (response['token'] != null) {
      await saveToken(response['token']);
    }

    return response;
  }

  Future<Map<String, dynamic>> register(Map<String, dynamic> data) async {
    final response = await post(ApiConfig.registerEndpoint, data);

    if (response['token'] != null) {
      await saveToken(response['token']);
    }

    return response;
  }

  Future<void> logout() async {
    try {
      await post(ApiConfig.logoutEndpoint, {});
    } finally {
      await clearToken();
    }
  }

  // ==================== APP CONFIG ====================

  Future<Map<String, dynamic>> getAppConfig() async {
    return await get(ApiConfig.configEndpoint);
  }

  // ==================== HOME DATA ====================

  Future<Map<String, dynamic>> getHomeData() async {
    return await get(ApiConfig.homeEndpoint);
  }

  // ==================== PRODUCTS ====================

  Future<Map<String, dynamic>> getProducts({
    int page = 1,
    int perPage = 20,
    int? categoryId,
    String? category,
    String? search,
  }) async {
    String url = '${ApiConfig.productsEndpoint}?page=$page&per_page=$perPage';
    if (categoryId != null) url += '&category_id=$categoryId';
    if (category != null) url += '&category=$category';
    if (search != null) url += '&search=$search';

    return await get(url);
  }

  Future<Map<String, dynamic>> getProduct(int id) async {
    final response = await get('${ApiConfig.productsEndpoint}/$id');
    return response['product'] ?? response;
  }

  Future<Map<String, dynamic>> searchProducts(String query) async {
    return await get('${ApiConfig.productsEndpoint}?search=$query');
  }

  // ==================== CATEGORIES ====================

  Future<Map<String, dynamic>> getCategories() async {
    return await get(ApiConfig.categoriesEndpoint);
  }

  // ==================== CART ====================

  Future<Map<String, dynamic>> getCart() async {
    return await get(ApiConfig.cartEndpoint);
  }

  Future<Map<String, dynamic>> addToCart(int productId, int quantity) async {
    return await post(ApiConfig.cartEndpoint, {
      'product_id': productId,
      'quantity': quantity,
    });
  }

  Future<Map<String, dynamic>> updateCartItem(int itemId, int quantity) async {
    return await put('${ApiConfig.cartEndpoint}/$itemId', {
      'quantity': quantity,
    });
  }

  Future<void> removeFromCart(int itemId) async {
    await delete('${ApiConfig.cartEndpoint}/$itemId');
  }

  Future<void> clearCart() async {
    await delete(ApiConfig.cartEndpoint);
  }

  // ==================== ORDERS ====================

  Future<Map<String, dynamic>> getOrders({int page = 1}) async {
    return await get('${ApiConfig.ordersEndpoint}?page=$page');
  }

  Future<Map<String, dynamic>> getOrder(int id) async {
    return await get('${ApiConfig.ordersEndpoint}/$id');
  }

  Future<Map<String, dynamic>> createOrder(Map<String, dynamic> data) async {
    return await post(ApiConfig.ordersEndpoint, data);
  }

  // ==================== WISHLIST ====================

  Future<Map<String, dynamic>> getWishlist() async {
    return await get(ApiConfig.wishlistEndpoint);
  }

  Future<Map<String, dynamic>> addToWishlist(int productId) async {
    return await post(ApiConfig.wishlistEndpoint, {'product_id': productId});
  }

  Future<void> removeFromWishlist(int productId) async {
    await delete('${ApiConfig.wishlistEndpoint}/$productId');
  }

  // ==================== PROFILE ====================

  Future<Map<String, dynamic>> getProfile() async {
    return await get(ApiConfig.profileEndpoint);
  }

  Future<Map<String, dynamic>> updateProfile({
    String? name,
    String? email,
    String? phone,
  }) async {
    final data = <String, dynamic>{};
    if (name != null) data['name'] = name;
    if (email != null) data['email'] = email;
    if (phone != null) data['phone'] = phone;
    return await put(ApiConfig.profileEndpoint, data);
  }

  // ==================== DEVICE REGISTRATION (FCM) ====================

  Future<void> registerDevice(String fcmToken, String platform) async {
    await post(ApiConfig.devicesEndpoint, {
      'fcm_token': fcmToken,
      'platform': platform,
      'device_id': '', // Add device ID if available
      'device_name': '', // Add device name if available
    });
  }
}
