import 'product.dart';

/// Cart item model
class CartItem {
  final int id;
  final Product product;
  int quantity;
  final String? size;
  final String? color;
  
  CartItem({
    required this.id,
    required this.product,
    required this.quantity,
    this.size,
    this.color,
  });
  
  /// Calculate total price for this item
  double get totalPrice => product.effectivePrice * quantity;
  
  /// Factory constructor from JSON
  factory CartItem.fromJson(Map<String, dynamic> json) {
    return CartItem(
      id: json['id'] as int,
      product: Product.fromJson(json['product']),
      quantity: json['quantity'] as int,
      size: json['size'] as String?,
      color: json['color'] as String?,
    );
  }
  
  /// Convert to JSON
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'product': product.toJson(),
      'quantity': quantity,
      'size': size,
      'color': color,
    };
  }
}

