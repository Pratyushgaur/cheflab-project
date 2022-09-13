<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LatLong extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            //
            Schema::table('vendors', function (Blueprint $table) {
                $table->float('lat',8,6)->nullable()->after('vendor_food_type');
                $table->float('long',8,6)->nullable()->after('vendor_food_type');
            });
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
            $table->dropColumn(['lat', 'long']);
        });
    }
}
