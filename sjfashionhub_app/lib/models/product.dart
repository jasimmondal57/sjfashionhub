class Product {
  final int id;
  final String name;
  final String description;
  final double price;
  final double? salePrice;
  final String? imageUrl;
  final List<String>? images;
  final List<String>? sizes;
  final List<String>? colors;
  final int stock;
  final String? category;
  final double? rating;
  final int? reviewCount;
  final bool isFeatured;
  final bool isOnSale;
  final String slug;
  final DateTime? createdAt;
  final DateTime? updatedAt;

  Product({
    required this.id,
    required this.name,
    required this.description,
    required this.price,
    this.salePrice,
    this.imageUrl,
    this.images,
    this.sizes,
    this.colors,
    this.stock = 0,
    this.category,
    this.rating,
    this.reviewCount,
    this.isFeatured = false,
    this.isOnSale = false,
    required this.slug,
    this.createdAt,
    this.updatedAt,
  });

  // Get the effective price (sale price if available, otherwise regular price)
  double get effectivePrice => salePrice ?? price;

  // Check if product is in stock
  bool get inStock => stock > 0;

  // Get discount percentage
  double get discountPercentage {
    if (salePrice != null && salePrice! < price) {
      return ((price - salePrice!) / price) * 100;
    }
    return 0.0;
  }

  // Get main image URL
  String get mainImageUrl {
    if (images != null && images!.isNotEmpty) {
      return images!.first;
    }
    return imageUrl ?? '';
  }

  // Create Product from JSON
  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: json['id'] ?? 0,
      name: json['name'] ?? '',
      description: json['description'] ?? '',
      price: (json['price'] ?? 0).toDouble(),
      salePrice: json['sale_price'] != null ? (json['sale_price']).toDouble() : null,
      imageUrl: json['image'],
      images: json['images'] != null 
          ? List<String>.from(json['images'])
          : null,
      sizes: json['sizes'] != null 
          ? List<String>.from(json['sizes'])
          : null,
      colors: json['colors'] != null 
          ? List<String>.from(json['colors'])
          : null,
      stock: json['stock'] ?? json['stock_quantity'] ?? 0,
      category: json['category'],
      rating: json['rating'] != null ? (json['rating']).toDouble() : null,
      reviewCount: json['review_count'] ?? json['reviews_count'],
      isFeatured: json['is_featured'] ?? false,
      isOnSale: json['is_on_sale'] ?? false,
      slug: json['slug'] ?? '',
      createdAt: json['created_at'] != null 
          ? DateTime.tryParse(json['created_at'])
          : null,
      updatedAt: json['updated_at'] != null 
          ? DateTime.tryParse(json['updated_at'])
          : null,
    );
  }

  // Convert Product to JSON
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'description': description,
      'price': price,
      'sale_price': salePrice,
      'image': imageUrl,
      'images': images,
      'sizes': sizes,
      'colors': colors,
      'stock': stock,
      'category': category,
      'rating': rating,
      'review_count': reviewCount,
      'is_featured': isFeatured,
      'is_on_sale': isOnSale,
      'slug': slug,
      'created_at': createdAt?.toIso8601String(),
      'updated_at': updatedAt?.toIso8601String(),
    };
  }

  // Create a copy with updated fields
  Product copyWith({
    int? id,
    String? name,
    String? description,
    double? price,
    double? salePrice,
    String? imageUrl,
    List<String>? images,
    List<String>? sizes,
    List<String>? colors,
    int? stock,
    String? category,
    double? rating,
    int? reviewCount,
    bool? isFeatured,
    bool? isOnSale,
    String? slug,
    DateTime? createdAt,
    DateTime? updatedAt,
  }) {
    return Product(
      id: id ?? this.id,
      name: name ?? this.name,
      description: description ?? this.description,
      price: price ?? this.price,
      salePrice: salePrice ?? this.salePrice,
      imageUrl: imageUrl ?? this.imageUrl,
      images: images ?? this.images,
      sizes: sizes ?? this.sizes,
      colors: colors ?? this.colors,
      stock: stock ?? this.stock,
      category: category ?? this.category,
      rating: rating ?? this.rating,
      reviewCount: reviewCount ?? this.reviewCount,
      isFeatured: isFeatured ?? this.isFeatured,
      isOnSale: isOnSale ?? this.isOnSale,
      slug: slug ?? this.slug,
      createdAt: createdAt ?? this.createdAt,
      updatedAt: updatedAt ?? this.updatedAt,
    );
  }

  @override
  String toString() {
    return 'Product(id: $id, name: $name, price: $price, stock: $stock)';
  }

  @override
  bool operator ==(Object other) {
    if (identical(this, other)) return true;
    return other is Product && other.id == id;
  }

  @override
  int get hashCode => id.hashCode;
}
