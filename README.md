# 📚 Sistem Perpustakaan — Laravel 9

Aplikasi manajemen perpustakaan berbasis **Laravel 9** dengan fitur login multi-role dan CRUD lengkap.

## Fitur

- **Multi-Role Login**: Admin, Petugas, dan Anggota
- **CRUD Buku** — tambah, edit, hapus, upload cover, pencarian & filter kategori
- **CRUD Kategori** — manajemen kategori buku
- **Peminjaman** — catat pinjam, pengembalian, denda otomatis Rp 1.000/hari
- **Manajemen Pengguna** — khusus Admin
- **Laporan** — statistik bulanan, buku populer, anggota aktif
- **Profil** — edit data diri & ganti password
- **Dashboard** berbeda per role
- Tampilan responsive Bootstrap 5

## Hak Akses

| Fitur              | Admin | Petugas | Anggota |
|--------------------|:-----:|:-------:|:-------:|
| Dashboard          | ✅    | ✅      | ✅      |
| Lihat Buku         | ✅    | ✅      | ✅      |
| CRUD Buku          | ✅    | ✅      | ❌      |
| CRUD Kategori      | ✅    | ✅      | ❌      |
| Catat Peminjaman   | ✅    | ✅      | ❌      |
| Lihat Peminjaman   | ✅    | ✅      | Milik sendiri |
| Kembalikan Buku    | ✅    | ✅      | ❌      |
| Manajemen User     | ✅    | ❌      | ❌      |
| Laporan            | ✅    | ✅      | ❌      |
| Edit Profil        | ✅    | ✅      | ✅      |

## Instalasi

### Prasyarat
- **PHP >= 8.0** (Laravel 9 membutuhkan minimal PHP 8.0)
- Composer
- MySQL / MariaDB

### Langkah Instalasi

```bash
# 1. Masuk ke folder project
cd C:\Users\aswan\Downloads\perpuss

# 2. Install dependencies
composer install

# 3. Generate app key
php artisan key:generate

# 4. Buat database MySQL
# Buka phpMyAdmin / MySQL CLI, jalankan:
# CREATE DATABASE perpustakaan;

# 5. Sesuaikan .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 6. Jalankan migrasi + seeder
php artisan migrate --seed

# 7. Buat symlink storage (untuk upload gambar)
php artisan storage:link

# 8. Jalankan server
php artisan serve
```

Buka browser: **http://localhost:8000**

---

## Akun Demo

| Role    | Email                    | Password |
|---------|--------------------------|----------|
| Admin   | admin@perpustakaan.com   | password |
| Petugas | petugas@perpustakaan.com | password |
| Anggota | budi@example.com         | password |
| Anggota | siti@example.com         | password |

---

## Versi

- **Laravel**: 9.x
- **PHP**: >= 8.0
- **Bootstrap**: 5.3

## Denda Keterlambatan

Denda dihitung otomatis: **Rp 1.000 per hari** setelah tanggal kembali yang direncanakan.
