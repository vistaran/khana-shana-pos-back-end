<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class AttributeFamilyGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $group_id = DB::table('group')->pluck('id');
        $attribute_id = DB::table('attribute')->pluck('id');
        $family_id = DB::Table('attribute_family')->pluck('id');
        // for ($i = 0; $i < 3; $i++) {
        //     for ($j = 0; $j < 3; $j++) {

        // DB::table('attribute_family_group')->insert([
        //     'group_id' => 1,
        //     'attribute_family_id' => 2,
        // ]);
        //     }
        // }

        for ($i = 1; $i < 4; $i++) {
            DB::table('attribute_family_group')->insert([
                'attribute_family_id' => $faker->unique()->randomElement($family_id),
                'group_id' => $faker->randomElement($group_id),
                'attribute_id' => $faker->randomElement($attribute_id),
            ]);
        }
    }
}
