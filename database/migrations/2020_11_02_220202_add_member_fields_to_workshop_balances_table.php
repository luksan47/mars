<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMemberFieldsToWorkshopBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('workshop_balances', function (Blueprint $table) {
            $table->integer('resident');
            $table->integer('extern');
            $table->integer('not_yet_paid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('workshop_balances', function (Blueprint $table) {
            $table->dropColumn('resident');
            $table->dropColumn('extern');
            $table->dropColumn('not_yet_paid');
        });
    }
}
