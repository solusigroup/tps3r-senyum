# TPS3R Senyum - Aplikasi Pengelolaan Sampah

Aplikasi pengelolaan TPS3R (Tempat Pengolahan Sampah Reduce, Reuse, Recycle) Senyum Desa Kedungmaling, Kecamatan Sooko, Mojokerto.

## Fitur Utama

- **Dashboard** - Ringkasan statistik dan aktivitas terkini
- **Pengangkutan** - Catat pengangkutan sampah harian
- **Pemilahan** - Catat hasil pemilahan (Organik/Anorganik/Residu)
- **Penjualan** - Catat penjualan hasil pilah ke pengepul
- **Iuran Warga** - Kelola pembayaran iuran pelanggan
- **Pelanggan** - Data warga pelanggan TPS3R
- **Karyawan** - Data karyawan/petugas
- **Absensi** - Catat kehadiran harian
- **Jadwal** - Kelola jadwal pengambilan mingguan

## Instalasi

### 1. Prasyarat
- PHP >= 8.2
- MySQL >= 5.7 / MariaDB >= 10.3
- Composer

### 2. Setup Database

**Buat database MySQL:**
```bash
mysql -u root -p
```

Kemudian jalankan:
```sql
CREATE DATABASE tps3r_senyum CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

Atau jalankan script:
```bash
mysql -u root -p < database/create_database.sql
```

### 3. Konfigurasi Environment

Salin file `.env.example` ke `.env`:
```bash
cp .env.example .env
```

Edit `.env` dan sesuaikan kredensial database:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tps3r_senyum
DB_USERNAME=root
DB_PASSWORD=your_password
```

### 4. Install Dependencies & Migrate

```bash
composer install
php artisan key:generate
php artisan migrate
```

### 5. Jalankan Aplikasi

```bash
php artisan serve
```

Akses aplikasi di: http://localhost:8000

## Struktur Database

| Tabel | Deskripsi |
|-------|-----------|
| `users` | Admin/pengguna sistem |
| `karyawan` | Data karyawan TPS3R |
| `pelanggan` | Data warga pelanggan |
| `pengangkutan` | Catatan pengangkutan sampah |
| `pemilahan` | Hasil pemilahan sampah |
| `penjualan` | Transaksi penjualan hasil pilah |
| `iuran` | Catatan pembayaran iuran warga |
| `absensi` | Kehadiran karyawan |
| `jadwal` | Jadwal pengambilan sampah |

## Screenshot

Aplikasi menggunakan design modern dengan sidebar navigasi dan tema hijau emerald yang sesuai dengan identitas TPS3R.

## Lisensi

MIT License
