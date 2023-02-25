<?php

use App\UserRoles;
use Illuminate\Database\Seeder;

class UserRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserRoles::insert(
            [
                [
                    'id' => 2,
                    'role_name' => 'Owner'
                ], [
                    'id' => 3,
                    'role_name' => 'Manager'
                ], [
                    'id' => 4,
                    'role_name' => 'Cashier'
                ], [
                    'id' => 5,
                    'role_name' => 'Accountant'
                ]
            ]
        );
    }
}
