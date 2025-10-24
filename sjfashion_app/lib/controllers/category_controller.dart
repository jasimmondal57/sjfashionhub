import 'package:get/get.dart';
import '../models/category_model.dart';
import '../services/api_service.dart';

class CategoryController extends GetxController {
  final ApiService _apiService = ApiService();

  final RxBool isLoading = false.obs;
  final RxList<Category> categories = <Category>[].obs;
  final RxList<Category> featuredCategories = <Category>[].obs;

  @override
  void onInit() {
    super.onInit();
    loadCategories();
  }

  Future<void> loadCategories() async {
    try {
      isLoading.value = true;

      final response = await _apiService.get('/categories');
      if (response['categories'] != null) {
        categories.value = List<Category>.from(
          response['categories'].map((category) => Category.fromJson(category)),
        );
      }
    } catch (e) {
      print('Error loading categories: $e');
    } finally {
      isLoading.value = false;
    }
  }

  Future<void> loadFeaturedCategories() async {
    try {
      final response = await _apiService.get('/featured-categories');
      if (response['success'] == true && response['data'] != null) {
        featuredCategories.value = List<Category>.from(
          response['data'].map((category) => Category.fromJson(category)),
        );
      }
    } catch (e) {
      print('Error loading featured categories: $e');
    }
  }

  void _loadMockCategories() {
    categories.value = [
      Category(
        id: '1',
        name: 'Women\'s Fashion',
        slug: 'womens-fashion',
        description: 'Latest trends in women\'s clothing and accessories',
        image: 'https://via.placeholder.com/200x200/FF3364/FFFFFF?text=Women',
        productCount: 125,
      ),
      Category(
        id: '2',
        name: 'Men\'s Fashion',
        slug: 'mens-fashion',
        description: 'Stylish clothing and accessories for men',
        image: 'https://via.placeholder.com/200x200/D7365C/FFFFFF?text=Men',
        productCount: 98,
      ),
      Category(
        id: '3',
        name: 'Shoes',
        slug: 'shoes',
        description: 'Comfortable and fashionable footwear',
        image: 'https://via.placeholder.com/200x200/FF3566/FFFFFF?text=Shoes',
        productCount: 67,
      ),
      Category(
        id: '4',
        name: 'Accessories',
        slug: 'accessories',
        description: 'Complete your look with our accessories',
        image: 'https://via.placeholder.com/200x200/A100AF/FFFFFF?text=Access',
        productCount: 45,
      ),
      Category(
        id: '5',
        name: 'Bags',
        slug: 'bags',
        description: 'Stylish bags for every occasion',
        image: 'https://via.placeholder.com/200x200/5580D3/FFFFFF?text=Bags',
        productCount: 32,
      ),
      Category(
        id: '6',
        name: 'Jewelry',
        slug: 'jewelry',
        description: 'Beautiful jewelry to enhance your style',
        image: 'https://via.placeholder.com/200x200/D35DDD/FFFFFF?text=Jewelry',
        productCount: 28,
      ),
    ];
  }

  Future<void> refresh() async {
    await loadCategories();
  }

  Category? getCategoryById(String id) {
    return categories.firstWhereOrNull((category) => category.id == id);
  }

  List<Category> searchCategories(String query) {
    if (query.isEmpty) return categories;

    return categories
        .where(
          (category) =>
              category.name.toLowerCase().contains(query.toLowerCase()) ||
              (category.description?.toLowerCase().contains(
                    query.toLowerCase(),
                  ) ??
                  false),
        )
        .toList();
  }
}
