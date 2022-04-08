<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeFamilyGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //AttributeFamily Group Table
    public function up()
    {
        Schema::create('attribute_family_group', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('attribute_family_id')->nullable();
            $table->foreign('attribute_family_id')->references('id')->on('attribute')->onDelete('cascade');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('group_id')->references('id')->on('group')->onDelete('cascade');
            $table->unsignedBigInteger('attribute_id')->nullable();
            $table->foreign('attribute_id')->references('id')->on('attribute')->onDelete('cascade');
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
        Schema::dropIfExists('attribute_family_group');
    }
}
