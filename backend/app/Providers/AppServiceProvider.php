<?php

namespace App\Providers;

use App\Repositories\TelegramIntegrationRepository;
use App\Repositories\TelegramIntegrationRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
        TelegramIntegrationRepositoryInterface::class,
        TelegramIntegrationRepository::class,
    );
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}