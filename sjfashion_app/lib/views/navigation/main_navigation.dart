import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:font_awesome_flutter/font_awesome_flutter.dart';
import 'package:badges/badges.dart' as badges;

import '../../config/app_config.dart';
import '../../controllers/app_controller.dart';
import '../../controllers/cart_controller.dart';
import '../../controllers/wishlist_controller.dart';
import '../home/home_page.dart';
import '../wishlist/wishlist_page.dart';
import '../cart/cart_page.dart';
import '../profile/profile_page.dart';

class MainNavigation extends StatelessWidget {
  const MainNavigation({super.key});

  @override
  Widget build(BuildContext context) {
    final AppController appController = Get.find<AppController>();
    final CartController cartController = Get.find<CartController>();
    final WishlistController wishlistController =
        Get.find<WishlistController>();

    return Obx(
      () => Scaffold(
        body: IndexedStack(
          index: appController.currentIndex.value,
          children: const [
            HomePage(),
            WishlistPage(),
            CartPage(),
            ProfilePage(),
          ],
        ),
        bottomNavigationBar: Container(
          decoration: BoxDecoration(
            color: Colors.white,
            boxShadow: [
              BoxShadow(
                color: AppConfig.shadowColor,
                blurRadius: 10,
                offset: const Offset(0, -2),
              ),
            ],
          ),
          child: BottomNavigationBar(
            currentIndex: appController.currentIndex.value,
            onTap: appController.changeIndex,
            type: BottomNavigationBarType.fixed,
            backgroundColor: Colors.white,
            selectedItemColor: AppConfig.primaryColor,
            unselectedItemColor: AppConfig.textLight,
            selectedFontSize: 12,
            unselectedFontSize: 12,
            elevation: 0,
            items: [
              const BottomNavigationBarItem(
                icon: Icon(Icons.home_outlined),
                activeIcon: Icon(Icons.home),
                label: 'Home',
              ),
              const BottomNavigationBarItem(
                icon: Icon(Icons.favorite_border),
                activeIcon: Icon(Icons.favorite),
                label: 'Wishlist',
              ),
              BottomNavigationBarItem(
                icon: Obx(
                  () => badges.Badge(
                    showBadge: cartController.cartItemCount.value > 0,
                    badgeContent: Text(
                      cartController.cartItemCount.value.toString(),
                      style: const TextStyle(
                        color: Colors.white,
                        fontSize: 10,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    badgeStyle: const badges.BadgeStyle(
                      badgeColor: AppConfig.primaryColor,
                      padding: EdgeInsets.all(4),
                    ),
                    child: const Icon(Icons.shopping_cart_outlined),
                  ),
                ),
                activeIcon: Obx(
                  () => badges.Badge(
                    showBadge: cartController.cartItemCount.value > 0,
                    badgeContent: Text(
                      cartController.cartItemCount.value.toString(),
                      style: const TextStyle(
                        color: Colors.white,
                        fontSize: 10,
                        fontWeight: FontWeight.bold,
                      ),
                    ),
                    badgeStyle: const badges.BadgeStyle(
                      badgeColor: AppConfig.primaryColor,
                      padding: EdgeInsets.all(4),
                    ),
                    child: const Icon(Icons.shopping_cart),
                  ),
                ),
                label: 'Cart',
              ),
              const BottomNavigationBarItem(
                icon: Icon(Icons.person_outline),
                activeIcon: Icon(Icons.person),
                label: 'Profile',
              ),
            ],
          ),
        ),
      ),
    );
  }
}
