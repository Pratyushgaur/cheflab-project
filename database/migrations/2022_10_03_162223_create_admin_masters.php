<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminMasters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_masters', function (Blueprint $table) {
            $table->id();
//            $table->text('privacy_policy');
//            $table->text('terms_conditions_vendor');
//            $table->text('terms_conditions_cheflab');
//            $table->text('terms_conditions_deliverboy');
//            $table->text('refund_cancellation_cheflab');
//            $table->text('aboutus');
            $table->string('delivery_charges_fix');
            $table->string('delivery_charges_per_km');
            $table->string('max_cod_amount')->comment('if order more then this then disable COD');
            $table->string('max_preparation_time')->comment('max preparation time');

//            $table->string('company_name');
//            $table->string('logo');
//            $table->string('favicon');
//            $table->text('goofle_map_key');
//            $table->text('razorpay_publish_key');
            $table->softDeletes();
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
        Schema::dropIfExists('admin_masters');
    }
}
