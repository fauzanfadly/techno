# ASSET-MANAGER — Anchor Resume

> **File ini adalah pintu masuk (anchor) untuk melanjutkan pekerjaan "Unified Asset Manager".**
> Di chat baru, cukup katakan: **"baca `ASSET-MANAGER.md`"**.

## Apa Ini

Migrasi besar sistem gambar/file project **Techno** (Laravel 11 + Vue 3) menjadi satu **asset manager terpadu dengan foldering** (`assets-file-manager` + tabel `mt_files_storage`), menghapus total `mt_images_storage` + `assets-image-manager`.

## Yang Harus Dibaca (urut)

1. **Spec penuh** — [docs/superpowers/specs/2026-08-29-unified-asset-manager-design.md](docs/superpowers/specs/2026-08-29-unified-asset-manager-design.md)
   - Bagian 0 = instruksi resume detail
   - Bagian 3 = roadmap 6 fase
   - Bagian 4 = keputusan Fase 1 (data model)
   - **Bagian 6 = Peta Kode** (semua lokasi `file:line`) → JANGAN explore codebase dari nol, pakai ini
2. **Progress tracker** — [docs/superpowers/specs/2026-08-29-unified-asset-manager-progress.md](docs/superpowers/specs/2026-08-29-unified-asset-manager-progress.md) → status terkini tiap fase, sumber kebenaran "sampai mana"
3. **Memory** `asset-manager-migration.md` → ringkasan + larangan penting (auto-load tiap sesi)

## Status Sekarang (2026-08-29)

- **Fase 1 (data model): SELESAI & terverifikasi.** Migration jalan, `mt_folders` + `folder_id` sudah ada di DB. Model `MtFolder` + relasi `folder()` siap.
- Keputusan terkunci: (1) tabel `mt_folders` terpisah + `folder_id`; (2) pertahankan `image_id`+`file_id`, repoint relasi nanti (Fase 5); (3) mirror pohon folder di disk.
- **Next step:** brainstorm **Fase 2** (backend CRUD unified + folder) — rombak `FilesStorageController` (terima semua tipe file, folder create/rename/move/delete transaksional + pindah file fisik, list per folder), generalisasi `UploadFileServices`, route API. Belum di-brainstorm detail.

## Larangan / Hati-hati

- **Jangan commit/push tanpa izin eksplisit user.**
- Jangan repoint relasi `image()` 5 entity sebelum data pindah (Fase 4→5) — rusak admin.
- Jangan hapus `public/images` (680 file, dibaca web publik sekarang) sebelum Fase 5.
- `FilesStorageController` existing rusak — dirombak di Fase 2, jangan dipakai apa adanya.
