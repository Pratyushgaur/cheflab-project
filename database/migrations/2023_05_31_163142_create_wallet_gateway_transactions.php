<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletGatewayTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_gateway_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('transaction_id',255);
            $table->decimal('amount',8,2)->default('0');
            $table->enum('payment_status',["0","1","2"])->default('0')->comment('0=pending,1=success,2=failed');
            $table->enum('wallet_update',["0","1"])->default('0')->comment('0=pending wallet update user,1=update wallet update user');
            $table->text('gateway_response')->nullable();
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
        Schema::dropIfExists('wallet_gateway_transactions');
    }
}
