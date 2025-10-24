import 'api_service.dart';

class WishlistService {
  final _apiService = ApiService();

  // Get wishlist items
  Future<List<Map<String, dynamic>>> getWishlist() async {
    try {
      final response = await _apiService.getWishlist();
      return List<Map<String, dynamic>>.from(response['wishlist_items'] ?? []);
    } catch (e) {
      return [];
    }
  }

  // Add product to wishlist
  Future<bool> addToWishlist(int productId) async {
    try {
      await _apiService.addToWishlist(productId);
      return true;
    } catch (e) {
      return false;
    }
  }

  // Remove product from wishlist
  Future<bool> removeFromWishlist(int productId) async {
    try {
      await _apiService.removeFromWishlist(productId);
      return true;
    } catch (e) {
      return false;
    }
  }
}
