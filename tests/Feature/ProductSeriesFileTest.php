<?php

namespace Tests\Feature;

use App\Models\MtFilesStorage;
use App\Models\MtProductCategory;
use App\Models\MtProductSeries;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductSeriesFileTest extends TestCase
{
    use RefreshDatabase;

    private function makePdf(): MtFilesStorage
    {
        return MtFilesStorage::create([
            'name' => 'Manual TW',
            'file_path' => 'upload/files/series/manual-tw.pdf',
            'file_name' => 'manual-tw.pdf',
            'file_extension' => 'pdf',
            'file_size' => '2048',
            'file_mime_type' => 'application/pdf',
        ]);
    }

    private function makeCategory(): MtProductCategory
    {
        return MtProductCategory::create(['mt_vendor_id' => 1, 'name' => 'Torque Wrench']);
    }

    public function test_store_persists_file_id(): void
    {
        $category = $this->makeCategory();
        $pdf = $this->makePdf();

        $response = $this->actingAs(User::factory()->create(), 'api')
            ->postJson('/api/product/series/create', [
                'name' => 'TW Series',
                'mt_product_category_id' => $category->id,
                'file_id' => $pdf->id,
            ]);

        $response->assertStatus(200)->assertJsonPath('status', 'SUCCESS');
        $this->assertDatabaseHas('mt_product_series', [
            'name' => 'TW Series',
            'file_id' => $pdf->id,
        ]);
    }

    public function test_update_sets_file_id(): void
    {
        $category = $this->makeCategory();
        $pdf = $this->makePdf();
        $series = MtProductSeries::create([
            'name' => 'TW',
            'mt_product_category_id' => $category->id,
        ]);

        $this->actingAs(User::factory()->create(), 'api')
            ->postJson("/api/product/series/update/{$series->id}", [
                'name' => 'TW',
                'mt_product_category_id' => $category->id,
                'file_id' => $pdf->id,
            ])
            ->assertStatus(200);

        $this->assertSame($pdf->id, $series->fresh()->file_id);
    }

    public function test_show_returns_file_relation(): void
    {
        $category = $this->makeCategory();
        $pdf = $this->makePdf();
        $series = MtProductSeries::create([
            'name' => 'TW',
            'mt_product_category_id' => $category->id,
            'file_id' => $pdf->id,
        ]);

        $this->getJson("/api/product/series/detail/{$series->id}")
            ->assertStatus(200)
            ->assertJsonPath('data.file.id', $pdf->id)
            ->assertJsonPath('data.file.file_path', 'upload/files/series/manual-tw.pdf');
    }
}
