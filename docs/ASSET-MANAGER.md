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
- **Next step:** Fase 4 (migrasi data 680 file `public/images`+pdf + `mt_images_storage` → storage) ATAU Fase 5 (switch publik + repoint relasi + wiring form entity + buang sistem lama). Belum di-brainstorm detail.
- **Temuan sampingan (di luar scope):** `AuthController@register` RUSAK (`...$user` spread model Eloquent, `AuthController.php:43`) — register API error.

## Larangan / Hati-hati

- **Jangan commit/push tanpa izin eksplisit user.**
- Jangan repoint relasi `image()` 5 entity sebelum data pindah (Fase 4→5) — rusak admin.
- Jangan hapus `public/images` (680 file, dibaca web publik sekarang) sebelum Fase 5.
- `FilesStorageController` existing rusak — dirombak di Fase 2, jangan dipakai apa adanya.
