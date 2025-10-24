import 'dart:convert';
import 'dart:developer';

import 'package:sjfashionhub/config/config.dart';
import 'package:sjfashionhub/model/MyReviewListModel.dart';
import 'package:sjfashionhub/model/WaitingReviewModel.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';
import 'package:http/http.dart' as http;

import '../AppConfig/language/app_localizations.dart';

class ReviewController extends GetxController {
  var isWaitingReviewLoading = false.obs;

  var isMyReviewLoading = false.obs;

  var waitingReview = WaitingReviewModel().obs;

  var myReview = MyReviewListModel().obs;

  var tokenKey = "token";
  GetStorage userToken = GetStorage();

  var isAnon = false.obs;

  var isTerms = false.obs;

  Future<WaitingReviewModel?> getWaitingForReviews() async {
    String token = await userToken.read(tokenKey);

    Uri userData = Uri.parse(URLs.WAITING_FOR_REVIEW + '?lang=${AppLocalizations.getLanguageCode()}');

    log("Url -> ${URLs.WAITING_FOR_REVIEW}");

    var response = await http.get(
      userData,
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );
    
    log("Review list response :: ${response.body}");
    var jsonString = jsonDecode(response.body);
    if (jsonString['message'] == 'success') {
      return WaitingReviewModel.fromJson(jsonString);
    } else {
      //show error message
      return null;
    }
  }

  Future<WaitingReviewModel?> waitingForReviews() async {
   
    try {
      isWaitingReviewLoading(true);
      var products = await getWaitingForReviews();
      if (products != null) {
        waitingReview.value = products;
      } else {
        waitingReview.value = WaitingReviewModel();
      }
      return products;
    } finally {
      isWaitingReviewLoading(false);
    }
  }

  Future<MyReviewListModel?> getMyReviewList() async {
    String token = await userToken.read(tokenKey);

    Uri userData = Uri.parse(URLs.MY_REVIEWS + '?lang=${AppLocalizations.getLanguageCode()}');

    var response = await http.get(
      userData,
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'Authorization': 'Bearer $token',
      },
    );
    var jsonString = jsonDecode(response.body);
    if (jsonString['message'] == 'success') {
      return MyReviewListModel.fromJson(jsonString);
    } else {
      //show error message
      return null;
    }
  }

  Future<MyReviewListModel?> myReviews() async {
    
    try {
      isMyReviewLoading(true);
      var products = await getMyReviewList();
      if (products != null) {
        myReview.value = products;
      } else {
        myReview.value = MyReviewListModel();
      }
      return products;
    } finally {
      isMyReviewLoading(false);
    }
  }

  void anonCheck() {
    isAnon.value = !isAnon.value;
  }

  void termCheck() {
    isTerms.value = !isTerms.value;
  }
}
