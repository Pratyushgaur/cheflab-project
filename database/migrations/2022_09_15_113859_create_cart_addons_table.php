<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_product_addons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cart_product_id');
            // $table->foreign('cart_product_id')->references('id')->on('products');


            $table->unsignedBigInteger('addon_id');
            $table->foreign('addon_id')->references('id')->on('addons');

            // $table->unsignedBigInteger('cart_id');
            // $table->foreign('cart_id')->references('id')->on('carts');



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
        Schema::dropIfExists('cart_product_addons');
    }
}
