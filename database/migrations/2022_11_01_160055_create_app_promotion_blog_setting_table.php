<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppPromotionBlogSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_promotion_blog_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('app_promotion_blog_id');
            $table->tinyInteger('blog_position');
            $table->string('blog_price');
            $table->string('blog_promotion_date_frame');
            $table->enum('is_active', ['1', '0'])->default('1')->comment('1-active 0-inactive');
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
        Schema::dropIfExists('app_promotion_blog_setting');
    }
}
