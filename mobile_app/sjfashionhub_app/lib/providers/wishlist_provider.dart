import 'package:flutter/foundation.dart';
import '../models/product.dart';
import '../services/api_service.dart';

/// Wishlist Provider for state management
class WishlistProvider with ChangeNotifier {
  final ApiService _apiService = ApiService();
  
  List<Product> _items = [];
  bool _isLoading = false;
  String? _error;

  List<Product> get items => _items;
  bool get isLoading => _isLoading;
  String? get error => _error;
  
  int get itemCount => _items.length;

  /// Check if product is in wishlist
  bool isFavorite(int productId) {
    return _items.any((item) => item.id == productId);
  }

  /// Load wishlist from API
  Future<void> loadWishlist() async {
    _isLoading = true;
    _error = null;
    notifyListeners();

    try {
      final response = await _apiService.getWishlist();
      _items = response.map((json) => Product.fromJson(json)).toList();
      _error = null;
    } catch (e) {
      _error = 'Failed to load wishlist: ${e.toString()}';
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  /// Add to wishlist
  Future<void> addToWishlist(Product product) async {
    try {
      await _apiService.addToWishlist(product.id);
      if (!_items.any((item) => item.id == product.id)) {
        _items.add(product);
        notifyListeners();
      }
    } catch (e) {
      _error = 'Failed to add to wishlist: ${e.toString()}';
      notifyListeners();
      rethrow;
    }
  }

  /// Remove from wishlist
  Future<void> removeFromWishlist(Product product) async {
    try {
      await _apiService.removeFromWishlist(product.id);
      _items.removeWhere((item) => item.id == product.id);
      notifyListeners();
    } catch (e) {
      _error = 'Failed to remove from wishlist: ${e.toString()}';
      notifyListeners();
      rethrow;
    }
  }

  /// Toggle wishlist
  Future<void> toggleWishlist(Product product) async {
    if (isFavorite(product.id)) {
      await removeFromWishlist(product);
    } else {
      await addToWishlist(product);
    }
  }
}

