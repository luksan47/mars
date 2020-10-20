<?php

use App\Models\InternetAccess;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SetWifiToTwo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internet_accesses', function (Blueprint $table) {
            $table->smallInteger('wifi_connection_limit')->default(2)->change();
        });

        $internetAccesses = InternetAccess::all();
        foreach ($internetAccesses as $internetAccesses) {
            $internetAccesses->update([
                'wifi_connection_limit' => 2
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
