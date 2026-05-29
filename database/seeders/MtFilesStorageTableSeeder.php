<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MtFilesStorageTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mt_files_storage')->delete();
        
        
        
    }
}