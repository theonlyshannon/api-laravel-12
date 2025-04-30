<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

    /**
     *
     * Import Interface
     */
use App\Interfaces\ExampleRepositoryInterface;
use App\Interfaces\AuthRepositoryInterface;

    /**
     *
     * Import Repository
     */
use App\Repositories\ExampleRepository;
use App\Repositories\AuthRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ExampleRepositoryInterface::class, ExampleRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
