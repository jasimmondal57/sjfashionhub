# 🚀 Git Version Control Guide for SJ Fashion Hub

## 📋 Quick Reference Commands

### 🔍 **Check Status & History**
```bash
# Check current status
git status

# View commit history
git log --oneline

# View detailed history with changes
git log --stat

# View last 5 commits
git log --oneline -5
```

### 💾 **Making Commits**
```bash
# Add all changes
git add .

# Add specific files
git add path/to/file.php

# Commit with message
git commit -m "Your commit message"

# Add and commit in one command
git commit -am "Your commit message"
```

### ⏪ **Easy Rollback Commands**

#### **1. Undo Last Commit (Keep Changes)**
```bash
git reset --soft HEAD~1
```

#### **2. Undo Last Commit (Discard Changes)**
```bash
git reset --hard HEAD~1
```

#### **3. Undo Multiple Commits**
```bash
# Undo last 3 commits (keep changes)
git reset --soft HEAD~3

# Undo last 3 commits (discard changes)
git reset --hard HEAD~3
```

#### **4. Rollback to Specific Commit**
```bash
# Find commit hash first
git log --oneline

# Rollback to specific commit (replace COMMIT_HASH)
git reset --hard COMMIT_HASH
```

#### **5. Undo Changes to Specific File**
```bash
# Restore file to last committed version
git checkout HEAD -- path/to/file.php

# Or using newer syntax
git restore path/to/file.php
```

### 🌿 **Branching for Safe Development**

#### **Create Feature Branches**
```bash
# Create and switch to new branch
git checkout -b feature/payment-gateway-updates

# Or using newer syntax
git switch -c feature/payment-gateway-updates

# Make your changes, then commit
git add .
git commit -m "Add new payment gateway features"

# Switch back to main branch
git checkout master
# or
git switch master

# Merge feature branch
git merge feature/payment-gateway-updates

# Delete feature branch after merging
git branch -d feature/payment-gateway-updates
```

### 🔄 **Stashing Changes**
```bash
# Save current changes temporarily
git stash

# List all stashes
git stash list

# Apply last stash
git stash pop

# Apply specific stash
git stash apply stash@{0}

# Clear all stashes
git stash clear
```

### 📊 **Viewing Changes**
```bash
# See what changed in working directory
git diff

# See what changed in staged files
git diff --staged

# See changes between commits
git diff HEAD~1 HEAD

# See changes in specific file
git diff path/to/file.php
```

## 🛡️ **Safe Development Workflow**

### **Before Making Major Changes:**
1. **Create a backup branch:**
   ```bash
   git checkout -b backup-before-changes
   git checkout master
   ```

2. **Create a feature branch:**
   ```bash
   git checkout -b feature/new-functionality
   ```

3. **Make your changes and test**

4. **Commit frequently with descriptive messages:**
   ```bash
   git add .
   git commit -m "Add payment gateway configuration UI"
   ```

5. **Merge back when ready:**
   ```bash
   git checkout master
   git merge feature/new-functionality
   ```

### **Emergency Rollback Scenarios:**

#### **🚨 "I broke something and need to go back immediately"**
```bash
# Go back to last working commit
git reset --hard HEAD~1

# Or go back to specific working commit
git log --oneline
git reset --hard COMMIT_HASH
```

#### **🚨 "I want to undo changes but keep my work"**
```bash
# Undo commit but keep changes staged
git reset --soft HEAD~1

# Undo commit and unstage changes
git reset HEAD~1
```

#### **🚨 "I want to see what changed before deciding"**
```bash
# See what will be undone
git show HEAD

# See differences between commits
git diff HEAD~1 HEAD
```

## 📝 **Commit Message Best Practices**

### **Good Commit Messages:**
- `feat: Add Razorpay payment gateway integration`
- `fix: Resolve SMS configuration validation issue`
- `update: Improve payment gateway error handling`
- `refactor: Optimize database queries in order management`
- `docs: Add payment gateway setup instructions`

### **Commit Types:**
- `feat:` - New features
- `fix:` - Bug fixes
- `update:` - Updates to existing features
- `refactor:` - Code refactoring
- `docs:` - Documentation changes
- `style:` - Code style changes
- `test:` - Adding tests
- `chore:` - Maintenance tasks

## 🔧 **Useful Git Aliases**

Add these to your Git config for faster commands:
```bash
git config --global alias.st status
git config --global alias.co checkout
git config --global alias.br branch
git config --global alias.ci commit
git config --global alias.unstage 'reset HEAD --'
git config --global alias.last 'log -1 HEAD'
git config --global alias.visual '!gitk'
```

## 📚 **Common Scenarios**

### **Scenario 1: Testing New Payment Gateway**
```bash
# Create feature branch
git checkout -b test/new-payment-gateway

# Make changes and test
# ... make changes ...

# Commit progress
git add .
git commit -m "feat: Add initial Stripe integration"

# If it works, merge to master
git checkout master
git merge test/new-payment-gateway

# If it doesn't work, just delete the branch
git branch -D test/new-payment-gateway
```

### **Scenario 2: Emergency Fix**
```bash
# Create hotfix branch
git checkout -b hotfix/payment-bug

# Fix the issue
# ... make fixes ...

# Commit and merge quickly
git add .
git commit -m "fix: Resolve payment processing error"
git checkout master
git merge hotfix/payment-bug
git branch -d hotfix/payment-bug
```

### **Scenario 3: Experimental Features**
```bash
# Create experimental branch
git checkout -b experiment/ai-features

# Try new things without fear
# ... experiment ...

# If successful, merge
# If not successful, just delete branch
git checkout master
git branch -D experiment/ai-features
```

## 🎯 **Daily Git Workflow**

1. **Start of day:**
   ```bash
   git status
   git log --oneline -5
   ```

2. **Before making changes:**
   ```bash
   git checkout -b feature/todays-work
   ```

3. **During development:**
   ```bash
   # Commit frequently
   git add .
   git commit -m "Descriptive message"
   ```

4. **End of day:**
   ```bash
   git checkout master
   git merge feature/todays-work
   git branch -d feature/todays-work
   ```

## 🆘 **Emergency Commands**

### **"I want to start over completely"**
```bash
git reset --hard HEAD
git clean -fd
```

### **"I want to go back to yesterday's version"**
```bash
git log --since="yesterday" --oneline
git reset --hard COMMIT_HASH
```

### **"I want to see what I changed today"**
```bash
git log --since="today" --stat
```

Remember: **Git is your safety net!** Commit early, commit often, and use branches for experimentation. 🛡️
