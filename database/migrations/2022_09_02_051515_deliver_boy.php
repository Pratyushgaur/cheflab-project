<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeliverBoy extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('deliver_boy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->text('address')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('status', ['1', '0'])->default('1')->comment('1-active 0-inactive');
            $table->string('mobile', 20)->unique();
            $table->string('alt_mobile', 20)->nullable();
            $table->string('city');
            $table->string('pincode', 8)->nullable();
            $table->string('identity_image');
            $table->string('identity_number');
            $table->enum('identity_type', ['1', '2', '3'])->default('1')->comment('1-Passport 2-Driving License 3-Aadhar Card');
            $table->string('image')->nullable();
            //
            $table->string('licence_number')->nullable();
            $table->string('licence_image')->nullable();
            $table->string('rc_number')->nullable();
            $table->string('rc_image')->nullable();
            $table->string('insurance_number')->nullable();
            $table->string('insurance_image')->nullable();
            $table->string('pancard_number')->nullable();
            $table->string('pancard_image')->nullable();
            $table->string('aadhar_number')->nullable();
            $table->string('aadhar_image')->nullable();
            $table->string('police_varification_image')->nullable();

            //
            $table->decimal('wallet', 8, 2)->default('0');
            $table->enum('type', ['1', '2', '3'])->default('1')->comment('1-Pure Commission 2-Rent_Commission 3-in_house');
            $table->enum('is_online', ['0', '1'])->default('0')->comment('0=offline 1=online');
            $table->double('lng', 8, 6)->nullable();
            $table->double('lat', 8, 6)->nullable();
            $table->string('time')->nullable();
            $table->string('boy_id')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->float('ratings', 2, 1)->default('0.0');
            $table->date('join_date');
            $table->string('leader_contact_no')->nullable();
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
        Schema::dropIfExists('deliver_boy');
    }
}
