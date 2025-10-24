import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';

class AuthController extends GetxController {
  final GetStorage _storage = GetStorage();
  
  final RxBool isLoggedIn = false.obs;
  final RxBool isLoading = false.obs;
  final RxString userToken = ''.obs;
  final RxMap<String, dynamic> userData = <String, dynamic>{}.obs;
  
  @override
  void onInit() {
    super.onInit();
    _checkAuthStatus();
  }
  
  void _checkAuthStatus() {
    final token = _storage.read('auth_token');
    final user = _storage.read('user_data');
    
    if (token != null && user != null) {
      userToken.value = token;
      userData.value = Map<String, dynamic>.from(user);
      isLoggedIn.value = true;
    }
  }
  
  Future<void> login(String email, String password) async {
    try {
      isLoading.value = true;
      
      // TODO: Implement actual login API call
      await Future.delayed(const Duration(seconds: 2)); // Simulate API call
      
      // Mock successful login
      final mockToken = 'mock_token_${DateTime.now().millisecondsSinceEpoch}';
      final mockUser = {
        'id': '1',
        'name': 'John Doe',
        'email': email,
        'phone': '+1234567890',
      };
      
      userToken.value = mockToken;
      userData.value = mockUser;
      isLoggedIn.value = true;
      
      _storage.write('auth_token', mockToken);
      _storage.write('user_data', mockUser);
      
      Get.snackbar(
        'Success',
        'Logged in successfully',
        snackPosition: SnackPosition.BOTTOM,
      );
      
    } catch (e) {
      Get.snackbar(
        'Error',
        'Login failed: ${e.toString()}',
        snackPosition: SnackPosition.BOTTOM,
      );
    } finally {
      isLoading.value = false;
    }
  }
  
  Future<void> register(String name, String email, String password) async {
    try {
      isLoading.value = true;
      
      // TODO: Implement actual register API call
      await Future.delayed(const Duration(seconds: 2)); // Simulate API call
      
      Get.snackbar(
        'Success',
        'Account created successfully. Please login.',
        snackPosition: SnackPosition.BOTTOM,
      );
      
    } catch (e) {
      Get.snackbar(
        'Error',
        'Registration failed: ${e.toString()}',
        snackPosition: SnackPosition.BOTTOM,
      );
    } finally {
      isLoading.value = false;
    }
  }
  
  void logout() {
    isLoggedIn.value = false;
    userToken.value = '';
    userData.clear();
    
    _storage.remove('auth_token');
    _storage.remove('user_data');
    
    Get.snackbar(
      'Success',
      'Logged out successfully',
      snackPosition: SnackPosition.BOTTOM,
    );
  }
  
  String get userName => userData['name'] ?? 'Guest';
  String get userEmail => userData['email'] ?? '';
  String get userPhone => userData['phone'] ?? '';
}
