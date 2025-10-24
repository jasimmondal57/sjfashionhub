import 'api_service.dart';

class AuthService {
  final _apiService = ApiService();

  // Check if user is authenticated
  bool get isAuthenticated => _apiService.isAuthenticated;

  // Get current token
  String? get token => _apiService.token;

  // Login with email and password
  Future<Map<String, dynamic>> login(String email, String password) async {
    try {
      final response = await _apiService.login(email, password);
      return {
        'success': true,
        'user': response['user'],
        'message': response['message'],
      };
    } catch (e) {
      return {
        'success': false,
        'message': e.toString().replaceAll('Exception: ', ''),
      };
    }
  }

  // Register new user
  Future<Map<String, dynamic>> register({
    required String name,
    required String email,
    required String password,
    required String passwordConfirmation,
    String? phone,
  }) async {
    try {
      final response = await _apiService.register({
        'name': name,
        'email': email,
        'password': password,
        'password_confirmation': passwordConfirmation,
        'phone': phone,
      });
      return {
        'success': true,
        'user': response['user'],
        'message': response['message'],
      };
    } catch (e) {
      return {
        'success': false,
        'message': e.toString().replaceAll('Exception: ', ''),
      };
    }
  }

  // Logout
  Future<void> logout() async {
    await _apiService.logout();
  }

  // Get current user profile
  Future<Map<String, dynamic>?> getCurrentUser() async {
    if (!isAuthenticated) return null;

    try {
      final response = await _apiService.getProfile();
      return response['user'];
    } catch (e) {
      return null;
    }
  }
}
