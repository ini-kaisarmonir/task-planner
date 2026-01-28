<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('admin-only', fn($user) => $user->isAdmin());
        Gate::define('view-dashboard', fn($user) => $user->isAdmin() || $user->isEmployee());
        Gate::define('manage-tasks', fn($user) => $user->isAdmin() || $user->isEmployee());
        Gate::define('manage-events', fn($user) => $user->isAdmin() || $user->isEmployee());
    }
}
