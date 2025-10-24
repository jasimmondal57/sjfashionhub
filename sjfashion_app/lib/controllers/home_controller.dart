import 'package:get/get.dart';
import '../models/product_model.dart';
import '../models/category_model.dart';
import '../models/banner_model.dart';
import '../models/home_section_model.dart';
import '../services/api_service.dart';

class HomeController extends GetxController {
  final ApiService _apiService = ApiService();

  final RxBool isLoading = false.obs;
  final Rx<HomeData?> homeData = Rx<HomeData?>(null);
  final RxList<Banner> banners = <Banner>[].obs;
  final RxList<Category> featuredCategories = <Category>[].obs;
  final RxList<Product> featuredProducts = <Product>[].obs;
  final RxList<Product> newArrivals = <Product>[].obs;
  final RxList<Product> bestSellers = <Product>[].obs;
  final RxList<HomeSection> bodySections = <HomeSection>[].obs;

  @override
  void onInit() {
    super.onInit();
    loadHomeData();
  }

  Future<void> loadHomeData() async {
    isLoading.value = true;
    try {
      // Load banners separately since /home endpoint has image_url: null
      await loadBanners();

      // Use the comprehensive home API endpoint for other sections
      final response = await _apiService.get('/home');

      if (response['sections'] != null) {
        homeData.value = HomeData.fromJson(response);
        _parseHomeData();
      }
    } catch (e) {
      print('Error loading home data: $e');
    } finally {
      isLoading.value = false;
    }
  }

  Future<void> loadBanners() async {
    try {
      final response = await _apiService.get('/banners');
      if (response['success'] == true && response['data'] != null) {
        banners.value = List<Banner>.from(
          response['data'].map((banner) => Banner.fromJson(banner)),
        );
      }
    } catch (e) {
      print('Error loading banners: $e');
    }
  }

  void _parseHomeData() {
    if (homeData.value == null) return;

    final data = homeData.value!;

    // Skip banners - we load them separately since /home endpoint has image_url: null
    // final bannerSection = data.bannerSection;
    // if (bannerSection != null) {
    //   banners.value = bannerSection.banners;
    // }

    // Extract featured categories
    final categoriesSection = data.featuredCategoriesSection;
    if (categoriesSection != null) {
      featuredCategories.value = categoriesSection.categories;
    }

    // Extract featured products
    final featuredSection = data.featuredProductsSection;
    if (featuredSection != null) {
      featuredProducts.value = featuredSection.products;
    }

    // Extract new arrivals
    final newArrivalsSection = data.newArrivalsSection;
    if (newArrivalsSection != null) {
      newArrivals.value = newArrivalsSection.products;
    }

    // Extract best sellers
    final bestSellersSection = data.bestSellersSection;
    if (bestSellersSection != null) {
      bestSellers.value = bestSellersSection.products;
    }

    // Extract body sections (dynamic sections from mobile admin)
    bodySections.value = data.sections
        .where(
          (section) =>
              section.type == 'body' ||
              section.type == 'product_grid' ||
              section.type == 'product_carousel' ||
              section.type == 'category_products',
        )
        .toList();
  }

  Future<void> refresh() async {
    await loadHomeData();
  }
}
