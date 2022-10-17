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
            $table->text('privacy_policy');
            $table->text('terms_conditions_vendor');
            $table->text('terms_conditions_cheflab');
            $table->text('terms_conditions_deliverboy');
            $table->text('refund_cancellation_cheflab');
            $table->text('aboutus');
            $table->string('delivery_charges_fix');
            $table->string('delivery_charges_per_km');
            $table->string('company_name');
            $table->string('logo');
            $table->string('favicon');
            $table->text('goofle_map_key');
            $table->text('razorpay_publish_key');
            $table->text('paytm_publish_key');
            $table->string('order_limit_amout');
            $table->string('default_cooking_time');
            $table->string('default_delivery_time');
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
