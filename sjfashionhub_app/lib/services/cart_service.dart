import 'api_service.dart';

class CartService {
  final _apiService = ApiService();

  // Get cart items
  Future<Map<String, dynamic>> getCart() async {
    try {
      return await _apiService.getCart();
    } catch (e) {
      return {'cart_items': [], 'total': 0, 'items_count': 0};
    }
  }

  // Add item to cart
  Future<Map<String, dynamic>> addToCart(int productId, int quantity) async {
    try {
      final response = await _apiService.addToCart(productId, quantity);
      print('Add to cart response: $response');
      return {
        'success': true,
        'message': response['message'] ?? 'Product added to cart',
      };
    } catch (e) {
      print('Add to cart error: $e');
      String errorMessage = 'Failed to add to cart';

      // Extract meaningful error message
      if (e.toString().contains('Insufficient stock available')) {
        errorMessage =
            'Sorry, this item is out of stock or insufficient stock available';
      } else if (e.toString().contains('Network error')) {
        errorMessage =
            'Network error. Please check your connection and try again';
      } else if (e.toString().contains('Unauthorized')) {
        errorMessage = 'Please login to add items to cart';
      }

      return {'success': false, 'message': errorMessage};
    }
  }

  // Update cart item quantity
  Future<bool> updateCartItem(int itemId, int quantity) async {
    try {
      await _apiService.updateCartItem(itemId, quantity);
      return true;
    } catch (e) {
      return false;
    }
  }

  // Remove item from cart
  Future<bool> removeFromCart(int itemId) async {
    try {
      await _apiService.removeFromCart(itemId);
      return true;
    } catch (e) {
      return false;
    }
  }

  // Clear entire cart
  Future<bool> clearCart() async {
    try {
      await _apiService.clearCart();
      return true;
    } catch (e) {
      return false;
    }
  }
}
