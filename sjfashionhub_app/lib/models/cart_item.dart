class CartItem {
  final String productId;
  final String title;
  final String imageUrl;
  final double price;
  int quantity;

  CartItem({
    required this.productId,
    required this.title,
    required this.imageUrl,
    required this.price,
    this.quantity = 1,
  });
}
