import 'product_model.dart';
import 'category_model.dart';
import 'banner_model.dart';

class HomeSection {
  final String id;
  final String title;
  final String description;
  final String type;
  final Map<String, dynamic> config;
  final List<dynamic> items;

  HomeSection({
    required this.id,
    required this.title,
    required this.description,
    required this.type,
    required this.config,
    required this.items,
  });

  factory HomeSection.fromJson(Map<String, dynamic> json) {
    return HomeSection(
      id: json['id']?.toString() ?? '',
      title: json['title'] ?? '',
      description: json['description'] ?? '',
      type: json['type'] ?? '',
      config: json['config'] ?? {},
      items: _parseItems(json['items'], json['type']),
    );
  }

  static List<dynamic> _parseItems(dynamic items, String type) {
    if (items == null) return [];

    List<dynamic> parsedItems = [];

    if (items is List) {
      for (var item in items) {
        switch (type) {
          case 'banner':
            if (item is Map<String, dynamic>) {
              parsedItems.add(Banner.fromJson(item));
            }
            break;
          case 'category':
            if (item is List) {
              // Handle nested category list
              for (var categoryItem in item) {
                if (categoryItem is Map<String, dynamic>) {
                  parsedItems.add(Category.fromJson(categoryItem));
                }
              }
            } else if (item is Map<String, dynamic>) {
              parsedItems.add(Category.fromJson(item));
            }
            break;
          case 'featured':
          case 'product_grid':
          case 'product_carousel':
          case 'category_products':
            if (item is Map<String, dynamic>) {
              parsedItems.add(Product.fromJson(item));
            }
            break;
          default:
            parsedItems.add(item);
        }
      }
    }

    return parsedItems;
  }

  List<Banner> get banners => items.whereType<Banner>().toList();
  List<Category> get categories => items.whereType<Category>().toList();
  List<Product> get products => items.whereType<Product>().toList();

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'title': title,
      'description': description,
      'type': type,
      'config': config,
      'items': items.map((item) {
        if (item is Banner) return item.toJson();
        if (item is Category) return item.toJson();
        if (item is Product) return item.toJson();
        return item;
      }).toList(),
    };
  }
}

class HomeData {
  final List<HomeSection> sections;

  HomeData({required this.sections});

  factory HomeData.fromJson(Map<String, dynamic> json) {
    List<HomeSection> sections = [];

    if (json['sections'] != null && json['sections'] is List) {
      sections = (json['sections'] as List)
          .map((section) => HomeSection.fromJson(section))
          .toList();
    }

    return HomeData(sections: sections);
  }

  // Helper getters for specific sections
  HomeSection? get bannerSection => sections.firstWhere(
    (section) => section.type == 'banner',
    orElse: () => HomeSection(
      id: '0',
      title: 'Banners',
      description: '',
      type: 'banner',
      config: {},
      items: [],
    ),
  );

  HomeSection? get featuredCategoriesSection => sections.firstWhere(
    (section) => section.type == 'category',
    orElse: () => HomeSection(
      id: '0',
      title: 'Featured Categories',
      description: '',
      type: 'category',
      config: {},
      items: [],
    ),
  );

  HomeSection? get featuredProductsSection => sections.firstWhere(
    (section) => section.type == 'featured',
    orElse: () => HomeSection(
      id: '0',
      title: 'Featured Products',
      description: '',
      type: 'featured',
      config: {},
      items: [],
    ),
  );

  HomeSection? get newArrivalsSection => sections.firstWhere(
    (section) =>
        section.type == 'product_grid' &&
        section.title.toLowerCase().contains('new'),
    orElse: () => HomeSection(
      id: '0',
      title: 'New Arrivals',
      description: '',
      type: 'product_grid',
      config: {},
      items: [],
    ),
  );

  HomeSection? get bestSellersSection => sections.firstWhere(
    (section) =>
        section.type == 'product_carousel' &&
        section.title.toLowerCase().contains('best'),
    orElse: () => HomeSection(
      id: '0',
      title: 'Best Sellers',
      description: '',
      type: 'product_carousel',
      config: {},
      items: [],
    ),
  );

  Map<String, dynamic> toJson() {
    return {'sections': sections.map((section) => section.toJson()).toList()};
  }
}
