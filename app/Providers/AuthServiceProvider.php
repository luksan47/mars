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
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // If the before callback returns a non-null result
        // that result will be considered the result of the check.
        // Otherwise (for null) goes through the other gates.
        Gate::before(function ($user, $ability) {
            if ($user->isAdmin()) {
                return true;
            }
        });
        
        Gate::define('print.print', function ($user) {
            return true;
        });
        Gate::define('print.modify', function ($user) {
            return false;
        });
        Gate::define('print.free_pages', function ($user) {
            return false;
        });

    }
}
