import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:cached_network_image/cached_network_image.dart';
import 'package:flutter_rating_bar/flutter_rating_bar.dart';
import 'package:photo_view/photo_view.dart';
import 'package:photo_view/photo_view_gallery.dart';

import '../../config/app_config.dart';
import '../../models/product_model.dart';
import '../../controllers/cart_controller.dart';

class ProductDetailsPage extends StatefulWidget {
  final Product product;

  const ProductDetailsPage({super.key, required this.product});

  @override
  State<ProductDetailsPage> createState() => _ProductDetailsPageState();
}

class _ProductDetailsPageState extends State<ProductDetailsPage> {
  final CartController cartController = Get.find<CartController>();
  int selectedImageIndex = 0;
  int quantity = 1;

  @override
  Widget build(BuildContext context) {
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
          widget.product.name,
          style: TextStyle(
            color: Colors.black,
            fontSize: 18.sp,
            fontWeight: FontWeight.w600,
          ),
        ),
        actions: [
          IconButton(
            icon: const Icon(Icons.share, color: Colors.black),
            onPressed: () {
              // TODO: Implement share functionality
            },
          ),
          IconButton(
            icon: const Icon(Icons.favorite_border, color: Colors.black),
            onPressed: () {
              // TODO: Implement wishlist functionality
            },
          ),
        ],
      ),
      body: Column(
        children: [
          Expanded(
            child: SingleChildScrollView(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  // Product Images
                  _buildImageGallery(),

                  // Product Info
                  _buildProductInfo(),

                  // Product Description
                  _buildProductDescription(),

                  SizedBox(height: 100.h), // Space for bottom bar
                ],
              ),
            ),
          ),

          // Bottom Add to Cart Bar
          _buildBottomBar(),
        ],
      ),
    );
  }

  Widget _buildImageGallery() {
    List<String> images = widget.product.images.isNotEmpty
        ? widget.product.images
        : [widget.product.mainImage];

    return Container(
      height: 400.h,
      color: Colors.white,
      child: Column(
        children: [
          // Main Image
          Expanded(
            child: GestureDetector(
              onTap: () => _showImageGallery(images, selectedImageIndex),
              child: Container(
                width: double.infinity,
                padding: EdgeInsets.all(16.w),
                child: CachedNetworkImage(
                  imageUrl: images[selectedImageIndex],
                  fit: BoxFit.contain,
                  placeholder: (context, url) => Container(
                    color: AppConfig.surfaceColor,
                    child: const Center(child: CircularProgressIndicator()),
                  ),
                  errorWidget: (context, url, error) => Container(
                    color: AppConfig.surfaceColor,
                    child: const Icon(Icons.image_not_supported, size: 50),
                  ),
                ),
              ),
            ),
          ),

          // Image Thumbnails
          if (images.length > 1)
            Container(
              height: 80.h,
              padding: EdgeInsets.symmetric(horizontal: 16.w),
              child: ListView.builder(
                scrollDirection: Axis.horizontal,
                itemCount: images.length,
                itemBuilder: (context, index) {
                  return GestureDetector(
                    onTap: () => setState(() => selectedImageIndex = index),
                    child: Container(
                      width: 60.w,
                      height: 60.h,
                      margin: EdgeInsets.only(right: 8.w),
                      decoration: BoxDecoration(
                        border: Border.all(
                          color: selectedImageIndex == index
                              ? AppConfig.primaryColor
                              : Colors.grey.shade300,
                          width: 2,
                        ),
                        borderRadius: BorderRadius.circular(8.r),
                      ),
                      child: ClipRRect(
                        borderRadius: BorderRadius.circular(6.r),
                        child: CachedNetworkImage(
                          imageUrl: images[index],
                          fit: BoxFit.cover,
                          placeholder: (context, url) => Container(
                            color: AppConfig.surfaceColor,
                            child: const Center(
                              child: CircularProgressIndicator(strokeWidth: 2),
                            ),
                          ),
                          errorWidget: (context, url, error) => Container(
                            color: AppConfig.surfaceColor,
                            child: const Icon(
                              Icons.image_not_supported,
                              size: 20,
                            ),
                          ),
                        ),
                      ),
                    ),
                  );
                },
              ),
            ),

          SizedBox(height: 16.h),
        ],
      ),
    );
  }

  Widget _buildProductInfo() {
    return Container(
      width: double.infinity,
      color: Colors.white,
      padding: EdgeInsets.all(16.w),
      margin: EdgeInsets.only(top: 8.h),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Product Name
          Text(
            widget.product.name,
            style: TextStyle(
              fontSize: 20.sp,
              fontWeight: FontWeight.w600,
              color: Colors.black,
            ),
          ),

          SizedBox(height: 8.h),

          // Category
          if (widget.product.categoryName?.isNotEmpty == true)
            Text(
              widget.product.categoryName!,
              style: TextStyle(fontSize: 14.sp, color: Colors.grey.shade600),
            ),

          SizedBox(height: 12.h),

          // Rating
          Row(
            children: [
              RatingBarIndicator(
                rating: widget.product.rating,
                itemBuilder: (context, index) =>
                    const Icon(Icons.star, color: Colors.amber),
                itemCount: 5,
                itemSize: 16.sp,
                direction: Axis.horizontal,
              ),
              SizedBox(width: 8.w),
              Text(
                '(${widget.product.rating.toStringAsFixed(1)})',
                style: TextStyle(fontSize: 14.sp, color: Colors.grey.shade600),
              ),
            ],
          ),

          SizedBox(height: 16.h),

          // Price
          Row(
            children: [
              Text(
                '₹${widget.product.finalPrice.toStringAsFixed(0)}',
                style: TextStyle(
                  fontSize: 24.sp,
                  fontWeight: FontWeight.bold,
                  color: AppConfig.primaryColor,
                ),
              ),

              if (widget.product.isOnSale) ...[
                SizedBox(width: 8.w),
                Text(
                  '₹${widget.product.price.toStringAsFixed(0)}',
                  style: TextStyle(
                    fontSize: 16.sp,
                    color: Colors.grey.shade500,
                    decoration: TextDecoration.lineThrough,
                  ),
                ),
                SizedBox(width: 8.w),
                Container(
                  padding: EdgeInsets.symmetric(horizontal: 6.w, vertical: 2.h),
                  decoration: BoxDecoration(
                    color: Colors.red,
                    borderRadius: BorderRadius.circular(4.r),
                  ),
                  child: Text(
                    '${widget.product.discountPercentage.toStringAsFixed(0)}% OFF',
                    style: TextStyle(
                      fontSize: 10.sp,
                      color: Colors.white,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                ),
              ],
            ],
          ),

          SizedBox(height: 16.h),

          // Stock Status
          Row(
            children: [
              Icon(
                widget.product.inStock ? Icons.check_circle : Icons.cancel,
                color: widget.product.inStock ? Colors.green : Colors.red,
                size: 16.sp,
              ),
              SizedBox(width: 4.w),
              Text(
                widget.product.inStock ? 'In Stock' : 'Out of Stock',
                style: TextStyle(
                  fontSize: 14.sp,
                  color: widget.product.inStock ? Colors.green : Colors.red,
                  fontWeight: FontWeight.w500,
                ),
              ),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildProductDescription() {
    if (widget.product.description.isEmpty) return const SizedBox.shrink();

    return Container(
      width: double.infinity,
      color: Colors.white,
      padding: EdgeInsets.all(16.w),
      margin: EdgeInsets.only(top: 8.h),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            'Description',
            style: TextStyle(
              fontSize: 16.sp,
              fontWeight: FontWeight.w600,
              color: Colors.black,
            ),
          ),

          SizedBox(height: 8.h),

          Text(
            widget.product.description,
            style: TextStyle(
              fontSize: 14.sp,
              color: Colors.grey.shade700,
              height: 1.5,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildBottomBar() {
    return Container(
      padding: EdgeInsets.all(16.w),
      decoration: BoxDecoration(
        color: Colors.white,
        boxShadow: [
          BoxShadow(
            color: Colors.black.withOpacity(0.1),
            blurRadius: 10,
            offset: const Offset(0, -2),
          ),
        ],
      ),
      child: SafeArea(
        child: Row(
          children: [
            // Quantity Selector
            Container(
              decoration: BoxDecoration(
                border: Border.all(color: Colors.grey.shade300),
                borderRadius: BorderRadius.circular(8.r),
              ),
              child: Row(
                mainAxisSize: MainAxisSize.min,
                children: [
                  IconButton(
                    onPressed: quantity > 1
                        ? () => setState(() => quantity--)
                        : null,
                    icon: const Icon(Icons.remove),
                    iconSize: 18.sp,
                  ),
                  Text(
                    quantity.toString(),
                    style: TextStyle(
                      fontSize: 16.sp,
                      fontWeight: FontWeight.w600,
                    ),
                  ),
                  IconButton(
                    onPressed: () => setState(() => quantity++),
                    icon: const Icon(Icons.add),
                    iconSize: 18.sp,
                  ),
                ],
              ),
            ),

            SizedBox(width: 16.w),

            // Add to Cart Button
            Expanded(
              child: ElevatedButton(
                onPressed: widget.product.inStock
                    ? () {
                        cartController.addToCart(
                          widget.product,
                          quantity: quantity,
                        );
                        Get.snackbar(
                          'Added to Cart',
                          '${widget.product.name} added to cart',
                          snackPosition: SnackPosition.BOTTOM,
                          backgroundColor: Colors.green,
                          colorText: Colors.white,
                          duration: const Duration(seconds: 2),
                        );
                      }
                    : null,
                style: ElevatedButton.styleFrom(
                  backgroundColor: AppConfig.primaryColor,
                  foregroundColor: Colors.white,
                  padding: EdgeInsets.symmetric(vertical: 16.h),
                  shape: RoundedRectangleBorder(
                    borderRadius: BorderRadius.circular(8.r),
                  ),
                ),
                child: Text(
                  widget.product.inStock ? 'Add to Cart' : 'Out of Stock',
                  style: TextStyle(
                    fontSize: 16.sp,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  void _showImageGallery(List<String> images, int initialIndex) {
    Get.to(
      () => Scaffold(
        backgroundColor: Colors.black,
        appBar: AppBar(
          backgroundColor: Colors.black,
          leading: IconButton(
            icon: const Icon(Icons.close, color: Colors.white),
            onPressed: () => Get.back(),
          ),
        ),
        body: PhotoViewGallery.builder(
          scrollPhysics: const BouncingScrollPhysics(),
          builder: (BuildContext context, int index) {
            return PhotoViewGalleryPageOptions(
              imageProvider: CachedNetworkImageProvider(images[index]),
              initialScale: PhotoViewComputedScale.contained,
              minScale: PhotoViewComputedScale.contained * 0.8,
              maxScale: PhotoViewComputedScale.covered * 2,
            );
          },
          itemCount: images.length,
          loadingBuilder: (context, event) => const Center(
            child: CircularProgressIndicator(color: Colors.white),
          ),
          pageController: PageController(initialPage: initialIndex),
        ),
      ),
    );
  }
}
