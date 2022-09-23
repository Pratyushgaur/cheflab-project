<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupon_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_Id');
            $table->foreign('user_Id')->references('id')->on('users')->nullable();
            $table->string('coupon_name');
            $table->string('code');
            $table->integer('coupon_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('coupon_history');
    }
}
