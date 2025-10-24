import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import '../../config/app_config.dart';
import '../../controllers/auth_controller.dart';
import '../auth/login_page.dart';

class ProfilePage extends StatelessWidget {
  const ProfilePage({super.key});

  @override
  Widget build(BuildContext context) {
    final AuthController authController = Get.find<AuthController>();

    return Scaffold(
      backgroundColor: AppConfig.backgroundColor,
      body: SafeArea(
        child: Obx(() {
          if (!authController.isLoggedIn.value) {
            return _buildGuestView();
          }

          return _buildLoggedInView(authController);
        }),
      ),
    );
  }

  Widget _buildGuestView() {
    return Center(
      child: Padding(
        padding: EdgeInsets.all(24.w),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Icon(
              Icons.person_outline,
              size: 80.sp,
              color: AppConfig.textLight,
            ),
            
            SizedBox(height: 24.h),
            
            Text(
              'Welcome to ${AppConfig.appName}',
              style: TextStyle(
                fontSize: 24.sp,
                fontWeight: FontWeight.bold,
                color: AppConfig.textPrimary,
              ),
              textAlign: TextAlign.center,
            ),
            
            SizedBox(height: 12.h),
            
            Text(
              'Sign in to access your account, orders, and personalized recommendations',
              style: TextStyle(
                fontSize: 16.sp,
                color: AppConfig.textSecondary,
              ),
              textAlign: TextAlign.center,
            ),
            
            SizedBox(height: 32.h),
            
            SizedBox(
              width: double.infinity,
              child: ElevatedButton(
                onPressed: () {
                  Get.to(() => const LoginPage());
                },
                style: ElevatedButton.styleFrom(
                  padding: EdgeInsets.symmetric(vertical: 16.h),
                ),
                child: Text(
                  'Sign In',
                  style: TextStyle(
                    fontSize: 16.sp,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ),
            ),
            
            SizedBox(height: 16.h),
            
            SizedBox(
              width: double.infinity,
              child: OutlinedButton(
                onPressed: () {
                  Get.to(() => const LoginPage(isRegister: true));
                },
                style: OutlinedButton.styleFrom(
                  padding: EdgeInsets.symmetric(vertical: 16.h),
                ),
                child: Text(
                  'Create Account',
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

  Widget _buildLoggedInView(AuthController authController) {
    return CustomScrollView(
      slivers: [
        // Profile Header
        SliverToBoxAdapter(
          child: Container(
            padding: EdgeInsets.all(24.w),
            decoration: BoxDecoration(
              color: Colors.white,
              boxShadow: [
                BoxShadow(
                  color: AppConfig.shadowColor,
                  blurRadius: 8,
                  offset: const Offset(0, 2),
                ),
              ],
            ),
            child: Row(
              children: [
                CircleAvatar(
                  radius: 40.r,
                  backgroundColor: AppConfig.primaryColor,
                  child: Text(
                    authController.userName.isNotEmpty 
                        ? authController.userName[0].toUpperCase()
                        : 'U',
                    style: TextStyle(
                      fontSize: 24.sp,
                      fontWeight: FontWeight.bold,
                      color: Colors.white,
                    ),
                  ),
                ),
                
                SizedBox(width: 16.w),
                
                Expanded(
                  child: Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Text(
                        authController.userName,
                        style: TextStyle(
                          fontSize: 20.sp,
                          fontWeight: FontWeight.bold,
                          color: AppConfig.textPrimary,
                        ),
                      ),
                      
                      SizedBox(height: 4.h),
                      
                      Text(
                        authController.userEmail,
                        style: TextStyle(
                          fontSize: 14.sp,
                          color: AppConfig.textSecondary,
                        ),
                      ),
                    ],
                  ),
                ),
                
                IconButton(
                  onPressed: () {
                    // TODO: Navigate to edit profile
                  },
                  icon: Icon(
                    Icons.edit,
                    color: AppConfig.primaryColor,
                  ),
                ),
              ],
            ),
          ),
        ),
        
        // Menu Items
        SliverToBoxAdapter(
          child: Padding(
            padding: EdgeInsets.all(16.w),
            child: Column(
              children: [
                _buildMenuItem(
                  icon: Icons.shopping_bag_outlined,
                  title: 'My Orders',
                  subtitle: 'Track your orders',
                  onTap: () {
                    // TODO: Navigate to orders
                  },
                ),
                
                _buildMenuItem(
                  icon: Icons.favorite_outline,
                  title: 'Wishlist',
                  subtitle: 'Your saved items',
                  onTap: () {
                    // TODO: Navigate to wishlist
                  },
                ),
                
                _buildMenuItem(
                  icon: Icons.location_on_outlined,
                  title: 'Addresses',
                  subtitle: 'Manage delivery addresses',
                  onTap: () {
                    // TODO: Navigate to addresses
                  },
                ),
                
                _buildMenuItem(
                  icon: Icons.payment_outlined,
                  title: 'Payment Methods',
                  subtitle: 'Manage payment options',
                  onTap: () {
                    // TODO: Navigate to payment methods
                  },
                ),
                
                _buildMenuItem(
                  icon: Icons.notifications_outlined,
                  title: 'Notifications',
                  subtitle: 'Notification preferences',
                  onTap: () {
                    // TODO: Navigate to notifications settings
                  },
                ),
                
                _buildMenuItem(
                  icon: Icons.help_outline,
                  title: 'Help & Support',
                  subtitle: 'Get help and contact us',
                  onTap: () {
                    // TODO: Navigate to help
                  },
                ),
                
                _buildMenuItem(
                  icon: Icons.info_outline,
                  title: 'About',
                  subtitle: 'App version and info',
                  onTap: () {
                    // TODO: Show about dialog
                  },
                ),
                
                SizedBox(height: 16.h),
                
                _buildMenuItem(
                  icon: Icons.logout,
                  title: 'Sign Out',
                  subtitle: 'Sign out of your account',
                  onTap: () {
                    _showLogoutDialog(authController);
                  },
                  isDestructive: true,
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildMenuItem({
    required IconData icon,
    required String title,
    required String subtitle,
    required VoidCallback onTap,
    bool isDestructive = false,
  }) {
    return Padding(
      padding: EdgeInsets.only(bottom: 8.h),
      child: Container(
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(AppConfig.defaultRadius),
          boxShadow: [
            BoxShadow(
              color: AppConfig.shadowColor,
              blurRadius: 4,
              offset: const Offset(0, 1),
            ),
          ],
        ),
        child: ListTile(
          leading: Icon(
            icon,
            color: isDestructive ? AppConfig.errorColor : AppConfig.primaryColor,
            size: 24.sp,
          ),
          title: Text(
            title,
            style: TextStyle(
              fontSize: 16.sp,
              fontWeight: FontWeight.w600,
              color: isDestructive ? AppConfig.errorColor : AppConfig.textPrimary,
            ),
          ),
          subtitle: Text(
            subtitle,
            style: TextStyle(
              fontSize: 12.sp,
              color: AppConfig.textSecondary,
            ),
          ),
          trailing: Icon(
            Icons.arrow_forward_ios,
            color: AppConfig.textLight,
            size: 16.sp,
          ),
          onTap: onTap,
          contentPadding: EdgeInsets.symmetric(
            horizontal: 16.w,
            vertical: 8.h,
          ),
        ),
      ),
    );
  }

  void _showLogoutDialog(AuthController authController) {
    Get.dialog(
      AlertDialog(
        title: const Text('Sign Out'),
        content: const Text('Are you sure you want to sign out?'),
        actions: [
          TextButton(
            onPressed: () => Get.back(),
            child: const Text('Cancel'),
          ),
          ElevatedButton(
            onPressed: () {
              authController.logout();
              Get.back();
            },
            style: ElevatedButton.styleFrom(
              backgroundColor: AppConfig.errorColor,
            ),
            child: const Text('Sign Out'),
          ),
        ],
      ),
    );
  }
}
