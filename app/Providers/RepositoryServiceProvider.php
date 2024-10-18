<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;

// ~cb-import-service-repositories~
// ~cb-import-service-interfaces~

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        
        // ~cb-service-provider~
        
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
