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
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('user_id');
            $table->string('customer_name');
            $table->text('delivery_address')->comment('this addres also have deliver to customer name');
            $table->enum('order_status',['pending','cancelled_by_customer','cancelled_by_vendor','completed','accept','payment_pending'])->default('pending');
            $table->float('total_amount', 8, 2)->comment('the whole sum or amount');
            $table->float('gross_amount', 8, 2)->comment('after tax deduction ');
            $table->float('net_amount', 8, 2)->comment('after discount and other deduction, this amount will payed  by customer');
            $table->float('discount_amount', 6, 2)->default(0);
            $table->unsignedBigInteger('coupon_id')->nullable()->default(null);
            $table->enum('payment_type',['COD','GPay'])->default('COD');
            $table->enum('payment_status',['paid','pending'])->default('pending');
            $table->text('transaction_id')->nullable()->default(null);
            $table->text('payment_string')->nullable()->default(null)->comment('payment gatway return json string');


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
