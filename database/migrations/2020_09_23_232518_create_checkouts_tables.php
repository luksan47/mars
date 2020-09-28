<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCheckoutsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('checkout_id');
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->unsignedBigInteger('payer_id')->nullable();
            $table->unsignedSmallInteger('semester_id');
            $table->integer('amount');
            $table->string('payment_type_id');
            $table->string('comment')->nullable();
            $table->timestamp('moved_to_checkout')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('password'); //required to move transaction to checkout
        });

        DB::table('checkouts')->insertOrIgnore([
            ['name' => 'ADMIN', 'password' => 'admin'],
            ['name' => 'VALASZTMANY', 'password' => 'valasztmany'],
            //passwords will be changed
            //not encrypted for easier reset
        ]);

        Schema::create('payment_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        DB::table('payment_types')->insertOrIgnore([
            ['name' => 'KKT'], ['name' => 'NETREG'],
            ['name' => 'INCOME'], ['name' => 'EXPENSE'],
            //receipt?
        ]);

        Schema::create('workshop_balances', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('semester_id');
            $table->unsignedSmallInteger('workshop_id');
            $table->integer('allocated_balance')->default(0);
            $table->integer('used_balance')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('balances');
        Schema::dropIfExists('checkouts');
        Schema::dropIfExists('payment_types');
    }
}
