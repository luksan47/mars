<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixWorkshopBalances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workshop_balances', function (Blueprint $table) {
            $table->dropColumn('resident');
            $table->dropColumn('extern');
            $table->dropColumn('not_yet_paid');
        });
        Schema::table('workshop_balances', function (Blueprint $table) {
            $table->integer('resident')->default(0);
            $table->integer('extern')->default(0);
            $table->integer('not_yet_paid')->default(0);
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
    }
}
