<?php

namespace App\Providers;

use App\Models\Applications;
use App\Models\Permissions;
use App\Models\Role;
use App\Models\User;
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
        \App\Models\MacAddress::class => \App\Policies\MacAddressPolicy::class,
        \App\Models\InternetAccess::class => \App\Policies\InternetAccessPolicy::class,
        \App\Models\PrintJob::class => \App\Policies\PrintJobPolicy::class,
        \App\Models\PrintAccount::class => \App\Policies\PrintAccountPolicy::class,
        \App\Models\FreePages::class => \App\Policies\FreePagesPolicy::class,
        \App\Models\LocalizationContribution::class => \App\Policies\LocalePolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Checkout::class => \App\Policies\CheckoutPolicy::class,
        \App\Models\Transaction::class => \App\Policies\TransactionPolicy::class,
        \App\Models\Fault::class => \App\Policies\FaultPolicy::class,
        \App\Models\EpistolaNews::class => \App\Policies\EpistolaPolicy::class,
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
        $this->registerDocumentPolicies();
        $this->registerVerificationPolicies();
        $this->registerPermissionHandlingPolicies();
        $this->registerAdmissionPolicies();
    }

    public function registerDocumentPolicies()
    {
        Gate::define('document.status-certificate.viewAny', function ($user) {
            return $user->hasRole(Role::SECRETARY);
        });
        Gate::define('document.status-certificate', function ($user) {
            return $user->isCollegist() && $user->isActive();
        });
        Gate::define('document.register-statement', function ($user) {
            return $user->isCollegist()
                || $user->hasRole(Role::TENANT);
        });
        Gate::define('document.import-license', function ($user) {
            return $user->isCollegist()
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
            return $user->hasAnyRole([Role::NETWORK_ADMIN, Role::SECRETARY, Role::PERMISSION_HANDLER]);
        });
    }

    public function registerPermissionHandlingPolicies()
    {
        Gate::define('permission.handle', function ($user) {
            return  $user->hasRole(Role::PERMISSION_HANDLER);
        });
    }

    public function registerAdmissionPolicies()
    {
        /**
         * Define Gate for user or admin user role
         * Returns true if user role is set to user or admin.
         **/
        Gate::define('isUserOrAdmin', function ($user) {
            return true; //$user->role == User::ROLE_ADMIN || $user->role == User::ROLE_USER;
        });

        /**
         * Define Gate for admin user role
         * Returns true if user role is set to admin.
         **/
        Gate::define('isAdmin', function ($user) {
            return $user->role == User::ROLE_ADMIN;
        });

        /**
         * Define Gate for user user role
         * Returns true if user role is set to user.
         **/
        Gate::define('isUser', function ($user) {
            return $user->role == User::ROLE_USER;
        });

        /**
         * Define Gate for applicant user role
         * Returns true if user role is set to applicant.
         **/
        Gate::define('isApplicant', function ($user) {
            return $user->role == User::ROLE_APPLICANT;
        });

        Gate::define('hasPermission', function ($user, $permission_code) {
            return 0 < Permissions::where('user_id', $user->id)->where('permission', $permission_code)->count();
        });

        Gate::define('hasApplicationAndFinalised', function ($user) {
            $application = Applications::where('user_id', $user->id)->get(['status']);

            if (count($application) == 0) {
                return false;
            }

            return $application[0]['status'] == Applications::STATUS_FINAL;
        });

        Gate::define('hasApplicationAndUnFinalised', function ($user) {
            $application = Applications::where('user_id', $user->id)->get(['status']);

            if (count($application) == 0) {
                return false;
            }

            return $application[0]['status'] == Applications::STATUS_UNFINAL;
        });
    }
}
