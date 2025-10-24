import 'package:amazcart/AppConfig/app_config.dart';
import 'package:amazcart/AppConfig/language/app_localizations.dart';

mixin URLs {
  static const String HOST = AppConfig.hostUrl;

  // Use mobile API endpoints
  static const String API_URL = HOST + '/api/mobile';

  static const String ALL_PRODUCTS = '$API_URL/products';

  static const String HOME_PAGE = '$API_URL/home';

  static const String SELLER_PROFILE = '$API_URL/profile';

  static const String ALL_GIFT_CARDS = '$API_URL/gift-card/list';

  static const String GIFT_CARD = '$API_URL/gift-card';

  static const String MY_PURCHASED_GIFT_CARDS =
      '$API_URL/gift-card/my-purchased/list';

  static const String PRODUCT_PRICE_SKU_WISE = '$API_URL/products/sku-price';

  static const String ALL_CATEGORY = '$API_URL/categories';

  static const String TOP_CATEGORY = '$API_URL/categories';

  static const String ALL_RECOMMENDED = '$API_URL/products';

  static const String ALL_TOP_PICKS = '$API_URL/products';

  static const String ALL_SLIDERS = '$API_URL/banners';

  static const String ALL_BRAND = '$API_URL/brands';

  static const String SINGLE_TAG_PRODUCTS = '$API_URL/products';

  static const String LOGIN = '$API_URL/auth/login';

  static const String SOCIAL_LOGIN = '$API_URL/auth/social-login';

  static const String REGISTER = '$API_URL/auth/register';

  static const String LOGOUT = '$API_URL/auth/logout';

  static const String GET_USER = '$API_URL/auth/user';

  static const String ALL_ORDER_LIST = '$API_URL/orders';

  static String ALL_ORDER_LIST_BY_STATUS({required int id}) =>
      '$API_URL/orders?status=$id&lang=${AppLocalizations.getLanguageCode()}';
  static const String ALL_ORDER_DELIVERY_PROCESS =
      '$API_URL/orders/delivery-processes';

  static const String ALL_ORDER_PENDING_LIST = '$API_URL/orders?status=pending';

  static const String ALL_ORDER_CANCEL_LIST =
      '$API_URL/orders?status=cancelled';

  static const String ALL_ORDER_REFUND_LIST = '$API_URL/orders?status=refunded';

  static const String NEW_USER_ZONE = '$API_URL/marketing/new-user-zone';

  static const String ORDER_TO_SHIP = '$API_URL/orders?status=to_ship';

  static const String ORDER_TO_RECEIVE = '$API_URL/orders?status=to_receive';

  static const String ORDER_REVIEW = '$API_URL/orders/reviews';

  static const String ADDRESS_LIST = '$API_URL/addresses';

  static const String COUNTRY = '$API_URL/locations/countries';

  static String stateByCountry(countryId) {
    return '$API_URL/locations/countries/$countryId/states';
  }

  static String cityByState(stateId) {
    return '$API_URL/locations/states/$stateId/cities';
  }

  static const String ADD_ADDRESS = '$API_URL/addresses';

  static const String ADDRESS_SET_DEFAULT_BILLING =
      '$API_URL/addresses/set-default-billing';

  static const String ADDRESS_SET_DEFAULT_SHIPPING =
      '$API_URL/addresses/set-default-shipping';

  static String editAddress(addressId) {
    return '$API_URL/addresses/$addressId';
  }

  static const String DELETE_ADDRESS = '$API_URL/addresses';

  static const String UPDATE_USER_PROFILE = '$API_URL/profile';

  static const String WAITING_FOR_REVIEW = '$API_URL/orders/reviews/waiting';

  static const String MY_REVIEWS = '$API_URL/orders/reviews';

  static const String UPDATE_PROFILE_PHOTO = '$API_URL/profile/photo';

  static const String MY_COUPONS = '$API_URL/coupons';
  static const String MY_COUPON_DELETE = '$API_URL/coupons';

  static const String MY_WISHLIST = '$API_URL/wishlist';

  static const String MY_WISHLIST_DELETE = '$API_URL/wishlist';

  static const String CART = '$API_URL/cart';
  static const String CART_QUANTITY_UPDATE = '$API_URL/cart/items';
  static const String CART_SELECT_UNSELECT_ALL = '$API_URL/cart/select-all';
  static const String CART_SELECT_UNSELECT_SELLER_WISE =
      '$API_URL/cart/select-seller';
  static const String CART_SELECT_UNSELECT_SINGLE = '$API_URL/cart/select-item';
  static const String CART_REMOVE_ALL = '$API_URL/cart/clear';
  static const String CART_REMOVE_CART_ITEM = '$API_URL/cart/items';

  static const String CART_UPDATE_SHIPPING = '$API_URL/cart/shipping-method';

  static const String FLASH_DEALS = '$API_URL/deals/flash';

  static const String CHANGE_PASSWORD = '$API_URL/auth/change-password';

  static const String CHECKOUT = '$API_URL/checkout';

  static const String TABBYURL = '$API_URL/checkout/tabby';

  static const String PAYMENT_GATEWAY = '$API_URL/payments/gateways';

  static const String BANK_INFO = '$API_URL/payments/bank/info';

  static const String BANK_PAYMENT_DATA_STORE = '$API_URL/payments/bank/store';

  static const String ORDER_STORE = '$API_URL/orders';

  static const String ORDER_PAYMENT_STORE = '$API_URL/orders/payment';

  static const String CHECK_PRICE_UPDATE = '$API_URL/checkout/price-check';

  static const String SORT_PRODUCTS = '$API_URL/products/sort';

  static const String SORT_ALL_PRODUCTS = '$API_URL/products/filter';

  static const String FILTER_ALL_PRODUCTS = '$API_URL/products/filter';

  static const String FILTER_SELLER_PRODUCTS = '$API_URL/products/filter';

  static const String APPLY_COUPON = '$API_URL/checkout/apply-coupon';

  static String fetchNewUserProductData(slug) {
    return '$API_URL/marketing/new-user-zone/$slug/fetch-product-data?lang=${AppLocalizations.getLanguageCode()}';
  }

  static String fetchNewUserCategoryAllProducts(slug) {
    return '$API_URL/marketing/new-user-zone/$slug/fetch-all-category-data?lang=${AppLocalizations.getLanguageCode()}';
  }

  static String fetchNewUserCouponAllProducts(slug) {
    return '$API_URL/marketing/new-user-zone/$slug/fetch-all-coupon-category-data?lang=${AppLocalizations.getLanguageCode()}';
  }

  static String fetchNewUserCategoryProducts(slug) {
    return '$API_URL/marketing/new-user-zone/$slug/fetch-category-data?lang=${AppLocalizations.getLanguageCode()}';
  }

  static String fetchNewUserCouponProducts(slug) {
    return '$API_URL/marketing/new-user-zone/$slug/fetch-coupon-category-data?lang=${AppLocalizations.getLanguageCode()}';
  }

  static const String CANCEL_REASONS = '$API_URL/orders/cancel-reasons';

  static const String ORDER_CANCEL_STORE = '$API_URL/orders/cancel';

  static const String REFUND_REASONS_LIST = '$API_URL/orders/refund-reasons';

  static const String REFUND_STORE = '$API_URL/orders/refund';

  static const String USER_NOTIFICATIONS = '$API_URL/notifications';

  static const String GENERAL_SETTINGS = HOST + '/api/api/general-settings';
  static const String USER_DELETE = '$API_URL/auth/delete-account';

  static const String CURRENCY_LIST = '$API_URL/config/currencies';

  static const String SHIPPING_LIST = '$API_URL/shipping/methods';

  static const String CUSTOMER_GET_DATA = '$API_URL/profile';

  // static const String TICKET_LIST = '$API_URL/tickets';
  static const String TICKET_LIST = '$API_URL/tickets';

  static const String TICKET_CATEGORIES = '$API_URL/tickets/categories';

  static const String TICKET_PRIORITIES = '$API_URL/tickets/priorities';

  static const String TICKET_STORE = '$API_URL/tickets';

  static const String TICKET_SHOW = '$API_URL/tickets';

  static const String TICKET_REPLY = '$API_URL/tickets/reply';

  static const String NOTIFICATION_SETTINGS = '$API_URL/notifications/settings';
  static const String NOTIFICATION_SETTINGS_UPDATE =
      '$API_URL/notifications/settings';

  static const String LIVE_SEARCH = '$API_URL/search';

  static const String OTP_SEND = '$API_URL/auth/send-otp';

  static const String FORGOT_PASSWORD = '$API_URL/auth/forgot-password';

  static const String getLang = '$API_URL/config/language';
  static const String setLang = '$API_URL/config/language';

  ///In-app purchase APIs
  static const String inAppPurchaseAddToCart = "$API_URL/cart/in-app";
  static const String createInAppPurchaseOrder = "$API_URL/orders/in-app";
  static const String deleteInAppPurchaseCart = "$API_URL/cart/in-app";
}

// constant for page limit & timeout
mixin AppLimit {
  static const int REQUEST_TIME_OUT = 30000;
}

const String appVersion = '0.0.1';
const String environment = 'Production';
