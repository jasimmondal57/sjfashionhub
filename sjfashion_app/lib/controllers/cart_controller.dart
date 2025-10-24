import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import '../models/product_model.dart';
import '../models/cart_item_model.dart';

class CartController extends GetxController {
  final GetStorage _storage = GetStorage();
  
  final RxList<CartItem> cartItems = <CartItem>[].obs;
  final RxDouble totalAmount = 0.0.obs;
  final RxInt cartItemCount = 0.obs;
  final RxBool isLoading = false.obs;
  
  @override
  void onInit() {
    super.onInit();
    _loadCartFromStorage();
  }
  
  void _loadCartFromStorage() {
    final List<dynamic>? savedCart = _storage.read('cart_items');
    if (savedCart != null) {
      cartItems.value = savedCart
          .map((item) => CartItem.fromJson(item))
          .toList();
      _updateCartSummary();
    }
  }
  
  void _saveCartToStorage() {
    _storage.write('cart_items', cartItems.map((item) => item.toJson()).toList());
  }
  
  void addToCart(Product product, {int quantity = 1}) {
    final existingIndex = cartItems.indexWhere(
      (item) => item.product.id == product.id,
    );
    
    if (existingIndex >= 0) {
      cartItems[existingIndex].quantity += quantity;
    } else {
      cartItems.add(CartItem(
        product: product,
        quantity: quantity,
      ));
    }
    
    _updateCartSummary();
    _saveCartToStorage();
    
    Get.snackbar(
      'Added to Cart',
      '${product.name} has been added to your cart',
      snackPosition: SnackPosition.BOTTOM,
      duration: const Duration(seconds: 2),
    );
  }
  
  void removeFromCart(String productId) {
    cartItems.removeWhere((item) => item.product.id == productId);
    _updateCartSummary();
    _saveCartToStorage();
  }
  
  void updateQuantity(String productId, int quantity) {
    if (quantity <= 0) {
      removeFromCart(productId);
      return;
    }
    
    final index = cartItems.indexWhere(
      (item) => item.product.id == productId,
    );
    
    if (index >= 0) {
      cartItems[index].quantity = quantity;
      _updateCartSummary();
      _saveCartToStorage();
    }
  }
  
  void clearCart() {
    cartItems.clear();
    _updateCartSummary();
    _saveCartToStorage();
  }
  
  void _updateCartSummary() {
    cartItemCount.value = cartItems.fold(0, (sum, item) => sum + item.quantity);
    totalAmount.value = cartItems.fold(0.0, (sum, item) => sum + item.totalPrice);
  }
  
  bool isInCart(String productId) {
    return cartItems.any((item) => item.product.id == productId);
  }
  
  int getQuantityInCart(String productId) {
    final item = cartItems.firstWhereOrNull(
      (item) => item.product.id == productId,
    );
    return item?.quantity ?? 0;
  }
}
