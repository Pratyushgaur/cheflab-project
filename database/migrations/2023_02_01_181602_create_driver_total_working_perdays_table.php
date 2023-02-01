<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDriverTotalWorkingPerdaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_total_working_perdays', function (Blueprint $table) {
            $table->id();
            $table->integer('rider_id')->nullable();
            $table->string('total_hr')->nullable();
            $table->string('current_date')->nullable();
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
        Schema::dropIfExists('driver_total_working_perdays');
    }
}
