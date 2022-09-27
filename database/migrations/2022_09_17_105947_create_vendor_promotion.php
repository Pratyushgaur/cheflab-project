<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorPromotion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_promotion_blogs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('app_position',['1','2'])->default(1)->comment('1=restaurant,2=chef');
            $table->enum('blog_type',['1','2'])->default(1)->comment('1=vendor,2=product');
            $table->enum('status', ['1', '0'])->default('1')->comment('1-active  0-inactive');
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
        Schema::dropIfExists('app_promotion_blogs');
    }
}
