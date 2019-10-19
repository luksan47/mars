<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Role;

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
        // Model-related policies, registering the contents of $this->policies 
        $this->registerPolicies();
        // General policies without models
        $this->registerPrintPolicies();
        $this->registerInternetPolicies();
        $this->registerWorkshopPolicies();
    }

    public function registerInternetPolicies()
    {
        Gate::define('internet.internet', function ($user) {
            return $user->hasAnyRole([Role::INTERNET_ADMIN, Role::INTERNET_USER]);
        });
    }

    public function registerPrintPolicies()
    {
        Gate::define('print.print', function ($user) {
            return $user->hasAnyRole([Role::PRINT_ADMIN, Role::PRINTER]);
        });
        Gate::define('print.modify', function ($user) {
            return $user->hasRole(Role::PRINT_ADMIN);
        });
        Gate::define('print.modify-free', function ($user) {
            return $user->hasRole(Role::PRINT_ADMIN);
        });
    }

    // TODO: this is only an example only to show the possibilities of the Role-based permission system
    // DELETEME when workshops are added
    public function registerWorkshopPolicies()
    {
        Gate::define('workshop.access', function ($user, $workshopId) {
            return $workshopId !== null && $user->hasRole(Role::WORKSHOP_ADMINISTRATOR, $workshopId);
        });
    }
}
