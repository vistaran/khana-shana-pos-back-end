<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id')->nullable();
            $table->foreign('group_id')->references('id')->on('group')->onDelete('cascade');
            $table->string('attribute_based');
            $table->string('attribute_code')->unique();
            $table->string('name');
            $table->string('type');
            $table->string('validation_required');
            $table->string('validation_unique');
            $table->string('input_validation');
            $table->string('value_per_local');
            $table->string('value_per_channel');
            $table->string('use_in_layered');
            $table->string('use_to_create_configuration_product');
            $table->string('visible_on_productview_page_front_end');
            $table->string('create_in_product_flat_table');
            $table->string('attribute_comparable');
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
        Schema::dropIfExists('attribute');
    }
}
