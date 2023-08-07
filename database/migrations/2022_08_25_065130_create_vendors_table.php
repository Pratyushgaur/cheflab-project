<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('owner_name')->nullable();
            $table->string('manager_name')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->date('dob')->nullable();
            $table->string('experience')->nullable();
            $table->date('career_starting_date')->nullable();
            
            $table->boolean('is_online')->default(1);
            $table->enum('vendor_type',['restaurant','chef']);
            $table->string('deal_categories',255);
            $table->string('deal_cuisines',255)->nullable();
            $table->enum('status', ['1', '0'])->default('1')->comment('1-active 0-inactive');
            $table->string('mobile',20);
            $table->string('alt_mobile',20)->nullable();
            $table->string('pincode',8)->nullable();
            $table->text('address')->nullable();
            $table->string('fssai_lic_no')->nullable();
            $table->enum('gst_available', ['0', '1'])->default('0')->comment('0-no 1-yes');
            $table->string('gst_no',15)->nullable();
            $table->string('tax');
            $table->string('other_document')->nullable();
            $table->string('other_document_image')->nullable();
            $table->string('image')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('speciality')->nullable();
            $table->string('licence_image')->nullable();
            $table->decimal('wallet',8,2)->default('0');
            $table->string('commission',10)->default('0');
            $table->float('vendor_ratings',2,1)->default('0.0');
            $table->integer('review_count')->default('0');
            $table->enum('vendor_food_type',['1','2','3'])->default('1')->comment('1=veg,2=eggs,3=non veg');
            $table->double('long',8,6)->nullable();
            $table->double('lat',8,6)->nullable();
            $table->enum('table_service',['1','0'])->default('0')->comment('1-active 0-inactive');
            $table->boolean('is_all_setting_done')->default(0)->comment('1=when vendor opning time setting and all other essential things done');
            $table->text('bio')->nullable();
            $table->boolean('is_auto_send_for_prepare')->default(0)->comment('1=automatically order goes for prepare status ');
            $table->integer('auto_accept_prepration_time')->default(0)->comment('auto accepted prepration time which define in create order');
            $table->string('password_change_otp')->nullable();
            $table->decimal('platform_fee',8,2)->unsigned()->default(0.0);
            $table->string('free_delivery',10)->default("0");
            $table->decimal('fee_delivery_minimum_amount',8,2)->unsigned()->default(0.0)->comment('Free delivery  minimum order amount');
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
//        Schema::dropIfExists('vendors');
    }
}
