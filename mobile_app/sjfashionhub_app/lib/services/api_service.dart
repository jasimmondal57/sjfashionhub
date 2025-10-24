import 'package:dio/dio.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../config/app_config.dart';

/// API Service for handling HTTP requests
class ApiService {
  late final Dio _dio;
  String? _authToken;
  
  ApiService() {
    _dio = Dio(
      BaseOptions(
        baseUrl: AppConfig.apiUrl,
        connectTimeout: AppConfig.connectionTimeout,
        receiveTimeout: AppConfig.receiveTimeout,
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
      ),
    );
    
    // Add interceptors
    _dio.interceptors.add(
      InterceptorsWrapper(
        onRequest: (options, handler) async {
          // Add auth token if available
          if (_authToken != null) {
            options.headers['Authorization'] = 'Bearer $_authToken';
          }
          return handler.next(options);
        },
        onError: (error, handler) async {
          // Handle 401 Unauthorized
          if (error.response?.statusCode == 401) {
            await _clearAuthToken();
          }
          return handler.next(error);
        },
      ),
    );
    
    // Load saved token
    _loadAuthToken();
  }
  
  /// Load auth token from storage
  Future<void> _loadAuthToken() async {
    final prefs = await SharedPreferences.getInstance();
    _authToken = prefs.getString('auth_token');
  }
  
  /// Save auth token to storage
  Future<void> _saveAuthToken(String token) async {
    _authToken = token;
    final prefs = await SharedPreferences.getInstance();
    await prefs.setString('auth_token', token);
  }
  
  /// Clear auth token from storage
  Future<void> _clearAuthToken() async {
    _authToken = null;
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
  }
  
  /// Check if user is authenticated
  bool get isAuthenticated => _authToken != null;
  
  /// GET request
  Future<Response> get(
    String endpoint, {
    Map<String, dynamic>? queryParameters,
  }) async {
    try {
      return await _dio.get(
        endpoint,
        queryParameters: queryParameters,
      );
    } catch (e) {
      rethrow;
    }
  }
  
  /// POST request
  Future<Response> post(
    String endpoint, {
    dynamic data,
    Map<String, dynamic>? queryParameters,
  }) async {
    try {
      return await _dio.post(
        endpoint,
        data: data,
        queryParameters: queryParameters,
      );
    } catch (e) {
      rethrow;
    }
  }
  
  /// PUT request
  Future<Response> put(
    String endpoint, {
    dynamic data,
    Map<String, dynamic>? queryParameters,
  }) async {
    try {
      return await _dio.put(
        endpoint,
        data: data,
        queryParameters: queryParameters,
      );
    } catch (e) {
      rethrow;
    }
  }
  
  /// DELETE request
  Future<Response> delete(
    String endpoint, {
    Map<String, dynamic>? queryParameters,
  }) async {
    try {
      return await _dio.delete(
        endpoint,
        queryParameters: queryParameters,
      );
    } catch (e) {
      rethrow;
    }
  }
  
  /// Login
  Future<Map<String, dynamic>> login(String email, String password) async {
    try {
      final response = await post(
        AppConfig.loginEndpoint,
        data: {
          'email': email,
          'password': password,
        },
      );
      
      if (response.data['token'] != null) {
        await _saveAuthToken(response.data['token']);
      }
      
      return response.data;
    } catch (e) {
      rethrow;
    }
  }
  
  /// Register
  Future<Map<String, dynamic>> register(Map<String, dynamic> data) async {
    try {
      final response = await post(
        AppConfig.registerEndpoint,
        data: data,
      );
      
      if (response.data['token'] != null) {
        await _saveAuthToken(response.data['token']);
      }
      
      return response.data;
    } catch (e) {
      rethrow;
    }
  }
  
  /// Logout
  Future<void> logout() async {
    try {
      await post(AppConfig.logoutEndpoint);
    } catch (e) {
      // Continue even if API call fails
    } finally {
      await _clearAuthToken();
    }
  }
  
  /// Get products
  Future<Map<String, dynamic>> getProducts({
    int page = 1,
    int perPage = 20,
    String? category,
    String? search,
    String? sortBy,
  }) async {
    try {
      final response = await get(
        AppConfig.productsEndpoint,
        queryParameters: {
          'page': page,
          'per_page': perPage,
          if (category != null) 'category': category,
          if (search != null) 'search': search,
          if (sortBy != null) 'sort_by': sortBy,
        },
      );
      
      return response.data;
    } catch (e) {
      rethrow;
    }
  }
  
  /// Get product by ID
  Future<Map<String, dynamic>> getProduct(int id) async {
    try {
      final response = await get('${AppConfig.productsEndpoint}/$id');
      return response.data;
    } catch (e) {
      rethrow;
    }
  }
  
  /// Get categories
  Future<List<dynamic>> getCategories() async {
    try {
      final response = await get(AppConfig.categoriesEndpoint);
      return response.data['data'] ?? response.data;
    } catch (e) {
      rethrow;
    }
  }
  
  /// Get banners
  Future<List<dynamic>> getBanners() async {
    try {
      final response = await get(AppConfig.bannersEndpoint);
      return response.data['data'] ?? response.data;
    } catch (e) {
      rethrow;
    }
  }
  
  /// Get cart
  Future<Map<String, dynamic>> getCart() async {
    try {
      final response = await get(AppConfig.cartEndpoint);
      return response.data;
    } catch (e) {
      rethrow;
    }
  }
  
  /// Add to cart
  Future<Map<String, dynamic>> addToCart(int productId, int quantity) async {
    try {
      final response = await post(
        AppConfig.cartEndpoint,
        data: {
          'product_id': productId,
          'quantity': quantity,
        },
      );
      return response.data;
    } catch (e) {
      rethrow;
    }
  }
  
  /// Update cart item
  Future<Map<String, dynamic>> updateCartItem(int itemId, int quantity) async {
    try {
      final response = await put(
        '${AppConfig.cartEndpoint}/$itemId',
        data: {
          'quantity': quantity,
        },
      );
      return response.data;
    } catch (e) {
      rethrow;
    }
  }
  
  /// Remove from cart
  Future<void> removeFromCart(int itemId) async {
    try {
      await delete('${AppConfig.cartEndpoint}/$itemId');
    } catch (e) {
      rethrow;
    }
  }
  
  /// Get wishlist
  Future<List<dynamic>> getWishlist() async {
    try {
      final response = await get(AppConfig.wishlistEndpoint);
      return response.data['data'] ?? response.data;
    } catch (e) {
      rethrow;
    }
  }
  
  /// Add to wishlist
  Future<void> addToWishlist(int productId) async {
    try {
      await post(
        AppConfig.wishlistEndpoint,
        data: {'product_id': productId},
      );
    } catch (e) {
      rethrow;
    }
  }
  
  /// Remove from wishlist
  Future<void> removeFromWishlist(int productId) async {
    try {
      await delete('${AppConfig.wishlistEndpoint}/$productId');
    } catch (e) {
      rethrow;
    }
  }
  
  /// Get orders
  Future<List<dynamic>> getOrders() async {
    try {
      final response = await get(AppConfig.ordersEndpoint);
      return response.data['data'] ?? response.data;
    } catch (e) {
      rethrow;
    }
  }
  
  /// Get order by ID
  Future<Map<String, dynamic>> getOrder(int id) async {
    try {
      final response = await get('${AppConfig.ordersEndpoint}/$id');
      return response.data;
    } catch (e) {
      rethrow;
    }
  }
  
  /// Get user profile
  Future<Map<String, dynamic>> getProfile() async {
    try {
      final response = await get(AppConfig.profileEndpoint);
      return response.data;
    } catch (e) {
      rethrow;
    }
  }
  
  /// Update user profile
  Future<Map<String, dynamic>> updateProfile(Map<String, dynamic> data) async {
    try {
      final response = await put(
        AppConfig.profileEndpoint,
        data: data,
      );
      return response.data;
    } catch (e) {
      rethrow;
    }
  }
}

