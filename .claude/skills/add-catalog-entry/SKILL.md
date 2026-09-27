---
name: add-catalog-entry
description: Menambah data katalog Techno (manufacture type, vendor, product category, product series, product) beserta gambar dan PDF-nya lewat admin UI. Gunakan setiap kali user minta "tambah vendor", "bikin kategori/series/produk baru", "masukin produk beserta gambar dan PDF", "input katalog", "daftarin brand/vendor baru", atau mengunggah gambar/PDF katalog ke Files Manager — baik di lokal maupun produksi. Skill ini tahu urutan dependency antar entity, field tiap form, cara upload aset, dan cara memilih gambar/PDF lewat FilePickerDialog; bisa dipandu manual atau digerakkan langsung oleh Claude via Playwright.
---

# Tambah data katalog Techno lewat admin UI

Katalog Techno bertingkat: **Manufacture Type → Vendor → Product Category → Product Series → Product**. Tiap entity punya gambar (`image_id`), dan Series + Product juga punya PDF (`file_id`). Semua gambar/PDF menunjuk ke satu asset manager berfolder (`mt_files_storage`) dan dipilih lewat picker, bukan diupload langsung di form entity.

Cara paling aman menambah data adalah lewat admin UI-nya sendiri (aplikasi ini memang CMS-nya). Skill ini bisa dijalankan dua mode: **memandu user** klik per klik, atau **Claude menggerakkan browser** via Playwright. Pilih sesuai permintaan user.

## Sebelum mulai

1. **Tentukan target:**
   - Lokal: jalankan `php artisan serve` dulu → `http://127.0.0.1:8000`. Kalau butuh render aset, `php artisan storage:link` sekali.
   - Produksi: `https://techno-triireka.co.id`. **Ini data asli — konfirmasi ke user tiap kali menambah/mengubah di produksi**, dan jangan pernah menghapus data yang sudah ada.
2. **Login** di `/admin/login` (email + password → tombol Login → redirect `/admin/dashboard`). Minta kredensial ke user; jangan cetak password ke chat. Kalau perlu user test cepat di lokal, endpoint `/api/register` bisa bikin akun.
3. **Kalau via Playwright, pakai viewport lebar** (`browser_resize` ≥ 1280px). Di layar sempit nav drawer jadi overlay yang menutupi tombol dan bikin klik meleset.

## Urutan wajib (dependency)

Selalu buat parent lebih dulu — child butuh parent-nya sudah ada untuk dipilih di cascade:

```
Manufacture Type  →  Vendor  →  Product Category  →  Product Series  →  Product
```

Kalau user cuma minta salah satu (mis. "tambah produk"), cek dulu apakah parent-nya sudah ada. Kalau belum, buat parent-nya dulu atau tanya user mana yang mau dipakai.

## Langkah 0 — Siapkan aset (gambar / PDF)

Gambar/PDF harus sudah ada di asset manager sebelum bisa dipilih. Buka **Files Manager** (`/admin/assets-file-manager`, menu "Files Manager").

- **Kalau asetnya sudah ada** (katalog existing punya ratusan gambar + PDF hasil migrasi): lewati upload, langsung pilih di form nanti.
- **Kalau aset baru:** di panel folder, pilih/buat folder tujuan (tombol buat folder → dialog Name), lalu tombol Upload → pilih file. Setelah kelihatan di grid, aset siap dipilih.

Taruh aset di folder yang masuk akal (mirror hierarki katalog, mis. `Assembling/MyTorq/<Category>/`) supaya gampang dicari di picker. Nama file yang deskriptif membantu.

## Langkah per entity

Semua form berpola sama: isi Name → pilih parent (autocomplete cascade) → pilih Image (dan PDF untuk series/product) → Description opsional → Submit. Submit sukses → balik ke halaman list + snackbar. Field Name dan parent wajib; Image/PDF/Description opsional.

| Entity | URL create | Field wajib | Cascade | Aset |
|---|---|---|---|---|
| Manufacture Type | `/admin/manufacture-type/create` | Name | — | Image |
| Vendor | `/admin/vendor/create` | Name, Manufacture Type | manufacture | Image |
| Product Category | `/admin/product-category/create` | Name, Manufacture Type, Vendor | manufacture→vendor | Image |
| Product Series | `/admin/product-series/create` | Name, …, Category | manufacture→vendor→category | Image + **PDF** |
| Product | `/admin/product/create` | Name, …, Series | …→series | Image + **PDF** |

**Cascade:** memilih parent mengaktifkan dan mengisi dropdown child berikutnya. Isi dari atas ke bawah; child ter-disable sampai parent-nya dipilih.

## Cara pilih gambar / PDF (FilePickerDialog)

Klik (atau focus) field **"Image File"** atau **"PDF File"** → dialog picker terbuka:

- Judulnya "Pilih Gambar" untuk image, "Pilih Dokumen/PDF" untuk PDF. Filter otomatis: mode image cuma menampilkan gambar; mode PDF menampilkan file non-gambar (pdf/dokumen). Jadi folder yang isinya gambar akan tampak "kosong" saat memilih PDF — itu normal, cari folder yang memang berisi PDF.
- Panel kiri = pohon folder (Root + subfolder, tombol panah untuk expand). **Klik nama folder** untuk memuat isinya ke grid kanan.
- **Klik satu file** di grid → langsung terpilih, dialog tertutup, field terisi nama file, dan `image_id`/`file_id` ter-set. Untuk PDF ada tombol buka di tab baru.

## Menggerakkan via Playwright

Pola interaksi yang terbukti jalan (Vuetify):

1. **Login:** `browser_navigate` ke `/admin/login` → `browser_fill_form` email+password → klik "Login". Tunggu URL jadi `/admin/dashboard`.
2. **Autocomplete cascade:** klik combobox (mis. "Manufacture Type") → muncul `listbox` berisi `option` → klik option-nya. Ambil `ref` dari `browser_snapshot` tiap kali, karena ref berubah setelah re-render. Isi berurutan; snapshot ulang sebelum memilih child.
3. **Picker:** klik field "Image File"/"PDF File" → snapshot dialog → expand folder (klik tombol panah) → klik nama folder untuk load file → klik file target. Setelah dialog tutup, ref di form berubah — snapshot ulang sebelum aksi berikutnya.
4. **Submit:** klik "Submit". Sukses = pindah halaman (list) + snackbar. Verifikasi lewat `browser_network_requests` (`POST /api/.../create` → 200) atau cek `GET /api/<entity>` bahwa row baru ada dengan `image_id`/`file_id` terisi.

Kalau ada langkah yang gagal (klik meleset, dialog belum kebuka), snapshot ulang dan ulangi — jangan pakai ref lama.

## Verifikasi

- Buka halaman list entity terkait, pastikan data baru muncul.
- Kalau ada gambar/PDF: pastikan preview/tautan ke-load dari `/storage/upload/...` (bukan 404). Di produksi aset dilayani dari `public_html/storage/upload/...`.
- Buka form edit data yang baru dibuat → gambar + PDF harus ter-load balik (mengonfirmasi `image_id`/`file_id` tersimpan benar).

## Aturan keras

- **Produksi = data asli.** Konfirmasi sebelum menambah, dan jangan hapus/ubah entity lain. Kalau ragu, tanya user dulu.
- **Selalu parent dulu.** Membuat child sebelum parent ada = cascade kosong dan submit gagal validasi.
- **Aset dulu, baru pilih.** Gambar/PDF harus sudah ada di Files Manager sebelum muncul di picker.
- Jangan cetak password/kredensial ke chat.
- Kalau di lokal setelah menambah banyak untuk test, ingat membersihkan data test bila diminta (kasih query ke user untuk dijalankan, jangan eksekusi DELETE sendiri di DB yang dipakai app).

## Alternatif: lewat API (kalau user minta batch/otomasi)

Form-form di atas mem-POST ke endpoint `auth:api` yang sama; berguna kalau user minta input massal:

- `POST /api/login` → JWT token (header `Authorization: Bearer <token>` untuk sisanya).
- Upload aset: `POST /api/assets-manager/file/create` (multipart: `name`, `folder_id`, `file`) → dapat id file. Folder: `POST /api/assets-manager/folder/create`.
- `POST /api/manufacture-type/create` — `name`, `image_id`
- `POST /api/vendor/create` — `name`, `mt_manufacture_type_id`, `image_id`
- `POST /api/product/category/create` — `name`, `mt_vendor_id`, `image_id`
- `POST /api/product/series/create` — `name`, `description`, `mt_product_category_id`, `image_id`, `file_id`
- `POST /api/product/create` — `name`, `description`, `mt_product_series_id`, `image_id`, `file_id`

`image_id`/`file_id` menunjuk `mt_files_storage.id`. Mode ini bukan default (user memilih admin UI) — pakai hanya kalau user memang minta otomasi/batch.
