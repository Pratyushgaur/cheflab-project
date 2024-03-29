<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserWalletTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->decimal('amount',8,2)->default('0');
            $table->enum('transaction_type',["0","1"])->default('1')->comment('0=cut 1=add');
            $table->text('narration');
            $table->string('transaction_id',255)->nullable();
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
        Schema::dropIfExists('user_wallet_transactions');
    }
}
