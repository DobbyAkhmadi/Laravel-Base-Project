<?php

namespace App\Providers;

use BaseRepository;
use BaseRepositoryInterface;
use Carbon\Laravel\ServiceProvider;
use EmployeeInterface;
use EmployeeRepository;
use UserInterface;
use UserRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(BaseRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(EmployeeInterface::class, EmployeeRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
