<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            // OutletsSeeder::class,
            // CategorySeeder::class,
            // ProductSeeder::class,
            // UserOutletSeeder::class,
            // CategoryProductSeeder::class,
            // AttributeFamilySeeder::class,
            // GroupSeeder::class,
            // AttributeSeeder::class,
            // AttributeFamilyGroupSeeder::class,
            // ProductAttributeFamilySeeder::class
        ]);
    }
}
