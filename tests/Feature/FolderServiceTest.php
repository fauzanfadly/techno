<?php

namespace Tests\Feature;

use App\Exceptions\CustomError;
use App\Models\MtFilesStorage;
use App\Models\MtFolder;
use App\Models\MtProduct;
use App\Services\FolderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FolderServiceTest extends TestCase
{
    use RefreshDatabase;

    private FolderService $service;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        $this->service = new FolderService();
    }

    private function dirExists(string $relative): bool
    {
        return File::isDirectory(Storage::disk('public')->path($relative));
    }

    private function makeFile(?MtFolder $folder, string $name = 'x.jpg'): MtFilesStorage
    {
        $folderPath = $folder?->path;
        $dir = 'upload/files' . ($folderPath ? '/' . $folderPath : '');
        Storage::disk('public')->put($dir . '/' . $name, 'dummy');

        return MtFilesStorage::create([
            'folder_id' => $folder?->id,
            'name' => $name,
            'file_path' => $dir . '/' . $name,
            'file_name' => $name,
            'file_extension' => 'jpg',
            'file_size' => '5',
            'file_mime_type' => 'image/jpeg',
        ]);
    }

    public function test_create_builds_nested_path_and_physical_dir(): void
    {
        $root = $this->service->create(null, 'MyTorq');
        $this->assertSame('MyTorq', $root->path);
        $this->assertTrue($this->dirExists('upload/files/MyTorq'));

        $child = $this->service->create($root->id, 'Assembling');
        $this->assertSame('MyTorq/Assembling', $child->path);
        $this->assertTrue($this->dirExists('upload/files/MyTorq/Assembling'));
    }

    public function test_rename_folder_rewrites_file_path_and_moves_dir(): void
    {
        $folder = $this->service->create(null, 'Old');
        $file = $this->makeFile($folder, 'x.jpg');

        $this->service->update($folder, ['name' => 'New']);

        $this->assertSame('New', $folder->fresh()->path);
        $this->assertSame('upload/files/New/x.jpg', $file->fresh()->file_path);
        Storage::disk('public')->assertExists('upload/files/New/x.jpg');
        Storage::disk('public')->assertMissing('upload/files/Old/x.jpg');
    }

    public function test_move_folder_rewrites_descendants_and_moves_files(): void
    {
        $a = $this->service->create(null, 'A');
        $b = $this->service->create($a->id, 'B');
        $file = $this->makeFile($b, 'x.jpg');
        $c = $this->service->create(null, 'C');

        $this->service->update($a, ['parent_id' => $c->id]);

        $this->assertSame('C/A', $a->fresh()->path);
        $this->assertSame('C/A/B', $b->fresh()->path);
        $this->assertSame('upload/files/C/A/B/x.jpg', $file->fresh()->file_path);
        Storage::disk('public')->assertExists('upload/files/C/A/B/x.jpg');
        Storage::disk('public')->assertMissing('upload/files/A/B/x.jpg');
    }

    public function test_move_into_own_descendant_is_rejected(): void
    {
        $a = $this->service->create(null, 'A');
        $b = $this->service->create($a->id, 'B');

        $this->expectException(CustomError::class);
        $this->service->update($a, ['parent_id' => $b->id]);
    }

    public function test_delete_cascades_and_detaches_only_file_id(): void
    {
        $a = $this->service->create(null, 'A');
        $b = $this->service->create($a->id, 'B');
        $file = $this->makeFile($b, 'x.jpg');

        // Product yang benar-benar mereferensi file lewat file_id -> harus di-detach
        $prodFile = MtProduct::create([
            'mt_product_series_id' => 1,
            'name' => 'ProdFile',
            'file_id' => $file->id,
        ]);

        // Transition-safety: product dengan image_id numerik sama dengan file id
        // (image_id masih menunjuk mt_images_storage) -> TIDAK BOLEH tersentuh
        $prodImage = MtProduct::create([
            'mt_product_series_id' => 1,
            'name' => 'ProdImage',
            'image_id' => $file->id,
        ]);

        $this->service->delete($a);

        $this->assertDatabaseMissing('mt_folders', ['id' => $a->id]);
        $this->assertDatabaseMissing('mt_folders', ['id' => $b->id]);
        $this->assertDatabaseMissing('mt_files_storage', ['id' => $file->id]);

        $this->assertNull($prodFile->fresh()->file_id, 'file_id harus di-null-kan');
        $this->assertSame($file->id, $prodImage->fresh()->image_id, 'image_id TIDAK boleh tersentuh di Fase 2');

        Storage::disk('public')->assertMissing('upload/files/A/B/x.jpg');
    }
}
