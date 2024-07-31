<?php

namespace App\Providers;

use App\Repositories\Abstract\UserRepositoryInterface;
use App\Repositories\Concrete\UserRepository;
use App\Services\Abstract\AuthServiceInterface;
use App\Services\Concrete\AuthService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
    }
}
