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
   - Bagian 7/8/9/10 = keputusan & desain Fase 2/3/4/6
   - Bagian 10.4 = ⚠️ daftar backup yang TIDAK boleh dihapus sampai produksi aman
2. **Progress tracker** — [superpowers/specs/2026-08-29-unified-asset-manager-progress.md](superpowers/specs/2026-08-29-unified-asset-manager-progress.md) → status terkini tiap fase, sumber kebenaran "sampai mana"
3. **Memory** `asset-manager-migration.md` → ringkasan + larangan penting (auto-load tiap sesi)

## Status Sekarang (2026-09-01)

**Fase 1–6 SELESAI & di-main (semua di-commit). Sisa cuma: deploy ke cPanel + cleanup backup (setelah produksi aman).**

Ringkas per fase (commit di `main`):
- **Fase 1** data model — `mt_folders` + `folder_id` di `mt_files_storage` (`4428d3f`)
- **Fase 2** backend CRUD+folder — `FolderService`/`FoldersController`, rombak `FilesStorageController`, endpoint `assets-manager/folder/*`+`file/*` (`7cbafa6`)
- **Fase 3** frontend two-pane manager — `assets-file-manager/Index.vue`, `FolderTree`, dialog Name/Move/Upload (`25d2438`)
- **Fase 4** migrasi data — command `assets:migrate-legacy` + kolom `source_ref`; **dijalankan user** → `storage/app/public/upload/files` terisi 1025 file/112 folder; `public/images` tetap utuh (`6f8bd64`)
- **Fase 5** flip (atomic) — repoint relasi `image()` 5 model → `MtFilesStorage`, `file_id` di series, command `assets:wire-entities`, picker `FilePickerDialog`, 5 form entity + frontend publik baca DB, buang sistem lama. **Flip live dijalankan user + Playwright PASS.** Merged (`8840c9c`). Wiring rule: manufacture→`mt_images_storage`(images:1/2/3), vendor+series→structured.
- **Fase 6** deploy prep + seeder — seeder regen clean via iseed (MtFolders 111/MtFilesStorage 1025/series 643/category 94/vendor 13/manufacture 3/images 7 backup), `DatabaseSeeder` ditulis ulang (urutan folders→files→images→entity→users; seeder ephemeral cache/sessions/jobs/migrations/password_reset dihapus), verified `migrate:fresh --seed` di sqlite. `.gitignore` tak diubah (`storage/app/public/upload` sudah trackable). Di-commit (`706c908`)

**Verifikasi:** unit test **16 pass**; Playwright end-to-end (admin form + katalog publik) render dari `/storage/upload/files` (DB), `anyOldRawStoragePath=false`.

**Sisa (user, non-code):**
1. **Deploy cPanel** — upload kode + folder `storage/app/public/upload`; di server `php artisan storage:link` + `migrate`/seed. Checklist di spec Bagian 10.3.
2. **Cleanup backup** — mini-task terpisah, HANYA setelah produksi terbukti aman (lihat Bagian 10.4).

**Temuan sampingan (di luar scope):** `AuthController@register` RUSAK (`...$user` spread model, `AuthController.php:43`) — register API error. Opsional: PDF picker admin di form series/product (`file_id`).

## Larangan / Hati-hati

- **Jangan commit/push tanpa izin eksplisit user.**
- ⚠️ **JANGAN drop/hapus backup APAPUN sampai deploy produksi terverifikasi 100% aman** (keputusan user 2026-09-01). Backup = table `mt_images_storage`+model, kolom `source_ref`, command `MigrateLegacyAssets`+test, DAN file asli `public/images`(680)+`public/pdf`(365). Detail Bagian 10.4.
- Jangan jalankan `migrate:fresh` / `db:seed` di DB **mysql live** tanpa maksud reset — cuma sqlite (test) yang aman. `assets:migrate-legacy` & `assets:wire-entities` SUDAH dijalankan — jangan re-run tanpa alasan (idempotent tapi tetap hati-hati).
