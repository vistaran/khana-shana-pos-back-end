<?php

use App\AppModulePermissions;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppModulePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_module_permissions', function (Blueprint $table) {
            $table->id();
            $table->integer('module_id');
            $table->string('permission_name');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

        AppModulePermissions::insert(
            [
                [
                    'id' => 1,
                    'module_id' => 1,
                    'permission_name' => 'View Item Groups',
                ], [
                    'id' => 2,
                    'module_id' => 1,
                    'permission_name' => 'Manage Item Groups',
                ], [
                    'id' => 3,
                    'module_id' => 1,
                    'permission_name' => 'View Items',
                ], [
                    'id' => 4,
                    'module_id' => 1,
                    'permission_name' => 'Manage Items',
                ],
                [
                    'id' => 5,
                    'module_id' => 1,
                    'permission_name' => 'View Purchases',
                ], [
                    'id' => 6,
                    'module_id' => 1,
                    'permission_name' => 'Manage Purchases',
                ],

                [
                    'id' => 7,
                    'module_id' => 2,
                    'permission_name' => 'View Sales',
                ], [
                    'id' => 8,
                    'module_id' => 2,
                    'permission_name' => 'Manage Sales',
                ], [
                    'id' => 9,
                    'module_id' => 2,
                    'permission_name' => 'View Menu Items',
                ], [
                    'id' => 10,
                    'module_id' => 2,
                    'permission_name' => 'Manage Menu Items',
                ],
                [
                    'id' => 11,
                    'module_id' => 2,
                    'permission_name' => 'View Menu Categories',
                ], [
                    'id' => 12,
                    'module_id' => 2,
                    'permission_name' => 'Manage Menu Categories',
                ],
                [
                    'id' => 13,
                    'module_id' => 2,
                    'permission_name' => 'View Table Management',
                ],
                [
                    'id' => 14,
                    'module_id' => 2,
                    'permission_name' => 'Manage Table Management',
                ],
                [
                    'id' => 15,
                    'module_id' => 3,
                    'permission_name' => 'View Expense by Item Group',
                ], [
                    'id' => 16,
                    'module_id' => 3,
                    'permission_name' => 'View Monthlt Expense',
                ], [
                    'id' => 17,
                    'module_id' => 4,
                    'permission_name' => 'View Users',
                ], [
                    'id' => 18,
                    'module_id' => 4,
                    'permission_name' => 'Manage Users',
                ],
                [
                    'id' => 19,
                    'module_id' => 4,
                    'permission_name' => 'View Vendors',
                ], [
                    'id' => 20,
                    'module_id' => 4,
                    'permission_name' => 'Manage Vendors',
                ],
                [
                    'id' => 21,
                    'module_id' => 4,
                    'permission_name' => 'View UOM',
                ],
                [
                    'id' => 22,
                    'module_id' => 4,
                    'permission_name' => 'Manage UOM',
                ],
                [
                    'id' => 23,
                    'module_id' => 4,
                    'permission_name' => 'View Customers',
                ],
                [
                    'id' => 24,
                    'module_id' => 4,
                    'permission_name' => 'Manage Customers',
                ],
                [
                    'id' => 25,
                    'module_id' => 4,
                    'permission_name' => 'View Staff',
                ],
                [
                    'id' => 26,
                    'module_id' => 4,
                    'permission_name' => 'Manage Staff',
                ],
                [
                    'id' => 27,
                    'module_id' => 5,
                    'permission_name' => 'View Attributes',
                ],
                [
                    'id' => 28,
                    'module_id' => 5,
                    'permission_name' => 'Manage Attributes',
                ],
                [
                    'id' => 29,
                    'module_id' => 5,
                    'permission_name' => 'View Attribute Family',
                ],
                [
                    'id' => 30,
                    'module_id' => 5,
                    'permission_name' => 'Manage Attribute Family',
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
        Schema::dropIfExists('app_module_permissions');
    }
}
