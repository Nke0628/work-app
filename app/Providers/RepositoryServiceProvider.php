<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Package\Domain\Repository\WorkDivisionInterface::class,
            \App\Package\Infrastructure\Eloquent\WorkDivisionRepository::class
        );

        $this->app->bind(
            \App\Package\Domain\Repository\DepartmentInterface::class,
            \App\Package\Infrastructure\Eloquent\DepartmentRepository::class
        );

        $this->app->bind(
            \App\Package\Domain\Repository\StaffRepositoryInterface::class,
            \App\Package\Infrastructure\Eloquent\StaffRepository::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
