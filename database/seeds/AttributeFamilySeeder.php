<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class AttributeFamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 3; $i++) {
            DB::table('attribute_family')->insert([
                'attribute_family_code' => $faker->randomElement(['default','test']),
                'attribute_family_name' => $faker->randomElement(['default','test'])
            ]);
        }
    }
}
