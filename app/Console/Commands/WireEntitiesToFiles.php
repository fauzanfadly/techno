<?php

namespace App\Console\Commands;

use App\Models\MtFilesStorage;
use App\Models\MtManufactureType;
use App\Models\MtProductSeries;
use App\Models\MtVendor;
use Illuminate\Console\Command;

class WireEntitiesToFiles extends Command
{
    protected $signature = 'assets:wire-entities {--dry-run : Preview tanpa menulis}';

    protected $description = 'Fase 5: wiring FK entity (image_id/file_id) ke mt_files_storage berdasarkan source_ref hasil migrasi Fase 4.';

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');

        // source_ref => mt_files_storage.id
        $map = MtFilesStorage::whereNotNull('source_ref')->pluck('id', 'source_ref');
        if ($map->isEmpty()) {
            $this->error('Belum ada mt_files_storage dengan source_ref. Jalankan assets:migrate-legacy dulu.');
            return self::FAILURE;
        }

        $stats = ['manufacture' => 0, 'vendor' => 0, 'series_img' => 0, 'series_pdf' => 0];

        // MANUFACTURE -> mt_images_storage (images:<oldId>).
        // Snapshot old image_id sebelum menulis; key stabil via nilai lama.
        $manufs = MtManufactureType::whereNotNull('image_id')->get(['id', 'image_id']);
        foreach ($manufs as $m) {
            $key = "images:{$m->image_id}";
            if (isset($map[$key])) {
                if (!$dry) {
                    MtManufactureType::where('id', $m->id)->update(['image_id' => $map[$key]]);
                }
                $stats['manufacture']++;
            }
        }

        // VENDOR -> structured (vendor:<id>:img). Key stabil = idempotent.
        foreach (MtVendor::pluck('id') as $vid) {
            $key = "vendor:$vid:img";
            if (isset($map[$key])) {
                if (!$dry) {
                    MtVendor::where('id', $vid)->update(['image_id' => $map[$key]]);
                }
                $stats['vendor']++;
            }
        }

        // SERIES -> structured (series:<id>:img -> image_id, series:<id>:pdf -> file_id).
        foreach (MtProductSeries::pluck('id') as $sid) {
            $imgKey = "series:$sid:img";
            $pdfKey = "series:$sid:pdf";
            if (isset($map[$imgKey])) {
                if (!$dry) {
                    MtProductSeries::where('id', $sid)->update(['image_id' => $map[$imgKey]]);
                }
                $stats['series_img']++;
            }
            if (isset($map[$pdfKey])) {
                if (!$dry) {
                    MtProductSeries::where('id', $sid)->update(['file_id' => $map[$pdfKey]]);
                }
                $stats['series_pdf']++;
            }
        }

        $this->newLine();
        $this->info("Manufacture image_id : {$stats['manufacture']}");
        $this->info("Vendor image_id      : {$stats['vendor']}");
        $this->info("Series image_id      : {$stats['series_img']}");
        $this->info("Series file_id (pdf) : {$stats['series_pdf']}");
        if ($dry) {
            $this->warn('DRY RUN — tidak ada yang ditulis.');
        }

        return self::SUCCESS;
    }
}
