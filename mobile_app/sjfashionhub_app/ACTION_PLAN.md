# SJ Fashion Hub Mobile App - Action Plan

## 🎯 Current Status
- **App Status:** Running at http://localhost:8080
- **API Status:** Connected to https://sjfashionhub.com/api/mobile
- **Data Loading:** Products working, Categories & Banners empty
- **Progress:** 18/40 screens complete (45%)

---

## 🔥 PHASE 1: FIX CURRENT ISSUES (1-2 days)

### Task 1.1: Populate Database with Categories & Banners
**Priority:** CRITICAL
**Time:** 2-3 hours

**Backend Tasks:**
```bash
# SSH into server
ssh -i ~/.ssh/id_ed25519_marketplace root@72.60.102.152

# Add categories to database
cd /var/www/sjfashionhub.com
php artisan tinker

# Create sample categories
Category::create(['name' => 'Women', 'slug' => 'women', 'is_active' => true]);
Category::create(['name' => 'Men', 'slug' => 'men', 'is_active' => true]);
Category::create(['name' => 'Kids', 'slug' => 'kids', 'is_active' => true]);
Category::create(['name' => 'Accessories', 'slug' => 'accessories', 'is_active' => true]);

# Create sample banners
Banner::create([
    'title' => 'Summer Sale',
    'image' => 'banners/summer-sale.jpg',
    'link' => '/products?category=women',
    'is_active' => true,
    'sort_order' => 1
]);
```

**Expected Result:** Home screen shows categories and banners

---

### Task 1.2: Test & Verify All Existing Screens
**Priority:** HIGH
**Time:** 2-3 hours

**Test Checklist:**
- [ ] Onboarding flow (3 screens)
- [ ] Login/Register
- [ ] Home screen with products
- [ ] Category list
- [ ] Product details
- [ ] Add to cart
- [ ] Cart screen
- [ ] Wishlist
- [ ] Profile
- [ ] Settings
- [ ] Notifications
- [ ] Orders list
- [ ] Addresses list
- [ ] Add/Edit address

**Fix any bugs found during testing**

---

## 🛒 PHASE 2: COMPLETE CHECKOUT FLOW (3-5 days)

### Task 2.1: Coupon/Promo Code Screen
**Priority:** HIGH
**Time:** 4-6 hours

**Files to Create:**
- `lib/screens/cart/coupon_screen.dart`
- `lib/models/coupon.dart`
- `lib/providers/coupon_provider.dart`

**Backend API:**
```php
// MobileApiController.php
public function getCoupons() {
    $coupons = Coupon::where('is_active', true)
        ->where('valid_from', '<=', now())
        ->where('valid_until', '>=', now())
        ->get();
    return response()->json(['success' => true, 'data' => $coupons]);
}

public function applyCoupon(Request $request) {
    $code = $request->input('code');
    $coupon = Coupon::where('code', $code)->first();
    // Validate and apply coupon logic
}
```

---

### Task 2.2: Shipping Method Selection
**Priority:** HIGH
**Time:** 6-8 hours

**Files to Create:**
- `lib/screens/checkout/shipping_method_screen.dart`
- `lib/models/shipping_method.dart`
- `lib/services/shiprocket_service.dart`

**Shiprocket Integration:**
```dart
class ShiprocketService {
  Future<List<ShippingMethod>> getShippingRates({
    required String pincode,
    required double weight,
    required double codAmount,
  }) async {
    // Call Shiprocket API
    final response = await dio.post(
      'https://apiv2.shiprocket.in/v1/external/courier/serviceability/',
      data: {
        'pickup_postcode': '400001',
        'delivery_postcode': pincode,
        'weight': weight,
        'cod': codAmount > 0 ? 1 : 0,
      },
    );
    return parseShippingMethods(response.data);
  }
}
```

**Backend API:**
```php
public function estimateShipping(Request $request) {
    $pincode = $request->input('pincode');
    $weight = $request->input('weight');
    
    // Call Shiprocket API
    $shiprocket = new ShiprocketService();
    $rates = $shiprocket->getServiceability($pincode, $weight);
    
    return response()->json(['success' => true, 'data' => $rates]);
}
```

---

### Task 2.3: Payment Method Selection
**Priority:** HIGH
**Time:** 4-6 hours

**Files to Create:**
- `lib/screens/checkout/payment_method_screen.dart`
- `lib/models/payment_method.dart`

**Payment Options:**
- UPI (PhonePe, Google Pay, Paytm)
- Credit/Debit Card
- Net Banking
- Cash on Delivery (COD)
- Wallets (Paytm, PhonePe, Amazon Pay)

---

### Task 2.4: Order Summary Screen
**Priority:** HIGH
**Time:** 3-4 hours

**Files to Create:**
- `lib/screens/checkout/order_summary_screen.dart`

**Display:**
- Cart items
- Delivery address
- Shipping method
- Payment method
- Coupon discount
- Total amount
- Place Order button

---

### Task 2.5: Payment Gateway Integration
**Priority:** CRITICAL
**Time:** 8-12 hours

**Recommended:** Razorpay (most popular in India)

**Flutter Integration:**
```dart
// pubspec.yaml
dependencies:
  razorpay_flutter: ^1.3.6

// payment_service.dart
class PaymentService {
  final Razorpay _razorpay = Razorpay();
  
  Future<void> initiatePayment({
    required double amount,
    required String orderId,
    required String name,
    required String email,
    required String phone,
  }) async {
    var options = {
      'key': 'YOUR_RAZORPAY_KEY',
      'amount': (amount * 100).toInt(), // Amount in paise
      'name': 'SJ Fashion Hub',
      'order_id': orderId,
      'prefill': {
        'contact': phone,
        'email': email,
      },
    };
    
    _razorpay.open(options);
  }
}
```

**Backend API:**
```php
use Razorpay\Api\Api;

public function createPaymentOrder(Request $request) {
    $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    
    $order = $api->order->create([
        'amount' => $request->amount * 100, // Amount in paise
        'currency' => 'INR',
        'receipt' => 'order_' . time(),
    ]);
    
    return response()->json([
        'success' => true,
        'order_id' => $order->id,
        'amount' => $order->amount,
    ]);
}

public function verifyPayment(Request $request) {
    $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
    
    try {
        $attributes = [
            'razorpay_order_id' => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature' => $request->razorpay_signature,
        ];
        
        $api->utility->verifyPaymentSignature($attributes);
        
        // Payment verified, update order status
        $order = Order::where('razorpay_order_id', $request->razorpay_order_id)->first();
        $order->update([
            'payment_status' => 'paid',
            'razorpay_payment_id' => $request->razorpay_payment_id,
        ]);
        
        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()], 400);
    }
}
```

---

### Task 2.6: Order Confirmation Screen
**Priority:** HIGH
**Time:** 3-4 hours

**Files to Create:**
- `lib/screens/checkout/order_confirmation_screen.dart`

**Display:**
- Success animation
- Order ID
- Estimated delivery date
- Order summary
- Track Order button
- Continue Shopping button

---

## 📦 PHASE 3: ORDER MANAGEMENT (2-3 days)

### Task 3.1: Order Details Screen
**Priority:** HIGH
**Time:** 4-6 hours

**Files to Create:**
- `lib/screens/orders/order_detail_screen.dart`
- `lib/models/order_detail.dart`

**Display:**
- Order items with images
- Order status timeline
- Delivery address
- Payment details
- Invoice download button
- Track shipment button
- Cancel/Return button (if applicable)

---

### Task 3.2: Shipment Tracking Screen
**Priority:** MEDIUM
**Time:** 6-8 hours

**Files to Create:**
- `lib/screens/orders/tracking_screen.dart`
- `lib/models/shipment_tracking.dart`

**Shiprocket Tracking API:**
```php
public function trackShipment($awb) {
    $shiprocket = new ShiprocketService();
    $tracking = $shiprocket->trackShipment($awb);
    
    return response()->json([
        'success' => true,
        'data' => [
            'awb' => $awb,
            'status' => $tracking['status'],
            'current_location' => $tracking['current_location'],
            'timeline' => $tracking['timeline'],
            'eta' => $tracking['eta'],
        ],
    ]);
}
```

---

### Task 3.3: Return/Exchange Screen
**Priority:** MEDIUM
**Time:** 6-8 hours

**Files to Create:**
- `lib/screens/orders/return_request_screen.dart`
- `lib/models/return_request.dart`

---

## 👤 PHASE 4: USER PROFILE & SETTINGS (2-3 days)

### Task 4.1: Edit Profile Screen
### Task 4.2: Wallet/Coupons Screen
### Task 4.3: Saved Payment Methods

---

## 🎨 PHASE 5: ADDITIONAL FEATURES (3-5 days)

### Task 5.1: Splash Screen
### Task 5.2: Forgot Password/OTP
### Task 5.3: Image Gallery with Zoom
### Task 5.4: Variant Selector (Size/Color)
### Task 5.5: Filter & Sort
### Task 5.6: Offers & Deals Page
### Task 5.7: Content Pages (About, FAQ, etc.)

---

## 🚀 PHASE 6: POLISH & DEPLOYMENT (1 week)

### Task 6.1: Testing
- Unit tests
- Integration tests
- UI tests
- Performance testing

### Task 6.2: Optimization
- Image optimization
- API caching
- Lazy loading
- Code splitting

### Task 6.3: App Store Preparation
- App icons (all sizes)
- Splash screens
- Screenshots
- App description
- Privacy policy
- Terms & conditions

### Task 6.4: Deployment
- Android APK/AAB build
- iOS IPA build
- Play Store submission
- App Store submission

---

## 📊 ESTIMATED TIMELINE

- **Phase 1:** 1-2 days (Fix current issues)
- **Phase 2:** 3-5 days (Complete checkout)
- **Phase 3:** 2-3 days (Order management)
- **Phase 4:** 2-3 days (Profile & settings)
- **Phase 5:** 3-5 days (Additional features)
- **Phase 6:** 5-7 days (Polish & deployment)

**Total:** 16-25 days (3-5 weeks)

---

## 💰 COST ESTIMATES (if outsourcing)

- **Phase 1-2:** $500-800 (Core commerce)
- **Phase 3-4:** $400-600 (Order & profile)
- **Phase 5:** $300-500 (Additional features)
- **Phase 6:** $200-400 (Polish & deployment)

**Total:** $1,400-2,300

---

**Next Immediate Action:** Fix categories and banners data, then test the app thoroughly!

