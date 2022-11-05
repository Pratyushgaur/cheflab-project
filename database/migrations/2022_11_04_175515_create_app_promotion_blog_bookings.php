<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppPromotionBlogBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_promotion_blog_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_promotion_blog_id');
            $table->unsignedBigInteger('app_promotion_blog_setting_id');
//            $table->foreign('pp_promotion_blog_id')->references('id')->on('app_promotion_blog');
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors');

            $table->unsignedBigInteger('product_id')->nullable();
//            $table->foreign('product_id')->references('id')->on('products');


            $table->datetime('from_date');
            $table->datetime('to_date');
            $table->time('from_time');
            $table->time('to_time');

            $table->string('image')->nullable();
            $table->enum('is_active', ['1', '2', '0'])->default('0')->comment('1-accept 2-reject 0-pending');
            $table->string('comment_reason');
            $table->string('price');
            $table->enum('payment_status', ['1', '0'])->default('0')->comment('1-Done  0-pending');
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
        Schema::dropIfExists('app_promotion_blog_bookings');
    }
}
