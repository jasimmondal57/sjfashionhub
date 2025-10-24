import 'dart:convert';

/// API Adapter to convert SJFashionHub API responses to Amazy app format
class ApiAdapter {
  /// Convert SJFashionHub product list response to Amazy format
  static Map<String, dynamic> adaptProductList(Map<String, dynamic> response) {
    List<dynamic> products = response['products'] ?? [];

    return {
      'products': products.map((product) => adaptProduct(product)).toList(),
      'pagination': response['pagination'] ?? {},
    };
  }

  /// Convert single product to Amazy format
  static Map<String, dynamic> adaptProduct(Map<String, dynamic> product) {
    // Handle null values and ensure proper types
    List<dynamic> images = product['images'] ?? [];

    // If images array is empty, try to use the single image field
    if (images.isEmpty && product['image'] != null) {
      images = [product['image']];
    }

    // Get first image or default
    String mainImage = '';
    if (images.isNotEmpty) {
      mainImage = images[0].toString();
    }

    print("🖼️ API Adapter: Product ${product['id']} - Image: $mainImage");

    // Calculate price properly
    double price = double.tryParse(product['price']?.toString() ?? '0') ?? 0.0;
    double? salePrice = product['sale_price'] != null
        ? double.tryParse(product['sale_price'].toString())
        : null;

    print(
      "💰 API Adapter: Product ${product['id']} - Price: $price, Sale Price: $salePrice",
    );
    print(
      "📝 API Adapter: Product ${product['id']} - Name: ${product['name']}",
    );

    return {
      'id': product['id'] ?? 0,
      'user_id': 1, // Default seller ID
      'product_id': product['id'] ?? 0,
      'tax': 0.0,
      'tax_type': 'flat',
      'discount': salePrice != null ? (price - salePrice) : 0.0,
      'discount_type': 'flat',
      'discount_start_date': null,
      'discount_end_date': null,
      'product_name': product['name'] ?? 'Product',
      'slug': product['slug'] ?? '',
      'thum_img': mainImage,
      'status': 1,
      'stock_manage': 1,
      'is_approved': 1,
      'min_sell_price': salePrice ?? price,
      'max_sell_price': price,
      'total_sale': 0,
      'avg_rating': (product['rating'] ?? 0).toDouble(),
      'max_selling_price': price,
      'rating': (product['rating'] ?? 0).toDouble(),
      'has_deal': null,
      'has_discount': salePrice != null ? 'yes' : 'no',
      'product': {
        'id': product['id'] ?? 0,
        'product_name': product['name'] ?? 'Product',
        'product_type': 1,
        'unit_type_id': 1,
        'brand_id': null,
        'category_id': product['category']?['id'] ?? 1,
        'sub_category_id': null,
        'child_category_id': null,
        'attributes': [],
        'choice_options': [],
        'color_image': [],
        'variation': [],
        'unit_price': price,
        'purchase_price': price * 0.8, // Assume 20% margin
        'tax': 0,
        'tax_type': 'flat',
        'discount': salePrice != null ? (price - salePrice) : 0.0,
        'discount_type': 'flat',
        'current_stock':
            product['stock'] ??
            product['stock_quantity'] ??
            100, // Default to 100 if null
        'minimum_order_qty': 1,
        'details': product['description'] ?? '',
        'free_shipping': 0,
        'attachment': null,
        'created_at': DateTime.now().toIso8601String(),
        'updated_at': DateTime.now().toIso8601String(),
        'status': 1,
        'featured': product['is_featured'] ?? false ? 1 : 0,
        'flash_deal': 0,
        'video_provider': 'youtube',
        'video_link': null,
        'colors': [],
        'variant_product': 0,
        'attributes': [],
        'choice_options': [],
        'variation': [],
        'published': 1,
        'unit_id': 1,
        'refundable': 1,
        'category': product['category'] ?? {'id': 1, 'name': 'General'},
        'thumbnail_image_source': mainImage,
        'gallery_images': images.map((img) => {'image_name': img}).toList(),
      },
      'skus': [
        {
          'id': product['id'] ?? 0,
          'user_id': 1,
          'product_id': product['id'] ?? 0,
          'product_sku_id': product['id'] ?? 0,
          'product_stock':
              product['stock'] ??
              product['stock_quantity'] ??
              100, // Default to 100 if null
          'selling_price': salePrice ?? price,
          'status': 1,
          'attr_image': mainImage,
          'color_image': mainImage,
          'created_at': DateTime.now().toIso8601String(),
          'updated_at': DateTime.now().toIso8601String(),
          'track_qty': 1,
          'variant': null,
          'attribute_value_id': null,
          'color_id': null,
          'size_id': null,
          'additional_shipping': 0,
          'product_variations': [],
          'product_variation_combinations': [],
          'in_app_purchase_id': null,
        },
      ],
      'reviews': [],
      'variant_details': [],
      'flash_deal': null,
      'seller': {
        'id': 1,
        'first_name': 'SJ Fashion Hub',
        'last_name': '',
        'username': 'sjfashionhub',
        'photo': null,
        'phone': null,
        'email': 'admin@sjfashionhub.com',
        'date_of_birth': null,
        'description': null,
        'status': 1,
        'avatar': null,
        'banner': null,
        'slug': 'sjfashionhub',
        'shop_name': 'SJ Fashion Hub',
        'shop_details': 'Official SJ Fashion Hub Store',
        'shop_image': null,
        'shop_cover': null,
        'seller_account_id': 1,
        'holiday_mode': 0,
        'holiday_type': 0,
        'holiday_start_date': null,
        'holiday_end_date': null,
        'holiday_date_list': [],
        'top_selling_item_count': 0,
        'total_sale_count': 0,
        'avg_rating': 5.0,
        'total_rating': 0,
        'rating_count': 0,
      },
      'product_type': {'id': 1, 'name': 'Physical Product', 'type': 1},
    };
  }

  /// Convert SJFashionHub cart response to Amazy format
  static Map<String, dynamic> adaptCart(Map<String, dynamic> response) {
    List<dynamic> cartItems = response['cart_items'] ?? [];

    // Group by seller (all items from same seller for SJFashionHub)
    Map<String, List<Map<String, dynamic>>> groupedCarts = {
      'sjfashionhub': cartItems.map((item) => adaptCartItem(item)).toList(),
    };

    return {
      'carts': groupedCarts,
      'message': 'Cart loaded successfully',
      'shipping_charge': 0.0,
      'total': response['total'] ?? 0,
      'items_count': cartItems.length,
    };
  }

  /// Convert single cart item to Amazy format
  static Map<String, dynamic> adaptCartItem(Map<String, dynamic> item) {
    Map<String, dynamic> product = item['product'] ?? {};

    return {
      'id': item['id'],
      'user_id': null,
      'seller_id': 1, // Default seller ID for SJFashionHub
      'product_type': 'product',
      'product_id': product['id'],
      'product_sku_id': product['id'],
      'qty': item['quantity'],
      'price': item['price'],
      'total_price': item['subtotal'],
      'is_select': 1,
      'product': {
        'id': product['id'],
        'product_name': product['name'],
        'slug': product['slug'],
        'thumbnail_image_source': product['image'],
        'price': product['price'],
        'sale_price': product['sale_price'],
        'stock': product['stock'],
        'in_stock': product['in_stock'],
      },
      'seller': {
        'id': 1,
        'first_name': 'SJ Fashion Hub',
        'last_name': '',
        'slug': 'sjfashionhub',
      },
    };
  }

  /// Convert SJFashionHub home response to Amazy format
  static Map<String, dynamic> adaptHome(Map<String, dynamic> response) {
    // Handle the actual response structure from sjfashionhub
    List<dynamic> sections = response['sections'] ?? [];
    print('API Adapter: Processing ${sections.length} sections');

    List<Map<String, dynamic>> sliders = [];
    List<Map<String, dynamic>> categories = [];
    List<Map<String, dynamic>> products = [];
    List<Map<String, dynamic>> featuredProducts = [];
    List<Map<String, dynamic>> dealsProducts = [];

    // Process each section
    for (var section in sections) {
      String sectionType = section['type'] ?? '';
      List<dynamic> items = section['items'] ?? [];
      print(
        'API Adapter: Processing section type: $sectionType with ${items.length} items',
      );

      switch (sectionType) {
        case 'banner':
          sliders.addAll(
            items.map(
              (banner) => {
                'id': banner['id'] ?? 0,
                'name': banner['title'] ?? '',
                'data_type': 'url',
                'data_id': 0,
                'slider_image': banner['image_url'] ?? '',
                'position': banner['id'] ?? 0,
                'category': null,
                'brand': null,
                'tag': null,
              },
            ),
          );
          break;

        case 'category':
          categories.addAll(
            items.map(
              (category) => {
                'id': category['id'] ?? 0,
                'name': category['name'] ?? '',
                'slug': category['slug'] ?? '',
                'icon': category['image'] ?? '',
                'banner': category['image'] ?? '',
                'products_count': category['products_count'] ?? 0,
              },
            ),
          );
          break;

        case 'product_grid':
        case 'product_carousel':
          products.addAll(items.map((product) => adaptProduct(product)));
          break;

        case 'featured':
          featuredProducts.addAll(
            items.map((product) => adaptProduct(product)),
          );
          break;

        case 'deals':
          dealsProducts.addAll(items.map((product) => adaptProduct(product)));
          break;
      }
    }

    // Combine all products
    List<Map<String, dynamic>> allProducts = [
      ...products,
      ...featuredProducts,
      ...dealsProducts,
    ];

    // If no banners, create a default one
    if (sliders.isEmpty) {
      sliders = [
        {
          'id': 1,
          'name': 'Welcome to SJ Fashion Hub',
          'data_type': 'url',
          'data_id': 0,
          'slider_image': 'https://sjfashionhub.com/storage/default-banner.jpg',
          'position': 1,
          'category': null,
          'brand': null,
          'tag': null,
        },
      ];
    }

    // Create proper structure for Amazy app
    print(
      'API Adapter: Final counts - sliders: ${sliders.length}, categories: ${categories.length}, products: ${allProducts.length}',
    );

    // Create featured brands from categories (since SJFashionHub doesn't have brands)
    List<Map<String, dynamic>> featuredBrands = categories
        .take(6)
        .map(
          (category) => {
            'id': category['id'],
            'name': category['name'],
            'slug': category['slug'],
            'logo': category['icon'],
            'image': category['icon'],
            'icon': category['icon'],
          },
        )
        .toList();

    return {
      'sliders': sliders,
      'top_categories': categories,
      'featured_brands': featuredBrands,
      'products': allProducts,
      'recommended_products': allProducts.take(10).toList(),
      'top_picks': featuredProducts.isNotEmpty
          ? featuredProducts.take(8).toList()
          : allProducts.take(8).toList(),
      'flash_deal': dealsProducts.isNotEmpty
          ? {
              'id': 1,
              'title': 'Flash Sale',
              'background_color': '#FF6B6B',
              'text_color': '#FFFFFF',
              'start_date': DateTime.now().toIso8601String(),
              'end_date': DateTime.now()
                  .add(Duration(days: 7))
                  .toIso8601String(),
              'slug': 'flash-sale',
              'banner_image': null,
              'is_featured': 1,
              'AllProducts': dealsProducts
                  .map(
                    (product) => {
                      'id': product['id'],
                      'flash_deal_id': 1,
                      'seller_product_id': product['id'],
                      'discount': 10,
                      'discount_type': 1,
                      'status': 1,
                      'created_at': DateTime.now().toIso8601String(),
                      'updated_at': DateTime.now().toIso8601String(),
                      'product': product,
                    },
                  )
                  .toList(),
            }
          : null,
      'new_user_zone': allProducts.isNotEmpty
          ? {
              'id': 1,
              'title': 'New User Zone',
              'background_color': '#4ECDC4',
              'slug': 'new-user-zone',
              'banner_image': null,
              'product_navigation_label': 'Shop Now',
              'category_navigation_label': 'Browse Categories',
              'coupon_navigation_label': 'Get Coupon',
              'product_slogan': 'Special offers for new users',
              'category_slogan': 'Explore our categories',
              'coupon_slogan': 'Save more with coupons',
              'coupon': {
                'id': 1,
                'title': 'Welcome Offer',
                'coupon_code': 'WELCOME10',
                'start_date': DateTime.now().toIso8601String(),
                'end_date': DateTime.now()
                    .add(Duration(days: 30))
                    .toIso8601String(),
                'discount': 10,
                'discount_type': 1,
                'minimum_shopping': 100,
                'maximum_discount': 50.0,
              },
              'AllProducts': allProducts
                  .take(6)
                  .map(
                    (product) => {
                      'id': product['id'],
                      'new_user_zone_id': 1,
                      'seller_product_id': product['id'],
                      'status': 1,
                      'created_at': DateTime.now().toIso8601String(),
                      'updated_at': DateTime.now().toIso8601String(),
                      'product': product,
                    },
                  )
                  .toList(),
            }
          : null,
      'meta': {
        'total': allProducts.length,
        'current_page': 1,
        'last_page': 1,
        'per_page': allProducts.length,
      },
    };
  }

  /// Convert SJFashionHub categories response to Amazy format
  static Map<String, dynamic> adaptCategories(Map<String, dynamic> response) {
    List<dynamic> categories = response['categories'] ?? [];

    return {
      'categories': categories
          .map(
            (category) => {
              'id': category['id'],
              'name': category['name'],
              'slug': category['slug'],
              'icon': category['image'],
              'banner': category['image'],
              'parent_id': category['parent_id'],
              'level': category['level'] ?? 0,
            },
          )
          .toList(),
    };
  }

  /// Convert SJFashionHub products response to Amazy AllRecommendedModel format
  static Map<String, dynamic> adaptProductsList(Map<String, dynamic> response) {
    List<dynamic> products = response['products'] ?? response['data'] ?? [];
    Map<String, dynamic> pagination =
        response['pagination'] ?? response['meta'] ?? {};

    List<Map<String, dynamic>> adaptedProducts = products
        .map((product) => adaptProduct(product))
        .toList();

    return {
      'data': adaptedProducts,
      'meta': {
        'current_page': pagination['current_page'] ?? 1,
        'from': pagination['from'] ?? 1,
        'last_page': pagination['last_page'] ?? 1,
        'path': pagination['path'] ?? '',
        'per_page': pagination['per_page'] ?? adaptedProducts.length,
        'to': pagination['to'] ?? adaptedProducts.length,
        'total': pagination['total'] ?? adaptedProducts.length,
      },
    };
  }

  /// Convert SJFashionHub wishlist response to Amazy format
  static Map<String, dynamic> adaptWishlist(dynamic response) {
    // Handle null response
    if (response == null) {
      return {'products': [], 'message': 'Wishlist is empty'};
    }

    // Handle different response types
    List<dynamic> wishlistItems = [];
    if (response is Map<String, dynamic>) {
      wishlistItems =
          response['wishlist_items'] ??
          response['wishlist'] ??
          response['products'] ??
          [];
    } else if (response is List) {
      wishlistItems = response;
    }

    return {
      'products': wishlistItems
          .map(
            (item) => {
              'id': item['id'] ?? 0,
              'product': adaptProduct(item['product'] ?? item),
              'created_at':
                  item['added_at'] ??
                  item['created_at'] ??
                  DateTime.now().toIso8601String(),
            },
          )
          .toList(),
      'message': 'Wishlist loaded successfully',
    };
  }

  /// Convert SJFashionHub orders response to Amazy format
  static Map<String, dynamic> adaptOrders(Map<String, dynamic> response) {
    List<dynamic> orders = response['orders'] ?? [];

    return {
      'orders': orders
          .map(
            (order) => {
              'id': order['id'],
              'order_number': order['order_number'],
              'status': order['status'],
              'total_amount': order['total_amount'],
              'created_at': order['created_at'],
              'items': order['items'] ?? [],
            },
          )
          .toList(),
    };
  }
}
