import 'package:amazcart/AppConfig/app_config.dart';
import 'package:amazcart/controller/home_controller.dart';
import 'package:amazcart/utils/styles.dart';
import 'package:amazcart/view/amazy_view/products/SearchPageMain.dart';
import 'package:amazcart/widgets/amazy_widget/cart_icon_widget.dart';
import 'package:amazcart/widgets/amazy_widget/custom_input_border.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';

import 'appbar_back_button.dart';

class CustomSliverAppBarWidget extends StatelessWidget {
  final bool showBack;
  final bool showCart;
  CustomSliverAppBarWidget(this.showBack, this.showCart);
  @override
  Widget build(BuildContext context) {
    final HomeController _homeController = Get.find<HomeController>();
    return SliverAppBar(
      backgroundColor: Color(0xff6E0200),
      titleSpacing: 0,
      expandedHeight: 70.h,
      automaticallyImplyLeading: false,
      stretch: false,
      pinned: true,
      floating: false,
      toolbarHeight: 80.h,
      forceElevated: false,
      scrolledUnderElevation: 0,
      elevation: 0,
      actions: [
        Container(),
      ],
      title: Row(
        children: [
          showBack
              ? AppBarBackButton()
              : Container(
                  height: 40.w,
                  width: 40.w,
                  margin: EdgeInsets.symmetric(horizontal: 8.w),
                  child: Image.asset(
                    "${AppConfig.appBarIcon}",
                    height: 40.w,
                    width: 40.w,
                    fit: BoxFit.contain,
                  ),
                ),
          SizedBox(width: 8),
          Expanded(
            child: GestureDetector(
              onTap: () {
                Get.to(() => SearchPageMain());
              },
              child: Container(
               // height: 40.w,
                child: TextField(
                  autofocus: true,
                  enabled: false,
                  textAlignVertical: TextAlignVertical.center,
                  keyboardType: TextInputType.text,
                  style:  AppStyles.appFont.copyWith(fontSize: 12.fontSize, color: AppStyles.greyColorDark,),
                  expands: false,

                  decoration: CustomInputBorder()
                      .inputDecorationAppBar(
                        '${AppConfig.appName}',
                      )
                      .copyWith(
                    hintStyle: AppStyles.appFont.copyWith(fontSize: 12.fontSize, color: AppStyles.blackColor,),
                    prefixIcon: CustomGradientOnChild(
                          child: Padding(
                            padding: EdgeInsets.only(left: 8),
                            child: Icon(
                              Icons.search,
                              color: AppStyles.pinkColor,
                              size: 16.w,
                            ),
                          ),
                        ),
                      ),
                ),
              ),
            ),
          ),
          SizedBox(width: 8),
          showCart
              ? CartIconWidget()
              : Container(
                  height: 40.w,
                  width: 40.w,
                  margin: const EdgeInsets.symmetric(horizontal: 2),
                  child: GestureDetector(
                      behavior: HitTestBehavior.translucent,
                      onTap: () {
                        print('open drawer');
                       scaffoldkey.value.currentState?.openDrawer();
                      },
                      child: Icon(
                        Icons.menu_rounded,
                        size: 30.w,
                      )),
                ),
          SizedBox(width: 8),
        ],
      ),
    );
  }
}
