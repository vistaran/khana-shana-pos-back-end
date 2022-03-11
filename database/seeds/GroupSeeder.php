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
        $attribute_family_id = DB::table('attribute_family')->pluck('id');
        for ($i = 0; $i < 6; $i++) {
            DB::table('group')->insert([
                'code' => $faker->randomElement(['brand', 'size', 'color', 'weight', 'depth', 'height', 'width', 'meta_description']),
                'name' => $faker->name,
                'type' => $faker->randomElement(['text', 'textarea', 'price', 'boolean', 'select', 'multiselect', 'datetime', 'date', 'image', 'file']),
                'group_name' => $faker->randomElement(['General', 'Price', 'Description', 'Shipping', 'Meta_description']),
                'family_id' => $faker->randomElement($attribute_family_id),
                'group_based' =>  $faker->randomElement(['System', 'User']),
            ]);
        }
    }
}
