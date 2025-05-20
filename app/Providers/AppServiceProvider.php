<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;
use App\Services\DesafioAutomaticoService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DesafioAutomaticoService::class, function ($app) {
            return new DesafioAutomaticoService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        User::observe(UserObserver::class);
        Paginator::useBootstrap();

        // Forçar HTTPS em ambiente de produção
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
