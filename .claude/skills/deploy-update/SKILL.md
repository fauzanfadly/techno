---
name: deploy-update
description: Bikin bundel update (zip) untuk server cPanel techno-triireka.co.id setelah ada perubahan kode. Gunakan setiap kali user bilang mau update, naikin, publish, atau deploy perubahan ke server, minta "bikin zip update", "build buat produksi", atau habis ubah Vue, Blade, controller, route, config, atau composer dan mau dipasang di produksi. Menjalankan npm run build, memilih bundel yang perlu (public, app, vendor), lalu menjelaskan langkah upload dan extract lewat File Manager cPanel.
---

# Deploy update Techno ke cPanel

Produksi berjalan di cPanel tanpa terminal, jadi update dilakukan dengan mengunggah bundel kecil lewat File Manager. Skill ini yang menyiapkan bundelnya. Runbook lengkap dan latar belakang layout server ada di `docs/DEPLOY-CPANEL.md`.

## Layout server (dari `/home/techno`)

- `laravel_app/` berisi Laravel tanpa `public` (app, config, routes, resources/views, vendor, storage, `.env`).
- `public_html/` adalah web root Laravel (`index.php`, `build/`, `images/`, `storage/upload/`). `index.php` di sini versi `deploy/index.php`, bukan `public/index.php`.
- `wp_app/` adalah WordPress yang diparkir. Jangan disentuh.

## Langkah

1. **Lihat perubahan.** Jalankan `git status --short` dan `git diff --stat HEAD`. Bundel dibuat dari working tree, jadi perubahan yang belum di-commit ikut masuk. Kalau ada perubahan yang jelas bukan untuk dipublish, tanya user dulu.

2. **Pilih target** dari file yang berubah:

   | Yang berubah | Target |
   |---|---|
   | `resources/js`, `resources/css`, `resources/scss`, file `.vue` | `public` |
   | `public/images` (gambar statis) | `public` dengan `-WithImages` |
   | `app/`, `routes/`, `config/`, `resources/views`, `bootstrap/app.php`, `bootstrap/providers.php` | `app` |
   | `composer.json` atau `composer.lock` | `vendor` (dan biasanya `app` juga) |
   | `database/migrations` | Tidak ada bundel. Lihat aturan migration di bawah. |
   | `.env` | Tidak ada bundel. Edit `laravel_app/.env` manual di server. |

   Kalau ragu, pakai `public,app`. Perubahan frontend yang memanggil endpoint atau field baru butuh keduanya.

3. **Jalankan script** dengan tool PowerShell dari root project:

   ```powershell
   powershell -NoProfile -ExecutionPolicy Bypass -File deploy\build-update.ps1 -Target public,app
   ```

   Opsi: `-Target public|app|vendor` (boleh beberapa, pisah koma), `-WithImages`, `-SkipBuild` (pakai `public/build` yang sudah ada). Build dan `vendor` bisa makan waktu satu sampai dua menit, jadi jalankan di background kalau timeout.

4. **Laporkan ke user**: path lengkap folder output (`..\techno-deploy-zips\update-<stamp>\`), tiap file dengan ukurannya, dan langkah upload di bawah. Selalu tulis path lengkap, bukan path relatif.

5. **Setelah user upload**, minta hard refresh (Ctrl+Shift+R) lalu cek halaman yang terkait perubahan. Tidak perlu clear cache karena `config:cache` dan `view:cache` tidak dipakai.

## Upload dan extract di File Manager

| File | Upload ke | Cara |
|---|---|---|
| `update_public.zip` | `/home/techno/public_html` | Extract di situ. Menimpa `build/` (file hash lama boleh menumpuk, aman). |
| `update_app.zip` | `/home/techno/laravel_app` | Extract di situ, timpa file lama. |
| `vendor.zip` | `/home/techno/laravel_app` | **Hapus folder `vendor` lama dulu**, lalu Extract. Ikut membawa `bootstrap/cache/packages.php` yang baru. |

Hapus file zip di server setelah extract selesai. Semua bundel berformat `.zip` (permintaan user). Jangan ganti ke `.tar.gz` kecuali user minta.

## Aturan keras

- Jangan compress folder project secara manual dan jangan jalankan `composer install --no-dev` di repo. Script sudah membuat salinan sementara dan tidak mengubah `vendor/` lokal.
- Jangan pernah memasukkan `.env`, `storage/`, `public/index.php`, atau `public/.htaccess` ke bundel. Server punya versinya sendiri, dan menimpa `index.php` dengan versi lokal langsung menghasilkan 500.
- Migration baru tidak bisa dijalankan di server (tidak ada terminal). Tulis SQL-nya, kasih ke user untuk dijalankan sendiri di phpMyAdmin pada DB produksi. Jangan mengeksekusi apa pun ke DB produksi.
- File yang dihapus di repo tidak ikut terhapus di server. Sebutkan file mana yang perlu dihapus manual kalau ada.
- Jangan commit atau push tanpa izin eksplisit user.
- Jangan hapus backup di server (`wp_app`, `laravel_public_old`, `wordpress-backups`, file `z-*`) sebelum user bilang produksi aman.

## Kalau ada masalah setelah extract

- **500 dan log `Permission denied`**: permission hasil extract salah. Zip buatan Windows tidak membawa permission Unix, dan pada deploy pertama ini pernah membuat sebagian file `vendor` tidak terbaca. Di File Manager pakai Change Permissions: folder 755, file 644. Checkbox "Recurse" di server ini tidak muncul, jadi untuk `vendor` yang besar cara praktisnya minta gua membuatkan `vendor.tar.gz` manual pakai `tar` dari Git (`C:\Program Files\Git\usr\bin\tar.exe --force-local`, dengan `C:\Program Files\Git\usr\bin` di PATH supaya `gzip` ketemu). Script tidak membuat tar.gz secara otomatis.
- **`No such file or directory` atau `View [...] not found`**: extract cPanel kadang menjatuhkan file secara diam-diam. Cek filenya ada di File Manager, lalu ulangi extract.
- **500 tanpa error terlihat**: nyalakan `display_errors = On` sementara di MultiPHP INI Editor, lihat pesannya, lalu matikan lagi. Cek juga `laravel_app/storage/logs/laravel.log`.
- **Tampilan lama masih muncul**: hard refresh. Kalau CSS tidak termuat, cek Network tab dan pastikan `public_html/build/manifest.json` sudah yang terbaru.
- **Mau aman sebelum menimpa perubahan besar**: compress folder `laravel_app/app` lama di File Manager dulu sebagai cadangan.

## Catatan

- `APP_ENV` di server harus `production` (cabang production di `resources/views/app.blade.php` membaca `public/build/manifest.json`), dan `APP_DEBUG=false`.
- File `.env`, password DB, dan key produksi tidak disimpan di repo dan tidak boleh dicetak ke chat.
