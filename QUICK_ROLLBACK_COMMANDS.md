# 🚨 EMERGENCY ROLLBACK COMMANDS - Quick Reference

## ⚡ **INSTANT ROLLBACK COMMANDS**

### 🔥 **EMERGENCY: Go back to last working version**
```bash
git reset --hard HEAD~1
```

### 🔥 **EMERGENCY: Go back 3 commits**
```bash
git reset --hard HEAD~3
```

### 🔥 **EMERGENCY: Go back to specific commit**
```bash
# First, find the commit hash
git log --oneline

# Then rollback (replace COMMIT_HASH with actual hash)
git reset --hard COMMIT_HASH
```

### 🔥 **EMERGENCY: Undo changes but keep work**
```bash
git reset --soft HEAD~1
```

---

## 📋 **QUICK STATUS CHECKS**

### Check what's changed
```bash
git status
```

### See recent commits
```bash
git log --oneline -10
```

### See what will be lost before rollback
```bash
git show HEAD
```

---

## 🛡️ **SAFE ROLLBACK (Recommended)**

### 1. Create backup before rollback
```bash
git branch backup-before-rollback
```

### 2. Then rollback safely
```bash
git reset --hard HEAD~1
```

### 3. If you need your changes back
```bash
git checkout backup-before-rollback
```

---

## 🎯 **SPECIFIC FILE ROLLBACK**

### Undo changes to one file
```bash
git checkout HEAD -- path/to/file.php
```

### Undo changes to payment gateway files
```bash
git checkout HEAD -- sjfashionhub/app/Http/Controllers/Admin/PaymentGatewayController.php
```

---

## 📊 **BRANCH MANAGEMENT**

### Switch to stable backup
```bash
git checkout backup-stable
```

### Create new feature branch
```bash
git checkout -b feature/new-changes
```

### Delete problematic branch
```bash
git branch -D problematic-branch
```

---

## 🆘 **NUCLEAR OPTION (Use with caution)**

### Reset everything to initial commit
```bash
git reset --hard 9fb0aa3
```

### Clean all untracked files
```bash
git clean -fd
```

---

## 💡 **BEFORE YOU ROLLBACK**

1. **Check what you'll lose:**
   ```bash
   git diff HEAD~1 HEAD
   ```

2. **Create a backup:**
   ```bash
   git branch emergency-backup
   ```

3. **Then rollback safely:**
   ```bash
   git reset --hard HEAD~1
   ```

---

## 🔍 **FIND SPECIFIC COMMITS**

### Find commits by date
```bash
git log --since="2 days ago" --oneline
```

### Find commits by message
```bash
git log --grep="payment" --oneline
```

### Find commits that changed specific file
```bash
git log --oneline -- sjfashionhub/app/Models/PaymentGateway.php
```

---

## ⚠️ **IMPORTANT NOTES**

- `--hard` **DESTROYS** your changes permanently
- `--soft` **KEEPS** your changes staged
- Always create a backup branch before major rollbacks
- Use `git status` to check current state
- Use `git log --oneline` to see commit history

---

## 🎯 **COMMON SCENARIOS**

### "I just broke the payment system"
```bash
git branch emergency-backup
git reset --hard HEAD~1
```

### "I want to test something risky"
```bash
git checkout -b experiment
# Make changes
# If it breaks: git checkout master
```

### "I need to go back to yesterday"
```bash
git log --since="yesterday" --oneline
git reset --hard COMMIT_HASH
```

---

## 📞 **HELP COMMANDS**

```bash
git help reset
git help checkout
git help branch
```

**Remember: When in doubt, create a backup branch first!** 🛡️
