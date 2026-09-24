# 🛒 TokoKu: Studi Kasus Buku Ajar Laravel 12

**Pemrograman Website Berbasis Framework: Konsep, Implementasi, dan Deployment Menggunakan Laravel 12**
Ahmad Rois Syujak, M.Kom. — Program Studi Teknologi Informasi, Fakultas Sains dan Teknologi, UIN Salatiga (2026)

TokoKu adalah aplikasi toko online sederhana yang dibangun bertahap sepanjang buku, dari Bab 2 sampai Bab 11. Repositori ini adalah project Laravel 12 lengkap (tanpa folder `vendor` dan `node_modules`) supaya kamu bisa menjalankannya langsung dan membandingkannya dengan hasil latihanmu.

---

## 📋 Fitur

| Fitur | Bab |
|---|---|
| CRUD produk | 3–5 |
| Kategori (one to many) dan tag (many to many) | 5 |
| Layout, komponen, dan partial view Blade | 6 |
| Form, validasi, upload gambar, flash message | 7 |
| Login, register, logout (Laravel Breeze) | 8 |
| Otorisasi berbasis peran: admin, seller, customer (middleware, Gate/Policy) | 8 |
| Pencarian, filter kategori dan harga, pagination 12 produk per halaman | 9 |
| Email konfirmasi pesanan (Mailable) | 9 |
| Unit test dan feature test | 10 |

**Aturan akses produk**

| Aksi | Admin | Seller | Customer |
|---|---|---|---|
| Lihat daftar dan detail produk | ✅ | ✅ | ✅ |
| Tambah produk | ✅ | ✅ | ❌ |
| Ubah produk | ✅ semua | ✅ hanya miliknya | ❌ |
| Hapus produk | ✅ | ❌ | ❌ |
| Admin dashboard | ✅ | ❌ | ❌ |

---

## ⚙️ Persyaratan Sistem

| Software | Versi Minimum | Cek |
|---|---|---|
| PHP | 8.2 | `php -v` |
| Composer | 2.x | `composer --version` |
| Node.js | 18 | `node -v` |
| NPM | 9 | `npm -v` |
| MySQL / MariaDB | 8.0 / 10.3 | `mysql --version` |
| Git | versi berapa pun | `git --version` |

---

## 🚀 Instalasi

```bash
git clone https://github.com/roissyujak/tokoku-laravel12.git
cd tokoku-laravel12

composer install
npm install && npm run build

cp .env.example .env
php artisan key:generate
```

Buat database `tokoku` di MySQL/MariaDB, lalu atur `.env`:

```env
APP_NAME=TokoKu
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tokoku
DB_USERNAME=root
DB_PASSWORD=
```

> Laravel 12 memakai SQLite secara default. Pastikan `DB_CONNECTION=mysql` dan baris `DB_*` **tidak** diawali tanda `#`.

```bash
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Buka <http://localhost:8000>.

## 👤 Akun Uji (khusus development)

| Role | Email | Password |
|---|---|---|
| Admin | admin@tokoku.com | password |
| Seller | seller@tokoku.com | password |
| Customer | customer@tokoku.com | password |

Jangan pernah memakai akun ini di server production.

## 🧪 Menjalankan Test

```bash
php artisan test
```

## 📁 Peta Bab dan File Utama

| Bab | Topik | File utama |
|---|---|---|
| 3 | Routing dan Controller | `routes/web.php`, `ProductController.php` |
| 4 | Model dan ORM | `Product.php`, `Category.php`, migration |
| 5 | Relasi dan CRUD | relasi model, seeder, factory |
| 6 | Blade | `layouts/main.blade.php`, `components/` |
| 7 | Form dan validasi | `_form.blade.php`, `Requests/` |
| 8 | Autentikasi dan otorisasi | Breeze, `RoleMiddleware`, `ProductPolicy` |
| 9 | Fitur tambahan | pagination, pencarian, filter, Mailable |
| 10 | Testing | `tests/Unit/`, `tests/Feature/` |
| 11 | Deployment | lihat Bab 11 di buku |

## 📝 Catatan

1. Jangan commit file `.env`.
2. Folder `vendor/` dan `node_modules/` tidak disertakan; jalankan `composer install` dan `npm install` bila perlu.
3. Jalankan `php artisan storage:link` agar gambar produk tampil.
4. Untuk production: `APP_DEBUG=false` dan `APP_ENV=production`.

## 🔄 Riwayat Versi

**v1.2**
- Layout TokoKu diganti nama menjadi `layouts/main.blade.php` agar tidak tertimpa Laravel Breeze; `layouts/app.blade.php` kembali menjadi layout asli Breeze (dipakai halaman profil).
- README: URL `git clone` dan konfigurasi `.env` (`DB_CONNECTION=mysql`) diperbaiki.

**v1.1**
- Tambah kolom `products.user_id` (migration `..._000005`) agar `ProductPolicy` bekerja: seller hanya boleh mengubah produk miliknya.
- Route produk dilindungi `role:admin,seller` dan controller memakai `Gate::authorize` (sebelumnya semua user login bisa menambah dan menghapus produk).
- Seeder user memakai `forceCreate` (sebelumnya role admin dan seller tidak tersimpan).
- Pengurutan produk dibatasi whitelist kolom.
- Form produk kini menampilkan pilihan tag; `sync` tag juga menghapus tag yang tidak dicentang.
- Test diperbarui: perbaikan test yang kadang gagal (produk acak tidak aktif) dan penambahan test otorisasi.

**v1.0** rilis awal.

## 📄 Lisensi

MIT (lihat berkas `LICENSE`).
