<?php

use Illuminate\Database\Migrations\Migration;

class AddStudentCouncilRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('roles')->insertOrIgnore(['name' => 'student-council']);
        DB::table('roles')->where('name', 'president')->delete();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
