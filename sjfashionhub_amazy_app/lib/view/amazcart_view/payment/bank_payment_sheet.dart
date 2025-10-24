import 'dart:io';
import 'dart:developer';

import 'package:sjfashionhub/AppConfig/app_config.dart';
import 'package:sjfashionhub/config/config.dart';
import 'package:sjfashionhub/controller/payment_gateway_controller.dart';
import 'package:sjfashionhub/model/NewModel/BankPaymentResponse.dart';
import 'package:sjfashionhub/utils/styles.dart';
import 'package:sjfashionhub/widgets/amazcart_widget/PinkButtonWidget.dart';
import 'package:sjfashionhub/widgets/amazcart_widget/dio_exception.dart';
import 'package:sjfashionhub/widgets/amazcart_widget/snackbars.dart';
import 'package:file_picker/file_picker.dart';
import 'package:flutter/cupertino.dart';
import 'package:flutter/material.dart';
import 'package:flutter_screenutil/flutter_screenutil.dart';

import 'package:get/get.dart';
import 'package:dio/dio.dart' as DIO;
import 'package:get_storage/get_storage.dart';

class BankPaymentSheet extends StatefulWidget {
  final Map? orderData;

  BankPaymentSheet({this.orderData});

  @override
  _BankPaymentSheetState createState() => _BankPaymentSheetState();
}

class _BankPaymentSheetState extends State<BankPaymentSheet> {
  final PaymentGatewayController controller =
      Get.put(PaymentGatewayController());
  bool paymentProcessing = false;
  final _formKey = GlobalKey<FormState>();
  File? file;
  DIO.Response? response;
  DIO.Dio dio = new DIO.Dio();
  final TextEditingController bankNameCtrl = TextEditingController();
  final TextEditingController branchNameCtrl = TextEditingController();
  final TextEditingController accountNumberCtrl = TextEditingController();
  final TextEditingController accountHolderCtrl = TextEditingController();
  var tokenKey = 'token';

  GetStorage userToken = GetStorage();

  void pickPaymentSlip() async {
    if (AppConfig.isDemo) {
      SnackBars().snackBarWarning("Disabled for demo".tr);
    } else {
      FilePickerResult? result = await FilePicker.platform.pickFiles(
        type: FileType.image,
      );

      if (result != null) {
        setState(() {
          file = File(result.files.single.path ?? '');
        });
      } else {
        // User canceled the picker
      }
    }
  }

  @override
  Widget build(BuildContext context) {
    return GestureDetector(
      onTap: () {
        Get.back();
      },
      child: GestureDetector(
        onTap: () {},
        child: Container(
          padding: EdgeInsets.symmetric(horizontal: 25, vertical: 10),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: BorderRadius.only(
              topLeft: const Radius.circular(25.0),
              topRight: const Radius.circular(25.0),
            ),
          ),
          child: Scaffold(
            backgroundColor: Colors.white,
            body: Form(
              key: _formKey,
              child: ListView(
               // physics: NeverScrollableScrollPhysics(),
                //shrinkWrap: true,
                children: [
                  SizedBox(
                    height: 10.h,
                  ),
                  Center(
                    child: InkWell(
                      onTap: () {
                        Get.back();
                      },
                      child: Container(
                        width: 40.w,
                        height: 5.h,
                        decoration: BoxDecoration(
                          color: Color(0xffDADADA),
                          borderRadius: BorderRadius.all(
                            Radius.circular(30.r),
                          ),
                        ),
                      ),
                    ),
                  ),
                  SizedBox(
                    height: 20.h,
                  ),
                  Center(
                    child: Text(
                      'Bank Payment'.tr,
                      style: AppStyles.kFontBlack15w4,
                    ),
                  ),
                  SizedBox(
                    height: 20.h,
                  ),
                  paymentProcessing == true
                      ? Center(
                          child: Column(
                            children: [
                              CupertinoActivityIndicator(),
                              SizedBox(
                                height: 20.h,
                              ),
                              Center(
                                child: Text(
                                  '${"Payment Processing".tr}. ${"Please don't close this until payment is complete".tr}',
                                  textAlign: TextAlign.center,
                                  style: AppStyles.kFontBlack17w5,
                                ),
                              ),
                              SizedBox(
                                height: 20.fontSize,
                              ),
                            ],
                          ),
                        )
                      : Column(
                          children: [
                            ///Bank Details
                            Row(
                              mainAxisAlignment:
                                  MainAxisAlignment.spaceBetween,
                              children: [
                                Text(
                                  'Bank Name'.tr,
                                  textAlign: TextAlign.center,
                                  style: AppStyles.kFontBlack14w5,
                                ),
                                Text(
                                  '${controller.bank.value.bankInfo?.bankName}',
                                  textAlign: TextAlign.center,
                                  style: AppStyles.kFontBlack14w5,
                                ),
                              ],
                            ),
                            SizedBox(
                              height: 5.h,
                            ),
                            Row(
                              mainAxisAlignment:
                                  MainAxisAlignment.spaceBetween,
                              children: [
                                Text(
                                  'Branch Name'.tr,
                                  textAlign: TextAlign.center,
                                  style: AppStyles.kFontBlack14w5,
                                ),
                                Text(
                                  '${controller.bank.value.bankInfo?.branchName}',
                                  textAlign: TextAlign.center,
                                  style: AppStyles.kFontBlack14w5,
                                ),
                              ],
                            ),
                            SizedBox(
                              height: 5.h,
                            ),
                            Row(
                              mainAxisAlignment:
                                  MainAxisAlignment.spaceBetween,
                              children: [
                                Text(
                                  'Account Number'.tr,
                                  textAlign: TextAlign.center,
                                  style: AppStyles.kFontBlack14w5,
                                ),
                                Text(
                                  '${controller.bank.value.bankInfo?.accountNumber}',
                                  textAlign: TextAlign.center,
                                  style: AppStyles.kFontBlack14w5,
                                ),
                              ],
                            ),
                            SizedBox(
                              height: 5.h,
                            ),
                            Row(
                              mainAxisAlignment:
                                  MainAxisAlignment.spaceBetween,
                              children: [
                                Text(
                                  'Account holder'.tr,
                                  textAlign: TextAlign.center,
                                  style: AppStyles.kFontBlack14w5,
                                ),
                                Text(
                                  '${controller.bank.value.bankInfo?.accountHolder}',
                                  textAlign: TextAlign.center,
                                  style: AppStyles.kFontBlack14w5,
                                ),
                              ],
                            ),
                            SizedBox(
                              height: 25.h,
                            ),
                            SizedBox(
                              height: 25.h,
                            ),

                            ///User Info
                            Row(
                              children: [
                                Expanded(
                                  child: Column(
                                    children: [
                                      Container(
                                        alignment: Alignment.centerLeft,
                                        child: Text(
                                          'Bank Name'.tr,
                                          style: AppStyles.appFont
                                              .copyWith(
                                            color: Colors.black,
                                            fontSize: 12.fontSize,
                                            fontWeight: FontWeight.w500,
                                          ),
                                        ),
                                      ),
                                      SizedBox(
                                        height: 10.h,
                                      ),
                                      Container(
                                        child: TextFormField(
                                          controller: bankNameCtrl,
                                          autovalidateMode:
                                              AutovalidateMode
                                                  .onUserInteraction,
                                          decoration: InputDecoration(
                                            border: OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: AppStyles
                                                    .textFieldFillColor,
                                              ),
                                            ),
                                            enabledBorder:
                                                OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: AppStyles
                                                    .textFieldFillColor,
                                              ),
                                            ),
                                            errorBorder:
                                                OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: Colors.red,
                                              ),
                                            ),
                                            focusedBorder:
                                                OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: AppStyles
                                                    .textFieldFillColor,
                                              ),
                                            ),
                                            hintText: 'Bank Name'.tr,
                                            hintMaxLines: 4,
                                            hintStyle: AppStyles.appFont
                                                .copyWith(
                                              color: Colors.grey,
                                              fontSize: 15.fontSize,
                                              fontWeight:
                                                  FontWeight.w900,
                                            ),
                                          ),
                                          keyboardType:
                                              TextInputType.text,
                                          style: AppStyles.appFont
                                              .copyWith(
                                            color: Colors.black,
                                            fontSize: 15.fontSize,
                                            fontWeight: FontWeight.w500,
                                          ),
                                          validator: (value) {
                                            if (value?.length == 0) {
                                              return 'Type Bank name'.tr;
                                            } else {
                                              return null;
                                            }
                                          },
                                        ),
                                      ),
                                      SizedBox(
                                        height: 20.h,
                                      ),
                                    ],
                                  ),
                                ),
                                SizedBox(
                                  width: 10.w,
                                ),
                                Expanded(
                                  child: Column(
                                    children: [
                                      Container(
                                        alignment: Alignment.centerLeft,
                                        child: Text(
                                          'Branch Name'.tr,
                                          style: AppStyles.appFont
                                              .copyWith(
                                            color: Colors.black,
                                            fontSize: 12.fontSize,
                                            fontWeight: FontWeight.w500,
                                          ),
                                        ),
                                      ),
                                      SizedBox(
                                        height: 10.h,
                                      ),
                                      Container(
                                        child: TextFormField(
                                          controller: branchNameCtrl,
                                          autovalidateMode:
                                              AutovalidateMode
                                                  .onUserInteraction,
                                          decoration: InputDecoration(
                                            border: OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: AppStyles
                                                    .textFieldFillColor,
                                              ),
                                            ),
                                            enabledBorder:
                                                OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: AppStyles
                                                    .textFieldFillColor,
                                              ),
                                            ),
                                            errorBorder:
                                                OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: Colors.red,
                                              ),
                                            ),
                                            focusedBorder:
                                                OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: AppStyles
                                                    .textFieldFillColor,
                                              ),
                                            ),
                                            hintText: 'Branch Name'.tr,
                                            hintMaxLines: 4,
                                            hintStyle: AppStyles.appFont
                                                .copyWith(
                                              color: Colors.grey,
                                              fontSize: 15.fontSize,
                                              fontWeight:
                                                  FontWeight.w900,
                                            ),
                                          ),
                                          keyboardType:
                                              TextInputType.text,
                                          style: AppStyles.appFont
                                              .copyWith(
                                            color: Colors.black,
                                            fontSize: 15.fontSize,
                                            fontWeight: FontWeight.w500,
                                          ),
                                          validator: (value) {
                                            if (value?.length == 0) {
                                              return 'Type Branch name'.tr;
                                            } else {
                                              return null;
                                            }
                                          },
                                        ),
                                      ),
                                      SizedBox(
                                        height: 20.fontSize,
                                      ),
                                    ],
                                  ),
                                ),
                              ],
                            ),
                            SizedBox(
                              height: 10.h,
                            ),
                            Row(
                              children: [
                                Expanded(
                                  child: Column(
                                    children: [
                                      Container(
                                        alignment: Alignment.centerLeft,
                                        child: Text(
                                          'Account Number'.tr,
                                          style: AppStyles.appFont
                                              .copyWith(
                                            color: Colors.black,
                                            fontSize: 12.fontSize,
                                            fontWeight: FontWeight.w500,
                                          ),
                                        ),
                                      ),
                                      SizedBox(
                                        height: 10.h,
                                      ),
                                      Container(
                                        child: TextFormField(
                                          controller: accountNumberCtrl,
                                          autovalidateMode:
                                              AutovalidateMode
                                                  .onUserInteraction,
                                          decoration: InputDecoration(
                                            border: OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: AppStyles
                                                    .textFieldFillColor,
                                              ),
                                            ),
                                            enabledBorder:
                                                OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: AppStyles
                                                    .textFieldFillColor,
                                              ),
                                            ),
                                            errorBorder:
                                                OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: Colors.red,
                                              ),
                                            ),
                                            focusedBorder:
                                                OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: AppStyles
                                                    .textFieldFillColor,
                                              ),
                                            ),
                                            hintText: 'Account Number'.tr,
                                            hintMaxLines: 4,
                                            hintStyle: AppStyles.appFont
                                                .copyWith(
                                              color: Colors.grey,
                                              fontSize: 15.fontSize,
                                              fontWeight:
                                                  FontWeight.w900,
                                            ),
                                          ),
                                          keyboardType:
                                              TextInputType.text,
                                          style: AppStyles.appFont
                                              .copyWith(
                                            color: Colors.black,
                                            fontSize: 15.fontSize,
                                            fontWeight: FontWeight.w500,
                                          ),
                                          validator: (value) {
                                            if (value?.length == 0) {
                                              return 'Type Account Number'.tr;
                                            } else {
                                              return null;
                                            }
                                          },
                                        ),
                                      ),
                                      SizedBox(
                                        height: 20.h,
                                      ),
                                    ],
                                  ),
                                ),
                                SizedBox(
                                  width: 10.w,
                                ),
                                Expanded(
                                  child: Column(
                                    children: [
                                      Container(
                                        alignment: Alignment.centerLeft,
                                        child: Text(
                                          'Account holder'.tr,
                                          style: AppStyles.appFont
                                              .copyWith(
                                            color: Colors.black,
                                            fontSize: 12.fontSize,
                                            fontWeight: FontWeight.w500,
                                          ),
                                        ),
                                      ),
                                      SizedBox(
                                        height: 10.h,
                                      ),
                                      Container(
                                        child: TextFormField(
                                          controller: accountHolderCtrl,
                                          autovalidateMode:
                                              AutovalidateMode
                                                  .onUserInteraction,
                                          decoration: InputDecoration(
                                            border: OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: AppStyles
                                                    .textFieldFillColor,
                                              ),
                                            ),
                                            enabledBorder:
                                                OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: AppStyles
                                                    .textFieldFillColor,
                                              ),
                                            ),
                                            errorBorder:
                                                OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: Colors.red,
                                              ),
                                            ),
                                            focusedBorder:
                                                OutlineInputBorder(
                                              borderSide: BorderSide(
                                                color: AppStyles
                                                    .textFieldFillColor,
                                              ),
                                            ),
                                            hintText: 'Account holder'.tr,
                                            hintMaxLines: 4,
                                            hintStyle: AppStyles.appFont
                                                .copyWith(
                                              color: Colors.grey,
                                              fontSize: 15.fontSize,
                                              fontWeight:
                                                  FontWeight.w900,
                                            ),
                                          ),
                                          keyboardType:
                                              TextInputType.text,
                                          style: AppStyles.appFont
                                              .copyWith(
                                            color: Colors.black,
                                            fontSize: 15.fontSize,
                                            fontWeight: FontWeight.w500,
                                          ),
                                          validator: (value) {
                                            if (value?.length == 0) {
                                              return 'Type Account Holder'.tr;
                                            } else {
                                              return null;
                                            }
                                          },
                                        ),
                                      ),
                                      SizedBox(
                                        height: 20.h,
                                      ),
                                    ],
                                  ),
                                ),
                              ],
                            ),
                            SizedBox(
                              height: 10.h,
                            ),

                            InkWell(
                              onTap: pickPaymentSlip,
                              child: Row(
                                children: [
                                  Expanded(
                                    child: Container(
                                      alignment: Alignment.centerLeft,
                                      child: Text(
                                          file == null
                                              ? 'Attach Payment Slip'.tr
                                              : "${"Payment Slip".tr}: ${file?.path.split('/').last}",
                                          style:
                                              AppStyles.kFontBlack15w4),
                                    ),
                                  ),
                                  Expanded(
                                    child: Container(),
                                  ),
                                  Icon(Icons.attach_file),
                                ],
                              ),
                            ),

                            SizedBox(
                              height: 25.h,
                            ),
                            PinkButtonWidget(
                              width: Get.width * 0.7,
                              height: 50.h,
                              btnText: 'Submit',
                              btnOnTap: () async {
                                if (_formKey.currentState!.validate()) {
                                  if (file != null) {
                                    setState(() {
                                      paymentProcessing = true;
                                    });
                                    try {
                                      String token = await userToken
                                          .read(tokenKey);

                                      final slip = await DIO
                                              .MultipartFile
                                          .fromFile(file?.path ?? '',
                                              filename: '${file?.path}');

                                      final formData =
                                          DIO.FormData.fromMap({
                                        'image': slip,
                                        'payment_for': 'order_payment',
                                        'payment_method':
                                            widget.orderData?[
                                                'payment_method'],
                                        'bank_name': bankNameCtrl.text,
                                        'branch_name':
                                            branchNameCtrl.text,
                                        'account_number':
                                            accountNumberCtrl.text,
                                        'account_holder':
                                            accountHolderCtrl.text,
                                        'bank_amount': widget
                                            .orderData?['grand_total'],
                                      });

                                      response = await dio.post(
                                        URLs.BANK_PAYMENT_DATA_STORE,
                                        data: formData,
                                        options: DIO.Options(
                                          headers: {
                                            'Accept':
                                                'application/json',
                                            'Authorization':
                                                'Bearer $token',
                                          },
                                        ),
                                        onSendProgress:
                                            (received, total) {
                                          if (total != -1) {
                                            print((received /
                                                        total *
                                                        100)
                                                    .toStringAsFixed(
                                                        0) +
                                                '%');
                                          }
                                        },
                                      ).catchError((e) {
                                        print("EEEE $e");
                                        final errorMessage =
                                            DioExceptions.fromDioError(
                                                    e)
                                                .toString();
                                        print(
                                            "ERROR MSG : $errorMessage");
                                        if (errorMessage == "401") {
                                          SnackBars().snackBarWarning(
                                              'Unauthorized'.tr);
                                          Get.back();
                                        }
                                        setState(() {
                                          paymentProcessing = false;
                                        });
                                      });
                                      if (response?.statusCode == 201) {
                                        var bankResponse =
                                            BankPaymentResponse
                                                .fromJson(
                                                    response?.data);

                                        log('Payment Info ${bankResponse.paymentInfo?.id.toString()}');
                                        log('Bank Info ${bankResponse.bankDetails?.id.toString()}');

                                        widget.orderData?.addAll({
                                          'payment_id': bankResponse
                                              .paymentInfo?.id,
                                          'bank_details_id':
                                              bankResponse
                                                  .bankDetails?.id
                                        });

                                        await controller.submitOrder(
                                            widget.orderData);
                                      } else {
                                        if (response?.statusCode ==
                                            401) {
                                          SnackBars().snackBarWarning(
                                              '${"Invalid Access token".tr}. ${"Please re-login".tr}.');
                                        } else {
                                          SnackBars().snackBarError(
                                              response?.data);
                                          // return false;
                                        }
                                      }
                                    } catch (e) {
                                      print('ERROR  $e');
                                    }
                                  } else {
                                    SnackBars().snackBarWarning(
                                        'Please attach Payment slip'.tr);
                                  }
                                }
                              },
                            ),
                          ],
                        ),
                ],
              ),
            ),
          ),
        ),
      ),
    );
  }
}
