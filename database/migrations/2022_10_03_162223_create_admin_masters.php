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
            $table->string('cin_no')->nullable();
            $table->string('fssai_no')->nullable();
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
            $table->string('app_run');
            $table->text('app_close_reason')->nullable()->comment('This message will shown when applicatio closed by admin');
            $table->integer('minimum_order_amount')->default(0);
            $table->string('free_delivery',10)->default("0");
            
            $table->text('goofle_map_key');
            $table->text('razorpay_publish_key');
            $table->text('dine_out_reject_reason');
            $table->string('user_app_current_version', 20);
            $table->string('user_app_force_update', 20);
            $table->string('user_app_soft_update', 20);
            $table->string('ios_user_app_version', 20);
            $table->enum('ios_user_app_force_update', ["0", "1"])->default('0');
            $table->enum('ios_user_app_soft_update', ["0", "1"])->default('1');

            $table->string('driver_app_current_version', 20);
            $table->string('driver_app_force_update', 20);
            $table->string('driver_app_soft_update', 20);
            $table->string('razorpay_key', 255)->nullble();
            $table->string('razorpay_secret_key', 255)->nullble();
            $table->string('cashfree_app_id', 255)->nullble();
            $table->string('cashfree_secret_key', 255)->nullble();
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
