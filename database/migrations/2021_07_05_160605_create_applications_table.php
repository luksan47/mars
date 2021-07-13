<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id');

            //$table->boolean('finalised');
            $table->text('status');

            $table->text('inf_name')->nullable();
            $table->date('inf_birthdate')->nullable();
            $table->text('inf_mothers_name')->nullable();
            $table->text('inf_main_email')->nullable();
            $table->text('inf_telephone')->nullable();

            $table->text('address_country')->nullable();
            $table->text('address_city')->nullable();
            $table->text('address_zip')->nullable();
            $table->text('address_street')->nullable();

            $table->text('school_name')->nullable();
            $table->text('school_country')->nullable();
            $table->text('school_city')->nullable();
            $table->text('school_zip')->nullable();
            $table->text('school_street')->nullable();

            $table->text('studies_matura_exam_year')->nullable();
            $table->text('studies_matura_exam_avrage')->nullable();
            $table->text('studies_university_studies_avrages')->nullable();
            $table->text('studies_university_courses')->nullable();

            $table->text('achivements_language_exams')->nullable();
            $table->text('achivements_competitions')->nullable();
            $table->text('achivements_publications')->nullable();
            $table->text('achivements_studies_abroad')->nullable();

            $table->text('question_social')->nullable();
            $table->text('question_why_us')->nullable();
            $table->text('question_plans')->nullable();

            $table->text('misc_status')->nullable();
            $table->text('misc_workshops')->nullable();
            $table->text('misc_neptun')->nullable();
            $table->text('misc_caesar_mail')->nullable();

            $table->text('profile_picture_path')->nullable();
            // $table->json('file_uploads')->nullable();

            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            /*$table->foreign('id')->references('applications_id')->on('uploads');
            $table->foreign('file_id_profile')->references('id')->on('uploads');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign('user_id');
            /*  $table->dropForeign('file_id_profile');
              $table->dropForeign('id');*/
        });
        Schema::dropIfExists('applications');
    }
}
