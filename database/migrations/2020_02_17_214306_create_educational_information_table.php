<?php

use App\Models\EducationalInformation;
use App\Models\PersonalInformation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEducationalInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('educational_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('year_of_graduation');
            $table->text('high_school');
            $table->char('neptun', 6);
            $table->unsignedInteger('year_of_acceptance');
            $table->timestamps();
        });
        foreach (PersonalInformation::all() as $info) {
            EducationalInformation::create([
                'user_id' => $info->user_id,
                'year_of_graduation' => $info->year_of_graduation,
                'high_school' => $info->high_school,
                'neptun' => $info->neptun,
                'year_of_acceptance' => $info->year_of_acceptance,
            ]);
        }
        Schema::table('personal_information', function (Blueprint $table) {
            $table->dropColumn('year_of_graduation');
            $table->dropColumn('high_school');
            $table->dropColumn('neptun');
            $table->dropColumn('year_of_acceptance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_information', function (Blueprint $table) {
            $table->unsignedInteger('year_of_graduation')->nullable();
            $table->text('high_school')->nullable();
            $table->char('neptun', 6)->nullable();
            $table->unsignedInteger('year_of_acceptance')->nullable();
        });
        foreach (EducationalInformation::all() as $info) {
            PersonalInformation::where('user_id', $info->user_id)
                ->update([
                    'year_of_graduation' => $info->year_of_graduation,
                    'high_school' => $info->high_school,
                    'neptun' => $info->neptun,
                    'year_of_acceptance' => $info->year_of_acceptance,
                ]);
        }
        Schema::dropIfExists('educational_information');
    }
}
