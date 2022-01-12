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
        Schema::create('application_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->text('high_school_address')->nullable();
            $table->string('graduation_avarage')->nullable();
            $table->text('semester_avarage')->nullable();
            $table->text('language_exam')->nullable();
            $table->text('competition')->nullable();
            $table->text('publication')->nullable();
            $table->text('foreign_studies')->nullable();
            $table->text('question_1')->nullable();
            $table->text('question_2')->nullable();
            $table->text('question_3')->nullable();
            $table->text('question_4')->nullable();
            $table->timestamps();
        });

        Schema::create('application_files', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_form_id')->constrained();
            $table->string('name');
            $table->string('path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('application_forms');
        Schema::dropIfExists('application_files');
    }
}
