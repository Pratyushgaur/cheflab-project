<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PaymentTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_table_name')->comment('table name:Vendor,user etc.');
            $table->string('user_id')->comment('vendor_id,user_id etc.');

            $table->string('foreign_id')->default(null)->comment('payment for id exampal:promotion etc.');
            $table->string('foreign_table_name')->comment('payment for promotion,table name:app_promotion_blog_bookings etc.');

            $table->string('r_payment_id')->default(null)->nullable();
            $table->string('bank_transaction_id')->default(null)->nullable();
            $table->string('amount')->default(null)->nullable();
            $table->string('currency')->default(null)->nullable();
            $table->string('status')->default(null)->nullable();
            $table->string('method')->default(null)->nullable();
            $table->text('description')->default(null)->nullable();
            $table->string('amount_refunded')->default(null)->nullable();
            $table->string('refund_status')->default(null)->nullable();
            $table->string('error_code')->default(null)->nullable();
            $table->string('error_description')->default(null)->nullable();
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
        //
    }
}
