import 'package:flutter/material.dart';

class AppConfig {

 static const String hostUrl = "https://spondan.com/spn4/amazcart/v4.8";

  static String appName = 'Amazcart';

  ///There is two app theme is available
  ///one is Amazcart and
  ///second one is amazy
  ///static isAmazCartTheme = true
  static bool isAmazCartTheme = false;

  static String appColorSchemeGradient1 = '#FD4949';

  static String appColorSchemeGradient2 = '#d20000';

  static String loginBackgroundImage = 'assets/config/login_bg.png';

  static String appLogo = 'assets/config/splash_screen_logo.png';

  static String appBanner = 'assets/config/app_banner.png';
  static String appBarIcon = 'assets/config/appbar_icon.png';


  static const String assetPath = hostUrl + '/public';

  static Color loginScreenBackgroundGradient1 = Color(0xffFF3566);

  static Color loginScreenBackgroundGradient2 = Color(0xffD7365C);

  static String appColorScheme = "#FF3364";

  static const String privacyPolicyUrl =
      'https://amazcart.ischooll.com/privacy-policy';

  static bool googleLogin = true;

  static bool facebookLogin = false;
  static bool appleLogin = false;

  static bool isDemo = false;

  static String tabbyMerchantCode = 'FONCY';
  static bool isPasswordChange = false;
}
