# DEPLOY-CPANEL — Runbook Deploy Laravel Berdampingan WordPress (Toggle 1 Domain)

> Panduan langkah-per-langkah men-deploy aplikasi **Techno (Laravel 11 + Vue 3)** ke cPanel `techno-triireka.co.id` yang **sudah berisi WordPress**, dengan mekanisme **toggle**: hanya satu app aktif di domain utama pada satu waktu, app yang lain disimpan utuh dan bisa diaktifkan lagi kapan saja lewat rename folder.
>
> Anchor terkait: [ASSET-MANAGER.md](ASSET-MANAGER.md).

---

## 0. Ringkasan & Prinsip

- **Domain:** `techno-triireka.co.id` — Document Root **TERKUNCI** ke `/home/techno/public_html` (tidak bisa diubah via UI cPanel).
- **Toggle = rename folder.** Folder yang bernama `public_html` itulah yang dilayani. Ganti app = ganti folder mana yang bernama `public_html`.
- **Tanpa Terminal/SSH.** Semua dilakukan lewat GUI cPanel: File Manager, phpMyAdmin, MySQL Databases, MultiPHP Manager. `composer` dan `npm run build` dijalankan **di lokal**, hasilnya diupload.
- **Tanpa symlink.** Asset dilayani langsung dari `public_html/storage` (Apache serve folder fisik), diatur lewat 1 baris config + 1 variabel `.env`.
- **Nondestruktif & reversible.** WordPress tidak dihapus, hanya "diparkir" (folder di-rename). Rollback = rename balik.

**Layout server final:**

```
/home/techno/
├── laravel_app/        # Laravel TANPA folder public (app, bootstrap, config, database,
│                       #   resources, routes, storage, vendor, .env, artisan, composer.json)
│                       #   >>> PATH STABIL, tidak pernah di-rename <<<
├── wp_app/             # Bundel WordPress (isi public_html yang sekarang)
├── laravel_public/     # Isi folder public/ Laravel (index.php dipatch, build/, favicon, dst)
└── public_html/        # Folder yang SEDANG AKTIF (hasil rename dari wp_app / laravel_public)
```

Saat **WordPress aktif**: `public_html` = bekas `wp_app`, dan `laravel_public` standby.
Saat **Laravel aktif**: `public_html` = bekas `laravel_public`, dan `wp_app` standby.
`laravel_app/` selalu ada di tempat, apa pun yang aktif.

---

## 1. Fakta Server (hasil pengecekan)

| Hal | Status |
|---|---|
| Home directory | `/home/techno` |
| Document Root domain utama | `/home/techno/public_html` (terkunci, read-only) |
| WordPress sekarang | Ditaruh **langsung** di `public_html` (loose), banyak file backup manual `z-*` |
| Terminal (shell di browser) | **Tidak ada** |
| SSH Access | Ada (butuh key + client luar — tidak dipakai di runbook ini) |
| phpMyAdmin | **Ada** (Databases) |
| MySQL Databases | **Ada** |
| MultiPHP Manager | **Ada** (untuk set PHP 8.2) |
| Cron Jobs | Ada (cadangan, tidak dipakai jika pakai cara no-symlink) |
| Subdomain | Kuota 12, tidak dipakai (keputusan: toggle 1 domain) |
| Folder `wordpress-bac...` di home | Ada — kemungkinan backup WP lama, **jangan diutak-atik** |

---

## 2. Persiapan di LOKAL (bikin bundel)

Semua langkah bagian ini dikerjakan di mesin lokal, hasilnya diupload nanti.

### 2.1 Code change (1 baris) — serve asset tanpa symlink

Edit `config/filesystems.php`, disk `public`, ganti `root` jadi env-driven:

```php
'public' => [
    'driver' => 'local',
    'root' => env('PUBLIC_DISK_ROOT', storage_path('app/public')),
    'url' => env('APP_URL').'/storage',
    'visibility' => 'public',
    'throw' => false,
],
```

> Aman & backward-compatible: tanpa `PUBLIC_DISK_ROOT`, perilaku lokal tetap sama (default `storage/app/public`). Di server nanti diarahkan ke `public_html/storage`.

### 2.2 Build dependency & frontend

```bash
composer install --no-dev --optimize-autoloader
npm ci
npm run build          # menghasilkan public/build
```

### 2.3 Siapkan `.env` produksi

Buat file `.env.production` (nanti diupload sebagai `.env` di `laravel_app`):

```dotenv
APP_NAME=Techno
APP_ENV=production
APP_KEY=            # isi dari langkah 2.4
APP_DEBUG=false
APP_URL=https://techno-triireka.co.id

# Serve asset langsung dari web root (tanpa symlink)
PUBLIC_DISK_ROOT=/home/techno/public_html/storage

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=techno_xxxx      # isi setelah buat DB (langkah 4)
DB_USERNAME=techno_xxxx
DB_PASSWORD=

# Driver berbasis file/sync → tidak butuh tabel sessions/cache/jobs
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_STORE=file
QUEUE_CONNECTION=sync
FILESYSTEM_DISK=local

# JWT (tymon/jwt-auth) — WAJIB, isi dari langkah 2.4
JWT_SECRET=
```

### 2.4 Generate APP_KEY & JWT_SECRET (di lokal)

```bash
php artisan key:generate --show     # salin hasilnya ke APP_KEY di .env.production
php artisan jwt:secret --show       # salin hasilnya ke JWT_SECRET (atau cek .env lokal)
```

> Kalau `--show` tidak tersedia, jalankan tanpa `--show` di project lokal lalu salin nilai `APP_KEY` / `JWT_SECRET` dari `.env` lokal.

### 2.5 `index.php` produksi (sudah disiapkan)

File siap pakai ada di repo: **[deploy/index.php](../deploy/index.php)** — sudah menunjuk ke `laravel_app` dan rename-safe. `public/index.php` bawaan **tidak diubah** (tetap untuk lokal).

Saat menyusun bundel public (2.6), **ganti** `index.php` di dalamnya dengan isi `deploy/index.php`.

> `__DIR__` index.php = folder aktif (`public_html`) atau standby (`laravel_public`) — dua-duanya sibling langsung `laravel_app` di bawah `/home/techno`, jadi `/../laravel_app` selalu benar apa pun nama foldernya. Rename-safe.

### 2.6 Susun 2 bundel ZIP

**Bundel A — `laravel_app.zip`** (semua KECUALI folder `public`):
- Sertakan: `app/`, `bootstrap/`, `config/`, `database/`, `resources/`, `routes/`, `storage/`, `vendor/`, `artisan`, `composer.json`, `composer.lock`, dan `.env.production` (rename jadi `.env` di dalam zip atau saat upload).
- Pastikan struktur `storage/` ada: `storage/framework/{cache,sessions,views}`, `storage/logs`, `storage/app/public`, `storage/app/private` (folder boleh kosong + `.gitkeep`).
- **Jangan** sertakan isi log/sessions lokal (kosongkan).

**Bundel B — `laravel_public.zip`** (isi folder `public/`):
- Sertakan semua isi `public/`: `.htaccess`, `build/`, `favicon.ico`, `robots.txt`, dll.
- **Ganti `index.php`** dengan isi `deploy/index.php` (lihat 2.5).
- **Jangan** sertakan `public/storage` (symlink lokal) — tidak dipakai.

**Bundel C — `upload.zip`** (asset asli):
- Isi `storage/app/public/upload` (hasil migrasi asset manager: ± 1025 file / 112 folder).
- Ini akan diletakkan di `public_html/storage/upload` di server.

---

## 3. BACKUP DULU (WAJIB, sebelum menyentuh server)

1. **Backup file WordPress:** File Manager → pilih `public_html` → **Compress** → `.zip` → **Download** ke lokal. (Atau cPanel *Backup Wizard* → Full Backup.)
2. **Backup DB WordPress:** buka `public_html/wp-config.php`, catat `DB_NAME`. phpMyAdmin → pilih DB itu → **Export** → simpan `.sql` ke lokal.
3. Simpan dua backup ini offline. **Jangan hapus file `z-*` lama & folder `wordpress-bac...` sampai Laravel terbukti aman di produksi.**

> Selama proses, jika ragu, berhenti dan cek backup dulu.

---

## 4. Database Laravel di Server

1. cPanel → **MySQL Databases**:
   - *Create New Database* → misal `techno_app` (nama final jadi `techno_techno_app` atau sesuai prefix akun; catat nama persisnya).
   - *Add New User* → misal `techno_app` + password kuat.
   - *Add User To Database* → pilih user + DB → **All Privileges**.
2. Export DB Laravel **di lokal**: `mysqldump --no-create-db --default-character-set=utf8mb4 <db_lokal> > techno.sql` (atau via phpMyAdmin lokal, *Export*).
   - Data sudah termasuk hasil seeder (folders 111 / files 1025 / series 643 / dst).
3. cPanel → **phpMyAdmin** → pilih DB server yang barusan dibuat → **Import** → upload `techno.sql`.
   - Kalau file besar/timeout: kompres jadi `.sql.gz` sebelum import, atau pecah.
4. Update `.env` (nanti di server) `DB_DATABASE` / `DB_USERNAME` / `DB_PASSWORD` sesuai yang dibuat di langkah 1.

---

## 5. Upload & Extract di Server

Lewat File Manager (`/home/techno`, di LUAR `public_html`):

1. Buat folder `laravel_app` → masuk → **Upload** `laravel_app.zip` → **Extract** → hapus zip.
   - Pastikan `.env` ada di `laravel_app/.env` (isi/lengkapi `DB_*` dari langkah 4).
2. Buat folder `laravel_public` → **Upload** `laravel_public.zip` → **Extract** → hapus zip.
3. Set permission tulis (File Manager → *Change Permissions*, atau recursive):
   - `laravel_app/storage` → **775** (recursive)
   - `laravel_app/bootstrap/cache` → **775** (recursive)
4. Siapkan folder asset di web root **(dilakukan setelah Laravel aktif — lihat 6)**, atau sementara taruh isi `upload.zip` di `laravel_public/storage/upload` supaya ikut ter-rename jadi `public_html/storage/upload` saat aktivasi. (Rekomendasi: taruh di `laravel_public/storage/upload` sekarang, jadi begitu di-rename langsung nyambung dengan `PUBLIC_DISK_ROOT`.)
   - Buat `laravel_public/storage/` → Upload `upload.zip` → Extract → hasil: `laravel_public/storage/upload/files/...`

---

## 6. Set PHP 8.2 & Aktivasi Laravel (Toggle Pertama)

### 6.1 PHP 8.2
cPanel → **MultiPHP Manager** → pilih domain `techno-triireka.co.id` → set **PHP 8.2** → Apply.

### 6.2 Aktivasi (rename — URUT, WAJIB parkir dulu baru promote)

Di File Manager `/home/techno`:

1. Rename `public_html` → `wp_app`   *(WordPress diparkir; situs down beberapa detik — ini normal)*
2. Rename `laravel_public` → `public_html`   *(Laravel live)*

> **Aturan mutlak:** parkir folder aktif DULU (langkah 1), baru promote standby (langkah 2). Kalau dibalik → error "name already exists" karena `public_html` masih ada.

Setelah ini, `public_html/storage/upload/...` sudah berisi asset (dari langkah 5.4), dan `.env` `PUBLIC_DISK_ROOT=/home/techno/public_html/storage` cocok. Tidak perlu `storage:link`.

---

## 7. Verifikasi

- Buka `https://techno-triireka.co.id` → landing Techno tampil, gambar/PDF ter-load.
- Cek Network beberapa asset → URL `https://techno-triireka.co.id/storage/upload/files/...` → **200 OK**.
- Buka halaman admin → login (JWT) → form entity → preview image dari DB.
- Cek katalog publik (vendor/series) → gambar + tombol PDF jalan.
- Kalau ada error 500: sementara set `APP_DEBUG=true` di `.env`, cek `laravel_app/storage/logs/laravel.log`, perbaiki, lalu **kembalikan `APP_DEBUG=false`**.

---

## 8. SOP Toggle (Operasi Rutin Bolak-Balik)

Semua lewat File Manager, `/home/techno`. **Selalu parkir yang aktif dulu, baru promote standby.**

**Aktifkan Laravel (dari kondisi WP aktif):**
1. Rename `public_html` → `wp_app`
2. Rename `laravel_public` → `public_html`
3. (Jika WP butuh versi PHP beda) MultiPHP Manager → set **PHP 8.2**

**Aktifkan WordPress (dari kondisi Laravel aktif):**
1. Rename `public_html` → `laravel_public`
2. Rename `wp_app` → `public_html`
3. (Jika perlu) MultiPHP Manager → set versi PHP WordPress

> Downtime hanya beberapa detik di antara 2 rename. Aman untuk switch yang disengaja.

**Catatan PHP:** WP & Laravel berbagi versi PHP domain. Idealnya set 8.2 dan pastikan WordPress masih jalan di 8.2 (WP modern umumnya oke). Kalau WP rewel di 8.2, jadikan "ganti versi PHP" bagian dari langkah toggle di atas.

---

## 9. Rollback

- **Saat deploy awal gagal:** rename `public_html` → `laravel_public`, lalu `wp_app` → `public_html`. WordPress kembali live seperti semula. Tidak ada data yang hilang.
- **Restore total WP (skenario terburuk):** extract backup dari Bagian 3 kembali ke `public_html`, import balik DB WP via phpMyAdmin.

---

## 10. Known Issues / Catatan

- ~~**`AuthController@register` RUSAK**~~ → **SUDAH DIPERBAIKI** di branch `deploy-cpanel` (spread `...$user` + `Auth::attempt` guard web salah → diganti `JWTAuth::fromUser`; ada `tests/Feature/AuthRegisterTest.php`).
- **PDF picker admin** (form series/product, `file_id`) belum ada — data PDF sudah ter-wire, publik cukup baca `series.file`. Nice-to-have.
- **Jangan hapus backup apa pun** (file `z-*` WP, `wordpress-bac...`, serta backup Laravel: tabel `mt_images_storage`, kolom `source_ref`, `public/images`, `public/pdf`) sampai produksi terbukti 100% aman. Lihat [ASSET-MANAGER.md](ASSET-MANAGER.md) Larangan.
- **Cadangan (jika no-symlink bermasalah):** kalau karena suatu hal asset tidak ter-serve dari `public_html/storage`, alternatif idiomatik = symlink lewat **Cron Jobs** one-shot: `ln -sfn /home/techno/laravel_app/storage/app/public /home/techno/public_html/storage` (jalankan sekali saat Laravel aktif, lalu hapus cron). Butuh dukungan symlink host.

---

## 11. Checklist Ringkas

**Lokal:**
- [ ] Edit `config/filesystems.php` (PUBLIC_DISK_ROOT)
- [ ] `composer install --no-dev -o` + `npm run build`
- [ ] `.env.production` lengkap (APP_KEY, JWT_SECRET, DB, PUBLIC_DISK_ROOT, driver file)
- [ ] Pakai `deploy/index.php` sebagai `index.php` di bundel public
- [ ] Bundel `laravel_app.zip`, `laravel_public.zip`, `upload.zip`

**Server:**
- [ ] Backup penuh WP (file + DB)
- [ ] Buat DB + user, import `techno.sql` via phpMyAdmin
- [ ] Upload/extract `laravel_app` + `laravel_public` + `upload` (ke `laravel_public/storage/upload`)
- [ ] Lengkapi `laravel_app/.env` (DB_*), set perm `storage` & `bootstrap/cache` 775
- [ ] MultiPHP → PHP 8.2
- [ ] Toggle: rename `public_html`→`wp_app`, `laravel_public`→`public_html`
- [ ] Verifikasi landing + asset 200 + admin login + katalog
