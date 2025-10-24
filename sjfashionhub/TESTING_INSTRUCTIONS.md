# Testing Instructions - Variant Order Flow

## 🎯 What to Test
Verify that product variant information (size) flows through the entire order process.

---

## 📋 Test Scenario: Order a Blouse with Size Variant

### **Step 1: Product Details Page**
**URL**: https://sjfashionhub.com/products/[blouse-product-slug]

**What to Check**:
- [ ] Size selector buttons are visible (26, 30, 32, 34, 36, 38, 40, 42)
- [ ] Clicking a size button highlights it (border turns black, background gray)
- [ ] Selected size is shown before adding to cart

**Expected Result**: ✅ Size variant selector is functional

---

### **Step 2: Add to Cart**
**Action**: Click "Add to Cart" button with a specific size selected (e.g., Size 30)

**What to Check**:
- [ ] Success message appears
- [ ] Cart count increases in header

**Expected Result**: ✅ Product added to cart with selected variant

---

### **Step 3: Cart Page**
**URL**: https://sjfashionhub.com/cart

**What to Check**:
- [ ] Product name is displayed
- [ ] **"Size: 30"** is shown in blue color below product name
- [ ] Size is visible on both mobile and desktop views
- [ ] Quantity and price are correct

**Expected Display**:
```
Black Embroidered blouses for sarees
Size: 30                    ← Should be in blue
₹599
```

**Expected Result**: ✅ Variant size is displayed in cart

---

### **Step 4: Checkout Page**
**URL**: https://sjfashionhub.com/checkout

**What to Check**:
- [ ] Order summary shows product name
- [ ] **"Size: 30"** is shown in blue color in order summary
- [ ] Quantity and price are correct
- [ ] Total amount is calculated correctly

**Expected Display in Order Summary**:
```
Black Embroidered blouses for sarees
Size: 30                    ← Should be in blue
Qty: 1
₹599
```

**Expected Result**: ✅ Variant size is displayed in checkout

---

### **Step 5: Place Order**
**Action**: Fill in delivery details and click "Place Order"

**What to Check**:
- [ ] Order is created successfully
- [ ] Order confirmation page shows order number
- [ ] Variant information should be saved in database

**Expected Result**: ✅ Order created with variant information

---

### **Step 6: Admin Panel - Order Details**
**URL**: https://sjfashionhub.com/admin/orders

**What to Check**:
1. Click on the newly created order
2. In order details page, check order items section
3. [ ] Product name is displayed
4. [ ] **"Size: 30"** is shown in blue color below product name
5. [ ] SKU is displayed
6. [ ] Quantity and price are correct

**Expected Display**:
```
Black Embroidered blouses for sarees
SKU: BLK-BLS
Size: 30                    ← Should be in blue
₹599 × 1 = ₹599
```

**Expected Result**: ✅ Admin can see the exact variant (size) that customer ordered

---

## 🔍 Database Verification (Optional)

### Check Cart Table:
```sql
SELECT 
    c.id,
    p.name as product_name,
    pv.option1_value as size,
    c.quantity
FROM carts c
JOIN products p ON c.product_id = p.id
LEFT JOIN product_variants pv ON c.product_variant_id = pv.id
WHERE c.product_variant_id IS NOT NULL;
```

**Expected**: Cart items with `product_variant_id` should show size

### Check Order Items Table:
```sql
SELECT 
    oi.id,
    o.order_number,
    p.name as product_name,
    pv.option1_value as size,
    oi.variant_details,
    oi.quantity
FROM order_items oi
JOIN orders o ON oi.order_id = o.id
JOIN products p ON oi.product_id = p.id
LEFT JOIN product_variants pv ON oi.product_variant_id = pv.id
WHERE oi.product_variant_id IS NOT NULL
ORDER BY oi.created_at DESC
LIMIT 5;
```

**Expected**: New order items should have `product_variant_id` and `variant_details` populated

---

## ✅ Success Criteria

All checkboxes above should be checked (✓) for the implementation to be considered successful.

### Critical Points:
1. ✅ Size selector works on product page
2. ✅ Selected size is saved when adding to cart
3. ✅ Size is **visible in cart page** (in blue color)
4. ✅ Size is **visible in checkout page** (in blue color)
5. ✅ Size is **saved in order** (product_variant_id + variant_details)
6. ✅ Size is **visible in admin panel** (in blue color)

---

## 🐛 Troubleshooting

### Issue: Size not showing in cart
**Solution**: Clear browser cache and refresh page. Ensure you're logged in or using the same session.

### Issue: Size not showing in admin panel
**Solution**: 
1. Check if order was created after the update (old orders won't have variant data)
2. Clear Laravel cache: `php artisan cache:clear && php artisan view:clear`

### Issue: Size selector not working on product page
**Solution**: 
1. Check browser console for JavaScript errors
2. Ensure product has variants in database
3. Clear browser cache

---

## 📊 Current Status

### Existing Data:
- ✅ **9 blouse products** with variants
- ✅ **72 total variants** (8 sizes per blouse: 26, 30, 32, 34, 36, 38, 40, 42)
- ✅ **2 cart items** already have variant data (Size: 30)
- ⚠️ **Previous orders** don't have variant data (created before update)

### Test Products:
1. Black Embroidered blouses for sarees (8 variants)
2. Blue Embroidered blouses for sarees (8 variants)
3. Maroon Embroidered blouses for sarees (8 variants)
4. Pink Embroidered blouses for sarees (8 variants)
5. Red Embroidered blouses for sarees (8 variants)
6. White Embroidered blouses for sarees (8 variants)
7. Yellow Embroidered blouses for sarees (8 variants)
8. Green Embroidered blouses for sarees (8 variants)
9. Orange Embroidered blouses for sarees (8 variants)

---

## 🎉 Expected Outcome

After completing all test steps, you should be able to:
1. Select a specific size variant on product page
2. See the selected size in cart
3. See the selected size in checkout
4. Complete the order
5. View the order in admin panel with the exact size variant displayed

**This ensures that admin can process the correct size that the customer ordered!**

