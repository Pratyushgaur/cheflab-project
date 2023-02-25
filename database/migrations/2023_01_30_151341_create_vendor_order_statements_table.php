<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorOrderStatementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_order_statements', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_id');
            $table->string('paid_amount')->default(null)->nullable();
            $table->float('pay_status')->default('0');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('vendor_cancel_deduction');
            $table->string('total_pay_amount');
            $table->string('payment_success_date')->nullable();
            $table->string('bank_utr_number')->nullable();
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
        Schema::dropIfExists('vendor_order_statements');
    }
}
