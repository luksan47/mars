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
            $table->unsignedBigInteger('uploader_id')->nullable();
            $table->string('title');
            $table->string('subtitle')->nullable();
            $table->longtext('description')->nullable();
            $table->string('further_details_url')->nullable();
            $table->string('website_url')->nullable();
            $table->string('facebook_event_url')->nullable();
            $table->string('fill_url')->nullable();
            $table->string('registration_url')->nullable();
            $table->dateTime('registration_deadline')->nullable();
            $table->dateTime('filling_deadline')->nullable();
            $table->dateTime('date')->nullable();
            $table->dateTime('time')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->string('picture_path')->nullable();
            $table->boolean('sent')->default(false);
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
