<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartProductVariantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_product_variants', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('cart_product_id');
            // $table->foreign('cart_product_id')->references('id')->on('products');

            $table->unsignedBigInteger('variant_id');
            $table->foreign('variant_id')->references('id')->on('variants');


            $table->integer('variant_qty');


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
        Schema::dropIfExists('cart_product_variants');
    }
}
