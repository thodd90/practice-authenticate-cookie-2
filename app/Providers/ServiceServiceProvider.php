<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\AuthServiceEloquent;
use Carbon\Laravel\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AuthService::class, AuthServiceEloquent::class);
    }
}
