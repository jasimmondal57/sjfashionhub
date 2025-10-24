import 'package:sjfashionhub/AppConfig/app_config.dart';
import 'package:sjfashionhub/controller/cart_controller.dart';
import 'package:sjfashionhub/controller/home_controller.dart';
import 'package:sjfashionhub/model/NewModel/Brand/BrandData.dart';
import 'package:sjfashionhub/utils/styles.dart';
import 'package:sjfashionhub/view/amazcart_view/products/brand/ProductsByBrands.dart';
import 'package:sjfashionhub/widgets/amazcart_widget/appbar_back_button.dart';
import 'package:sjfashionhub/widgets/amazcart_widget/cart_icon_widget.dart';
import 'package:sjfashionhub/widgets/amazcart_widget/custom_grid_delegate.dart';
import 'package:fancy_shimmer_image/fancy_shimmer_image.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';

class AllBrandsPage extends StatefulWidget {
  @override
  _AllBrandsPageState createState() => _AllBrandsPageState();
}

class _AllBrandsPageState extends State<AllBrandsPage> {
  final HomeController _homeController = Get.put(HomeController());
  // final CartController cartController = Get.put(CartController());
  final CartController cartController = Get.find();

  @override
  void initState() {
    _homeController.getAllBrand();
    super.initState();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppStyles.appBackgroundColor,
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0,
        centerTitle: false,
        scrolledUnderElevation: 0,
        leading: AppBarBackButton(),
        toolbarHeight: 60.h,
        title: Text(
          "Brands".tr,
          style: AppStyles.kFontBlack15w4,
        ),
        actions: [
          CartIconWidget(),
        ],
      ),
      body: Obx(() {
        if (_homeController.isBrandsLoading.value) {
          return Center(child: CupertinoActivityIndicator());
        } else {
          return GridView.builder(
              shrinkWrap: true,
              padding: EdgeInsets.symmetric(horizontal: 10, vertical: 10),
              physics: BouncingScrollPhysics(),
              gridDelegate:
                  SliverGridDelegateWithFixedCrossAxisCountAndFixedHeight(
                crossAxisCount: 3,
                crossAxisSpacing: 0,
                mainAxisSpacing: 6,
                height: 130.h,
              ),
              itemCount: _homeController.allBrands.length,
              itemBuilder: (context, index) {
                BrandData brand = _homeController.allBrands[index];
                return GestureDetector(
                  onTap: () async {
                    _homeController.brandId.value = brand.id ?? 0;
                    _homeController.allBrandProducts.clear();
                    _homeController.lastBrandPage.value = false;
                    _homeController.brandPageNumber.value = 1;
                    _homeController.getBrandProducts();
                    _homeController.getBrandFilterData();
                    if (_homeController.dataFilterCat.value.filterDataFromCat !=
                        null) {
                      _homeController
                          .dataFilterCat.value.filterDataFromCat?.filterType
                          ?.forEach((element) {
                        if (element.filterTypeId == 'brand' ||
                            element.filterTypeId == 'cat') {
                          print(element.filterTypeId);
                          element.filterTypeValue?.clear();
                        }
                      });
                    }
                    Get.to(() => ProductsByBrands(
                          brandId: brand.id ?? 0,
                        ));
                  },
                  child: Container(
                    width: Get.width * 0.5,
                    child: Padding(
                      padding: EdgeInsets.symmetric(horizontal: 8.w, vertical: 5.h),
                      child: Material(
                        elevation: 2,
                        shadowColor: Colors.white,
                        borderRadius: BorderRadius.all(
                          Radius.circular(5.r),
                        ),
                        clipBehavior: Clip.antiAlias,
                        child: Container(
                          color: Colors.white,
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.center,
                            crossAxisAlignment: CrossAxisAlignment.center,
                            children: [
                              Expanded(
                                child: Container(
                                  padding: EdgeInsets.symmetric(
                                      vertical: 10.w,
                                      horizontal: 10.w),
                                  child: brand.logo != null && ( brand.logo??'').isNotEmpty
                                      ? Container(
                                          child: FancyShimmerImage(
                                            imageUrl: AppConfig.assetPath + '/' + brand.logo.toString(),
                                            boxFit: BoxFit.contain,
                                            errorWidget: FancyShimmerImage(
                                              imageUrl:
                                                  "${AppConfig.assetPath}/backend/img/default.png",
                                              boxFit: BoxFit.contain,
                                            ),
                                          ),
                                        )
                                      : Container(
                                          child: Icon(
                                            Icons.list_alt,
                                            size: 30.w,
                                          ),
                                        ),
                                ),
                              ),
                              Text(
                                brand.name?? '',
                                maxLines: 2,
                                overflow: TextOverflow.ellipsis,
                                style: AppStyles.appFont.copyWith(
                                  color: AppStyles.blackColor,
                                  fontSize: 15.fontSize,
                                  fontWeight: FontWeight.w500,
                                ),
                              ),
                              SizedBox(
                                height: 20,
                              ),
                            ],
                          ),
                        ),
                      ),
                    ),
                  ),
                );
              });
        }
      }),
    );
  }
}
