<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAddon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('order_product_addons', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('addon_id');
            $table->unsignedBigInteger('order_product_id');
            $table->string('addon_name');
            $table->float('addon_price', 8, 2);
            $table->integer('addon_qty');
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
        Schema::dropIfExists('order_product_addons');
    }
}
