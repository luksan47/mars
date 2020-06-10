<?php

namespace App\Http\Controllers;

use App\Semester;

class SecretariatController extends Controller
{
    public function list()
    {
        return \App\EventTrigger::first()->handleSignal();
        return Semester::current()->activeUsers;
    }

    public static function sendStatementMail()
    {
        //TODO
    }

    public static function finalizeStatements()
    {
        //TODO
    }

}
