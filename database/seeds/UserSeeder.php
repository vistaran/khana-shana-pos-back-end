<?php


use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // for ($i = 0; $i < 50; $i++) {
            DB::table('user')->insert([
                'first_name' => 'Khana Shana',
                'lastname' => 'Admin',
                'username' => 'khanashanaadmin',
                'email' => 'admin@khanashana.com',
                'password' => Hash::make('khanashana@123'),
                'confirm_password' => Hash::make('khanashana@123'),
                'user_avatar' => 'user - lg . jpg',
                'status' => 'active'
            ]);
        // }
    }
}
