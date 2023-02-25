<?php

use App\UserRolePermissions;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRolePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_role_permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('role_id');
            $table->integer('module_id');
            $table->integer('permission_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        UserRolePermissions::insert(
            [
                [
                    'id' => 1,
                    'role_id' => 1,
                    'module_id' => 1,
                    'permission_id' => 1,
                ], [
                    'id' => 2,
                    'role_id' => 1,
                    'module_id' => 1,
                    'permission_id' => 2,
                ], [
                    'id' => 3,
                    'role_id' => 1,
                    'module_id' => 1,
                    'permission_id' => 3
                ], [
                    'id' => 4,
                    'role_id' => 1,
                    'module_id' => 1,
                    'permission_id' => 4
                ],
                [
                    'id' => 5,
                    'role_id' => 1,
                    'module_id' => 1,
                    'permission_id' => 5
                ],
                [
                    'id' => 6,
                    'role_id' => 1,
                    'module_id' => 1,
                    'permission_id' => 6
                ],
                [
                    'id' => 7,
                    'role_id' => 1,
                    'module_id' => 2,
                    'permission_id' => 7
                ],

                [
                    'id' => 8,
                    'role_id' => 1,
                    'module_id' => 2,
                    'permission_id' => 8
                ],
                [
                    'id' => 9,
                    'role_id' => 1,
                    'module_id' => 2,
                    'permission_id' => 9
                ],
                [
                    'id' => 10,
                    'role_id' => 1,
                    'module_id' => 2,
                    'permission_id' => 10
                ],
                [
                    'id' => 11,
                    'role_id' => 1,
                    'module_id' => 2,
                    'permission_id' => 11
                ],
                [
                    'id' => 12,
                    'role_id' => 1,
                    'module_id' => 2,
                    'permission_id' => 12
                ],
                [
                    'id' => 13,
                    'role_id' => 1,
                    'module_id' => 2,
                    'permission_id' => 13
                ],
                [
                    'id' => 14,
                    'role_id' => 1,
                    'module_id' => 2,
                    'permission_id' => 14
                ],
                [
                    'id' => 15,
                    'role_id' => 1,
                    'module_id' => 3,
                    'permission_id' => 15
                ],
                [
                    'id' => 16,
                    'role_id' => 1,
                    'module_id' => 3,
                    'permission_id' => 16
                ],
                [
                    'id' => 17,
                    'role_id' => 1,
                    'module_id' => 4,
                    'permission_id' => 17
                ],
                [
                    'id' => 18,
                    'role_id' => 1,
                    'module_id' => 4,
                    'permission_id' => 18
                ],
                [
                    'id' => 19,
                    'role_id' => 1,
                    'module_id' => 4,
                    'permission_id' => 19
                ],
                [
                    'id' => 20,
                    'role_id' => 1,
                    'module_id' => 4,
                    'permission_id' => 20
                ],
                [
                    'id' => 21,
                    'role_id' => 1,
                    'module_id' => 4,
                    'permission_id' => 21
                ],
                [
                    'id' => 22,
                    'role_id' => 1,
                    'module_id' => 4,
                    'permission_id' => 22
                ],
                [
                    'id' => 23,
                    'role_id' => 1,
                    'module_id' => 4,
                    'permission_id' => 23
                ],
                [
                    'id' => 24,
                    'role_id' => 1,
                    'module_id' => 4,
                    'permission_id' => 24
                ],
                [
                    'id' => 25,
                    'role_id' => 1,
                    'module_id' => 4,
                    'permission_id' => 25
                ],
                [
                    'id' => 26,
                    'role_id' => 1,
                    'module_id' => 4,
                    'permission_id' => 26
                ],
                [
                    'id' => 27,
                    'role_id' => 1,
                    'module_id' => 5,
                    'permission_id' => 27
                ],
                [
                    'id' => 28,
                    'role_id' => 1,
                    'module_id' => 5,
                    'permission_id' => 28
                ],
                [
                    'id' => 29,
                    'role_id' => 1,
                    'module_id' => 5,
                    'permission_id' => 29
                ],
                [
                    'id' => 30,
                    'role_id' => 1,
                    'module_id' => 5,
                    'permission_id' => 30
                ],


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
        Schema::dropIfExists('user_role_permissions');
    }
}
