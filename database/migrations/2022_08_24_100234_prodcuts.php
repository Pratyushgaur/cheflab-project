<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Prodcuts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('users');
            $table->string('product_name');
            $table->string('product_image');
            $table->enum('created_on',['chef_product','cheflab_product'])->comment('1-active 2-inactive 3-delete');
            $table->enum('status', ['1', '0'])->default('1')->comment('1-active 0-inactive');
            $table->dateTime('created_at')->useCurrent();
            $table->ipAddress('created_ip_address')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
