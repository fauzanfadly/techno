<?php

namespace Tests\Feature;

use App\Models\MtFilesStorage;
use App\Models\MtManufactureType;
use App\Models\MtProductSeries;
use App\Models\MtVendor;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WireEntitiesToFilesTest extends TestCase
{
    use RefreshDatabase;

    private function makeFile(string $sourceRef, string $name): MtFilesStorage
    {
        return MtFilesStorage::create([
            'name' => $name,
            'file_path' => 'upload/files/x/' . $name . '.jpg',
            'file_name' => $name . '.jpg',
            'file_extension' => 'jpg',
            'file_size' => '10',
            'file_mime_type' => 'image/jpeg',
            'source_ref' => $sourceRef,
        ]);
    }

    public function test_wires_all_entity_types_and_relations_resolve_to_files(): void
    {
        // Manufacture masih menunjuk id lama mt_images_storage = 3
        $manuf = MtManufactureType::create(['id' => 1, 'name' => 'Wielding', 'image_id' => 3]);
        $vendor = MtVendor::create(['id' => 2, 'name' => 'MyTorq', 'mt_manufacture_type_id' => 1, 'image_id' => 5]);
        $series = MtProductSeries::create(['id' => 74, 'name' => 'TW', 'mt_product_category_id' => 10]);

        $fManuf = $this->makeFile('images:3', 'wielding');
        $fVendor = $this->makeFile('vendor:2:img', 'vendor2');
        $fSeriesImg = $this->makeFile('series:74:img', 'series74img');
        $fSeriesPdf = $this->makeFile('series:74:pdf', 'series74pdf');

        $this->artisan('assets:wire-entities')->assertExitCode(0);

        // FK ter-set ke id mt_files_storage yang benar
        $this->assertSame($fManuf->id, $manuf->fresh()->image_id);
        $this->assertSame($fVendor->id, $vendor->fresh()->image_id, 'Vendor pakai structured, overwrite images:5');
        $this->assertSame($fSeriesImg->id, $series->fresh()->image_id);
        $this->assertSame($fSeriesPdf->id, $series->fresh()->file_id);

        // Relasi resolve ke MtFilesStorage (bukan mt_images_storage)
        $this->assertInstanceOf(MtFilesStorage::class, $manuf->fresh()->image);
        $this->assertSame('upload/files/x/wielding.jpg', $manuf->fresh()->image->file_path);
        $this->assertSame('upload/files/x/series74pdf.jpg', $series->fresh()->file->file_path);
    }

    public function test_vendor_and_series_wiring_is_idempotent(): void
    {
        $vendor = MtVendor::create(['id' => 2, 'name' => 'MyTorq', 'mt_manufacture_type_id' => 1]);
        $series = MtProductSeries::create(['id' => 74, 'name' => 'TW', 'mt_product_category_id' => 10]);
        $fVendor = $this->makeFile('vendor:2:img', 'vendor2');
        $fSeries = $this->makeFile('series:74:img', 'series74img');

        $this->artisan('assets:wire-entities')->assertExitCode(0);
        $this->artisan('assets:wire-entities')->assertExitCode(0); // ulang

        $this->assertSame($fVendor->id, $vendor->fresh()->image_id);
        $this->assertSame($fSeries->id, $series->fresh()->image_id);
    }

    public function test_dry_run_writes_nothing(): void
    {
        $vendor = MtVendor::create(['id' => 2, 'name' => 'MyTorq', 'mt_manufacture_type_id' => 1]);
        $this->makeFile('vendor:2:img', 'vendor2');

        $this->artisan('assets:wire-entities', ['--dry-run' => true])->assertExitCode(0);

        $this->assertNull($vendor->fresh()->image_id);
    }
}
