<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
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
        $j = 0;
        $limit = 3;

        for ($i = 0; $i < 10; $i++) {
            $user_id = DB::table('user')->pluck('id');
            $outlet_id = DB::table('outlets')->pluck('id');
            while ($j < $limit) {
                DB::table('user_outlet')->insert([
                    'user_id' => $j + 1,
                    'outlet_id' => $i + 1,
                ]);
                $j++;
            }
            $limit = ($i + 1) * 3;
        }
    }
}
