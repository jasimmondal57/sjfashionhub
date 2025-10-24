class BannerModel {
  int? id;
  String? title;
  String? image;
  String? link;
  int? sortOrder;
  bool? isActive;
  DateTime? createdAt;
  DateTime? updatedAt;

  BannerModel({
    this.id,
    this.title,
    this.image,
    this.link,
    this.sortOrder,
    this.isActive,
    this.createdAt,
    this.updatedAt,
  });

  factory BannerModel.fromJson(Map<String, dynamic> json) {
    return BannerModel(
      id: json['id'],
      title: json['title'],
      image: json['image'],
      link: json['link'],
      sortOrder: json['sort_order'],
      isActive: json['is_active'] == 1 || json['is_active'] == true,
      createdAt: json['created_at'] != null ? DateTime.parse(json['created_at']) : null,
      updatedAt: json['updated_at'] != null ? DateTime.parse(json['updated_at']) : null,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'title': title,
      'image': image,
      'link': link,
      'sort_order': sortOrder,
      'is_active': isActive,
      'created_at': createdAt?.toIso8601String(),
      'updated_at': updatedAt?.toIso8601String(),
    };
  }

  Map<String, dynamic> toFormData() {
    return {
      if (id != null) 'id': id.toString(),
      'title': title ?? '',
      'link': link ?? '',
      'sort_order': sortOrder?.toString() ?? '1',
      'is_active': isActive == true ? '1' : '0',
    };
  }
}
