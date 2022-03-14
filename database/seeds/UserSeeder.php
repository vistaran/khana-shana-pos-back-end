<?php


use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 11; $i++) {
            DB::table('user')->insert([
                'first_name' => $faker->firstName,
                'lastname' => $faker->lastName,
                'username' => $faker->username,
                'email' => $faker->email,
                'password' => bcrypt('secret'),
                'confirm_password' => bcrypt('secret'),
                'outlet_name' => $faker->name,
                'outlet_status' => $faker->randomElement(['active', 'inactive']),
                'phone_no' => $faker->phoneNumber,
                'user_avatar' => 'user - lg . jpg',
                'status' => $faker->randomElement(['active', 'inactive']),
            ]);
        }
    }
}