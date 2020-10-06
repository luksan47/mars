<?php

use Illuminate\Database\Migrations\Migration;

class AddWorkshop extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('workshops')->insertOrIgnore(['name' => \App\Models\Workshop::GAZDALKODASTUDOMANYI]);
        DB::table('faculties')->insertOrIgnore(['name' => \App\Models\Faculty::GTI]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Nothing to do here
    }
}
