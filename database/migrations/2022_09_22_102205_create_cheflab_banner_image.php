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
        Schema::create('cheflab_banner_image', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('bannerImage');
            $table->tinyInteger('position');
            $table->string('price');
            $table->enum('banner_for', ['cheflab','chef', 'restaurant', 'dineout','order_traking'])->comment('in mobile app where banner should be displayed');
            $table->integer('redirect_vendor_id')->nullable()->comment('this is for menual by admin for redirect to restaurant page in application');
            $table->enum('is_active', ['1', '0'])->default('1')->comment('1-active 0-inactive');
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
        Schema::dropIfExists('cheflab_banner_image');

    }
}
