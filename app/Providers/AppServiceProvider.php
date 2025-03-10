<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\IRedMailService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(IRedMailService::class, function ($app) {
            return new IRedMailService();
        });
    }
    
    public function boot(): void
    {
        //
    }
}
