<?php

namespace App\Providers;

use App\Http\Middleware\AuthenticateUser;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AuthenticateUser::class, function () {
            return new AuthenticateUser();
        });
    }
}
