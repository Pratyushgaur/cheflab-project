<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppPromotionBlogBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_promotion_blog_booking', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_promotion_blog_id');
//            $table->foreign('pp_promotion_blog_id')->references('id')->on('app_promotion_blog');
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->enum('booking_status', ['pending', 'accepted','rejected'])->default('pending')->comment('this flag for vendor; is vendor accept the booking?');

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
        Schema::dropIfExists('app_promotion_blog_booking');
    }
}
