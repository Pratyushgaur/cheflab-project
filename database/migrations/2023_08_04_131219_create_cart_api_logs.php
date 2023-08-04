<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartApiLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cart_api_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('userId')->nullable();
            $table->text('api_request_log')->nullable();
            $table->text('api_response_log')->nullable();

            //$table->foreign('userId')->references('id')->on('users')->onDelete('cascade')->nullable();
            $table->dateTime('created_at')->useCurrent();
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
        Schema::dropIfExists('cart_api_logs');
    }
}
