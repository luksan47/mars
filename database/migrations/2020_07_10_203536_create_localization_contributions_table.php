<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateLocalizationContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localization_contributions', function (Blueprint $table) {
            $table->id();
            $table->string('language');
            $table->string('key');
            $table->string('value');
            $table->integer('contributor_id');
            $table->boolean('approved');
            $table->timestamps();
        });

        DB::table('roles')->insertOrIgnore(['name' => 'locale-admin']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('localization_contributions');
        DB::table('roles')->where('name', 'locale-admin')->delete();
    }
}
