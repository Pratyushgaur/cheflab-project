<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePendingPaymentOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pending_payment_orders', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id',255)->nullable();
            $table->text('request_data');
            $table->enum('payment_status',["0","1","2"])->default("0")->comment("0=pending 1=success 2=cancel from gateway 3=not placed order ");
            $table->string('cancel_reason')->nullable();
            $table->enum('order_generated',["0","1","2"])->default("0")->comment('0=pending 1=generated 2=error for generate');
            $table->text('order_generate_error')->nullable();
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
        Schema::dropIfExists('pending_payment_orders');
    }
}
