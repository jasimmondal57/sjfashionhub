# 📍 Location-Based Shipping Guide

## Overview
The location-based shipping feature allows you to set different shipping rates based on customer location - both domestic (state-wise for India) and international (country-wise).

---

## 🎯 Key Features

### ✅ Domestic Shipping (India)
- **State-wise rates**: Set different rates for different Indian states
- **36 States & UTs**: All Indian states and union territories available
- **Zone-based**: Create zones like "West Bengal", "Rest of India", etc.
- **Dropdown selection**: Easy multi-select dropdown for states

### ✅ International Shipping
- **Country-wise rates**: Set different rates for different countries
- **200+ Countries**: Comprehensive list of countries worldwide
- **Zone-based**: Create zones like "Asia", "Europe", "North America"
- **Dropdown selection**: Easy multi-select dropdown for countries

### ✅ Automatic Detection
- **Cart Page**: Automatically detects state/country from user's default address
- **Checkout Page**: Updates shipping cost based on selected delivery address
- **Real-time**: Shipping cost updates instantly when address changes

---

## 🚀 How to Set Up

### Step 1: Enable Location-Based Shipping

1. Go to **Admin Panel** → **Shipping Settings**
2. Select **"Location Based"** as shipping method
3. Check **"Enable Location-Based Shipping"**

### Step 2: Configure Domestic Shipping (India)

#### Example: West Bengal + Rest of India

**Zone 1: West Bengal**
1. Click **"Add Domestic Zone"**
2. Enter Zone Name: `West Bengal`
3. Set Shipping Rate: `₹79`
4. Set Delivery Days: `3`
5. Select States: Choose `West Bengal` from dropdown
6. Click **Save Settings**

**Zone 2: Rest of India**
1. Click **"Add Domestic Zone"** again
2. Enter Zone Name: `Rest of India`
3. Set Shipping Rate: `₹99`
4. Set Delivery Days: `5`
5. Select States: Choose all other states (hold Ctrl/Cmd to select multiple)
6. Click **Save Settings**

### Step 3: Configure International Shipping

#### Example: Asia + Europe + Rest of World

**Enable International Shipping:**
1. Click on **"International"** tab
2. Check **"Enable International Shipping"**
3. Set Default International Rate: `₹999` (for countries not in any zone)

**Zone 1: Asia**
1. Click **"Add International Zone"**
2. Enter Zone Name: `Asia`
3. Set Shipping Rate: `₹499`
4. Set Delivery Days: `7`
5. Select Countries: Choose Asian countries (Singapore, Malaysia, Thailand, etc.)
6. Click **Save Settings**

**Zone 2: Europe**
1. Click **"Add International Zone"**
2. Enter Zone Name: `Europe`
3. Set Shipping Rate: `₹799`
4. Set Delivery Days: `10`
5. Select Countries: Choose European countries (UK, Germany, France, etc.)
6. Click **Save Settings**

---

## 💡 Example Scenarios

### Scenario 1: E-commerce Store in Kolkata

**Business Need:**
- Lower shipping for West Bengal (local)
- Standard rate for rest of India
- Premium rate for international

**Configuration:**
```
Domestic Zones:
  Zone 1: West Bengal
    - States: West Bengal
    - Rate: ₹49
    - Delivery: 2-3 days

  Zone 2: Rest of India
    - States: All other 35 states
    - Rate: ₹99
    - Delivery: 5-7 days

International:
  - Enabled: Yes
  - Default Rate: ₹999
  - Delivery: 10-15 days
```

**Customer Experience:**
- Customer in Kolkata: Shipping = ₹49
- Customer in Mumbai: Shipping = ₹99
- Customer in USA: Shipping = ₹999

---

### Scenario 2: Fashion Store with Regional Pricing

**Business Need:**
- Different rates for North, South, East, West India
- Special rates for metro cities
- International shipping to select countries only

**Configuration:**
```
Domestic Zones:
  Zone 1: North India
    - States: Delhi, Punjab, Haryana, UP, etc.
    - Rate: ₹89
    - Delivery: 4-5 days

  Zone 2: South India
    - States: Karnataka, Tamil Nadu, Kerala, etc.
    - Rate: ₹99
    - Delivery: 5-6 days

  Zone 3: East India
    - States: West Bengal, Bihar, Odisha, etc.
    - Rate: ₹79
    - Delivery: 4-5 days

  Zone 4: West India
    - States: Maharashtra, Gujarat, Goa, etc.
    - Rate: ₹89
    - Delivery: 4-5 days

International Zones:
  Zone 1: SAARC Countries
    - Countries: Bangladesh, Pakistan, Sri Lanka, Nepal
    - Rate: ₹299
    - Delivery: 7-10 days

  Zone 2: Middle East
    - Countries: UAE, Saudi Arabia, Qatar, Kuwait
    - Rate: ₹599
    - Delivery: 10-12 days
```

---

## 🔄 How It Works in Cart & Checkout

### Cart Page

**Without Address:**
- Shows default flat rate or first zone rate
- Message: "Add delivery address for accurate shipping"

**With Default Address:**
```javascript
// Automatically detects state from user's default address
User Address: Kolkata, West Bengal, India

Shipping Calculation:
1. Checks country: India (domestic)
2. Checks state: West Bengal
3. Finds matching zone: "West Bengal Zone"
4. Applies rate: ₹49

Cart Display:
  Subtotal: ₹1,000
  Shipping: ₹49 (West Bengal)
  Total: ₹1,049
```

### Checkout Page

**Address Selection:**
```javascript
// Updates shipping when user selects different address
User selects: Mumbai, Maharashtra, India

Shipping Calculation:
1. Checks country: India (domestic)
2. Checks state: Maharashtra
3. Finds matching zone: "Rest of India Zone"
4. Applies rate: ₹99

Checkout Display:
  Subtotal: ₹1,000
  Shipping: ₹99 (Rest of India)
  Total: ₹1,099
```

**International Address:**
```javascript
// International shipping calculation
User selects: New York, USA

Shipping Calculation:
1. Checks country: USA (international)
2. International shipping enabled: Yes
3. Checks if USA in any zone: No
4. Applies default international rate: ₹999

Checkout Display:
  Subtotal: ₹1,000
  Shipping: ₹999 (International)
  Total: ₹1,999
```

---

## 📊 Technical Implementation

### Backend (ShippingSetting Model)

```php
// Calculates shipping based on destination
public function calculateShipping($cartTotal, $totalWeight = null, $destination = null)
{
    // Check if location-based shipping is enabled
    if ($this->shipping_method !== 'location_based') {
        return $this->flat_rate;
    }

    // Get country and state from destination
    $country = $destination['country'] ?? 'India';
    $state = $destination['state'] ?? null;

    // Domestic (India) or International
    if (strtolower($country) === 'india') {
        return $this->calculateDomesticShipping($state);
    } else {
        return $this->calculateInternationalShipping($country);
    }
}
```

### Frontend (Cart/Checkout)

```javascript
// Cart page - sends state/country to calculate shipping
fetch('/cart/calculate-shipping', {
    method: 'POST',
    body: JSON.stringify({
        cart_total: totalWithTax,
        state: userState,
        country: userCountry
    })
})
.then(response => response.json())
.then(data => {
    // Update shipping cost display
    document.getElementById('shipping').textContent = `₹${data.shipping}`;
});
```

---

## 🎨 User Interface

### Admin Panel

**Domestic Tab:**
- Clean card-based layout
- Zone name input
- Shipping rate input (₹)
- Delivery days input
- Multi-select dropdown for states
- Add/Remove zone buttons

**International Tab:**
- Enable/disable toggle
- Default international rate
- Zone cards similar to domestic
- Multi-select dropdown for countries
- Add/Remove zone buttons

### Customer View

**Cart Page:**
```
Order Summary
─────────────────
Subtotal:     ₹1,000
Shipping:     ₹49 (West Bengal)
Tax:          ₹50
─────────────────
Total:        ₹1,099
```

**Checkout Page:**
```
Delivery Address: [Select Address ▼]
  ○ Home - Kolkata, West Bengal
  ○ Office - Mumbai, Maharashtra

Shipping: ₹49 (2-3 days delivery)
```

---

## ✅ Best Practices

### 1. **Create a "Rest of India" Zone**
Always create a catch-all zone for states not in specific zones:
```
Zone: Rest of India
States: Select all remaining states
Rate: Standard rate (e.g., ₹99)
```

### 2. **Logical Zone Grouping**
Group states logically:
- By region (North, South, East, West)
- By distance from warehouse
- By delivery time
- By shipping cost

### 3. **International Zones**
Group countries by:
- Geographic proximity (Asia, Europe, Americas)
- Shipping cost similarity
- Delivery time
- Popular destinations

### 4. **Delivery Days**
Be realistic with delivery estimates:
- Local state: 2-3 days
- Nearby states: 3-5 days
- Far states: 5-7 days
- International: 7-15 days

### 5. **Pricing Strategy**
- **Local**: Lower rates to encourage local sales
- **Regional**: Moderate rates for nearby states
- **National**: Standard rates for rest of country
- **International**: Premium rates to cover costs

---

## 🧪 Testing Your Configuration

### Test 1: Domestic Shipping
1. Add products to cart
2. Go to checkout
3. Select address in West Bengal
4. Verify shipping shows ₹49 (or your configured rate)
5. Change address to Maharashtra
6. Verify shipping updates to ₹99 (or your configured rate)

### Test 2: International Shipping
1. Add products to cart
2. Go to checkout
3. Select/add international address (e.g., USA)
4. Verify shipping shows international rate
5. Verify delivery days show international estimate

### Test 3: Zone Coverage
1. Test addresses from different states
2. Ensure every state has a matching zone
3. Verify "Rest of India" catches unassigned states

---

## 🔧 Troubleshooting

### Issue: Shipping not updating in cart
**Solution:** 
- Ensure user has a default address set
- Check if location-based shipping is enabled
- Clear browser cache

### Issue: Wrong shipping rate applied
**Solution:**
- Verify state spelling matches exactly
- Check if state is assigned to correct zone
- Ensure no duplicate state assignments

### Issue: International shipping not working
**Solution:**
- Check "Enable International Shipping" is checked
- Verify default international rate is set
- Ensure country is not "India"

### Issue: State not found in dropdown
**Solution:**
- All 36 Indian states/UTs are included
- Check spelling (e.g., "Odisha" not "Orissa")
- Use exact names from dropdown

---

## 📱 Mobile Responsiveness

All location-based shipping features work perfectly on:
- ✅ Desktop browsers
- ✅ Tablets
- ✅ Mobile phones
- ✅ All screen sizes

---

## 🚀 Quick Start Checklist

- [ ] Enable location-based shipping method
- [ ] Create domestic zones for India
- [ ] Assign states to each zone
- [ ] Set shipping rates for each zone
- [ ] Enable international shipping (if needed)
- [ ] Set default international rate
- [ ] Create international zones (optional)
- [ ] Test with different addresses
- [ ] Verify cart updates correctly
- [ ] Verify checkout updates correctly
- [ ] Test on mobile devices

---

**Last Updated:** 2025-10-01  
**Version:** 1.0  
**Feature:** Location-Based Shipping with Domestic & International Support

