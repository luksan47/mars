<?php

namespace App\Http\Controllers;

use App\Models\EventTrigger;
use App\Models\Semester;
use App\Models\User;

class SecretariatController extends Controller
{
    public function list()
    {
        return Semester::current()->activeUsers;
    }

    public static function isStatementAvailable()
    {
        $statement_event = EventTrigger::find(EventTrigger::INTERNET_ACTIVATION_SIGNAL)->date;
        $deadline_event = EventTrigger::find(EventTrigger::DEACTIVATE_STATUS_SIGNAL)->date;
        // If the deadline is closer than sending out the request, that means
        // the request has been already sent out.
        return $deadline_event < $statement_event;
    }

    public static function sendStatementMail()
    {
        //TODO: after #219
    }

    /**
     * Those who did not make their statements by now will be inactive
     * next semester.
     */
    public static function finalizeStatements()
    {
        $users = User::all();
        $next_semester = Semester::next();
        foreach ($users as $user) {
            if (! $user->isInSemester($next_semester)) {
                $user->setStatusFor($next_semester, Semester::INACTIVE, 'Failed to make a statement');
            }
        }
    }
}
