<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreareAppPromotionBlogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_promotion_blog', function (Blueprint $table) {
            $table->id();
            $table->enum('vendor_type',['1','2'])->default('1')->comment('1-restaurent 2-chef');
            $table->enum('blog_type',['1','2'])->default('1')->comment('1-vendor 2-product');
            $table->string('name');
            $table->enum('duration', ['1','2'])->default('1')->comment('1-fullday 2-custom');
            $table->time('from')->nullable();
            $table->time('to')->nullable();
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
        Schema::dropIfExists('app_promotion_blog');
    }
}
