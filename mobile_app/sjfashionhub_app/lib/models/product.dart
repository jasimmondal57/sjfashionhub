/// Product model
class Product {
  final int id;
  final String name;
  final String description;
  final double price;
  final double? discountPrice;
  final String? imageUrl;
  final List<String>? images;
  final String? category;
  final int? categoryId;
  final List<String>? sizes;
  final List<String>? colors;
  final int stock;
  final double? rating;
  final int? reviewCount;
  final bool isFeatured;
  final bool isNew;
  final DateTime? createdAt;

  Product({
    required this.id,
    required this.name,
    required this.description,
    required this.price,
    this.discountPrice,
    this.imageUrl,
    this.images,
    this.category,
    this.categoryId,
    this.sizes,
    this.colors,
    this.stock = 0,
    this.rating,
    this.reviewCount,
    this.isFeatured = false,
    this.isNew = false,
    this.createdAt,
  });

  /// Calculate discount percentage
  int? get discountPercentage {
    if (discountPrice != null && discountPrice! < price) {
      return (((price - discountPrice!) / price) * 100).round();
    }
    return null;
  }

  /// Get effective price (discount price if available, otherwise regular price)
  double get effectivePrice => discountPrice ?? price;

  /// Check if product is in stock
  bool get inStock => stock > 0;

  /// Check if product has discount
  bool get hasDiscount => discountPrice != null && discountPrice! < price;

  /// Factory constructor from JSON
  factory Product.fromJson(Map<String, dynamic> json) {
    // Helper function to parse price (handles both String and num)
    double parsePrice(dynamic value) {
      if (value == null) return 0.0;
      if (value is num) return value.toDouble();
      if (value is String) return double.tryParse(value) ?? 0.0;
      return 0.0;
    }

    return Product(
      id: json['id'] as int,
      name: json['name'] as String,
      description:
          json['description'] as String? ??
          json['short_description'] as String? ??
          '',
      price: parsePrice(json['price']),
      discountPrice: json['sale_price'] != null
          ? parsePrice(json['sale_price'])
          : (json['discount_price'] != null
                ? parsePrice(json['discount_price'])
                : null),
      imageUrl: json['image_url'] as String?,
      images: json['images'] != null ? List<String>.from(json['images']) : null,
      category: json['category'] is Map
          ? json['category']['name'] as String?
          : json['category'] as String?,
      categoryId: json['category_id'] as int?,
      sizes: json['sizes'] != null ? List<String>.from(json['sizes']) : null,
      colors: json['colors'] != null ? List<String>.from(json['colors']) : null,
      stock: json['stock_quantity'] as int? ?? json['stock'] as int? ?? 0,
      rating: json['rating'] != null
          ? (json['rating'] as num).toDouble()
          : null,
      reviewCount: json['review_count'] as int?,
      isFeatured: json['is_featured'] as bool? ?? false,
      isNew: json['is_new'] as bool? ?? false,
      createdAt: json['created_at'] != null
          ? DateTime.parse(json['created_at'])
          : null,
    );
  }

  /// Convert to JSON
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'description': description,
      'price': price,
      'discount_price': discountPrice,
      'image_url': imageUrl,
      'images': images,
      'category': category,
      'category_id': categoryId,
      'sizes': sizes,
      'colors': colors,
      'stock': stock,
      'rating': rating,
      'review_count': reviewCount,
      'is_featured': isFeatured,
      'is_new': isNew,
      'created_at': createdAt?.toIso8601String(),
    };
  }
}
