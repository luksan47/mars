<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->text('place_of_birth');
            $table->date('date_of_birth');
            $table->text('mothers_name');
            $table->text('phone_number');
            $table->text('country');
            $table->text('county');
            $table->text('zip_code');
            $table->text('city');
            $table->text('street_and_number');
            $table->unsignedInteger('year_of_graduation')->nullable();
            $table->text('high_school')->nullable();
            $table->char('neptun', 6)->nullable();
            $table->unsignedInteger('year_of_acceptance')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('personal_information');
    }
}
