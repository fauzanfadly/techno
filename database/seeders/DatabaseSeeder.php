<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(CacheTableSeeder::class);
        $this->call(CacheLocksTableSeeder::class);
        $this->call(FailedJobsTableSeeder::class);
        $this->call(JobBatchesTableSeeder::class);
        $this->call(JobsTableSeeder::class);
        $this->call(MigrationsTableSeeder::class);
        $this->call(MtFilesStorageTableSeeder::class);
        $this->call(MtImagesStorageTableSeeder::class);
        $this->call(MtManufactureTypeTableSeeder::class);
        $this->call(MtProductTableSeeder::class);
        $this->call(MtProductCategoryTableSeeder::class);
        $this->call(MtProductSeriesTableSeeder::class);
        $this->call(MtVendorTableSeeder::class);
        $this->call(PasswordResetTokensTableSeeder::class);
        $this->call(SessionsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
