# Irshad Autos POS - Hostinger Deployment Guide

## 🚀 Pre-Deployment (Local Preparation)

### 1. **Optimize Laravel for Production**
```bash
# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations and seeders
php artisan migrate --force
php artisan db:seed --force
```

### 2. **Create Database Dump**
```bash
# Export your local database
mysqldump -u [username] -p [database_name] > database_dump.sql
```

### 3. **Prepare Files for Upload**
- ✅ All caches are generated
- ✅ Database is ready
- ✅ Application is optimized

---

## 📤 Upload to Hostinger

### 1. **File Upload**
Upload these directories/files to your Hostinger hosting:
- `app/` (application code)
- `bootstrap/` (framework bootstrap)
- `config/` (configuration files)
- `database/` (migrations and seeders)
- `lang/` (language files)
- `public/` (web root - point your domain here)
- `resources/` (views, assets)
- `routes/` (route definitions)
- `storage/` (logs, cache, uploads)
- `vendor/` (composer dependencies)
- `artisan` (Laravel command line tool)
- `composer.json` and `composer.lock`

### 2. **Files to EXCLUDE from Upload**
- `.env` (create new one on server)
- `.git/` (version control)
- `node_modules/` (if exists)
- `storage/logs/*.log` (log files)
- `storage/framework/cache/*` (cache files)
- `storage/framework/sessions/*` (session files)
- `storage/framework/views/*` (compiled views)

---

## 🔧 Hostinger Server Setup

### 1. **Create .env File**
Create `.env` file on server with your Hostinger database credentials:
```env
APP_NAME="Irshad Autos"
APP_ENV=production
APP_KEY=[generate with: php artisan key:generate]
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=your_hostinger_db_name
DB_USERNAME=your_hostinger_db_user
DB_PASSWORD=your_hostinger_db_password

# Google Drive Backup (if using)
GOOGLE_CLIENT_ID=your_google_client_id
GOOGLE_CLIENT_SECRET=your_google_client_secret
GOOGLE_REDIRECT_URI=https://yourdomain.com/manage-backup/google/callback
```

### 2. **Set Permissions**
```bash
# Set proper permissions (if SSH access available)
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
chmod -R 755 public/
```

### 3. **Install Dependencies**
```bash
# Use composer.phar if composer not available
php composer.phar install --optimize-autoloader --no-dev
```

### 4. **Import Database**
- Go to Hostinger cPanel → phpMyAdmin
- Create new database
- Import the `database_dump.sql` file

### 5. **Generate Application Key**
```bash
# If you can run artisan commands
php artisan key:generate
```

---

## 🌐 Domain Configuration

### 1. **Point Domain to Public Folder**
- Set document root to: `/public_html/public/`
- Or create `.htaccess` in root to redirect to public/

### 2. **Create .htaccess in Root (if needed)**
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

## 🔍 Post-Deployment Checklist

### ✅ **Verify Installation**
1. **Website loads** without errors
2. **Login page** appears correctly
3. **Database connection** works
4. **File uploads** work (check storage permissions)
5. **Backup system** functions (if using Google Drive)

### ✅ **Security Checks**
1. **APP_DEBUG=false** in production
2. **Proper file permissions** set
3. **HTTPS** enabled (recommended)
4. **Strong passwords** for database and admin

### ✅ **Performance Optimization**
1. **Caches are working** (config, route, view)
2. **Database indexes** are optimized
3. **Images and assets** are compressed

---

## 🚨 Troubleshooting

### **Common Issues:**

1. **500 Error**
   - Check file permissions
   - Verify .env file exists
   - Check storage/logs/laravel.log

2. **Database Connection Error**
   - Verify database credentials in .env
   - Check if database exists in phpMyAdmin

3. **File Upload Issues**
   - Set proper permissions on storage/ directory
   - Check upload_max_filesize in PHP settings

4. **Composer Issues**
   - Use `composer.phar` instead of `composer`
   - Download composer.phar from getcomposer.org

---

## 📞 Support
If you encounter issues:
1. Check Hostinger error logs
2. Check Laravel logs: `storage/logs/laravel.log`
3. Verify all files uploaded correctly
4. Ensure database import was successful

**Good luck with your deployment! 🎉** 