<?php

namespace App\Providers;

use App\Role;
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
        \App\MacAddress::class => \App\Policies\MacAddressPolicy::class,
        \App\InternetAccess::class => \App\Policies\InternetAccessPolicy::class,
        \App\PrintJob::class => \App\Policies\PrintJobPolicy::class,
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
        $this->registerVerificationPolicies();
        $this->registerWorkshopPolicies();
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

    public function registerInternetPolicies()
    {
        Gate::define('internet.internet', function ($user) {
            return $user->hasAnyRole([Role::INTERNET_ADMIN, Role::INTERNET_USER]);
        });
    }

    public function registerVerificationPolicies()
    {
        Gate::define('registration.handle', function ($user) {
            return  $user->hasRole(Role::INTERNET_ADMIN);
        });
    }

    // TODO: this is only an example only to show the possibilities of the Role-based permission system
    // DELETEME when workshops are added
    public function registerWorkshopPolicies()
    {
        Gate::define('workshop.access', function ($user, $workshopId) {
            return $user->hasRole(Role::WORKSHOP_ADMINISTRATOR, $workshopId);
        });
    }
}
