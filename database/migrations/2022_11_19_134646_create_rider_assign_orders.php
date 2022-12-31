<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiderAssignOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_assign_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('rider_id');
            $table->foreign('rider_id')->references('id')->on('deliver_boy');
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id')->references('id')->on('orders');
            $table->string('distance')->nullable();
            $table->float('earning', 8, 2)->nullable();
            $table->text('cancel_reason')->nullable()->commnet('if driver cancel the order then they put reason');
            $table->enum('action',['0','1','2','3','4','5'])->default('0')->comment('0=pending 1= accept 2= reject by driver , 4=pickup , 3=delivered , 5=cancelled');
            $table->string('otp',10)->nullable()->comment('Pick Up otp');
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
        Schema::dropIfExists('rider_assign_orders');
    }
}
