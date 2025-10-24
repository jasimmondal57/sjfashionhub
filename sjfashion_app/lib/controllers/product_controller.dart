import 'package:get/get.dart';
import '../models/product_model.dart';
import '../services/api_service.dart';

class ProductController extends GetxController {
  final ApiService _apiService = ApiService();
  
  final RxBool isLoading = false.obs;
  final RxList<Product> products = <Product>[].obs;
  final RxList<Product> featuredProducts = <Product>[].obs;
  final RxList<Product> searchResults = <Product>[].obs;
  final RxString searchQuery = ''.obs;
  final RxString selectedCategory = ''.obs;
  final RxString sortBy = 'name'.obs; // name, price_low, price_high, rating
  
  @override
  void onInit() {
    super.onInit();
    loadProducts();
  }
  
  Future<void> loadProducts({String? categoryId}) async {
    try {
      isLoading.value = true;
      
      String endpoint = '/products';
      if (categoryId != null) {
        endpoint += '?category_id=$categoryId';
      }
      
      final response = await _apiService.get(endpoint);
      if (response['success'] == true && response['data'] != null) {
        products.value = List<Product>.from(
          response['data'].map((product) => Product.fromJson(product)),
        );
      }
      
    } catch (e) {
      print('Error loading products: $e');
      // Load mock products for demo
      _loadMockProducts();
    } finally {
      isLoading.value = false;
    }
  }
  
  Future<void> loadFeaturedProducts() async {
    try {
      final response = await _apiService.get('/products/featured');
      if (response['success'] == true && response['data'] != null) {
        featuredProducts.value = List<Product>.from(
          response['data'].map((product) => Product.fromJson(product)),
        );
      }
    } catch (e) {
      print('Error loading featured products: $e');
    }
  }
  
  Future<Product?> getProductById(String id) async {
    try {
      final response = await _apiService.get('/products/$id');
      if (response['success'] == true && response['data'] != null) {
        return Product.fromJson(response['data']);
      }
    } catch (e) {
      print('Error loading product: $e');
    }
    return null;
  }
  
  void searchProducts(String query) {
    searchQuery.value = query;
    
    if (query.isEmpty) {
      searchResults.clear();
      return;
    }
    
    searchResults.value = products.where((product) =>
      product.name.toLowerCase().contains(query.toLowerCase()) ||
      product.description.toLowerCase().contains(query.toLowerCase()) ||
      (product.categoryName?.toLowerCase().contains(query.toLowerCase()) ?? false)
    ).toList();
    
    _applySorting(searchResults);
  }
  
  void filterByCategory(String categoryId) {
    selectedCategory.value = categoryId;
    loadProducts(categoryId: categoryId.isEmpty ? null : categoryId);
  }
  
  void setSortBy(String sort) {
    sortBy.value = sort;
    _applySorting(products);
    if (searchResults.isNotEmpty) {
      _applySorting(searchResults);
    }
  }
  
  void _applySorting(RxList<Product> productList) {
    switch (sortBy.value) {
      case 'price_low':
        productList.sort((a, b) => a.finalPrice.compareTo(b.finalPrice));
        break;
      case 'price_high':
        productList.sort((a, b) => b.finalPrice.compareTo(a.finalPrice));
        break;
      case 'rating':
        productList.sort((a, b) => b.rating.compareTo(a.rating));
        break;
      case 'name':
      default:
        productList.sort((a, b) => a.name.compareTo(b.name));
        break;
    }
  }
  
  void _loadMockProducts() {
    products.value = [
      Product(
        id: '1',
        name: 'Elegant Evening Dress',
        slug: 'elegant-evening-dress',
        description: 'Beautiful evening dress perfect for special occasions. Made with high-quality fabric and attention to detail.',
        price: 129.99,
        salePrice: 99.99,
        image: 'https://via.placeholder.com/300x400/FF3364/FFFFFF?text=Dress+1',
        images: [
          'https://via.placeholder.com/300x400/FF3364/FFFFFF?text=Dress+1',
          'https://via.placeholder.com/300x400/D7365C/FFFFFF?text=Dress+1-2',
        ],
        rating: 4.8,
        categoryName: 'Women\'s Fashion',
        categoryId: '1',
        stock: 15,
      ),
      Product(
        id: '2',
        name: 'Classic Men\'s Blazer',
        slug: 'classic-mens-blazer',
        description: 'Sophisticated blazer for the modern gentleman. Perfect for business meetings and formal events.',
        price: 199.99,
        image: 'https://via.placeholder.com/300x400/D7365C/FFFFFF?text=Blazer',
        images: [
          'https://via.placeholder.com/300x400/D7365C/FFFFFF?text=Blazer',
          'https://via.placeholder.com/300x400/FF3566/FFFFFF?text=Blazer-2',
        ],
        rating: 4.6,
        categoryName: 'Men\'s Fashion',
        categoryId: '2',
        stock: 8,
      ),
      Product(
        id: '3',
        name: 'Comfortable Running Shoes',
        slug: 'comfortable-running-shoes',
        description: 'High-performance running shoes with excellent cushioning and support for your daily runs.',
        price: 89.99,
        salePrice: 69.99,
        image: 'https://via.placeholder.com/300x400/FF3566/FFFFFF?text=Shoes',
        images: [
          'https://via.placeholder.com/300x400/FF3566/FFFFFF?text=Shoes',
          'https://via.placeholder.com/300x400/A100AF/FFFFFF?text=Shoes-2',
        ],
        rating: 4.4,
        categoryName: 'Shoes',
        categoryId: '3',
        stock: 25,
      ),
      Product(
        id: '4',
        name: 'Stylish Handbag',
        slug: 'stylish-handbag',
        description: 'Trendy handbag that complements any outfit. Spacious interior with multiple compartments.',
        price: 79.99,
        image: 'https://via.placeholder.com/300x400/A100AF/FFFFFF?text=Handbag',
        images: [
          'https://via.placeholder.com/300x400/A100AF/FFFFFF?text=Handbag',
          'https://via.placeholder.com/300x400/5580D3/FFFFFF?text=Handbag-2',
        ],
        rating: 4.7,
        categoryName: 'Accessories',
        categoryId: '4',
        stock: 12,
      ),
    ];
    
    featuredProducts.value = products.take(2).toList();
  }
  
  Future<void> refresh() async {
    await loadProducts();
  }
}
