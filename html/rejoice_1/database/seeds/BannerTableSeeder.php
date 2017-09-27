<?php

use Illuminate\Database\Seeder;

class BannerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         DB::table('re_app_users')->insert([
            'name' => 'guest',
            'email' => 'guest@gmail.com',
            'api_token' => '$2y$10$1JLegarGxx2Wb5pAJX0VQeQimr.tOClF8tA/gbBpYe.MPsJROAXpa',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
