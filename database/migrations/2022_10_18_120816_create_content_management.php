<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContentManagement extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_management', function (Blueprint $table) {
            $table->id();
            $table->text('user_privacy_policy');
            $table->text('vendor_privacy_policy');
            $table->text('deliveryboy_privacy_policy');
            $table->text('terms_conditions_vendor');
            $table->text('terms_conditions_user');
            $table->text('terms_conditions_deliverboy');
            $table->text('refund_cancellation_user');
            $table->text('refund_cancellation_vendor');
            $table->text('refund_cancellation_deliveryboy');
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
        Schema::dropIfExists('content_management');
    }
}
