<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MtProductCategoryTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mt_product_category')->delete();
        
        \DB::table('mt_product_category')->insert(array (
            0 => 
            array (
                'id' => 4,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Industry 4.0 Transducerized Screwdriver',
                'description' => NULL,
                'created_at' => '2024-12-31 05:15:33',
                'updated_at' => '2024-12-31 05:15:33',
            ),
            1 => 
            array (
                'id' => 5,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Industry 4.0 Current Control Screwdriver',
                'description' => NULL,
                'created_at' => '2024-12-31 05:15:42',
                'updated_at' => '2024-12-31 05:15:42',
            ),
            2 => 
            array (
                'id' => 6,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Automation',
                'description' => NULL,
                'created_at' => '2024-12-31 05:15:50',
                'updated_at' => '2024-12-31 05:15:50',
            ),
            3 => 
            array (
                'id' => 7,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Torque Readout Screwdriver',
                'description' => NULL,
                'created_at' => '2024-12-31 05:15:58',
                'updated_at' => '2024-12-31 05:15:58',
            ),
            4 => 
            array (
                'id' => 8,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Brushless Auto Shut off Screwdriver',
                'description' => NULL,
                'created_at' => '2024-12-31 05:16:05',
                'updated_at' => '2024-12-31 05:16:05',
            ),
            5 => 
            array (
                'id' => 9,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'AC Brushless Auto Shut off Screwdriver',
                'description' => NULL,
                'created_at' => '2024-12-31 05:16:11',
                'updated_at' => '2024-12-31 05:16:11',
            ),
            6 => 
            array (
                'id' => 10,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Built-in Error Proof Screwdriver',
                'description' => NULL,
                'created_at' => '2024-12-31 05:16:26',
                'updated_at' => '2024-12-31 05:16:26',
            ),
            7 => 
            array (
                'id' => 11,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Power Controller',
                'description' => NULL,
                'created_at' => '2024-12-31 05:16:31',
                'updated_at' => '2024-12-31 05:16:31',
            ),
            8 => 
            array (
                'id' => 13,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Error Proof Counter',
                'description' => NULL,
                'created_at' => '2024-12-31 05:16:47',
                'updated_at' => '2024-12-31 05:16:47',
            ),
            9 => 
            array (
                'id' => 14,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Cordless Screwdriver',
                'description' => NULL,
                'created_at' => '2024-12-31 05:16:53',
                'updated_at' => '2024-12-31 05:16:53',
            ),
            10 => 
            array (
                'id' => 15,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Torque Meter',
                'description' => NULL,
                'created_at' => '2024-12-31 05:16:59',
                'updated_at' => '2024-12-31 05:16:59',
            ),
            11 => 
            array (
                'id' => 16,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Screw Feeder',
                'description' => NULL,
                'created_at' => '2024-12-31 05:17:06',
                'updated_at' => '2024-12-31 05:17:06',
            ),
            12 => 
            array (
                'id' => 17,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Auxiliary Arm',
                'description' => NULL,
                'created_at' => '2024-12-31 05:17:12',
                'updated_at' => '2024-12-31 05:17:12',
            ),
            13 => 
            array (
                'id' => 18,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'I/O Signal Control Box',
                'description' => NULL,
                'created_at' => '2024-12-31 05:17:18',
                'updated_at' => '2024-12-31 05:17:18',
            ),
            14 => 
            array (
                'id' => 19,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Slow Start Control Module',
                'description' => NULL,
                'created_at' => '2024-12-31 05:17:25',
                'updated_at' => '2024-12-31 05:17:25',
            ),
            15 => 
            array (
                'id' => 20,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Accessories',
                'description' => NULL,
                'created_at' => '2024-12-31 05:17:31',
                'updated_at' => '2024-12-31 05:17:31',
            ),
            16 => 
            array (
                'id' => 21,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Carbon Brush Screwdrive',
                'description' => NULL,
                'created_at' => '2024-12-31 05:20:00',
                'updated_at' => '2024-12-31 05:20:00',
            ),
            17 => 
            array (
                'id' => 22,
                'mt_vendor_id' => 2,
                'image_id' => NULL,
                'name' => 'Carbon Brush Screwdrive + Error Proof Counter',
                'description' => NULL,
                'created_at' => '2025-01-07 00:26:32',
                'updated_at' => '2025-01-07 00:26:32',
            ),
            18 => 
            array (
                'id' => 23,
                'mt_vendor_id' => 4,
                'image_id' => NULL,
                'name' => 'Nutrunners',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'id' => 24,
                'mt_vendor_id' => 4,
                'image_id' => NULL,
                'name' => 'Servo Presses',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'id' => 25,
                'mt_vendor_id' => 4,
                'image_id' => NULL,
                'name' => 'Joining Systems',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'id' => 26,
                'mt_vendor_id' => 4,
                'image_id' => NULL,
                'name' => 'Smart Factories',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'id' => 27,
                'mt_vendor_id' => 5,
                'image_id' => NULL,
                'name' => 'Industrial Manipulators',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'id' => 28,
                'mt_vendor_id' => 5,
                'image_id' => NULL,
                'name' => 'Rigid Industrial Manipulators',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'id' => 29,
                'mt_vendor_id' => 5,
                'image_id' => NULL,
                'name' => 'Cable Balancing Industrial Manipulators',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'id' => 30,
                'mt_vendor_id' => 5,
                'image_id' => NULL,
                'name' => 'Mobile Industrial Manipulators',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'id' => 31,
                'mt_vendor_id' => 5,
                'image_id' => NULL,
                'name' => 'Air Balancers',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'id' => 32,
                'mt_vendor_id' => 5,
                'image_id' => NULL,
                'name' => 'Servo Hoists',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'id' => 33,
                'mt_vendor_id' => 5,
                'image_id' => NULL,
                'name' => 'Aluminium Rail',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'id' => 34,
                'mt_vendor_id' => 5,
                'image_id' => NULL,
                'name' => 'Steel Rail',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'id' => 35,
                'mt_vendor_id' => 5,
                'image_id' => NULL,
                'name' => 'Vertical Lifter',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'id' => 36,
                'mt_vendor_id' => 6,
                'image_id' => NULL,
                'name' => 'Aluminum Profile',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'id' => 37,
                'mt_vendor_id' => 6,
                'image_id' => NULL,
                'name' => 'Fastening Elements',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'id' => 38,
                'mt_vendor_id' => 6,
                'image_id' => NULL,
                'name' => 'Connecting Elements',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'id' => 39,
                'mt_vendor_id' => 6,
                'image_id' => NULL,
                'name' => 'Profile Accessories',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'id' => 40,
                'mt_vendor_id' => 6,
                'image_id' => NULL,
                'name' => 'Floor Elements',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'id' => 41,
                'mt_vendor_id' => 6,
                'image_id' => NULL,
                'name' => 'Panel Installation Elements',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'id' => 42,
                'mt_vendor_id' => 6,
                'image_id' => NULL,
                'name' => 'Door and Window Elements',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'id' => 43,
                'mt_vendor_id' => 6,
                'image_id' => NULL,
                'name' => 'Additional Accessories',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'id' => 44,
                'mt_vendor_id' => 7,
                'image_id' => NULL,
                'name' => 'Material Handling',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'id' => 45,
                'mt_vendor_id' => 7,
                'image_id' => NULL,
                'name' => 'Aerial Work Platform',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'id' => 46,
                'mt_vendor_id' => 7,
                'image_id' => NULL,
                'name' => 'AGV',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'id' => 47,
                'mt_vendor_id' => 8,
                'image_id' => NULL,
                'name' => 'Air Technology',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'id' => 48,
                'mt_vendor_id' => 8,
                'image_id' => NULL,
                'name' => 'IonRinse™',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'id' => 49,
                'mt_vendor_id' => 8,
                'image_id' => NULL,
                'name' => 'IonWash™',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'id' => 50,
                'mt_vendor_id' => 8,
                'image_id' => NULL,
                'name' => 'JetStream',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'id' => 51,
                'mt_vendor_id' => 8,
                'image_id' => NULL,
                'name' => 'Static Control',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'id' => 52,
                'mt_vendor_id' => 8,
                'image_id' => NULL,
                'name' => 'Web Cleaning',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'id' => 53,
                'mt_vendor_id' => 9,
                'image_id' => NULL,
                'name' => 'Polishing Film',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'id' => 54,
                'mt_vendor_id' => 9,
                'image_id' => NULL,
                'name' => 'Fujistar Original Product',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'id' => 55,
                'mt_vendor_id' => 9,
                'image_id' => NULL,
                'name' => 'Whetstone Product',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'id' => 56,
                'mt_vendor_id' => 9,
                'image_id' => NULL,
                'name' => 'Abrasive Cloth Products',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'id' => 57,
                'mt_vendor_id' => 9,
                'image_id' => NULL,
                'name' => 'Abrasive Paper Products',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'id' => 58,
                'mt_vendor_id' => 9,
                'image_id' => NULL,
                'name' => 'Hook And Loop Abrasive Products',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'id' => 59,
                'mt_vendor_id' => 9,
                'image_id' => NULL,
                'name' => 'Other Products',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'id' => 60,
                'mt_vendor_id' => 10,
                'image_id' => NULL,
                'name' => 'Panel Filter',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            56 => 
            array (
                'id' => 61,
                'mt_vendor_id' => 10,
                'image_id' => NULL,
                'name' => 'Pocket Filter',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            57 => 
            array (
                'id' => 62,
                'mt_vendor_id' => 10,
                'image_id' => NULL,
                'name' => 'HEPA Filter',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            58 => 
            array (
                'id' => 63,
                'mt_vendor_id' => 10,
                'image_id' => NULL,
                'name' => 'Activated Carbon Filter',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            59 => 
            array (
                'id' => 64,
                'mt_vendor_id' => 10,
                'image_id' => NULL,
                'name' => 'Compact Filter',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            60 => 
            array (
                'id' => 65,
                'mt_vendor_id' => 10,
                'image_id' => NULL,
                'name' => 'High Temperature Filter',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            61 => 
            array (
                'id' => 66,
                'mt_vendor_id' => 10,
                'image_id' => NULL,
                'name' => 'Paint Collector',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            62 => 
            array (
                'id' => 67,
                'mt_vendor_id' => 10,
                'image_id' => NULL,
                'name' => 'Accessories',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            63 => 
            array (
                'id' => 68,
                'mt_vendor_id' => 11,
                'image_id' => NULL,
                'name' => 'Environmental improvement',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            64 => 
            array (
                'id' => 69,
                'mt_vendor_id' => 11,
                'image_id' => NULL,
                'name' => 'Quality improvement',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            65 => 
            array (
                'id' => 70,
                'mt_vendor_id' => 11,
                'image_id' => NULL,
                'name' => 'Customization',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            66 => 
            array (
                'id' => 71,
                'mt_vendor_id' => 13,
                'image_id' => NULL,
                'name' => 'Welding Products',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            67 => 
            array (
                'id' => 72,
                'mt_vendor_id' => 13,
                'image_id' => NULL,
                'name' => 'Wires',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            68 => 
            array (
                'id' => 73,
                'mt_vendor_id' => 13,
                'image_id' => NULL,
                'name' => 'Metallurgical Components',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            69 => 
            array (
                'id' => 74,
                'mt_vendor_id' => 13,
                'image_id' => NULL,
                'name' => 'Profiles and Specialities',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            70 => 
            array (
                'id' => 75,
                'mt_vendor_id' => 13,
                'image_id' => NULL,
                'name' => 'Others',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            71 => 
            array (
                'id' => 76,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Portable Spot Welding Machine',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            72 => 
            array (
                'id' => 77,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Stationary Spot Welding Machine',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            73 => 
            array (
                'id' => 78,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Multi Head Spot Welding Machine',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            74 => 
            array (
                'id' => 79,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Table Spot Welding Machine',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            75 => 
            array (
                'id' => 80,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Manual Spot Welding Machine',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            76 => 
            array (
                'id' => 81,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Single Side Spot Welding Machine',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            77 => 
            array (
                'id' => 82,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Seam Welding Machine',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            78 => 
            array (
                'id' => 83,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Robotic Spot Welding Gun',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            79 => 
            array (
                'id' => 84,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Diffusion Welding Machine',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            80 => 
            array (
                'id' => 85,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Laser Welder Machine',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            81 => 
            array (
                'id' => 86,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Stud Welding Machine',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            82 => 
            array (
                'id' => 87,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Kickless Cables',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            83 => 
            array (
                'id' => 88,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Nut Feeder Machine',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            84 => 
            array (
                'id' => 89,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Spot Welding Copper Electrodes',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            85 => 
            array (
                'id' => 90,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Industrial Spring Balancer',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            86 => 
            array (
                'id' => 91,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Capacitor Discharge Spot Welding Machine',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            87 => 
            array (
                'id' => 92,
                'mt_vendor_id' => 14,
                'image_id' => NULL,
                'name' => 'Welding Robot',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            88 => 
            array (
                'id' => 93,
                'mt_vendor_id' => 12,
                'image_id' => NULL,
                'name' => 'Finishing, Masking & Satin Finising',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            89 => 
            array (
                'id' => 94,
                'mt_vendor_id' => 12,
                'image_id' => NULL,
                'name' => 'Surface Preparation & Blending',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            90 => 
            array (
                'id' => 95,
                'mt_vendor_id' => 12,
                'image_id' => NULL,
                'name' => 'Cutting, Grinding & Deburring',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            91 => 
            array (
                'id' => 96,
                'mt_vendor_id' => 3,
                'image_id' => NULL,
                'name' => 'Driver Bits',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            92 => 
            array (
                'id' => 97,
                'mt_vendor_id' => 3,
                'image_id' => NULL,
                'name' => 'Impact Sockets',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            93 => 
            array (
                'id' => 98,
                'mt_vendor_id' => 3,
                'image_id' => NULL,
                'name' => 'Accessories',
                'description' => NULL,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}