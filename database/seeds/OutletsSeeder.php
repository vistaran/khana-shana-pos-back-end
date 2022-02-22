<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OutletsSeeder extends Seeder
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
            DB::table('outlets')->insert([
                'Outlet_name' => $faker->name,
                'Outlet_Address' => $faker->streetAddress,
                'Country' => $faker->country,
                'State' => $faker->state,
                'City' => $faker->city,
                'Postcode' => str_pad(rand(0, pow(10, 4) - 1), 4, '0', STR_PAD_LEFT),
                'Status' => $faker->randomElement(['active', 'inactive']),
                'inventory_source' => $faker->randomElement(['default']),
            ]);
        }
    }
}
