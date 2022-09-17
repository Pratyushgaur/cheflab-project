<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Products extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('userId');
             $table->foreign('userId')->references('id')->on('vendors')->nullable();
            $table->string('product_name');
            $table->string('product_image')->nullable();
            $table->unsignedBigInteger('cuisines')->references('id')->on('cuisines');
            $table->unsignedBigInteger('category')->references('id')->on('categories');
            $table->unsignedBigInteger('menu_id')->references('id')->on('vendor_menus')->nullable();
            $table->string('dis');
            $table->enum('type',['veg','non_veg','eggs']);
            $table->decimal('product_price', 10,2);
            $table->string('customizable',20);
            // $table->text('variants')->nullable();
            $table->text('addons')->nullable();
            $table->enum('product_for',['1','2','3'])->comment('1-cheflab 2-chef 3-restaurant');
            $table->enum('status', ['1', '0'])->default('1')->comment('1-active 0-inactive');
            $table->dateTime('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();

            //$table->foreign('userId')->references('id')->on('vendors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('products');
    }
}
