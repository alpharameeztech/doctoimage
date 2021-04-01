<?php

namespace App\Providers;

use App\Repositories\Interfaces\DocToPdfInterface;
use App\Repositories\LibreOfficeDocToPdf;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            DocToPdfInterface::class,
            LibreOfficeDocToPdf::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
