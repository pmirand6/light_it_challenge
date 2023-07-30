<?php

namespace App\Providers;

use App\Repositories\Contracts\PatientRepositoryContract;
use App\Repositories\PatientRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(PatientRepositoryContract::class, PatientRepository::class);
    }
}
