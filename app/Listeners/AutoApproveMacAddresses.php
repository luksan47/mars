<?php

namespace App\Listeners;

use App\Models\MacAddress;
use Illuminate\Support\Facades\Log;

class AutoApproveMacAddresses
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
        $user = $event->user;
        $slots_to_approve = $user->internetAccess->auto_approved_mac_slots - $user->macAddresses->where('state', MacAddress::APPROVED)->count();
        $macAddresses = $user->macAddresses
            ->where('state', MacAddress::REQUESTED)
            ->where('id', '!=', $event->macAddress->id)
            ->take($slots_to_approve);
        // Updating one by one to fire events.
        foreach ($macAddresses as $macAddress) {
            $macAddress->state =MacAddress::APPROVED;
            $macAddress->saveQuietly();
            $macAddress->setNextIP();
        }
    }
}
