<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MtManufactureTypeTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mt_manufacture_type')->delete();
        
        \DB::table('mt_manufacture_type')->insert(array (
            0 => 
            array (
                'id' => 1,
                'image_id' => 1021,
                'name' => 'Assembling',
                'description' => NULL,
                'created_at' => '2024-12-23 05:09:41',
                'updated_at' => '2026-09-01 06:21:18',
            ),
            1 => 
            array (
                'id' => 2,
                'image_id' => 1022,
                'name' => 'Painting',
                'description' => NULL,
                'created_at' => '2024-12-26 09:40:32',
                'updated_at' => '2026-09-01 06:21:18',
            ),
            2 => 
            array (
                'id' => 3,
                'image_id' => 1023,
                'name' => 'Wielding',
                'description' => NULL,
                'created_at' => '2024-12-30 10:39:40',
                'updated_at' => '2026-09-01 06:21:18',
            ),
        ));
        
        
    }
}