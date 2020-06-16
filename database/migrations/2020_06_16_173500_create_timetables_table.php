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
            $table->text('number');
            $table->unsignedInteger('capacity');
            $table->timestamps();
        });

        App\Classroom::insert([[
                'number' => '012',
                'capacity' => 10,
            ],[
                'number' => '013',
                'capacity' => 10,
            ],[
                'number' => '015',
                'capacity' => 10,
            ],[
                'number' => '016',
                'capacity' => 30,
            ],[
                'number' => '018',
                'capacity' => 20,
            ],[
                'number' => 'Borzsák könyvtár',
                'capacity' => 15,
            ],
        ]);

        Schema::create('timetables', function (Blueprint $table) {
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
        Schema::dropIfExists('timetables');
        Schema::dropIfExists('classrooms');
    }
}
