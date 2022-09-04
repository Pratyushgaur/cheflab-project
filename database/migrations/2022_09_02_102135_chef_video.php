<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChefVideo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('chef_video', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('userId');
            $table->foreign('userId')->references('id')->on('vendors');
            $table->string('title');
            $table->string('sub_title');
            $table->string('link');
            $table->dateTime('created_at')->useCurrent();
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
        Schema::dropIfExists('chef_video');
    }
}
