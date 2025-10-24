import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:flutter_swiper_view/flutter_swiper_view.dart';
import 'package:cached_network_image/cached_network_image.dart';

import '../../config/app_config.dart';
import '../../controllers/home_controller.dart';
import '../../models/home_section_model.dart';
import '../../widgets/product_card.dart';
import '../../widgets/category_card.dart';
import '../../widgets/section_header.dart';
import '../../widgets/loading_shimmer.dart';
import '../categories/all_categories_page.dart';

class HomePage extends StatelessWidget {
  const HomePage({super.key});

  @override
  Widget build(BuildContext context) {
    final HomeController controller = Get.find<HomeController>();

    return Scaffold(
      backgroundColor: AppConfig.backgroundColor,
      body: SafeArea(
        child: RefreshIndicator(
          onRefresh: controller.refresh,
          color: AppConfig.primaryColor,
          child: CustomScrollView(
            slivers: [
              // App Bar
              SliverAppBar(
                floating: true,
                backgroundColor: Colors.white,
                elevation: 0,
                title: Text(
                  AppConfig.appName,
                  style: TextStyle(
                    color: AppConfig.textPrimary,
                    fontSize: 20.sp,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                actions: [
                  IconButton(
                    icon: Icon(
                      Icons.search,
                      color: AppConfig.textPrimary,
                      size: 24.sp,
                    ),
                    onPressed: () {
                      // TODO: Navigate to search page
                    },
                  ),
                  IconButton(
                    icon: Icon(
                      Icons.notifications_outlined,
                      color: AppConfig.textPrimary,
                      size: 24.sp,
                    ),
                    onPressed: () {
                      // TODO: Navigate to notifications
                    },
                  ),
                ],
              ),

              // Content
              SliverToBoxAdapter(
                child: Obx(() {
                  if (controller.isLoading.value) {
                    return const LoadingShimmer();
                  }

                  return Column(
                    children: [
                      // Banner Section
                      _buildBannerSection(controller),

                      SizedBox(height: 20.h),

                      // Featured Categories
                      _buildFeaturedCategories(controller),

                      SizedBox(height: 20.h),

                      // Dynamic Body Sections from Mobile Admin
                      _buildBodySections(controller),

                      // Fallback sections if no body sections are configured
                      if (controller.bodySections.isEmpty) ...[
                        // Featured Products
                        _buildFeaturedProducts(controller),

                        SizedBox(height: 20.h),

                        // New Arrivals
                        _buildNewArrivals(controller),

                        SizedBox(height: 20.h),

                        // Best Sellers
                        _buildBestSellers(controller),
                      ],

                      SizedBox(height: 20.h),
                    ],
                  );
                }),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildBannerSection(HomeController controller) {
    if (controller.banners.isEmpty) {
      return const SizedBox.shrink();
    }

    return Container(
      height: 180.h,
      margin: EdgeInsets.symmetric(horizontal: 16.w),
      child: Swiper(
        itemBuilder: (context, index) {
          return Container(
            decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(AppConfig.defaultRadius),
              boxShadow: [
                BoxShadow(
                  color: AppConfig.shadowColor,
                  blurRadius: 8,
                  offset: const Offset(0, 2),
                ),
              ],
            ),
            child: ClipRRect(
              borderRadius: BorderRadius.circular(AppConfig.defaultRadius),
              child: CachedNetworkImage(
                imageUrl: controller.banners[index].image ?? '',
                fit: BoxFit.cover,
                placeholder: (context, url) => Container(
                  color: AppConfig.surfaceColor,
                  child: const Center(child: CircularProgressIndicator()),
                ),
                errorWidget: (context, url, error) => Container(
                  color: AppConfig.surfaceColor,
                  child: const Icon(Icons.error),
                ),
              ),
            ),
          );
        },
        itemCount: controller.banners.length,
        pagination: const SwiperPagination(
          builder: DotSwiperPaginationBuilder(
            activeColor: AppConfig.primaryColor,
            color: AppConfig.borderColor,
          ),
        ),
        autoplay: true,
        autoplayDelay: 3000,
      ),
    );
  }

  Widget _buildFeaturedCategories(HomeController controller) {
    if (controller.featuredCategories.isEmpty) {
      return const SizedBox.shrink();
    }

    return Column(
      children: [
        SectionHeader(
          title: 'Shop by Category',
          onViewAll: () {
            Get.to(() => const AllCategoriesPage());
          },
        ),
        SizedBox(height: 12.h),
        SizedBox(
          height: 120.h,
          child: ListView.builder(
            scrollDirection: Axis.horizontal,
            padding: EdgeInsets.symmetric(horizontal: 16.w),
            itemCount: controller.featuredCategories.length,
            itemBuilder: (context, index) {
              final category = controller.featuredCategories[index];
              return Padding(
                padding: EdgeInsets.only(right: 12.w),
                child: CategoryCard(category: category),
              );
            },
          ),
        ),
      ],
    );
  }

  Widget _buildFeaturedProducts(HomeController controller) {
    if (controller.featuredProducts.isEmpty) {
      return const SizedBox.shrink();
    }

    return Column(
      children: [
        SectionHeader(
          title: 'Featured Products',
          onViewAll: () {
            // TODO: Navigate to products page
          },
        ),
        SizedBox(height: 12.h),
        SizedBox(
          height: 280.h,
          child: ListView.builder(
            scrollDirection: Axis.horizontal,
            padding: EdgeInsets.symmetric(horizontal: 16.w),
            itemCount: controller.featuredProducts.length,
            itemBuilder: (context, index) {
              final product = controller.featuredProducts[index];
              return Padding(
                padding: EdgeInsets.only(right: 12.w),
                child: SizedBox(
                  width: 160.w,
                  child: ProductCard(product: product),
                ),
              );
            },
          ),
        ),
      ],
    );
  }

  Widget _buildNewArrivals(HomeController controller) {
    if (controller.newArrivals.isEmpty) {
      return const SizedBox.shrink();
    }

    return Column(
      children: [
        SectionHeader(
          title: 'New Arrivals',
          onViewAll: () {
            // TODO: Navigate to new arrivals page
          },
        ),
        SizedBox(height: 12.h),
        SizedBox(
          height: 280.h,
          child: ListView.builder(
            scrollDirection: Axis.horizontal,
            padding: EdgeInsets.symmetric(horizontal: 16.w),
            itemCount: controller.newArrivals.length,
            itemBuilder: (context, index) {
              final product = controller.newArrivals[index];
              return Padding(
                padding: EdgeInsets.only(right: 12.w),
                child: SizedBox(
                  width: 160.w,
                  child: ProductCard(product: product),
                ),
              );
            },
          ),
        ),
      ],
    );
  }

  Widget _buildBestSellers(HomeController controller) {
    if (controller.bestSellers.isEmpty) {
      return const SizedBox.shrink();
    }

    return Column(
      children: [
        SectionHeader(
          title: 'Best Sellers',
          onViewAll: () {
            // TODO: Navigate to best sellers page
          },
        ),
        SizedBox(height: 12.h),
        SizedBox(
          height: 280.h,
          child: ListView.builder(
            scrollDirection: Axis.horizontal,
            padding: EdgeInsets.symmetric(horizontal: 16.w),
            itemCount: controller.bestSellers.length,
            itemBuilder: (context, index) {
              final product = controller.bestSellers[index];
              return Padding(
                padding: EdgeInsets.only(right: 12.w),
                child: SizedBox(
                  width: 160.w,
                  child: ProductCard(product: product),
                ),
              );
            },
          ),
        ),
      ],
    );
  }

  Widget _buildBodySections(HomeController controller) {
    if (controller.bodySections.isEmpty) {
      return const SizedBox.shrink();
    }

    return Column(
      children: controller.bodySections.map((section) {
        return Column(
          children: [
            _buildDynamicSection(section),
            SizedBox(height: 20.h),
          ],
        );
      }).toList(),
    );
  }

  Widget _buildDynamicSection(HomeSection section) {
    switch (section.type) {
      case 'body':
      case 'product_grid':
        return _buildProductGridSection(section);
      case 'product_carousel':
        return _buildProductCarouselSection(section);
      case 'category_products':
        return _buildCategoryProductsSection(section);
      default:
        return const SizedBox.shrink();
    }
  }

  Widget _buildProductGridSection(HomeSection section) {
    if (section.products.isEmpty) {
      return const SizedBox.shrink();
    }

    return Column(
      children: [
        SectionHeader(
          title: section.title,
          onViewAll: () {
            // TODO: Navigate to section products page
          },
        ),

        SizedBox(height: 16.h),

        Padding(
          padding: EdgeInsets.symmetric(horizontal: 16.w),
          child: GridView.builder(
            shrinkWrap: true,
            physics: const NeverScrollableScrollPhysics(),
            gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
              crossAxisCount: 2,
              childAspectRatio: 0.7,
              crossAxisSpacing: 12.w,
              mainAxisSpacing: 12.h,
            ),
            itemCount: section.products.length > 4
                ? 4
                : section.products.length,
            itemBuilder: (context, index) {
              return ProductCard(product: section.products[index]);
            },
          ),
        ),
      ],
    );
  }

  Widget _buildProductCarouselSection(HomeSection section) {
    if (section.products.isEmpty) {
      return const SizedBox.shrink();
    }

    return Column(
      children: [
        SectionHeader(
          title: section.title,
          onViewAll: () {
            // TODO: Navigate to section products page
          },
        ),

        SizedBox(height: 16.h),

        SizedBox(
          height: 280.h,
          child: ListView.builder(
            scrollDirection: Axis.horizontal,
            padding: EdgeInsets.symmetric(horizontal: 16.w),
            itemCount: section.products.length,
            itemBuilder: (context, index) {
              return Container(
                width: 160.w,
                margin: EdgeInsets.only(right: 12.w),
                child: ProductCard(product: section.products[index]),
              );
            },
          ),
        ),
      ],
    );
  }

  Widget _buildCategoryProductsSection(HomeSection section) {
    if (section.products.isEmpty) {
      return const SizedBox.shrink();
    }

    return Column(
      children: [
        SectionHeader(
          title: section.title,
          onViewAll: () {
            // TODO: Navigate to category products page
          },
        ),

        SizedBox(height: 16.h),

        SizedBox(
          height: 280.h,
          child: ListView.builder(
            scrollDirection: Axis.horizontal,
            padding: EdgeInsets.symmetric(horizontal: 16.w),
            itemCount: section.products.length,
            itemBuilder: (context, index) {
              return Container(
                width: 160.w,
                margin: EdgeInsets.only(right: 12.w),
                child: ProductCard(product: section.products[index]),
              );
            },
          ),
        ),
      ],
    );
  }
}
