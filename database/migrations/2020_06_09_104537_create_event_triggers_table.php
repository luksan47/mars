<?php

use App\EventTrigger;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventTriggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_triggers', function (Blueprint $table) {
            $table->text('name');
            $table->text('data');
            $table->timestamp('date');
            $table->integer('signal');
            $table->text('comment')->nullable();
            
            $table->primary('signal');
        });
        EventTrigger::create([
            'name' => 'internet_valid_until',
            'data' => Carbon::createFromDate(2020, 3, 15, 'Europe/Budapest'),
            'date' => Carbon::createFromDate(2020, 2, 1, 'Europe/Budapest'),
            'signal' => EventTrigger::INTERNET_ACTIVATION_SIGNAL,
            'comment' => 'When the date is reached, activating internet will have new default value',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_triggers');
    }
}
