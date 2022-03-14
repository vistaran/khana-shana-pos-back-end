<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 6; $i++) {
            DB::table('group')->insert([
                'group_name' => $faker->randomElement(['General', 'Price', 'Description', 'Shipping', 'Meta_description']),
                'group_based' =>  $faker->randomElement(['System', 'User']),
            ]);
        }
    }
}
