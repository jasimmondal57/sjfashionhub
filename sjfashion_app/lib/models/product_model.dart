class Product {
  final String id;
  final String name;
  final String slug;
  final String description;
  final double price;
  final double? salePrice;
  final String? image;
  final List<String> images;
  final bool inStock;
  final int stock;
  final double rating;
  final String? categoryId;
  final String? categoryName;
  final bool hasDiscount;
  final double discountPercentage;

  Product({
    required this.id,
    required this.name,
    required this.slug,
    required this.description,
    required this.price,
    this.salePrice,
    this.image,
    this.images = const [],
    this.inStock = true,
    this.stock = 0,
    this.rating = 0.0,
    this.categoryId,
    this.categoryName,
    this.hasDiscount = false,
    this.discountPercentage = 0.0,
  });

  double get finalPrice => salePrice ?? price;

  double get savings => hasDiscount ? price - finalPrice : 0.0;

  String get mainImage => image ?? (images.isNotEmpty ? images.first : '');

  bool get isOnSale => salePrice != null && salePrice! < price;

  factory Product.fromJson(Map<String, dynamic> json) {
    double price = _parseDouble(json['price']) ?? 0.0;
    double? salePrice = json['sale_price'] != null
        ? _parseDouble(json['sale_price'])
        : null;

    List<String> imagesList = [];
    if (json['images'] != null) {
      if (json['images'] is List) {
        imagesList = List<String>.from(json['images']);
      } else if (json['images'] is String) {
        try {
          // Try to parse as JSON array
          imagesList = List<String>.from(json['images']);
        } catch (e) {
          // If parsing fails, treat as single image
          imagesList = [json['images']];
        }
      }
    }

    return Product(
      id: json['id']?.toString() ?? '',
      name: json['name'] ?? '',
      slug: json['slug'] ?? '',
      description: json['description'] ?? '',
      price: price,
      salePrice: salePrice,
      image: json['image'],
      images: imagesList,
      inStock: json['in_stock'] ?? json['status'] == 1 ?? true,
      stock: _parseInt(json['stock']) ?? _parseInt(json['stock_quantity']) ?? 0,
      rating: _parseDouble(json['rating']) ?? 0.0,
      categoryId:
          json['category_id']?.toString() ??
          json['category']?['id']?.toString(),
      categoryName: json['category_name'] ?? json['category']?['name'],
      hasDiscount: salePrice != null,
      discountPercentage: salePrice != null
          ? ((price - salePrice) / price * 100)
          : 0.0,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'slug': slug,
      'description': description,
      'price': price,
      'sale_price': salePrice,
      'image': image,
      'images': images,
      'in_stock': inStock,
      'stock': stock,
      'rating': rating,
      'category_id': categoryId,
      'category_name': categoryName,
      'has_discount': hasDiscount,
      'discount_percentage': discountPercentage,
    };
  }

  static double? _parseDouble(dynamic value) {
    if (value == null) return null;
    if (value is double) return value;
    if (value is int) return value.toDouble();
    if (value is String) {
      return double.tryParse(value);
    }
    return null;
  }

  static int? _parseInt(dynamic value) {
    if (value == null) return null;
    if (value is int) return value;
    if (value is double) return value.toInt();
    if (value is String) {
      return int.tryParse(value);
    }
    return null;
  }
}
