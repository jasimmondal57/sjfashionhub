import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:get/get.dart';

import '../config/app_config.dart';
import '../models/category_model.dart';
import '../views/categories/category_products_page.dart';

class CategoryCard extends StatelessWidget {
  final Category category;
  final VoidCallback? onTap;

  const CategoryCard({super.key, required this.category, this.onTap});

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap:
          onTap ??
          () {
            Get.to(() => const CategoryProductsPage(), arguments: category);
          },
      child: Container(
        width: 80.w,
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            // Category Image
            Container(
              width: 70.w,
              height: 70.h,
              decoration: BoxDecoration(
                color: Colors.white,
                shape: BoxShape.circle,
                boxShadow: [
                  BoxShadow(
                    color: AppConfig.shadowColor,
                    blurRadius: 8,
                    offset: const Offset(0, 2),
                  ),
                ],
              ),
              child: ClipOval(
                child: category.image != null
                    ? CachedNetworkImage(
                        imageUrl: category.image!,
                        fit: BoxFit.cover,
                        placeholder: (context, url) => Container(
                          color: AppConfig.surfaceColor,
                          child: const Center(
                            child: CircularProgressIndicator(),
                          ),
                        ),
                        errorWidget: (context, url, error) => Container(
                          color: AppConfig.surfaceColor,
                          child: Icon(
                            Icons.category,
                            color: AppConfig.primaryColor,
                            size: 30.sp,
                          ),
                        ),
                      )
                    : Container(
                        color: AppConfig.surfaceColor,
                        child: Icon(
                          Icons.category,
                          color: AppConfig.primaryColor,
                          size: 30.sp,
                        ),
                      ),
              ),
            ),

            SizedBox(height: 4.h),

            // Category Name
            Text(
              category.name,
              style: TextStyle(
                fontSize: 10.sp,
                fontWeight: FontWeight.w500,
                color: AppConfig.textPrimary,
              ),
              textAlign: TextAlign.center,
              maxLines: 1,
              overflow: TextOverflow.ellipsis,
            ),
          ],
        ),
      ),
    );
  }
}
