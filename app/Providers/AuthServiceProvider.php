<?php

namespace App\Providers;

use App\User;
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

        Gate::define('users', function(User $user) {
            return $user->role->menus()->where('route', 'users')->first();
        });

        Gate::define('languages', function(User $user) {
            return $user->role->menus()->where('route', 'languages')->first();
        });

        Gate::define('roles', function (User $user) {
            return $user->role->menus()->where('route', 'roles')->first();
        });

        Gate::define('categories', function(User $user) {
            return $user->role->menus()->where('route', 'categories')->first();
        });

        Gate::define('pages', function(User $user) {
            return $user->role->menus()->where('route', 'pages')->first();
        });

        Gate::define('faqs', function(User $user) {
            return $user->role->menus()->where('route', 'faqs')->first();
        });

        Gate::define('blogs', function(User $user) {
            return $user->role->menus()->where('route', 'blogs')->first();
        });

        Gate::define('features', function (User $user) {
           return $user->role->menus()->where('route', 'features')->first();
        });

        Gate::define('orders', function (User $user) {
           return $user->role->menus()->where('route', 'orders')->first();
        });
    }
}
