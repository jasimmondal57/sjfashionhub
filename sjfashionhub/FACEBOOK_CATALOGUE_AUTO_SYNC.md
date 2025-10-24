# 📅 Facebook Catalogue Auto-Sync Setup

## ✅ What's Been Implemented

Your sjfashionhub.com now has **automatic Facebook Catalogue syncing** with:

1. **Hourly Full Sync** - All products synced every hour
2. **Sold-Out Detection** - Products marked as sold-out every 30 minutes
3. **Real-time Updates** - Immediate sync when stock changes
4. **Scheduled Commands** - Laravel scheduler handles all automation
5. **Error Logging** - All sync activities logged for monitoring

---

## 🔧 How It Works

### Automatic Sync Schedule

| Task | Frequency | Purpose |
|------|-----------|---------|
| Full Catalogue Sync | Every hour | Sync all active products to Facebook |
| Sold-Out Check | Every 30 minutes | Mark sold-out products in Facebook |
| Daily Full Sync | Daily at 00:00 | Complete catalogue refresh |

### Real-Time Updates

When you update a product:
- **Stock changes** → Immediately synced to Facebook
- **Price changes** → Immediately synced to Facebook
- **Product details** → Immediately synced to Facebook
- **Product sold out** → Immediately marked as "out of stock" on Facebook

---

## 📁 Files Created/Modified

### New Files:
1. **app/Console/Kernel.php** - Scheduler configuration
2. **app/Console/Commands/SyncFacebookCatalogue.php** - Hourly sync command
3. **app/Console/Commands/SyncFacebookSoldout.php** - Sold-out sync command
4. **database/migrations/2025_10_24_add_auto_sync_enabled_to_facebook_settings.php** - Database migration

### Modified Files:
1. **app/Models/FacebookSetting.php** - Added auto_sync_enabled field
2. **app/Observers/ProductFacebookObserver.php** - Enhanced sold-out detection

---

## 🚀 Setup Instructions

### Step 1: Run Migration
```bash
php artisan migrate
```

This adds the `auto_sync_enabled` column to the facebook_settings table.

### Step 2: Enable Auto-Sync in Admin Panel
1. Go to: **https://sjfashionhub.com/admin/facebook**
2. Check "Enable Auto-Sync" checkbox
3. Save settings

### Step 3: Configure Scheduler

**On Linux/Unix Server:**

Add this to your crontab:
```bash
* * * * * cd /var/www/sjfashionhub.com && php artisan schedule:run >> /dev/null 2>&1
```

**Command to add:**
```bash
crontab -e
```

Then add the line above.

**On Windows Server:**

Use Windows Task Scheduler to run:
```
php artisan schedule:run
```

Every minute.

---

## 📊 Monitoring Sync Status

### Check Sync Logs
```bash
# View recent sync logs
tail -f /var/www/sjfashionhub.com/storage/logs/laravel.log | grep "Facebook"

# Or in admin panel:
# Go to Admin → Facebook Integration → Sync Logs
```

### Manual Sync Commands

**Sync all products now:**
```bash
php artisan facebook:sync-catalogue
```

**Force sync (even if recently synced):**
```bash
php artisan facebook:sync-catalogue --force
```

**Sync sold-out products:**
```bash
php artisan facebook:sync-soldout
```

---

## 🔍 Troubleshooting

### Issue: Scheduler not running

**Solution 1: Check cron job**
```bash
crontab -l
```

Should show the schedule:run command.

**Solution 2: Verify permissions**
```bash
chmod 755 /var/www/sjfashionhub.com
```

**Solution 3: Check Laravel logs**
```bash
tail -100 /var/www/sjfashionhub.com/storage/logs/laravel.log
```

### Issue: Products not syncing

**Check if auto-sync is enabled:**
- Admin → Facebook Integration → Check "Enable Auto-Sync"

**Check if catalogue is configured:**
- Admin → Facebook Integration → Verify Catalog ID and Access Token

**Manual sync:**
```bash
php artisan facebook:sync-catalogue --force
```

### Issue: Sold-out products not updating

**Manual sync sold-out:**
```bash
php artisan facebook:sync-soldout
```

**Check product stock:**
- Verify stock_quantity is 0 or less in database

---

## 📈 Performance Considerations

### Sync Frequency
- **Hourly sync** - Balances freshness with API rate limits
- **30-minute sold-out check** - Catches stock changes quickly
- **Real-time updates** - Immediate for critical changes

### API Rate Limits
- Facebook allows ~200 requests per hour
- Hourly sync uses ~1 request per product
- Safe for catalogs up to 100+ products

### Database Impact
- Minimal - only updates last_synced_at timestamp
- Logs stored in facebook_sync_logs table
- Old logs can be archived/deleted

---

## 🎯 Best Practices

1. **Enable Auto-Sync** - Always keep enabled for real-time updates
2. **Monitor Logs** - Check logs weekly for errors
3. **Test Manually** - Run `php artisan facebook:sync-catalogue` after setup
4. **Verify in Facebook** - Check Meta Business Suite to confirm syncs
5. **Set Alerts** - Monitor for sync failures in logs

---

## 📞 Support

If auto-sync is not working:

1. Check cron job is running: `crontab -l`
2. Check Laravel logs: `tail -f storage/logs/laravel.log`
3. Run manual sync: `php artisan facebook:sync-catalogue --force`
4. Verify Facebook settings in admin panel
5. Check server permissions and disk space

---

## 🔄 What Gets Synced

### Every Hour:
- Product name
- Description
- Price & sale price
- Stock quantity
- Availability (in stock/out of stock)
- Images
- Category
- Brand
- Gender, age group, color, size, material, pattern

### Every 30 Minutes (Sold-Out Check):
- Stock quantity
- Availability status

### Real-Time (When Changed):
- Stock quantity
- Price
- Sale price
- Product details (name, description, images)

---

## ✨ Next Steps

1. ✅ Run migration: `php artisan migrate`
2. ✅ Configure cron job on server
3. ✅ Enable auto-sync in admin panel
4. ✅ Test with manual sync command
5. ✅ Monitor logs for 24 hours
6. ✅ Verify in Meta Business Suite

Your Facebook Catalogue is now fully automated! 🎉

