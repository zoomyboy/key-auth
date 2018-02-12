<?php

namespace Zoomyboy\KeyAuth;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Facades\Auth;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        Auth::extend('key', function ($app, $name, array $config) {
            return new Guard($this->app['session.store']);
        });

        $this->loadMigrationsFrom(__DIR__.'/migrations');
    }
}
