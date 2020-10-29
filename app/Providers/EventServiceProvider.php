<?php

namespace App\Providers;

use App\Events\MacAddressDeleted;
use App\Events\MacAddressSaved;
use App\Listeners\AutoApproveMacAddresses;
use App\Listeners\MailGate;
use App\Listeners\UpdatePhysicalIP;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Mail\Events\MessageSending;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MacAddressSaved::class => [
            AutoApproveMacAddresses::class,
            UpdatePhysicalIP::class,
        ],
        MacAddressDeleted::class => [
            AutoApproveMacAddresses::class,
        ],
        MessageSending::class => [
            MailGate::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
