import 'package:amazcart/AppConfig/app_config.dart';
import 'package:amazcart/controller/login_controller.dart';
import 'package:amazcart/utils/styles.dart';
import 'package:amazcart/view/admin/BannerManagement.dart';
import 'package:amazcart/view/admin/CategoryManagement.dart';
import 'package:amazcart/view/admin/ProductManagement.dart';
import 'package:amazcart/view/admin/OrderManagement.dart';
import 'package:amazcart/view/authentication/sign_in/LoginPage.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';

class AdminDashboard extends StatefulWidget {
  @override
  _AdminDashboardState createState() => _AdminDashboardState();
}

class _AdminDashboardState extends State<AdminDashboard> {
  final LoginController loginController = Get.find<LoginController>();

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppStyles.appBackgroundColor,
      appBar: AppBar(
        backgroundColor: AppStyles.pinkColor,
        title: Text(
          'Admin Dashboard',
          style: AppStyles.appFont.copyWith(
            color: Colors.white,
            fontSize: 18.sp,
            fontWeight: FontWeight.bold,
          ),
        ),
        actions: [
          IconButton(
            onPressed: () {
              _showLogoutDialog();
            },
            icon: Icon(Icons.logout, color: Colors.white),
          ),
        ],
      ),
      body: Padding(
        padding: EdgeInsets.all(16.w),
        child: GridView.count(
          crossAxisCount: 2,
          crossAxisSpacing: 16.w,
          mainAxisSpacing: 16.h,
          children: [
            _buildDashboardCard(
              title: 'Banner Management',
              icon: Icons.image,
              color: Colors.blue,
              onTap: () {
                Get.to(() => BannerManagement());
              },
            ),
            _buildDashboardCard(
              title: 'Category Management',
              icon: Icons.category,
              color: Colors.green,
              onTap: () {
                Get.to(() => CategoryManagement());
              },
            ),
            _buildDashboardCard(
              title: 'Product Management',
              icon: Icons.inventory,
              color: Colors.orange,
              onTap: () {
                Get.to(() => ProductManagement());
              },
            ),
            _buildDashboardCard(
              title: 'Order Management',
              icon: Icons.shopping_cart,
              color: Colors.purple,
              onTap: () {
                Get.to(() => OrderManagement());
              },
            ),
            _buildDashboardCard(
              title: 'Analytics',
              icon: Icons.analytics,
              color: Colors.teal,
              onTap: () {
                // TODO: Implement analytics
                Get.snackbar('Coming Soon', 'Analytics feature will be available soon');
              },
            ),
            _buildDashboardCard(
              title: 'Settings',
              icon: Icons.settings,
              color: Colors.grey,
              onTap: () {
                // TODO: Implement settings
                Get.snackbar('Coming Soon', 'Settings feature will be available soon');
              },
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildDashboardCard({
    required String title,
    required IconData icon,
    required Color color,
    required VoidCallback onTap,
  }) {
    return GestureDetector(
      onTap: onTap,
      child: Container(
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
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Container(
              padding: EdgeInsets.all(16.w),
              decoration: BoxDecoration(
                color: color.withOpacity(0.1),
                shape: BoxShape.circle,
              ),
              child: Icon(
                icon,
                size: 32.w,
                color: color,
              ),
            ),
            SizedBox(height: 12.h),
            Text(
              title,
              textAlign: TextAlign.center,
              style: AppStyles.appFont.copyWith(
                fontSize: 14.sp,
                fontWeight: FontWeight.w600,
                color: AppStyles.blackColor,
              ),
            ),
          ],
        ),
      ),
    );
  }

  void _showLogoutDialog() {
    Get.dialog(
      AlertDialog(
        title: Text('Logout'),
        content: Text('Are you sure you want to logout?'),
        actions: [
          TextButton(
            onPressed: () => Get.back(),
            child: Text('Cancel'),
          ),
          TextButton(
            onPressed: () {
              Get.back();
              loginController.logOut();
              Get.offAll(() => LoginPage());
            },
            child: Text('Logout'),
          ),
        ],
      ),
    );
  }
}
