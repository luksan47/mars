<?php

use App\Models\EventTrigger;
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
            $table->text('data')->nullable();
            $table->timestamp('date');
            $table->integer('signal');
            $table->text('comment')->nullable();

            $table->primary('signal');
        });

        Schema::table('semesters', function (Blueprint $table) {
            $table->boolean('verified')->default(false);
        });

        EventTrigger::create([
            'name' => 'internet_valid_until',
            'data' => Carbon::createFromDate(2020, 10, 15, 'Europe/Budapest'),
            'date' => Carbon::createFromDate(2020, 9, 1, 'Europe/Budapest'),
            'signal' => EventTrigger::INTERNET_ACTIVATION_SIGNAL,
            'comment' => 'When the date is reached, activating internet will have new default value',
        ]);

        EventTrigger::create([
            'name' => 'send_status_statement_request',
            'date' => Carbon::createFromDate(2021, 1, 1, 'Europe/Budapest'),
            'signal' => EventTrigger::SEND_STATUS_STATEMENT_REQUEST,
            'comment' => 'The trigger to nofify students about filling out statements regarding their status in the next semester',
        ]);

        EventTrigger::create([
            'name' => 'deactivate_status_signal',
            'date' => Carbon::createFromDate(2021, 1, 15, 'Europe/Budapest'),
            'signal' => EventTrigger::DEACTIVATE_STATUS_SIGNAL,
            'comment' => 'The date when all students who did not make the above statement will lose their status for the next semester',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->dropColumn('verified');
        });
        Schema::dropIfExists('event_triggers');
    }
}
