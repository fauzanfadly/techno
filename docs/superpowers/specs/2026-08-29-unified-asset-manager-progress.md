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
| 3 | Frontend asset manager berfolder | 🟡 Kode + build vite + TEST UI LIVE (Playwright) PASS; belum di-commit |
| 4 | Migrasi data (680 file + mt_images_storage) | ⚪ Belum |
| 5 | Switch publik + buang sistem lama | ⚪ Belum |
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

## Perubahan Belum Di-commit (per 2026-08-30)

Fase 1 (`4428d3f`) & Fase 2 (`7cbafa6`) SUDAH di-commit. Yang belum (kode Fase 3 + doc):
- `resources/js/pages/admin/assets-file-manager/Index.vue` (rebuild)
- `resources/js/components/asset-manager/FolderTree.vue` (baru)
- `resources/js/components/dialogs/NamePromptDialog.vue` + `utils/name_prompt_dialog.js` (baru)
- `resources/js/components/dialogs/MoveDialog.vue` + `utils/move_dialog.js` (baru)
- `resources/js/components/dialogs/FileUploadDialog.vue` + `utils/file_upload_dialog.js` (baru)
- `docs/ASSET-MANAGER.md`, `docs/superpowers/specs/*design.md`, `*progress.md` (update)

Usulan commit message (belum dieksekusi, tunggu test browser):
`feat: Phase 3 unified asset manager - two-pane folder file manager UI`

## Catatan Antar-Sesi

- Web publik SEKARANG baca gambar dari `public/images/...` (structured-path via `rawStorage.*`), BUKAN dari `mt_images_storage`. Jangan hapus `public/images` sebelum Fase 5 selesai.
- Selama transisi, `mt_images_storage` + `mt_files_storage` hidup bersama. Jangan repoint relasi `image()` sebelum data pindah (Fase 4 → Fase 5).
- `FilesStorageController` existing rusak — akan dirombak di Fase 2, jangan dipakai apa adanya.
- Seeder digenerate ulang paling akhir (Fase 6), setelah semua data final.
- Larangan git: jangan commit/push tanpa izin eksplisit user.
