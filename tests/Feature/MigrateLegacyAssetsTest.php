<?php

namespace Tests\Feature;

use App\Models\MtFilesStorage;
use App\Models\MtFolder;
use App\Models\MtImagesStorage;
use App\Models\MtManufactureType;
use App\Models\MtProductCategory;
use App\Models\MtProductSeries;
use App\Models\MtVendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class MigrateLegacyAssetsTest extends TestCase
{
    use RefreshDatabase;

    private string $imagesPath;
    private string $pdfPath;

    protected function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');

        $base = sys_get_temp_dir() . '/legacy-fixture-' . uniqid();
        $this->imagesPath = $base . '/images';
        $this->pdfPath = $base . '/pdf';

        // Entities
        MtManufactureType::create(['id' => 1, 'name' => 'Assembling']);
        MtVendor::create(['id' => 2, 'name' => 'MyTorq', 'mt_manufacture_type_id' => 1]);
        MtProductCategory::create(['id' => 10, 'name' => 'Torque Wrench', 'mt_vendor_id' => 2]);
        MtProductSeries::create(['id' => 74, 'name' => 'TW-Series', 'mt_product_category_id' => 10]);

        // Fixture structured files
        $this->putFixture($this->imagesPath, 'manufacture_type_1/manufacture_type_1_img.jpg');
        $this->putFixture($this->imagesPath, 'manufacture_type_1/vendor_2/vendor_2_img.png');
        $this->putFixture($this->imagesPath, 'manufacture_type_1/vendor_2/category_10/series/series_74_img.jpg');
        $this->putFixture($this->imagesPath, 'logo/logo.png'); // landing -> harus di-skip
        $this->putFixture($this->pdfPath, 'manufacture_type_1/vendor_2/category_10/series/series_74_pdf.pdf');
    }

    protected function tearDown(): void
    {
        File::deleteDirectory(dirname($this->imagesPath));
        parent::tearDown();
    }

    private function putFixture(string $base, string $rel, string $content = 'dummy'): void
    {
        $full = $base . '/' . $rel;
        File::ensureDirectoryExists(dirname($full));
        File::put($full, $content);
    }

    private function runMigrate(bool $dry = false): void
    {
        $args = ['--images-path' => $this->imagesPath, '--pdf-path' => $this->pdfPath];
        if ($dry) {
            $args['--dry-run'] = true;
        }
        $this->artisan('assets:migrate-legacy', $args)->assertExitCode(0);
    }

    public function test_builds_folder_hierarchy_with_real_names(): void
    {
        $this->runMigrate();

        $this->assertDatabaseHas('mt_folders', ['name' => 'Assembling', 'parent_id' => null, 'path' => 'Assembling']);
        $manuf = MtFolder::where('name', 'Assembling')->first();
        $this->assertDatabaseHas('mt_folders', ['name' => 'MyTorq', 'parent_id' => $manuf->id, 'path' => 'Assembling/MyTorq']);
        $vendor = MtFolder::where('name', 'MyTorq')->first();
        $this->assertDatabaseHas('mt_folders', ['name' => 'Torque Wrench', 'parent_id' => $vendor->id, 'path' => 'Assembling/MyTorq/Torque Wrench']);
    }

    public function test_places_files_with_source_ref_and_physical_copy(): void
    {
        $this->runMigrate();

        // series image di folder category
        $img = MtFilesStorage::where('source_ref', 'series:74:img')->first();
        $this->assertNotNull($img);
        $this->assertSame('TW-Series', $img->name);
        $this->assertSame('upload/files/Assembling/MyTorq/Torque Wrench/series_74_img.jpg', $img->file_path);
        Storage::disk('public')->assertExists($img->file_path);

        // series pdf
        $pdf = MtFilesStorage::where('source_ref', 'series:74:pdf')->first();
        $this->assertNotNull($pdf);
        $this->assertSame('TW-Series (PDF)', $pdf->name);
        Storage::disk('public')->assertExists($pdf->file_path);

        // vendor + manufacture
        $this->assertDatabaseHas('mt_files_storage', ['source_ref' => 'vendor:2:img', 'name' => 'MyTorq']);
        $this->assertDatabaseHas('mt_files_storage', ['source_ref' => 'manufacture:1:img', 'name' => 'Assembling']);
    }

    public function test_skips_landing_assets(): void
    {
        $this->runMigrate();
        // logo tidak boleh jadi row
        $this->assertSame(0, MtFilesStorage::where('file_name', 'logo.png')->count());
    }

    public function test_migrates_images_storage_into_assets_lama(): void
    {
        Storage::disk('public')->put('upload/images/old_logo.png', 'x');
        MtImagesStorage::create([
            'id' => 5, 'name' => 'MyTorq logo', 'image_path' => 'upload/images/old_logo.png',
            'image_name' => 'old_logo.png', 'image_extension' => 'png', 'image_size' => '10', 'image_mime_type' => 'image/png',
        ]);

        $this->runMigrate();

        $folder = MtFolder::where('name', 'Assets Lama')->first();
        $this->assertNotNull($folder);
        $this->assertDatabaseHas('mt_files_storage', ['source_ref' => 'images:5', 'name' => 'MyTorq logo', 'folder_id' => $folder->id]);
    }

    public function test_is_idempotent(): void
    {
        $this->runMigrate();
        $filesAfterFirst = MtFilesStorage::count();
        $foldersAfterFirst = MtFolder::count();

        $this->runMigrate(); // ulang

        $this->assertSame($filesAfterFirst, MtFilesStorage::count(), 'Rerun tidak boleh menambah file');
        $this->assertSame($foldersAfterFirst, MtFolder::count(), 'Rerun tidak boleh menambah folder');
    }

    public function test_dry_run_writes_nothing(): void
    {
        $this->runMigrate(dry: true);
        $this->assertSame(0, MtFolder::count());
        $this->assertSame(0, MtFilesStorage::count());
    }
}
