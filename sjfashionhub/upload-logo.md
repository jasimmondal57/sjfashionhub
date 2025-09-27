# Logo Upload Instructions

## To upload your new SJ Fashion Hub logo:

### Method 1: Using SCP (Recommended)
```bash
# Save your logo image as 'sj-fashion-hub-logo.png' on your local machine
# Then upload it to the server:
scp -i ~/.ssh/id_ed25519_marketplace /path/to/your/sj-fashion-hub-logo.png root@72.60.102.152:/var/www/sjfashionhub.in/public/images/

# Make sure the file has proper permissions:
ssh -i ~/.ssh/id_ed25519_marketplace root@72.60.102.152 "chmod 644 /var/www/sjfashionhub.in/public/images/sj-fashion-hub-logo.png"
```

### Method 2: Using File Manager
1. Access your server's file manager
2. Navigate to `/var/www/sjfashionhub.in/public/images/`
3. Upload your logo file as `sj-fashion-hub-logo.png`
4. Set file permissions to 644

### Method 3: Using Admin Panel (Future Enhancement)
We can add a logo upload feature to the admin panel if needed.

## Logo Specifications:
- **File Name**: `sj-fashion-hub-logo.png`
- **Recommended Size**: 512x512 pixels (will be displayed at 128x128 on auth pages)
- **Format**: PNG with transparent background (recommended)
- **File Size**: Keep under 500KB for fast loading

## Current Implementation:
- Logo appears on login and register pages
- Size: 128x128 pixels (w-32 h-32)
- Centered above the form
- Includes brand name and tagline below logo
- Responsive design for mobile devices

## Testing:
After uploading, test the logo by visiting:
- https://sjfashionhub.in/login
- https://sjfashionhub.in/register

The logo should appear prominently at the top of both forms.
