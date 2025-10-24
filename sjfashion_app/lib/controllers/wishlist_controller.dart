import 'package:get/get.dart';
import '../models/product_model.dart';
import '../services/api_service.dart';

class WishlistController extends GetxController {
  final ApiService _apiService = ApiService();

  final RxList<Product> wishlistProducts = <Product>[].obs;
  final RxBool isLoading = false.obs;
  final RxSet<String> wishlistProductIds = <String>{}.obs;

  @override
  void onInit() {
    super.onInit();
    loadWishlist();
  }

  Future<void> loadWishlist() async {
    try {
      isLoading.value = true;

      // TODO: Replace with actual API endpoint when available
      // For now, using local storage or empty list
      wishlistProducts.clear();
      wishlistProductIds.clear();

      print('📋 Wishlist loaded: ${wishlistProducts.length} items');
    } catch (e) {
      print('❌ Error loading wishlist: $e');
      Get.snackbar(
        'Error',
        'Failed to load wishlist',
        snackPosition: SnackPosition.BOTTOM,
      );
    } finally {
      isLoading.value = false;
    }
  }

  bool isInWishlist(String productId) {
    return wishlistProductIds.contains(productId);
  }

  Future<void> toggleWishlist(Product product) async {
    try {
      if (isInWishlist(product.id)) {
        // Remove from wishlist
        await removeFromWishlist(product.id);
      } else {
        // Add to wishlist
        await addToWishlist(product);
      }
    } catch (e) {
      print('❌ Error toggling wishlist: $e');
      Get.snackbar(
        'Error',
        'Failed to update wishlist',
        snackPosition: SnackPosition.BOTTOM,
      );
    }
  }

  Future<void> addToWishlist(Product product) async {
    try {
      // TODO: Replace with actual API call when available
      // final response = await _apiService.post('/wishlist', {'product_id': product.id});

      wishlistProducts.add(product);
      wishlistProductIds.add(product.id);

      Get.snackbar(
        'Added to Wishlist',
        '${product.name} has been added to your wishlist',
        snackPosition: SnackPosition.BOTTOM,
        duration: const Duration(seconds: 2),
      );

      print('✅ Added to wishlist: ${product.name}');
    } catch (e) {
      print('❌ Error adding to wishlist: $e');
      rethrow;
    }
  }

  Future<void> removeFromWishlist(String productId) async {
    try {
      // TODO: Replace with actual API call when available
      // final response = await _apiService.delete('/wishlist/$productId');

      final product = wishlistProducts.firstWhere((p) => p.id == productId);
      wishlistProducts.removeWhere((p) => p.id == productId);
      wishlistProductIds.remove(productId);

      Get.snackbar(
        'Removed from Wishlist',
        '${product.name} has been removed from your wishlist',
        snackPosition: SnackPosition.BOTTOM,
        duration: const Duration(seconds: 2),
      );

      print('✅ Removed from wishlist: ${product.name}');
    } catch (e) {
      print('❌ Error removing from wishlist: $e');
      rethrow;
    }
  }

  Future<void> clearWishlist() async {
    try {
      // TODO: Replace with actual API call when available
      // final response = await _apiService.delete('/wishlist/clear');

      wishlistProducts.clear();
      wishlistProductIds.clear();

      Get.snackbar(
        'Wishlist Cleared',
        'All items have been removed from your wishlist',
        snackPosition: SnackPosition.BOTTOM,
        duration: const Duration(seconds: 2),
      );

      print('✅ Wishlist cleared');
    } catch (e) {
      print('❌ Error clearing wishlist: $e');
      Get.snackbar(
        'Error',
        'Failed to clear wishlist',
        snackPosition: SnackPosition.BOTTOM,
      );
    }
  }

  int get wishlistCount => wishlistProducts.length;
}
