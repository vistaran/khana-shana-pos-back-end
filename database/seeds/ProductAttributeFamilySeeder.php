<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class ProductAttributeFamilySeeder extends Seeder {
    /**
    * Run the database seeds.
    *
    * @return void
    */

    public function run() {
        $faker = Faker::create();
        // $product_id = DB::table( 'product' )->pluck( 'id' );
        $attribute_family_id = DB::table( 'attribute_family' )->pluck( 'id' );
        for ( $i = 0; $i < 50; $i++ ) {
            DB::table( 'product_attribute_family' )->insert( [
                'product_id' => $i + 1 ,
                'attribute_family_id' => $faker->randomElement( $attribute_family_id ),
            ] );
        }
    }
}