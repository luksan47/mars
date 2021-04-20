<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditEpistolaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('epistola', function (Blueprint $table) {
            $table->dropColumn('further_details_url');
            $table->dropColumn('website_url');
            $table->dropColumn('facebook_event_url')->nullable();
            $table->dropColumn('fill_url')->nullable();
            $table->dropColumn('registration_url')->nullable();
            $table->dropColumn('registration_deadline')->nullable();
            $table->dropColumn('filling_deadline')->nullable();

            $table->string('details_name_1')->nullable();
            $table->string('details_url_1')->nullable();
            $table->string('details_name_2')->nullable();
            $table->string('details_url_2')->nullable();

            $table->string('deadline_name')->nullable();
            $table->dateTime('deadline_date')->nullable();
        });
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
