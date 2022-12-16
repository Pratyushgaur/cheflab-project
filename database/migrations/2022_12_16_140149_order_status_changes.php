<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class OrderStatusChanges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE orders MODIFY order_status ENUM('pending',
'confirmed',
'preparing',
'ready_to_dispatch',
'dispatched',
'cancelled_by_customer_before_confirmed',
'cancelled_by_customer_after_confirmed',
'cancelled_by_vendor',
'completed')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE orders MODIFY order_status ENUM('pending','preparing','ready_to_dispatch','dispatched','cancelled_by_customer','cancelled_by_vendor','completed','accepted','payment_pending')");
    }
}
