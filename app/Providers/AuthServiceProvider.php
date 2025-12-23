<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\President;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */

    public function boot()
    {
        Gate::define("update-president", function (
            $user,
            President $president,
        ) {
            return $user->id === $president->user_id || $user->is_admin;
        });

        Gate::define("delete-president", function (
            $user,
            President $president,
        ) {
            return $user->id === $president->user_id || $user->is_admin;
        });

        Gate::define("restore-president", function ($user) {
            return $user->is_admin;
        });
    }
}
