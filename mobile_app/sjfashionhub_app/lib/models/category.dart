/// Category model
class Category {
  final int id;
  final String name;
  final String? description;
  final String? imageUrl;
  final int? parentId;
  final int productCount;

  Category({
    required this.id,
    required this.name,
    this.description,
    this.imageUrl,
    this.parentId,
    this.productCount = 0,
  });

  /// Factory constructor from JSON
  factory Category.fromJson(Map<String, dynamic> json) {
    return Category(
      id: json['id'] as int,
      name: json['name'] as String,
      description: json['description'] as String?,
      imageUrl: json['image'] as String?, // API returns 'image' not 'image_url'
      parentId: json['parent_id'] as int?,
      productCount:
          json['product_count'] as int? ?? json['products_count'] as int? ?? 0,
    );
  }

  /// Convert to JSON
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'description': description,
      'image_url': imageUrl,
      'parent_id': parentId,
      'product_count': productCount,
    };
  }
}
