<?php

namespace App\Providers;

use App\Repositories\TelegramIntegrationRepository;
use App\Repositories\TelegramIntegrationRepositoryInterface;
use App\Repositories\TelegramNotificationRepository;
use App\Repositories\TelegramNotificationRepositoryInterface;
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

    $this->app->bind(
        TelegramNotificationRepositoryInterface::class,
        TelegramNotificationRepository::class,
   
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