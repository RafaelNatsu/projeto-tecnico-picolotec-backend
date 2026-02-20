<?php

namespace App\Providers;

use App\Models\Requisition;
use App\Models\User;
use App\Observers\UserObserver;
use App\Policies\UserRequisitionPolicy;
use Illuminate\Support\Facades\Gate;
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
        Gate::policy(Requisition::class,UserRequisitionPolicy::class);
        User::observe(UserObserver::class);
    }
}
