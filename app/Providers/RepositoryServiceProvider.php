<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Interfaces\UserInviteRepositoryInterface;
use App\Repositories\UserInviteRepository;
use App\Interfaces\MailQueRepositoryInterface;
use App\Repositories\MailQueRepository;

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
        $this->app->bind(UserInviteRepositoryInterface::class, UserInviteRepository::class);
        $this->app->bind(MailQueRepositoryInterface::class, MailQueRepository::class);

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
