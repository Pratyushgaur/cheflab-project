<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slotbooking_table', function (Blueprint $table) {

            $table->string('booked_for_customer_phone')->after('vendor_id')->comment('contact no of person, table booked for');
            $table->string('booked_for_customer_name')->after('vendor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slotbooking_table', function (Blueprint $table) {
            $table->dropColumn('booked_for_customer_phone');
            $table->dropColumn('booked_for_customer_name');
        });
    }
}
