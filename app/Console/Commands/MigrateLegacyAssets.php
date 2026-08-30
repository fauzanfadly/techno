<?php

namespace App\Console\Commands;

use App\Models\MtFilesStorage;
use App\Models\MtFolder;
use App\Models\MtImagesStorage;
use App\Models\MtManufactureType;
use App\Models\MtProductCategory;
use App\Models\MtProductSeries;
use App\Models\MtVendor;
use App\Services\FolderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class MigrateLegacyAssets extends Command
{
    protected $signature = 'assets:migrate-legacy
        {--dry-run : Preview tanpa menulis apa pun}
        {--images-path= : Override path folder images (default public/images)}
        {--pdf-path= : Override path folder pdf (default public/pdf)}';

    protected $description = 'Fase 4: migrasi file legacy (public/images, public/pdf, mt_images_storage) ke mt_folders + mt_files_storage. Additive & idempotent.';

    private bool $dry = false;
    private array $folderCache = [];
    private array $stats = ['folders' => 0, 'files' => 0, 'skipped' => 0, 'missing' => 0];
    private array $unmatched = [];

    private $manufNames;   // id => name
    private $vendorNames;  // id => name
    private $catNames;     // id => name
    private $seriesNames;  // id => name

    public function handle(FolderService $folderService): int
    {
        $this->dry = (bool) $this->option('dry-run');
        $imagesPath = $this->option('images-path') ?: public_path('images');
        $pdfPath = $this->option('pdf-path') ?: public_path('pdf');

        $this->manufNames = MtManufactureType::pluck('name', 'id');
        $this->vendorNames = MtVendor::pluck('name', 'id');
        $this->catNames = MtProductCategory::pluck('name', 'id');
        $this->seriesNames = MtProductSeries::pluck('name', 'id');

        if ($this->dry) {
            $this->warn('DRY RUN — tidak ada yang ditulis.');
        }

        $this->migrateImages($folderService, $imagesPath);
        $this->migratePdfs($folderService, $pdfPath);
        $this->migrateImagesStorage($folderService);

        $this->newLine();
        $this->info("Folders dibuat : {$this->stats['folders']}");
        $this->info("Files dimigrasi: {$this->stats['files']}");
        $this->info("Dilewati (sudah ada): {$this->stats['skipped']}");
        $this->info("Source hilang  : {$this->stats['missing']}");
        if ($this->unmatched) {
            $this->warn('Tak terparse: ' . count($this->unmatched) . ' (contoh: ' . implode(', ', array_slice($this->unmatched, 0, 3)) . ')');
        }
        if ($this->dry) {
            $this->warn('DRY RUN selesai — jalankan tanpa --dry-run untuk eksekusi.');
        }

        return self::SUCCESS;
    }

    private function migrateImages(FolderService $svc, string $basePath): void
    {
        if (!File::isDirectory($basePath)) {
            $this->warn("Path images tidak ada: $basePath");
            return;
        }

        foreach (File::allFiles($basePath) as $file) {
            $rel = str_replace('\\', '/', $file->getRelativePathname());

            // Skip aset landing (bukan aset entity)
            if (preg_match('#^(logo|client_logos|authorized_distributor_logos)/#', $rel)) {
                continue;
            }

            $abs = $file->getRealPath();
            $ext = strtolower($file->getExtension());
            $fname = $file->getFilename();

            if (preg_match('#^manufacture_type_(\d+)/vendor_(\d+)/category_(\d+)/series/series_(\d+)_img\.#', $rel, $m)) {
                $folder = $this->ensureCategoryFolder($svc, $m[1], $m[2], $m[3]);
                $this->placeFile($folder, $abs, $fname, $this->seriesName($m[4]), $ext, "series:{$m[4]}:img");
            } elseif (preg_match('#^manufacture_type_(\d+)/vendor_(\d+)/vendor_\d+_img\.#', $rel, $m)) {
                $folder = $this->ensureVendorFolder($svc, $m[1], $m[2]);
                $this->placeFile($folder, $abs, $fname, $this->vendorName($m[2]), $ext, "vendor:{$m[2]}:img");
            } elseif (preg_match('#^manufacture_type_(\d+)/manufacture_type_\d+_img\.#', $rel, $m)) {
                $folder = $this->ensureManufFolder($svc, $m[1]);
                $this->placeFile($folder, $abs, $fname, $this->manufName($m[1]), $ext, "manufacture:{$m[1]}:img");
            } else {
                $this->unmatched[] = $rel;
            }
        }
    }

    private function migratePdfs(FolderService $svc, string $basePath): void
    {
        if (!File::isDirectory($basePath)) {
            $this->warn("Path pdf tidak ada: $basePath");
            return;
        }

        foreach (File::allFiles($basePath) as $file) {
            $rel = str_replace('\\', '/', $file->getRelativePathname());
            $abs = $file->getRealPath();
            $fname = $file->getFilename();

            if (preg_match('#^manufacture_type_(\d+)/vendor_(\d+)/category_(\d+)/series/series_(\d+)_pdf\.#', $rel, $m)) {
                $folder = $this->ensureCategoryFolder($svc, $m[1], $m[2], $m[3]);
                $this->placeFile($folder, $abs, $fname, $this->seriesName($m[4]) . ' (PDF)', 'pdf', "series:{$m[4]}:pdf");
            } else {
                $this->unmatched[] = 'pdf/' . $rel;
            }
        }
    }

    private function migrateImagesStorage(FolderService $svc): void
    {
        $rows = MtImagesStorage::all();
        if ($rows->isEmpty()) {
            return;
        }

        $folder = $this->ensureFolder($svc, null, 'Assets Lama', 'root:assets-lama');

        foreach ($rows as $img) {
            $abs = Storage::disk('public')->path($img->image_path);
            $fname = basename($img->image_path);
            $ext = $img->image_extension ?: strtolower(pathinfo($img->image_path, PATHINFO_EXTENSION));
            $name = $img->name ?: 'Image ' . $img->id;
            $this->placeFile($folder, $abs, $fname, $name, $ext, "images:{$img->id}");
        }
    }

    private function ensureManufFolder(FolderService $svc, $m)
    {
        return $this->ensureFolder($svc, null, $this->manufName($m), "m:$m");
    }

    private function ensureVendorFolder(FolderService $svc, $m, $v)
    {
        $parent = $this->ensureManufFolder($svc, $m);
        return $this->ensureFolder($svc, $parent, $this->vendorName($v), "v:$v");
    }

    private function ensureCategoryFolder(FolderService $svc, $m, $v, $c)
    {
        $parent = $this->ensureVendorFolder($svc, $m, $v);
        return $this->ensureFolder($svc, $parent, $this->catName($c), "c:$c");
    }

    /** @return object folder record (MtFolder asli, atau stub {id,path} saat dry-run) */
    private function ensureFolder(FolderService $svc, $parent, string $name, string $key)
    {
        if (isset($this->folderCache[$key])) {
            return $this->folderCache[$key];
        }

        $parentId = $parent->id ?? null;

        $existing = MtFolder::where('name', $name)
            ->when($parentId, fn ($q) => $q->where('parent_id', $parentId), fn ($q) => $q->whereNull('parent_id'))
            ->first();
        if ($existing) {
            return $this->folderCache[$key] = $existing;
        }

        $this->stats['folders']++;

        if ($this->dry) {
            $seg = $svc->segment($name);
            $path = ($parent && $parent->path) ? $parent->path . '/' . $seg : $seg;
            return $this->folderCache[$key] = (object) ['id' => null, 'path' => $path, 'name' => $name];
        }

        return $this->folderCache[$key] = $svc->create($parentId, $name);
    }

    private function placeFile($folder, string $sourceAbs, string $fileName, string $displayName, string $ext, string $sourceRef): void
    {
        if (MtFilesStorage::where('source_ref', $sourceRef)->exists()) {
            $this->stats['skipped']++;
            return;
        }
        if (!$sourceAbs || !file_exists($sourceAbs)) {
            $this->stats['missing']++;
            return;
        }

        $this->stats['files']++;
        if ($this->dry) {
            return;
        }

        $rel = 'upload/files/' . ($folder->path ? $folder->path . '/' : '') . $fileName;
        Storage::disk('public')->put($rel, file_get_contents($sourceAbs));

        MtFilesStorage::create([
            'folder_id' => $folder->id,
            'name' => $displayName,
            'description' => null,
            'file_path' => $rel,
            'file_name' => $fileName,
            'file_extension' => $ext,
            'file_size' => (string) filesize($sourceAbs),
            'file_mime_type' => (function_exists('mime_content_type') ? @mime_content_type($sourceAbs) : null) ?: 'application/octet-stream',
            'source_ref' => $sourceRef,
        ]);
    }

    private function manufName($id): string
    {
        return $this->manufNames[$id] ?? "Manufacture $id";
    }

    private function vendorName($id): string
    {
        return $this->vendorNames[$id] ?? "Vendor $id";
    }

    private function catName($id): string
    {
        return $this->catNames[$id] ?? "Category $id";
    }

    private function seriesName($id): string
    {
        return $this->seriesNames[$id] ?? "Series $id";
    }
}
