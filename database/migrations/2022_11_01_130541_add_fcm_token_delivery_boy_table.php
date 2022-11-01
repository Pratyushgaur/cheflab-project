<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFcmTokenDeliveryBoyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deliver_boy', function (Blueprint $table) {
            $table->string('fcm_token')->default(null)->after('wallet')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('deliver_boy', 'fcm_token')){
            Schema::table('deliver_boy', function (Blueprint $table) {
                $table->dropColumn('fcm_token');
            });
        }
    }
}
