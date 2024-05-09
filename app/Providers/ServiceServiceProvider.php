<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\AuthServiceEloquent;
use App\Services\User\UserService;
use App\Services\User\UserServiceEloquent;
use Carbon\Laravel\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(AuthService::class, AuthServiceEloquent::class);
        $this->app->singleton(UserService::class, UserServiceEloquent::class);
    }
}
