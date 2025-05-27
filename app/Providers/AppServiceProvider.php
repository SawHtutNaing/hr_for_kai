<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

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
        Gate::define('manage-hr', function (User $user) {
            return $user->role->name === 'HR';
        });

        // Employee access to check-in/check-out and leave requests
        Gate::define('manage-employee', function (User $user) {
            return $user->role->name === 'Employee';
        });

        // View own payroll and attendance
        Gate::define('view-own-data', function (User $user, $model) {
            return $user->id === $model->user_id;
        });

    }
}
