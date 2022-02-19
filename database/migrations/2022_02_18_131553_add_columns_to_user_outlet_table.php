<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToUserOutletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_outlet', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('user');
            $table->foreign('outlet_id')->references('id')->on('outlet');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_outlet', function (Blueprint $table) {
            //
        });
    }
}
