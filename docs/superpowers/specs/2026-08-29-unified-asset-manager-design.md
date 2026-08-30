# Unified Asset Manager — Design Spec

- **Tanggal:** 2026-08-29 (update 2026-08-30)
- **Status:** Fase 1 SELESAI & di-commit. Fase 2 (backend CRUD + folder) desain disetujui, implementasi berjalan. Fase 3–6 belum di-brainstorm detail.
- **Progress tracker:** [2026-08-29-unified-asset-manager-progress.md](2026-08-29-unified-asset-manager-progress.md)

## 0. Cara Melanjutkan di Sesi Baru

> **Anchor resume = `docs/ASSET-MANAGER.md`.** Di chat baru cukup katakan:
> **"baca `docs/ASSET-MANAGER.md`"**

Saat itu terjadi, lakukan urutan ini sebelum bertindak:

1. **Baca file ini penuh** — konteks, visi, roadmap, keputusan Fase 1.
2. **Baca progress tracker** ([progress.md](2026-08-29-unified-asset-manager-progress.md)) — status terkini tiap fase + task yang belum selesai. Ini sumber kebenaran "sampai mana".
3. **Baca memory** `asset-manager-migration.md` — ringkasan + larangan penting.
4. **Baca Bagian 6 (Peta Kode)** di file ini — semua lokasi `file:line` yang relevan. Pakai ini supaya TIDAK perlu explore codebase dari nol.
5. Lihat "Langkah Berikutnya" di bawah, konfirmasi ke user, baru kerja.

**Langkah berikutnya saat ini (2026-08-30):** Fase 1 selesai & di-commit (`4428d3f`). Fase 2 desain disetujui (lihat Bagian 7), implementasi backend berjalan. Setelah kode Fase 2 jadi: user jalankan test manual endpoint, lalu lanjut Fase 3 (frontend). Jangan commit/push tanpa izin.

## 1. Latar Belakang & Masalah

Project Techno (Laravel 11 + Vue 3) saat ini punya sistem gambar/file yang berantakan karena dulu dikejar cepat. Ada **3 konvensi upload** hidup bersamaan dan **2 tabel** aset yang tumpang tindih:

1. **`public/images/manufacture_type_X/vendor_Y/category_Z/...`** — ~680 file, plus `public/pdf/...`. Ini sumber kebenaran yang dibaca web publik sekarang (via helper `rawStorage.*` di `resources/js/utils/storage.js`). Struktur folder fisik mengikuti hierarki entity.
2. **`storage/app/public/upload/images`** (flat) — sistem tabel `mt_images_storage` + kolom `image_id`. Hanya 4 file yang benar-benar terpakai (id 1,2,3 di `mt_manufacture_type`, id 5 di `mt_vendor`).
3. **Target upload controller tidak konsisten:** `ImagesStorageController`/`ProductController` menulis ke `images/mt_product`, `UploadFileServices` ke `upload/images`, `FilesStorageController` ke `upload/files`.

Selain itu:
- `FilesStorageController` setengah jadi dan rusak (method `update` mereferensi kolom `image_path`/`pdf_file_path` yang tidak ada di tabel; `store` hanya menerima PDF).
- Semua FK aset di-comment (tidak ada constraint DB).
- Folder `storage/app/public/upload` masih ter-gitignore, padahal rencana deploy butuh file-nya ikut.

## 2. Visi Target

Satu **asset manager terpadu dengan foldering**, di halaman admin `assets-file-manager`, dibacking tabel `mt_files_storage`. Menyimpan semua tipe (image, dokumen, PDF, file lain). User bisa organisir file ke dalam folder seperti file manager biasa.

Konsekuensinya:
- `assets-image-manager` + tabel `mt_images_storage` **dihapus total**, dilebur ke `assets-file-manager` + `mt_files_storage`.
- Semua entity (product/vendor/manufacture/category/series) menyambung ke `mt_files_storage`.
- Web publik berhenti membaca structured-path `public/images/...`, ganti membaca dari `mt_files_storage` (via DB).
- `storage/app/public/upload` dilepas dari gitignore untuk deploy ke cPanel via file manager.
- Semua seeder digenerate ulang dari DB final (langkah terakhir).

## 3. Roadmap (6 Fase)

Dependency hampir linear.

| Fase | Isi | Status |
|---|---|---|
| **1. Kunci data model** | Desain + migration schema baru. Belum sentuh data. | **Disetujui** |
| **2. Backend CRUD unified + folder** | Rombak `FilesStorageController` (terima semua tipe, folder CRUD, list per folder). Generalisasi `UploadFileServices`. Route API. | Belum |
| **3. Frontend asset manager berfolder** | Bangun ulang `assets-file-manager` (UI folder). Update `ImagePicker`/`SelectFileImage`. Update 5 form entity untuk pick dari `mt_files_storage`. | Belum |
| **4. Migrasi data** | `mt_images_storage` → `mt_files_storage`. 680 file `public/images`+pdf → storage + register + tata folder + rewire FK entity. Script. | Belum |
| **5. Switch publik + buang sistem lama** | Web publik baca dari `mt_files_storage`. Hapus `assets-image-manager`, `mt_images_storage`, `ImagesStorageController`, helper `rawStorage`. Repoint relasi `image()` 5 entity. | Belum |
| **6. Deploy prep + seeder** | `.gitignore` lepas `storage/app/public/upload`. Catatan `storage:link` cPanel. Regen semua seeder dari DB final. | Belum |

## 4. Fase 1 — Data Model (Disetujui)

### 4.1 Keputusan Terkunci

| # | Keputusan | Pilihan | Alasan |
|---|---|---|---|
| 1 | Model folder | Tabel `mt_folders` terpisah + `folder_id` di `mt_files_storage` | Tabel file tetap murni; folder nested via `parent_id`; pola media-library standar. |
| 2 | Link entity ke aset | Pertahankan nama kolom `image_id` + `file_id`, hanya repoint relasi ke `MtFilesStorage` | Churn minimal — tidak rename kolom di 5 tabel/model/form/frontend. Product tetap 2 kolom (`image_id`=gambar, `file_id`=pdf). Cukup untuk kebutuhan 1 gambar/entity. Bisa di-upgrade ke pivot jika nanti butuh galeri. |
| 3 | Layout fisik disk | **Mirror** pohon folder di disk (path fisik nested) | Deploy via cPanel file manager manual → disk yang human-browsable cocok dengan cara deploy. |

Asumsi: **1 gambar per entity** (+1 PDF khusus product). Bukan galeri multi-gambar. Jika nanti butuh galeri, naik ke pivot polymorphic.

### 4.2 Perubahan Schema (additive — tidak menghapus apa pun)

**Migration 1 — buat `mt_folders`:**

| Kolom | Tipe | Keterangan |
|---|---|---|
| `id` | bigint PK | |
| `name` | string | nama folder |
| `parent_id` | bigint nullable FK→`mt_folders` | null = root |
| `path` | string nullable | prefix path fisik denormalized, mis. `MyTorq/Assembling` |
| `timestamps` | | |

Constraint: unique `(parent_id, name)` — cegah folder kembar di induk yang sama.

**Migration 2 — `mt_files_storage` tambah kolom:**
- `folder_id` bigint nullable FK→`mt_folders` (null = file di root).
- Kolom lain tetap: `name, description, file_path, file_name, file_extension, file_size, file_mime_type`.
- `file_path` = path fisik nested, mengikuti `folder.path`.

**Model baru `MtFolder`:** relasi `parent()`/`children()` self-reference + `files()` hasMany ke `MtFilesStorage`.

**Kenapa `path` didenormalisasi di folder:** agar `file_path = folder.path + '/' + file_name` mudah dihitung, dan saat rename/move folder cukup recompute `path` folder + `file_path` semua file turunan.

### 4.3 Konsekuensi Layout Mirror (Keputusan #3)

Karena disk mirror pohon folder, operasi folder harus menyentuh disk:
- **Rename/move folder** = pindah file fisik + rewrite `file_path` semua turunan (folder & file). Harus transaksional (Fase 2).
- **Delete folder** = hapus file fisik turunan + row DB.
- **Move file antar folder** = pindah file fisik + update `file_path` + `folder_id`.

Ini trade-off yang diterima sadar demi kecocokan dengan deploy cPanel manual.

### 4.4 Yang TIDAK Disentuh di Fase 1 (ditunda, biar additive & aman)

- Repoint relasi `image()` pada 5 entity model → **Fase 5** (sekarang masih baca `mt_images_storage`; kalau direpoint sebelum data pindah, admin existing rusak).
- Drop tabel `mt_images_storage` + `assets-image-manager` + `ImagesStorageController` → **Fase 5**.
- FK constraint aktif/tidak → ikut gaya existing (di-comment/nullable), tidak menambah constraint keras di Fase 1.

### 4.5 Deliverable Fase 1

1. `database/migrations/xxxx_create_mt_folders_table.php`
2. `database/migrations/xxxx_add_folder_id_to_mt_files_storage_table.php`
3. `app/Models/MtFolder.php`
4. Update `app/Models/MtFilesStorage.php` — tambah relasi `folder()` belongsTo.
5. Spec ini + progress tracker.

## 5. Risiko & Catatan

- **Layout mirror bikin folder-ops mahal** — mitigasi: bungkus rename/move/delete dalam DB transaction + rollback file jika gagal (Fase 2).
- **680 file harus dipetakan ke entity** saat migrasi (Fase 4) — perlu strategi mapping dari struktur `manufacture_type_X/vendor_Y/...` ke `folder_id` + FK entity. Belum didesain, masuk brainstorm Fase 4.
- **Transisi dua tabel** — selama Fase 1–4, `mt_images_storage` dan `mt_files_storage` hidup bersama; jangan repoint relasi sebelum data pindah.
- **Deploy cPanel** — perlu `php artisan storage:link` di server (atau symlink manual via file manager). Detail masuk Fase 6.

## 6. Peta Kode (Temuan Sesi 2026-08-29)

Semua lokasi penting yang sudah ditelusuri. Pakai ini agar sesi baru tidak explore ulang.

### 6.1 Dua Sistem Gambar (INTI kebingungan)

- **Sistem A — `mt_images_storage` (DB):** disajikan via `getStorageFile(path)` = `${origin}/storage/${path}` di `resources/js/utils/storage.js:3`. Hanya dipakai di 1 tempat publik: `resources/js/components/LandingPage/Products.vue:42` (`getStorageFile(type.image?.image_path)`, data dari `/api/manufacture-type`) + form admin.
- **Sistem B — structured-path `public/images/...`:** dibangun helper di `resources/js/utils/storage.js` — `manufactureImg` (baris 34), `vendorImg` (41), `categoryImg` (48), `seriesImg` (55), `productImg` (62), `seriesPdf` (69), `productPdf` (76). Menghasilkan URL `/images/manufacture_type_X/vendor_Y/category_Z/...` dan `/pdf/...`. **Ini yang dipakai halaman produk publik.**

### 6.2 Frontend — konsumen aset

| File:line | Pakai | Sistem |
|---|---|---|
| `resources/js/components/LandingPage/Products.vue:42` | `getStorageFile(type.image?.image_path)` | A (mt_images_storage) — manufacture types |
| `resources/js/pages/products/Vendor.vue:112` | `rawStorage.vendorImg(...)` | B (structured public) |
| `resources/js/pages/products/catalog/Index.vue:13` | `rawStorage.vendorImg(...)` + lainnya | B (structured public) |
| `resources/js/pages/admin/manufacture-type/Form.vue:37` | `getStorageFile(image.path)` | A — preview edit |
| `resources/js/pages/admin/vendor/Form.vue:52` | `getStorageFile(image.path)` | A — preview edit |
| `resources/js/pages/admin/product/Form.vue:87` | `getStorageFile(image.path)` | A |
| `resources/js/pages/admin/product-category/Form.vue:63` | `getStorageFile(image.path)` | A |
| `resources/js/pages/admin/product-series/Form.vue:75` | `getStorageFile(image.path)` | A |
| `resources/js/pages/admin/assets-image-manager/Form.vue:40` | `getStorageFile(image.path)` | A — manager (akan dihapus) |
| `resources/js/pages/admin/assets-file-manager/Form.vue:40` | `getStorageFile(image.path)` | target manager baru |
| `resources/js/components/ImagePicker.vue:31` | `getStorageFile(item.image_path)` | A — picker |
| `resources/js/utils/select_file_image_dialog.js` | dialog pilih file | A |
| `resources/js/utils/image_full_screen_dialog.js:14-15` | preview fullscreen | A |

Catatan: `MainFooter.vue`/`TopNavBar.vue` pakai `/images/logo/logo.png` (statik publik, TIDAK terkait sistem aset).

### 6.3 Backend — model & relasi

| Model | Relasi | Target |
|---|---|---|
| `app/Models/MtProduct.php:21` | `image()` | `MtImagesStorage` via `image_id` |
| `app/Models/MtProduct.php:26` | `file()` | `MtFilesStorage` via `file_id` (pdf) |
| `app/Models/MtVendor.php:26` | `image()` | `MtImagesStorage` via `image_id` |
| `app/Models/MtManufactureType.php:21` | `image()` | `MtImagesStorage` via `image_id` |
| `app/Models/MtProductCategory.php:26` | `image()` | `MtImagesStorage` via `image_id` |
| `app/Models/MtProductSeries.php:30` | `image()` | `MtImagesStorage` via `image_id` |
| `app/Models/MtFilesStorage.php` | `mt_product()` hasMany via `file_id`; `$guarded = []` | |

Kolom FK di migration: `mt_vendor:14` (image_id), `mt_product_category:14`, `mt_product_series:14`, `mt_product:14` (image_id) + `:15` (file_id), `mt_manufacture_type:16`. Semua `nullable`, FK di-comment.

### 6.4 Backend — target upload (TIDAK konsisten, harus disatukan Fase 2)

| File:line | Target path |
|---|---|
| `app/Http/Controllers/ImagesStorageController.php:133` | `images/mt_product` (image) |
| `app/Http/Controllers/ImagesStorageController.php:143` | `pdfs/mt_product` (pdf) |
| `app/Http/Controllers/ProductController.php:61,130` | `images/mt_product` |
| `app/Http/Controllers/ProductController.php:68,140` | `pdfs/mt_product` |
| `app/Http/Controllers/FilesStorageController.php:119,129` | `upload/files` |
| `app/Services/UploadFileServices.php:16-17,35,63` | `upload/images` + `upload/files` |

`FilesStorageController` RUSAK: `update()` mereferensi `$update->image_path`/`$update->pdf_file_path` (bukan kolom tabel); `store()` hanya `mimes:pdf`. Harus dirombak Fase 2.

Eager-load relasi image: `ManufactureTypeController:25`, `VendorController:23`, `ProductSeriesController:23`, `ProductCategoryController:23` pakai `with(['image'])`; `ProductController:25` pakai `with('mt_product_series.mt_product_category.mt_vendor.mt_manufacture_type')`.

### 6.5 Fakta data (dari seeder + verifikasi live DB)

- `mt_images_storage` 7 row (id 1–7). **Terpakai:** id 1,2,3 (mt_manufacture_type: Assembling/Painting/Wielding), id 5 (mt_vendor: MyTorq). **Orphan-di-DB:** id 4,6,7.
- **Orphan fisik (tak masuk DB):** `1734767528_d1-img1.jpg`, `1734768126_d1-img1.jpg`, `1734782677_d1-img5.jpg`, `manufacture_type_1/vendor_4/vendor_4_img.png`, `manufacture_type_1/vendor_2/category_4/series_3/series_3_img.jpg`.
- `public/images` = **680 file** (struktur `manufacture_type_X/vendor_Y/category_Z/...` + `logo/`, `client_logos/`, `authorized_distributor_logos/`). `public/pdf` struktur sama.
- Product/category/series semua `image_id => NULL` di seeder → belum ada gambar terpasang lewat sistem A.

### 6.6 gitignore (relevan Fase 6)

`.gitignore` sekarang meng-ignore: `/public/build`, `/public/hot`, `/public/storage` (symlink). TIDAK meng-ignore `/public/images` & `/public/pdf` (jadi 680 file ikut ke-track git). Fase 6: lepas `storage/app/public/upload` dari ignore untuk deploy cPanel.

## 7. Fase 2 — Desain (Disetujui 2026-08-30)

Backend asset manager berfolder. Backend-only; UI di Fase 3.

### 7.1 Keputusan Terkunci

| # | Keputusan | Pilihan |
|---|---|---|
| Tipe file | Whitelist | image: `jpg,jpeg,png,webp,gif,svg`; dokumen: `pdf,doc,docx,xls,xlsx,ppt,pptx`; teks: `txt,csv`. Tolak executable. |
| Max size | Split per tipe | image = **10MB** (10240 KB); dokumen/teks = **50MB** (51200 KB). Dipilih karena PDF terbesar existing = 43.59MB. |
| Hapus folder | Cascade + auto-detach | Hapus subfolder+file (DB+fisik) + set FK entity null, dalam 1 transaction. Frontend wajib konfirmasi. |
| Layout disk | Mirror | Base `upload/files`; `folder.path` = path relatif; file_path = `upload/files/<folder.path>/<file_name>`. |

### 7.2 Transisi Penting (hindari bug)

Di Fase 2–4, kolom `image_id` 5 entity MASIH menunjuk `mt_images_storage`, BUKAN `mt_files_storage`. Karena id-space kedua tabel overlap (sama-sama mulai 1), auto-detach TIDAK BOLEH menyentuh `image_id` berdasarkan id `mt_files_storage` — bisa salah null-kan entity. **Auto-detach di Fase 2 hanya untuk FK yang benar-benar menunjuk `mt_files_storage` = `mt_product.file_id`.** Detach `image_id` (5 entity) DITAMBAHKAN di Fase 5 setelah relasi di-repoint.

Implementasi: `FolderService` punya map `$fileReferences` = daftar `[Model, kolom]` yang menunjuk `mt_files_storage`. Fase 2 isinya `[[MtProduct, 'file_id']]`. Fase 5 tambah 5 entri `image_id`.

### 7.3 Komponen

1. **`app/Services/FolderService.php`** (baru) — otak folder:
   - `segment(name)` sanitasi (trim, buang `/ \`, spasi boleh).
   - `buildPath(parent, name)` → path relatif.
   - `create(parentId, name)` → bikin dir fisik + row.
   - `update(folder, name?, parentId?)` → rename &/atau move: `File::moveDirectory` fisik (subtree ikut) lalu rewrite `path` folder turunan + `file_path` file turunan dalam transaction; revert FS jika DB gagal. Tolak move ke diri/keturunan sendiri.
   - `delete(folder)` → kumpulkan self+turunan → transaction (detach `$fileReferences`, hapus file rows, hapus folder rows) → `File::deleteDirectory`.
   - `detach(fileIds)` → set FK null untuk tiap `[Model,kolom]` di `$fileReferences`.
2. **`app/Http/Controllers/FoldersController.php`** (baru) — `index(?parent_id)`, `store` (cek nama kembar app-level termasuk root NULL), `update`, `destroy`.
3. **`app/Http/Controllers/FilesStorageController.php`** (rombak total) — `index(?folder_id)`, `store` (upload+folder), `update` (rename/replace/move), `remove` (detach entity), `destroy` (detach + hapus fisik+row).
4. **`app/Services/UploadFileServices.php`** (edit) — `saveUploadFile($file, $folderPath = null)` simpan ke `upload/files/<folderPath>`. `saveUploadImage` lama dibiarkan sampai Fase 5.
5. **`routes/api.php`** (edit) — tambah grup `assets-manager/folder/*` dan `assets-manager/file/*`. Route `image/*` lama dibiarkan.

### 7.4 Endpoint (auth:api, prefix `assets-manager`)

```
folder:  GET /folder?parent_id= · POST /folder/create · POST /folder/update/{id} · DELETE /folder/delete/{id}
file:    GET /file?folder_id=   · POST /file/create   · POST /file/update/{id}   · DELETE /file/remove/{id} · DELETE /file/delete/{id}
```

### 7.5 Validasi

- **Folder store:** `name` required string; `parent_id` nullable exists `mt_folders`. Cek app-level nama kembar di parent sama (termasuk root `parent_id=NULL` yang tak dijaga unique DB).
- **File store:** `name` required; `description` nullable; `folder_id` nullable exists `mt_folders`; `file` required + `mimes:<whitelist>` + `max:51200`. Lalu cek manual: jika ekstensi image dan size > 10MB → error.

### 7.6 Penanganan Gagal FS+DB

- **Folder move/rename:** `File::moveDirectory` dulu → bulk-update DB dalam transaction → commit. FS gagal → throw sebelum DB. DB gagal setelah FS pindah → revert (`moveDirectory` balik).
- **Delete:** transaction (detach + hapus row) → commit → baru hapus fisik. Fisik gagal setelah commit = sisa file yatim (bukan referensi menggantung, aman).
- Pakai facade `Illuminate\Support\Facades\File` untuk operasi direktori (path absolut via `Storage::disk('public')->path()`), `Storage` untuk operasi file relatif.
