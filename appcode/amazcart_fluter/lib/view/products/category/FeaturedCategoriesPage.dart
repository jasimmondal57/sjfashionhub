import 'package:amazcart/utils/styles.dart';
import 'package:amazcart/widgets/AppBarWidget.dart';
import 'package:amazcart/view/products/category/ProductsByCategory.dart';
import 'package:fancy_shimmer_image/fancy_shimmer_image.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';

class FeaturedCategoriesPage extends StatefulWidget {
  @override
  State<FeaturedCategoriesPage> createState() => _FeaturedCategoriesPageState();
}

class _FeaturedCategoriesPageState extends State<FeaturedCategoriesPage> {
  // Featured categories from mobile admin panel
  final List<Map<String, dynamic>> featuredCategories = [
    {
      'id': 22,
      'name': '2 Pcs Set',
      'slug': '2-pcs-set',
      'image': null,
      'products_count': 4,
    },
    {
      'id': 23,
      'name': '3 Pcs Set',
      'slug': '3-pcs-set',
      'image': null,
      'products_count': 23,
    },
    {
      'id': 24,
      'name': 'Blouse',
      'slug': 'blouse',
      'image': null,
      'products_count': 9,
    },
    {
      'id': 31,
      'name': 'Kurti',
      'slug': 'kurti',
      'image': null,
      'products_count': 3,
    },
    {
      'id': 33,
      'name': 'Nayara 3 Pcs Set',
      'slug': 'nayara-3-pcs-set',
      'image': null,
      'products_count': 8,
    },
    {
      'id': 25,
      'name': 'Capsule 2 Pcs Set',
      'slug': 'capsule-2-pcs-set',
      'image': null,
      'products_count': 8,
    },
    {
      'id': 26,
      'name': 'Capsule 3 Pcs Set',
      'slug': 'capsule-3-pcs-set',
      'image': null,
      'products_count': 16,
    },
    {
      'id': 21,
      'name': 'Uncategorized',
      'slug': 'uncategorized',
      'image': null,
      'products_count': 1,
    },
  ];

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppStyles.appBackgroundColor,
      appBar: AppBarWidget(title: "Shop by Category"),
      body: Padding(
        padding: EdgeInsets.all(16.w),
        child: GridView.builder(
          gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
            crossAxisCount: 2,
            crossAxisSpacing: 16.w,
            mainAxisSpacing: 16.h,
            childAspectRatio: 0.85,
          ),
          itemCount: featuredCategories.length,
          itemBuilder: (context, index) {
            final category = featuredCategories[index];
            return _buildCategoryCard(category);
          },
        ),
      ),
    );
  }

  Widget _buildCategoryCard(Map<String, dynamic> category) {
    return GestureDetector(
      onTap: () => _handleCategoryTap(category),
      child: Container(
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(16.r),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withOpacity(0.1),
              spreadRadius: 1,
              blurRadius: 8,
              offset: Offset(0, 4),
            ),
          ],
        ),
        child: ClipRRect(
          borderRadius: BorderRadius.circular(16.r),
          child: Stack(
            children: [
              // Category image placeholder
              Container(
                color: Colors.grey[300],
                child: Center(
                  child: Icon(
                    Icons.category,
                    color: Colors.grey[600],
                    size: 50,
                  ),
                ),
              ),
              // Gradient overlay
              Container(
                decoration: BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.topCenter,
                    end: Alignment.bottomCenter,
                    colors: [Colors.transparent, Colors.black.withOpacity(0.7)],
                  ),
                ),
              ),
              // Category info
              Positioned(
                bottom: 12.h,
                left: 12.w,
                right: 12.w,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      category['name'] as String,
                      style: AppStyles.appFont.copyWith(
                        fontSize: 16.sp,
                        fontWeight: FontWeight.bold,
                        color: Colors.white,
                      ),
                      maxLines: 2,
                      overflow: TextOverflow.ellipsis,
                    ),
                    SizedBox(height: 4.h),
                    Text(
                      '${category['products_count']} Products',
                      style: AppStyles.appFont.copyWith(
                        fontSize: 12.sp,
                        fontWeight: FontWeight.w400,
                        color: Colors.white.withOpacity(0.9),
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  void _handleCategoryTap(Map<String, dynamic> category) {
    final categoryId = category['id'] as int;
    Get.to(() => ProductsByCategory(categoryId: categoryId));
  }
}
