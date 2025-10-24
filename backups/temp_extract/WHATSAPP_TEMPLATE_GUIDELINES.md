# WhatsApp Marketing Template Guidelines

## 🎯 **CRITICAL: Variable Samples Are REQUIRED!**

**⚠️ THIS IS WHY YOUR TEMPLATES WERE REJECTED!**

WhatsApp/Meta **REQUIRES** example values for ALL variables ({{1}}, {{2}}, {{3}}, etc.) to review your template.

**Without variable samples, your template will be automatically REJECTED.**

### **How to Provide Variable Samples:**

When creating a template with variables:
1. The form will automatically detect variables in your header and body
2. A "Variable Sample Values" section will appear
3. **You MUST fill in realistic example values for each variable**
4. Use realistic examples, NOT real customer data

**Example:**
- Variable {{1}} = "Priya Sharma" (NOT "John123" or real customer name)
- Variable {{2}} = "#SJF12345" (NOT actual order number)
- Variable {{3}} = "March 15, 2025" (NOT today's date)

---

## ✅ COMPLIANT TEMPLATE EXAMPLES

### Example 1: Order Shipped (UTILITY) ✅ RECOMMENDED
```
Display Name: Order Shipped Notification
Category: UTILITY
Language: en

Header: Order Shipped
Body: Hello {{1}},

Great news! Your order {{2}} has been shipped and is on its way to you.

Expected delivery: {{3}}

Track your shipment to see real-time updates.

Thank you for shopping with SJ Fashion Hub!

Footer: SJ Fashion Hub
Buttons:
- [URL] Track Order → https://sjfashionhub.com/track-order
- [QUICK_REPLY] Contact Support

Variable Samples (REQUIRED):
- {{1}} = "Priya Sharma"
- {{2}} = "#SJF12345"
- {{3}} = "March 15, 2025"
```

**Why this works:**
- ✅ UTILITY category (transactional, not promotional)
- ✅ Provides useful information (order status)
- ✅ Variable samples included
- ✅ Real brand name
- ✅ Working URL
- ✅ No aggressive sales language

### Example 2: New Arrivals (MARKETING)
```
Display Name: new_arrivals_notification
Category: MARKETING
Language: en

Header: New Collection Available
Body: Hi {{1}},

We've added new items to our {{2}} collection at SJ Fashion Hub. 

Browse the latest styles and find your perfect outfit. Our team is here to help you with any questions.

Footer: SJ Fashion Hub - Reply STOP to unsubscribe
Buttons:
- [URL] Browse Collection → https://sjfashionhub.com/new-arrivals
- [QUICK_REPLY] Contact Us
```

### Example 3: Order Update (UTILITY)
```
Display Name: order_status_update
Category: UTILITY
Language: en

Header: Order Update
Body: Hello {{1}},

Your order #{{2}} has been {{3}}.

Expected delivery: {{4}}

Track your order or contact us if you have any questions.

Footer: SJ Fashion Hub
Buttons:
- [URL] Track Order → https://sjfashionhub.com/track/{{2}}
- [QUICK_REPLY] Contact Support
```

---

## ❌ COMMON REJECTION REASONS

### 1. **Overly Promotional Language**
❌ DON'T USE:
- "Don't miss out!"
- "Limited time only!"
- "Act now!"
- "Hurry up!"
- "Last chance!"
- "Buy now!"

✅ USE INSTEAD:
- "This offer is available until [date]"
- "Valid for the next 7 days"
- "Available while supplies last"
- "Visit our store to learn more"

### 2. **Generic/Placeholder Content**
❌ DON'T USE:
- "Your Brand Name"
- "Your Company"
- "Our Store"

✅ USE INSTEAD:
- "SJ Fashion Hub"
- Your actual business name

### 3. **Missing Opt-Out Information**
❌ DON'T:
- Send marketing messages without opt-out option

✅ DO:
- Add "Reply STOP to unsubscribe" in footer
- Include "Contact Support" or "Manage Preferences" button

### 4. **Vague or Misleading Offers**
❌ DON'T USE:
- "Up to 90% off" (without specifics)
- "All items on sale" (too broad)
- "Huge discounts" (vague)

✅ USE INSTEAD:
- "10% off selected dresses"
- "₹500 off on orders above ₹2000"
- "Buy 2 Get 1 Free on accessories"

### 5. **Header Issues**
❌ DON'T USE IN HEADERS:
- Emojis (🎉, ❤️, 🔥)
- Asterisks (*)
- Underscores (_)
- New lines
- Formatting characters

✅ USE IN HEADERS:
- Plain text only
- Max 60 characters
- Variables allowed ({{1}}, {{2}})

---

## 📋 TEMPLATE CATEGORIES

### MARKETING
- Promotional offers
- New product announcements
- Seasonal sales
- Customer engagement

**Requirements:**
- Must provide value to customer
- Include opt-out option
- Be specific about offers
- Avoid aggressive sales language

### UTILITY
- Order confirmations
- Shipping updates
- Account notifications
- Appointment reminders

**Requirements:**
- Transactional in nature
- Provide useful information
- Related to customer's existing relationship

### AUTHENTICATION
- OTP codes
- Password resets
- Account verification
- Security alerts

**Requirements:**
- Security-related only
- Time-sensitive
- No marketing content

---

## 🎯 BEST PRACTICES

### 1. **Use Real Business Information**
- Real brand name
- Real website URLs
- Real contact information

### 2. **Be Specific**
- Exact discount amounts
- Clear expiration dates
- Specific product categories

### 3. **Provide Value**
- Useful information
- Relevant offers
- Helpful resources

### 4. **Include Call-to-Action Buttons**
- Quick Reply for simple actions
- URL buttons for website links
- Phone buttons for customer support

### 5. **Test Before Submitting**
- Check for typos
- Verify all variables
- Test button URLs
- Review for policy compliance

---

## 🚀 SUBMISSION CHECKLIST

Before submitting a template, verify:

- [ ] Real brand name used (not placeholder)
- [ ] No emojis in header
- [ ] Specific offer details (if applicable)
- [ ] Opt-out option included (for marketing)
- [ ] No aggressive sales language
- [ ] All URLs are valid and working
- [ ] Variables are properly formatted ({{1}}, {{2}})
- [ ] Footer has real brand name
- [ ] Buttons have proper URLs (for URL type)
- [ ] Content is clear and professional

---

## 📞 NEED HELP?

If your template is rejected:

1. **Review the rejection reason** in WhatsApp Manager
2. **Check this guide** for common issues
3. **Edit and resubmit** the template
4. **Request a review** in Business Support Home if you believe it's compliant

**Meta's WhatsApp Business Policy:**
https://www.whatsapp.com/legal/business-policy

**Template Guidelines:**
https://developers.facebook.com/docs/whatsapp/message-templates/guidelines

