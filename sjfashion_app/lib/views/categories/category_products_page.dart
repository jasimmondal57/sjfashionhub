import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import '../../config/app_config.dart';
import '../../models/category_model.dart';
import '../../models/product_model.dart';
import '../../services/api_service.dart';
import '../../widgets/product_card.dart';
import '../../widgets/loading_shimmer.dart';

class CategoryProductsPage extends StatefulWidget {
  const CategoryProductsPage({super.key});

  @override
  State<CategoryProductsPage> createState() => _CategoryProductsPageState();
}

class _CategoryProductsPageState extends State<CategoryProductsPage> {
  final ApiService _apiService = ApiService();
  final RxBool isLoading = false.obs;
  final RxList<Product> products = <Product>[].obs;

  Category? category;

  @override
  void initState() {
    super.initState();
    category = Get.arguments as Category?;
    if (category != null) {
      loadCategoryProducts();
    }
  }

  Future<void> loadCategoryProducts() async {
    try {
      isLoading.value = true;

      // Call API with category parameter to get filtered products
      final response = await _apiService.get(
        '/products?category=${category!.id}',
      );

      List<Product> categoryProducts = [];
      if (response['products'] != null) {
        categoryProducts = List<Product>.from(
          response['products'].map((product) => Product.fromJson(product)),
        );
      } else if (response['data'] != null) {
        categoryProducts = List<Product>.from(
          response['data'].map((product) => Product.fromJson(product)),
        );
      }

      products.value = categoryProducts;

      print(
        '✅ Loaded ${products.length} products for category ${category!.name} (ID: ${category!.id})',
      );

      if (products.isEmpty) {
        print(
          '⚠️ No products found for category ${category!.name} (ID: ${category!.id})',
        );
      }
    } catch (e) {
      print('Error loading category products: $e');
      Get.snackbar(
        'Error',
        'Failed to load products for this category',
        snackPosition: SnackPosition.BOTTOM,
        backgroundColor: Colors.red,
        colorText: Colors.white,
      );
    } finally {
      isLoading.value = false;
    }
  }

  @override
  Widget build(BuildContext context) {
    if (category == null) {
      return Scaffold(
        appBar: AppBar(title: const Text('Category Products')),
        body: const Center(child: Text('Category not found')),
      );
    }

    return Scaffold(
      backgroundColor: AppConfig.backgroundColor,
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back, color: Colors.black),
          onPressed: () => Get.back(),
        ),
        title: Text(
          category!.name,
          style: TextStyle(
            color: Colors.black,
            fontSize: 18.sp,
            fontWeight: FontWeight.w600,
          ),
        ),
      ),
      body: RefreshIndicator(
        onRefresh: loadCategoryProducts,
        child: Obx(() {
          if (isLoading.value && products.isEmpty) {
            return _buildLoadingGrid();
          }

          if (products.isEmpty) {
            return _buildEmptyState();
          }

          return _buildProductsGrid();
        }),
      ),
    );
  }

  Widget _buildLoadingGrid() {
    return Padding(
      padding: EdgeInsets.all(16.w),
      child: GridView.builder(
        gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
          crossAxisCount: 2,
          childAspectRatio: 0.7,
          crossAxisSpacing: 12.w,
          mainAxisSpacing: 16.h,
        ),
        itemCount: 6,
        itemBuilder: (context, index) {
          return Container(
            decoration: BoxDecoration(
              color: Colors.grey[300],
              borderRadius: BorderRadius.circular(12),
            ),
          );
        },
      ),
    );
  }

  Widget _buildEmptyState() {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(
            Icons.shopping_bag_outlined,
            size: 64.sp,
            color: Colors.grey.shade400,
          ),
          SizedBox(height: 16.h),
          Text(
            'No Products Found',
            style: TextStyle(
              fontSize: 18.sp,
              fontWeight: FontWeight.w600,
              color: Colors.grey.shade600,
            ),
          ),
          SizedBox(height: 8.h),
          Text(
            'No products available in ${category!.name} category',
            style: TextStyle(fontSize: 14.sp, color: Colors.grey.shade500),
            textAlign: TextAlign.center,
          ),
          SizedBox(height: 24.h),
          ElevatedButton(
            onPressed: loadCategoryProducts,
            style: ElevatedButton.styleFrom(
              backgroundColor: AppConfig.primaryColor,
              foregroundColor: Colors.white,
              padding: EdgeInsets.symmetric(horizontal: 24.w, vertical: 12.h),
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(8.r),
              ),
            ),
            child: Text(
              'Refresh',
              style: TextStyle(fontSize: 14.sp, fontWeight: FontWeight.w600),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildProductsGrid() {
    return Padding(
      padding: EdgeInsets.all(16.w),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Category info
          Container(
            width: double.infinity,
            padding: EdgeInsets.all(16.w),
            decoration: BoxDecoration(
              color: Colors.white,
              borderRadius: BorderRadius.circular(12.r),
              boxShadow: [
                BoxShadow(
                  color: AppConfig.shadowColor,
                  blurRadius: 8,
                  offset: const Offset(0, 2),
                ),
              ],
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  category!.name,
                  style: TextStyle(
                    fontSize: 18.sp,
                    fontWeight: FontWeight.w600,
                    color: AppConfig.textPrimary,
                  ),
                ),
                if (category!.description != null) ...[
                  SizedBox(height: 8.h),
                  Text(
                    category!.description!,
                    style: TextStyle(
                      fontSize: 14.sp,
                      color: AppConfig.textSecondary,
                    ),
                    maxLines: 3,
                    overflow: TextOverflow.ellipsis,
                  ),
                ],
                SizedBox(height: 8.h),
                Text(
                  '${products.length} products found',
                  style: TextStyle(
                    fontSize: 12.sp,
                    color: AppConfig.primaryColor,
                    fontWeight: FontWeight.w500,
                  ),
                ),
              ],
            ),
          ),

          SizedBox(height: 16.h),

          // Products grid
          Expanded(
            child: GridView.builder(
              gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: 2,
                childAspectRatio: 0.7,
                crossAxisSpacing: 12.w,
                mainAxisSpacing: 16.h,
              ),
              itemCount: products.length,
              itemBuilder: (context, index) {
                final product = products[index];
                return ProductCard(product: product);
              },
            ),
          ),
        ],
      ),
    );
  }
}
