import 'package:flutter/material.dart';
import 'package:get/get.dart';
import 'package:get_storage/get_storage.dart';

class AppController extends GetxController {
  final GetStorage _storage = GetStorage();

  // Navigation
  final RxInt currentIndex = 0.obs;

  // App State
  final RxBool isLoading = false.obs;
  final RxBool isConnected = true.obs;
  final RxString currentLanguage = 'en'.obs;

  // Theme
  final RxBool isDarkMode = false.obs;

  @override
  void onInit() {
    super.onInit();
    _loadSettings();
  }

  void _loadSettings() {
    // Load saved settings
    isDarkMode.value = _storage.read('isDarkMode') ?? false;
    currentLanguage.value = _storage.read('language') ?? 'en';
  }

  void changeIndex(int index) {
    currentIndex.value = index;
  }

  void toggleTheme() {
    isDarkMode.value = !isDarkMode.value;
    _storage.write('isDarkMode', isDarkMode.value);
  }

  void changeLanguage(String language) {
    currentLanguage.value = language;
    _storage.write('language', language);
    Get.updateLocale(Locale(language));
  }

  void setLoading(bool loading) {
    isLoading.value = loading;
  }

  void setConnected(bool connected) {
    isConnected.value = connected;
  }
}
