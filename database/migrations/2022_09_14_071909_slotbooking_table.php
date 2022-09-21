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
            $table->bigIncrements('slot_id');
            $table->unsignedBigInteger('id')->nullable();
            //$table->foreign('id')->references('id')->on('slot')->nullable();
            $table->string('vendor_id');
            $table->string('date');
            $table->string('slot_image');
            $table->string('price');
            $table->string('id');
            $table->string('banner');
            $table->enum('slot_status', ['1', '2', '0'])->default('0')->comment('1-accept 2-reject 0-pending');
            $table->enum('is_active', ['1', '2', '0'])->default('0')->comment('1-accept 2-reject 0-pending');
            $table->string('comment_rejoin');
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
