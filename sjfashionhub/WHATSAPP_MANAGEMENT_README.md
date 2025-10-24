# WhatsApp Management System

## Overview
Comprehensive WhatsApp management system for SJ Fashion Hub that allows admins to:
- View all sent/received WhatsApp messages
- Chat directly with customers
- Manage WhatsApp orders
- Sync products to WhatsApp catalog
- Track message delivery status
- Categorize messages (Marketing, OTP, Notifications, Support, Orders)

## Features

### 1. **Dashboard** (`/admin/whatsapp/dashboard`)
- Overview of WhatsApp activity
- Message statistics (today, delivered, failed)
- Open conversations count
- Pending WhatsApp orders
- Messages by category chart
- Recent messages list
- Quick action buttons

### 2. **Message Logs** (`/admin/whatsapp/messages`)
- View all sent and received messages
- Filter by:
  - Category (Marketing, OTP, Notification, Support, Order)
  - Status (Pending, Sent, Delivered, Read, Failed)
  - Direction (Outbound, Inbound)
  - Phone number
  - Date range
- View message details
- See delivery status and timestamps

### 3. **Conversations** (`/admin/whatsapp/conversations`)
- Chat inbox for customer conversations
- Real-time message history
- Send messages directly to customers
- Assign conversations to admin users
- Mark conversations as open/closed
- Unread message indicators
- Customer information sidebar

### 4. **WhatsApp Orders** (`/admin/whatsapp/orders`)
- View orders placed via WhatsApp catalog
- Confirm pending orders
- Link WhatsApp orders to system orders
- View order items and customer details

### 5. **Product Catalog** (`/admin/whatsapp/catalog`)
- Sync products to Meta WhatsApp catalog
- View sync status (Synced, Pending, Failed)
- Bulk sync all products
- Individual product sync
- Track last sync time

## Database Tables

### `whatsapp_messages`
Stores all WhatsApp messages (sent and received)
- Message ID, direction, type, status
- Phone number, user ID
- Category, template name
- Content, media, parameters
- Timestamps (sent, delivered, read, failed)
- Error messages
- Related order/return IDs

### `whatsapp_conversations`
Manages customer conversations
- Phone number, user ID, customer name
- Status (open, closed, archived)
- Assigned admin user
- Last message details
- Unread count

### `whatsapp_catalog_products`
Tracks product sync to Meta catalog
- Product ID, Meta product ID
- Retailer ID (SKU)
- Sync status, last synced time
- Sync errors

### `whatsapp_orders`
Stores orders placed via WhatsApp
- WhatsApp order ID
- Linked system order ID
- Customer details
- Order items (JSON)
- Total amount, status

## Installation Steps

1. **Run Migration**
```bash
php artisan migrate
```

2. **Update Routes**
Routes are already added in `routes/web.php` under `/admin/whatsapp/*`

3. **Update Admin Menu**
Add WhatsApp Management link to admin sidebar navigation

4. **Configure WhatsApp Settings**
Ensure WhatsApp Business API credentials are configured in Communication Settings

## Usage

### Viewing Messages
1. Go to `/admin/whatsapp/dashboard`
2. Click "All Messages" or navigate to `/admin/whatsapp/messages`
3. Use filters to find specific messages
4. Click on any message to view full details

### Chatting with Customers
1. Go to `/admin/whatsapp/conversations`
2. Click "Open Chat" on any conversation
3. View message history
4. Type message and click "Send"
5. Assign conversation to team member if needed

**Note:** WhatsApp has a 24-hour messaging window. You can only send free-form messages within 24 hours of customer's last message. After that, you must use approved templates.

### Managing WhatsApp Orders
1. Go to `/admin/whatsapp/orders`
2. View pending orders from WhatsApp catalog
3. Click "Confirm" to create order in system
4. View order details and customer information

### Syncing Products to Catalog
1. Go to `/admin/whatsapp/catalog`
2. Click "Sync All Products" to queue all products
3. Or click sync button on individual products
4. Monitor sync status

## Automatic Message Logging

All WhatsApp messages sent through the system are automatically logged:
- OTP messages
- Order notifications
- Return notifications
- Marketing messages
- Support messages

The `WhatsAppService` class automatically:
- Creates message records
- Links to user accounts
- Creates/updates conversations
- Categorizes messages
- Tracks delivery status

## Message Categories

- **OTP**: Login/verification codes
- **Notification**: Order updates, shipping notifications
- **Marketing**: Promotional messages, campaigns
- **Support**: Customer service messages
- **Order**: Order confirmations, updates

## API Integration

### Receiving Messages (Webhook)
Update your WhatsApp webhook handler to log incoming messages:

```php
// In WhatsAppWebhookController
WhatsAppMessage::create([
    'wamid' => $message['id'],
    'direction' => 'inbound',
    'type' => $message['type'],
    'status' => 'received',
    'phone_number' => $message['from'],
    'content' => $message['text']['body'] ?? '',
    'metadata' => $message,
]);
```

### Status Updates (Webhook)
Log delivery status updates:

```php
// Update message status
WhatsAppMessage::where('wamid', $status['id'])->update([
    'status' => $status['status'], // sent, delivered, read
    $status['status'] . '_at' => now(),
]);
```

## Future Enhancements

1. **WhatsApp Commerce Integration**
   - Automatic catalog sync
   - Order creation from WhatsApp
   - Payment link generation

2. **Chatbot Integration**
   - Automated responses
   - FAQ handling
   - Order tracking via chat

3. **Broadcast Campaigns**
   - Send bulk messages
   - Segment customers
   - Schedule messages

4. **Analytics**
   - Message delivery rates
   - Response times
   - Conversation metrics
   - ROI tracking

## Troubleshooting

### Messages not logging
- Check database connection
- Verify WhatsAppService is being used
- Check error logs

### Conversations not updating
- Ensure webhook is configured
- Check phone number format
- Verify user linking logic

### Catalog sync failing
- Check Meta API credentials
- Verify product data completeness
- Check API rate limits

## Support

For issues or questions, check:
- Laravel logs: `storage/logs/laravel.log`
- WhatsApp API logs in Communication Settings
- Database records in `whatsapp_messages` table

