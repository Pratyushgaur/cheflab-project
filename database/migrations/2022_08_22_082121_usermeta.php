<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Usermeta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usermeta', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->text('value');
            $table->unsignedBigInteger('userId');
            //$table->foreign('userId')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('userId')->references('id')->on('users');
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
        Schema::dropIfExists('usermeta');
    }
}
