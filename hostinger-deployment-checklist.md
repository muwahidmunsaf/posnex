# 🚀 Irshad Autos POS - Hostinger Deployment Checklist

## ✅ **LOCAL PREPARATION (COMPLETED)**

### **Optimization Commands (Already Run)**
- ✅ `php artisan config:cache`
- ✅ `php artisan route:cache` 
- ✅ `php artisan view:cache`
- ✅ `php artisan migrate --force`
- ✅ `php artisan db:seed --force`

### **Database Export**
Since the script failed, use **phpMyAdmin**:
1. Open phpMyAdmin locally
2. Select database `posnex`
3. Click **Export** → **Go**
4. Save as `database_dump.sql`

---

## 📤 **FILES TO UPLOAD TO HOSTINGER**

### **Core Application Files:**
```
✅ app/
✅ bootstrap/
✅ config/
✅ database/
✅ lang/
✅ public/          ← Point domain here
✅ resources/
✅ routes/
✅ storage/
✅ vendor/
✅ artisan
✅ composer.json
✅ composer.lock
```

### **Files to EXCLUDE:**
```
❌ .env              ← Create new on server
❌ .git/
❌ node_modules/
❌ storage/logs/*.log
❌ storage/framework/cache/*
❌ storage/framework/sessions/*
❌ storage/framework/views/*
❌ export-database.php
❌ deploy-to-hostinger.md
```

---

## 🔧 **HOSTINGER SERVER SETUP**

### **1. Create .env File**
```env
APP_NAME="Irshad Autos"
APP_ENV=production
APP_KEY=base64:YOUR_GENERATED_KEY_HERE
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_hostinger_db_name
DB_USERNAME=your_hostinger_db_user
DB_PASSWORD=your_hostinger_db_password

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

# Google Drive Backup (if using)
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=https://yourdomain.com/manage-backup/google/callback
```

### **2. Generate APP_KEY**
If you can run commands on Hostinger:
```bash
php artisan key:generate
```
If not, generate locally and copy the key.

### **3. Install Dependencies**
```bash
# Download composer.phar first
wget https://getcomposer.org/composer.phar

# Install dependencies
php composer.phar install --optimize-autoloader --no-dev
```

### **4. Set Permissions**
```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 755 public/
```

### **5. Import Database**
1. Go to Hostinger cPanel → **phpMyAdmin**
2. Create new database
3. Import `database_dump.sql`

---

## 🌐 **DOMAIN CONFIGURATION**

### **Option 1: Point to Public Folder**
- Set document root to: `/public_html/public/`

### **Option 2: Use .htaccess Redirect**
Create `.htaccess` in root:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

## 🔍 **POST-DEPLOYMENT VERIFICATION**

### **✅ Test These Features:**
1. **Website loads** without errors
2. **Login page** appears correctly
3. **User registration** works
4. **Dashboard** loads properly
5. **File uploads** work (check storage permissions)
6. **Backup system** functions (if using Google Drive)
7. **All modules** (Sales, Inventory, etc.) work

### **✅ Security Checklist:**
- [ ] APP_DEBUG=false
- [ ] Strong database passwords
- [ ] HTTPS enabled
- [ ] Proper file permissions
- [ ] Admin account secured

---

## 🚨 **TROUBLESHOOTING**

### **500 Error:**
- Check `storage/logs/laravel.log`
- Verify `.env` file exists
- Check file permissions

### **Database Error:**
- Verify database credentials
- Check if database exists
- Ensure tables are imported

### **File Upload Issues:**
- Set permissions: `chmod -R 755 storage/`
- Check PHP upload limits

### **Composer Issues:**
- Use `composer.phar` instead of `composer`
- Download from: https://getcomposer.org/composer.phar

---

## 📞 **SUPPORT**

### **If Issues Persist:**
1. Check Hostinger error logs
2. Check Laravel logs: `storage/logs/laravel.log`
3. Verify all files uploaded correctly
4. Ensure database import was successful

### **Contact:**
- Hostinger Support for hosting issues
- Check Laravel documentation for framework issues

---

## 🎉 **SUCCESS INDICATORS**

Your deployment is successful when:
- ✅ Website loads without errors
- ✅ Login/registration works
- ✅ All modules function properly
- ✅ File uploads work
- ✅ Backup system works (if configured)

**Good luck with your deployment! 🚀** 