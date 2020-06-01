<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesDominoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games_domino', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('game_id');
            $table->bigInteger('owner');
            $table->bigInteger('state_id');
            $table->enum('update_kind', Domino::STATES);
            $table->integer('position_x')->nullable();
            $table->integer('position_y')->nullable();
            $table->text('value')->nullable();
            $table->timestamps();
        });
        Schema::create('games_domino_players', function (Blueprint $table) {
            $table->bigInteger('game_id');
            $table->bigInteger('player');

            $table->foreign('player')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('game_id')->references('game_id')->on('games_domino')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('games_domino');
        Schema::dropIfExists('games_domino_players');
    }
}
