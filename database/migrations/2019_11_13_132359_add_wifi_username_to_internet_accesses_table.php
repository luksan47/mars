<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWifiUsernameToInternetAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internet_accesses', function (Blueprint $table) {
            $table->string('wifi_username')->unique()->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internet_accesses', function (Blueprint $table) {
            $table->dropColumn('wifi_username');
        });
    }
}
