<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateHomePageNews extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_page_news', function (Blueprint $table) {
            $table->id();
            $table->longText('text');
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
        DB::table('home_page_news')->insert(['text' => '']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_page_news');
    }
}
