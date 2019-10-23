<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternetAccessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internet_accesses', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->unique();
            $table->integer('auto_approved_mac_slots')->default(3);
            $table->dateTime('has_internet_until')->nullable();
            $table->string('wifi_password', 64)->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internet_accesses');
    }
}
