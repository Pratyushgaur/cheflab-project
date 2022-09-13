<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vendor_id');
            $table->string('image')->nullable();
            $table->string('name');
            $table->string('code');
            $table->enum('discount_type', ['1', '0'])->default('1')->comment('1-percent 0-flat');
            $table->string('discount')->nullable();
            $table->string('maxim_dis_amount')->nullable();
            $table->string('minimum_order_amount')->nullable();
            $table->string('promo_redeem_count')->nullable();
            $table->enum('promocode_use', ['1', '2','3'])->default('1')->comment('1-day 2-week 3-month');
            $table->string('create_by');
            $table->string('coupon_type');
            $table->string('product_id');
            $table->string('from');
            $table->string('to');
            $table->string('discription');
            $table->enum('status', ['1', '0'])->default('1')->comment('1-active 0-inactive');
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
        Schema::dropIfExists('coupons');
    }
}
