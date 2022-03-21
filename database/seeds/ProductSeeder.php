<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
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
            DB::table('product')->insert([
                'sku' => $faker->name,
                'name' => $faker->name,
                'product_type' => $faker->randomElement(['booking', 'simple', 'bundle', 'bundle']),
                'status' => $faker->randomElement(['active', 'deactive']),
                'price' => $faker->randomDigit,
                'quantity' => $faker->randomDigit,
            ]);
        }
    }
}
