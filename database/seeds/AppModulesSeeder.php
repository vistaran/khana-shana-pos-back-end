<?php

use App\AppModules;
use Illuminate\Database\Seeder;

class AppModulesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppModules::insert(
            [
                [
                    'id' => 1,
                    'module_name' => 'Expense'
                ], [
                    'id' => 2,
                    'module_name' => 'Sales'
                ], [
                    'id' => 3,
                    'module_name' => 'Reports'
                ], [
                    'id' => 4,
                    'module_name' => 'System'
                ], [
                    'id' => 5,
                    'module_name' => 'Catalog'
                ]
            ]
        );
    }
}
