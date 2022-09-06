<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendersTable extends Migration
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
            $table->string('email')->unique();
            $table->string('password');
            $table->enum('vendor_type',['restaurant','chef']);
            $table->string('deal_categories',255);
            $table->enum('status', ['1', '0'])->default('1')->comment('1-active 0-inactive');
            $table->string('mobile',20)->unique();
            $table->string('pincode',8)->nullable();
            $table->text('address')->nullable();
            $table->string('fssai_lic_no')->nullable();
            $table->string('other_document')->nullable();
            $table->string('other_document_image')->nullable();
            $table->string('image')->nullable();
            $table->string('licence_image')->nullable();
            $table->decimal('wallet',8,2)->default('0');
            $table->string('commission',10)->default('0');
            $table->float('vendor_ratings',2,1)->default('0.0');
            $table->intiger('review_count')->default('0');
            $table->enum('vendor_food_type',['1','2','3'])->default('1')->comment('1=veg,2=eggs,3=non veg');
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
        Schema::dropIfExists('vendors');
    }
}
