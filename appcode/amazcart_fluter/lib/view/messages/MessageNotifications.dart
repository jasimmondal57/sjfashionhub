import 'dart:developer';

import 'package:amazcart/config/config.dart';
import 'package:amazcart/controller/login_controller.dart';
import 'package:amazcart/model/UserNotificationModel.dart';
import 'package:amazcart/utils/styles.dart';
import 'package:amazcart/widgets/BuildIndicatorBuilder.dart';
import 'package:amazcart/widgets/CustomDate.dart';
import 'package:amazcart/widgets/NotificationWidget.dart';
import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get_storage/get_storage.dart';
import 'package:loading_more_list/loading_more_list.dart';
import 'package:get/get.dart';

import '../../AppConfig/language/app_localizations.dart';

class MessageNotifications extends StatefulWidget {
  @override
  _MessageNotificationsState createState() => _MessageNotificationsState();
}

class _MessageNotificationsState extends State<MessageNotifications> {
  MessageNotificationLoadMore? source;

  @override
  void initState() {

    source = MessageNotificationLoadMore();

    super.initState();
  }

  @override
  void dispose() {
    super.dispose();
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
        title: Text(
          "Notifications".tr,
          style: AppStyles.appFont.copyWith(
            fontWeight: FontWeight.bold,
            color: AppStyles.blackColor,
            fontSize: 17.fontSize,
          ),
        ),
        actions: [Container()],
      ),
      body: Padding(
        padding: EdgeInsets.symmetric(vertical: 10.0.h, horizontal: 15.w),
        child: Obx((){

          if(!Get.find<LoginController>().loggedIn.value){
            return BuildIndicatorBuilder(source: null).buildIndicator(context, null);
          }
          return LoadingMoreList<NotificationData>(
            ListConfig<NotificationData>(
              shrinkWrap: true,
              padding: const EdgeInsets.all(0.0),
              physics: BouncingScrollPhysics(),
              indicatorBuilder: BuildIndicatorBuilder(
                source: source,
                isSliver: false,
                name: 'Notifications'.tr,
              ).buildIndicator,
              showGlowLeading: true,
              itemBuilder: (BuildContext c, NotificationData prod, int index) {
                return NotificationWidget(
                  notificationTitle: prod.order != null ? '${prod.order?.orderNumber?.capitalizeFirst}' : 'Notification'.tr,
                  notificationDate: '${CustomDate().formattedDateTime(prod.createdAt)}',
                  notificationBody: '${prod.title}',
                );
              },
              sourceList: source!,
            ),
          );
        }),
      ),
    );
  }
}

class MessageNotificationLoadMore extends LoadingMoreBase<NotificationData> {
  bool isSorted = false;
  String sortKey = 'new';

  int pageIndex = 1;
  bool _hasMore = true;
  bool forceRefresh = false;
  int productsLength = 0;

  @override
  bool get hasMore => (_hasMore && length < productsLength) || forceRefresh;

  @override
  Future<bool> refresh([bool clearBeforeRequest = false]) async {

    log("Notification refresh :::: ");
    _hasMore = true;
    pageIndex = 1;
    //force to refresh list when you don't want clear list before request
    //for the case, if your list already has 20 items.
    forceRefresh = !clearBeforeRequest;
    var result = await super.refresh(clearBeforeRequest);
    forceRefresh = false;
    return result;
  }

  @override
  Future<bool> loadData([bool isloadMoreAction = false]) async {
    Dio _dio = Dio();
    GetStorage userToken = GetStorage();
    var tokenKey = 'token';
    String token = await userToken.read(tokenKey)??'';

    if(token.isEmpty){
      return false;
    }

    bool isSuccess = false;
    try {
      //to show loading more clearly, in your app,remove this
      // await Future.delayed(Duration(milliseconds: 500));
      var result;
      UserNotificationModel source;
      print(URLs.USER_NOTIFICATIONS + '?lang=${AppLocalizations.getLanguageCode()}');

      if (this.length == 0) {
        result = await _dio.get(
          URLs.USER_NOTIFICATIONS + '?lang=${AppLocalizations.getLanguageCode()}',
          options: Options(
            headers: {
              'Content-Type': 'application/json',
              'Accept': 'application/json',
              'Authorization': 'Bearer $token',
            },
          ),
        );
      } else {
        result = await _dio.get(URLs.USER_NOTIFICATIONS + '?lang=${AppLocalizations.getLanguageCode()}',
            options: Options(
              headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': 'Bearer $token',
              },
            ),
            queryParameters: {
              'page': pageIndex,
            });
      }
      print(result.realUri);
      final data = new Map<String, dynamic>.from(result.data);
      source = UserNotificationModel.fromJson(data);
      productsLength = source.notifications?.total ?? 0;

      if (pageIndex == 1) {
        this.clear();
      }
      for (var item in source.notifications?.data ?? []) {
        this.add(item);
      }

      _hasMore = source.notifications?.data?.length != 0;
      pageIndex++;
      isSuccess = true;
    } catch (exception, stack) {
      isSuccess = false;
      print(exception);
      print(stack);
    }
    return isSuccess;
  }
}
