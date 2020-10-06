<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('classrooms', function (Blueprint $table) {
            $table->tinyIncrements('id');
            $table->text('name');
            $table->unsignedInteger('capacity');
            $table->timestamps();
        });

        App\Models\Classroom::insert([[
            'name' => '012',
            'capacity' => 10,
        ], [
            'name' => '013',
            'capacity' => 10,
        ], [
            'name' => '015',
            'capacity' => 10,
        ], [
            'name' => '016',
            'capacity' => 30,
        ], [
            'name' => '018',
            'capacity' => 20,
        ], [
            'name' => '019',
            'capacity' => 30,
        ], [
            'name' => '022',
            'capacity' => 30,
        ], [
            'name' => 'Borzsák könyvtár',
            'capacity' => 15,
        ], [
            'name' => 'Nagyklub',
            'capacity' => 30,
        ],
        ]);

        Schema::create('timetable', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedTinyInteger('classroom_id');
            $table->timestamp('time');
            $table->timestamps();

            $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->foreign('classroom_id')->references('id')->on('classrooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timetable', function (Blueprint $table) {
            $table->dropForeign(['course_id']);
            $table->dropForeign(['classroom_id']);
        });
        Schema::dropIfExists('timetable');
        Schema::dropIfExists('classrooms');
    }
}
