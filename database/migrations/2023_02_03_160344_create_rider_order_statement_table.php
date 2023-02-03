<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiderOrderStatementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rider_order_statement', function (Blueprint $table) {
            $table->id();
            $table->string('rider_id');
            $table->string('paid_amount')->default(null)->nullable();;
            $table->float('pay_status')->default('0');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('total_pay_amount');
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
        Schema::dropIfExists('rider_order_statement');
    }
}
