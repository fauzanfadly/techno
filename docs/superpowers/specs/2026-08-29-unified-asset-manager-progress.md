# Unified Asset Manager — Progress Tracker

- **Spec:** [2026-08-29-unified-asset-manager-design.md](2026-08-29-unified-asset-manager-design.md)
- **Mulai:** 2026-08-29
- **Update terakhir:** 2026-08-30
- **Resume:** anchor = `docs/ASSET-MANAGER.md`. Katakan "baca `docs/ASSET-MANAGER.md`" → dari situ baca spec (Bagian 0 = resume, Bagian 6 = peta kode, Bagian 7 = Fase 2), tracker ini, dan memory `asset-manager-migration.md`.

## Status Fase

| Fase | Deskripsi | Status |
|---|---|---|
| 1 | Kunci data model (desain + migration) | 🟢 Selesai — migrate sukses, di-commit `4428d3f` |
| 2 | Backend CRUD unified + folder | 🟢 Selesai — kode + FolderService test PASS, di-commit `7cbafa6` |
| 3 | Frontend asset manager berfolder | 🟢 Selesai — kode + build + UI live test PASS, di-commit `25d2438` |
| 4 | Migrasi data (680 file + mt_images_storage) | 🟡 Kode command + test PASS; user BELUM jalanin `migrate` + `assets:migrate-legacy` |
| 5 | Switch publik + buang sistem lama | 🟡 Di branch `feature/asset-manager-phase-5`. Backend flip (schema+wiring+repoint relasi) SELESAI+test. Frontend (5b/5c) + cleanup (5d) belum |
| 6 | Deploy prep + regen seeder | ⚪ Belum |

Legenda: ⚪ Belum · 🟡 Berjalan · 🟢 Selesai

## Fase 1 — Task Detail

Keputusan terkunci:
- [x] Model folder → tabel `mt_folders` terpisah + `folder_id`
- [x] Link entity → pertahankan `image_id`+`file_id`, repoint relasi (nanti Fase 5)
- [x] Layout disk → mirror pohon folder di disk

Deliverable:
- [x] Migration `2026_08_29_000001_create_mt_folders_table.php` (id, name, parent_id, path, timestamps, unique(parent_id,name))
- [x] Migration `2026_08_29_000002_add_folder_id_to_mt_files_storage_table.php` (folder_id nullable, after id)
- [x] Model `app/Models/MtFolder.php` (parent/children/files)
- [x] Update `app/Models/MtFilesStorage.php` — relasi `folder()` belongsTo
- [x] Spec ditulis (file design)
- [x] Lint `php -l` clean semua file
- [x] **`php artisan migrate` dijalankan user — sukses, schema terverifikasi via DESCRIBE**
- [x] Di-commit `7cbafa6`
- [x] **Verifikasi HTTP tambahan (via UI Playwright, 2026-08-30):** `FilesStorageController@update` lolos live — rename (name only), move file A→B (relokasi fisik + `file_path`/`folder_id` update), replace/ganti file (hapus fisik lama + simpan baru + ekstensi berubah). Verified DB & disk.
- [ ] Sisa belum dites (risiko rendah, boleh skip): `FilesStorageController@remove` (detach entity — belum ada konsumen sampai Fase 5), validasi whitelist tipe + cap 10MB gambar.

Catatan unique(parent_id,name): MySQL anggap NULL distinct, jadi folder root (parent_id NULL) dengan nama sama TIDAK tercegah di level DB — perlu cek app-level saat CRUD folder root (Fase 2).

## Fase 2 — Task Detail

Keputusan terkunci (detail di spec Bagian 7):
- [x] Tipe file → whitelist (image/dokumen/teks, tolak executable)
- [x] Max size → image 10MB / dokumen 50MB (split; PDF terbesar existing 43.59MB)
- [x] Hapus folder → cascade + auto-detach FK, transaksional
- [x] Transisi: auto-detach Fase 2 HANYA `mt_product.file_id` (image_id ditunda Fase 5, hindari overlap id-space)

Deliverable:
- [x] `app/Services/FolderService.php` (baru) — create/update(rename+move)/delete/detach, mirror fisik
- [x] `app/Services/UploadFileServices.php` (edit) — `saveUploadFile($file, $folderPath)`
- [x] `app/Http/Controllers/FoldersController.php` (baru)
- [x] `app/Http/Controllers/FilesStorageController.php` (rombak total)
- [x] `routes/api.php` (edit) — grup `assets-manager/folder/*` + `file/*`; `image/*` dibiarkan
- [x] Lint `php -l` clean + `route:list` keregister + app boot bersih
- [x] **Fix keamanan `phpunit.xml`** — aktifin `DB_CONNECTION=sqlite` / `:memory:` (sebelumnya di-comment → `php artisan test` bakal hantam mysql `techno` asli via RefreshDatabase). Sekarang test terisolasi.
- [x] `tests/Feature/FolderServiceTest.php` — 5 test PASS: create/rename/move/reject-descendant/delete-cascade. Termasuk assert transition-safety `image_id` tak tersentuh.
- [ ] **Test HTTP controller + auth:api** (upload multipart, validasi, remove) — belum (butuh token; logika inti sudah tercover service test)
- [ ] Commit (butuh izin user)

Saran smoke test (via API client, header Authorization Bearer token):
1. `POST assets-manager/folder/create` (root, lalu nested pakai parent_id) → cek `path` benar + dir fisik `storage/app/public/upload/files/...` kebuat
2. `POST assets-manager/file/create` (multipart: name, folder_id, file) → cek row + file fisik di path mirror
3. `POST assets-manager/file/update/{id}` kirim `folder_id` beda → cek file fisik pindah
4. `POST assets-manager/folder/update/{id}` rename/move → cek `path` turunan + `file_path` file turunan ke-rewrite + dir fisik pindah
5. `DELETE assets-manager/folder/delete/{id}` folder berisi → cek cascade (row+fisik hilang) + `mt_product.file_id` yang nunjuk jadi null

Catatan edge (untuk diperhatikan saat test):
- Validasi tipe file pakai **ekstensi** (bukan mime-guess) — hindari false-reject csv/svg, tapi lebih lemah dari cek mime. Cukup untuk admin di balik auth.
- File servable butuh `php artisan storage:link` (symlink `public/storage`). Tidak wajib untuk test API, wajib untuk render.

## Fase 3 — Task Detail

Keputusan terkunci (detail di spec Bagian 8):
- [x] Layout → two-pane (pohon folder + grid file)
- [x] Scope diperkecil: Fase 3 HANYA manager mandiri; picker + 5 form entity + PDF picker product → digeser Fase 5 (transition-safety)

Deliverable:
- [x] `resources/js/pages/admin/assets-file-manager/Index.vue` (rebuild total → two-pane)
- [x] `resources/js/components/asset-manager/FolderTree.vue` (rekursif)
- [x] `NamePromptDialog.vue` + `name_prompt_dialog.js`
- [x] `MoveDialog.vue` + `move_dialog.js`
- [x] `FileUploadDialog.vue` + `file_upload_dialog.js`
- [x] `npm run build` (vite) LOLOS
- [x] **Test UI live via Playwright MCP (2026-08-30) PASS:** login → render two-pane → create folder root (DB + dir fisik `upload/files/MyTorq`) → pilih folder (breadcrumb + tombol aksi) → upload gambar (DB row + file fisik mirror + thumbnail ter-serve via `storage:link`) → `files_count` update → hapus folder (dialog konfirmasi cascade → row + file fisik hilang). Semua verified di DB & disk.
- [ ] Commit (butuh izin user)

Catatan test: butuh viewport lebar (≥md) supaya nav drawer permanent (kalau sempit, scrim drawer nutupin klik). Register endpoint `AuthController@register` RUSAK (`...$user` spread model, line 43) — di luar scope, tapi nyata. Pakai user test via tinker buat login (sudah dihapus lagi).

Utang teknis (cleanup Fase 5): `assets-file-manager/Form.vue` + route create/detail jadi tak terpakai; MoveDialog belum grey-out keturunan (backend yang cegah).

## Fase 4 — Task Detail

Keputusan terkunci (detail di spec Bagian 9): struktur mirror hierarki (series flat di category), populate-only additive + `source_ref`, `mt_images_storage` → folder "Assets Lama", skip aset landing.

Deliverable:
- [x] Migration `2026_08_30_000001_add_source_ref_to_mt_files_storage_table.php`
- [x] Command `app/Console/Commands/MigrateLegacyAssets.php` (`--dry-run`, `--images-path`, `--pdf-path`; idempotent, non-destruktif)
- [x] `tests/Feature/MigrateLegacyAssetsTest.php` — 6 test PASS (full suite 13 pass)
- [ ] **User jalankan:** `php artisan migrate` → `php artisan assets:migrate-legacy --dry-run` → `php artisan assets:migrate-legacy`
- [ ] Verifikasi hasil di DB + `storage/app/public/upload/files` (`public/images` harus tetap utuh)
- [ ] Commit (butuh izin user)

## Fase 5 — Progress (branch `feature/asset-manager-phase-5`)

Keputusan wiring (data-grounded): manufacture → `mt_images_storage` (`images:1/2/3`, lebih lengkap + tampil di landing); vendor + series → structured (`vendor:V:img`, `series:S:img/pdf`). Atomic flip (nggak bisa dipecah tanpa broken window) → dikerjakan di branch, test, commit sekali.

**5a Backend flip — SELESAI + test (16 pass, 62 assert):**
- [x] Migration `2026_08_30_000002_add_file_id_to_mt_product_series_table` (FK pdf series)
- [x] Repoint relasi `image()` 5 model → `MtFilesStorage`; tambah `file()` di `MtProductSeries`
- [x] Command `app/Console/Commands/WireEntitiesToFiles.php` (`assets:wire-entities --dry-run`)
- [x] `tests/Feature/WireEntitiesToFilesTest.php` (3 test)

**5b Picker + form entity admin — SELESAI (image), build lolos:**
- [x] `resources/js/utils/file_picker_dialog.js` + `components/dialogs/FilePickerDialog.vue` (picker berfolder: FolderTree + grid, filter image/pdf, emit pick)
- [x] 5 form entity: image-picker ke-swap `SelectFileImageDialog` → `FilePickerDialog`, `openSelectImageDialog` → `openFilePicker({filter:'image'})`, `value.image_path` → `value.file_path`
- [ ] (Ditunda) PDF picker admin di form series/product (`file_id`) — data pdf sudah ke-wire via `series:S:pdf`; publik cukup baca `series.file`. Nice-to-have.

**5c Switch frontend publik — SELESAI (build lolos):**
- [x] Backend eager-load: `ManufactureTypeController` +`mt_vendor.image`; `VendorController` +`mt_product_category.mt_product_series.file` (pdf). Validasi `image_id` `mt_images_storage`→`mt_files_storage` di 5 controller.
- [x] `Vendor.vue`: `rawStorage.vendorImg` → `getStorageFile(vendor.image.file_path)`
- [x] `catalog/Index.vue`: vendorImg→`vendor.image`, seriesImg→`series.image`, seriesPdf→`series.file` (semua `getStorageFile(...file_path)`)
- [x] `LandingPage/Products.vue`: `type.image?.image_path` → `file_path`

**Belum:**
- [ ] 5d: buang `mt_images_storage`+`ImagesStorageController`+`assets-image-manager`+`rawStorage` helper+ImagePicker/SelectFileImageDialog lama+Form.vue nganggur+route `image/*`
- [ ] Test full (Playwright end-to-end setelah flip live)
- [ ] **Eksekusi flip live** (URUT, di akhir): `php artisan migrate` (file_id) → `php artisan assets:wire-entities`. CATATAN: DB shared — begitu di-wire, main lama rusak sampai branch merge.
- [ ] Merge branch + commit

⚠️ DB tidak ikut branch. Jangan jalankan `assets:wire-entities` di live sampai frontend siap.

## Commit History

- Fase 1 → `4428d3f`
- Fase 2 → `7cbafa6`
- Fase 3 → `25d2438`

(Update dokumentasi/doc setelah commit terakhir mungkin belum di-commit — commit terpisah jika perlu.)

## Catatan Antar-Sesi

- Web publik SEKARANG baca gambar dari `public/images/...` (structured-path via `rawStorage.*`), BUKAN dari `mt_images_storage`. Jangan hapus `public/images` sebelum Fase 5 selesai.
- Selama transisi, `mt_images_storage` + `mt_files_storage` hidup bersama. Jangan repoint relasi `image()` sebelum data pindah (Fase 4 → Fase 5).
- `FilesStorageController` existing rusak — akan dirombak di Fase 2, jangan dipakai apa adanya.
- Seeder digenerate ulang paling akhir (Fase 6), setelah semua data final.
- Larangan git: jangan commit/push tanpa izin eksplisit user.
