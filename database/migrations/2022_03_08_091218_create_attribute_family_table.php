<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeFamilyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //Attribute Family Table
    public function up()
    {
        Schema::create('attribute_family', function (Blueprint $table) {
            $table->id();
            $table->string('attribute_family_code');
            $table->string('attribute_family_name');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_family');
    }
}
