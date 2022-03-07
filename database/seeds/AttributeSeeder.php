<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class AttributeSeeder extends Seeder
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
            DB::table('attribute')->insert([
                'attribute_code' => $faker->randomElement(['brand,', 'size', 'color', 'weight', 'depth', 'height', 'width', 'meta_description']),
                'type' => $faker->randomElement(['text', 'textarea', 'price', 'boolean', 'select', 'multiselect', 'datetime', 'date', 'image', 'file']),
                'admin' => $faker->name,
                'english' => $faker->name,
                'portuguse' => $faker->name,
                'validation_required' => $faker->randomElement(['yes', 'no']),
                'validation_unique' => $faker->randomElement(['yes', 'no']),
                'input_validation' => $faker->randomElement(['number', 'email', 'decimal', 'url']),
                'value_per_local' => $faker->randomElement(['yes', 'no']),
                'value_per_channel' => $faker->randomElement(['yes', 'no']),
                'use_in_layered' => $faker->randomElement(['yes', 'no']),
                'use_to_create_configuration_product' => $faker->randomElement(['yes', 'no']),
                'visible_on_productview_page_front_end' => $faker->randomElement(['yes', 'no']),
                'create_in_product_flat_table' => $faker->randomElement(['yes', 'no']),
                'attribute_comparable' => $faker->randomElement(['yes', 'no'])
            ]);
        }
    }
}
