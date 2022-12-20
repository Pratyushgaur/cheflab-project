<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrders extends Migration
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
            $table->string('order_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('user_id');
            $table->string('customer_name');
            $table->text('delivery_address')->comment('this addres also have deliver to customer name');
            $table->text('landmark_address')->comment('landmark address');
            $table->string('mobile_number')->comment('landmark address');
            $table->float('lat',8,6);
            $table->float('long',8,6);
            $table->string('pincode')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->enum('order_status',['pending','confirmed','preparing','ready_to_dispatch','dispatched','cancelled_by_customer_before_confirmed','cancelled_by_customer_after_confirmed','cancelled_by_customer_during_prepare','cancelled_by_customer_after_disptch','cancelled_by_vendor','completed'])->default('pending');
            $table->float('total_amount', 8, 2)->comment('the whole sum or amount');
            $table->float('gross_amount', 8, 2)->comment('after tax deduction ');
            $table->float('net_amount', 8, 2)->comment('after discount and other deduction, this amount will payed  by customer');
            $table->enum('wallet_apply',['0','1'])->default('0')->comment('0= no and 1 =yes');
            $table->float('wallet_cut',8, 2)->default(0);
            $table->float('discount_amount', 6, 2)->default(0);
            $table->unsignedBigInteger('coupon_id')->nullable()->default(null);
            $table->enum('payment_type',['COD','online'])->default('COD');
            $table->enum('payment_status',['paid','pending'])->default('pending');
            $table->text('transaction_id')->nullable()->default(null);
            $table->text('payment_string')->nullable()->default(null)->comment('payment gatway return json string');
            $table->datetime('preparation_time_from')->nullable()->default(null);
            $table->datetime('preparation_time_to')->nullable()->default(null);
            $table->enum('refund',['0','1','2'])->default('0')->comment('0 no need for refund,1 refund requested, 2 refund DONE');

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
        Schema::dropIfExists('orders');
    }
}
