<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SlotbookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('slotbooking_table', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('cheflab_banner_image_id');
            $table->string('vendor_id');
            $table->datetime('from_date');
            $table->datetime('to_date');

            $table->time('from_time');
            $table->time('to_time');

            $table->string('slot_image');
            $table->string('price');
            $table->enum('for', ['chef', 'restaurant', 'dineout'])->comment('in mobile app where banner should be displed');
            $table->enum('is_active', ['1', '2', '0'])->default('0')->comment('1-accept 2-reject 0-pending');
            $table->string('comment_reason');
            $table->enum('payment_status', ['1', '0'])->default('0')->comment('1-Done  0-pending');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
            $table->softDeletes();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('slotbooking_table');
    }
}
