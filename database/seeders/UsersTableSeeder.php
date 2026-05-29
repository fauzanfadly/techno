<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$7344mcwp7gRphDU/0oehx.McmUdAhEscpcbiohAt4zK0w/drkJux2',
                'remember_token' => NULL,
                'created_at' => '2024-12-21 12:05:51',
                'updated_at' => '2024-12-21 12:05:51',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'FF Xhora',
                'email' => 'xr@mail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$12$AYW.a81JNRC/SE/3vWNCreJHgysDORKKwgsfcrEP8jKNOG4PxziD6',
                'remember_token' => NULL,
                'created_at' => '2024-12-21 12:05:51',
                'updated_at' => '2024-12-21 12:05:51',
            ),
        ));
        
        
    }
}