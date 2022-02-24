<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CategoryProductSeeder extends Seeder
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
            $category_id = DB::table('category')->pluck('id');
            $product_id = DB::table('product')->pluck('id');
            DB::table('category_product')->insert([
                'category_id' => $faker->randomElement($category_id),
                'product_id' => $faker->randomElement($product_id),
            ]);
        }
    }
}
