# Panduan Deploy TPS3R Senyum ke Arenhost.id

**Domain:** `tps3rsenyum.simpleakunting.my.id`

---

## 1. Persiapan di cPanel Arenhost

### A. Setup Subdomain
1. Login ke cPanel Arenhost
2. Buka **Subdomains** atau **Addon Domains**
3. Buat subdomain: `tps3rsenyum.simpleakunting.my.id`
4. Document root: `/home/[username]/tps3rsenyum.simpleakunting.my.id`

### B. Buat Database MySQL
1. Buka **MySQL Databases**
2. Buat database baru: `tps3r_senyum`
3. Buat user baru dengan password kuat
4. Assign user ke database dengan **ALL PRIVILEGES**
5. Catat: `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`

---

## 2. Upload File Aplikasi

### Opsi A: Via Git (Jika SSH tersedia)
```bash
cd ~/tps3rsenyum.simpleakunting.my.id
git clone https://github.com/solusigroup/tps3r-senyum.git .
```

### Opsi B: Via File Manager/FTP
1. Download ZIP dari GitHub
2. Upload ke folder subdomain
3. Extract semua file

---

## 3. Konfigurasi Aplikasi

### A. Setup .env
```bash
cp .env.example .env
```

Edit `.env`:
```env
APP_NAME="TPS3R Senyum"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://tps3rsenyum.simpleakunting.my.id

DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nama_database_cpanel
DB_USERNAME=user_database_cpanel
DB_PASSWORD=password_database

SESSION_DRIVER=file
CACHE_DRIVER=file
```

### B. Install Dependencies (via SSH atau cPanel Terminal)
```bash
composer install --no-dev --optimize-autoloader
```

### C. Generate Key & Migrate
```bash
php artisan key:generate
php artisan migrate --force
php artisan db:seed
php artisan storage:link
```

---

## 4. Konfigurasi Document Root

Laravel memerlukan `public/` sebagai root. Ada 2 cara:

### Opsi A: Pindahkan public ke root (Recommended)
1. Pindahkan isi `public/` ke root subdomain
2. Edit `index.php`, ubah path:
```php
require __DIR__.'/../vendor/autoload.php';
// menjadi:
require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';
// menjadi:
$app = require_once __DIR__.'/bootstrap/app.php';
```

### Opsi B: Gunakan .htaccess redirect
Buat `.htaccess` di root subdomain:
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>
```

---

## 5. Set Permission
```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

---

## 6. Optimasi Production
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## 7. Setup SSL (HTTPS)
1. Di cPanel, buka **SSL/TLS** atau **Let's Encrypt**
2. Install SSL untuk subdomain
3. Force HTTPS di `.htaccess`

---

## 8. Test Aplikasi
1. Buka: https://tps3rsenyum.simpleakunting.my.id
2. Login: `admin@tps3r.id` / `admin123`

---

## Troubleshooting

| Masalah | Solusi |
|---------|--------|
| 500 Error | Cek `storage/logs/laravel.log` |
| Permission denied | `chmod -R 775 storage` |
| Class not found | `composer dump-autoload` |
| CSRF mismatch | Clear browser cache |
