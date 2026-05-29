<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MtImagesStorageTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mt_images_storage')->delete();
        
        \DB::table('mt_images_storage')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Assembling',
                'description' => NULL,
                'image_path' => 'upload/images/1734782985_d1-img1.jpg',
                'image_name' => '1734782985_d1-img1.jpg',
                'image_extension' => 'jpg',
                'image_size' => '93529',
                'image_mime_type' => 'image/jpeg',
                'created_at' => '2024-12-21 12:09:46',
                'updated_at' => '2024-12-21 12:09:46',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Painting',
                'description' => NULL,
                'image_path' => 'upload/images/1734782997_d1-img5.jpg',
                'image_name' => '1734782997_d1-img5.jpg',
                'image_extension' => 'jpg',
                'image_size' => '117756',
                'image_mime_type' => 'image/jpeg',
                'created_at' => '2024-12-21 12:09:57',
                'updated_at' => '2024-12-21 12:09:57',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Weilding',
                'description' => NULL,
                'image_path' => 'upload/images/1734783044_d1-img7.jpg',
                'image_name' => '1734783044_d1-img7.jpg',
                'image_extension' => 'jpg',
                'image_size' => '40935',
                'image_mime_type' => 'image/jpeg',
                'created_at' => '2024-12-21 12:10:45',
                'updated_at' => '2024-12-21 12:10:45',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'Engineering & Services',
                'description' => NULL,
                'image_path' => 'upload/images/1734783065_business-structure-which-type-is-best-for-your-business.png',
                'image_name' => '1734783065_business-structure-which-type-is-best-for-your-business.png',
                'image_extension' => 'png',
                'image_size' => '219160',
                'image_mime_type' => 'image/png',
                'created_at' => '2024-12-21 12:11:05',
                'updated_at' => '2024-12-21 12:11:05',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'MyTorq logo',
                'description' => NULL,
                'image_path' => 'upload/images/1735013381_image 13.png',
                'image_name' => '1735013381_image 13.png',
                'image_extension' => 'png',
                'image_size' => '78249',
                'image_mime_type' => 'image/png',
                'created_at' => '2024-12-24 04:09:42',
                'updated_at' => '2024-12-24 04:09:42',
            ),
            5 => 
            array (
                'id' => 6,
                'name' => 'Cordless Screwdriver',
                'description' => NULL,
                'image_path' => 'upload/images/1735099491_output.jpg',
                'image_name' => '1735099491_output.jpg',
                'image_extension' => 'jpg',
                'image_size' => '80590',
                'image_mime_type' => 'image/jpeg',
                'created_at' => '2024-12-25 04:04:52',
                'updated_at' => '2024-12-25 04:04:52',
            ),
            6 => 
            array (
                'id' => 7,
                'name' => 'MYBT-IM',
                'description' => NULL,
            'image_path' => 'upload/images/1735262243_output (1).jpg',
            'image_name' => '1735262243_output (1).jpg',
                'image_extension' => 'jpg',
                'image_size' => '64161',
                'image_mime_type' => 'image/jpeg',
                'created_at' => '2024-12-27 01:17:24',
                'updated_at' => '2024-12-27 01:17:24',
            ),
        ));
        
        
    }
}