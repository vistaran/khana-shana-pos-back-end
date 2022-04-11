<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductToTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    //Product Table
    public function up()
    {
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('product_name')->nullable();
            $table->text('description')->nullable();
            $table->integer('price')->nullable();
            $table->integer('category_id')->nullable();
            $table->string('category_name')->nullable();

            // optional
            $table->text('attribute_data')->nullable();
            $table->unsignedBigInteger('attribute_family_id')->nullable();
            // $table->foreign('attribute_family_id')->references('id')->on('attribute')->onDelete('cascade');
            $table->unsignedBigInteger('group_id')->nullable();
            // $table->foreign('group_id')->references('id')->on('group')->onDelete('cascade');
            $table->unsignedBigInteger('attribute_id')->nullable();
            // $table->foreign('attribute_id')->references('id')->on('attribute')->onDelete('cascade');
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
        Schema::dropIfExists('product');
    }
}
