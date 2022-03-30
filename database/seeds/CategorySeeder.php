<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            DB::table('category')->insert([
                'parent_category_id' => $i + 2,
                'name' => $faker->name,
                'visible_in_menu' => $faker->randomElement(['yes', 'no']),
                'position' => $faker->randomDigit,
                'display_mode' => $faker->randomElement(['Products & Description', 'Products Only', 'Description Only']),
                'decription' => $faker->text(100),
                'image' => $faker->imageUrl($width = 400, $height = 400),
                'category_logo' => $faker->imageUrl($width = 400, $height = 400),
                'attributes' => $faker->randomElement(['price',  'brand']),
                'meta_title' => $faker->title,
                'slug' => $faker->name,
                'meta_description' => $faker->text(100),
                'meta_keyword' => $faker->text(50),
                'status' => $faker->randomElement(['active', 'inactive']),

            ]);
        }
    }
}
