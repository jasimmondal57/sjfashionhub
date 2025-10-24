# 📊 Google Sheets Integration - Deployment Guide

This guide will help you set up the Google Apps Script to enable automatic data synchronization between SJ Fashion Hub and Google Sheets.

## 🚀 Quick Setup Overview

1. **Create Google Spreadsheet** → Set up your data sheets
2. **Deploy Google Apps Script** → Enable API communication
3. **Configure SJ Fashion Hub** → Connect to your sheets
4. **Test & Monitor** → Verify everything works

---

## 📋 Step 1: Create Google Spreadsheet

### 1.1 Create New Spreadsheet
1. Go to [Google Sheets](https://sheets.google.com)
2. Click **"+ Blank"** to create a new spreadsheet
3. Rename it to **"SJ Fashion Hub Data"** (or your preferred name)

### 1.2 Create Individual Sheets
Create separate sheets for each data type:

**Sheet 1: Orders**
- Right-click on "Sheet1" → Rename to **"Orders"**

**Sheet 2: Returns** 
- Click **"+"** at bottom → Name it **"Returns"**

**Sheet 3: Users**
- Click **"+"** at bottom → Name it **"Users"**

**Sheet 4: Newsletters**
- Click **"+"** at bottom → Name it **"Newsletters"**

### 1.3 Get Spreadsheet ID
1. Copy the **Spreadsheet ID** from the URL:
   ```
   https://docs.google.com/spreadsheets/d/[SPREADSHEET_ID]/edit
   ```
2. Save this ID - you'll need it later!

---

## ⚙️ Step 2: Deploy Google Apps Script

### 2.1 Create Apps Script Project
1. Go to [Google Apps Script](https://script.google.com)
2. Click **"+ New project"**
3. Rename the project to **"SJ Fashion Hub Integration"**

### 2.2 Add the Script Code
1. Delete the default `myFunction()` code
2. Copy the entire contents of `Code.gs` file (provided separately)
3. Paste it into the script editor
4. Click **"Save"** (Ctrl+S)

### 2.3 Deploy as Web App
1. Click **"Deploy"** → **"New deployment"**
2. Click the gear icon ⚙️ next to "Type"
3. Select **"Web app"**
4. Configure deployment settings:
   - **Description**: "SJ Fashion Hub Data Sync"
   - **Execute as**: "Me"
   - **Who has access**: "Anyone"
5. Click **"Deploy"**
6. **Copy the Web App URL** - you'll need this!

### 2.4 Authorize Permissions
1. Click **"Authorize access"**
2. Choose your Google account
3. Click **"Advanced"** → **"Go to SJ Fashion Hub Integration (unsafe)"**
4. Click **"Allow"**

---

## 🔧 Step 3: Configure SJ Fashion Hub

### 3.1 Access Google Sheets Settings
1. Login to your SJ Fashion Hub admin panel
2. Go to **"Google Sheets Integration"** in the sidebar
3. You'll see four cards: Orders, Returns, Users, Newsletters

### 3.2 Configure Orders Sheet
1. Click **"Setup Orders Sheet"** or **"Configure"**
2. Fill in the form:
   - **Sheet Name**: `Orders`
   - **Spreadsheet ID**: [Your copied ID from Step 1.3]
   - **Web App URL**: [Your copied URL from Step 2.3]
   - **Auto Sync**: ✅ Enabled
   - **Sync Frequency**: Hourly (recommended)
3. Click **"Save Configuration"**
4. Click **"Test"** to verify connection

### 3.3 Configure Returns Sheet
1. Click **"Setup Returns Sheet"** or **"Configure"**
2. Fill in the form:
   - **Sheet Name**: `Returns`
   - **Spreadsheet ID**: [Same as Orders]
   - **Web App URL**: [Same as Orders]
   - **Auto Sync**: ✅ Enabled
   - **Sync Frequency**: Hourly
3. Click **"Save Configuration"**
4. Click **"Test"** to verify connection

### 3.4 Configure Users Sheet
1. Click **"Setup Users Sheet"** or **"Configure"**
2. Fill in the form:
   - **Sheet Name**: `Users`
   - **Spreadsheet ID**: [Same as Orders]
   - **Web App URL**: [Same as Orders]
   - **Auto Sync**: ✅ Enabled
   - **Sync Frequency**: Daily (recommended for users)
3. Click **"Save Configuration"**
4. Click **"Test"** to verify connection

### 3.5 Configure Newsletters Sheet
1. Click **"Setup Newsletters Sheet"** or **"Configure"**
2. Fill in the form:
   - **Sheet Name**: `Newsletters`
   - **Spreadsheet ID**: [Same as Orders]
   - **Web App URL**: [Same as Orders]
   - **Auto Sync**: ✅ Enabled
   - **Sync Frequency**: Hourly (recommended)
3. Click **"Save Configuration"**
4. Click **"Test"** to verify connection

---

## 🧪 Step 4: Test & Monitor

### 4.1 Initial Data Sync
1. Go back to **"Google Sheets Integration"** dashboard
2. Click **"Sync Now"** for each sheet type
3. Check your Google Sheets - you should see:
   - Headers automatically added
   - Data populated from your database
   - Proper formatting applied

### 4.2 Monitor Sync Activity
1. Click **"View Sync Logs"** to see all sync activities
2. Check for any errors or failed syncs
3. Monitor success rates and performance

### 4.3 Verify Real-time Updates
1. Create a new order in your system
2. Check if it appears in the Google Sheet (may take a few minutes)
3. Update an order status and verify the change syncs

---

## 🔍 Troubleshooting

### Common Issues & Solutions

**❌ "Connection Failed" Error**
- Verify the Web App URL is correct
- Ensure the Apps Script is deployed as "Anyone" access
- Check if the Spreadsheet ID is accurate

**❌ "Sheet Not Found" Error**
- Verify sheet names match exactly (case-sensitive)
- Ensure sheets exist in the spreadsheet
- Check spelling of sheet names

**❌ "Permission Denied" Error**
- Re-deploy the Apps Script with "Anyone" access
- Clear browser cache and try again
- Verify Google account permissions

**❌ Data Not Syncing**
- Check sync logs for error messages
- Verify auto-sync is enabled
- Test manual sync first

### Getting Help
1. Check the **Sync Logs** for detailed error messages
2. Use the **Test Connection** feature to diagnose issues
3. Verify all URLs and IDs are correctly copied

---

## 📊 Data Structure

### Orders Sheet Columns
- Order ID, Customer Name, Customer Email, Customer Phone
- Total Amount, Status, Payment Status, Shipping Address
- Order Date, Last Updated, Items Count, Shipping Method
- Tracking Number, Notes

### Returns Sheet Columns  
- Return ID, Order ID, Customer Name, Customer Email
- Return Reason, Return Status, Refund Amount
- Return Date, Approved Date, Refund Date
- Quality Check, Admin Notes, Tracking Number

### Users Sheet Columns
- User ID, Name, Email, Phone, Role, Status
- Registration Date, Last Login, Total Orders, Total Spent
- Address, City, State, Country

### Newsletters Sheet Columns
- Subscriber ID, Email Address, Name, Status
- Subscribed Date, Unsubscribed Date, Source
- IP Address, User Agent, Preferences
- Created Date, Updated Date

---

## 🔄 Automatic Updates

Once configured, the system will automatically:

✅ **Sync new orders** when they're placed  
✅ **Update order statuses** when changed  
✅ **Add return requests** when submitted  
✅ **Update return statuses** through the workflow
✅ **Sync user registrations** and profile updates
✅ **Sync newsletter subscriptions** and unsubscriptions
✅ **Maintain data consistency** between systems

---

## 🛡️ Security Notes

- The Apps Script runs with your Google account permissions
- Data is transmitted securely via HTTPS
- No sensitive data like passwords are synced
- You can revoke access anytime from Google Apps Script

---

## 📞 Support

If you encounter any issues:
1. Check the troubleshooting section above
2. Review sync logs for specific error messages
3. Verify all configuration steps were followed correctly
4. Test with a simple manual sync first

The integration provides real-time visibility into your business data while maintaining security and reliability! 🚀
