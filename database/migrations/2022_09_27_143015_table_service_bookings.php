<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableServiceBookings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_service_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->enum('booking_status', ['pending', 'accepted','rejected'])->default('pending')->comment('this flag for vendor; is vendor accept the booking?');
            $table->integer('booked_no_guest')->default(0);
            $table->dateTime('booked_slot_time_from');
            $table->dateTime('booked_slot_time_to');
            $table->integer('booked_slot_discount')->default(0);
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
        Schema::dropIfExists('table_service_bookings');
    }
}
