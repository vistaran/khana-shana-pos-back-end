<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('visible_in_menu');
            $table->integer('position');
            $table->string('display_mode');
            $table->string('decription');
            $table->string('image');
            $table->string('category_logo');
            $table->string('parent_category');
            $table->string('attributes');
            $table->string('meta_title');
            $table->string('slug');
            $table->string('meta_description');
            $table->string('meta_keyword');
            $table->string('status');
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
        Schema::dropIfExists('category');
    }
}
