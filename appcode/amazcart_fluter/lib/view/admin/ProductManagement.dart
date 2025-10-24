import 'package:amazcart/utils/styles.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';

class ProductManagement extends StatelessWidget {
  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppStyles.appBackgroundColor,
      appBar: AppBar(
        backgroundColor: AppStyles.pinkColor,
        title: Text(
          'Product Management',
          style: AppStyles.appFont.copyWith(
            color: Colors.white,
            fontSize: 18.sp,
            fontWeight: FontWeight.bold,
          ),
        ),
      ),
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(
              Icons.inventory,
              size: 64.w,
              color: Colors.grey,
            ),
            SizedBox(height: 16.h),
            Text(
              'Product Management',
              style: AppStyles.appFont.copyWith(
                fontSize: 18.sp,
                fontWeight: FontWeight.bold,
                color: AppStyles.blackColor,
              ),
            ),
            SizedBox(height: 8.h),
            Text(
              'Coming Soon',
              style: AppStyles.appFont.copyWith(
                fontSize: 14.sp,
                color: Colors.grey,
              ),
            ),
          ],
        ),
      ),
    );
  }
}
