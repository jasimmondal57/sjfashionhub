import 'package:get/get.dart';
import '../app_controller.dart';
import '../home_controller.dart';
import '../category_controller.dart';
import '../product_controller.dart';
import '../cart_controller.dart';
import '../wishlist_controller.dart';
import '../auth_controller.dart';

class InitialBinding extends Bindings {
  @override
  void dependencies() {
    // Core Controllers
    Get.put<AppController>(AppController(), permanent: true);
    Get.put<AuthController>(AuthController(), permanent: true);
    Get.put<CartController>(CartController(), permanent: true);
    Get.put<WishlistController>(WishlistController(), permanent: true);

    // Feature Controllers
    Get.lazyPut<HomeController>(() => HomeController());
    Get.lazyPut<CategoryController>(() => CategoryController());
    Get.lazyPut<ProductController>(() => ProductController());
  }
}
