<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IsAllSettingsDone extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            /// 1. Create new column
            
            $table->boolean('is_all_setting_done')
            ->default(0)
            ->comment('1=when vendor opning time setting and all other essential things done')
            ->after('vendor_food_type');

            $table->boolean('is_online')
            ->default(1)            
            ->after('vendor_food_type');
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
            //
        });
    }
}
