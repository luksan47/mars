<?php

use Illuminate\Database\Migrations\Migration;

class AddPrintPaymentType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('payment_types')->insertOrIgnore(['name' => 'PRINT']);
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
