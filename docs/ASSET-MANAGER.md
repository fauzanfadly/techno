# ASSET-MANAGER — Anchor Resume

> **File ini adalah pintu masuk (anchor) untuk melanjutkan pekerjaan "Unified Asset Manager".**
> Lokasi: `docs/ASSET-MANAGER.md`. Di chat baru, cukup katakan: **"baca `docs/ASSET-MANAGER.md`"**.

## Apa Ini

Migrasi besar sistem gambar/file project **Techno** (Laravel 11 + Vue 3) menjadi satu **asset manager terpadu dengan foldering** (`assets-file-manager` + tabel `mt_files_storage`), menghapus total `mt_images_storage` + `assets-image-manager`.

## Yang Harus Dibaca (urut)

1. **Spec penuh** — [superpowers/specs/2026-08-29-unified-asset-manager-design.md](superpowers/specs/2026-08-29-unified-asset-manager-design.md)
   - Bagian 0 = instruksi resume detail
   - Bagian 3 = roadmap 6 fase
   - Bagian 4 = keputusan Fase 1 (data model)
   - Bagian 6 = Peta Kode (semua lokasi `file:line`) → JANGAN explore codebase dari nol, pakai ini
   - Bagian 7 = keputusan & desain Fase 2 (backend CRUD + folder)
2. **Progress tracker** — [superpowers/specs/2026-08-29-unified-asset-manager-progress.md](superpowers/specs/2026-08-29-unified-asset-manager-progress.md) → status terkini tiap fase, sumber kebenaran "sampai mana"
3. **Memory** `asset-manager-migration.md` → ringkasan + larangan penting (auto-load tiap sesi)

## Status Sekarang (2026-08-30)

- **Fase 1 (data model): SELESAI & di-commit (`4428d3f`).** `mt_folders` + `folder_id` ada di DB.
- **Fase 2 (backend CRUD + folder): SELESAI & di-commit (`7cbafa6`).** FolderService lulus automated test.
  - Baru: `app/Services/FolderService.php`, `app/Http/Controllers/FoldersController.php`, `tests/Feature/FolderServiceTest.php`; rombak `app/Http/Controllers/FilesStorageController.php`; edit `app/Services/UploadFileServices.php` + `routes/api.php` + `phpunit.xml`.
  - Endpoint: `assets-manager/folder/*` + `assets-manager/file/*` (auth:api). `image/*` lama masih hidup sampai Fase 5.
  - Whitelist tipe file, max image 10MB / dok 50MB, hapus folder cascade+auto-detach (Fase 2 detach hanya `mt_product.file_id`).
  - Test: automated 5 pass (create/rename/move/reject-descendant/delete-cascade + assert `image_id` tak tersentuh). HTTP `file/update` (rename/move/replace) juga lolos live via UI Playwright. Sisa belum dites (risiko rendah): `remove`/detach + validasi tipe/size.
  - CATATAN: `phpunit.xml` sudah difix aktifin sqlite in-memory (sebelumnya test bakal hantam mysql asli).
- **Fase 3 (frontend two-pane manager): SELESAI & di-commit (`25d2438`).** Kode + build + TEST UI LIVE (Playwright) PASS.
  - Rebuild `pages/admin/assets-file-manager/Index.vue` jadi two-pane; baru: `components/asset-manager/FolderTree.vue`, dialog `NamePromptDialog`/`MoveDialog`/`FileUploadDialog` + util singleton-nya.
  - Scope diperkecil: picker berfolder + PDF picker product + 5 form entity DIGESER ke Fase 5 (transition-safety). Komponen lama dibiarkan. Utang cleanup Fase 5: `assets-file-manager/Form.vue` + route create/detail jadi nganggur.
- **Fase 4 (migrasi data): KODE + test PASS, user BELUM jalanin command, belum di-commit.**
  - Baru: migration `add_source_ref_to_mt_files_storage`, command `app/Console/Commands/MigrateLegacyAssets.php` (`assets:migrate-legacy`, `--dry-run`), `tests/Feature/MigrateLegacyAssetsTest.php` (6 pass).
  - Populate-only additive: mirror hierarki (Manufacture/Vendor/Category, series flat di category) + `mt_images_storage` → folder "Assets Lama" + `source_ref` per file. TIDAK sentuh FK/relasi/frontend/public/images. Skip aset landing.
  - **User jalankan:** `php artisan migrate` → `php artisan assets:migrate-legacy --dry-run` → `php artisan assets:migrate-legacy`.
- **Fase 4 (migrasi data): SUDAH DIJALANKAN user (2026-08-30).** Disk `storage/app/public/upload/files` terisi 1025 file + 112 folder (Assembling/Painting/Wielding/Assets Lama). `public/images` utuh (680). Command di-commit `6f8bd64`.
- **Fase 5 (flip): SEDANG BERJALAN di branch `feature/asset-manager-phase-5`.** Atomic flip. Wiring rule: manufacture→`mt_images_storage` (images:1/2/3), vendor+series→structured.
  - **5a backend SELESAI + test (16 pass):** migration `add_file_id_to_mt_product_series`, repoint relasi `image()` 5 model → `MtFilesStorage` + `file()` di series, command `assets:wire-entities`, `WireEntitiesToFilesTest`. Di-commit `d2ef97b`.
  - **5b picker + form entity admin SELESAI (build lolos):** `utils/file_picker_dialog.js` + `components/dialogs/FilePickerDialog.vue` (picker berfolder), 5 form image-picker → FilePickerDialog + `image_path`→`file_path`. (PDF picker admin ditunda.)
  - **5c frontend publik SELESAI (build lolos):** backend eager-load (`mt_vendor.image`, `series.file`) + validasi `image_id`→mt_files_storage; Vendor.vue/catalog/Products.vue `rawStorage.*` → `getStorageFile(entity.image/file.file_path)`.
  - **5d buang sistem lama SELESAI (build lolos, 16 test pass):** hapus ImagesStorageController, assets-image-manager, assets-file-manager/Form.vue, ImagePicker/SelectFileImageDialog+util, route image/*, nav "Images Manager", helper rawStorage. KEEP (drop Fase 6): mt_images_storage table+model, MigrateLegacyAssets command, kolom source_ref.
  - **Flip live DIJALANKAN user + Playwright PASS (2026-09-01):** `migrate` + `assets:wire-entities` (manuf 3/vendor 13/series img 643/pdf 361). Katalog publik + admin form render dari `/storage/upload/files` (DB); `anyOldRawStoragePath=false`. Entity live SEKARANG → mt_files_storage (main kode lama nampilin salah — harus merge branch).
  - Belum: commit 5d + docs (branch), merge branch → main.
- **Next step:** commit 5d + merge `feature/asset-manager-phase-5` → main (butuh izin user). Lalu Fase 6 (gitignore storage + regen seeder + drop mt_images_storage/source_ref).
- **Temuan sampingan (di luar scope):** `AuthController@register` RUSAK (`...$user` spread model Eloquent, `AuthController.php:43`) — register API error.

## Larangan / Hati-hati

- **Jangan commit/push tanpa izin eksplisit user.**
- Jangan repoint relasi `image()` 5 entity sebelum data pindah (Fase 4→5) — rusak admin.
- Jangan hapus `public/images` (680 file, dibaca web publik sekarang) sebelum Fase 5.
- `FilesStorageController` existing rusak — dirombak di Fase 2, jangan dipakai apa adanya.
