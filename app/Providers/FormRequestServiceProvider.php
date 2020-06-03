<?php

namespace App\Providers;

use App\Package\Domain\Department\RegisterDepartmentRequestInterface;
use Illuminate\Support\ServiceProvider;

class FormRequestServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            \App\Package\Domain\Department\RegisterDepartmentRequestInterface::class,
            \App\Http\Requests\DepartmentInputRequest::class
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
