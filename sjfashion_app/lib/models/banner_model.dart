class Banner {
  final String id;
  final String title;
  final String? description;
  final String? image;
  final String linkType;
  final String? linkValue;
  final int order;

  Banner({
    required this.id,
    required this.title,
    this.description,
    this.image,
    required this.linkType,
    this.linkValue,
    required this.order,
  });

  factory Banner.fromJson(Map<String, dynamic> json) {
    // Try multiple possible image field names
    String? imageUrl =
        json['image'] ??
        json['image_url'] ??
        json['banner_image'] ??
        json['url'];

    return Banner(
      id: json['id']?.toString() ?? '',
      title: json['title'] ?? '',
      description: json['description'],
      image: imageUrl,
      linkType: json['link_type'] ?? 'none',
      linkValue: json['link_value'],
      order: json['order'] ?? 0,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'title': title,
      'description': description,
      'image': image,
      'link_type': linkType,
      'link_value': linkValue,
      'order': order,
    };
  }
}
