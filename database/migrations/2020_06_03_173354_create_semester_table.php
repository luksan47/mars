<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSemesterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('semesters', function (Blueprint $table) {
            // Eloquent does not support composite primary keys, so let's just add one there.
            $table->smallIncrements('id');
            $table->unsignedInteger('year');
            $table->set('part', \App\Semester::PARTS);
        });

        Schema::create('semester_status', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedSmallInteger('semester_id');
            $table->set('status', \App\Semester::STATUSES)->default(\App\Semester::ACTIVE);
            $table->text('comment')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('semester_status', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['semester_id']);
        });
        Schema::dropIfExists('semesters');
        Schema::dropIfExists('semester_status');
    }
}
