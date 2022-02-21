<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class UserOutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 50; $i++) {
            $user_id = DB::table('user')->pluck('id');
            $outlet_id = DB::table('outlets')->pluck('id');
            DB::table('user_outlet')->insert([
                'user_id' => $faker->randomElement($user_id),
                'outlet_id' => $faker->randomElement($outlet_id),
            ]);
        }
    }
}
