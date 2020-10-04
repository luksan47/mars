<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMacToRouters extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('routers', function (Blueprint $table) {
            $table->string('port')->nullable();
            $table->string('type')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('mac_5G', 17)->nullable();
            $table->string('mac_2G_LAN', 17)->nullable();
            $table->string('mac_WAN', 17)->nullable();
            $table->string('comment')->nullable();
            $table->date('date_of_acquisition')->nullable();
            $table->date('date_of_deployment')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('routers', function (Blueprint $table) {
            //
        });
    }
}
