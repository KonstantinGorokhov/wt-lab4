<?php

namespace App\Providers;

use App\Models\President;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define("manage-users", function (User $user) {
            return $user->is_admin;
        });

        Gate::define("update-president", function (
            User $user,
            President $president,
        ) {
            return $user->is_admin || $president->user_id === $user->id;
        });

        Gate::define("delete-president", function (
            User $user,
            President $president,
        ) {
            return $user->is_admin || $president->user_id === $user->id;
        });

        Gate::define("restore-president", function (User $user) {
            return $user->is_admin;
        });

        Gate::define("force-delete-president", function (User $user) {
            return $user->is_admin;
        });
    }
}
