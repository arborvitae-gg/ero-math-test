<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        $this->registerPolicies();

        // Register RolePolicy for User model
        \Illuminate\Support\Facades\Gate::define('hasRole', [\App\Policies\RolePolicy::class, 'hasRole']);
    }
}
