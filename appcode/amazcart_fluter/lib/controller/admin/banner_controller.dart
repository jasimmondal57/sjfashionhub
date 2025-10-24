import 'dart:convert';
import 'dart:io';
import 'package:amazcart/config/config.dart';
import 'package:amazcart/controller/login_controller.dart';
import 'package:amazcart/model/admin/BannerModel.dart';
import 'package:dio/dio.dart';
import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:http/http.dart' as http;

class BannerController extends GetxController {
  var banners = <BannerModel>[].obs;
  var isLoading = false.obs;
  var isSaving = false.obs;

  final LoginController loginController = Get.find<LoginController>();
  final Dio _dio = Dio();

  @override
  void onInit() {
    super.onInit();
    getBanners();
  }

  Future<void> getBanners() async {
    try {
      isLoading.value = true;
      
      final response = await http.get(
        Uri.parse('${URLs.BASE_URL}/api/admin/banners'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ${loginController.tokenString}',
        },
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        if (data['success'] == true) {
          final List<dynamic> bannerList = data['data'];
          banners.value = bannerList.map((json) => BannerModel.fromJson(json)).toList();
        } else {
          Get.snackbar('Error', data['message'] ?? 'Failed to load banners');
        }
      } else {
        Get.snackbar('Error', 'Failed to load banners');
      }
    } catch (e) {
      print('Error loading banners: $e');
      Get.snackbar('Error', 'Failed to load banners');
    } finally {
      isLoading.value = false;
    }
  }

  Future<bool> addBanner(BannerModel banner, File? imageFile) async {
    try {
      isSaving.value = true;

      FormData formData = FormData.fromMap(banner.toFormData());
      
      if (imageFile != null) {
        formData.files.add(MapEntry(
          'image',
          await MultipartFile.fromFile(imageFile.path),
        ));
      }

      final response = await _dio.post(
        '${URLs.BASE_URL}/api/admin/banners',
        data: formData,
        options: Options(
          headers: {
            'Authorization': 'Bearer ${loginController.tokenString}',
            'Accept': 'application/json',
          },
        ),
      );

      if (response.statusCode == 201) {
        final data = response.data;
        if (data['success'] == true) {
          Get.snackbar(
            'Success',
            'Banner added successfully',
            backgroundColor: Colors.green,
            colorText: Colors.white,
          );
          return true;
        } else {
          Get.snackbar('Error', data['message'] ?? 'Failed to add banner');
          return false;
        }
      } else {
        Get.snackbar('Error', 'Failed to add banner');
        return false;
      }
    } catch (e) {
      print('Error adding banner: $e');
      Get.snackbar('Error', 'Failed to add banner');
      return false;
    } finally {
      isSaving.value = false;
    }
  }

  Future<bool> updateBanner(BannerModel banner, File? imageFile) async {
    try {
      isSaving.value = true;

      FormData formData = FormData.fromMap(banner.toFormData());
      formData.fields.add(MapEntry('_method', 'PUT'));
      
      if (imageFile != null) {
        formData.files.add(MapEntry(
          'image',
          await MultipartFile.fromFile(imageFile.path),
        ));
      }

      final response = await _dio.post(
        '${URLs.BASE_URL}/api/admin/banners/${banner.id}',
        data: formData,
        options: Options(
          headers: {
            'Authorization': 'Bearer ${loginController.tokenString}',
            'Accept': 'application/json',
          },
        ),
      );

      if (response.statusCode == 200) {
        final data = response.data;
        if (data['success'] == true) {
          Get.snackbar(
            'Success',
            'Banner updated successfully',
            backgroundColor: Colors.green,
            colorText: Colors.white,
          );
          return true;
        } else {
          Get.snackbar('Error', data['message'] ?? 'Failed to update banner');
          return false;
        }
      } else {
        Get.snackbar('Error', 'Failed to update banner');
        return false;
      }
    } catch (e) {
      print('Error updating banner: $e');
      Get.snackbar('Error', 'Failed to update banner');
      return false;
    } finally {
      isSaving.value = false;
    }
  }

  Future<void> deleteBanner(int bannerId) async {
    try {
      final response = await http.delete(
        Uri.parse('${URLs.BASE_URL}/api/admin/banners/$bannerId'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ${loginController.tokenString}',
        },
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        if (data['success'] == true) {
          banners.removeWhere((banner) => banner.id == bannerId);
          Get.snackbar(
            'Success',
            'Banner deleted successfully',
            backgroundColor: Colors.green,
            colorText: Colors.white,
          );
        } else {
          Get.snackbar('Error', data['message'] ?? 'Failed to delete banner');
        }
      } else {
        Get.snackbar('Error', 'Failed to delete banner');
      }
    } catch (e) {
      print('Error deleting banner: $e');
      Get.snackbar('Error', 'Failed to delete banner');
    }
  }

  Future<void> toggleBannerStatus(int bannerId, bool isActive) async {
    try {
      final response = await http.put(
        Uri.parse('${URLs.BASE_URL}/api/admin/banners/$bannerId/toggle-status'),
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': 'Bearer ${loginController.tokenString}',
        },
        body: json.encode({'is_active': isActive}),
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        if (data['success'] == true) {
          // Update local banner status
          final bannerIndex = banners.indexWhere((banner) => banner.id == bannerId);
          if (bannerIndex != -1) {
            banners[bannerIndex].isActive = isActive;
            banners.refresh();
          }
          
          Get.snackbar(
            'Success',
            'Banner status updated successfully',
            backgroundColor: Colors.green,
            colorText: Colors.white,
          );
        } else {
          Get.snackbar('Error', data['message'] ?? 'Failed to update banner status');
        }
      } else {
        Get.snackbar('Error', 'Failed to update banner status');
      }
    } catch (e) {
      print('Error updating banner status: $e');
      Get.snackbar('Error', 'Failed to update banner status');
    }
  }
}
