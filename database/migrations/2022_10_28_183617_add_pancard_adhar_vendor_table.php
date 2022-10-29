<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPancardAdharVendorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->string('aadhar_number')->default(null)->after('bio')->nullable();
            $table->string('aadhar_card_image')->default(null)->after('bio')->nullable();
            $table->string('pancard_number')->default(null)->after('bio')->nullable();
            $table->string('pancard_image')->default(null)->after('bio')->nullable();
//            $table->string('fassi_image')->default(null)->after('fssai_lic_no');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('vendors', function (Blueprint $table) {
            $table->dropColumn('aadhar_number');
            $table->dropColumn('aadhar_card_image');
            $table->dropColumn('pancard_number');
            $table->dropColumn('pancard_image');
            $table->dropColumn('fassi_image');

        });
    }
}
