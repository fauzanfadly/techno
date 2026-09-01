<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * Urutan penting (folder_id, image_id/file_id):
     * folders -> files -> entity. Tabel ephemeral (cache/sessions/jobs/
     * migrations/password_reset_tokens) TIDAK di-seed (data runtime).
     */
    public function run(): void
    {
        // Asset manager (folder harus sebelum files; files sebelum entity yang FK ke image_id/file_id)
        $this->call(MtFoldersTableSeeder::class);
        $this->call(MtFilesStorageTableSeeder::class);
        $this->call(MtImagesStorageTableSeeder::class); // backup data lama

        // Master data (manufacture -> vendor -> category -> series -> product)
        $this->call(MtManufactureTypeTableSeeder::class);
        $this->call(MtVendorTableSeeder::class);
        $this->call(MtProductCategoryTableSeeder::class);
        $this->call(MtProductSeriesTableSeeder::class);
        $this->call(MtProductTableSeeder::class);

        // Users
        $this->call(UsersTableSeeder::class);
    }
}
