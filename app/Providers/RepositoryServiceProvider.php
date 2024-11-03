<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;

use App\Repositories\UserInviteRepository;
use App\Repositories\MailQueRepository;
use App\Interfaces\UserInviteRepositoryInterface;
use App\Interfaces\MailQueRepositoryInterface;

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
        $this->app->bind(MailQueRepositoryInterface::class, MailQueRepository::class);
        $this->app->bind(UserInviteRepositoryInterface::class, UserInviteRepository::class);

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
