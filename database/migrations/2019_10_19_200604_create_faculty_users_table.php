<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacultyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faculty_users', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedtinyInteger('faculty_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('faculty_users', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['faculty_id']);
        });
        Schema::dropIfExists('faculty_users');
    }
}
