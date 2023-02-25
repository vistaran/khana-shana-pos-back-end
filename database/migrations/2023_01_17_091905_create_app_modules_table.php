<?php

use App\AppModules;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_modules', function (Blueprint $table) {
            $table->id();
            $table->string('module_name');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });

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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_modules');
    }
}
