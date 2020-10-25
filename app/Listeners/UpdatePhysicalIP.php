<?php

namespace App\Listeners;

use App\Models\MacAddress;
use Illuminate\Support\Facades\Log;

class UpdatePhysicalIP
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->macAddress->setNextIp();
    }
}
