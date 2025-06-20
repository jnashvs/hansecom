<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $arrBindings = [
            'App\Repositories\User\UserRepositoryInterface' => 'App\Repositories\User\UserRepository',
            'App\Repositories\Stock\StockRepositoryInterface' => 'App\Repositories\Stock\StockRepository',
        ];

        foreach ($arrBindings as $interface => $module) {
            $this->app->bind($interface, $module);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
