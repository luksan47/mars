<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MacAddressDeleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $macAddress;
    public $user;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($macAddress)
    {
        $this->macAddress = $macAddress;
        $this->user = $macAddress->user;
    }
}
