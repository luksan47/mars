<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpistola extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epistola', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->longtext('description')->nullable(); //main text
            $table->string('further_details')->nullable();
            $table->string('website')->nullable();
            $table->string('facebook_event')->nullable();
            $table->string('registration')->nullable();
            $table->dateTime('registration_deadline')->nullable();
            $table->dateTime('filling_deadline')->nullable();
            $table->dateTime('date')->nullable();
            $table->dateTime('end_date')->nullable(); //time interval if both provided
            $table->string('picture')->nullable(); //path to main picture
            $table->dateTime('valid_until'); //notifications should be sent before this date
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('epistola');
    }
}
