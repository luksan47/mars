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
        \App\PrintAccount::class => \App\Policies\PrintAccountPolicy::class,
        \App\FreePages::class => \App\Policies\FreePagesPolicy::class,
        \App\LocalizationContribution::class => \App\Policies\LocalePolicy::class,
        \App\User::class => \App\Policies\UserPolicy::class,
        \App\Checkout::class => \App\Policies\CheckoutPolicy::class,
        \App\Transaction::class => \App\Policies\TransactionPolicy::class,
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
        $this->registerDocumentPolicies();
        $this->registerVerificationPolicies();
        $this->registerPermissionHandlingPolicies();
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
        Gate::define('print.admin', function ($user) {
            return $user->hasRole(Role::PRINT_ADMIN);
        });
    }

    public function registerInternetPolicies()
    {
        Gate::define('internet.internet', function ($user) {
            return $user->hasAnyRole([Role::INTERNET_ADMIN, Role::INTERNET_USER]);
        });
    }

    public function registerDocumentPolicies()
    {
        Gate::define('document.status-certificate.viewAny', function ($user) {
            return $user->hasRole(Role::SECRETARY);
        });
        Gate::define('document.status-certificate', function ($user) {
            return $user->hasRoleBase(Role::COLLEGIST);
        });
        Gate::define('document.register-statement', function ($user) {
            return $user->hasRoleBase(Role::COLLEGIST)
                || $user->hasRole(Role::TENANT);
        });
        Gate::define('document.import-license', function ($user) {
            return $user->hasRoleBase(Role::COLLEGIST)
                || $user->hasRole(Role::TENANT);
        });

        Gate::define('document.any', function ($user) {
            return Gate::any([
                'document.status-certificate.viewAny',
                'document.status-certificate',
                'document.register-statement',
                'document.import-license',
            ]);
        });
    }

    public function registerVerificationPolicies()
    {
        Gate::define('registration.handle', function ($user) {
            return $user->hasAnyRole([Role::INTERNET_ADMIN, Role::SECRETARY, Role::PERMISSION_HANDLER]);
        });
    }

    public function registerPermissionHandlingPolicies()
    {
        Gate::define('permission.handle', function ($user) {
            return  $user->hasRole(Role::PERMISSION_HANDLER);
        });
    }
}
