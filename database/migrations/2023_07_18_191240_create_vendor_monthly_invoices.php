<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorMonthlyInvoices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_monthly_invoices', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->integer('year');
            $table->integer('month');
            $table->string('invoice_number',255)->nullable();
            $table->string('gross_revenue')->default('0');
            $table->string('vendor_commission')->default('0');
            $table->string('commission_gst')->default('0');
            $table->string('convenience_fee')->default('0');
            $table->string('convenience_fee_gst')->default('0');
            $table->string('final_amount')->default('0');
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
        Schema::dropIfExists('vendor_monthly_invoices');
    }
}
