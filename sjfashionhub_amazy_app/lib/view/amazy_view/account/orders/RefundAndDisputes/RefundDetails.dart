import 'package:sjfashionhub/AppConfig/app_config.dart';
import 'package:sjfashionhub/controller/settings_controller.dart';
import 'package:sjfashionhub/model/NewModel/Order/OrderRefundModel.dart';
import 'package:sjfashionhub/utils/styles.dart';
import 'package:fancy_shimmer_image/fancy_shimmer_image.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';
import 'package:get/get.dart';
import 'package:loading_more_list/loading_more_list.dart';
import '../../../../../model/NewModel/Order/Package.dart';
import '../../../../../model/NewModel/Product/ProductModel.dart';
import '../../../../../widgets/amazy_widget/AppBarWidget.dart';
import '../../../../../widgets/amazy_widget/BuildIndicatorBuilder.dart';
import '../../../../../widgets/amazy_widget/CustomDate.dart';
import '../../../../../widgets/amazy_widget/single_product_widgets/GridViewProductWidget.dart';
import '../../../products/RecommendedProductLoadMore.dart';
import '../../../products/product/product_details.dart';


class RefundDetails extends StatefulWidget {
  final RefundOrder? refundOrder;

  RefundDetails({this.refundOrder});

  @override
  _RefundDetailsState createState() => _RefundDetailsState();
}

class _RefundDetailsState extends State<RefundDetails> {
  final GeneralSettingsController currencyController =
  Get.put(GeneralSettingsController());

  String deliverStateName(Package package) {
    var deliveryStatus;
    package.processes?.forEach((element) {
      if (element.id == package.deliveryStatus) {
        deliveryStatus = element.name;
      } else if (package.deliveryStatus == 0) {
        deliveryStatus = "";
      }
    });
    return deliveryStatus;
  }

  bool checkReview(Package package) {
    // print(package.deliveryStates);
    if (package.deliveryStates?.length != 0) {
      // print('${package.processes.last.id} == ${package.deliveryStatus}');
      if (package.processes?.last.id == package.deliveryStatus) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  RecommendedProductsLoadMore? source;

  @override
  void initState() {
    source = RecommendedProductsLoadMore();

    super.initState();
  }

  @override
  void dispose() {
    source?.dispose();

    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: AppStyles.appBackgroundColor,
      appBar: AppBarWidget(title: 'Refund Details'.tr),
      body: LoadingMoreCustomScrollView(
        reverse: false,
        showGlowLeading: false,
        physics: const ClampingScrollPhysics(),
        slivers: [
          SliverToBoxAdapter(
            child: Container(
              color: Colors.white,
              child: ListView(
                padding: EdgeInsets.symmetric(horizontal: 20, vertical: 15),
                shrinkWrap: true,
                physics: const NeverScrollableScrollPhysics(),
                children: [
                  Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            widget
                                .refundOrder?.order?.orderNumber?.capitalizeFirst ?? '',
                            style: AppStyles.kFontBlack15w4,
                          ),
                          SizedBox(
                            height: 5.2.h,
                          ),
                          Text(
                            'Request Sent Date'.tr +
                                ': ' +
                                CustomDate().formattedDateTime(
                                    widget.refundOrder?.createdAt),
                            style: AppStyles.kFontBlack12w4,
                          ),
                          SizedBox(
                            height: 5.2.h,
                          ),
                          Text(
                            'Order Date'.tr +
                                ': ' +
                                CustomDate().formattedDateTime(
                                    widget.refundOrder?.order?.createdAt),
                            style: AppStyles.kFontBlack12w4,
                          ),
                          SizedBox(
                            height: 5.2.h,
                          ),
                          Text('Refund Method'.tr + ': ' + widget.refundOrder!.refundMethod!.replaceAll("_", ' ').capitalizeFirst!,
                            style: AppStyles.kFontBlack12w4,
                          ),
                          SizedBox(
                            height: 5.2.h,
                          ),
                          Text(
                            'Shipping Type'.tr +
                                ': ' +
                                widget.refundOrder!.shippingMethod
                                !.replaceAll("_", ' ')
                                    .capitalizeFirst!,
                            style: AppStyles.kFontBlack12w4,
                          ),
                        ],
                      ),
                      Expanded(child: Container()),
                      Text(
                        '${widget.refundOrder?.checkConfirmed}'.tr,
                        style: AppStyles.kFontDarkBlue12w5,
                      ),
                    ],
                  ),
                  SizedBox(
                    height: 10.h,
                  ),
                  ListView.builder(
                      shrinkWrap: true,
                      physics: NeverScrollableScrollPhysics(),
                      itemCount: widget.refundOrder?.refundDetails?.length,
                      itemBuilder: (context, packageIndex) {
                        return Container(
                          padding: EdgeInsets.symmetric(vertical: 10.h),
                          child: Column(
                            mainAxisAlignment: MainAxisAlignment.start,
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Row(
                                mainAxisAlignment:
                                MainAxisAlignment.spaceBetween,
                                crossAxisAlignment: CrossAxisAlignment.start,
                                children: [
                                  Expanded(
                                    child: Column(
                                      mainAxisAlignment:
                                      MainAxisAlignment.start,
                                      crossAxisAlignment:
                                      CrossAxisAlignment.start,
                                      children: [
                                        Row(
                                          children: [
                                            Image.asset(
                                              'assets/images/icon_delivery-parcel.png',
                                              width: 17.w,
                                              height: 17.w,
                                            ),
                                            SizedBox(
                                              width: 8.w,
                                            ),
                                            Text(
                                              widget
                                                  .refundOrder
                                                  ?.refundDetails?[packageIndex]
                                                  .orderPackage
                                                  ?.packageCode ?? '',
                                              style: AppStyles.kFontBlack14w5,
                                            ),
                                          ],
                                        ),
                                        Padding(
                                          padding: EdgeInsets.only(
                                              left: 26.0, top: 5),
                                          child: Text(
                                            'Sold by'.tr + ': ' + '${widget.refundOrder?.refundDetails?[packageIndex].seller?.firstName}',
                                            style: AppStyles.kFontBlack14w5,
                                          ),
                                        ),
                                        Padding(
                                          padding: EdgeInsets.only(
                                              left: 26.0, top: 5),
                                          child: Text(widget.refundOrder?.refundDetails?[packageIndex].orderPackage?.shippingDate ?? '',
                                            style: AppStyles.kFontBlack12w4,
                                          ),
                                        ),
                                      ],
                                    ),
                                  ),
                                ],
                              ),
                              SizedBox(
                                height: 15.h,
                              ),
                              ListView.separated(
                                  separatorBuilder: (context, index) {
                                    return Divider(
                                      color: AppStyles.appBackgroundColor,
                                      height: 2.h,
                                      thickness: 2,
                                    );
                                  },
                                  shrinkWrap: true,
                                  padding: EdgeInsets.only(left: 26.0),
                                  physics: NeverScrollableScrollPhysics(),
                                  itemCount: widget
                                      .refundOrder
                                      ?.refundDetails?[packageIndex]
                                      .refundProducts
                                      ?.length ?? 0,
                                  itemBuilder: (context, productIndex) {
                                    return GestureDetector(
                                      onTap: () {
                                        Get.to(() => ProductDetails(
                                          productID: widget.refundOrder?.refundDetails?[packageIndex].refundProducts?[productIndex].sellerProductSku?.product?.id??0,
                                        ));
                                      },
                                      child: Container(
                                        margin:
                                        EdgeInsets.symmetric(vertical: 10),
                                        child: Row(
                                          crossAxisAlignment:
                                          CrossAxisAlignment.start,
                                          children: [
                                            ClipRRect(
                                              borderRadius: BorderRadius.all(
                                                  Radius.circular(5.w)),
                                              child: Container(
                                                  height: 80.w,
                                                  width: 80.w,
                                                  color: Colors.white,
                                                  child: Image.network(
                                                    AppConfig.assetPath +
                                                        '/' +
                                                        '${widget.refundOrder?.refundDetails?[packageIndex].refundProducts?[productIndex].sellerProductSku?.product?.product?.thumbnailImageSource}',
                                                    fit: BoxFit.contain,
                                                  )),
                                            ),
                                            SizedBox(
                                              width: 15.w,
                                            ),
                                            Expanded(
                                              child: Container(
                                                child: Column(
                                                  mainAxisAlignment:
                                                  MainAxisAlignment.start,
                                                  crossAxisAlignment:
                                                  CrossAxisAlignment.start,
                                                  children: [
                                                    Text(
                                                      widget
                                                          .refundOrder
                                                          ?.refundDetails?[
                                                      packageIndex]
                                                          .refundProducts?[
                                                      productIndex]
                                                          .sellerProductSku
                                                          ?.product
                                                          ?.productName ?? '',
                                                      style: AppStyles
                                                          .kFontBlack14w5,
                                                    ),
                                                    ListView.builder(
                                                      shrinkWrap: true,
                                                      physics:
                                                      NeverScrollableScrollPhysics(),
                                                      itemCount: widget
                                                          .refundOrder
                                                          ?.refundDetails?[
                                                      packageIndex]
                                                          .refundProducts?[
                                                      productIndex]
                                                          .sellerProductSku
                                                          ?.productVariations
                                                          ?.length,
                                                      itemBuilder: (context,
                                                          variantIndex) {


                                                        var attribute = widget.refundOrder?.refundDetails?[packageIndex].refundProducts?[productIndex].sellerProductSku?.productVariations?[variantIndex].attribute;
                                                        var attributeValue = widget.refundOrder?.refundDetails?[packageIndex].refundProducts?[productIndex].sellerProductSku?.productVariations?[variantIndex].attributeValue;

                                                        return Text(
                                                          '${attribute?.name??""}'+
                                                              ': ${attributeValue?.name??attributeValue?.value??''}',
                                                          style: AppStyles
                                                              .kFontBlack12w4,
                                                        );

                                                      },
                                                    ),
                                                    Row(
                                                      mainAxisAlignment:
                                                      MainAxisAlignment
                                                          .start,
                                                      crossAxisAlignment:
                                                      CrossAxisAlignment
                                                          .center,
                                                      children: [
                                                        Text(
                                                          '${currencyController.setCurrentSymbolPosition(amount: ((widget.refundOrder?.refundDetails?[packageIndex].refundProducts?[productIndex].returnAmount??0) * currencyController.conversionRate.value).toStringAsFixed(2))}',
                                                          style: AppStyles
                                                              .kFontPink15w5,
                                                        ),
                                                        SizedBox(
                                                          width: 5.w,
                                                        ),
                                                        Text(
                                                          '(${widget.refundOrder?.refundDetails?[packageIndex].refundProducts?[productIndex].returnQty}x)',
                                                          style: AppStyles
                                                              .kFontBlack14w5,
                                                        ),
                                                      ],
                                                    ),
                                                    SizedBox(
                                                      height: 10.h,
                                                    ),
                                                  ],
                                                ),
                                              ),
                                            ),
                                          ],
                                        ),
                                      ),
                                    );
                                  }),
                            ],
                          ),
                        );
                      }),
                  widget.refundOrder?.pickUpAddressCustomer != null
                      ? Text(
                    'Courier Pickup Info'.tr,
                    style: AppStyles.kFontBlack15w6,
                  )
                      : Text(
                    'Drop off Info'.tr,
                    style: AppStyles.kFontBlack15w6,
                  ),
                  SizedBox(
                    height: 5.2,
                  ),
                  PickUpInfoWidget(
                    title: 'Shipping Method'.tr,
                    value: '${widget.refundOrder?.shippingGateway?.methodName}',
                  ),
                  widget.refundOrder?.pickUpAddressCustomer != null
                      ? Column(
                    crossAxisAlignment: CrossAxisAlignment.start,
                    children: [
                      SizedBox(
                        height: 5.2.h,
                      ),
                      PickUpInfoWidget(
                        title: 'Name'.tr,
                        value:
                        '${widget.refundOrder?.pickUpAddressCustomer?.name}',
                      ),
                      SizedBox(
                        height: 5.2.h,
                      ),
                      PickUpInfoWidget(
                        title: 'Email'.tr,
                        value:
                        '${widget.refundOrder?.pickUpAddressCustomer?.email}',
                      ),
                      SizedBox(
                        height: 5.2.h,
                      ),
                      PickUpInfoWidget(
                        title: 'Phone Number'.tr,
                        value:
                        '${widget.refundOrder?.pickUpAddressCustomer?.phone}',
                      ),
                      SizedBox(
                        height: 5.2.h,
                      ),
                      PickUpInfoWidget(
                        title: 'Address'.tr,
                        value:
                        '${widget.refundOrder?.pickUpAddressCustomer?.address}',
                      ),
                      SizedBox(
                        height: 5.2.h,
                      ),
                      PickUpInfoWidget(
                        title: 'City'.tr,
                        value:
                        '${widget.refundOrder?.pickUpAddressCustomer?.city}',
                      ),
                      SizedBox(
                        height: 5.2.h,
                      ),
                      PickUpInfoWidget(
                        title: 'State'.tr,
                        value:
                        '${widget.refundOrder?.pickUpAddressCustomer?.state}',
                      ),

                      SizedBox(
                        height: 5.2.h,
                      ),

                      PickUpInfoWidget(
                        title: 'Country'.tr,
                        value:
                        '${widget.refundOrder?.pickUpAddressCustomer?.country}',
                      ),
                      SizedBox(
                        height: 5.2.h,
                      ),
                      PickUpInfoWidget(
                        title: 'Postcode'.tr,
                        value:
                        '${widget.refundOrder?.pickUpAddressCustomer?.postalCode}',
                      ),
                      SizedBox(
                        height: 5.2.h,
                      ),
                    ],
                  )
                      : PickUpInfoWidget(
                    title: 'Drop off Address'.tr,
                    value: '${widget.refundOrder?.dropOffAddress ?? ""}',
                  ),
                  SizedBox(
                    height: 15.h,
                  ),
                ],
              ),
            ),
          ),
          SliverToBoxAdapter(
            child: Padding(
              padding: EdgeInsets.symmetric(vertical: 15.h),
              child: Text(
                'You might like'.tr,
                textAlign: TextAlign.center,
                style: AppStyles.appFont.copyWith(
                  color: AppStyles.blackColor,
                  fontSize: 16,
                  fontWeight: FontWeight.w600,
                ),
              ),
            ),
          ),
          LoadingMoreSliverList<ProductModel>(
            SliverListConfig<ProductModel>(
              padding: EdgeInsets.symmetric(horizontal: 8.w),
              indicatorBuilder: BuildIndicatorBuilder(
                source: source,
                isSliver: true,
                name: 'Recommended Products'.tr,
              ).buildIndicator,
              extendedListDelegate:
              SliverWaterfallFlowDelegateWithFixedCrossAxisCount(
                crossAxisCount: 2,
                crossAxisSpacing: 5,
                mainAxisSpacing: 5,
              ),
              itemBuilder: (BuildContext c, ProductModel prod, int index) {
                return GridViewProductWidget(
                  productModel: prod,
                  averageRating: 0,
                );
              },
              sourceList: source!,
            ),
            key: const Key('refundDetailsPageLoadMoreKey'),
          ),
        ],
      ),
    );
  }

  getPaidBy(RefundOrder order) {
    if (order.order?.paymentType == 1) {
      return 'Cash On Delivery';
    } else if (order.order?.paymentType == 2) {
      return 'Wallet';
    } else if (order.order?.paymentType == 3) {
      return 'PayPal';
    } else if (order.order?.paymentType == 4) {
      return 'Stripe';
    } else if (order.order?.paymentType == 5) {
      return 'PayStack';
    } else if (order.order?.paymentType == 6) {
      return 'Razorpay';
    } else if (order.order?.paymentType == 7) {
      return 'Bank Payment';
    } else if (order.order?.paymentType == 8) {
      return 'Instamojo';
    } else if (order.order?.paymentType == 9) {
      return 'PayTM';
    } else if (order.order?.paymentType == 10) {
      return 'Midtrans';
    } else if (order.order?.paymentType == 11) {
      return 'PayUMoney';
    } else if (order.order?.paymentType == 12) {
      return 'JazzCash';
    } else if (order.order?.paymentType == 13) {
      return 'Google Pay';
    } else if (order.order?.paymentType == 14) {
      return 'FlutterWave';
    }
  }
}

class PickUpInfoWidget extends StatelessWidget {
  final String? title;
  final String? value;

  PickUpInfoWidget({this.title, this.value});

  @override
  Widget build(BuildContext context) {
    return RichText(
      text: TextSpan(
        children: [
          TextSpan(
            text: '$title',
            style: AppStyles.kFontBlack12w4,
          ),
          TextSpan(
            text: ': $value',
            style: AppStyles.kFontGrey12w5,
          ),
        ],
      ),
    );
  }
}
