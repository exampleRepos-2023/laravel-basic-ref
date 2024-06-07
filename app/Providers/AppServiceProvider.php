<?php

namespace App\Providers;

use Gate;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        Gate::define('admin', function ($user) {
            return $user->isAdmin === 1;
        });

        Paginator::useBootstrapFive();
    }
}
