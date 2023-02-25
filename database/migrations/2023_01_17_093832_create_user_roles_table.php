<?php

use App\UserRoles;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('role_name');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        UserRoles::insert(
            [
                [
                    'id' => 1,
                    'role_name' => 'Admin'
                ],
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
    }
}
