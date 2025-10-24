class Category {
  final String id;
  final String name;
  final String slug;
  final String? description;
  final String? image;
  final String? icon;
  final int productCount;
  final bool isActive;
  final String? parentId;

  Category({
    required this.id,
    required this.name,
    required this.slug,
    this.description,
    this.image,
    this.icon,
    this.productCount = 0,
    this.isActive = true,
    this.parentId,
  });

  factory Category.fromJson(Map<String, dynamic> json) {
    return Category(
      id: json['id']?.toString() ?? '',
      name: json['name'] ?? '',
      slug: json['slug'] ?? '',
      description: json['description'],
      image: json['image'],
      icon: json['icon'],
      productCount: _parseInt(json['product_count']) ?? 
                   _parseInt(json['products_count']) ?? 0,
      isActive: json['is_active'] ?? json['status'] == 1 ?? true,
      parentId: json['parent_id']?.toString(),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'slug': slug,
      'description': description,
      'image': image,
      'icon': icon,
      'product_count': productCount,
      'is_active': isActive,
      'parent_id': parentId,
    };
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
