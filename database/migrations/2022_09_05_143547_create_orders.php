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
            $table->string('pdf_url')->nullable();
            $table->string('customer_name');
            $table->text('delivery_address')->comment('this addres also have deliver to customer name');
            $table->text('landmark_address')->comment('landmark address');
            $table->string('mobile_number')->comment('landmark address');
            $table->float('lat', 8, 6);
            $table->float('long', 8, 6);
            $table->string('pincode')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->enum('order_status', ['pending', 'confirmed', 'preparing', 'ready_to_dispatch', 'dispatched', 'cancelled_by_customer_before_confirmed', 'cancelled_by_customer_after_confirmed', 'cancelled_by_customer_during_prepare', 'cancelled_by_customer_after_disptch', 'cancelled_by_vendor', 'completed'])->default('pending');
            $table->float('total_amount', 8, 2)->comment('the whole sum or amount');
            $table->float('gross_amount', 8, 2)->comment('after tax deduction ');
            $table->float('net_amount', 8, 2)->comment('after discount and other deduction, this amount will payed  by customer');
            $table->enum('wallet_apply', ['0', '1'])->default('0')->comment('0= no and 1 =yes');
            $table->float('wallet_cut', 8, 2)->default(0);
            $table->float('discount_amount', 6, 2)->default(0);
            $table->unsignedBigInteger('coupon_id')->nullable()->default(null);
            $table->enum('payment_type', ['COD', 'Online'])->default('COD');
            $table->enum('payment_status', ['paid', 'pending'])->default('pending');
            $table->text('transaction_id')->nullable()->default(null);
            $table->text('payment_string')->nullable()->default(null)->comment('payment gatway return json string');
            $table->text('gateway_response')->nullable()->comment('Gateway all response');
            $table->datetime('preparation_time_from')->nullable()->default(null);
            $table->datetime('preparation_time_to')->nullable()->default(null);
            $table->boolean('is_need_more_time')->default(0)->comment('1=if more preparation time extends');
            $table->boolean('send_cutlery')->default(0)->comment('0=no 1=yes');
            $table->text('chef_message')->nullable()->comment('chef message');
            $table->boolean('avoid_ring_bell')->default(0)->comment('0=false 1= true');
            $table->boolean('leave_at_door')->default(0)->comment('0=false 1= true');
            $table->boolean('avoid_calling')->default(0)->comment('0=false 1= true');
            $table->boolean('direction_to_reach')->default(0)->comment('0=false 1= true');
            $table->text('direction_instruction')->nullable()->comment('Direction instruction by user');
            $table->enum('refund', ['0', '1', '2'])->default('0')->comment('0 no need for refund,1 refund requested, 2 refund DONE');
            $table->float('platform_charges', 8, 2)->comment('platform_charges');
            $table->double('tex')->comment('platform_charges');
            $table->unsignedBigInteger('cancel_by_user')->default(0);
            $table->unsignedBigInteger('accepted_driver_id')->nullable()->comment('Driver id who accepted this order and going to delivery');
            $table->string('deliver_otp')->nullable()->comment('Otp for deliver to user');
            $table->string('pickup_otp')->nullable()->comment('Otp for pickup');
            $table->timestamp('pickup_time')->nullable()->comment('driver order pick up time');
            $table->timestamp('delivered_time')->nullable()->comment('driver order delivered time');
            $table->enum('user_review_done', ["0", "1", "2"])->default('0')->comment('0=pending,1=done review,2reject');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->boolean('delivery_charge')->default(0);
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
