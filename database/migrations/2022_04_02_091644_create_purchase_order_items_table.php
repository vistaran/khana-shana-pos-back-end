<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('purchase_order_id');
            $table->string('notes');
            $table->unsignedInteger('item_id');
            $table->string('item_name');
            $table->unsignedInteger('item_group_id');
            $table->string('item_group_name');
            $table->unsignedInteger('qty');
            $table->unsignedInteger('unit_id');
            $table->float('price', 8, 2);
            $table->unsignedInteger('unit_name');
            $table->float('subtotal', 8, 2);
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
        Schema::dropIfExists('purchase_order_items');
    }
}
