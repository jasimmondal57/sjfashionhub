# 🔧 Setup Cron Job for Facebook Catalogue Auto-Sync

## 📋 Overview

The Facebook Catalogue auto-sync requires a cron job to run Laravel's scheduler every minute. This guide will help you set it up on your server.

---

## 🚀 Quick Setup (Linux/Unix)

### Step 1: SSH into your server
```bash
ssh -i ~/.ssh/id_ed25519_marketplace root@72.60.102.152
```

### Step 2: Open crontab editor
```bash
crontab -e
```

### Step 3: Add the scheduler command
Add this line to the crontab:
```bash
* * * * * cd /var/www/sjfashionhub.com && php artisan schedule:run >> /dev/null 2>&1
```

### Step 4: Save and exit
- Press `Ctrl+X` (if using nano)
- Type `Y` and press Enter to confirm

### Step 5: Verify the cron job
```bash
crontab -l
```

You should see the line you just added.

---

## ✅ Verification

### Check if cron is running
```bash
ps aux | grep cron
```

Should show: `cron` process running

### Check cron logs
```bash
tail -f /var/log/syslog | grep CRON
```

Or on some systems:
```bash
tail -f /var/log/cron
```

### Test the scheduler manually
```bash
cd /var/www/sjfashionhub.com
php artisan schedule:run
```

Should output something like:
```
Running scheduled command: facebook:sync-catalogue
Running scheduled command: facebook:sync-soldout
```

---

## 📊 What the Cron Job Does

Every minute, the cron job runs:
```bash
php artisan schedule:run
```

This checks the scheduler and runs any commands that are due:

| Time | Command | Purpose |
|------|---------|---------|
| Every hour | `facebook:sync-catalogue` | Sync all products to Facebook |
| Every 30 min | `facebook:sync-soldout` | Check and sync sold-out products |
| Daily 00:00 | `facebook:sync-catalogue` | Full catalogue refresh |

---

## 🔍 Troubleshooting

### Issue: Cron job not running

**Check 1: Is cron service running?**
```bash
systemctl status cron
```

If not running:
```bash
systemctl start cron
systemctl enable cron
```

**Check 2: Is the crontab entry correct?**
```bash
crontab -l
```

Should show the schedule:run command.

**Check 3: Check file permissions**
```bash
ls -la /var/www/sjfashionhub.com/app/Console/Kernel.php
```

Should be readable by the web server user.

### Issue: Scheduler not executing commands

**Check Laravel logs:**
```bash
tail -100 /var/www/sjfashionhub.com/storage/logs/laravel.log | grep -i "facebook\|schedule"
```

**Check if Kernel.php is loaded:**
```bash
cd /var/www/sjfashionhub.com
php artisan list | grep facebook
```

Should show:
```
facebook:sync-catalogue    Sync all products to Facebook catalogue every hour
facebook:sync-soldout      Sync sold-out products to Facebook catalogue
```

### Issue: Permission denied

**Fix permissions:**
```bash
chown -R www-data:www-data /var/www/sjfashionhub.com
chmod -R 755 /var/www/sjfashionhub.com
```

---

## 📝 Manual Testing

### Test the sync command directly
```bash
cd /var/www/sjfashionhub.com
php artisan facebook:sync-catalogue
```

Expected output:
```
Starting Facebook Catalogue sync...
✅ Sync completed!
📊 Synced: 45 products
❌ Failed: 0 products
```

### Test sold-out sync
```bash
php artisan facebook:sync-soldout
```

Expected output:
```
Checking for sold-out products...
Found 5 sold-out products. Syncing...
✅ Sold-out sync completed!
📊 Updated: 5 products
❌ Failed: 0 products
```

---

## 🎯 Best Practices

1. **Always verify cron is running** after setup
2. **Check logs regularly** for errors
3. **Test manually** before relying on automation
4. **Monitor sync frequency** - ensure it's not too aggressive
5. **Keep backups** of your crontab: `crontab -l > crontab_backup.txt`

---

## 📞 Support

If the cron job is not working:

1. SSH into server: `ssh -i ~/.ssh/id_ed25519_marketplace root@72.60.102.152`
2. Check cron status: `systemctl status cron`
3. View crontab: `crontab -l`
4. Check logs: `tail -f /var/log/syslog | grep CRON`
5. Test manually: `cd /var/www/sjfashionhub.com && php artisan schedule:run`

---

## 🔄 Cron Job Reference

### Current Setup
```bash
* * * * * cd /var/www/sjfashionhub.com && php artisan schedule:run >> /dev/null 2>&1
```

### Breakdown:
- `*` = Every minute
- `*` = Every hour
- `*` = Every day of month
- `*` = Every month
- `*` = Every day of week
- `cd /var/www/sjfashionhub.com` = Change to app directory
- `php artisan schedule:run` = Run Laravel scheduler
- `>> /dev/null 2>&1` = Suppress output (optional, can be removed for debugging)

### Alternative with logging:
```bash
* * * * * cd /var/www/sjfashionhub.com && php artisan schedule:run >> /var/www/sjfashionhub.com/storage/logs/cron.log 2>&1
```

This logs all cron output to `storage/logs/cron.log` for debugging.

---

## ✨ Next Steps

1. ✅ SSH into server
2. ✅ Add cron job: `crontab -e`
3. ✅ Verify: `crontab -l`
4. ✅ Test: `php artisan schedule:run`
5. ✅ Monitor logs for 24 hours
6. ✅ Verify syncs in Meta Business Suite

Your Facebook Catalogue auto-sync is now fully automated! 🎉

