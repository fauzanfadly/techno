<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MtFoldersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('mt_folders')->delete();
        
        \DB::table('mt_folders')->insert(array (
            0 => 
            array (
                'id' => 4,
                'name' => 'Assembling',
                'parent_id' => NULL,
                'path' => 'Assembling',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            1 => 
            array (
                'id' => 5,
                'name' => 'MyTorq',
                'parent_id' => 4,
                'path' => 'Assembling/MyTorq',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            2 => 
            array (
                'id' => 6,
                'name' => 'Built-in Error Proof Screwdriver',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Built-in Error Proof Screwdriver',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            3 => 
            array (
                'id' => 7,
                'name' => 'Power Controller',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Power Controller',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            4 => 
            array (
                'id' => 8,
                'name' => 'Error Proof Counter',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Error Proof Counter',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            5 => 
            array (
                'id' => 9,
                'name' => 'Cordless Screwdriver',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Cordless Screwdriver',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            6 => 
            array (
                'id' => 10,
                'name' => 'Torque Meter',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Torque Meter',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            7 => 
            array (
                'id' => 11,
                'name' => 'Screw Feeder',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Screw Feeder',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            8 => 
            array (
                'id' => 12,
                'name' => 'Auxiliary Arm',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Auxiliary Arm',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            9 => 
            array (
                'id' => 13,
                'name' => 'I/O Signal Control Box',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/I-O Signal Control Box',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            10 => 
            array (
                'id' => 14,
                'name' => 'Slow Start Control Module',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Slow Start Control Module',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            11 => 
            array (
                'id' => 15,
                'name' => 'Accessories',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Accessories',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            12 => 
            array (
                'id' => 16,
                'name' => 'Carbon Brush Screwdrive',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Carbon Brush Screwdrive',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            13 => 
            array (
                'id' => 17,
                'name' => 'Carbon Brush Screwdrive + Error Proof Counter',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Carbon Brush Screwdrive + Error Proof Counter',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            14 => 
            array (
                'id' => 18,
                'name' => 'Industry 4.0 Transducerized Screwdriver',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Industry 4.0 Transducerized Screwdriver',
                'created_at' => '2026-08-30 19:10:31',
                'updated_at' => '2026-08-30 19:10:31',
            ),
            15 => 
            array (
                'id' => 19,
                'name' => 'Industry 4.0 Current Control Screwdriver',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Industry 4.0 Current Control Screwdriver',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            16 => 
            array (
                'id' => 20,
                'name' => 'Automation',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Automation',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            17 => 
            array (
                'id' => 21,
                'name' => 'Torque Readout Screwdriver',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Torque Readout Screwdriver',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            18 => 
            array (
                'id' => 22,
                'name' => 'Brushless Auto Shut off Screwdriver',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/Brushless Auto Shut off Screwdriver',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            19 => 
            array (
                'id' => 23,
                'name' => 'AC Brushless Auto Shut off Screwdriver',
                'parent_id' => 5,
                'path' => 'Assembling/MyTorq/AC Brushless Auto Shut off Screwdriver',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            20 => 
            array (
                'id' => 24,
                'name' => 'OHMI',
                'parent_id' => 4,
                'path' => 'Assembling/OHMI',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            21 => 
            array (
                'id' => 25,
                'name' => 'Driver Bits',
                'parent_id' => 24,
                'path' => 'Assembling/OHMI/Driver Bits',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            22 => 
            array (
                'id' => 26,
                'name' => 'Impact Sockets',
                'parent_id' => 24,
                'path' => 'Assembling/OHMI/Impact Sockets',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            23 => 
            array (
                'id' => 27,
                'name' => 'Accessories',
                'parent_id' => 24,
                'path' => 'Assembling/OHMI/Accessories',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            24 => 
            array (
                'id' => 28,
                'name' => 'Sanyo Machine Works',
                'parent_id' => 4,
                'path' => 'Assembling/Sanyo Machine Works',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            25 => 
            array (
                'id' => 29,
                'name' => 'Nutrunners',
                'parent_id' => 28,
                'path' => 'Assembling/Sanyo Machine Works/Nutrunners',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            26 => 
            array (
                'id' => 30,
                'name' => 'Servo Presses',
                'parent_id' => 28,
                'path' => 'Assembling/Sanyo Machine Works/Servo Presses',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            27 => 
            array (
                'id' => 31,
                'name' => 'Joining Systems',
                'parent_id' => 28,
                'path' => 'Assembling/Sanyo Machine Works/Joining Systems',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            28 => 
            array (
                'id' => 32,
                'name' => 'Smart Factories',
                'parent_id' => 28,
                'path' => 'Assembling/Sanyo Machine Works/Smart Factories',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            29 => 
            array (
                'id' => 33,
                'name' => 'Posilift',
                'parent_id' => 4,
                'path' => 'Assembling/Posilift',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            30 => 
            array (
                'id' => 34,
                'name' => 'Industrial Manipulators',
                'parent_id' => 33,
                'path' => 'Assembling/Posilift/Industrial Manipulators',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            31 => 
            array (
                'id' => 35,
                'name' => 'Rigid Industrial Manipulators',
                'parent_id' => 33,
                'path' => 'Assembling/Posilift/Rigid Industrial Manipulators',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            32 => 
            array (
                'id' => 36,
                'name' => 'Cable Balancing Industrial Manipulators',
                'parent_id' => 33,
                'path' => 'Assembling/Posilift/Cable Balancing Industrial Manipulators',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            33 => 
            array (
                'id' => 37,
                'name' => 'Mobile Industrial Manipulators',
                'parent_id' => 33,
                'path' => 'Assembling/Posilift/Mobile Industrial Manipulators',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            34 => 
            array (
                'id' => 38,
                'name' => 'Air Balancers',
                'parent_id' => 33,
                'path' => 'Assembling/Posilift/Air Balancers',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            35 => 
            array (
                'id' => 39,
                'name' => 'Servo Hoists',
                'parent_id' => 33,
                'path' => 'Assembling/Posilift/Servo Hoists',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            36 => 
            array (
                'id' => 40,
                'name' => 'Aluminium Rail',
                'parent_id' => 33,
                'path' => 'Assembling/Posilift/Aluminium Rail',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            37 => 
            array (
                'id' => 41,
                'name' => 'Steel Rail',
                'parent_id' => 33,
                'path' => 'Assembling/Posilift/Steel Rail',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            38 => 
            array (
                'id' => 42,
                'name' => 'Vertical Lifter',
                'parent_id' => 33,
                'path' => 'Assembling/Posilift/Vertical Lifter',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            39 => 
            array (
                'id' => 43,
                'name' => 'Modular Assembly Technology',
                'parent_id' => 4,
                'path' => 'Assembling/Modular Assembly Technology',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            40 => 
            array (
                'id' => 44,
                'name' => 'Aluminum Profile',
                'parent_id' => 43,
                'path' => 'Assembling/Modular Assembly Technology/Aluminum Profile',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            41 => 
            array (
                'id' => 45,
                'name' => 'Fastening Elements',
                'parent_id' => 43,
                'path' => 'Assembling/Modular Assembly Technology/Fastening Elements',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            42 => 
            array (
                'id' => 46,
                'name' => 'Connecting Elements',
                'parent_id' => 43,
                'path' => 'Assembling/Modular Assembly Technology/Connecting Elements',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            43 => 
            array (
                'id' => 47,
                'name' => 'Profile Accessories',
                'parent_id' => 43,
                'path' => 'Assembling/Modular Assembly Technology/Profile Accessories',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            44 => 
            array (
                'id' => 48,
                'name' => 'Floor Elements',
                'parent_id' => 43,
                'path' => 'Assembling/Modular Assembly Technology/Floor Elements',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            45 => 
            array (
                'id' => 49,
                'name' => 'Panel Installation Elements',
                'parent_id' => 43,
                'path' => 'Assembling/Modular Assembly Technology/Panel Installation Elements',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            46 => 
            array (
                'id' => 50,
                'name' => 'Door and Window Elements',
                'parent_id' => 43,
                'path' => 'Assembling/Modular Assembly Technology/Door and Window Elements',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            47 => 
            array (
                'id' => 51,
                'name' => 'Additional Accessories',
                'parent_id' => 43,
                'path' => 'Assembling/Modular Assembly Technology/Additional Accessories',
                'created_at' => '2026-08-30 19:10:32',
                'updated_at' => '2026-08-30 19:10:32',
            ),
            48 => 
            array (
                'id' => 52,
                'name' => 'Noblift',
                'parent_id' => 4,
                'path' => 'Assembling/Noblift',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            49 => 
            array (
                'id' => 53,
                'name' => 'Material Handling',
                'parent_id' => 52,
                'path' => 'Assembling/Noblift/Material Handling',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            50 => 
            array (
                'id' => 54,
                'name' => 'Aerial Work Platform',
                'parent_id' => 52,
                'path' => 'Assembling/Noblift/Aerial Work Platform',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            51 => 
            array (
                'id' => 55,
                'name' => 'AGV',
                'parent_id' => 52,
                'path' => 'Assembling/Noblift/AGV',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            52 => 
            array (
                'id' => 56,
                'name' => 'Painting',
                'parent_id' => NULL,
                'path' => 'Painting',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            53 => 
            array (
                'id' => 57,
                'name' => 'Wetzel',
                'parent_id' => 56,
                'path' => 'Painting/Wetzel',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            54 => 
            array (
                'id' => 58,
                'name' => 'Panel Filter',
                'parent_id' => 57,
                'path' => 'Painting/Wetzel/Panel Filter',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            55 => 
            array (
                'id' => 59,
                'name' => 'Pocket Filter',
                'parent_id' => 57,
                'path' => 'Painting/Wetzel/Pocket Filter',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            56 => 
            array (
                'id' => 60,
                'name' => 'HEPA Filter',
                'parent_id' => 57,
                'path' => 'Painting/Wetzel/HEPA Filter',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            57 => 
            array (
                'id' => 61,
                'name' => 'Activated Carbon Filter',
                'parent_id' => 57,
                'path' => 'Painting/Wetzel/Activated Carbon Filter',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            58 => 
            array (
                'id' => 62,
                'name' => 'Compact Filter',
                'parent_id' => 57,
                'path' => 'Painting/Wetzel/Compact Filter',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            59 => 
            array (
                'id' => 63,
                'name' => 'High Temperature Filter',
                'parent_id' => 57,
                'path' => 'Painting/Wetzel/High Temperature Filter',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            60 => 
            array (
                'id' => 64,
                'name' => 'Paint Collector',
                'parent_id' => 57,
                'path' => 'Painting/Wetzel/Paint Collector',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            61 => 
            array (
                'id' => 65,
                'name' => 'Accessories',
                'parent_id' => 57,
                'path' => 'Painting/Wetzel/Accessories',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            62 => 
            array (
                'id' => 66,
                'name' => 'Mayteck',
                'parent_id' => 56,
                'path' => 'Painting/Mayteck',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            63 => 
            array (
                'id' => 67,
                'name' => 'Environmental improvement',
                'parent_id' => 66,
                'path' => 'Painting/Mayteck/Environmental improvement',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            64 => 
            array (
                'id' => 68,
                'name' => 'Quality improvement',
                'parent_id' => 66,
                'path' => 'Painting/Mayteck/Quality improvement',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            65 => 
            array (
                'id' => 69,
                'name' => 'Customization',
                'parent_id' => 66,
                'path' => 'Painting/Mayteck/Customization',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            66 => 
            array (
                'id' => 70,
                'name' => 'Bibielle',
                'parent_id' => 56,
                'path' => 'Painting/Bibielle',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            67 => 
            array (
                'id' => 71,
                'name' => 'Finishing, Masking & Satin Finising',
                'parent_id' => 70,
                'path' => 'Painting/Bibielle/Finishing, Masking & Satin Finising',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            68 => 
            array (
                'id' => 72,
                'name' => 'Surface Preparation & Blending',
                'parent_id' => 70,
                'path' => 'Painting/Bibielle/Surface Preparation & Blending',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            69 => 
            array (
                'id' => 73,
                'name' => 'Cutting, Grinding & Deburring',
                'parent_id' => 70,
                'path' => 'Painting/Bibielle/Cutting, Grinding & Deburring',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            70 => 
            array (
                'id' => 74,
                'name' => 'Meech',
                'parent_id' => 56,
                'path' => 'Painting/Meech',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            71 => 
            array (
                'id' => 75,
                'name' => 'Air Technology',
                'parent_id' => 74,
                'path' => 'Painting/Meech/Air Technology',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            72 => 
            array (
                'id' => 76,
                'name' => 'IonRinse™',
                'parent_id' => 74,
                'path' => 'Painting/Meech/IonRinse™',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            73 => 
            array (
                'id' => 77,
                'name' => 'IonWash™',
                'parent_id' => 74,
                'path' => 'Painting/Meech/IonWash™',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            74 => 
            array (
                'id' => 78,
                'name' => 'JetStream',
                'parent_id' => 74,
                'path' => 'Painting/Meech/JetStream',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            75 => 
            array (
                'id' => 79,
                'name' => 'Static Control',
                'parent_id' => 74,
                'path' => 'Painting/Meech/Static Control',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            76 => 
            array (
                'id' => 80,
                'name' => 'Web Cleaning',
                'parent_id' => 74,
                'path' => 'Painting/Meech/Web Cleaning',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            77 => 
            array (
                'id' => 81,
                'name' => 'Sankyo Fuji Star',
                'parent_id' => 56,
                'path' => 'Painting/Sankyo Fuji Star',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            78 => 
            array (
                'id' => 82,
                'name' => 'Polishing Film',
                'parent_id' => 81,
                'path' => 'Painting/Sankyo Fuji Star/Polishing Film',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            79 => 
            array (
                'id' => 83,
                'name' => 'Fujistar Original Product',
                'parent_id' => 81,
                'path' => 'Painting/Sankyo Fuji Star/Fujistar Original Product',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            80 => 
            array (
                'id' => 84,
                'name' => 'Whetstone Product',
                'parent_id' => 81,
                'path' => 'Painting/Sankyo Fuji Star/Whetstone Product',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            81 => 
            array (
                'id' => 85,
                'name' => 'Abrasive Cloth Products',
                'parent_id' => 81,
                'path' => 'Painting/Sankyo Fuji Star/Abrasive Cloth Products',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            82 => 
            array (
                'id' => 86,
                'name' => 'Abrasive Paper Products',
                'parent_id' => 81,
                'path' => 'Painting/Sankyo Fuji Star/Abrasive Paper Products',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            83 => 
            array (
                'id' => 87,
                'name' => 'Hook And Loop Abrasive Products',
                'parent_id' => 81,
                'path' => 'Painting/Sankyo Fuji Star/Hook And Loop Abrasive Products',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            84 => 
            array (
                'id' => 88,
                'name' => 'Other Products',
                'parent_id' => 81,
                'path' => 'Painting/Sankyo Fuji Star/Other Products',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            85 => 
            array (
                'id' => 89,
                'name' => 'Wielding',
                'parent_id' => NULL,
                'path' => 'Wielding',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            86 => 
            array (
                'id' => 90,
                'name' => 'Luvata',
                'parent_id' => 89,
                'path' => 'Wielding/Luvata',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            87 => 
            array (
                'id' => 91,
                'name' => 'Welding Products',
                'parent_id' => 90,
                'path' => 'Wielding/Luvata/Welding Products',
                'created_at' => '2026-08-30 19:10:33',
                'updated_at' => '2026-08-30 19:10:33',
            ),
            88 => 
            array (
                'id' => 92,
                'name' => 'Wires',
                'parent_id' => 90,
                'path' => 'Wielding/Luvata/Wires',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            89 => 
            array (
                'id' => 93,
                'name' => 'Metallurgical Components',
                'parent_id' => 90,
                'path' => 'Wielding/Luvata/Metallurgical Components',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            90 => 
            array (
                'id' => 94,
                'name' => 'Profiles and Specialities',
                'parent_id' => 90,
                'path' => 'Wielding/Luvata/Profiles and Specialities',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            91 => 
            array (
                'id' => 95,
                'name' => 'Others',
                'parent_id' => 90,
                'path' => 'Wielding/Luvata/Others',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            92 => 
            array (
                'id' => 96,
                'name' => 'Xingweihan Welding',
                'parent_id' => 89,
                'path' => 'Wielding/Xingweihan Welding',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            93 => 
            array (
                'id' => 97,
                'name' => 'Portable Spot Welding Machine',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Portable Spot Welding Machine',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            94 => 
            array (
                'id' => 98,
                'name' => 'Stationary Spot Welding Machine',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Stationary Spot Welding Machine',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            95 => 
            array (
                'id' => 99,
                'name' => 'Multi Head Spot Welding Machine',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Multi Head Spot Welding Machine',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            96 => 
            array (
                'id' => 100,
                'name' => 'Table Spot Welding Machine',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Table Spot Welding Machine',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            97 => 
            array (
                'id' => 101,
                'name' => 'Manual Spot Welding Machine',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Manual Spot Welding Machine',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            98 => 
            array (
                'id' => 102,
                'name' => 'Single Side Spot Welding Machine',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Single Side Spot Welding Machine',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            99 => 
            array (
                'id' => 103,
                'name' => 'Seam Welding Machine',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Seam Welding Machine',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            100 => 
            array (
                'id' => 104,
                'name' => 'Robotic Spot Welding Gun',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Robotic Spot Welding Gun',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            101 => 
            array (
                'id' => 105,
                'name' => 'Diffusion Welding Machine',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Diffusion Welding Machine',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            102 => 
            array (
                'id' => 106,
                'name' => 'Laser Welder Machine',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Laser Welder Machine',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            103 => 
            array (
                'id' => 107,
                'name' => 'Stud Welding Machine',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Stud Welding Machine',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            104 => 
            array (
                'id' => 108,
                'name' => 'Kickless Cables',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Kickless Cables',
                'created_at' => '2026-08-30 19:10:34',
                'updated_at' => '2026-08-30 19:10:34',
            ),
            105 => 
            array (
                'id' => 109,
                'name' => 'Nut Feeder Machine',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Nut Feeder Machine',
                'created_at' => '2026-08-30 19:10:35',
                'updated_at' => '2026-08-30 19:10:35',
            ),
            106 => 
            array (
                'id' => 110,
                'name' => 'Spot Welding Copper Electrodes',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Spot Welding Copper Electrodes',
                'created_at' => '2026-08-30 19:10:35',
                'updated_at' => '2026-08-30 19:10:35',
            ),
            107 => 
            array (
                'id' => 111,
                'name' => 'Industrial Spring Balancer',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Industrial Spring Balancer',
                'created_at' => '2026-08-30 19:10:35',
                'updated_at' => '2026-08-30 19:10:35',
            ),
            108 => 
            array (
                'id' => 112,
                'name' => 'Capacitor Discharge Spot Welding Machine',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Capacitor Discharge Spot Welding Machine',
                'created_at' => '2026-08-30 19:10:35',
                'updated_at' => '2026-08-30 19:10:35',
            ),
            109 => 
            array (
                'id' => 113,
                'name' => 'Welding Robot',
                'parent_id' => 96,
                'path' => 'Wielding/Xingweihan Welding/Welding Robot',
                'created_at' => '2026-08-30 19:10:35',
                'updated_at' => '2026-08-30 19:10:35',
            ),
            110 => 
            array (
                'id' => 114,
                'name' => 'Assets Lama',
                'parent_id' => NULL,
                'path' => 'Assets Lama',
                'created_at' => '2026-08-30 19:10:42',
                'updated_at' => '2026-08-30 19:10:42',
            ),
        ));
        
        
    }
}