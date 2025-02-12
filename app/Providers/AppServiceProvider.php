<?php

namespace App\Providers;

use App\Repositories\Abstract\AddressRepositoryInterface;
use App\Repositories\Abstract\UserRepositoryInterface;
use App\Repositories\Concrete\AddressRepository;
use App\Repositories\Concrete\UserRepository;
use App\Services\Abstract\AuthServiceInterface;
use App\Services\Abstract\PasswordResetServiceInterface;
// use App\Services\Abstract\PasswordResetServiceInterface;
use App\Services\Abstract\UserServiceInterface;
use App\Services\Concrete\AuthService;
use App\Services\Concrete\PasswordResetService;
use App\Services\Concrete\UserService;
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
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
        $this->app->bind(PasswordResetServiceInterface::class, PasswordResetService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {}
}
