<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorOrderTimeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_order_time', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->string('day_no',5)->comment('0=sun,1=mon,2=Tue,3=wed,4=thu,5=fri,6=sat');
            $table->string('start_time',50)->nullable();
            $table->string('end_time',50)->nullable();
            $table->string('available',50)->comment('0=not available,1=available')->default('1');

            $table->foreign('vendor_id')->references('id')->on('vendors');
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
        Schema::dropIfExists('vendor_order_time');
    }
}
