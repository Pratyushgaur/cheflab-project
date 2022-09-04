<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeliverBoy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('deliver_boy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('status', ['1', '0'])->default('1')->comment('1-active 0-inactive');
            $table->string('mobile',20)->unique();
            $table->string('pincode',8)->nullable();
            $table->text('address')->nullable();
            $table->string('other_document')->nullable();
            $table->string('other_document_image')->nullable();
            $table->string('image')->nullable();
            $table->decimal('wallet',8,2)->default('0');
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
        //
        Schema::dropIfExists('deliver_boy');
    }
}
