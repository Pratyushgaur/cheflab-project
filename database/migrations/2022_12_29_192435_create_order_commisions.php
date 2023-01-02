<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderCommisions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_commisions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('is_approve');
            $table->unsignedBigInteger('is_cancel');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('order_id');
            $table->string('net_amount');
            $table->string('vendor_commision');
            $table->string('admin_commision');
            $table->string('gross_revenue');
            $table->string('additions');
            $table->string('deductions');
            $table->string('net_receivables');
            $table->string('addition_tax');
            $table->string('convenience_tax');
            $table->string('admin_tax');
            $table->string('tax');
            $table->string('convenience_amount');
            $table->string('tax_amount');
            $table->string('admin_amount');
            $table->string('order_date');
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
        Schema::dropIfExists('order_commisions');
    }
}
