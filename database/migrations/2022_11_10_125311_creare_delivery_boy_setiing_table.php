<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreareDeliveryBoySetiingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_boy_setting', function (Blueprint $table) {
            $table->id();
            $table->string('a_to_b_charge');
            $table->string('b_to_c_charge');
            $table->string('fix_charge_1');
            $table->string('fix_charge_2');
            $table->string('incentive_one');
            $table->string('incentive_to');
            $table->softDeletes();
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
        Schema::dropIfExists('delivery_boy_setting');
    }
}
