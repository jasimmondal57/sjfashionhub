/// Banner model
class Banner {
  final int id;
  final String title;
  final String? subtitle;
  final String imageUrl;
  final String? link;
  final int order;
  final bool isActive;

  Banner({
    required this.id,
    required this.title,
    this.subtitle,
    required this.imageUrl,
    this.link,
    this.order = 0,
    this.isActive = true,
  });

  /// Factory constructor from JSON
  factory Banner.fromJson(Map<String, dynamic> json) {
    return Banner(
      id: json['id'] as int,
      title: json['title'] as String? ?? json['name'] as String? ?? 'Banner',
      subtitle:
          json['description']
              as String?, // API returns 'description' not 'subtitle'
      imageUrl:
          json['image_path'] as String? ??
          json['image_url'] as String? ??
          '', // API returns 'image_path'
      link:
          json['custom_link'] as String? ??
          json['button_link'] as String? ??
          json['link'] as String?,
      order: json['sort_order'] as int? ?? json['order'] as int? ?? 0,
      isActive: (json['is_active'] is bool)
          ? json['is_active'] as bool
          : (json['is_active'] == 1 ||
                json['is_active'] == '1' ||
                json['is_active'] == true),
    );
  }

  /// Convert to JSON
  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'title': title,
      'subtitle': subtitle,
      'image_url': imageUrl,
      'link': link,
      'order': order,
      'is_active': isActive,
    };
  }
}
