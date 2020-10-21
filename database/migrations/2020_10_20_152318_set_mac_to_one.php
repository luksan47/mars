<?php

use App\Models\InternetAccess;
use Illuminate\Database\Migrations\Migration;

class SetMacToOne extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $internet_accesses = InternetAccess::all();
        foreach ($internet_accesses as $internet_access) {
            $internet_access->update([
                'auto_approved_mac_slots' => 1,
            ]);
        }
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
