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
            $table->decimal('first_three_km_charge_user', 10,2);
            $table->decimal('first_three_km_charge_admin', 10,2);
            $table->decimal('three_km_to_six_user', 10,2);
            $table->decimal('three_km_to_six_admin', 10,2);
            $table->decimal('six_km_above_user', 10,2);
            $table->decimal('six_km_above_admin', 10,2);
            $table->decimal('extra_charges_admin', 10,2);
            $table->decimal('extra_charges_user', 10,2);
            $table->string('extra_charge_active',10)->default('0');
            
            $table->decimal('fifteen_order_incentive_4', 10,2);
            $table->decimal('fifteen_order_incentive_5', 10,2);
            $table->decimal('sentientfive_order_incentive_4', 10,2);
            $table->decimal('sentientfive_order_incentive_5', 10,2);
            $table->decimal('hundred_order_incentive_4', 10,2);
            $table->decimal('hundred_order_incentive_5', 10,2);
            $table->decimal('no_of_order_cancel', 10,2);
            $table->decimal('below_one_five_km', 10,2);
            $table->decimal('above_one_five_km', 10,2);
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
