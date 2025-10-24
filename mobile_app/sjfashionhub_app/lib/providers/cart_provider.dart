import 'package:flutter/foundation.dart';
import '../models/cart_item.dart';
import '../models/product.dart';
import '../services/api_service.dart';

/// Cart Provider for state management
class CartProvider with ChangeNotifier {
  final ApiService _apiService = ApiService();
  
  List<CartItem> _items = [];
  bool _isLoading = false;
  String? _error;

  List<CartItem> get items => _items;
  bool get isLoading => _isLoading;
  String? get error => _error;
  
  int get itemCount => _items.length;
  
  double get subtotal {
    return _items.fold(0, (sum, item) => sum + item.totalPrice);
  }
  
  double get shipping => 50.0;
  double get total => subtotal + shipping;

  /// Load cart from API
  Future<void> loadCart() async {
    _isLoading = true;
    _error = null;
    notifyListeners();

    try {
      final response = await _apiService.getCart();
      _items = (response['items'] as List)
          .map((json) => CartItem.fromJson(json))
          .toList();
      _error = null;
    } catch (e) {
      _error = 'Failed to load cart: ${e.toString()}';
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  /// Add item to cart
  Future<void> addToCart(Product product, int quantity, {String? size, String? color}) async {
    try {
      await _apiService.addToCart(product.id, quantity);
      await loadCart(); // Reload cart
    } catch (e) {
      _error = 'Failed to add to cart: ${e.toString()}';
      notifyListeners();
      rethrow;
    }
  }

  /// Update item quantity
  Future<void> updateQuantity(CartItem item, int newQuantity) async {
    try {
      await _apiService.updateCartItem(item.id, newQuantity);
      final index = _items.indexWhere((i) => i.id == item.id);
      if (index != -1) {
        _items[index].quantity = newQuantity;
        notifyListeners();
      }
    } catch (e) {
      _error = 'Failed to update quantity: ${e.toString()}';
      notifyListeners();
      rethrow;
    }
  }

  /// Remove item from cart
  Future<void> removeItem(CartItem item) async {
    try {
      await _apiService.removeFromCart(item.id);
      _items.removeWhere((i) => i.id == item.id);
      notifyListeners();
    } catch (e) {
      _error = 'Failed to remove item: ${e.toString()}';
      notifyListeners();
      rethrow;
    }
  }

  /// Clear cart
  void clearCart() {
    _items.clear();
    notifyListeners();
  }
}

