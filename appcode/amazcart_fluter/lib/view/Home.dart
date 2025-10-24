import 'package:amazcart/AppConfig/app_config.dart';
import 'package:amazcart/controller/settings_controller.dart';
import 'package:amazcart/controller/home_controller.dart';
import 'package:amazcart/controller/product_details_controller.dart';
import 'package:amazcart/model/NewModel/Category/CategoryData.dart';
import 'package:amazcart/model/NewModel/Category/SingleCategory.dart';
import 'package:amazcart/model/NewModel/HomePage/HomePageModel.dart';
import 'package:amazcart/model/NewModel/Product/ProductModel.dart';
import 'package:amazcart/model/NewModel/Product/ProductType.dart';
import 'package:amazcart/utils/styles.dart';
import 'package:amazcart/view/marketing/AllTopPickProducts.dart';
import 'package:amazcart/view/marketing/FlashDealView.dart';
import 'package:amazcart/view/marketing/NewUserZone/NewUserZonePage.dart';
import 'package:amazcart/view/products/AllCategorySubCategory.dart';
import 'package:amazcart/view/products/product/ProductDetails.dart';
import 'package:amazcart/view/products/RecommendedProductLoadMore.dart';
import 'package:amazcart/view/products/brand/AllBrandsPage.dart';
import 'package:amazcart/view/products/brand/ProductsByBrands.dart';
import 'package:amazcart/view/products/category/ProductsByCategory.dart';
import 'package:amazcart/view/products/category/FeaturedCategoriesPage.dart';
import 'package:amazcart/view/products/tags/ProductsByTags.dart';
import 'package:amazcart/widgets/BuildIndicatorBuilder.dart';
import 'package:amazcart/widgets/GridViewProductWidget.dart';
import 'package:amazcart/widgets/HomeTitlesWidget.dart';
import 'package:amazcart/widgets/HorizontalProductWidget.dart';
import 'package:amazcart/widgets/custom_input_border.dart';
import 'package:amazcart/widgets/fa_icon_maker/fa_custom_icon.dart';
import 'package:fancy_shimmer_image/fancy_shimmer_image.dart';
import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:flutter_swiper_view/flutter_swiper_view.dart';
import 'package:get/get.dart';
import 'package:loading_more_list/loading_more_list.dart';
import 'package:loading_skeleton_niu/loading_skeleton.dart';
import 'package:supercharged/supercharged.dart';
import 'package:amazcart/widgets/custom_grid_delegate.dart';
import '../controller/cart_controller.dart';
import 'SearchPageMain.dart';

class Home extends StatefulWidget {
  @override
  _HomeState createState() => _HomeState();
}

class _HomeState extends State<Home> {
  // final HomeController controller = Get.put(HomeController());

  final HomeController _homeController = Get.put(HomeController());

  final GeneralSettingsController currencyController = Get.put(
    GeneralSettingsController(),
  );

  @override
  void initState() {
    _homeController.source = RecommendedProductsLoadMore();
    Get.find<CartController>().getCartList();
    super.initState();
  }

  @override
  void dispose() {
    _homeController.source?.dispose();
    super.dispose();
  }

  Future<void> refresh() async {
    print('refres');
    // controller.forceR.value = true;
    // controller.allRecommendedProds.clear();
    // controller.recommendedPageNumber.value = 1;
    // controller.recommendedLastPage.value = false;

    // controller.allTopPicksProds.clear();
    // controller.chunkedBrands.clear();
    // controller.topPicksPageNumber.value = 1;
    // controller.topPicksLastPage.value = false;
    // controller.onInit();
    // controller.forceR.value = false;

    await _homeController.getHomePage();
    _homeController.source?.refresh(true);
  }

  RadialGradient selectColor(int position) {
    RadialGradient c = RadialGradient(
      center: Alignment(0.7, -0.6), // near the top right
      radius: 0.2,
      colors: [
        Color(0xFFFFFF00), // yellow sun
        Color(0xFF0099FF), // blue sky
      ],
      stops: [0.4, 1.0],
    );
    if (position % 8 == 0)
      c = RadialGradient(colors: [Color(0xFFD35DDD), Color(0xFFA100AF)]);
    if (position % 8 == 1)
      c = RadialGradient(colors: [Color(0xFF5580D3), Color(0xFF003464)]);
    if (position % 8 == 2)
      c = RadialGradient(colors: [Color(0xFF8564E1), Color(0xFF4922B7)]);
    if (position % 8 == 3)
      c = RadialGradient(colors: [Color(0xFFFF4387), Color(0xFFC60077)]);
    if (position % 8 == 4)
      c = RadialGradient(colors: [Color(0xFFFF4370), Color(0xFFCE0019)]);
    if (position % 8 == 5)
      c = RadialGradient(colors: [Color(0xFF36C25E), Color(0xFF00A324)]);
    if (position % 8 == 6)
      c = RadialGradient(colors: [Color(0xFF852A8D), Color(0xFF5C0064)]);
    if (position % 8 == 7)
      c = RadialGradient(colors: [Color(0xFFFF6C4B), Color(0xFFDB2B20)]);
    return c;
  }

  final ScrollController scrollController = ScrollController();

  bool isScrolling = false;

  @override
  Widget build(BuildContext context) {
    return SafeArea(
      child: Scaffold(
        backgroundColor: AppStyles.appBackgroundColor,
        floatingActionButton: isScrolling
            ? Container(
                margin: EdgeInsets.only(bottom: 60.r),
                child: FloatingActionButton.small(
                  backgroundColor: AppStyles.pinkColor,
                  onPressed: () {
                    scrollController.animateTo(
                      0,
                      duration: Duration(milliseconds: 500),
                      curve: Curves.easeIn,
                    );
                  },
                  child: Icon(
                    Icons.arrow_upward_sharp,
                    size: 16.w,
                    color: Colors.white,
                  ),
                ),
              )
            : Container(),
        body: GestureDetector(
          onTap: () {
            FocusScope.of(context).unfocus();
          },
          child: RefreshIndicator(
            onRefresh: refresh,
            child: NotificationListener<ScrollNotification>(
              onNotification: (ScrollNotification scrollInfo) {
                FocusScope.of(context).unfocus();
                if (scrollController.offset > 0) {
                  setState(() {
                    isScrolling = true;
                  });
                } else {
                  setState(() {
                    isScrolling = false;
                  });
                }
                return false;
              },
              child: LoadingMoreCustomScrollView(
                controller: scrollController,
                slivers: [
                  SliverAppBar(
                    backgroundColor: AppStyles.appBackgroundColor,
                    titleSpacing: 10.w,
                    pinned: true,
                    elevation: 0,
                    // expandedHeight: 50.h,
                    toolbarHeight: 70.h,
                    scrolledUnderElevation: 0,
                    title: Row(
                      children: [
                        Image.asset("${AppConfig.appBanner}", height: 30.h),
                        SizedBox(width: 10.w),
                        // Expanded(child: Container()),
                        // IconButton(
                        //   onPressed: () {
                        //     Get.to(() => SearchPageMain());
                        //   },
                        //   icon: Icon(
                        //     FontAwesomeIcons.search,
                        //   ),
                        // ),
                        Expanded(
                          child: GestureDetector(
                            onTap: () {
                              Get.to(() => SearchPageMain());
                            },
                            child: Container(
                              //height: 50.h,
                              alignment: Alignment.center,
                              child: TextField(
                                autofocus: true,
                                enabled: false,
                                textAlignVertical: TextAlignVertical.center,
                                keyboardType: TextInputType.text,
                                style: AppStyles.appFont.copyWith(
                                  fontSize: 12.sp,
                                  color: AppStyles.greyColorDark,
                                ),
                                decoration: CustomInputBorder()
                                    .inputDecoration('${AppConfig.appName}')
                                    .copyWith(
                                      suffixIcon: Icon(
                                        Icons.search,
                                        size: 16.w,
                                      ),
                                      contentPadding: EdgeInsets.all(6.w),
                                    ),
                              ),
                            ),
                          ),
                        ),
                      ],
                    ),
                  ),

                  SliverToBoxAdapter(
                    child: ListView(
                      physics: NeverScrollableScrollPhysics(),
                      shrinkWrap: true,
                      padding: EdgeInsets.symmetric(
                        horizontal: 10.w,
                        vertical: 0,
                      ),
                      children: [
                        ///** TOP BANNER SECTION (ADMIN MANAGED)
                        _buildTopBannerSection(),

                        SizedBox(height: 16.h),

                        ///** SHOP BY CATEGORY SECTION (ADMIN MANAGED)
                        _buildShopByCategorySection(),

                        SizedBox(height: 16.h),

                        ///** SLIDER
                        Obx(
                          () => _homeController.isHomePageLoading.value
                              ? ClipRRect(
                                  borderRadius: BorderRadius.all(
                                    Radius.circular(5),
                                  ),
                                  child: Container(
                                    padding: EdgeInsets.all(1),
                                    child: LoadingSkeleton(
                                      height: 150.h,
                                      width: Get.width,
                                      colors: [
                                        Colors.black.withOpacity(0.1),
                                        Colors.black.withOpacity(0.2),
                                      ],
                                    ),
                                  ),
                                )
                              : _homeController.homePageModel.value.sliders ==
                                        null ||
                                    _homeController
                                        .homePageModel
                                        .value
                                        .sliders!
                                        .isEmpty
                              ? SizedBox.shrink()
                              : ClipRRect(
                                  borderRadius: BorderRadius.all(
                                    Radius.circular(5),
                                  ),
                                  child: AspectRatio(
                                    aspectRatio: 16 / 5,
                                    child: Swiper(
                                      itemCount: _homeController
                                          .homePageModel
                                          .value
                                          .sliders!
                                          .length,
                                      autoplay: true,
                                      autoplayDelay: 5000,
                                      itemBuilder:
                                          (
                                            BuildContext context,
                                            int sliderIndex,
                                          ) {
                                            HomePageSlider slider =
                                                _homeController
                                                    .homePageModel
                                                    .value
                                                    .sliders![sliderIndex];
                                            return FancyShimmerImage(
                                              imageUrl:
                                                  AppConfig.assetPath +
                                                  '/' +
                                                  slider.sliderImage!,
                                              boxFit: BoxFit.cover,
                                              width: Get.width,
                                              errorWidget: FancyShimmerImage(
                                                imageUrl:
                                                    "${AppConfig.assetPath}/backend/img/default.png",
                                                boxFit: BoxFit.contain,
                                                errorWidget: FancyShimmerImage(
                                                  imageUrl:
                                                      "${AppConfig.assetPath}/backend/img/default.png",
                                                  boxFit: BoxFit.contain,
                                                ),
                                              ),
                                            );
                                          },
                                      onTap: (sliderIndex) {
                                        HomePageSlider slider = _homeController
                                            .homePageModel
                                            .value
                                            .sliders![sliderIndex];
                                        if (slider.dataType ==
                                            SliderDataType.PRODUCT) {
                                          Get.to(
                                            () => ProductDetails(
                                              productID: slider.dataId!,
                                            ),
                                          );
                                        } else if (slider.dataType ==
                                            SliderDataType.CATEGORY) {
                                          print('category');
                                          _homeController.categoryId.value =
                                              slider.dataId!;
                                          _homeController
                                                  .categoryIdBeforeFilter
                                                  .value =
                                              slider.dataId!;
                                          _homeController.allProds.clear();
                                          _homeController.subCats.clear();
                                          _homeController.lastPage.value =
                                              false;
                                          _homeController.pageNumber.value = 1;
                                          _homeController.category.value =
                                              CategoryData();
                                          _homeController.catAllData.value =
                                              SingleCategory();
                                          // controller.dataFilter.value =
                                          //     FilterFromCatModel();
                                          _homeController.getCategoryProducts();
                                          _homeController
                                              .getCategoryFilterData();
                                          if (_homeController
                                                  .dataFilterCat
                                                  .value
                                                  .filterDataFromCat !=
                                              null) {
                                            _homeController
                                                .dataFilterCat
                                                .value
                                                .filterDataFromCat!
                                                .filterType!
                                                .forEach((element) {
                                                  if (element.filterTypeId ==
                                                          'brand' ||
                                                      element.filterTypeId ==
                                                          'cat') {
                                                    print(element.filterTypeId);
                                                    element.filterTypeValue!
                                                        .clear();
                                                  }
                                                });
                                          }

                                          _homeController.filterRating.value =
                                              0.0;

                                          Get.to(
                                            () => ProductsByCategory(
                                              categoryId: slider.dataId!,
                                            ),
                                          );
                                        } else if (slider.dataType ==
                                            SliderDataType.BRAND) {
                                          print('brand');
                                          _homeController.brandId.value =
                                              slider.dataId!;
                                          _homeController.allBrandProducts
                                              .clear();
                                          _homeController.subCatsInBrands
                                              .clear();
                                          _homeController.lastBrandPage.value =
                                              false;
                                          _homeController
                                                  .brandPageNumber
                                                  .value =
                                              1;
                                          _homeController.getBrandProducts();
                                          _homeController.getBrandFilterData();

                                          if (_homeController
                                                  .dataFilterCat
                                                  .value
                                                  .filterDataFromCat !=
                                              null) {
                                            _homeController
                                                .dataFilterCat
                                                .value
                                                .filterDataFromCat!
                                                .filterType!
                                                .forEach((element) {
                                                  if (element.filterTypeId ==
                                                          'brand' ||
                                                      element.filterTypeId ==
                                                          'cat') {
                                                    print(element.filterTypeId);
                                                    element.filterTypeValue!
                                                        .clear();
                                                  }
                                                });
                                          }
                                          Get.to(
                                            () => ProductsByBrands(
                                              brandId: slider.dataId!,
                                            ),
                                          );
                                        } else if (slider.dataType ==
                                            SliderDataType.TAG) {
                                          print('tag -- ${slider.tag!.name}');

                                          Get.to(
                                            () => ProductsByTags(
                                              tagName: slider.tag!.name!,
                                              tagId: slider.tag!.id!,
                                            ),
                                          );
                                        }
                                      },
                                      pagination: SwiperPagination(
                                        margin: EdgeInsets.all(5.0),
                                        builder: SwiperCustomPagination(
                                          builder:
                                              (
                                                BuildContext context,
                                                SwiperPluginConfig config,
                                              ) {
                                                return Align(
                                                  alignment:
                                                      Alignment.bottomCenter,
                                                  child:
                                                      RectSwiperPaginationBuilder(
                                                        color: Colors.white
                                                            .withOpacity(0.5),
                                                        activeColor:
                                                            Colors.white,
                                                        size: Size(5.0, 5.0),
                                                        activeSize: Size(
                                                          20.0,
                                                          5.0,
                                                        ),
                                                      ).build(context, config),
                                                );
                                              },
                                        ),
                                      ),
                                    ),
                                  ),
                                ),
                        ),

                        // Obx(() {
                        //
                        //
                        //
                        //
                        //
                        //   // if (_homeController.isHomePageLoading.value) {
                        //   //   return ClipRRect(
                        //   //     borderRadius:
                        //   //         BorderRadius.all(Radius.circular(5)),
                        //   //     child: Container(
                        //   //       padding: EdgeInsets.all(1),
                        //   //       child: LoadingSkeleton(
                        //   //         height: 150,
                        //   //         width: Get.width,
                        //   //         colors: [
                        //   //           Colors.black.withOpacity(0.1),
                        //   //           Colors.black.withOpacity(0.2),
                        //   //         ],
                        //   //       ),
                        //   //     ),
                        //   //   );
                        //   // } else {
                        //   //   if (_homeController
                        //   //           .homePageModel.value.sliders!.isNotEmpty) {
                        //   //     return ClipRRect(
                        //   //       borderRadius:
                        //   //           BorderRadius.all(Radius.circular(5)),
                        //   //       child: AspectRatio(
                        //   //         aspectRatio: 16/5,
                        //   //         child: Swiper(
                        //   //           itemCount: _homeController
                        //   //               .homePageModel.value.sliders!.length,
                        //   //           autoplay: true,
                        //   //           autoplayDelay: 5000,
                        //   //           itemBuilder: (BuildContext context,
                        //   //               int sliderIndex) {
                        //   //             HomePageSlider slider = _homeController
                        //   //                 .homePageModel
                        //   //                 .value
                        //   //                 .sliders![sliderIndex];
                        //   //             return FancyShimmerImage(
                        //   //               imageUrl: AppConfig.assetPath +
                        //   //                   '/' +
                        //   //                   slider.sliderImage!,
                        //   //               boxFit: BoxFit.cover,
                        //   //               width: Get.width,
                        //   //               errorWidget: FancyShimmerImage(
                        //   //                 imageUrl:
                        //   //                     "${AppConfig.assetPath}/backend/img/default.png",
                        //   //                 boxFit: BoxFit.contain,
                        //   //                 errorWidget: FancyShimmerImage(
                        //   //                   imageUrl:
                        //   //                       "${AppConfig.assetPath}/backend/img/default.png",
                        //   //                   boxFit: BoxFit.contain,
                        //   //                 ),
                        //   //               ),
                        //   //             );
                        //   //           },
                        //   //           onTap: (sliderIndex) {
                        //   //             HomePageSlider slider = _homeController
                        //   //                 .homePageModel
                        //   //                 .value
                        //   //                 .sliders![sliderIndex];
                        //   //             if (slider.dataType ==
                        //   //                 SliderDataType.PRODUCT) {
                        //   //               Get.to(() => ProductDetails(
                        //   //                     productID: slider.dataId!,
                        //   //                   ));
                        //   //             } else if (slider.dataType ==
                        //   //                 SliderDataType.CATEGORY) {
                        //   //               print('category');
                        //   //               _homeController.categoryId.value =
                        //   //                   slider.dataId!;
                        //   //               _homeController.categoryIdBeforeFilter
                        //   //                   .value = slider.dataId!;
                        //   //               _homeController.allProds.clear();
                        //   //               _homeController.subCats.clear();
                        //   //               _homeController.lastPage.value = false;
                        //   //               _homeController.pageNumber.value = 1;
                        //   //               _homeController.category.value =
                        //   //                   CategoryData();
                        //   //               _homeController.catAllData.value =
                        //   //                   SingleCategory();
                        //   //               // controller.dataFilter.value =
                        //   //               //     FilterFromCatModel();
                        //   //               _homeController.getCategoryProducts();
                        //   //               _homeController.getCategoryFilterData();
                        //   //               if (_homeController.dataFilterCat.value
                        //   //                       .filterDataFromCat !=
                        //   //                   null) {
                        //   //                 _homeController.dataFilterCat.value
                        //   //                     .filterDataFromCat!.filterType!
                        //   //                     .forEach((element) {
                        //   //                   if (element.filterTypeId ==
                        //   //                           'brand' ||
                        //   //                       element.filterTypeId == 'cat') {
                        //   //                     print(element.filterTypeId);
                        //   //                     element.filterTypeValue!.clear();
                        //   //                   }
                        //   //                 });
                        //   //               }
                        //   //
                        //   //               _homeController.filterRating.value =
                        //   //                   0.0;
                        //   //
                        //   //               Get.to(() => ProductsByCategory(
                        //   //                     categoryId: slider.dataId!,
                        //   //                   ));
                        //   //             } else if (slider.dataType ==
                        //   //                 SliderDataType.BRAND) {
                        //   //               print('brand');
                        //   //               _homeController.brandId.value =
                        //   //                   slider.dataId!;
                        //   //               _homeController.allBrandProducts
                        //   //                   .clear();
                        //   //               _homeController.subCatsInBrands.clear();
                        //   //               _homeController.lastBrandPage.value =
                        //   //                   false;
                        //   //               _homeController.brandPageNumber.value =
                        //   //                   1;
                        //   //               _homeController.getBrandProducts();
                        //   //               _homeController.getBrandFilterData();
                        //   //
                        //   //               if (_homeController.dataFilterCat.value
                        //   //                       .filterDataFromCat !=
                        //   //                   null) {
                        //   //                 _homeController.dataFilterCat.value
                        //   //                     .filterDataFromCat!.filterType!
                        //   //                     .forEach((element) {
                        //   //                   if (element.filterTypeId ==
                        //   //                           'brand' ||
                        //   //                       element.filterTypeId == 'cat') {
                        //   //                     print(element.filterTypeId);
                        //   //                     element.filterTypeValue!.clear();
                        //   //                   }
                        //   //                 });
                        //   //               }
                        //   //               Get.to(() => ProductsByBrands(
                        //   //                     brandId: slider.dataId!,
                        //   //                   ));
                        //   //             } else if (slider.dataType ==
                        //   //                 SliderDataType.TAG) {
                        //   //               print('tag -- ${slider.tag!.name}');
                        //   //
                        //   //               Get.to(() => ProductsByTags(
                        //   //                     tagName: slider.tag!.name!,
                        //   //                     tagId: slider.tag!.id!,
                        //   //                   ));
                        //   //             }
                        //   //           },
                        //   //           pagination: SwiperPagination(
                        //   //               margin: EdgeInsets.all(5.0),
                        //   //               builder: SwiperCustomPagination(builder:
                        //   //                   (BuildContext context,
                        //   //                       SwiperPluginConfig config) {
                        //   //                 return Align(
                        //   //                   alignment: Alignment.bottomCenter,
                        //   //                   child: RectSwiperPaginationBuilder(
                        //   //                     color:
                        //   //                         Colors.white.withOpacity(0.5),
                        //   //                     activeColor: Colors.white,
                        //   //                     size: Size(5.0, 5.0),
                        //   //                     activeSize: Size(20.0, 5.0),
                        //   //                   ).build(context, config),
                        //   //                 );
                        //   //               })),
                        //   //         ),
                        //   //       ),
                        //   //     );
                        //   //   } else {
                        //   //     return SizedBox.shrink();
                        //   //   }
                        //   // }
                        // }),
                        15.verticalSpace,

                        ///** CATEGORY
                        Obx(() {
                          if (!_homeController.isHomePageLoading.value) {
                            if (_homeController
                                    .homePageModel
                                    .value
                                    .topCategories
                                    ?.isEmpty ??
                                false) {
                              return SizedBox();
                            }
                            return ListView(
                              shrinkWrap: true,
                              padding: EdgeInsets.zero,
                              physics: NeverScrollableScrollPhysics(),
                              children: [
                                HomeTitlesWidget(
                                  title: 'Categories'.tr,
                                  btnOnTap: () {
                                    Get.to(() => AllCategorySubCategory());
                                  },
                                  showDeal: false,
                                ),
                                Container(
                                  child:
                                      _homeController
                                                  .homePageModel
                                                  .value
                                                  .topCategories ==
                                              null ||
                                          _homeController
                                              .homePageModel
                                              .value
                                              .topCategories!
                                              .isEmpty
                                      ? SizedBox()
                                      : GridView.builder(
                                          physics:
                                              NeverScrollableScrollPhysics(),
                                          shrinkWrap: true,
                                          gridDelegate:
                                              SliverGridDelegateWithFixedCrossAxisCountAndFixedHeight(
                                                crossAxisCount: 4,
                                                crossAxisSpacing: 15,
                                                mainAxisSpacing: 10,
                                                height: 110.w,
                                              ),
                                          itemCount: _homeController
                                              .homePageModel
                                              .value
                                              .topCategories!
                                              .length,
                                          itemBuilder: (context, index) {
                                            CategoryBrand category =
                                                _homeController
                                                    .homePageModel
                                                    .value
                                                    .topCategories![index];
                                            return Column(
                                              crossAxisAlignment:
                                                  CrossAxisAlignment.center,
                                              children: [
                                                InkWell(
                                                  customBorder: CircleBorder(),
                                                  onTap: () async {
                                                    _homeController
                                                            .categoryId
                                                            .value =
                                                        category.id!;
                                                    _homeController
                                                        .categoryIdBeforeFilter
                                                        .value = category
                                                        .id!;
                                                    _homeController.allProds
                                                        .clear();
                                                    _homeController.subCats
                                                        .clear();
                                                    _homeController
                                                            .lastPage
                                                            .value =
                                                        false;
                                                    _homeController
                                                            .pageNumber
                                                            .value =
                                                        1;
                                                    _homeController
                                                            .category
                                                            .value =
                                                        CategoryData();
                                                    _homeController
                                                            .catAllData
                                                            .value =
                                                        SingleCategory();
                                                    // controller.dataFilter.value =
                                                    //     FilterFromCatModel();
                                                    _homeController
                                                        .getCategoryProducts();
                                                    _homeController
                                                        .getCategoryFilterData();
                                                    if (_homeController
                                                            .dataFilterCat
                                                            .value
                                                            .filterDataFromCat !=
                                                        null) {
                                                      _homeController
                                                          .dataFilterCat
                                                          .value
                                                          .filterDataFromCat!
                                                          .filterType!
                                                          .forEach((element) {
                                                            if (element.filterTypeId ==
                                                                    'brand' ||
                                                                element.filterTypeId ==
                                                                    'cat') {
                                                              print(
                                                                element
                                                                    .filterTypeId,
                                                              );
                                                              element
                                                                  .filterTypeValue!
                                                                  .clear();
                                                            }
                                                          });
                                                    }
                                                    _homeController
                                                            .filterRating
                                                            .value =
                                                        0.0;
                                                    Get.to(
                                                      () => ProductsByCategory(
                                                        categoryId:
                                                            category.id!,
                                                      ),
                                                    );
                                                  },
                                                  child: Container(
                                                    height: 60.w,
                                                    width: 60.w,
                                                    decoration: BoxDecoration(
                                                      gradient: selectColor(
                                                        index,
                                                      ),
                                                      shape: BoxShape.circle,
                                                    ),
                                                    child:
                                                        category.icon != null &&
                                                            (category.icon ??
                                                                    '')
                                                                .isNotEmpty
                                                        ? Icon(
                                                            FaCustomIcon.getFontAwesomeIcon(
                                                              category.icon!,
                                                            ),
                                                            color: Colors.white,
                                                            size: 22.w,
                                                          )
                                                        : Icon(
                                                            Icons
                                                                .list_alt_outlined,
                                                            color: Colors.white,
                                                            size: 22.w,
                                                          ),
                                                  ),
                                                ),
                                                Container(
                                                  height: 40.h,
                                                  child: Padding(
                                                    padding: EdgeInsets.only(
                                                      top: 5.0.h,
                                                    ),
                                                    child: Text(
                                                      category.name!,
                                                      textAlign:
                                                          TextAlign.center,
                                                      maxLines: 2,
                                                      style: AppStyles.appFont
                                                          .copyWith(
                                                            fontSize: 13.sp,
                                                            fontWeight:
                                                                FontWeight
                                                                    .normal,
                                                          ),
                                                    ),
                                                  ),
                                                ),
                                              ],
                                            );
                                          },
                                        ),
                                ),
                              ],
                            );
                          } else {
                            return Container(
                              margin: EdgeInsets.only(bottom: 10.h),
                              child: GridView.builder(
                                physics: NeverScrollableScrollPhysics(),
                                shrinkWrap: true,
                                gridDelegate:
                                    SliverGridDelegateWithFixedCrossAxisCount(
                                      crossAxisCount: 4,
                                      mainAxisSpacing: 10.0,
                                      crossAxisSpacing: 10.0,
                                      mainAxisExtent: 110.w,
                                    ),
                                itemCount: 8,
                                itemBuilder: (context, index) {
                                  return Container(
                                    child: ClipRRect(
                                      borderRadius: BorderRadius.all(
                                        Radius.circular(5),
                                      ),
                                      child: LoadingSkeleton(
                                        height: 80.h,
                                        width: 40.w,
                                        colors: [
                                          Colors.black.withOpacity(0.1),
                                          Colors.black.withOpacity(0.2),
                                        ],
                                      ),
                                    ),
                                  );
                                },
                              ),
                            );
                          }
                        }),

                        10.verticalSpace,

                        // ** NEW USER ZONE
                        Obx(() {
                          if (_homeController.isHomePageLoading.value) {
                            return Column(
                              children: [
                                ClipRRect(
                                  borderRadius: BorderRadius.all(
                                    Radius.circular(5.r),
                                  ),
                                  clipBehavior: Clip.antiAlias,
                                  child: Container(
                                    height: 80.h,
                                    alignment: Alignment.center,
                                    color: AppStyles.pinkColor,
                                    child: Row(
                                      crossAxisAlignment:
                                          CrossAxisAlignment.center,
                                      children: [
                                        15.horizontalSpace,
                                        Container(
                                          width: 50.w,
                                          height: 50.w,
                                          child: Image.asset(
                                            'assets/images/icon_gift_alt.png',
                                            fit: BoxFit.contain,
                                            width: 50.w,
                                            height: 50.w,
                                          ),
                                        ),
                                        15.horizontalSpace,
                                        Flexible(
                                          child: Column(
                                            crossAxisAlignment:
                                                CrossAxisAlignment.start,
                                            mainAxisAlignment:
                                                MainAxisAlignment.center,
                                            children: [
                                              Text(
                                                'New Users Zone!'.tr,
                                                overflow: TextOverflow.ellipsis,
                                                maxLines: 1,
                                                style: AppStyles.kFontWhite14w5
                                                    .copyWith(
                                                      fontWeight:
                                                          FontWeight.bold,
                                                      fontSize: 17.0.fontSize,
                                                    ),
                                              ),
                                              Text(
                                                '',
                                                maxLines: 1,
                                                style: AppStyles.kFontWhite14w5
                                                    .copyWith(
                                                      fontSize: 12.0.fontSize,
                                                    ),
                                              ),
                                            ],
                                          ),
                                        ),
                                        Spacer(),
                                        Container(
                                          height: 35.w,
                                          width: 35.w,
                                          alignment: Alignment.center,
                                          decoration: BoxDecoration(
                                            shape: BoxShape.circle,
                                            color: Colors.white,
                                          ),
                                          child: Icon(
                                            Icons.arrow_forward_ios,
                                            size: 14.w,
                                            color: AppStyles.pinkColor,
                                          ),
                                        ),
                                        15.horizontalSpace,
                                      ],
                                    ),
                                  ),
                                ),
                                10.verticalSpace,
                                ClipRRect(
                                  borderRadius: BorderRadius.all(
                                    Radius.circular(5),
                                  ),
                                  child: Container(
                                    height: 150.h,
                                    padding: EdgeInsets.all(4.w),
                                    color: AppStyles.lightBlueColorAlt,
                                    child: Row(
                                      children: [
                                        Expanded(
                                          flex: 2,
                                          child: Row(
                                            children: List.generate(2, (index) {
                                              return Expanded(
                                                child: Padding(
                                                  padding: EdgeInsets.symmetric(
                                                    horizontal: 4.w,
                                                  ),
                                                  child: ClipRRect(
                                                    borderRadius:
                                                        BorderRadius.all(
                                                          Radius.circular(5.r),
                                                        ),
                                                    child: Container(
                                                      decoration: BoxDecoration(
                                                        color: Colors.white,
                                                      ),
                                                      child: Column(
                                                        mainAxisAlignment:
                                                            MainAxisAlignment
                                                                .center,
                                                        crossAxisAlignment:
                                                            CrossAxisAlignment
                                                                .center,
                                                        children: [
                                                          10.verticalSpace,
                                                          LoadingSkeleton(
                                                            height: 70.h,
                                                            width: 80.w,
                                                            colors: [
                                                              Colors.black
                                                                  .withOpacity(
                                                                    0.1,
                                                                  ),
                                                              Colors.black
                                                                  .withOpacity(
                                                                    0.2,
                                                                  ),
                                                            ],
                                                          ),
                                                          10.verticalSpace,
                                                          LoadingSkeleton(
                                                            height: 20.h,
                                                            width: 80.w,
                                                            colors: [
                                                              Colors.black
                                                                  .withOpacity(
                                                                    0.1,
                                                                  ),
                                                              Colors.black
                                                                  .withOpacity(
                                                                    0.2,
                                                                  ),
                                                            ],
                                                          ),
                                                          5.verticalSpace,
                                                        ],
                                                      ),
                                                    ),
                                                  ),
                                                ),
                                              );
                                            }),
                                          ),
                                        ),
                                        2.horizontalSpace,
                                        ClipRRect(
                                          borderRadius: BorderRadius.all(
                                            Radius.circular(5.r),
                                          ),
                                          child: Container(
                                            width: Get.width * 0.35,
                                            decoration: BoxDecoration(
                                              color: AppStyles.pinkColor,
                                            ),
                                            child: Column(
                                              mainAxisSize: MainAxisSize.max,
                                              mainAxisAlignment:
                                                  MainAxisAlignment.center,
                                              children: [
                                                Text(
                                                  'Discount'.tr,
                                                  textAlign: TextAlign.center,
                                                  style: AppStyles
                                                      .kFontWhite14w5
                                                      .copyWith(
                                                        fontWeight:
                                                            FontWeight.bold,
                                                        fontSize: 14.0.fontSize,
                                                      ),
                                                ),
                                                5.verticalSpace,
                                                InkWell(
                                                  onTap: () {
                                                    Get.to(
                                                      () => NewUserZonePage(),
                                                    );
                                                  },
                                                  child: Container(
                                                    alignment: Alignment.center,
                                                    height: 30.h,
                                                    width: 80.w,
                                                    decoration: BoxDecoration(
                                                      color: Color(0xffFFD600),
                                                      borderRadius:
                                                          BorderRadius.all(
                                                            Radius.circular(
                                                              25.r,
                                                            ),
                                                          ),
                                                    ),
                                                    child: Text(
                                                      'Shop Now'.tr,
                                                      textAlign:
                                                          TextAlign.center,
                                                      style: AppStyles.appFont
                                                          .copyWith(
                                                            fontSize:
                                                                12.0.fontSize,
                                                          ),
                                                    ),
                                                  ),
                                                ),
                                              ],
                                            ),
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),
                                ),
                                5.verticalSpace,
                              ],
                            );
                          } else {
                            if (_homeController
                                        .homePageModel
                                        .value
                                        .newUserZone ==
                                    null ||
                                (_homeController
                                        .homePageModel
                                        .value
                                        .newUserZone
                                        ?.allProducts
                                        ?.isEmpty ??
                                    false)) {
                              return SizedBox();
                            } else {
                              return Column(
                                mainAxisAlignment: MainAxisAlignment.center,
                                crossAxisAlignment: CrossAxisAlignment.center,
                                children: [
                                  GestureDetector(
                                    onTap: () {
                                      Get.to(() => NewUserZonePage());
                                    },
                                    child: ClipRRect(
                                      borderRadius: BorderRadius.all(
                                        Radius.circular(5.r),
                                      ),
                                      clipBehavior: Clip.antiAlias,
                                      child: Container(
                                        height: 85.h,
                                        padding: EdgeInsets.symmetric(
                                          vertical: 5.h,
                                        ),
                                        alignment: Alignment.center,
                                        color: AppStyles.pinkColor,
                                        child: Row(
                                          crossAxisAlignment:
                                              CrossAxisAlignment.center,
                                          children: [
                                            15.horizontalSpace,
                                            Container(
                                              width: 50.w,
                                              height: 50.w,
                                              child: Image.asset(
                                                'assets/images/icon_gift_alt.png',
                                                fit: BoxFit.contain,
                                              ),
                                            ),
                                            15.horizontalSpace,
                                            Expanded(
                                              child: Column(
                                                crossAxisAlignment:
                                                    CrossAxisAlignment.start,
                                                mainAxisAlignment:
                                                    MainAxisAlignment.center,
                                                children: [
                                                  Text(
                                                    'New Users Zone!'.tr,
                                                    maxLines: 1,
                                                    style: AppStyles
                                                        .kFontWhite14w5
                                                        .copyWith(
                                                          fontWeight:
                                                              FontWeight.bold,
                                                          fontSize: 17.fontSize,
                                                          overflow: TextOverflow
                                                              .ellipsis,
                                                        ),
                                                  ),
                                                  Text(
                                                    '${_homeController.homePageModel.value.newUserZone!.title ?? ""}',
                                                    maxLines: 1,
                                                    style: AppStyles
                                                        .kFontWhite14w5
                                                        .copyWith(
                                                          fontSize: 12.fontSize,
                                                        ),
                                                    overflow:
                                                        TextOverflow.ellipsis,
                                                  ),
                                                ],
                                              ),
                                            ),
                                            5.horizontalSpace,
                                            Container(
                                              height: 35.w,
                                              width: 35.w,
                                              alignment: Alignment.center,
                                              decoration: BoxDecoration(
                                                shape: BoxShape.circle,
                                                color: Colors.white,
                                              ),
                                              child: Icon(
                                                Icons.arrow_forward_ios,
                                                size: 14.w,
                                                color: AppStyles.pinkColor,
                                              ),
                                            ),
                                            15.horizontalSpace,
                                          ],
                                        ),
                                      ),
                                    ),
                                  ),
                                  10.verticalSpace,
                                  ClipRRect(
                                    borderRadius: BorderRadius.all(
                                      Radius.circular(5.r),
                                    ),
                                    child: Container(
                                      height: 150.h,
                                      padding: EdgeInsets.all(4.w),
                                      color: AppStyles.lightBlueColorAlt,
                                      child: Row(
                                        children: [
                                          Expanded(
                                            flex: 2,
                                            child: Row(
                                              children: List.generate(
                                                _homeController
                                                    .homePageModel
                                                    .value
                                                    .newUserZone!
                                                    .allProducts!
                                                    .length,
                                                (index) {
                                                  return Expanded(
                                                    child: GestureDetector(
                                                      behavior: HitTestBehavior
                                                          .translucent,
                                                      onTap: () async {
                                                        final ProductDetailsController
                                                        productDetailsController =
                                                            Get.put(
                                                              ProductDetailsController(),
                                                            );
                                                        await productDetailsController
                                                            .getProductDetails2(
                                                              _homeController
                                                                  .homePageModel
                                                                  .value
                                                                  .newUserZone!
                                                                  .allProducts![index]
                                                                  .product!
                                                                  .id,
                                                            );
                                                        Get.to(
                                                          () => ProductDetails(
                                                            productID:
                                                                _homeController
                                                                    .homePageModel
                                                                    .value
                                                                    .newUserZone!
                                                                    .allProducts![index]
                                                                    .product!
                                                                    .id ??
                                                                0,
                                                          ),
                                                        );
                                                      },
                                                      child: Padding(
                                                        padding:
                                                            EdgeInsets.symmetric(
                                                              horizontal: 4.w,
                                                            ),
                                                        child: ClipRRect(
                                                          borderRadius:
                                                              BorderRadius.all(
                                                                Radius.circular(
                                                                  5.r,
                                                                ),
                                                              ),
                                                          child: Container(
                                                            decoration:
                                                                BoxDecoration(
                                                                  color: Colors
                                                                      .white,
                                                                ),
                                                            child: Column(
                                                              children: [
                                                                10.verticalSpace,
                                                                Expanded(
                                                                  flex: 2,
                                                                  child: FancyShimmerImage(
                                                                    imageUrl:
                                                                        '${AppConfig.assetPath}/${_homeController.homePageModel.value.newUserZone!.allProducts![index].product!.product!.thumbnailImageSource}',
                                                                    boxFit: BoxFit
                                                                        .contain,
                                                                    errorWidget: FancyShimmerImage(
                                                                      imageUrl:
                                                                          "${AppConfig.assetPath}/backend/img/default.png",
                                                                      boxFit: BoxFit
                                                                          .contain,
                                                                    ),
                                                                  ),
                                                                ),
                                                                10.verticalSpace,
                                                                Expanded(
                                                                  flex: 1,
                                                                  child: Wrap(
                                                                    crossAxisAlignment:
                                                                        WrapCrossAlignment
                                                                            .center,
                                                                    children: [
                                                                      Text(
                                                                        currencyController.calculatePrice(
                                                                          _homeController.homePageModel.value.newUserZone?.allProducts?[index].product ??
                                                                              ProductModel(),
                                                                        ),
                                                                        overflow:
                                                                            TextOverflow.ellipsis,
                                                                        style: AppStyles
                                                                            .kFontPink15w5
                                                                            .copyWith(
                                                                              fontSize: 12.fontSize,
                                                                            ),
                                                                      ),
                                                                      3.horizontalSpace,
                                                                      if (!(_homeController
                                                                              .homePageModel
                                                                              .value
                                                                              .newUserZone!
                                                                              .allProducts![index]
                                                                              .product!
                                                                              .hasDiscount ==
                                                                          'no'))
                                                                        Text(
                                                                          currencyController.calculateMainPrice(
                                                                            _homeController.homePageModel.value.newUserZone!.allProducts![index].product!,
                                                                          ),
                                                                          style: AppStyles.kFontGrey12w5.copyWith(
                                                                            decoration:
                                                                                TextDecoration.lineThrough,
                                                                            fontSize:
                                                                                12.fontSize,
                                                                          ),
                                                                        ),
                                                                    ],
                                                                  ),
                                                                ),
                                                                5.verticalSpace,
                                                              ],
                                                            ),
                                                          ),
                                                        ),
                                                      ),
                                                    ),
                                                  );
                                                },
                                              ),
                                            ),
                                          ),
                                          2.horizontalSpace,
                                          ClipRRect(
                                            borderRadius: BorderRadius.all(
                                              Radius.circular(5.r),
                                            ),
                                            child: GestureDetector(
                                              behavior:
                                                  HitTestBehavior.translucent,
                                              onTap: () {
                                                Get.to(() => NewUserZonePage());
                                              },
                                              child: Container(
                                                width: Get.width * 0.35,
                                                decoration: BoxDecoration(
                                                  color: AppStyles.pinkColor,
                                                ),
                                                child: Column(
                                                  mainAxisSize:
                                                      MainAxisSize.max,
                                                  mainAxisAlignment:
                                                      MainAxisAlignment.center,
                                                  children: [
                                                    Text(
                                                      '${_homeController.homePageModel.value.newUserZone!.coupon!.discount}% ' +
                                                          'OFF'.tr,
                                                      textAlign:
                                                          TextAlign.center,
                                                      style: AppStyles
                                                          .kFontWhite14w5
                                                          .copyWith(
                                                            fontWeight:
                                                                FontWeight.bold,
                                                            fontSize:
                                                                14.fontSize,
                                                          ),
                                                    ),
                                                    Text(
                                                      '${_homeController.homePageModel.value.newUserZone!.coupon!.title}',
                                                      textAlign:
                                                          TextAlign.center,
                                                      style: AppStyles.appFont
                                                          .copyWith(
                                                            fontSize:
                                                                12.fontSize,
                                                            color: Colors.white,
                                                          ),
                                                    ),
                                                    5.verticalSpace,
                                                    InkWell(
                                                      onTap: () {
                                                        Get.to(
                                                          () =>
                                                              NewUserZonePage(),
                                                        );
                                                      },
                                                      child: Container(
                                                        padding:
                                                            EdgeInsets.symmetric(
                                                              horizontal: 2.w,
                                                            ),
                                                        alignment:
                                                            Alignment.center,
                                                        height: 30.h,
                                                        width: 85.w,
                                                        decoration: BoxDecoration(
                                                          color: Color(
                                                            0xffFFD600,
                                                          ),
                                                          borderRadius:
                                                              BorderRadius.all(
                                                                Radius.circular(
                                                                  25.r,
                                                                ),
                                                              ),
                                                        ),
                                                        child: Text(
                                                          'Shop Now'.tr,
                                                          textAlign:
                                                              TextAlign.center,
                                                          style: AppStyles
                                                              .appFont
                                                              .copyWith(
                                                                fontSize:
                                                                    12.fontSize,
                                                              ),
                                                        ),
                                                      ),
                                                    ),
                                                  ],
                                                ),
                                              ),
                                            ),
                                          ),
                                        ],
                                      ),
                                    ),
                                  ),
                                  5.verticalSpace,
                                ],
                              );
                            }
                          }
                        }),

                        // ** FLASH SALE
                        Obx(() {
                          if (_homeController.isHomePageLoading.value) {
                            return SizedBox();
                          } else {
                            if (_homeController.hasDeal.value) {
                              if (_homeController
                                      .homePageModel
                                      .value
                                      .flashDeal
                                      ?.allProducts
                                      ?.isEmpty ??
                                  true) {
                                return SizedBox();
                              }

                              return ListView(
                                shrinkWrap: true,
                                physics: NeverScrollableScrollPhysics(),
                                children: [
                                  HomeTitlesWidget(
                                    title:
                                        '${_homeController.dealsText.value.tr}  ',
                                    btnOnTap: () async {
                                      _homeController.flashProductData.clear();
                                      _homeController.flashPageNumber.value = 1;
                                      _homeController.lastFlashDealPage.value =
                                          false;
                                      await _homeController.getFlashDealsData();
                                      Get.to(() => FlashDealView());
                                    },
                                    dealDuration:
                                        _homeController.dealDuration.value,
                                    showDeal: true,
                                  ),
                                  Container(
                                    height: 160.h,
                                    child: ListView.separated(
                                      itemCount: _homeController
                                          .homePageModel
                                          .value
                                          .flashDeal!
                                          .allProducts!
                                          .length,
                                      shrinkWrap: true,
                                      separatorBuilder: (context, index) {
                                        return 5.horizontalSpace;
                                      },
                                      padding: EdgeInsets.zero,
                                      scrollDirection: Axis.horizontal,
                                      itemBuilder: (context, flashIndex) {
                                        FlashDealAllProduct flashDeal =
                                            _homeController
                                                .homePageModel
                                                .value
                                                .flashDeal!
                                                .allProducts![flashIndex];
                                        return InkWell(
                                          onTap: () {
                                            Get.to(
                                              () => ProductDetails(
                                                productID:
                                                    flashDeal.product!.id ?? 0,
                                              ),
                                            );
                                          },
                                          child: ClipRRect(
                                            borderRadius: BorderRadius.all(
                                              Radius.circular(5.r),
                                            ),
                                            child: Container(
                                              width: 105.w,
                                              color: Colors.white,
                                              child: Column(
                                                mainAxisAlignment:
                                                    MainAxisAlignment.start,
                                                crossAxisAlignment:
                                                    CrossAxisAlignment.start,
                                                children: [
                                                  Expanded(
                                                    child: ClipRRect(
                                                      borderRadius:
                                                          BorderRadius.all(
                                                            Radius.circular(
                                                              5.r,
                                                            ),
                                                          ),
                                                      child: Container(
                                                        height: 90.h,
                                                        child: Stack(
                                                          fit: StackFit.expand,
                                                          children: [
                                                            FancyShimmerImage(
                                                              imageUrl:
                                                                  "${AppConfig.assetPath}/${flashDeal.product!.product!.thumbnailImageSource}",
                                                              boxFit: BoxFit
                                                                  .contain,
                                                              errorWidget:
                                                                  FancyShimmerImage(
                                                                    imageUrl:
                                                                        "${AppConfig.assetPath}/backend/img/default.png",
                                                                    boxFit: BoxFit
                                                                        .contain,
                                                                  ),
                                                            ),
                                                            flashDeal
                                                                        .product!
                                                                        .productType ==
                                                                    ProductType
                                                                        .GIFT_CARD
                                                                ? Positioned(
                                                                    top: 0,
                                                                    right: 0,
                                                                    child: Align(
                                                                      alignment:
                                                                          Alignment
                                                                              .topRight,
                                                                      child:
                                                                          flashDeal.product!.giftCardEndDate!.compareTo(
                                                                                DateTime.now(),
                                                                              ) >
                                                                              0
                                                                          ? Container(
                                                                              padding: EdgeInsets.all(
                                                                                4.w,
                                                                              ),
                                                                              alignment: Alignment.center,
                                                                              decoration: BoxDecoration(
                                                                                color: AppStyles.pinkColor,
                                                                              ),
                                                                              child: Text(
                                                                                flashDeal.product!.discountType ==
                                                                                            "0" ||
                                                                                        flashDeal.product!.discountType ==
                                                                                            0
                                                                                    ? '-${flashDeal.product!.discount.toString()}% '
                                                                                    : '${(flashDeal.product!.discount! * currencyController.conversionRate.value).toStringAsFixed(2)}${currencyController.appCurrency.value} ',
                                                                                textAlign: TextAlign.center,
                                                                                style: AppStyles.appFont.copyWith(
                                                                                  color: Colors.white,
                                                                                  fontSize: 12.fontSize,
                                                                                  fontWeight: FontWeight.w500,
                                                                                ),
                                                                              ),
                                                                            )
                                                                          : SizedBox.shrink(),
                                                                    ),
                                                                  )
                                                                : Positioned(
                                                                    top: 0,
                                                                    right: 0,
                                                                    child: Align(
                                                                      alignment:
                                                                          Alignment
                                                                              .topRight,
                                                                      child:
                                                                          flashDeal.product!.hasDeal !=
                                                                              null
                                                                          ? flashDeal.product!.hasDeal!.discount! >
                                                                                    0
                                                                                ? Container(
                                                                                    padding: EdgeInsets.all(
                                                                                      4,
                                                                                    ),
                                                                                    alignment: Alignment.center,
                                                                                    decoration: BoxDecoration(
                                                                                      color: AppStyles.pinkColor,
                                                                                    ),
                                                                                    child: Text(
                                                                                      flashDeal.product!.hasDeal!.discountType ==
                                                                                              0
                                                                                          ? '${flashDeal.product!.hasDeal!.discount.toString()}% '
                                                                                          : '${(flashDeal.product!.hasDeal!.discount! * currencyController.conversionRate.value).toStringAsFixed(2)}${currencyController.appCurrency.value} ',
                                                                                      textAlign: TextAlign.center,
                                                                                      style: AppStyles.appFont.copyWith(
                                                                                        color: Colors.white,
                                                                                        fontSize: 12.fontSize,
                                                                                        fontWeight: FontWeight.w500,
                                                                                      ),
                                                                                    ),
                                                                                  )
                                                                                : Container()
                                                                          : flashDeal.product!.discountStartDate !=
                                                                                    null &&
                                                                                currencyController.endDate.millisecondsSinceEpoch <
                                                                                    DateTime.now().millisecondsSinceEpoch
                                                                          ? Container()
                                                                          : flashDeal.product!.discount! >
                                                                                0
                                                                          ? Container(
                                                                              padding: EdgeInsets.all(
                                                                                4.w,
                                                                              ),
                                                                              alignment: Alignment.center,
                                                                              decoration: BoxDecoration(
                                                                                color: AppStyles.pinkColor,
                                                                              ),
                                                                              child: Text(
                                                                                flashDeal.product!.discountType ==
                                                                                        "0"
                                                                                    ? '-${flashDeal.product!.discount.toString()}% '
                                                                                    : '${(flashDeal.product!.discount! * currencyController.conversionRate.value).toStringAsFixed(2)}${currencyController.appCurrency.value} ',
                                                                                textAlign: TextAlign.center,
                                                                                style: AppStyles.appFont.copyWith(
                                                                                  color: Colors.white,
                                                                                  fontSize: 12.fontSize,
                                                                                  fontWeight: FontWeight.w500,
                                                                                ),
                                                                              ),
                                                                            )
                                                                          : Container(),
                                                                    ),
                                                                  ),
                                                          ],
                                                        ),
                                                      ),
                                                    ),
                                                  ),
                                                  10.verticalSpace,
                                                  Container(
                                                    //   height: 1.h,
                                                    child: Stack(
                                                      fit: StackFit.loose,
                                                      alignment:
                                                          Alignment.centerLeft,
                                                      children: [
                                                        Container(
                                                          width:
                                                              double.maxFinite,
                                                          padding:
                                                              EdgeInsets.symmetric(
                                                                horizontal: 4.w,
                                                              ),
                                                          child:
                                                              flashDeal
                                                                      .product!
                                                                      .totalSale !=
                                                                  null
                                                              ? Text(
                                                                  ' ${flashDeal.product!.totalSale} ' +
                                                                      'Sold'.tr,
                                                                  style:
                                                                      flashDeal
                                                                              .product!
                                                                              .totalSale! >
                                                                          80
                                                                      ? AppStyles.appFont.copyWith(
                                                                          fontSize:
                                                                              12.fontSize,
                                                                          color:
                                                                              Colors.white,
                                                                        )
                                                                      : AppStyles.appFont.copyWith(
                                                                          fontSize:
                                                                              12.fontSize,
                                                                          color:
                                                                              Colors.black,
                                                                        ),
                                                                )
                                                              : Text(
                                                                  ' ${flashDeal.product!.totalSale} ' +
                                                                      'Sold'.tr,
                                                                  style: AppStyles
                                                                      .appFont
                                                                      .copyWith(
                                                                        fontSize:
                                                                            12.fontSize,
                                                                        color: Colors
                                                                            .black,
                                                                      ),
                                                                ),
                                                        ),
                                                      ],
                                                    ),
                                                  ),
                                                  Padding(
                                                    padding:
                                                        EdgeInsets.symmetric(
                                                          horizontal: 6.w,
                                                        ),
                                                    child: Wrap(
                                                      children: [
                                                        Text(
                                                          '${currencyController.calculatePrice(flashDeal.product!)}',
                                                          overflow: TextOverflow
                                                              .ellipsis,
                                                          style: AppStyles
                                                              .appFont
                                                              .copyWith(
                                                                fontSize:
                                                                    12.fontSize,
                                                                color: AppStyles
                                                                    .pinkColor,
                                                              ),
                                                        ),
                                                        5.horizontalSpace,
                                                        flashDeal
                                                                    .product!
                                                                    .hasDeal !=
                                                                null
                                                            ? flashDeal
                                                                          .product!
                                                                          .hasDeal!
                                                                          .discount! >
                                                                      0
                                                                  ? Text(
                                                                      currencyController.calculateMainPrice(
                                                                        flashDeal
                                                                            .product!,
                                                                      ),
                                                                      style: AppStyles.appFont.copyWith(
                                                                        decoration:
                                                                            TextDecoration.lineThrough,
                                                                        color: AppStyles
                                                                            .greyColorDark,
                                                                      ),
                                                                    )
                                                                  : Container()
                                                            : Text(
                                                                currencyController
                                                                    .calculateMainPrice(
                                                                      flashDeal
                                                                          .product!,
                                                                    ),
                                                                style: AppStyles
                                                                    .kFontGrey12w5
                                                                    .copyWith(
                                                                      decoration:
                                                                          TextDecoration
                                                                              .lineThrough,
                                                                    ),
                                                              ),
                                                      ],
                                                    ),
                                                  ),
                                                  10.verticalSpace,
                                                ],
                                              ),
                                            ),
                                          ),
                                        );
                                      },
                                    ),
                                  ),
                                  5.verticalSpace,
                                ],
                              );
                            } else {
                              return Container();
                            }
                          }
                        }),

                        //** BRANDS
                        Obx(() {
                          if (_homeController.isHomePageLoading.value) {
                            return ListView(
                              shrinkWrap: true,
                              physics: NeverScrollableScrollPhysics(),
                              children: [
                                HomeTitlesWidget(
                                  title: 'Brands'.tr,
                                  btnOnTap: () {
                                    Get.to(() => AllBrandsPage());
                                  },
                                  showDeal: false,
                                ),
                                ClipRRect(
                                  borderRadius: BorderRadius.all(
                                    Radius.circular(10.r),
                                  ),
                                  child: Container(
                                    color: AppStyles.lightBlueColorAlt,
                                    child: Container(
                                      padding: EdgeInsets.all(10.w),
                                      child: Container(
                                        child: GridView.builder(
                                          physics:
                                              NeverScrollableScrollPhysics(),
                                          shrinkWrap: true,
                                          gridDelegate:
                                              SliverGridDelegateWithFixedCrossAxisCount(
                                                crossAxisCount: 4,
                                                mainAxisSpacing: 10.0,
                                                crossAxisSpacing: 10.0,
                                                mainAxisExtent: 90,
                                              ),
                                          itemCount: 8,
                                          itemBuilder: (context, index) {
                                            return ClipRRect(
                                              borderRadius: BorderRadius.all(
                                                Radius.circular(5.w),
                                              ),
                                              child: LoadingSkeleton(
                                                width: 50,
                                                height: 40,
                                                colors: [
                                                  Colors.black.withOpacity(0.1),
                                                  Colors.black.withOpacity(0.2),
                                                ],
                                              ),
                                            );
                                          },
                                        ),
                                      ),
                                    ),
                                  ),
                                ),
                              ],
                            );
                          } else {
                            return ListView(
                              shrinkWrap: true,
                              physics: NeverScrollableScrollPhysics(),
                              children: [
                                HomeTitlesWidget(
                                  title: 'Brands'.tr,
                                  btnOnTap: () {
                                    Get.to(() => AllBrandsPage());
                                  },
                                  showDeal: false,
                                ),
                                ClipRRect(
                                  borderRadius: BorderRadius.all(
                                    Radius.circular(10.r),
                                  ),
                                  child: Container(
                                    color: AppStyles.lightBlueColorAlt,
                                    child: Container(
                                      height:
                                          _homeController.chunkedBrands.length >
                                              4
                                          ? 235.h
                                          : 130.h,
                                      padding: EdgeInsets.all(10.w),
                                      child: Container(
                                        child: Swiper.children(
                                          children: _homeController.chunkedBrands.chunked(8).map((
                                            e,
                                          ) {
                                            return GridView.builder(
                                              physics:
                                                  NeverScrollableScrollPhysics(),
                                              gridDelegate:
                                                  SliverGridDelegateWithFixedCrossAxisCount(
                                                    crossAxisCount: 4,
                                                    mainAxisSpacing: 10.0,
                                                    crossAxisSpacing: 10.0,
                                                    mainAxisExtent: 90.h,
                                                  ),
                                              itemBuilder: (context, index) {
                                                var brand = e[index];
                                                return InkWell(
                                                  onTap: () {
                                                    _homeController
                                                            .brandId
                                                            .value =
                                                        brand.id!;
                                                    _homeController
                                                        .allBrandProducts
                                                        .clear();
                                                    _homeController
                                                        .subCatsInBrands
                                                        .clear();
                                                    _homeController
                                                            .lastBrandPage
                                                            .value =
                                                        false;
                                                    _homeController
                                                            .brandPageNumber
                                                            .value =
                                                        1;
                                                    _homeController
                                                        .getBrandProducts();
                                                    _homeController
                                                        .getBrandFilterData();

                                                    if (_homeController
                                                            .dataFilterCat
                                                            .value
                                                            .filterDataFromCat !=
                                                        null) {
                                                      _homeController
                                                          .dataFilterCat
                                                          .value
                                                          .filterDataFromCat
                                                          ?.filterType
                                                          ?.forEach((element) {
                                                            if (element.filterTypeId ==
                                                                    'brand' ||
                                                                element.filterTypeId ==
                                                                    'cat') {
                                                              print(
                                                                element
                                                                    .filterTypeId,
                                                              );
                                                              element
                                                                  .filterTypeValue!
                                                                  .clear();
                                                            }
                                                          });
                                                    }
                                                    Get.to(
                                                      () => ProductsByBrands(
                                                        brandId: brand.id!,
                                                      ),
                                                    );
                                                  },
                                                  child: ClipRRect(
                                                    borderRadius:
                                                        BorderRadius.all(
                                                          Radius.circular(5.r),
                                                        ),
                                                    clipBehavior:
                                                        Clip.antiAlias,
                                                    child: Container(
                                                      color: Colors.white,
                                                      child: Column(
                                                        children: <Widget>[
                                                          Expanded(
                                                            child: Padding(
                                                              padding:
                                                                  EdgeInsets.all(
                                                                    6.w,
                                                                  ),
                                                              child:
                                                                  brand.logo !=
                                                                          null &&
                                                                      (brand.logo ??
                                                                              '')
                                                                          .isNotEmpty
                                                                  ? Container(
                                                                      child: FancyShimmerImage(
                                                                        imageUrl:
                                                                            AppConfig.assetPath +
                                                                            '/' +
                                                                            brand.logo!,
                                                                        boxFit:
                                                                            BoxFit.contain,
                                                                        errorWidget: FancyShimmerImage(
                                                                          imageUrl:
                                                                              "${AppConfig.assetPath}/backend/img/default.png",
                                                                          boxFit:
                                                                              BoxFit.contain,
                                                                        ),
                                                                      ),
                                                                    )
                                                                  : Container(
                                                                      child: Icon(
                                                                        Icons
                                                                            .list_alt,
                                                                        size: 22
                                                                            .w,
                                                                      ),
                                                                    ),
                                                            ),
                                                          ),
                                                          5.verticalSpace,
                                                          Padding(
                                                            padding: EdgeInsets.symmetric(
                                                              vertical:
                                                                  brand
                                                                          .name!
                                                                          .length <
                                                                      10
                                                                  ? 1.0
                                                                  : 0.0,
                                                              horizontal: 4.w,
                                                            ),
                                                            child: Text(
                                                              brand.name!,
                                                              textAlign:
                                                                  TextAlign
                                                                      .center,
                                                              maxLines: 2,
                                                              overflow:
                                                                  TextOverflow
                                                                      .ellipsis,
                                                              style: AppStyles
                                                                  .appFont
                                                                  .copyWith(
                                                                    fontSize: 12
                                                                        .fontSize,
                                                                    color: AppStyles
                                                                        .blackColor,
                                                                  ),
                                                            ),
                                                          ),
                                                          15.verticalSpace,
                                                        ],
                                                      ),
                                                    ),
                                                  ),
                                                );
                                              },
                                              itemCount: e.length,
                                            );
                                          }).toList(),
                                          loop: false,
                                          pagination: SwiperPagination(
                                            margin: EdgeInsets.zero,
                                            builder: SwiperCustomPagination(
                                              builder:
                                                  (
                                                    BuildContext context,
                                                    SwiperPluginConfig config,
                                                  ) {
                                                    return Align(
                                                      alignment: Alignment
                                                          .bottomCenter,
                                                      child:
                                                          RectSwiperPaginationBuilder(
                                                            color: Colors.white
                                                                .withOpacity(
                                                                  0.5,
                                                                ),
                                                            activeColor:
                                                                Colors.pink,
                                                            size: Size(
                                                              5.0.w,
                                                              5.0.h,
                                                            ),
                                                            activeSize: Size(
                                                              20.0.w,
                                                              5.0.h,
                                                            ),
                                                          ).build(
                                                            context,
                                                            config,
                                                          ),
                                                    );
                                                  },
                                            ),
                                          ),
                                        ),
                                      ),
                                    ),
                                  ),
                                ),
                              ],
                            );
                          }
                        }),

                        ///** TOP PICKS
                        Obx(() {
                          if (_homeController.isHomePageLoading.value) {
                            return Column(
                              children: [
                                30.verticalSpace,
                                ClipRRect(
                                  borderRadius: BorderRadius.all(
                                    Radius.circular(5.r),
                                  ),
                                  child: Container(
                                    child: LoadingSkeleton(
                                      height: 150.h,
                                      width: Get.width,
                                      colors: [
                                        Colors.black.withOpacity(0.1),
                                        Colors.black.withOpacity(0.2),
                                      ],
                                    ),
                                  ),
                                ),
                                15.verticalSpace,
                              ],
                            );
                          } else {
                            return Column(
                              children: [
                                HomeTitlesWidget(
                                  title: 'Top Picks'.tr,
                                  btnOnTap: () {
                                    Get.to(() => AllTopPickProducts());
                                  },
                                  showDeal: false,
                                ),
                                Container(
                                  height: 220.h,
                                  child:
                                      _homeController
                                              .homePageModel
                                              .value
                                              .topPicks !=
                                          null
                                      ? ListView.separated(
                                          itemCount: _homeController
                                              .homePageModel
                                              .value
                                              .topPicks!
                                              .take(8)
                                              .length,
                                          shrinkWrap: true,
                                          scrollDirection: Axis.horizontal,
                                          physics: BouncingScrollPhysics(),
                                          padding: EdgeInsets.zero,
                                          separatorBuilder: (context, index) {
                                            return 10.verticalSpace;
                                          },
                                          itemBuilder: (context, topPickIndex) {
                                            ProductModel prod = _homeController
                                                .homePageModel
                                                .value
                                                .topPicks![topPickIndex];
                                            return HorizontalProductWidget(
                                              productModel: prod,
                                            );
                                          },
                                        )
                                      : SizedBox(),
                                ),
                              ],
                            );
                          }
                        }),
                      ],
                    ),
                  ),

                  //** RECOMMENDED
                  SliverToBoxAdapter(
                    child: Padding(
                      padding: EdgeInsets.symmetric(vertical: 15.w),
                      child: Text(
                        'You might like'.tr,
                        textAlign: TextAlign.center,
                        style: AppStyles.appFont.copyWith(
                          color: AppStyles.blackColor,
                          fontSize: 16.fontSize,
                          fontWeight: FontWeight.w600,
                        ),
                      ),
                    ),
                  ),

                  LoadingMoreSliverList<ProductModel>(
                    SliverListConfig<ProductModel>(
                      padding: EdgeInsets.symmetric(horizontal: 8.w),
                      indicatorBuilder: BuildIndicatorBuilder(
                        source: _homeController.source,
                        isSliver: true,
                        name: 'Recommended Products'.tr,
                      ).buildIndicator,
                      extendedListDelegate:
                          SliverWaterfallFlowDelegateWithFixedCrossAxisCount(
                            crossAxisCount: 2,
                            crossAxisSpacing: 10,
                            mainAxisSpacing: 10,
                          ),
                      itemBuilder:
                          (BuildContext c, ProductModel prod, int index) {
                            return GridViewProductWidget(productModel: prod);
                          },
                      sourceList: _homeController.source!,
                    ),
                    key: const Key('homePageLoadMoreKey'),
                  ),
                  SliverToBoxAdapter(child: SizedBox(height: 100.h)),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }

  Widget _buildTopBannerSection() {
    return Obx(() {
      if (_homeController.isHomePageLoading.value) {
        return _buildBannerLoadingSkeleton();
      }

      // For mobile app, we'll create a sample banner for now
      // TODO: Later integrate with mobile admin panel API
      final sampleBanner = {
        'title': 'Welcome to SJ Fashion Hub Mobile App',
        'image':
            'https://sjfashionhub.com/storage/banners/7UgkSgbb2J6qgN6eR4uQDQLOXkDlUxcdsZmGeBt5.png',
        'link_type': 'none',
        'link_value': null,
      };

      return Container(
        margin: EdgeInsets.only(bottom: 8.h),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Banner title/label
            Container(
              padding: EdgeInsets.symmetric(horizontal: 4.w, vertical: 8.h),
              child: Row(
                children: [
                  Container(
                    width: 4.w,
                    height: 20.h,
                    decoration: BoxDecoration(
                      color: AppStyles.pinkColor,
                      borderRadius: BorderRadius.circular(2.r),
                    ),
                  ),
                  SizedBox(width: 8.w),
                  Text(
                    sampleBanner['title'] as String,
                    style: AppStyles.appFont.copyWith(
                      fontSize: 16.sp,
                      fontWeight: FontWeight.bold,
                      color: AppStyles.blackColor,
                    ),
                  ),
                ],
              ),
            ),

            // Banner image
            GestureDetector(
              onTap: () {
                _handleMobileBannerTap(sampleBanner);
              },
              child: Container(
                decoration: BoxDecoration(
                  borderRadius: BorderRadius.circular(12.r),
                  boxShadow: [
                    BoxShadow(
                      color: Colors.black.withOpacity(0.1),
                      spreadRadius: 1,
                      blurRadius: 8,
                      offset: Offset(0, 4),
                    ),
                  ],
                ),
                child: ClipRRect(
                  borderRadius: BorderRadius.circular(12.r),
                  child: AspectRatio(
                    aspectRatio: 16 / 6,
                    child: FancyShimmerImage(
                      imageUrl: sampleBanner['image'] as String,
                      boxFit: BoxFit.cover,
                      width: Get.width,
                      errorWidget: Container(
                        color: Colors.grey[200],
                        child: Column(
                          mainAxisAlignment: MainAxisAlignment.center,
                          children: [
                            Icon(
                              Icons.image_not_supported,
                              size: 48.w,
                              color: Colors.grey[400],
                            ),
                            SizedBox(height: 8.h),
                            Text(
                              'Banner Image',
                              style: AppStyles.appFont.copyWith(
                                fontSize: 14.sp,
                                color: Colors.grey[600],
                              ),
                            ),
                          ],
                        ),
                      ),
                    ),
                  ),
                ),
              ),
            ),

            // Banner subtitle if needed
            SizedBox(height: 8.h),
            Container(
              padding: EdgeInsets.symmetric(horizontal: 4.w),
              child: Text(
                'Managed by Mobile Admin Panel',
                style: AppStyles.appFont.copyWith(
                  fontSize: 12.sp,
                  fontWeight: FontWeight.w400,
                  color: Colors.grey[600],
                ),
                maxLines: 1,
                overflow: TextOverflow.ellipsis,
              ),
            ),
          ],
        ),
      );
    });
  }

  Widget _buildBannerLoadingSkeleton() {
    return Container(
      margin: EdgeInsets.only(bottom: 8.h),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Title skeleton
          Container(
            padding: EdgeInsets.symmetric(horizontal: 4.w, vertical: 8.h),
            child: Row(
              children: [
                Container(
                  width: 4.w,
                  height: 20.h,
                  decoration: BoxDecoration(
                    color: Colors.grey[300],
                    borderRadius: BorderRadius.circular(2.r),
                  ),
                ),
                SizedBox(width: 8.w),
                Container(
                  width: 120.w,
                  height: 16.h,
                  decoration: BoxDecoration(
                    color: Colors.grey[300],
                    borderRadius: BorderRadius.circular(4.r),
                  ),
                ),
              ],
            ),
          ),

          // Banner skeleton
          ClipRRect(
            borderRadius: BorderRadius.circular(12.r),
            child: AspectRatio(
              aspectRatio: 16 / 6,
              child: LoadingSkeleton(
                height: 150.h,
                width: Get.width,
                colors: [
                  Colors.black.withOpacity(0.1),
                  Colors.black.withOpacity(0.2),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  void _handleBannerTap(HomePageSlider banner) {
    if (banner.dataType == SliderDataType.PRODUCT) {
      // Navigate to product details
      // You can implement product navigation here
      print('Navigate to product: ${banner.dataId}');
    } else if (banner.dataType == SliderDataType.CATEGORY) {
      // Navigate to category
      if (banner.category != null) {
        Get.to(() => ProductsByCategory(categoryId: banner.category!.id!));
      }
    } else if (banner.dataType == SliderDataType.BRAND) {
      // Navigate to brand
      if (banner.brand != null) {
        Get.to(() => ProductsByBrands(brandId: banner.brand!.id!));
      }
    } else if (banner.dataType == SliderDataType.TAG) {
      // Navigate to tag
      if (banner.tag != null) {
        Get.to(
          () => ProductsByTags(
            tagId: banner.tag!.id!,
            tagName: banner.tag!.name!,
          ),
        );
      }
    }
  }

  Widget _buildShopByCategorySection() {
    return Obx(() {
      if (_homeController.isHomePageLoading.value) {
        return _buildCategoryLoadingSkeleton();
      }

      // Get featured categories from mobile admin panel
      // For now using the first 4 categories, later will integrate with API
      final featuredCategories = [
        {
          'id': 22,
          'name': '2 Pcs Set',
          'slug': '2-pcs-set',
          'image': null,
          'products_count': 4,
        },
        {
          'id': 23,
          'name': '3 Pcs Set',
          'slug': '3-pcs-set',
          'image': null,
          'products_count': 23,
        },
        {
          'id': 24,
          'name': 'Blouse',
          'slug': 'blouse',
          'image': null,
          'products_count': 9,
        },
        {
          'id': 31,
          'name': 'Kurti',
          'slug': 'kurti',
          'image': null,
          'products_count': 3,
        },
      ];

      return Container(
        margin: EdgeInsets.only(bottom: 8.h),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Section title with pink accent
            Container(
              padding: EdgeInsets.symmetric(horizontal: 4.w, vertical: 8.h),
              child: Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Row(
                    children: [
                      Container(
                        width: 4.w,
                        height: 20.h,
                        decoration: BoxDecoration(
                          color: AppStyles.pinkColor,
                          borderRadius: BorderRadius.circular(2.r),
                        ),
                      ),
                      SizedBox(width: 8.w),
                      Text(
                        'Shop by Category',
                        style: AppStyles.appFont.copyWith(
                          fontSize: 16.sp,
                          fontWeight: FontWeight.bold,
                          color: AppStyles.blackColor,
                        ),
                      ),
                    ],
                  ),
                  // View All button
                  GestureDetector(
                    onTap: () {
                      Get.to(() => FeaturedCategoriesPage());
                    },
                    child: Text(
                      'View All',
                      style: AppStyles.appFont.copyWith(
                        fontSize: 14.sp,
                        fontWeight: FontWeight.w600,
                        color: AppStyles.pinkColor,
                      ),
                    ),
                  ),
                ],
              ),
            ),

            // Categories grid (2x2)
            Container(
              padding: EdgeInsets.symmetric(horizontal: 4.w),
              child: GridView.builder(
                shrinkWrap: true,
                physics: NeverScrollableScrollPhysics(),
                gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                  crossAxisCount: 2,
                  crossAxisSpacing: 12.w,
                  mainAxisSpacing: 12.h,
                  childAspectRatio: 1.2,
                ),
                itemCount: featuredCategories.length,
                itemBuilder: (context, index) {
                  final category = featuredCategories[index];
                  return _buildCategoryCard(category);
                },
              ),
            ),
          ],
        ),
      );
    });
  }

  Widget _buildCategoryCard(Map<String, dynamic> category) {
    return GestureDetector(
      onTap: () => _handleCategoryTap(category),
      child: Container(
        decoration: BoxDecoration(
          borderRadius: BorderRadius.circular(12.r),
          boxShadow: [
            BoxShadow(
              color: Colors.black.withOpacity(0.08),
              spreadRadius: 1,
              blurRadius: 6,
              offset: Offset(0, 2),
            ),
          ],
        ),
        child: ClipRRect(
          borderRadius: BorderRadius.circular(12.r),
          child: Stack(
            children: [
              // Category image placeholder
              Container(
                color: Colors.grey[300],
                child: Center(
                  child: Icon(
                    Icons.category,
                    color: Colors.grey[600],
                    size: 40,
                  ),
                ),
              ),
              // Gradient overlay
              Container(
                decoration: BoxDecoration(
                  gradient: LinearGradient(
                    begin: Alignment.topCenter,
                    end: Alignment.bottomCenter,
                    colors: [Colors.transparent, Colors.black.withOpacity(0.7)],
                  ),
                ),
              ),
              // Category info
              Positioned(
                bottom: 8.h,
                left: 8.w,
                right: 8.w,
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    Text(
                      category['name'] as String,
                      style: AppStyles.appFont.copyWith(
                        fontSize: 14.sp,
                        fontWeight: FontWeight.bold,
                        color: Colors.white,
                      ),
                      maxLines: 1,
                      overflow: TextOverflow.ellipsis,
                    ),
                    SizedBox(height: 2.h),
                    Text(
                      '${category['products_count']} Products',
                      style: AppStyles.appFont.copyWith(
                        fontSize: 12.sp,
                        fontWeight: FontWeight.w400,
                        color: Colors.white.withOpacity(0.9),
                      ),
                    ),
                  ],
                ),
              ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildCategoryLoadingSkeleton() {
    return Container(
      margin: EdgeInsets.only(bottom: 8.h),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Title skeleton
          Container(
            padding: EdgeInsets.symmetric(horizontal: 4.w, vertical: 8.h),
            child: Row(
              children: [
                Container(
                  width: 4.w,
                  height: 20.h,
                  decoration: BoxDecoration(
                    color: Colors.grey[300],
                    borderRadius: BorderRadius.circular(2.r),
                  ),
                ),
                SizedBox(width: 8.w),
                Container(
                  width: 120.w,
                  height: 16.h,
                  decoration: BoxDecoration(
                    color: Colors.grey[300],
                    borderRadius: BorderRadius.circular(4.r),
                  ),
                ),
              ],
            ),
          ),
          // Grid skeleton
          Container(
            padding: EdgeInsets.symmetric(horizontal: 4.w),
            child: GridView.builder(
              shrinkWrap: true,
              physics: NeverScrollableScrollPhysics(),
              gridDelegate: SliverGridDelegateWithFixedCrossAxisCount(
                crossAxisCount: 2,
                crossAxisSpacing: 12.w,
                mainAxisSpacing: 12.h,
                childAspectRatio: 1.2,
              ),
              itemCount: 4,
              itemBuilder: (context, index) {
                return Container(
                  decoration: BoxDecoration(
                    color: Colors.grey[300],
                    borderRadius: BorderRadius.circular(12.r),
                  ),
                );
              },
            ),
          ),
        ],
      ),
    );
  }

  void _handleCategoryTap(Map<String, dynamic> category) {
    // Navigate to category products page
    final categoryId = category['id'] as int;
    Get.to(() => ProductsByCategory(categoryId: categoryId));
  }

  void _handleMobileBannerTap(Map<String, dynamic> banner) {
    // Handle mobile banner tap based on link_type
    final linkType = banner['link_type'] as String?;
    final linkValue = banner['link_value'] as String?;

    if (linkType == 'none' || linkValue == null) {
      // No action for banners without links
      print('Banner tapped: ${banner['title']} (no link)');
      return;
    }

    // TODO: Implement navigation based on link_type
    // - 'product': Navigate to product detail
    // - 'category': Navigate to category page
    // - 'url': Open external URL
    // - 'screen': Navigate to specific app screen
    print('Banner tapped: ${banner['title']} -> $linkType: $linkValue');
  }
}
