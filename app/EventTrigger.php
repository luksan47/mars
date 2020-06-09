<?php

namespace App;

use App\Semester;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

/**
 * This class implements the logic of triggering certain events (eg. automatic status changes)
 * when we reach a given datetime. The triggers will fire a signal that we handle accordingly.
 * Members of this models should not get created through the site. It is stored in the database
 * so the dates can be changed on the run, everything else should be static.
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

    const INTERNET_ACTIVATION_SIGNAL = 0;
    const SEND_STATUS_STATEMENT_REQUEST = 1;
    const DEACTIVATE_STATUS = 2;
    const SIGNALS = [
        self::INTERNET_ACTIVATION_SIGNAL,
        self::SEND_STATUS_STATEMENT_REQUEST,
        self::DEACTIVATE_STATUS,
    ];

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
            case self::DEACTIVATE_STATUS:
                $this->deactivateStatus();
                break;
            default:        
                Log::warning("Event Trigger got undefined signal: " . $this->signal);
                break;
        }
        return $this;
    }

    private function handleInternetActivationSignal() {
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

    private function handleSendStatusStatementRequest() {

    }
    
    private function deactivateStatus() {

    }
}
