<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MtVendorTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mt_vendor')->delete();
        
        \DB::table('mt_vendor')->insert(array (
            0 => 
            array (
                'id' => 2,
                'mt_manufacture_type_id' => 1,
                'image_id' => 198,
                'name' => 'MyTorq',
                'description' => NULL,
                'created_at' => '2024-12-25 03:57:45',
                'updated_at' => '2026-09-01 06:21:18',
            ),
            1 => 
            array (
                'id' => 3,
                'mt_manufacture_type_id' => 1,
                'image_id' => 223,
                'name' => 'OHMI',
                'description' => NULL,
                'created_at' => '2024-12-30 10:45:31',
                'updated_at' => '2026-09-01 06:21:19',
            ),
            2 => 
            array (
                'id' => 4,
                'mt_manufacture_type_id' => 1,
                'image_id' => 237,
                'name' => 'Sanyo Machine Works',
                'description' => NULL,
                'created_at' => '2024-12-30 10:45:41',
                'updated_at' => '2026-09-01 06:21:19',
            ),
            3 => 
            array (
                'id' => 5,
                'mt_manufacture_type_id' => 1,
                'image_id' => 247,
                'name' => 'Posilift',
                'description' => NULL,
                'created_at' => '2024-12-30 10:46:04',
                'updated_at' => '2026-09-01 06:21:19',
            ),
            4 => 
            array (
                'id' => 6,
                'mt_manufacture_type_id' => 1,
                'image_id' => 303,
                'name' => 'Modular Assembly Technology',
                'description' => NULL,
                'created_at' => '2024-12-30 10:46:14',
                'updated_at' => '2026-09-01 06:21:19',
            ),
            5 => 
            array (
                'id' => 7,
                'mt_manufacture_type_id' => 1,
                'image_id' => 317,
                'name' => 'Noblift',
                'description' => NULL,
                'created_at' => '2024-12-30 10:47:14',
                'updated_at' => '2026-09-01 06:21:19',
            ),
            6 => 
            array (
                'id' => 8,
                'mt_manufacture_type_id' => 2,
                'image_id' => 417,
                'name' => 'Meech',
                'description' => NULL,
                'created_at' => '2024-12-30 10:47:57',
                'updated_at' => '2026-09-01 06:21:19',
            ),
            7 => 
            array (
                'id' => 9,
                'mt_manufacture_type_id' => 2,
                'image_id' => 432,
                'name' => 'Sankyo Fuji Star',
                'description' => NULL,
                'created_at' => '2024-12-30 10:48:45',
                'updated_at' => '2026-09-01 06:21:19',
            ),
            8 => 
            array (
                'id' => 10,
                'mt_manufacture_type_id' => 2,
                'image_id' => 345,
                'name' => 'Wetzel',
                'description' => NULL,
                'created_at' => '2024-12-30 10:48:56',
                'updated_at' => '2026-09-01 06:21:19',
            ),
            9 => 
            array (
                'id' => 11,
                'mt_manufacture_type_id' => 2,
                'image_id' => 386,
                'name' => 'Mayteck',
                'description' => NULL,
                'created_at' => '2024-12-30 10:49:30',
                'updated_at' => '2026-09-01 06:21:19',
            ),
            10 => 
            array (
                'id' => 12,
                'mt_manufacture_type_id' => 2,
                'image_id' => 402,
                'name' => 'Bibielle',
                'description' => NULL,
                'created_at' => '2024-12-30 10:49:51',
                'updated_at' => '2026-09-01 06:21:19',
            ),
            11 => 
            array (
                'id' => 13,
                'mt_manufacture_type_id' => 3,
                'image_id' => 466,
                'name' => 'Luvata',
                'description' => NULL,
                'created_at' => '2024-12-30 10:50:11',
                'updated_at' => '2026-09-01 06:21:19',
            ),
            12 => 
            array (
                'id' => 14,
                'mt_manufacture_type_id' => 3,
                'image_id' => 659,
                'name' => 'Xingweihan Welding',
                'description' => NULL,
                'created_at' => '2025-01-08 07:39:26',
                'updated_at' => '2026-09-01 06:21:19',
            ),
        ));
        
        
    }
}