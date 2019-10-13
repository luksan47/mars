<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\MacAddress::class => MacAddressPolicy::class,
        \App\InternetAccess::class => InternetAccessPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerPrintPolicies();
        $this->registerWorkshopPolicies();

        // If the before callback returns a non-null result
        // that result will be considered the result of the check.
        // Otherwise (for null) goes through the other gates.
        Gate::before(function ($user, $ability) {
            if ($user->isAdmin()) {
                return true;
            }
        });

        Gate::define('internet.internet', function ($user) {
            return $user->inRole(['collegist', 'tenant']);
        });
    }

    public function registerPrintPolicies()
    {
        Gate::define('print.print', function ($user) {
            return $user->inRole(['collegist', 'tenant']);
        });
        Gate::define('print.modify', function ($user) {
            return $user->inRole([]);
        });
        Gate::define('print.free_pages', function ($user) {
            return $user->inRole([]);
        });
    }

    public function registerWorkshopPolicies()
    {
        Gate::define('workshop.access', function ($user, $workshopId) {
            return $workshopId !== null && $user->inRole(['workshop_administrator'], $workshopId);
        });
    }
}
