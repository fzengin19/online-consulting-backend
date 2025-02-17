<?php

namespace App\Providers;

use App\Repositories\Abstract\{
    AddressRepositoryInterface,
    UserAddressRepositoryInterface,
    UserRepositoryInterface
};
use App\Repositories\Concrete\{
    AddressRepository,
    UserAddressRepository,
    UserRepository
};
use App\Services\Abstract\{
    AuthServiceInterface,
    PasswordResetServiceInterface,
    UserServiceInterface
};
use App\Services\Concrete\{
    AuthService,
    PasswordResetService,
    UserService
};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * All of the container bindings that should be registered.
     */
    public $bindings = [
        // Repository Bindings
        UserRepositoryInterface::class => UserRepository::class,
        AddressRepositoryInterface::class => AddressRepository::class,
        UserAddressRepositoryInterface::class => UserAddressRepository::class,

        // Service Bindings
        AuthServiceInterface::class => AuthService::class,
        UserServiceInterface::class => UserService::class,
        PasswordResetServiceInterface::class => PasswordResetService::class,
    ];

    public function boot(): void
    {
        //
    }
}
