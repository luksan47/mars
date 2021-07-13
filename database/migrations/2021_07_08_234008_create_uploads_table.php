<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('applications_id');

            $table->string('file_name');
            $table->string('file_path');

            $table->timestamps();

            $table->foreign('applications_id')->references('id')->on('applications');
            // $table->foreign('id')->references('file_id_profile')->on('applications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uploads', function (Blueprint $table) {
            $table->dropForeign('applications_id');
            // $table->dropForeign('id');
        });
        Schema::dropIfExists('uploads');
    }
}
