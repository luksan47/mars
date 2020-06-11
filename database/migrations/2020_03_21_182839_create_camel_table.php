<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCamelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shepherds', function (Blueprint $table) {
            $table->unsignedInteger('id')->unique();
            $table->string('name')->unique();
            $table->integer('camels')->nullable(); //how many camels belongs to shepherd, null if visitor
            $table->integer('min_camels')->nullable(); //minimum number of camels the shepherd should have, null if visitor
        });

        Schema::create('herds', function (Blueprint $table) {
            $table->string('name')->unique();
            $table->integer('camel_count'); //how many camels contained in herd
        });

        Schema::create('shepherding', function (Blueprint $table) {
            //if shepherd finishes with a herd, the camels belongs to it will go back to the farmer
            $table->bigIncrements('id');
            $table->unsignedInteger('shepherd');
            $table->string('herd');
            $table->timestamps();

            $table->foreign('shepherd')
                    ->references('id')->on('shepherds');
            $table->foreign('herd')
                    ->references('name')->on('herds');
        });
        Schema::create('allocate', function (Blueprint $table) {
            //the farmer can allocate camels to shepherds
            $table->unsignedInteger('shepherd');
            $table->integer('camels');
            $table->timestamps();

            $table->foreign('shepherd')
                    ->references('id')->on('shepherds');
        });
        Schema::create('farmer', function (Blueprint $table) {
            $table->string('password');
            $table->integer('def_min_camels');
        });

        DB::table('roles')->insertOrIgnore(['name' => 'camel-breeder']);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shepherds');
        Schema::dropIfExists('herds');
        Schema::dropIfExists('shepherding');
        Schema::dropIfExists('allocate');
        Schema::dropIfExists('farmer');

        DB::table('users')->where('name', '=', 'camel-breeder')->delete();
    }
}
