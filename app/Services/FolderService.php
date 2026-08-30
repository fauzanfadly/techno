<?php

namespace App\Services;

use App\Exceptions\CustomError;
use App\Models\MtFilesStorage;
use App\Models\MtFolder;
use App\Models\MtProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class FolderService
{
    private string $disk = 'public';
    private string $base = 'upload/files';

    /**
     * FK columns yang benar-benar menunjuk mt_files_storage.
     * Fase 2: hanya mt_product.file_id. Fase 5 tambah image_id 5 entity setelah relasi di-repoint.
     *
     * @var array<int, array{0: class-string, 1: string}>
     */
    private array $fileReferences = [
        [MtProduct::class, 'file_id'],
    ];

    /** Sanitasi satu segmen nama folder untuk path fisik (spasi boleh, slash tidak). */
    public function segment(string $name): string
    {
        return trim(str_replace(['/', '\\'], '-', $name));
    }

    /** Bangun path relatif folder dari parent + nama. */
    public function buildPath(?MtFolder $parent, string $name): string
    {
        $segment = $this->segment($name);
        return $parent && $parent->path ? $parent->path . '/' . $segment : $segment;
    }

    /** Path relatif disk (di bawah base) untuk sebuah folder path. */
    public function diskDir(?string $folderPath): string
    {
        return $folderPath ? $this->base . '/' . $folderPath : $this->base;
    }

    /** Path absolut di disk 'public' untuk sebuah path relatif. */
    private function absolute(string $relative): string
    {
        return Storage::disk($this->disk)->path($relative);
    }

    public function create(?int $parentId, string $name): MtFolder
    {
        $parent = $parentId ? MtFolder::findOrFail($parentId) : null;
        $path = $this->buildPath($parent, $name);

        File::ensureDirectoryExists($this->absolute($this->diskDir($path)));

        return MtFolder::create([
            'name' => $name,
            'parent_id' => $parentId,
            'path' => $path,
        ]);
    }

    /**
     * Rename (ubah name) dan/atau move (ubah parent_id) sebuah folder.
     * Memindahkan direktori fisik beserta seluruh isinya, lalu me-rewrite
     * path folder turunan + file_path file turunan.
     */
    public function update(MtFolder $folder, array $attrs): MtFolder
    {
        // Bedakan "parent_id tidak dikirim" (tetap) vs "parent_id null" (pindah ke root)
        $name = $attrs['name'] ?? $folder->name;
        $parentId = array_key_exists('parent_id', $attrs) ? $attrs['parent_id'] : $folder->parent_id;

        $parent = $parentId ? MtFolder::findOrFail($parentId) : null;

        if ($parent && $this->isSelfOrDescendant($folder, $parent)) {
            throw new CustomError("Tidak bisa memindahkan folder ke dalam dirinya sendiri atau turunannya");
        }

        $oldPath = $folder->path;
        $newPath = $this->buildPath($parent, $name);

        // Tidak ada perubahan sama sekali
        if ($newPath === $oldPath && $name === $folder->name && $parentId === $folder->parent_id) {
            return $folder;
        }

        $oldDir = $this->absolute($this->diskDir($oldPath));
        $newDir = $this->absolute($this->diskDir($newPath));
        $moved = false;

        if ($newPath !== $oldPath) {
            if (File::exists($newDir)) {
                throw new CustomError("Folder tujuan '$newPath' sudah ada");
            }
            if (File::exists($oldDir)) {
                File::ensureDirectoryExists(dirname($newDir));
                File::moveDirectory($oldDir, $newDir);
                $moved = true;
            }
        }

        try {
            DB::transaction(function () use ($folder, $name, $parentId, $oldPath, $newPath) {
                // Kumpulkan turunan sebelum path berubah
                $descendants = MtFolder::where('path', 'like', $oldPath . '/%')->get();

                // Update folder ini
                $folder->update([
                    'name' => $name,
                    'parent_id' => $parentId,
                    'path' => $newPath,
                ]);

                // Peta folder_id => path baru (self + turunan)
                $pathMap = [$folder->id => $newPath];
                foreach ($descendants as $child) {
                    $child->path = $newPath . substr($child->path, strlen($oldPath));
                    $child->save();
                    $pathMap[$child->id] = $child->path;
                }

                // Rewrite file_path semua file di folder-folder tersebut
                $files = MtFilesStorage::whereIn('folder_id', array_keys($pathMap))->get();
                foreach ($files as $item) {
                    $item->file_path = $this->diskDir($pathMap[$item->folder_id]) . '/' . $item->file_name;
                    $item->save();
                }
            });
        } catch (\Throwable $e) {
            // Revert pemindahan fisik agar konsisten dengan DB
            if ($moved && File::exists($newDir)) {
                File::moveDirectory($newDir, $oldDir);
            }
            throw new CustomError("Gagal update folder, {$e->getMessage()}");
        }

        return $folder->fresh();
    }

    /**
     * Hapus folder cascade: seluruh subfolder + file (DB & fisik),
     * dengan auto-detach FK entity yang menunjuk file-file tersebut.
     */
    public function delete(MtFolder $folder): void
    {
        $folderIds = $this->selfAndDescendantIds($folder);
        $fileIds = MtFilesStorage::whereIn('folder_id', $folderIds)->pluck('id')->all();
        $dir = $this->absolute($this->diskDir($folder->path));

        DB::transaction(function () use ($folderIds, $fileIds) {
            $this->detach($fileIds);
            MtFilesStorage::whereIn('id', $fileIds)->delete();
            MtFolder::whereIn('id', $folderIds)->delete();
        });

        if (File::exists($dir)) {
            File::deleteDirectory($dir);
        }
    }

    /** Set FK entity jadi null untuk setiap kolom yang menunjuk mt_files_storage. */
    public function detach(array $fileIds): void
    {
        if (empty($fileIds)) {
            return;
        }
        foreach ($this->fileReferences as [$model, $column]) {
            $model::whereIn($column, $fileIds)->update([$column => null]);
        }
    }

    /** ID folder ini + seluruh turunannya. */
    private function selfAndDescendantIds(MtFolder $folder): array
    {
        $ids = MtFolder::where('path', 'like', $folder->path . '/%')->pluck('id')->all();
        $ids[] = $folder->id;
        return $ids;
    }

    /** Cek apakah $target adalah $folder itu sendiri atau salah satu turunannya. */
    private function isSelfOrDescendant(MtFolder $folder, MtFolder $target): bool
    {
        if ($target->id === $folder->id) {
            return true;
        }
        return $target->path !== null
            && $folder->path !== null
            && str_starts_with($target->path, $folder->path . '/');
    }
}
