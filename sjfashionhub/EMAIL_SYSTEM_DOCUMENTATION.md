# SJ Fashion Hub - Email Notification System

## Overview

A comprehensive email notification system has been implemented for SJ Fashion Hub that automatically sends emails to customers and admins for various order events, user registrations, and system alerts.

## Features

### ✅ **Customer Email Templates**
- **Order Placed** - Sent when customer places an order
- **Order Confirmed** - Sent when admin confirms the order
- **Order Ready to Ship** - Sent when order is ready for shipping
- **Order Shipped** - Sent when order is dispatched with tracking details
- **Order Out for Delivery** - Sent when order is out for delivery
- **Order Delivered** - Sent when order is successfully delivered
- **Order Cancelled** - Sent when order is cancelled
- **Return Request Submitted** - Sent when customer submits return request
- **Return Approved** - Sent when return request is approved
- **Welcome Email** - Sent when new customer registers

### ✅ **Admin Email Templates**
- **New Order Alert** - Sent to admins when new order is placed
- **Return Request Alert** - Sent to admins when return request is submitted
- **Low Stock Alert** - Sent to admins when product stock is low

## System Components

### 1. **Email Templates** (`CommunicationTemplate` Model)
- **Location**: Admin Panel > Communication > Templates
- **Features**: HTML and text content, variable substitution, multilingual support
- **Management**: Full CRUD operations through admin panel

### 2. **Email Notification Service** (`EmailNotificationService`)
- **Location**: `app/Services/EmailNotificationService.php`
- **Purpose**: Handles all email sending logic with template rendering
- **Features**: Error handling, logging, variable substitution

### 3. **Model Observers** (Auto-trigger emails)
- **OrderObserver**: Triggers emails on order status changes
- **ReturnOrderObserver**: Triggers emails on return status changes
- **UserObserver**: Triggers welcome email on user registration
- **ProductObserver**: Triggers low stock alerts

### 4. **Communication Logs** (`CommunicationLog` Model)
- **Location**: Admin Panel > Communication > Logs
- **Purpose**: Track all sent emails with status and error details
- **Features**: Success/failure tracking, error messages, recipient details

## Email Templates Created

### Customer Templates

#### 1. Order Placed
- **Event**: `order_placed_customer`
- **Trigger**: When order is created
- **Variables**: `user_name`, `order_number`, `order_total`, `payment_method`, `tracking_url`, `site_name`

#### 2. Order Confirmed
- **Event**: `order_confirmed_customer`
- **Trigger**: When order status changes to 'confirmed'
- **Variables**: `user_name`, `order_number`, `order_total`, `estimated_delivery`, `tracking_url`, `site_name`

#### 3. Order Ready to Ship
- **Event**: `order_ready_to_ship_customer`
- **Trigger**: When order status changes to 'ready_to_ship'
- **Variables**: `user_name`, `order_number`, `estimated_delivery`, `tracking_url`, `site_name`

#### 4. Order Shipped
- **Event**: `order_shipped_customer`
- **Trigger**: When order status changes to 'in_transit'
- **Variables**: `user_name`, `order_number`, `tracking_number`, `courier_company`, `estimated_delivery`, `tracking_url`, `site_name`

#### 5. Order Out for Delivery
- **Event**: `order_out_for_delivery_customer`
- **Trigger**: When order status changes to 'out_for_delivery'
- **Variables**: `user_name`, `order_number`, `tracking_number`, `courier_company`, `delivery_date`, `tracking_url`, `site_name`

#### 6. Order Delivered
- **Event**: `order_delivered_customer`
- **Trigger**: When order status changes to 'delivered'
- **Variables**: `user_name`, `order_number`, `delivery_date`, `return_policy_url`, `review_url`, `site_name`

#### 7. Order Cancelled
- **Event**: `order_cancelled_customer`
- **Trigger**: When order status changes to 'cancelled'
- **Variables**: `user_name`, `order_number`, `cancellation_reason`, `refund_amount`, `refund_timeline`, `site_name`

#### 8. Return Request Submitted
- **Event**: `return_request_submitted_customer`
- **Trigger**: When return request is created
- **Variables**: `user_name`, `return_number`, `order_number`, `return_reason`, `return_items`, `processing_timeline`, `site_name`

#### 9. Return Approved
- **Event**: `return_approved_customer`
- **Trigger**: When return status changes to 'approved'
- **Variables**: `user_name`, `return_number`, `pickup_date`, `pickup_instructions`, `refund_amount`, `refund_timeline`, `site_name`

#### 10. Welcome Email
- **Event**: `user_registered`
- **Trigger**: When new customer registers
- **Variables**: `user_name`, `user_email`, `site_name`, `site_url`, `login_url`

### Admin Templates

#### 1. New Order Alert
- **Event**: `new_order_admin`
- **Trigger**: When new order is placed
- **Variables**: `order_number`, `customer_name`, `customer_email`, `order_total`, `payment_method`, `order_items`, `admin_url`, `site_name`

#### 2. Return Request Alert
- **Event**: `return_request_admin`
- **Trigger**: When return request is submitted
- **Variables**: `return_number`, `order_number`, `customer_name`, `return_reason`, `return_items`, `admin_url`, `site_name`

#### 3. Low Stock Alert
- **Event**: `low_stock_alert_admin`
- **Trigger**: When product stock falls below threshold
- **Variables**: `product_name`, `product_sku`, `current_stock`, `threshold`, `admin_url`, `site_name`

## Commands Available

### 1. Create Email Templates
```bash
# Create basic email templates
php artisan templates:create-email --force

# Create extended email templates
php artisan templates:create-extended --force
```

### 2. Test Email Templates
```bash
# Test welcome email
php artisan email:test welcome --email=test@example.com

# Test order placed email
php artisan email:test order-placed --email=test@example.com

# Test order shipped email
php artisan email:test order-shipped --email=test@example.com

# Test order delivered email
php artisan email:test order-delivered --email=test@example.com

# Test low stock alert
php artisan email:test low-stock --email=admin@example.com
```

## Configuration

### Mail Settings
Configure in `.env` file:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@sjfashionhub.in
MAIL_FROM_NAME="SJ Fashion Hub"
```

### Admin Email Recipients
Admin emails are sent to all users with role 'admin' or 'super_admin'.

## Automatic Triggers

### Order Status Changes
- **pending → confirmed**: Order Confirmed email
- **confirmed → ready_to_ship**: Order Ready to Ship email
- **ready_to_ship → in_transit**: Order Shipped email
- **in_transit → out_for_delivery**: Order Out for Delivery email
- **out_for_delivery → delivered**: Order Delivered email
- **any → cancelled**: Order Cancelled email

### Return Status Changes
- **created**: Return Request Submitted email (customer) + Return Request Alert (admin)
- **approved**: Return Approved email (customer)

### User Registration
- **created**: Welcome email (for customers only)

### Stock Management
- **stock_quantity ≤ low_stock_threshold**: Low Stock Alert (admin)
- **Spam Prevention**: Only one alert per hour per product

## Admin Panel Management

### Templates Management
1. Go to **Admin Panel > Communication > Templates**
2. View all email templates
3. Edit template content, subject, and variables
4. Enable/disable templates
5. Preview templates with sample data

### Communication Logs
1. Go to **Admin Panel > Communication > Logs**
2. View all sent emails
3. Check delivery status
4. View error messages for failed emails
5. Filter by recipient, template, or date

## Technical Details

### File Structure
```
app/
├── Services/
│   ├── EmailNotificationService.php
│   └── MailConfigService.php
├── Observers/
│   ├── OrderObserver.php
│   ├── ReturnOrderObserver.php
│   ├── UserObserver.php
│   └── ProductObserver.php
├── Console/Commands/
│   ├── CreateEmailTemplates.php
│   ├── CreateEmailTemplatesExtended.php
│   └── TestEmailTemplates.php
└── Models/
    ├── CommunicationTemplate.php
    └── CommunicationLog.php
```

### Error Handling
- All email failures are logged in `CommunicationLog`
- Errors are logged in Laravel logs
- System continues to function even if emails fail
- Retry mechanism can be implemented if needed

## Customization

### Adding New Templates
1. Create template via admin panel or command
2. Add method to `EmailNotificationService`
3. Add trigger in appropriate observer
4. Test with `php artisan email:test`

### Modifying Templates
1. Edit via Admin Panel > Communication > Templates
2. Use `{{variable_name}}` for dynamic content
3. Test changes with test command

### Adding Variables
1. Update template variables array
2. Pass variables in service method
3. Document in this file

## Troubleshooting

### Common Issues
1. **Emails not sending**: Check mail configuration in `.env`
2. **Templates not found**: Run template creation commands
3. **Variables not replacing**: Check variable names match exactly
4. **Admin emails not received**: Verify admin users exist with correct roles

### Debugging
1. Check `CommunicationLog` for email status
2. Check Laravel logs for errors
3. Use test commands to verify functionality
4. Verify mail configuration with test email

## Status: ✅ COMPLETE

All email templates have been created and deployed successfully. The system is fully functional and ready for production use.

**Total Templates Created**: 13 (10 customer + 3 admin)
**Auto-triggers**: ✅ Enabled
**Admin Management**: ✅ Available
**Logging**: ✅ Enabled
**Testing**: ✅ Available
