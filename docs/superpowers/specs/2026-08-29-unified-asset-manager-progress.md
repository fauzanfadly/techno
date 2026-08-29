# Unified Asset Manager — Progress Tracker

- **Spec:** [2026-08-29-unified-asset-manager-design.md](2026-08-29-unified-asset-manager-design.md)
- **Mulai:** 2026-08-29
- **Update terakhir:** 2026-08-29
- **Resume:** anchor = `ASSET-MANAGER.md` (root). Katakan "baca `ASSET-MANAGER.md`" → dari situ baca spec (Bagian 0 = resume, Bagian 6 = peta kode), tracker ini, dan memory `asset-manager-migration.md`.

## Status Fase

| Fase | Deskripsi | Status |
|---|---|---|
| 1 | Kunci data model (desain + migration) | 🟢 Selesai — migrate sukses, schema terverifikasi (2026-08-29) |
| 2 | Backend CRUD unified + folder | ⚪ Belum |
| 3 | Frontend asset manager berfolder | ⚪ Belum |
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
- [ ] Commit (butuh izin user)

Catatan unique(parent_id,name): MySQL anggap NULL distinct, jadi folder root (parent_id NULL) dengan nama sama TIDAK tercegah di level DB — perlu cek app-level saat CRUD folder root (Fase 2).

## Perubahan Belum Di-commit (per 2026-08-29)

Menunggu izin user untuk commit. File yang berubah/baru:
- `database/migrations/2026_08_29_000001_create_mt_folders_table.php` (baru)
- `database/migrations/2026_08_29_000002_add_folder_id_to_mt_files_storage_table.php` (baru)
- `app/Models/MtFolder.php` (baru)
- `app/Models/MtFilesStorage.php` (edit — tambah relasi `folder()`)
- `ASSET-MANAGER.md` (baru — anchor resume)
- `docs/superpowers/specs/2026-08-29-unified-asset-manager-design.md` (baru — spec)
- `docs/superpowers/specs/2026-08-29-unified-asset-manager-progress.md` (baru — tracker ini)

Usulan commit message (belum dieksekusi):
`feat: Phase 1 unified asset manager - add mt_folders table + folder_id on mt_files_storage`

## Fase 2 — Catatan Awal (belum di-brainstorm)

Scope: rombak backend jadi asset manager berfolder. Titik-titik yang harus diputuskan saat brainstorm Fase 2:
- **CRUD folder:** endpoint create / rename / move / delete. Karena disk mirror (Keputusan #3), rename & move harus **pindah file fisik + rewrite `file_path` + `folder.path` semua turunan**, dibungkus DB transaction + rollback file kalau gagal.
- **Delete folder:** hapus file fisik turunan + row DB (cascade). Perlu putuskan: tolak kalau ada file di dalam, atau cascade.
- **Upload file:** generalisasi `UploadFileServices` supaya terima semua tipe (bukan cuma pdf/image). Tentukan validasi mime yang diizinkan.
- **Fix `FilesStorageController`** yang rusak (lihat Peta Kode Bagian 6.4 di spec): `store()` cuma `mimes:pdf`, `update()` referensi kolom `image_path`/`pdf_file_path` yang tak ada.
- **List/browse:** endpoint list isi folder (subfolder + file) per `folder_id`.
- **Validasi app-level:** cegah nama folder kembar di root (parent_id NULL) — DB tak menjaga ini.
- **Route API:** pola `resource` mengikuti konvensi existing di `routes/api.php`.

## Catatan Antar-Sesi

- Web publik SEKARANG baca gambar dari `public/images/...` (structured-path via `rawStorage.*`), BUKAN dari `mt_images_storage`. Jangan hapus `public/images` sebelum Fase 5 selesai.
- Selama transisi, `mt_images_storage` + `mt_files_storage` hidup bersama. Jangan repoint relasi `image()` sebelum data pindah (Fase 4 → Fase 5).
- `FilesStorageController` existing rusak — akan dirombak di Fase 2, jangan dipakai apa adanya.
- Seeder digenerate ulang paling akhir (Fase 6), setelah semua data final.
- Larangan git: jangan commit/push tanpa izin eksplisit user.
