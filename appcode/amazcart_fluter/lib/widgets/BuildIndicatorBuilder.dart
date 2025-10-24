import 'package:amazcart/AppConfig/app_config.dart';
import 'package:amazcart/utils/styles.dart';
import 'package:amazcart/widgets/PinkButtonWidget.dart';
import 'package:amazcart/widgets/custom_loading_widget.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';
import 'package:loading_more_list/loading_more_list.dart';

class BuildIndicatorBuilder {
  final dynamic source;
  final bool? isSliver;
  final String? name;

  BuildIndicatorBuilder({this.source, this.isSliver, this.name});

  Widget buildIndicator(BuildContext context, IndicatorStatus? status) {
    Widget widget;
    switch (status) {
      case IndicatorStatus.none:
        widget = Container(height: 0.0);
        break;

      case IndicatorStatus.loadingMoreBusying:
        widget = Center(child: SizedBox(width: 50.w, child: CustomLoadingWidget()));
        break;

      case IndicatorStatus.fullScreenBusying:
        widget = Container(
          margin: EdgeInsets.only(right: 0.0),
          child: Center(child: CustomLoadingWidget()),
        );
        if (isSliver == true) {
          widget = SliverFillRemaining(
            child: widget,
          );
        } else {
          widget = CustomScrollView(
            slivers: <Widget>[
              SliverFillRemaining(
                child: widget,
              )
            ],
          );
        }
        break;

      case IndicatorStatus.error:
        widget = Text('Error'.tr, style: AppStyles.kFontBlack14w5);

        widget = GestureDetector(
          onTap: () {
            source.errorRefresh();
          },
          child: widget,
        );

        break;

      case IndicatorStatus.fullScreenError:
        widget = ListView(
          physics: NeverScrollableScrollPhysics(),
          children: <Widget>[
            SizedBox(
              height: 30.h,
            ),
            CircleAvatar(
              foregroundColor: AppStyles.pinkColor,
              backgroundColor: AppStyles.pinkColor,
              radius: 30.r,
              child: Container(
                color: AppStyles.pinkColor,
                child: Image.asset(
                  AppConfig.appLogo,
                  width: 30.w,
                  height: 30.w,
                ),
              ),
            ),
            SizedBox(
              height: 20.h,
            ),
            Text(
              '- ${'No item found'.tr} - ',
              style: AppStyles.kFontBlack17w5,
              textAlign: TextAlign.center,
            ),
            SizedBox(
              height: 20.h,
            ),
            Padding(
              padding: EdgeInsets.symmetric(horizontal: 50.0.w),
              child: PinkButtonWidget(
                btnOnTap: () {
                  source.errorRefresh();
                },
                btnText: 'Reload'.tr,
              ),
            ),
          ],
        );
        if (isSliver == true) {
          widget = SliverFillRemaining(
            child: widget,
          );
        } else {
          widget = CustomScrollView(
            slivers: <Widget>[
              SliverFillRemaining(
                child: widget,
              )
            ],
          );
        }
        break;

      case IndicatorStatus.noMoreLoad:
        widget = Padding(
          padding: EdgeInsets.all(8.0.w),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text('- ${"End of Results".tr} - ',
                  style: AppStyles.kFontBlack14w5),
            ],
          ),
        );
        break;


      case IndicatorStatus.empty:
        widget = Column(
          crossAxisAlignment: CrossAxisAlignment.center,
          mainAxisAlignment: MainAxisAlignment.center,
          children: <Widget>[
            SizedBox(
              height: 30.w,
            ),
            CircleAvatar(
              foregroundColor: AppStyles.pinkColor,
              backgroundColor: AppStyles.pinkColor,
              radius: 30.r,
              child: Container(
                color: AppStyles.pinkColor,
                child: Image.asset(
                  AppConfig.appLogo,
                  width: 30.w,
                  height: 30.w,
                ),
              ),
            ),
            SizedBox(
              height: 20.h,
            ),
            Text(
              '- ${'No item found'.tr} - ',
              style: AppStyles.kFontBlack17w5,
              textAlign: TextAlign.center,
            ),
            SizedBox(
              height: 20.h,
            ),
            Padding(
              padding: EdgeInsets.symmetric(horizontal: 50.0.w),
              child: PinkButtonWidget(
                btnOnTap: () {
                  Get.back();
                },
                btnText: 'Continue Shopping'.tr,
              ),
            ),
          ],
        );
        if (isSliver == true) {
          widget = SliverToBoxAdapter(
            child: widget,
          );
        } else {
          widget = CustomScrollView(
            slivers: <Widget>[
              SliverFillRemaining(
                child: widget,
              )
            ],
          );
        }
        break;

       default :
         widget = Column(
           crossAxisAlignment: CrossAxisAlignment.center,
           mainAxisAlignment: MainAxisAlignment.center,
           children: <Widget>[
             SizedBox(
               height: 30.w,
             ),
             CircleAvatar(
               foregroundColor: AppStyles.pinkColor,
               backgroundColor: AppStyles.pinkColor,
               radius: 30.r,
               child: Container(
                 color: AppStyles.pinkColor,
                 child: Image.asset(
                   AppConfig.appLogo,
                   width: 30.w,
                   height: 30.w,
                 ),
               ),
             ),
             SizedBox(
               height: 20.h,
             ),
             Text(
               "Please Sign in or Register to view notifications".tr,
               style: AppStyles.kFontBlack17w5,
               textAlign: TextAlign.center,
             ),
             SizedBox(
               height: 20.h,
             ),
             Padding(
               padding: EdgeInsets.symmetric(horizontal: 50.0.w),
               child: PinkButtonWidget(
                 btnOnTap: () {

                 },
                 btnText: 'Sign in or Register'.tr,
               ),
             ),
           ],
         );
      }
    return widget;
  }
}
