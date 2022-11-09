<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('payment_mode');
            $table->string('customer_id')->nullable();
            $table->string('notes');
            $table->float('shipping_charge', 6, 2, true);
            $table->string('discount_type')->nullable();
            $table->float('discount_amount', 6, 2, true)->nullable();
            $table->float('total_amount', 10, 2, true);
            $table->dateTime('order_date')->nullable();
            $table->integer('table_number')->default(0);
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
        Schema::dropIfExists('orders');
    }
}
