<?php

namespace App\Providers;

use App\Services\ServiceResponse;
use Illuminate\Support\ServiceProvider;

class ResourceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerResourceMappings();
    }

    /**
     * Register resource mappings for models
     */
    private function registerResourceMappings(): void
    {
        ServiceResponse::registerResourceMap([
            'user' => \App\Http\Resources\UserResource::class,
            'address' => \App\Http\Resources\AddressResource::class,
        ]);
    }
}