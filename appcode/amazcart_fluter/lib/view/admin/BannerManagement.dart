import 'package:amazcart/AppConfig/app_config.dart';
import 'package:amazcart/controller/admin/banner_controller.dart';
import 'package:amazcart/model/admin/BannerModel.dart';
import 'package:amazcart/utils/styles.dart';
import 'package:amazcart/view/admin/AddEditBanner.dart';
import 'package:fancy_shimmer_image/fancy_shimmer_image.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';
import 'package:loading_skeleton_niu/loading_skeleton.dart';

class BannerManagement extends StatefulWidget {
  @override
  _BannerManagementState createState() => _BannerManagementState();
}

class _BannerManagementState extends State<BannerManagement> {
  final BannerController bannerController = Get.put(BannerController());

  @override
  void initState() {
    super.initState();
    bannerController.getBanners();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppStyles.appBackgroundColor,
      appBar: AppBar(
        backgroundColor: AppStyles.pinkColor,
        title: Text(
          'Banner Management',
          style: AppStyles.appFont.copyWith(
            color: Colors.white,
            fontSize: 18.sp,
            fontWeight: FontWeight.bold,
          ),
        ),
        actions: [
          IconButton(
            onPressed: () {
              Get.to(() => AddEditBanner())?.then((value) {
                if (value == true) {
                  bannerController.getBanners();
                }
              });
            },
            icon: Icon(Icons.add, color: Colors.white),
          ),
        ],
      ),
      body: Obx(() {
        if (bannerController.isLoading.value) {
          return _buildLoadingSkeleton();
        }

        if (bannerController.banners.isEmpty) {
          return _buildEmptyState();
        }

        return RefreshIndicator(
          onRefresh: () async {
            await bannerController.getBanners();
          },
          child: ListView.builder(
            padding: EdgeInsets.all(16.w),
            itemCount: bannerController.banners.length,
            itemBuilder: (context, index) {
              final banner = bannerController.banners[index];
              return _buildBannerCard(banner, index);
            },
          ),
        );
      }),
    );
  }

  Widget _buildLoadingSkeleton() {
    return ListView.builder(
      padding: EdgeInsets.all(16.w),
      itemCount: 5,
      itemBuilder: (context, index) {
        return Container(
          margin: EdgeInsets.only(bottom: 16.h),
          child: LoadingSkeleton(
            height: 120.h,
            width: Get.width,
            colors: [
              Colors.black.withOpacity(0.1),
              Colors.black.withOpacity(0.2),
            ],
          ),
        );
      },
    );
  }

  Widget _buildEmptyState() {
    return Center(
      child: Column(
        mainAxisAlignment: MainAxisAlignment.center,
        children: [
          Icon(
            Icons.image_not_supported,
            size: 64.w,
            color: Colors.grey,
          ),
          SizedBox(height: 16.h),
          Text(
            'No banners found',
            style: AppStyles.appFont.copyWith(
              fontSize: 18.sp,
              color: Colors.grey,
            ),
          ),
          SizedBox(height: 8.h),
          Text(
            'Tap the + button to add your first banner',
            style: AppStyles.appFont.copyWith(
              fontSize: 14.sp,
              color: Colors.grey,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildBannerCard(BannerModel banner, int index) {
    return Container(
      margin: EdgeInsets.only(bottom: 16.h),
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(12.r),
        boxShadow: [
          BoxShadow(
            color: Colors.grey.withOpacity(0.1),
            spreadRadius: 1,
            blurRadius: 5,
            offset: Offset(0, 2),
          ),
        ],
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Banner Image
          ClipRRect(
            borderRadius: BorderRadius.only(
              topLeft: Radius.circular(12.r),
              topRight: Radius.circular(12.r),
            ),
            child: AspectRatio(
              aspectRatio: 16 / 6,
              child: FancyShimmerImage(
                imageUrl: banner.image ?? '',
                boxFit: BoxFit.cover,
                width: Get.width,
                errorWidget: Container(
                  color: Colors.grey[200],
                  child: Icon(
                    Icons.image_not_supported,
                    size: 32.w,
                    color: Colors.grey,
                  ),
                ),
              ),
            ),
          ),
          
          // Banner Details
          Padding(
            padding: EdgeInsets.all(16.w),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  children: [
                    Expanded(
                      child: Text(
                        banner.title ?? 'Untitled Banner',
                        style: AppStyles.appFont.copyWith(
                          fontSize: 16.sp,
                          fontWeight: FontWeight.bold,
                          color: AppStyles.blackColor,
                        ),
                      ),
                    ),
                    Container(
                      padding: EdgeInsets.symmetric(horizontal: 8.w, vertical: 4.h),
                      decoration: BoxDecoration(
                        color: banner.isActive == true ? Colors.green : Colors.red,
                        borderRadius: BorderRadius.circular(12.r),
                      ),
                      child: Text(
                        banner.isActive == true ? 'Active' : 'Inactive',
                        style: AppStyles.appFont.copyWith(
                          fontSize: 12.sp,
                          color: Colors.white,
                          fontWeight: FontWeight.w500,
                        ),
                      ),
                    ),
                  ],
                ),
                
                if (banner.link != null && banner.link!.isNotEmpty) ...[
                  SizedBox(height: 8.h),
                  Text(
                    'Link: ${banner.link}',
                    style: AppStyles.appFont.copyWith(
                      fontSize: 12.sp,
                      color: Colors.blue,
                    ),
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                ],
                
                SizedBox(height: 12.h),
                Row(
                  children: [
                    Text(
                      'Sort Order: ${banner.sortOrder ?? 0}',
                      style: AppStyles.appFont.copyWith(
                        fontSize: 12.sp,
                        color: Colors.grey[600],
                      ),
                    ),
                    Spacer(),
                    IconButton(
                      onPressed: () {
                        Get.to(() => AddEditBanner(banner: banner))?.then((value) {
                          if (value == true) {
                            bannerController.getBanners();
                          }
                        });
                      },
                      icon: Icon(Icons.edit, color: Colors.blue, size: 20.w),
                    ),
                    IconButton(
                      onPressed: () {
                        _showDeleteDialog(banner);
                      },
                      icon: Icon(Icons.delete, color: Colors.red, size: 20.w),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  void _showDeleteDialog(BannerModel banner) {
    Get.dialog(
      AlertDialog(
        title: Text('Delete Banner'),
        content: Text('Are you sure you want to delete this banner?'),
        actions: [
          TextButton(
            onPressed: () => Get.back(),
            child: Text('Cancel'),
          ),
          TextButton(
            onPressed: () {
              Get.back();
              bannerController.deleteBanner(banner.id!);
            },
            child: Text('Delete', style: TextStyle(color: Colors.red)),
          ),
        ],
      ),
    );
  }
}
