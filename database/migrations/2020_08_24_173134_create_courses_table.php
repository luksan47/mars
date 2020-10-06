<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('code');
            $table->unsignedTinyInteger('workshop_id');
            $table->text('name');
            $table->text('name_english');
            $table->set('type', \App\Models\Course::TYPES);
            $table->unsignedTinyInteger('credits');
            $table->unsignedTinyInteger('hours');
            $table->unsignedSmallInteger('semester_id');
            $table->unsignedBigInteger('teacher_id');
            $table->timestamps();

            $table->foreign('workshop_id')->references('id')->on('workshops')->onDelete('cascade');
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
            $table->foreign('teacher_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropForeign(['teacher_id']);
            $table->dropForeign(['semester_id']);
            $table->dropForeign(['workshop_id']);
        });
        Schema::dropIfExists('courses');
    }
}
