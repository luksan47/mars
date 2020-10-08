<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWifiConnections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wifi_connections', function (Blueprint $table) {
            $table->id();
            $table->string('ip', 15);
            $table->string('mac_address', 17);
            $table->string('wifi_username');
            $table->timestamps();
        });

        Schema::table('internet_accesses', function (Blueprint $table) {
            $table->smallInteger('wifi_connection_limit')->default(3);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wifi_connections');
    }
}
