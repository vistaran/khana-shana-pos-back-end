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
        $group_user_id = DB::table('group')->where('group_based', 'User')->pluck('id');
        // for ($i = 0; $i < 3; $i++) {
        //     for ($j = 0; $j < 3; $j++) {

                // DB::table('attribute_family_group')->insert([
                //     'group_id' => 1,
                //     'attribute_family_id' => 2,
                // ]);
        //     }
        // }

        for ($i = 0; $i < 3; $i++) {
            DB::table('attribute_family_group')->insert([
                'group_id'
                => $faker->randomElement($group_user_id),
                'attribute_family_id' => $i,
            ]);
        }
    }
}
