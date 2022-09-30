<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheflabBannerImage extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
<<<<<<<< HEAD:database/migrations/2022_09_22_102205_create_cheflab_banner_image.php
        Schema::create('cheflab_banner_image', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bannerImage');
            $table->string('position',5);
            $table->enum('is_active', ['1', '0'])->default('1')->comment('1-active 0-inactive');
            $table->softDeletes();
========
        Schema::create('app_promotion_blogs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('app_position',['1','2'])->default(1)->comment('1=restaurant,2=chef');
            $table->enum('blog_type',['1','2'])->default(1)->comment('1=vendor,2=product');
            $table->enum('status', ['1', '0'])->default('1')->comment('1-active  0-inactive');
>>>>>>>> 47d6bf1f58608877197c2398e6d1570ac4f430ef:database/migrations/2022_09_17_105947_create_vendor_promotion.php
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
<<<<<<<< HEAD:database/migrations/2022_09_22_102205_create_cheflab_banner_image.php
        Schema::dropIfExists('cheflab_banner_image');
========
        Schema::dropIfExists('app_promotion_blogs');
>>>>>>>> 47d6bf1f58608877197c2398e6d1570ac4f430ef:database/migrations/2022_09_17_105947_create_vendor_promotion.php
    }
}
