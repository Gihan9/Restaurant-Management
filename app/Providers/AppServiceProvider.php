<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ConcessionRepositoryInterface;
use App\Repositories\ConcessionRepository;
use App\Repositories\OrderRepositoryInterface;
use App\Repositories\OrderRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ConcessionRepositoryInterface::class, ConcessionRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}