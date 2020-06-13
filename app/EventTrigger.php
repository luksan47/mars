<?php

namespace App;

use App\Http\Controllers\SecretariatController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * This class implements the logic of triggering certain (recurring) events (eg. automatic status changes)
 * when we reach a given datetime. The triggers will fire a signal that we handle accordingly.
 * Members of this models should not get created through the site. It is stored in the database
 * so the dates can be changed on the run, everything else should be static.
 * The handlers of each signal will do one or two things:
 *  - Runs the function/does the changes relvant to the event.
 *  - (only recurring events) Updates the trigger date.
 */
class EventTrigger extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $primaryKey = 'signal';
    protected $fillable = [
        'name', 'data', 'date', 'signal', 'comment',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    // Signal for setting the default activation date to the next semester.
    const INTERNET_ACTIVATION_SIGNAL = 0;
    // Signal for notifying the students to make a statement regarding their status
    // in the next semester.
    const SEND_STATUS_STATEMENT_REQUEST = 1;
    // Deadline for the above signal; when triggered, everyone who did not make a
    // statement will be set to inactive.
    const DEACTIVATE_STATUS_SIGNAL = 2;
    const SIGNALS = [
        self::INTERNET_ACTIVATION_SIGNAL,
        self::SEND_STATUS_STATEMENT_REQUEST,
        self::DEACTIVATE_STATUS_SIGNAL,
    ];

    public static function listen()
    {
        $now = Carbon::now();
        $events = EventTrigger::where('date', '<=', $now)
                              ->where('date', '>', $now->subHours(1));
        foreach ($events as $event) {
            $event->handleSignal();
        }

        return $events;
    }

    /* Getters */

    public static function internetActivationDeadline()
    {
        return self::find(self::INTERNET_ACTIVATION_SIGNAL)->data;
    }

    public static function statementRequestDate()
    {
        return self::find(self::SEND_STATUS_STATEMENT_REQUEST)->date;
    }

    public static function statementDeadline()
    {
        return self::find(self::DEACTIVATE_STATUS_SIGNAL)->date;
    }

    /* Handlers which are fired when the set date is reached. */

    public function handleSignal()
    {
        switch ($this->signal) {
            case self::INTERNET_ACTIVATION_SIGNAL:
                $this->handleInternetActivationSignal();
                break;
            case self::SEND_STATUS_STATEMENT_REQUEST:
                $this->handleSendStatusStatementRequest();
                break;
            case self::DEACTIVATE_STATUS_SIGNAL:
                $this->deactivateStatus();
                break;
            default:
                Log::warning('Event Trigger got undefined signal: '.$this->signal);
                break;
        }

        return $this;
    }

    private function handleInternetActivationSignal()
    {
        $months_to_add = Semester::current()->isSpring() ? 7 : 5;
        $current_date = Carbon::instance($this->date);
        $current_data = Carbon::parse($this->data);
        $this->update([
            // Update the new trigger date
            'date' => $current_date->addMonth($months_to_add),
            // Update the new activation deadline
            'data' => $current_data->addMonth($months_to_add),
        ]);
    }

    private function handleSendStatusStatementRequest()
    {
        $months_to_add = Semester::current()->isSpring() ? 7 : 5;
        $current_date = Carbon::instance($this->date);

        // Triggering the event
        SecretariatController::sendStatementMail();

        $this->update([
            // Update the new trigger date
            'date' => $current_date->addMonth($months_to_add),
        ]);
    }

    private function deactivateStatus()
    {
        $months_to_add = Semester::current()->isSpring() ? 7 : 5;
        $current_date = Carbon::instance($this->date);

        // Triggering the event
        SecretariatController::finalizeStatements();

        $this->update([
            // Update the new trigger date
            'date' => $current_date->addMonth($months_to_add),
        ]);
    }
}
