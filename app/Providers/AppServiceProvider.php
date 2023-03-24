<?php

namespace App\Providers;

use App\Models\Employee;
use App\Models\Position;
use App\Observers\EmployeeObserver;
use App\Observers\PositionObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Employee::observe(EmployeeObserver::class);
        Position::observe(PositionObserver::class);

    }
}
