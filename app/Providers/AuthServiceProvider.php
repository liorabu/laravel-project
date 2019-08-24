<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        Gate::define('owner', function ($user) {
            return $user->role == 'owner';
        });
        Gate::define('admin', function ($user) {
            return $user->role == 'admin';
        });
        Gate::define('invitor', function ($user) {
            return $user->role == 'invitor';
        });
        Gate::define('participator', function ($user) {
            return $user->role == 'participator';
        });
    }
}
